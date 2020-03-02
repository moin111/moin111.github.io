<?php
	/*
	* File：普通注册接口文件 
	* Author：易如意
	* QQ：51154393
	* Url：www.eruyi.cn
	*/
	if(!isset($app_res) or !is_array($app_res))out(100);//如果需要调用应用配置请先判断是否加载app配置
	if($app_res['reg_state']=='n')out(103,$app_res['reg_notice'],$app_res);//判断是否可注册
	
	$name = isset($data_arr['name']) && !empty($data_arr['name']) ? purge($data_arr['name']) : '这个人没有名字!';//昵称
	$user = isset($data_arr['user']) && !empty($data_arr['user']) ? purge($data_arr['user']) : out(110,$app_res);//请输入账号
	$pwd = isset($data_arr['password']) && !empty($data_arr['password']) ? purge($data_arr['password']) : out(111,$app_res);//请输入密码
	$inv = isset($data_arr['inv']) ? intval($data_arr['inv']) : 0;//邀请人
	$reg_in = isset($data_arr['markcode']) ? purge($data_arr['markcode']) : '';//机器码
	
	if($app_res['reg_inon'] > 0 && $reg_in == '')out(112,$app_res);//判断是否验证机器码
	$reg_ip = getIp();//注册IP
	$reg_time = time();//注册时间
	if (preg_match ("/^[\w]{5,11}$/",$user)==0) out(116,$app_res);//账号长度5~11位，不支持中文和特殊字符
	if (preg_match ("/^[a-zA-Z\d.*_-]{6,18}$/",$pwd)==0) out(119,'密码长度需要满足6-18位数,不支持中文以及.-*_以外特殊字符',$app_res);//密码长度6~18位
	$res_user = Db::table('user')->where(['user'=>$user,'appid'=>$appid])->find();//false
	if($res_user)out(115,$app_res);//账号已存在
	
	$reg_ipon = $app_res['reg_ipon'];//获取IP重复注册间隔
	if($reg_ipon > 0){
		$ip_time = $reg_time-$reg_ipon*3600;
		$res = Db::table('user')->where('reg_ip',$reg_ip)->where('reg_time','>',$ip_time)->find();//寻找相同IP
		if($res) out(117,$app_res);//该IP已注册
	}
	
	$reg_inon = $app_res['reg_inon'];//获取机器码重复注册间隔
	if($reg_inon > 0){
		$in_time = $reg_time-$reg_inon*3600;
		$res = Db::table('user')->where('reg_in',$reg_in)->where('reg_time','>',$in_time)->find();//寻找相同机器码
		if($res) out(117,$app_res);//该机器码已注册
	}
	
	if ($inv > 0){//邀请人事件
		$res = Db::table('user')->where('id',$inv)->where('appid',$appid)->find();//查询邀请者ID
		if(!$res)out(118,$app_res);//邀请人已存在
		$inv_award = $app_res['inv_award'];//奖励类型
		$inv_award_num = $app_res['inv_award_num'];//邀请奖励数
		if($inv_award_num > 0){
			if($inv_award == 'vip' && $res['vip'] != 999999999){//奖励类型是VIP
				if($res['vip'] > $reg_time){//VIP没有过期
					$vip = $res['vip'] + 3600 * $inv_award_num;
				}else{//VIP已过期
					$vip = $reg_time + 3600 * $inv_award_num;
				}
				$inv_res = Db::table('user')->where('id',$inv)->update(['vip'=>$vip]);//更新邀请人VIP数据
				if($inv_res){
					Db::table('user_log')->add(['uid'=>$inv,'type'=>'inv','status'=>200,'time'=>$reg_time,'ip'=>$reg_ip,'vip'=>3600 * $inv_award_num / 86400,'appid'=>$appid]);//记录日志
				}else{
					Db::table('user_log')->add(['uid'=>$inv,'type'=>'inv','status'=>201,'time'=>$reg_time,'ip'=>$reg_ip,'appid'=>$appid]);//记录日志
				}
			}else if($inv_award == 'fen'){
				$fen = $res['fen'] + $inv_award_num;
				$inv_res = Db::table('user')->where('id',$inv)->update(['fen'=>$fen]);//更新邀请人积分数据
				if($inv_res){
					Db::table('user_log')->add(['uid'=>$inv,'type'=>'inv','status'=>200,'time'=>$reg_time,'ip'=>$reg_ip,'fen'=>$inv_award_num,'appid'=>$appid]);//记录日志
				}else{
					Db::table('user_log')->add(['uid'=>$inv,'type'=>'inv','status'=>201,'time'=>$reg_time,'ip'=>$reg_ip,'appid'=>$appid]);//记录日志
				}
			}
		}
	}
	
	$reg_award = $app_res['reg_award'];//奖励类型
	$reg_award_num = $app_res['reg_award_num'];//注册奖励
	if($reg_award_num > 0){
		if($reg_award == 'vip'){
			$vip = $reg_time + 60 * $reg_award_num;
			$add_res = Db::table('user')->add(['name'=>$name,'user'=>$user,'pwd'=>md5($pwd),'vip'=>$vip,'inv'=>$inv,'reg_in'=>$reg_in,'reg_ip'=>$reg_ip,'reg_time'=>$reg_time,'appid'=>$appid]);
		}else{
			$add_res = Db::table('user')->add(['name'=>$name,'user'=>$user,'pwd'=>md5($pwd),'fen'=>$reg_award_num,'inv'=>$inv,'reg_in'=>$reg_in,'reg_ip'=>$reg_ip,'reg_time'=>$reg_time,'appid'=>$appid]);
		}
	}else{
		$add_res = Db::table('user')->add(['name'=>$name,'user'=>$user,'pwd'=>md5($pwd),'inv'=>$inv,'reg_in'=>$reg_in,'reg_ip'=>$reg_ip,'reg_time'=>$reg_time,'appid'=>$appid]);
	}
	if($add_res){
		out(200,'注册成功',$app_res);
	}out(201,'注册失败',$app_res);
?>