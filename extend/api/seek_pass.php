<?php
	/*
	* File：邮箱找回密码
	* Author：易如意
	* QQ：51154393
	* Url：www.eruyi.cn
	*/
	if(!isset($app_res) or !is_array($app_res))out(100);//如果需要调用应用配置请先判断是否加载app配置
	if($app_res['smtp_state']=='n')out(121,$app_res);//判断邮箱是否可用
	
	$email = isset($data_arr['email']) && !empty($data_arr['email']) ? purge($data_arr['email']) : out(110,$app_res);//请输入账号
	$crc = isset($data_arr['crc']) && !empty($data_arr['crc']) ? intval($data_arr['crc']) : out(120,$app_res);//验证码为空
	$newpwd = isset($data_arr['newpassword']) && !empty($data_arr['newpassword']) ? purge($data_arr['newpassword']) : out(111,'请输入新密码',$app_res);//请输入密码
	
	if (!check_email($email)) out(116,'邮箱不合法',$app_res);//账号长度5~11位，不支持中文和特殊字符
	if (preg_match ("/^[a-zA-Z\d.*_-]{6,18}$/",$pwd)==0) out(119,'密码长度需要满足6-18位数,不支持中文以及.-*_以外特殊字符',$app_res);//密码长度6~18位
	$res_user = Db::table('user')->where(['email'=>$email,'appid'=>$appid])->find();//false
	if(!$res_user)out(122,$app_res);//账号不存在
	if($res_user['ban'] > time())out(114,$res_user['ban_notice'],$app_res);//账号被禁用
	
	$res_code = Db::table('captcha')->where(['email'=>$email,'code'=>$crc,'new'=>'y','appid'=>$appid])->order('id DESC')->find();//false
	if(!$res_code)out(124,$app_res);//验证码不正确
	Db::table('captcha')->where('id',$res_code['id'])->update(['new'=>'n']);
	$res = Db::table('user')->where('id',$res_user['id'])->update(['pwd'=>md5($newpwd)]);
	
	if($res){
		Db::table('user_log')->add(['uid'=>$res_user['id'],'type'=>$act,'status'=>200,'time'=>time(),'ip'=>getip(),'appid'=>$appid]);//记录日志
		out(200,'找回密码成功',$app_res);
	}else{
		Db::table('user_log')->add(['uid'=>$res_user['id'],'type'=>$act,'status'=>201,'time'=>time(),'ip'=>getip(),'appid'=>$appid]);//记录日志
		out(201,'找回密码失败',$app_res);
	}
?>