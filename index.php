<?php
/*易如意网络验证系统首页入口文件*/
include("./include/common.php");
if($app_res == false && !is_array($app_res)){
	include(FCPATH."template/".INDEX_TEMPLATE."/error.html");//数据库可能出错
	return;
}

if($_SERVER["QUERY_STRING"] == '' or $_SERVER["QUERY_STRING"] == 'index'){
	include(FCPATH."template/".INDEX_TEMPLATE."/index.html");
}else if(file_exists(FCPATH."template/".INDEX_TEMPLATE."/".$_SERVER["QUERY_STRING"].".html")){
	include(FCPATH."template/".INDEX_TEMPLATE."/".$_SERVER["QUERY_STRING"].".html");
}else{
	include(FCPATH."template/".INDEX_TEMPLATE."/404.html");
}
?>

