<?php
/*
* File：后台全局加载项
* Author：易如意
* QQ：51154393
* Url：www.eruyi.cn
*/

require_once '../include/global.php';
require_once 'userdata.php';
substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1);

$action = isset($_GET['action']) ? purge($_GET['action']) : '';

//登录验证
if ($action == 'login') {
	$username = isset($_POST['user']) ? purge($_POST['user']) : '';
	$password = isset($_POST['pwd']) ? purge($_POST['pwd']) : '';
	
    if($username == '' || $password == ''){
		header('Location:./login.php?err=1');
		exit;
	}
	
	if($username == $user && $password == $pass){
		setcookie('ADMIN_COOKIE', $cookie, time() + 36000, '/');
		header('Location:./');
		exit;
	}else{
		header('Location:./login.php?err=2');
		exit;
	}
}
//退出
if ($action == 'logout') {
	setcookie('ADMIN_COOKIE', ' ', time() - 36000, '/');
	header('Location:./login.php');
	exit;
}

$ADMIN_COOKIE = isset($_COOKIE['ADMIN_COOKIE']) ? purge($_COOKIE['ADMIN_COOKIE']) : '';
if($ADMIN_COOKIE == $cookie){
	$islogin = true;
}else{
	$islogin = false;
}

if (!$islogin) {
	header('Location:./login.php?err=3');
	exit;
}

function php_self(){
    $php_self=substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1);
    return $php_self;
}
