<?php
	/*
	* File：获取用户信息
	* Author：易如意
	* QQ：51154393
	* Url：www.eruyi.cn
	*/
	if(!isset($app_res) or !is_array($app_res))out(100);//如果需要调用应用配置请先判断是否加载app配置
	
	$token = isset($data_arr['token']) && !empty($data_arr['token']) ? purge($data_arr['token']) : out(125,$app_res);//请输TOKEN
	
	$res_logon = Db::table('user_logon','as logon')->field('U.*')->JOIN('user','as U','logon.uid=U.id')->where('logon.appid',$appid)->where('U.appid',$appid)->where('logon.token',$token)->find();//false
	if(!$res_logon)out(127,$app_res);//TOKEN不存在或已失效
	if($res_logon['ban'] > time())out(114,$res_logon['ban_notice'],$app_res);//账号被禁用
	Db::table('user_logon')->where('token',$token)->update(['last_t'=>time()]);//记录活动时间
	if($app_res['mode'] == 'y'){$vip = $res_logon['vip'];}else{$vip = '999999999';}//判断当前收费模式
	
	$user_info = [
		'id'=>$res_logon['id'],
		'pic'=>get_pic($res_logon['pic']),
		'user'=>$res_logon['user'],
		'email'=>$res_logon['email'],
		'phone'=>$res_logon['phone'],
		'name'=>$res_logon['name'],
		'vip'=>$vip,
		'fen'=>$res_logon['fen'],
		'inv'=>$res_logon['inv'],
		'openid_wx'=>$res_logon['openid_wx'],
		'openid_qq'=>$res_logon['openid_qq']
	];
	out(200,$user_info,$app_res);
?>