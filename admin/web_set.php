<?php
/*
* File：系统配置项
* Author：易如意
* QQ：51154393
* Url：www.eruyi.cn
*/

include_once 'header.php';

?>
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">首页</a></li>
                                            
                                            <li class="breadcrumb-item active">设置</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title"><?php echo $title; ?></h4>
                                </div> <!-- end page-title-box -->
                            </div> <!-- end col-->
                        </div>
                        <!-- end page title -->

                        <!-- end row -->
						<div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="" method="post" id="addimg" name="addimg">
                                            <div class="form-row">
												<div class="form-group col-md-12">
                                                    <label class="col-form-label">错误输出</label>
													<select class="form-control" name="app_debug" id="app_debug">
														<option value="0" <?php if(APP_DEBUG == 0) echo 'selected = "selected"'; ?>>关闭</option>
														<option value="1" <?php if(APP_DEBUG == 1) echo 'selected = "selected"'; ?>>开启</option>
													</select>
                                                </div>
                                            </div>
											<div class="form-row">
												<div class="form-group col-md-12">
                                                    <label class="col-form-label">数据输出格式</label>
													<select class="form-control" name="default_return_type" id="default_return_type">
														<option value="0" <?php if(DEFAULT_RETURN_TYPE == 0) echo 'selected = "selected"'; ?>>JSON</option>
														<option value="1" <?php if(DEFAULT_RETURN_TYPE == 1) echo 'selected = "selected"'; ?>>XML</option>
													</select>
                                                </div>
                                            </div>
											<div class="form-row">
												<div class="form-group col-md-12">
                                                    <label for="f_user" class="col-form-label">用户在线状态有效期</label>
                                                    
													<div class="input-group">
														<input type="text" class="form-control" id="user_token_time" name="user_token_time" placeholder="用户在线状态有效期" value="<?php echo USER_TOKEN_TIME; ?>" required>
														<div class="input-group-prepend">
															<span class="input-group-text" id="basic-addon1">秒</span>
														</div>
													</div>
                                                </div>
                                            </div>
											<div class="form-row">
												<div class="form-group col-md-12">
                                                    <label for="f_user" class="col-form-label">后台管理每页数据</label>
                                                    
													<div class="input-group">
														<input type="text" class="form-control" id="data_page_enums" name="data_page_enums" placeholder="后台管理每页数据" value="<?php echo DATA_PAGE_ENUMS; ?>" required>
														<div class="input-group-prepend">
															<span class="input-group-text" id="basic-addon1">条</span>
														</div>
													</div>
                                                </div>
                                            </div>
											<div class="form-row">
												<div class="form-group col-md-12">
                                                    <label for="f_user" class="col-form-label">系统时区</label> ：<a href='https://www.php.net/manual/en/timezones.php'target="_blank">查看合法时区的列表</a>
                                                    <input type="text" class="form-control" id="default_timezone" name="default_timezone" placeholder="系统时区" value="<?php echo DEFAULT_TIMEZONE; ?>" required>
                                                </div>
                                            </div>
											<div class="form-row">
												<div class="form-group col-md-12">
                                                    <label class="col-form-label">首页模板目录</label>
													<select class="form-control" name="index_template" id="index_template">
														<?php $template_arr = myScanDir(FCPATH.'template/',1); foreach($template_arr as $value){?>
														<option value="<?php echo $value; ?>" <?php if(INDEX_TEMPLATE == $value) echo 'selected = "selected"'; ?>><?php echo $value; ?></option>
														<?php } ?>
													</select>
                                                </div>
                                            </div>
											<div class="form-row">
												<div class="form-group col-md-12">
                                                    <label for="f_user" class="col-form-label">接口扩展目录</label>
                                                    <input type="text" class="form-control" id="api_extend_mulu" name="api_extend_mulu" placeholder="接口扩展目录" value="<?php echo API_EXTEND_MULU; ?>" required>
                                                </div>
                                            </div>
											<div class="form-row">
												<div class="form-group col-md-12">
                                                    <label for="f_user" class="col-form-label">后台扩展目录</label>
                                                    <input type="text" class="form-control" id="adm_extend_mulu" name="adm_extend_mulu" placeholder="后台扩展目录" value="<?php echo ADM_EXTEND_MULU; ?>" required>
                                                </div>
                                            </div>
											<div class="form-row">
												<div class="form-group col-md-12">
                                                    <label for="f_user" class="col-form-label">用户头像目录</label>
                                                    <input type="text" class="form-control" id="user_pic_mulu" name="user_pic_mulu" placeholder="用户头像目录" value="<?php echo USER_PIC_MULU; ?>" required>
                                                </div>
                                            </div>
											<div class="form-row">
												<div class="form-group col-md-12">
                                                    <label for="f_user" class="col-form-label">日志打印目录</label>
                                                    <input type="text" class="form-control" id="log_mulu" name="log_mulu" placeholder="日志打印保存目录" value="<?php echo LOG_MULU; ?>" required>
                                                </div>
                                            </div>
											
											<div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="ok" name="ok" value="y" required>
                                                    <label class="custom-control-label" for="ok">确认是我操作</label>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-block btn-primary" name="submit" id="submit" value="确认">确认修改</button>

                                        </form>

                                    </div> <!-- end card-body -->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>
					
						<script>
							$('#submit').click(function() {
								let t = window.jQuery;
								var app_debug = $("select[name='app_debug']").val();
								var default_return_type = $("select[name='default_return_type']").val();
								var user_token_time = $("input[name='user_token_time']").val();
								var data_page_enums = $("input[name='data_page_enums']").val();
								var default_timezone = $("input[name='default_timezone']").val();
								var index_template = $("select[name='index_template']").val();
								var api_extend_mulu = $("input[name='api_extend_mulu']").val();
								var adm_extend_mulu = $("input[name='adm_extend_mulu']").val();
								var user_pic_mulu = $("input[name='user_pic_mulu']").val();
								var log_mulu = $("input[name='log_mulu']").val();
								var ok = document.getElementById("ok").checked;
								if(!ok){
									t.NotificationApp.send("提示","请确认是我操作","top-center","rgba(0,0,0,0.2)","warning")
									return false;
								}
								document.getElementById('submit').innerHTML="<span class=\"spinner-border spinner-border-sm mr-1\" role=\"status\" aria-hidden=\"true\"></span>正在修改";
								document.getElementById('submit').disabled=true;
								
								$.ajax({
									cache: false,
									type: "POST",//请求的方式
									url : "ajax.php?act=web_set",//请求的文件名
									data : {
										app_debug:app_debug,
										default_return_type:default_return_type,
										user_token_time:user_token_time,
										data_page_enums:data_page_enums,
										default_timezone:default_timezone,
										index_template:index_template,
										api_extend_mulu:api_extend_mulu,
										adm_extend_mulu:adm_extend_mulu,
										user_pic_mulu:user_pic_mulu,
										log_mulu:log_mulu
									},
									dataType : 'json',
									success : function(data) {
										console.log(data);
										document.getElementById('submit').disabled=false;
										document.getElementById('submit').innerHTML="确认修改";
										if(data.code == 200){
											t.NotificationApp.send("成功",data.msg,"top-center","rgba(0,0,0,0.2)","success")
											document.getElementById("ok").checked=false;
											//window.setTimeout("window.location='"+window.location.href+"'",1000);
										}else{
											t.NotificationApp.send("失败",data.msg,"top-center","rgba(0,0,0,0.2)","error")
										}
									}
								});
								return false;//重要语句：如果是像a链接那种有href属性注册的点击事件，可以阻止它跳转。
							});
					
						</script>
<?php 
include_once 'footer.php';
?>