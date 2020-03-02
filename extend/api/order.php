<?php
	/*
	* File：订单查询
	* Author：易如意
	* QQ：51154393
	* Url：www.eruyi.cn
	*/
	if(!isset($app_res) or !is_array($app_res))out(100);//如果需要调用应用配置请先判断是否加载app配置
	
	$oin = isset($data_arr['oin']) && !empty($data_arr['oin']) ? purge($data_arr['oin']) : out(140,$app_res);//订单信息，可以是订单号也可以是用户账号
	
	$order = Db::table('goods_order','as O')->field('O.*,U.user,G.appid,G.type,G.amount')->JOIN("goods","as G",'O.gid=G.id')->JOIN("user",'as U','O.Uid=U.id');
	$order_res = $order->where(['G.appid'=>$appid],'(',')')->where('(O.order',$oin)->whereOr(['U.user'=>$oin],')')->order('id desc')->select();//false
	$ret = [];
	if(is_array($order_res)){
		foreach ($order_res as $k => $v){$rows = $order_res[$k];
			$ret[] = [
				'order' => $rows['order'],
				'gname' => $rows['name'],
				'gmoney' => $rows['money'],
				'gtype' => $rows['type'],
				'obtain' => $rows['amount'],
				'otime' => $rows['o_time'],
				'ptime' => $rows['p_time'],
				'ptype' => $rows['p_type'],
				'state' => $rows['state']
			];
		}
		out(200,$ret,$app_res);
	}out(201,'订单查询失败',$app_res);
	
	
	
?>