<?php
	/*
	* File：运动/心跳
	* Author：易如意
	* QQ：51154393
	* Url：www.eruyi.cn
	*/
	if(!isset($app_res) or !is_array($app_res))out(100);//如果需要调用应用配置请先判断是否加载app配置
	
	$token = isset($data_arr['token']) && !empty($data_arr['token']) ? purge($data_arr['token']) : out(125,$app_res);//请输TOKEN
	
	$res_logon = Db::table('user_logon','as logon')->field('U.*')->JOIN('user','as U','logon.uid=U.id')->where('logon.appid',$appid)->where('U.appid',$appid)->where('logon.token',$token)->find();//false
	if(!$res_logon)out(127,$app_res);//TOKEN不存在或已失效
	if($res_logon['ban'] > time())out(114,$res_logon['ban_notice'],$app_res);//账号被禁用
	$res = Db::table('user_logon')->where('token',$token)->update(['last_t'=>time()]);//记录活动时间
	if($res){
		out(200,$app_res);
	}else{
		out(201,$app_res);
	}
?>