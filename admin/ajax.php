<?php
require_once 'globals.php';
$act = isset($_GET['act']) ? purge($_GET['act']) : '';


if($act == 'edit_fen'){//编辑积分事件
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$update['name'] = isset($_POST['name']) ? purge($_POST['name']) : '';
	$update['fen_num'] = isset($_POST['fen_num']) ? intval($_POST['fen_num']) : 0;
	$update['vip_num'] = isset($_POST['vip_num']) ? intval($_POST['vip_num']) : 0;
	$update['appid'] = isset($_POST['appid']) ? intval($_POST['appid']) : 0;
	
	if($update['name'] == '')json(201,'积分事件名称为空');
	if($update['fen_num'] == 0)json(201,'请正确填写消耗积分数');
	if($update['vip_num'] < 0)json(201,'请正确填写兑换会员数');
	if($update['appid'] == 0)json(201,'绑定应用为空');
	
	$app_res = Db::table('app')->where('id',$update['appid'])->find();
	if(!$app_res)json(201,'应用不存在');
	
	$fen_res = Db::table('fen')->where(['name'=>$update['name'],'appid'=>$update['appid']])->find();
	if($fen_res){
		if($fen_res['id'] != $id)json(201,'积分事件名称已存在');
	}
	
	$res = Db::table('fen')->where('id',$id)->update($update);
	//die($res); 
	if($res){
		json(200,'编辑成功');
	}json(201,'编辑失败');
}

if($act == 'add_fen'){//添加积分事件
	$add['name'] = isset($_POST['name']) ? purge($_POST['name']) : '';
	$add['fen_num'] = isset($_POST['fen_num']) ? intval($_POST['fen_num']) : 0;
	$add['vip_num'] = isset($_POST['vip_num']) ? intval($_POST['vip_num']) : 0;
	$add['appid'] = isset($_POST['appid']) ? intval($_POST['appid']) : 0;
	
	if($add['name'] == '')json(201,'积分事件名称为空');
	if($add['fen_num'] == 0)json(201,'请正确填写消耗积分数');
	if($add['vip_num'] < 0)json(201,'请正确填写兑换会员数');
	if($add['appid'] == 0)json(201,'绑定应用为空');
	
	$app_res = Db::table('app')->where('id',$add['appid'])->find();
	if(!$app_res)json(201,'应用不存在');
	
	$fen_res = Db::table('fen')->where(['name'=>$add['name'],'appid'=>$add['appid']])->find();
	if($fen_res)json(201,'积分事件名称已存在');
	
	$add_res = Db::table('fen')->add($add);
	//die($add_res); 
	if($add_res){
		json(200,'添加成功');
	}json(201,'添加失败');
}

if($act == 'del_fen'){//删除积分事件
	$id = isset($_POST['id']) ? $_POST['id'] : '';
	if($id){
		$ids = '';
		foreach ($id as $value) {
			$ids .= intval($value).",";
		}
		$ids = rtrim($ids, ",");
		$res = Db::table('fen')->where('id','in','('.$ids.')')->del();//false
		//die($res);
		if($res){
			json(200,'删除成功');
		}json(201,'删除失败');
	}else{
		json(201,'没有需要删除的数据');
	}
}

if($act == 'del_fen_o'){//删除积分事件订单
	$id = isset($_POST['id']) ? $_POST['id'] : '';
	if($id){
		$ids = '';
		foreach ($id as $value) {
			$ids .= intval($value).",";
		}
		$ids = rtrim($ids, ",");
		$res = Db::table('fen_order')->where('id','in','('.$ids.')')->del();//false
		//die($res);
		if($res){
			json(200,'删除成功');
		}json(201,'删除失败');
	}else{
		json(201,'没有需要删除的数据');
	}
}

if($act == 'del_kami'){//删除卡密
	$id = isset($_POST['id']) ? $_POST['id'] : '';
	if($id){
		$ids = '';
		foreach ($id as $value) {
			$ids .= intval($value).",";
		}
		$ids = rtrim($ids, ",");
		$res = Db::table('kami')->where('id','in','('.$ids.')')->del();//false
		//die($res);
		if($res){
			json(200,'删除成功');
		}json(201,'删除失败');
	}else{
		json(201,'没有需要删除的数据');
	}
}

if($act == 'state_kami'){
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$state = isset($_POST['state']) ? purge($_POST['state']) : 'y';
	if($id <= 0)json(201,'需要修改的卡密有误');
	$k_res = Db::table('kami')->where('id',$id)->find();
	if(!$k_res)json(201,'卡密不存在');
	
	$res = Db::table('kami')->where('id',$id)->update(['state'=>$state]);//,false
	//die($res); 
	if($res){
		json(200,'编辑成功');
	}json(201,'编辑失败');
}

if($act == 'note_kami'){
	$id = isset($_POST['kid']) ? intval($_POST['kid']) : 0;
	$note = isset($_POST['note']) ? purge($_POST['note']) : '';
	if($id <= 0)json(201,'需要修改的卡密有误');
	$k_res = Db::table('kami')->where('id',$id)->find();
	if(!$k_res)json(201,'卡密不存在');
	
	$res = Db::table('kami')->where('id',$id)->update(['note'=>$note]);
	//die($res); 
	if($res){
		json(200,'编辑成功');
	}json(201,'编辑失败');
}

if($act == 'add_kami'){
	$appid = isset($_POST['appid']) ? intval($_POST['appid']) : 0;
	$note = isset($_POST['note']) ? purge($_POST['note']) : '';
	$type = isset($_POST['type']) ? purge($_POST['type']) : 'vip';
	$amount = isset($_POST['amount']) ? intval($_POST['amount']) : 1;
	$num = isset($_POST['num']) ? intval($_POST['num']) : 1;
	$out = isset($_POST['out']) ? intval($_POST['out']) : 0;
	$k_length = isset($_POST['k_length']) ? intval($_POST['k_length']) : 10;
	
	if($amount <= 0)json(201,'请设置卡密获得数');
	if($appid == 0)json(201,'绑定应用为空');
	$app_res = Db::table('app')->where('id',$appid)->find();
	if(!$app_res)json(201,'应用不存在');
	
	$str = '';
	for($i=1;$i<=$num;$i++){
		$key=getcode($k_length);
		if($out == 1){
			$add_res = Db::table('kami')->add(['kami'=>$key,'type'=>$type,'amount'=>$amount,'note'=>$note,'appid'=>$appid,'new'=>'y']);
		}else{
			$add_res = Db::table('kami')->add(['kami'=>$key,'type'=>$type,'amount'=>$amount,'note'=>$note,'appid'=>$appid]);
		}
		
		if(!$add_res){
			$key=getcode($k_length);
			$add_res = Db::table('kami')->add(['kami'=>$key,'type'=>$type,'amount'=>$amount,'note'=>$note,'appid'=>$appid]);
		}
		$str .= $key . "\r\n";
	}
	if($out == 1){
		$str = "==============卡密开始================\r\n\r\n".$str."\r\n==============卡密结束================";
		json(202,$str);
	}else{
		json(200,'添加成功');
	}
}

if($act == 'del_goods_o'){//删除订单
	$id = isset($_POST['id']) ? $_POST['id'] : '';
	if($id){
		$ids = '';
		foreach ($id as $value) {
			$ids .= intval($value).",";
		}
		$ids = rtrim($ids, ",");
		$res = Db::table('goods_order')->where('id','in','('.$ids.')')->del();//false
		//die($res);
		if($res){
			json(200,'删除成功');
		}json(201,'删除失败');
	}else{
		json(201,'没有需要删除的数据');
	}
}

if($act == 'del_goods'){//删除商品
	$id = isset($_POST['id']) ? $_POST['id'] : '';
	if($id){
		$ids = '';
		foreach ($id as $value) {
			$ids .= intval($value).",";
		}
		$ids = rtrim($ids, ",");
		$res = Db::table('goods')->where('id','in','('.$ids.')')->del();//false
		//die($res);
		if($res){
			json(200,'删除成功');
		}json(201,'删除失败');
	}else{
		json(201,'没有需要删除的数据');
	}
}

if($act == 'edit_goods'){
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$update['name'] = isset($_POST['name']) ? purge($_POST['name']) : '';
	$update['type'] = isset($_POST['type']) ? purge($_POST['type']) : 'vip';
	$update['amount'] = isset($_POST['amount']) ? intval($_POST['amount']) : 0;
	$update['money'] = isset($_POST['money']) ? purge($_POST['money']) : '1.00';
	$update['jie'] = isset($_POST['jie']) ? purge($_POST['jie']) : '';
	$update['appid'] = isset($_POST['appid']) ? intval($_POST['appid']) : 0;
	$update['state'] = isset($_POST['state']) ? purge($_POST['state']) : 'y';
	
	if($update['name'] == '')json(201,'请设置商品名称');
	if($update['amount'] <= 0)json(201,'请设置购买数量');
	if($update['appid'] == 0)json(201,'绑定应用为空');
	
	$app_res = Db::table('app')->where('id',$update['appid'])->find();
	if(!$app_res)json(201,'应用不存在');
	
	$goods_res = Db::table('goods')->where(['appid'=>$update['appid'],'name'=>$update['name']])->find();
	if($goods_res){
		if($goods_res['id'] != $id)json(201,'商品已存在');
	}
	
	$res = Db::table('goods')->where('id',$id)->update($update);
	//die($res); 
	if($res){
		json(200,'编辑成功');
	}json(201,'编辑失败');
}

if($act == 'add_goods'){
	$name = isset($_POST['name']) ? purge($_POST['name']) : '';
	$type = isset($_POST['type']) ? purge($_POST['type']) : 'vip';
	$amount = isset($_POST['amount']) ? intval($_POST['amount']) : 0;
	$money = isset($_POST['money']) ? purge($_POST['money']) : '1.00';
	$jie = isset($_POST['jie']) ? purge($_POST['jie']) : '';
	$appid = isset($_POST['appid']) ? intval($_POST['appid']) : 0;
	
	if($name == '')json(201,'请设置商品名称');
	if($amount <= 0)json(201,'请设置购买数量');
	if($appid == 0)json(201,'绑定应用为空');
	$app_res = Db::table('app')->where('id',$appid)->find();
	if(!$app_res)json(201,'应用不存在');
	$goods_res = Db::table('goods')->where(['appid'=>$appid,'name'=>$name])->find();
	if($goods_res)json(201,'商品已存在');
	$add_res = Db::table('goods')->add(['name'=>$name,'type'=>$type,'amount'=>$amount,'money'=>$money,'jie'=>$jie,'appid'=>$appid]);
	//die($res); 
	if($add_res){
		json(200,'添加成功');
	}json(201,'添加失败');
}

if($act == 'edit_exten'){//编辑配置
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$update['name'] = isset($_POST['name']) ? purge($_POST['name']) : '';
	$update['data'] = isset($_POST['data']) ? purge($_POST['data']) : '';
	$update['appid'] = isset($_POST['appid']) ? intval($_POST['appid']) : 0;
	
	if($update['name'] == '')json(201,'变量名称为空');
	if(preg_match ("/^[\w]{1,32}$/",$update['name'])==0)json(201,'变量名称不合格');
	if($update['data'] == '')json(201,'扩展配置为空');
	if($update['appid'] == 0)json(201,'绑定应用为空');
	
	$app_res = Db::table('app')->where('id',$update['appid'])->find();
	if(!$app_res)json(201,'应用不存在');
	
	$exten_res = Db::table('app_exten')->where(['name'=>$update['name']])->find();
	if($exten_res){
		if($exten_res['id'] != $id)json(201,'变量名已存在');
	}
	
	$res = Db::table('app_exten')->where('id',$id)->update($update);
	//die($res); 
	if($res){
		json(200,'编辑成功');
	}json(201,'编辑失败');
}

if($act == 'add_exten'){//添加配置
	$name = isset($_POST['name']) ? purge($_POST['name']) : '';
	$data = isset($_POST['data']) ? purge($_POST['data']) : '';
	$appid = isset($_POST['appid']) ? intval($_POST['appid']) : 0;
	
	if($name == '')json(201,'变量名称为空');
	if(preg_match ("/^[\w]{1,32}$/",$name)==0)json(201,'变量名称不合格');
	if($data == '')json(201,'扩展配置为空');
	if($appid == 0)json(201,'绑定应用为空');
	
	$app_res = Db::table('app')->where('id',$appid)->find();
	if(!$app_res)json(201,'应用不存在');
	
	$exten_res = Db::table('app_exten')->where(['name'=>$name])->find();
	if($exten_res)json(201,'变量名已存在');
	
	$add_res = Db::table('app_exten')->add(['name'=>$name,'data'=>$data,'appid'=>$appid]);
	//die($add_res); 
	if($add_res){
		json(200,'添加成功');
	}json(201,'添加失败');
}

if($act == 'del_exten'){//删除配置
	$id = isset($_POST['id']) ? $_POST['id'] : '';
	if($id){
		$ids = '';
		foreach ($id as $value) {
			$ids .= intval($value).",";
		}
		$ids = rtrim($ids, ",");
		$res = Db::table('app_exten')->where('id','in','('.$ids.')')->del();//false
		//die($res);
		if($res){
			json(200,'删除成功');
		}json(201,'删除失败');
	}else{
		json(201,'没有需要删除的数据');
	}
}

if($act == 'del_app'){//删除应用
	$id = isset($_POST['id']) ? $_POST['id'] : '';
	if($id){
		$ids = '';
		foreach ($id as $value) {
			$ids .= intval($value).",";
		}
		$ids = rtrim($ids, ",");
		$res = Db::table('app')->where('id','in','('.$ids.')')->del();//false
		//die($res);
		if($res){
			json(200,'删除成功');
		}json(201,'删除失败');
	}else{
		json(201,'没有需要删除的数据');
	}
}

if($act == 'edit_app'){
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$update['name'] = isset($_POST['name']) ? purge($_POST['name']) : '';
	$update['appkey'] = isset($_POST['appkey']) ? purge($_POST['appkey']) : '';
	
	$update['state'] = isset($_POST['state']) ? purge($_POST['state']) : 'y';//应用状态
	$update['mi_state'] = isset($_POST['mi_state']) ? purge($_POST['mi_state']) : 'y';//加密状态
	$update['smtp_state'] = isset($_POST['smtp_state']) ? purge($_POST['smtp_state']) : 'n';//邮箱状态
	$update['pay_state'] = isset($_POST['pay_state']) ? purge($_POST['pay_state']) : 'n';//支付状态
	$update['logon_state'] = isset($_POST['logon_state']) ? purge($_POST['logon_state']) : 'y';//登录状态
	$update['reg_state'] = isset($_POST['reg_state']) ? purge($_POST['reg_state']) : 'y';//注册状态
	
	$update['reg_ipon'] = isset($_POST['reg_ipon']) ? intval($_POST['reg_ipon']) : '';//IP重复注册间隔
	$update['reg_inon'] = isset($_POST['reg_inon']) ? intval($_POST['reg_inon']) : '';//设备重复注册间隔
	$update['reg_award'] = isset($_POST['reg_award']) ? purge($_POST['reg_award']) : '';//注册奖励类型
	$update['reg_award_num'] = isset($_POST['reg_award_num']) ? intval($_POST['reg_award_num']) : 0;//注册奖励数
	$update['inv_award'] = isset($_POST['inv_award']) ? purge($_POST['inv_award']) : '';//邀请奖励类型
	$update['inv_award_num'] = isset($_POST['inv_award_num']) ? intval($_POST['inv_award_num']) : 0;//邀请奖励数
	$update['reg_notice'] = isset($_POST['reg_notice']) ? purge($_POST['reg_notice']) : '';//注册关闭通知
	
	$update['logon_way'] = isset($_POST['logon_way']) ? intval($_POST['logon_way']) : 0;//登录方式
	$update['logon_check_in'] = isset($_POST['logon_check_in']) ? purge($_POST['logon_check_in']) : '';//登录时验证设备信息
	$update['logon_check_t'] = isset($_POST['logon_check_t']) ? intval($_POST['logon_check_t']) : 0;//设备换绑间隔时间
	$update['logon_num'] = isset($_POST['logon_num']) ? intval($_POST['logon_num']) : 0;//多设备登录数
	$update['diary_award'] = isset($_POST['diary_award']) ? purge($_POST['diary_award']) : '';//签到奖励类型
	$update['diary_award_num'] = isset($_POST['diary_award_num']) ? intval($_POST['diary_award_num']) : 0;//签到奖励数
	$update['logon_notice'] = isset($_POST['logon_notice']) ? purge($_POST['logon_notice']) : '';//登录关闭通知
	
	$update['smtp_host'] = isset($_POST['smtp_host']) ? purge($_POST['smtp_host']) : '';//邮箱服务器
	$update['smtp_user'] = isset($_POST['smtp_user']) ? purge($_POST['smtp_user']) : '';//邮箱账号
	$update['smtp_pass'] = isset($_POST['smtp_pass']) ? purge($_POST['smtp_pass']) : '';//邮箱密码
	$update['smtp_port'] = isset($_POST['smtp_port']) ? intval($_POST['smtp_port']) : 25;//邮箱端口
	
	$update['pay_url'] = isset($_POST['pay_url']) ? purge($_POST['pay_url']) : '';//支付地址
	$update['pay_id'] = isset($_POST['pay_id']) ? purge($_POST['pay_id']) : '';//支付ID
	$update['pay_key'] = isset($_POST['pay_key']) ? purge($_POST['pay_key']) : '';//支付KEY
	$update['pay_ali_state'] = isset($_POST['pay_ali_state']) ? purge($_POST['pay_ali_state']) : 'y';//支付宝状态
	$update['pay_wx_state'] = isset($_POST['pay_wx_state']) ? purge($_POST['pay_wx_state']) : 'y';//微信状态
	$update['pay_qq_state'] = isset($_POST['pay_qq_state']) ? purge($_POST['pay_qq_state']) : 'y';//QQ状态
	$update['pay_notify'] = isset($_POST['pay_notify']) ? purge($_POST['pay_notify']) : '';//异步通知地址
	$update['mi_type'] = isset($_POST['mi_type']) ? intval($_POST['mi_type']) : 0;//加密类型
	$update['mi_sign'] = isset($_POST['mi_sign']) ? purge($_POST['mi_sign']) : '';//数据签名
	$update['mi_time'] = isset($_POST['mi_time']) ? intval($_POST['mi_time']) : 0;//时间校验
	$update['mi_rsa_private_key'] = isset($_POST['mi_rsa_private_key']) ? purge($_POST['mi_rsa_private_key']) : '';//RSA私钥
	$update['mi_rsa_public_key'] = isset($_POST['mi_rsa_public_key']) ? purge($_POST['mi_rsa_public_key']) : '';//RSA公钥
	$update['mi_rc4_key'] = isset($_POST['mi_rc4_key']) ? purge($_POST['mi_rc4_key']) : '';//RC4秘钥
	$update['mode'] = isset($_POST['mode']) ? purge($_POST['mode']) : 'y';//运营模式
	
	$update['app_bb'] = isset($_POST['app_bb']) ? purge($_POST['app_bb']) : '1.0';//APP版本
	$update['app_nurl'] = isset($_POST['app_nurl']) ? purge($_POST['app_nurl']) : '';//更新链接
	$update['app_nshow'] = isset($_POST['app_nshow']) ? purge($_POST['app_nshow']) : '';//更新内容
	$update['notice'] = isset($_POST['notice']) ? purge($_POST['notice']) : '';//关闭通知
	
	$app_res = Db::table('app')->where('name',$update['name'])->find();
	if($app_res){
		if($app_res['id']!=$id)json(201,'应用名称重复');
	}
	
	$res = Db::table('app')->where('id',$id)->update($update);
	//die($res); 
	if($res){
		json(200,'编辑成功');
	}json(201,'编辑失败');
}

if($act == 'add_app'){
	$name = isset($_POST['name']) ? purge($_POST['name']) : '';
	$bb = isset($_POST['bb']) ? purge($_POST['bb']) : '';
	$appid = isset($_POST['appid']) ? intval($_POST['appid']) : 0;
	if($name == '')json(201,'应用名字不能为空');
	
	$app_res = Db::table('app')->where('name',$name)->find();
	if($app_res)json(201,'应用名称重复');
	if($appid > 0){
		$app_res = Db::table('app')->where('id',$appid)->find();
		if(!$app_res)json(201,'继承应用不存在');
		$app_res['name'] = $name;
		$app_res['appkey'] = md5(time());
		if($bb != '')$app_res['app_bb'] = $bb;
		$app_res['appkey'] = md5(time());
		unset($app_res['id']);
		$add = $app_res;
	}else{
		if($bb == '')$bb = '1.0';
		$add = ['name'=>$name,'app_bb'=>$bb,'appkey'=>md5(time())];
	}
	$res = Db::table('app')->add($add);
	//die($res); 
	if($res){
		json(200,'添加成功');
	}json(201,'添加失败');
}

if($act == 'del_user'){//删除用户
	$id = isset($_POST['id']) ? $_POST['id'] : '';
	if($id){
		$ids = '';
		foreach ($id as $value) {
			$ids .= intval($value).",";
		}
		$ids = rtrim($ids, ",");
		$res = Db::table('user')->where('id','in','('.$ids.')')->del();//false
		//die($res);
		if($res){
			json(200,'删除成功');
		}json(201,'删除失败');
	}else{
		json(201,'没有需要删除的数据');
	}
}

if($act == 'edit_user'){
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
	$update['fen'] = isset($_POST['fen']) ? intval($_POST['fen']) : 0;
	$update['vip'] = isset($_POST['vip']) ? intval($_POST['vip']) : 0;
	$update['ban'] = isset($_POST['ban']) ? intval($_POST['ban']) : 0;
	$update['ban_notice'] = isset($_POST['ban_notice']) ? purge($_POST['ban_notice']) : '';
	$update['openid_qq'] = isset($_POST['openid_qq']) ? purge($_POST['openid_qq']) : '';
	$update['openid_wx'] = isset($_POST['openid_wx']) ? purge($_POST['openid_wx']) : '';
	$pwd = isset($_POST['pwd']) ? purge($_POST['pwd']) : '';
	if($pwd != ''){
		$pass = md5($pwd);
		$update['pwd'] = $pass;
	}
	
	$res = Db::table('user')->where('id',$id)->update($update,false);
	//die($res); 
	if($res){
		json(200,'编辑成功');
	}json(201,'编辑失败');
}

if($act == 'add_user'){
	$user = isset($_POST['user']) ? purge($_POST['user']) : '';
	$pwd = isset($_POST['pwd']) ? purge($_POST['pwd']) : '';
	$appid = isset($_POST['appid']) ? intval($_POST['appid']) : 0;
	$reg_time = time();
	if($user == '')json(201,'账号不能为空');
	if($pwd == '')json(201,'密码不能为空');
	if($appid == 0)json(201,'绑定应用不能为空');
	$app_res = Db::table('app')->where('id',$appid)->find();
	if(!$app_res)json(201,'应用不存在');
	$user_res = Db::table('user')->where(['appid'=>$appid,'user'=>$user])->find();
	if($user_res)json(201,'账号已存在');
	$add_res = Db::table('user')->add(['user'=>$user,'pwd'=>md5($pwd),'appid'=>$appid,'reg_time'=>$reg_time]);
	//die($res); 
	if($add_res){
		json(200,'添加成功');
	}json(201,'添加失败');
}

if($act == 'del_user_log'){//删除日志
	$id = isset($_POST['id']) ? $_POST['id'] : '';
	if($id){
		$ids = '';
		foreach ($id as $value) {
			$ids .= intval($value).",";
		}
		$ids = rtrim($ids, ",");
		$res = Db::table('user_log')->where('id','in','('.$ids.')')->del();//false
		//die($res);
		if($res){
			json(200,'删除成功');
		}json(201,'删除失败');
	}else{
		json(201,'没有需要删除的数据');
	}
}

if($act == 'web_set'){
	$app_debug = isset($_POST['app_debug']) ? intval($_POST['app_debug']) : 0;
	$default_return_type = isset($_POST['default_return_type']) ? intval($_POST['default_return_type']) : 0;
	$user_token_time = isset($_POST['user_token_time']) ? intval($_POST['user_token_time']) : 0;
	$data_page_enums = isset($_POST['data_page_enums']) ? intval($_POST['data_page_enums']) : 0;
	$default_timezone = isset($_POST['default_timezone']) ? purge($_POST['default_timezone']) : '';
	$index_template = isset($_POST['index_template']) ? purge($_POST['index_template']) : '';
	$api_extend_mulu = isset($_POST['api_extend_mulu']) ? purge($_POST['api_extend_mulu']) : '';
	$adm_extend_mulu = isset($_POST['adm_extend_mulu']) ? purge($_POST['adm_extend_mulu']) : '';
	$user_pic_mulu = isset($_POST['user_pic_mulu']) ? purge($_POST['user_pic_mulu']) : '';
	$log_mulu = isset($_POST['log_mulu']) ? purge($_POST['log_mulu']) : '';
	
	if($user_token_time == '')json(201,'用户在线状态有效期有误');
	if($default_timezone == '')json(201,'系统时区有误');
	if($api_extend_mulu == '')json(201,'接口扩展目录有误');
	if($adm_extend_mulu == '')json(201,'后台扩展目录有误');
	if($user_pic_mulu == '')json(201,'用户头像目录有误');
	if($log_mulu == '')json(201,'日志打印目录有误');
	
	$userdata = file_get_contents('../include/config.php');
	$userdata = preg_replace("/\'APP_DEBUG',(\d+)/", "'APP_DEBUG',{$app_debug}", $userdata);
	$userdata = preg_replace("/\'DEFAULT_RETURN_TYPE',(\d+)/", "'DEFAULT_RETURN_TYPE',{$default_return_type}", $userdata);
	$userdata = preg_replace("/\'USER_TOKEN_TIME',(\d+)/", "'USER_TOKEN_TIME',{$user_token_time}", $userdata);
	$userdata = preg_replace("/\'DATA_PAGE_ENUMS',(\d+)/", "'DATA_PAGE_ENUMS',{$data_page_enums}", $userdata);
	$userdata = preg_replace("/\'DEFAULT_TIMEZONE','(.*?)'/", "'DEFAULT_TIMEZONE','{$default_timezone}'", $userdata);
	$userdata = preg_replace("/\'INDEX_TEMPLATE','(.*?)'/", "'INDEX_TEMPLATE','{$index_template}'", $userdata);
	$userdata = preg_replace("/\'API_EXTEND_MULU','(.*?)'/", "'API_EXTEND_MULU','{$api_extend_mulu}'", $userdata);
	$userdata = preg_replace("/\'ADM_EXTEND_MULU','(.*?)'/", "'ADM_EXTEND_MULU','{$adm_extend_mulu}'", $userdata);
	$userdata = preg_replace("/\'USER_PIC_MULU','(.*?)'/", "'USER_PIC_MULU','{$user_pic_mulu}'", $userdata);
	$userdata = preg_replace("/\'LOG_MULU','(.*?)'/", "'LOG_MULU','{$log_mulu}'", $userdata);
	$adm_res = file_put_contents('../include/config.php', $userdata);
	if($adm_res){
		json(200,'修改成功');
	}json(201,'修改失败');
}

if($act == 'adm_edit'){
	$user = isset($_POST['user']) ? purge($_POST['user']) : '';
	$pwd = isset($_POST['pwd']) ? purge($_POST['pwd']) : '';
	$okpwd = isset($_POST['okpwd']) ? purge($_POST['okpwd']) : '';
	if($user == '')json(201,'账号不能为空');
	if($pwd == '')json(201,'密码不能为空');
	if($okpwd == '')json(201,'请确认密码');
	if($okpwd != $pwd)json(201,'确认密码有误');
	$userdata = file_get_contents('userdata.php');
	//json(201,$userdata);
	$userdata = preg_replace('/\$user = \'.*?\'/', '$user = \'' . $user . '\'', $userdata);
	$userdata = preg_replace('/\$pass = \'.*?\'/', '$pass = \'' . $pwd . '\'', $userdata);
	$userdata = preg_replace('/\$cookie = \'.*?\'/', '$cookie = \'' . md5($user.$pwd.time()) . '\'', $userdata);
	$adm_res = file_put_contents('userdata.php', $userdata);
	if($adm_res){
		json(200,'修改成功');
	}json(201,'修改失败');
}

?>