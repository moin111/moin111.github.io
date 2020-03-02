<?php
/*
* File：后台首页
* Author：易如意
* QQ：51154393
* Url：www.eruyi.cn
*/

include_once 'header.php';
$domain = $_SERVER['SERVER_NAME'];
$serverapp = $_SERVER['SERVER_SOFTWARE'];
$mysql_ver = DB::getInstance()->getMysqlVersion();
$php_ver = PHP_VERSION;
$uploadfile_maxsize = ini_get('upload_max_filesize');
if (function_exists("imagecreate")) {
	if (function_exists('gd_info')) {
		$ver_info = gd_info();
		$gd_ver = $ver_info['GD Version'];
	} else{
		$gd_ver = '支持';
	}
} else{
	$gd_ver = '不支持';
}


$jt_us = Db::table('user')->where('reg_time','between',[timeRange('t_a'),timeRange('t_b')])->count();//今日新用户
$zt_us = Db::table('user')->where('reg_time','between',[timeRange('zt_a'),timeRange('zt_b')])->count();//昨天新用户
if($zt_us > 0){
	$user_scale = $jt_us - $zt_us;
}else{
	$user_scale = $jt_us;
}

$jt_qs = Db::table('user_log')->where('type','clock')->where('time','between',[timeRange('t_a'),timeRange('t_b')])->count();//今日签到
$zt_qs = Db::table('user_log')->where('type','clock')->where('time','between',[timeRange('zt_a'),timeRange('zt_b')])->count();//昨天签到

if($zt_qs > 0){
	$diary_scale = $jt_qs - $zt_qs;//
}else{
	$diary_scale = $jt_qs;
}

$order_num = Db::table('goods_order')->count();//获取订单总数

$jt_os = Db::table('goods_order')->where('o_time','between',[timeRange('t_a'),timeRange('t_b')])->count();//今日订单数
$zt_os = Db::table('goods_order')->where('o_time','between',[timeRange('zt_a'),timeRange('zt_b')])->count();//昨天订单数

if($zt_os > 0){
	$order_scale = $jt_os - $zt_os;//
}else{
	$order_scale = $jt_os;
}

$jt_ms = Db::table('goods_order')->where('p_time','between',[timeRange('t_a'),timeRange('t_b')])->sum('money');//今日收益
if($jt_ms == null){
	$jt_ms =0;
}

$zt_ms = Db::table('goods_order')->where('p_time','between',[timeRange('zt_a'),timeRange('zt_b')])->sum('money');//昨天收益
if($zt_ms == null){
	$zt_ms =0;
}

if($zt_ms > 0){
	$money_scale = $jt_ms - $zt_ms;//
}else{
	$money_scale = $jt_ms;
}


//$u_num = Db::table('user')->count();
?>
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">首页</a></li>
                                            
                                            <li class="breadcrumb-item active">统计</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">统计</h4>
                                </div> <!-- end page-title-box -->
                            </div> <!-- end col-->
                        </div>
                        <!-- end page title -->

                        <!-- end row -->
						<div class="row">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="card widget-flat">
                                            <div class="card-body">
                                                <div class="float-right">
                                                    <i class="mdi mdi-account-multiple widget-icon"></i>                                                </div>
                                                <h5 class="text-muted font-weight-normal mt-0" title="Number of Customers">用户总数</h5>
                                                <h3 class="mt-3 mb-3"><?php echo $u_num; ?></h3>
                                                <p class="mb-0 text-muted">
													<?php if($user_scale >= 0):?>
                                                    <span class="text-success mr-2"><i class="mdi mdi-arrow-up-bold"></i> <?php echo $user_scale; ?></span>
													<?php else:?>
													<span class="text-danger mr-2"><i class="mdi mdi-arrow-down-bold"></i> <?php echo $user_scale; ?></span>
													<?php endif; ?>
													<span class="text-nowrap">对比昨天</span> 
												</p>
                                            </div> <!-- end card-body-->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->

                                    <div class="col-lg-3">
                                        <div class="card widget-flat">
                                            <div class="card-body">
                                                <div class="float-right">
                                                    <i class="mdi mdi-account-check widget-icon"></i>                                                </div>
                                                <h5 class="text-muted font-weight-normal mt-0" title="Number of Orders">今天签到</h5>
                                                <h3 class="mt-3 mb-3"><?php echo $jt_qs ?></h3>
                                                <p class="mb-0 text-muted">
                                                    <?php if($diary_scale >= 0):?>
                                                    <span class="text-success mr-2"><i class="mdi mdi-arrow-up-bold"></i> <?php echo $diary_scale; ?></span>
													<?php else:?>
													<span class="text-danger mr-2"><i class="mdi mdi-arrow-down-bold"></i> <?php echo $diary_scale; ?></span>
													<?php endif; ?>
													<span class="text-nowrap">对比昨天</span>                                                
												</p>
                                            </div> <!-- end card-body-->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->
									
									<div class="col-lg-3">
                                        <div class="card widget-flat">
                                            <div class="card-body">
                                                <div class="float-right">
                                                    <i class="mdi mdi-calendar-text widget-icon"></i>                                                </div>
                                                <h5 class="text-muted font-weight-normal mt-0" title="Number of Orders">订单总数</h5>
                                                <h3 class="mt-3 mb-3"><?php echo $order_num; ?></h3>
                                                <p class="mb-0 text-muted">
                                                    <?php if($order_scale >= 0):?>
                                                    <span class="text-success mr-2"><i class="mdi mdi-arrow-up-bold"></i> <?php echo $order_scale; ?></span>
													<?php else:?>
													<span class="text-danger mr-2"><i class="mdi mdi-arrow-down-bold"></i> <?php echo $order_scale; ?></span>
													<?php endif; ?>
													<span class="text-nowrap">对比昨天</span>                                                 
												</p>
                                            </div> <!-- end card-body-->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->
									
									<div class="col-lg-3">
                                        <div class="card widget-flat">
                                            <div class="card-body">
                                                <div class="float-right">
                                                    <i class="mdi mdi-cash-multiple widget-icon"></i>                                                </div>
                                                <h5 class="text-muted font-weight-normal mt-0" title="Growth">今日收益</h5>
                                                <h3 class="mt-3 mb-3"><?php echo $jt_ms; ?></h3>
                                                <p class="mb-0 text-muted">
                                                    <?php if($money_scale >= 0):?>
                                                    <span class="text-success mr-2"><i class="mdi mdi-arrow-up-bold"></i> <?php echo $money_scale; ?></span>
													<?php else:?>
													<span class="text-danger mr-2"><i class="mdi mdi-arrow-down-bold"></i> <?php echo $money_scale; ?></span>
													<?php endif; ?>
													<span class="text-nowrap">对比昨天</span>                                                 
												</p>
                                            </div> <!-- end card-body-->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->
								</div> <!-- end row -->

                            </div> <!-- end col -->
                        </div> <!-- end row -->
						
						<div class="row">
							<div class="col-xl-8">
								<div class="card">
									<div class="card-body" style="height: 507px;">
										<a href="user_log.php" class="btn btn-sm btn-link float-right mb-3">更多
											<i class="mdi mdi-chevron-double-right ml-1"></i>                                        
										</a>
										<h4 class="header-title mt-2">用户日志</h4>
										<?php 
											$sql = "SELECT {$DP}user_log.*,u.pic,u.user,u.name from {$DP}user_log LEFT JOIN `{$DP}user` as u ON ({$DP}user_log.uid=u.id) ORDER BY id desc limit 0,5";
											$res_log = DB::query($sql);
											//$res_log = Db::table('user_log')->order('id desc')->limit(0,5)->select();
											if(count($res_log)<=0):
										?>
										<div class="text-center" style="margin-top:6.5rem!important">
											<img src="../assets/images/startman.svg" height="120" alt="File not found Image">
											<h4 class="text-uppercase mt-3">暂无用户日志</h4>
										</div>	
										<?php else:foreach ($res_log as $k => $v){$rows = $res_log[$k];?>
										<div class="table-responsive">
											<table class="table table-centered table-hover mb-0" id="user_log">
												<tbody>
													<tr>
														<td class="media">
															<img class="mr-3 rounded-circle" src="<?php echo get_pic($rows['pic'],true);?>" width="40" alt="Generic placeholder image">
															<div class="media-body">
																<a href="user_edit.php?id=<?php echo $rows['uid']; ?>" class="text-title"><h5 class="mt-0 mb-1"><?php echo $rows['user'];?></h5></a>
																<span class="font-13"><?php echo $rows['name'];?></span>
															</div>
                                                        </td>
														<td>
															<h5 class="font-14 mb-1 font-weight-normal"><?php echo $lang_user[$rows['type']]; ?></h5>
															<span class="text-muted font-13">类型</span>                                                        
														</td>
														<td>
															<h5 class="font-14 mb-1 font-weight-normal"><?php echo date("Y-m-d H:i",$rows['time']); ?></h5>
															<span class="text-muted font-13">时间</span>                                                        
														</td>
														<td>
															<h5 class="font-14 mb-1 font-weight-normal"><?php echo $rows['ip']; ?></h5>
															<span class="text-muted font-13">IP</span>                                                        
														</td>
														<td>
															<h5 class="font-14 mb-1 font-weight-normal"><?php if($rows['fen'] >0){echo '+'.$rows['fen'];}else{echo $rows['fen'];} ?></h5>
															<span class="text-muted font-13">积分变化</span>                                                        
														</td>
														<td>
															<h5 class="font-14 mb-1 font-weight-normal"><?php if($rows['vip'] >0){echo '+'.$rows['vip'];}else{echo $rows['vip'];} ?></h5>
															<span class="text-muted font-13">会员变化</span>                                                        
														</td>
													</tr>
												</tbody>
											</table>
										</div> <!-- end table-responsive-->
										<?php } endif; ?>
									</div> <!-- end card-body-->
								</div> <!-- end card-->
							</div> <!-- end col-->
							<div class="col-xl-4">
								<div class="card">
									<div class="card-body" id="news"></div>
								</div>
								<!-- end card-->
							</div>
						</div>
                        <!-- end row-->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        
                                        <h4 class="header-title mb-3">服务器信息</h4>
                                        <div class="chart inline-legend grid">
										<p>当前版本：<?php echo EDITION; ?> <a id="edition_url" href="javascript:void(0);" target="_blank"><span class="badge badge-success-lighten" id="edition">最新</span></a></p>
										<p>当前域名：<?php echo $domain; ?></p>
										<p>PHP版本：<?php echo $php_ver; ?></p>
										<p>MySQL版本：<?php echo $mysql_ver; ?></p>
										<p>服务器环境：<?php echo $serverapp; ?></p>
										<p>GD图形处理库：<?php echo $gd_ver; ?></p>
										<p>服务器空间允许上传最大文件：<?php echo $uploadfile_maxsize; ?></p>
										
									</div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->
                        </div>
                        <!-- end row -->
                        <!-- end row -->
                    </div> <!-- content -->
					
					<script>
						$.ajax({
							cache: false,
							type: "GET",//请求的方式
							url : "http://nvs.eruyi.cn/api.php?act=bb",//请求的文件名
							dataType : 'json',
							success : function(data) {
								if(data.code == 200){
									if(<?php echo EDITION;?> >= data.msg.edition){
										document.getElementById("edition").className = "badge badge-success-lighten";
										document.getElementById("edition").innerHTML="最新";
									}else{
										document.getElementById("edition").className = "badge badge-danger-lighten";
										document.getElementById("edition").innerHTML="发现新版本";
										document.getElementById("edition_url").href = data.msg.url;
									}
								}
							}
						});
					</script>
<?php 
include_once 'footer.php';
?>