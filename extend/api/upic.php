<?php
	/*
	* File：上传头像
	* Author：易如意
	* QQ：51154393
	* Url：www.eruyi.cn
	*/
	if(!isset($app_res) or !is_array($app_res))out(100);//如果需要调用应用配置请先判断是否加载app配置
	
	$upt = isset($data_arr['upt']) && !empty($data_arr['upt']) ? purge($data_arr['upt']) : 'e4a';//上传类型
	$token = isset($data_arr['token']) && !empty($data_arr['token']) ? purge($data_arr['token']) : out(125,$app_res);//请输TOKEN
	$res_logon = Db::table('user_logon','as logon')->field('U.*')->JOIN('user','as U','logon.uid=U.id')->where('U.appid',$appid)->where('logon.token',$token)->find();//false
	if(!$res_logon)out(127,$app_res);//TOKEN不存在或已失效
	if($res_logon['ban'] > time())out(114,$res_logon['ban_notice'],$app_res);//账号被禁用
	Db::table('user_logon')->where('token',$token)->update(['last_t'=>time()]);//记录活动时间
	
	$local_path  = FCPATH.USER_PIC_MULU;
	if (!file_exists($local_path)) mkdir($local_path);
	if ($upt == 'bbp'){
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			foreach ( $_FILES as $name=>$file ) {
				$fn=$file['name'];
				$ft=strrpos($fn,'.',0);
				$fe=substr($fn,$ft);
				$fp=$res_logon['id'].$fe;
				$result = move_uploaded_file($file['tmp_name'],$local_path.$fp);
				$pic = "/" . $fp;
			}
		}out(141,$app_res);//提交方式不正确
	}else if($upt == 'e4a'){
		$target_path = $res_logon['id'].".png";
		$result = move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $local_path.$target_path);
		$pic = substr($target_path,1);
	}else{
		out(142,$app_res);//上传类型不支持
	}
	
	if($result) {
		$res = Db::table('user')->where('id',$res_logon['id'])->update(['pic'=>$pic]);
		if($res){
			Db::table('user_log')->add(['uid'=>$res_logon['id'],'type'=>$act,'status'=>200,'time'=>time(),'ip'=>getip(),'appid'=>$appid]);//记录日志
			out(200,'上传成功',$app_res);
		}else{
			Db::table('user_log')->add(['uid'=>$res_logon['id'],'type'=>$act,'status'=>201,'time'=>time(),'ip'=>getip(),'appid'=>$appid]);//记录日志
			out(201,'修改头像数据失败',$app_res);
		}	
    }else{
		Db::table('user_log')->add(['uid'=>$res_logon['id'],'type'=>$act,'status'=>201,'time'=>time(),'ip'=>getip(),'appid'=>$appid]);//记录日志
		out(201,'上传失败',$app_res);
    }
	
	
?>