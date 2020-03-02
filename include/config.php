<?php
define('APP_DEBUG',0);//错误输出，0=关闭，1=开启

define('DEFAULT_RETURN_TYPE',0);//默认输出0=JSON格式,1=xml格式

define('USER_TOKEN_TIME',1800);// 用户状态在线有效期

define('DATA_PAGE_ENUMS',10);// 每页显示数据

define('DEFAULT_TIMEZONE','PRC');// 默认时区

define('INDEX_TEMPLATE','eruyi');//首页模板

define('API_EXTEND_MULU','extend/api/');//api扩展目录

define('ADM_EXTEND_MULU','extend/adm/');//adm扩展目录

define('USER_PIC_MULU','data/pic/');//用户头像目录

define('LOG_MULU','log/');//日志打印目录

define('FCPATH', str_replace("\\", DIRECTORY_SEPARATOR, dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR)); // 网站根目录

define('WEB_URL',($_SERVER['SERVER_PORT']==443) ? 'https':'http'.'://'.$_SERVER['HTTP_HOST'].str_replace($_SERVER['DOCUMENT_ROOT'],"",dirname($_SERVER['SCRIPT_FILENAME']))); // 网站根目录

define('EDITION', 1.7); // 当前系统版本
?>