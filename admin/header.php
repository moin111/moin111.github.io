<?php
/*
* File：页头
* Author：易如意
* QQ：51154393
* Url：www.eruyi.cn
*/
require_once 'globals.php';

$t_name = [
	'web_set.php'=>'系统设置',
	'adm_edit.php'=>'修改管理员密码',
	'index.php'=>'首页',
	'app_adm.php'=>'应用管理',
	'app_edit.php'=>'编辑应用',
	'app_exten.php'=>'扩展配置',
	'user_adm.php'=>'用户管理',
	'user_edit.php'=>'用户编辑',
	'user_log.php'=>'用户日志',
	'goods_adm.php'=>'商品管理',
	'goods_order.php'=>'商品订单',
	'goods_edit.php'=>'编辑商品',
	'kami_adm.php'=>'卡密管理',
	'kami_add.php'=>'添加卡密',
	'fen_adm.php'=>'积分管理',
	'fen_order.php'=>'积分订单',
];

$title = $t_name[php_self()];
$so = isset($_POST['so']) ? purge($_POST['so']) : '';

$u_num = Db::table('user')->count();//获取用户总数
$a_num = Db::table('app')->count();//获取用户总数
$g_num = Db::table('goods')->count();//获取用户总数
$k_num = Db::table('kami')->count();//获取卡密总数
$f_num = Db::table('fen')->count();//获取积分事件总数
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title><?php echo $title; ?> - 后台管理 - 易如意网络验证</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
		<script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>
		
		<!--<script src="https://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
		<link rel="stylesheet" type="text/css" href="https://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
        <!-- App favicon -->
        <link rel="icon" href="../assets/images/favicon.ico">
        <!-- App css -->
        <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/css/eruyi.min.css" rel="stylesheet" type="text/css" />
		<script src="../assets/js/modal_dialog.js"></script>
    </head>

    <body>

        <!-- Topbar Start -->
        <div class="navbar-custom topnav-navbar">
            <div class="container-fluid">
                <!-- LOGO -->
                <a href="index.php" class="topnav-logo">
                    <span class="topnav-logo-lg">
                        <img src="../assets/images/logo-light.png?" alt="" height="16">                    
					</span>
                    <span class="topnav-logo-sm">
                        <img src="../assets/images/logo_sm.png" alt="" height="16">                    
					</span>                
				</a>

                <ul class="list-unstyled topbar-right-menu float-right mb-0">
                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle nav-user arrow-none mr-0" data-toggle="dropdown" id="topbar-userdrop" href="#" role="button" aria-haspopup="true"
                            aria-expanded="false">
                            <span class="account-user-avatar"> 
                                <img src="../assets/images/users/avatar-1.jpg" alt="user-image" class="rounded-circle">                            
							</span>
                            <span>
                                <span class="account-user-name">管理员</span>
                                <span class="account-position"><?php echo $user;?></span>                            
							</span>                        
						</a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated topbar-dropdown-menu profile-dropdown" aria-labelledby="topbar-userdrop">
                            <!-- item-->
                            <div class=" dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Welcome !</h6>
                            </div>
							<!-- item-->
                            <a href="web_set.php" class="dropdown-item notify-item">
                                <i class="mdi mdi-cogs mr-1"></i>
                                <span>系统设置</span>                            
							</a>
                            <!-- item-->
                            <a href="adm_edit.php" class="dropdown-item notify-item">
                                <i class="mdi mdi-account-edit mr-1"></i>
                                <span>修改密码</span>                            
							</a>
    
                            <!-- item-->
                            <a href="./?action=logout" class="dropdown-item notify-item">
                                <i class="mdi mdi-account-arrow-right mr-1"></i>
                                <span>退出登入</span>                            
							</a>
                        </div>
                    </li>
                </ul>
				<a class="button-menu-mobile disable-btn">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </a>
            </div>
        </div>
		
        <!-- end Topbar -->
        <div class="container-fluid">

            <!-- Begin page -->
            <div class="wrapper">

                <!-- ============================================================== -->
                <!-- Start Page Content here -->
                <!-- ============================================================== -->

                <!-- Start Content-->

                <!-- ========== Left Sidebar Start ========== -->
                <div class="left-side-menu">

                    <div class="leftbar-user">
                        <a href="#">
                            <img src="../assets/images/users/avatar-1.jpg" alt="user-image" height="42" class="rounded-circle shadow-sm">
                            <span class="leftbar-user-name">管理员</span>                        
						</a>                    
					</div>

                    <!--- Sidemenu -->
                    <ul class="metismenu side-nav">

                        <li class="side-nav-title side-nav-item">导航</li>

                        <li class="side-nav-item">
                            <a href="./" class="side-nav-link">
                                <i class="mdi mdi-chart-arc"></i>
                                <span>首页</span>                            
							</a>
                        </li>
						
						<li class="side-nav-item">
                            <a href="javascript: void(0);" class="side-nav-link">
                                <i class="mdi mdi-cube-outline"></i>
                                <span>应用</span> 
								<span class="menu-arrow"></span>
							</a>
                            <ul class="side-nav-second-level" aria-expanded="false">
                                <li id="app">
                                    <a href="app_adm.php">应用管理<span class="badge badge-success float-right"><?php if($a_num>99){echo '99+';}else{echo $a_num;}?></span></a>
                                </li>
								<li>
                                    <a href="app_exten.php">扩展配置</a>
                                </li>
								<li hidden>
                                    <a href="app_edit.php">编辑用户</a>
                                </li>
                            </ul>
                        </li>
						
						<li class="side-nav-item">
                            <a href="javascript: void(0);" class="side-nav-link">
                                <i class="mdi mdi-account"></i>
                                <span>用户</span> 
								<span class="menu-arrow"></span>
							</a>
                            <ul class="side-nav-second-level" aria-expanded="false">
                                <li id="user">
                                    <a href="user_adm.php">用户管理<span class="badge badge-success float-right"><?php if($u_num>99){echo '99+';}else{echo $u_num;}?></span></a>
                                </li>
								<li>
                                    <a href="user_log.php">用户日志</a>
                                </li>
								<li hidden>
                                    <a href="user_edit.php">编辑用户</a>
                                </li>
                            </ul>
                        </li>
						
						<li class="side-nav-item">
                            <a href="javascript: void(0);" class="side-nav-link">
                                <i class="mdi mdi-credit-card"></i>
                                <span>卡密</span>
								<span class="menu-arrow"></span>
							</a>
                            <ul class="side-nav-second-level" aria-expanded="false">
                                <li>
                                    <a href="kami_adm.php">卡密管理<span class="badge badge-success float-right"><?php if($k_num>99){echo '99+';}else{echo $k_num;}?></span></a>
                                </li>
                                <li>
                                    <a href="kami_add.php">添加卡密</a>
                                </li>
                            </ul>
                        </li>
						
						<li class="side-nav-item">
                            <a href="javascript: void(0);" class="side-nav-link">
                                <i class="mdi mdi-cart"></i>
                                <span>商品</span>
								<span class="menu-arrow"></span>
							</a>
                            <ul class="side-nav-second-level" aria-expanded="false">
                                <li id="goods">
                                    <a href="goods_adm.php">商品管理<span class="badge badge-success float-right"><?php if($g_num>99){echo '99+';}else{echo $g_num;}?></span></a>
                                </li>
								<li>
                                    <a href="goods_order.php">商品订单</a>
                                </li>
								<li hidden>
                                    <a href="goods_edit.php">编辑商品</a>
                                </li>
                            </ul>
                        </li>
						
						<li class="side-nav-item">
                            <a href="javascript: void(0);" class="side-nav-link">
                                <i class="mdi mdi-coin"></i>
                                <span>积分</span>
								<span class="menu-arrow"></span>
							</a>
                            <ul class="side-nav-second-level" aria-expanded="false">
                                <li id="fen">
                                    <a href="fen_adm.php">积分管理<span class="badge badge-success float-right"><?php if($f_num>99){echo '99+';}else{echo $f_num;}?></span></a>
                                </li>
								<li>
                                    <a href="fen_order.php">积分订单</a>
                                </li>
                            </ul>
                        </li>
						
						
                    <div class="clearfix"></div>
                    <!-- Sidebar -left -->
                </div>
                <!-- Left Sidebar End -->
				<div class="content-page">
                    <div class="content">