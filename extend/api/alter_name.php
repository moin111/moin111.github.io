<?php
	/*
	* File：修改名称
	* Author：易如意
	* QQ：51154393
	* Url：www.eruyi.cn
	*/
	if(!isset($app_res) or !is_array($app_res))out(100);//如果需要调用应用配置请先判断是否加载app配置
	
	$token = isset($data_arr['token']) && !empty($data_arr['token']) ? purge($data_arr['token']) : out(125,$app_res);//请输TOKEN
	$name = isset($data_arr['name']) && !empty($data_arr['name']) ? purge($data_arr['name']) : out(129,$app_res);//请输账号
	
	$res_logon = Db::table('user_logon','as logon')->field('U.*')->JOIN('user','as U','logon.uid=U.id')->where('U.appid',$appid)->where('logon.token',$token)->find();//false
	if(!$res_logon)out(127,$app_res);//TOKEN不存在或已失效
	if($res_logon['ban'] > time())out(114,$res_logon['ban_notice'],$app_res);//账号被禁用
	
	$res = Db::table('user')->where('id',$res_logon['id'])->update(['name'=>$name]);
	
	Db::table('user_logon')->where('token',$token)->update(['last_t'=>time()]);//记录活动时间
	
	//die($res); 
	if($res){
		Db::table('user_log')->add(['uid'=>$res_logon['id'],'type'=>$act,'status'=>200,'time'=>time(),'ip'=>getip(),'appid'=>$appid]);//记录日志
		out(200,'修改成功',$app_res);
	}else{
		Db::table('user_log')->add(['uid'=>$res_logon['id'],'type'=>$act,'status'=>201,'time'=>time(),'ip'=>getip(),'appid'=>$appid]);//记录日志
		out(201,'修改失败',$app_res);
	}
?>