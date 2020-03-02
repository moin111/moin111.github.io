<?php
	/*
	* File：获取商品
	* Author：易如意
	* QQ：51154393
	* Url：www.eruyi.cn
	*/
	if(!isset($app_res) or !is_array($app_res))out(100);//如果需要调用应用配置请先判断是否加载app配置
	$ret = [];
	$goods_res = Db::table('goods')->where('appid',$appid)->select();//获取扩展配置
	if(is_array($goods_res)){
		foreach ($goods_res as $k => $v){$rows = $goods_res[$k];
			if($rows['state'] == 'y'){
				$ret[] = [
					'gid' => $rows['id'],
					'gname' => $rows['name'],
					'gmoney' => $rows['money'],
					'gtype' => $rows['type'],
					'obtain' => $rows['amount'],
					'cv' => $rows['jie']
				];
			}
		}
		out(200,$ret,$app_res);
	}out(201,'商品读取失败',$app_res);
	
?>