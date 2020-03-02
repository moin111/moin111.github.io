<?php
/*
* File：添加卡密
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
                                            <li class="breadcrumb-item active">卡密</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title"><?php echo $title; ?></h4>
                                </div> <!-- end page-title-box -->
                            </div> <!-- end col-->
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form class="needs-validation" novalidate  action="" method="post">
											<div class="form-row">
												<div class="form-group col-md-2">
                                                    <label class="col-form-label">卡密类型</label>
													<select class="form-control" name="add_type" id="add_type" onchange="type_change(this.value)">
														<option value="vip" selected = "selected">会员</option>
														<option value="fen" >积分</option>
													</select>
                                                </div>
												<div class="form-group col-md-10">
													<label class="col-form-label" id="amount_name">&nbsp;会员天数 *</label>
													<div class="input-group">
														<input type="number" id="add_amount" name="add_amount" class="form-control" placeholder="会员天数，永久卡9个9" value="" required>
														<div class="input-group-prepend">
															<span class="input-group-text" id="amount_a">天</span>
														</div>
													</div>
                                                </div>
                                            </div>
                                            <div class="form-row">
												<div class="form-group col-md-6">
                                                    <label class="col-form-label">生成数量</label>
                                                    <input type="number" class="form-control" id="add_num" name="add_num" placeholder="生成数量" value="1" required>
                                                </div>
												<div class="form-group col-md-6">
                                                    <label class="col-form-label">卡密长度</label>
                                                    <input type="number" class="form-control" id="k_length" name="k_length" placeholder="卡密长度" value="10" required>
                                                </div>
											</div>
											
											<div class="form-row">
												<div class="form-group col-md-12">
                                                    <label class="col-form-label">卡密备注</label>
                                                    <input type="text" class="form-control" id="add_note" name="add_note" placeholder="卡密备注" value="" >
                                                </div>
											</div>	
											<div class="form-row">	
												<div class="form-group col-md-12">
													<label class="col-form-label">绑定应用</label>
													<select class="form-control" name="add_appid" id="add_appid">
														<?php
															$res = Db::table('app')->order('id desc')->select();
															foreach ($res as $k => $v){$rows = $res[$k];
														?>
														<option value="<?php echo $rows['id']; ?>"><?php echo $rows['name']; ?></option>
														<?php } ?>
													</select>
												</div>
											</div>											
											<div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" name="out" id="out" value="1">
                                                    <label class="custom-control-label" for="out">生成后立即导出</label>
                                                </div>
                                            </div>
											<button class="btn btn-block btn-xs btn-success" name="add_submit" id="add_submit" type="submit" value="确定">确认生成</button>
                                        </form>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col -->

                            
                        </div>
                        <!-- end row -->
						<script>
							$('#add_submit').click(function() {
								let t = window.jQuery;
								var out = document.getElementById("out").checked;
								if(out){
									out=1;
								}else{
									out=0;
								}
								var add_type = $("select[name='add_type']").val();
								var add_amount = $("input[name='add_amount']").val();
								var add_num = $("input[name='add_num']").val();
								var k_length = $("input[name='k_length']").val();
								var add_note = $("input[name='add_note']").val();
								var add_appid = $("select[name='add_appid']").val();
								document.getElementById('add_submit').innerHTML="<span class=\"spinner-border spinner-border-sm mr-1\" role=\"status\" aria-hidden=\"true\"></span>正在生成";
								document.getElementById('add_submit').disabled=true;
								
								$.ajax({
									cache: false,
									type: "POST",//请求的方式
									url : "ajax.php?act=add_kami",//请求的文件名
									data : {
										type:add_type,
										amount:add_amount,
										num:add_num,
										out:out,
										k_length:k_length,
										note:add_note,
										appid:add_appid
									},
									dataType : 'json',
									success : function(data) {
										console.log(data);
										document.getElementById('add_submit').disabled=false;
										document.getElementById('add_submit').innerHTML="确认添加";
										if(data.code == 200){
											t.NotificationApp.send("成功",data.msg,"top-center","rgba(0,0,0,0.2)","success");
											//window.setTimeout("window.location='"+window.location.href+"'",1000);
										}else if(data.code == 202){
											t.NotificationApp.send("成功","正在生成卡密文件","top-center","rgba(0,0,0,0.2)","success");
											download(add_type+'_'+add_num+'_'+add_appid,data.msg);
										}else{
											t.NotificationApp.send("失败",data.msg,"top-center","rgba(0,0,0,0.2)","error");
										}
									}
								});
								return false;//重要语句：如果是像a链接那种有href属性注册的点击事件，可以阻止它跳转。
							});
							
							function download(filename, text) {
							  var element = document.createElement('a');
							  element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
							  element.setAttribute('download', filename+'km.txt');
							 
							  element.style.display = 'none';
							  document.body.appendChild(element);
							 
							  element.click();
							 
							  document.body.removeChild(element);
							}
							
							function type_change(i) {
								
								if(i=='vip'){
									document.getElementById('amount_name').innerHTML="&nbsp;会员天数 *";
									document.getElementById('add_amount').setAttribute("placeholder","会员天数，永久卡9个9");
									document.getElementById('amount_a').innerHTML="天";
								}else{
									document.getElementById('amount_name').innerHTML="&nbsp;积分数 *";
									document.getElementById('add_amount').setAttribute("placeholder","积分数");
									document.getElementById('amount_a').innerHTML="积分";
								}
							}
						</script>
                        
<?php 
include_once 'footer.php';
?>							