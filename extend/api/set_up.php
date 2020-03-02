<?php
	/*
	* File：设置账号
	* Author：易如意
	* QQ：51154393
	* Url：www.eruyi.cn
	*/
	if(!isset($app_res) or !is_array($app_res))out(100);//如果需要调用应用配置请先判断是否加载app配置
	
	$token = isset($data_arr['token']) && !empty($data_arr['token']) ? purge($data_arr['token']) : out(125,$app_res);//请输TOKEN
	$user = isset($data_arr['user']) && !empty($data_arr['user']) ? purge($data_arr['user']) : out(110,$app_res);//请输账号
	$pwd = isset($data_arr['password']) && !empty($data_arr['password']) ? purge($data_arr['password']) : '';//请输入密码
	if(preg_match("/^[\w]{32}$/",$token)==0)out(126,$app_res);//TOKEN不正确，32位字符串
	if(preg_match("/^[\w]{5,11}$/",$user)==0)out(116,$app_res);//账号长度5~11位，不支持中文和特殊字符
	$res_logon = Db::table('user_logon','as logon')->field('U.*')->JOIN('user','as U','logon.uid=U.id')->where('U.appid',$appid)->where('logon.token',$token)->find();//false
	if(!$res_logon)out(127,$app_res);//TOKEN不存在或已失效
	if(!empty($res_logon['user']))out(128,$app_res);//已设置过账号
	
	if($res_logon['ban'] > time())out(114,$res_logon['ban_notice'],$app_res);//账号被禁用
	
	Db::table('user_logon')->where('token',$token)->update(['last_t'=>time()]);//记录活动时间
	
	$res_user = Db::table('user')->where(['user'=>$user,'appid'=>$appid])->find();//false
	if($res_user)out(115,$app_res);//账号已存在
	if($pwd == ''){
		$res = Db::table('user')->where('id',$res_logon['id'])->update(['user'=>$user]);
	}else{
		$res = Db::table('user')->where('id',$res_logon['id'])->update(['user'=>$user,'pwd'=>md5($pwd)]);
	}
	
	//die($res); 
	if($res){
		Db::table('user_log')->add(['uid'=>$res_logon['id'],'type'=>$act,'status'=>200,'time'=>time(),'ip'=>getip(),'appid'=>$appid]);//记录日志
		out(200,'设置成功',$app_res);
	}else{
		Db::table('user_log')->add(['uid'=>$res_logon['id'],'type'=>$act,'status'=>201,'time'=>time(),'ip'=>getip(),'appid'=>$appid]);//记录日志
		out(201,'设置失败',$app_res);
	}
?>