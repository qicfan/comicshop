<?php
// 设置脚本开始时间
$mtime = explode ( ' ', microtime () );
define ( 'ZF_START_TIME', $mtime [1] + $mtime [0] );
unset ( $mtime ); // 注销临时变量
$PRO_ROOT = defined(__DIR__) ? __DIR__ : dirname(__FILE__);
$PRO_ROOT = str_replace ( '\\', '/', $PRO_ROOT );
$PRO_ROOT = trim ( $PRO_ROOT, '/' ) . '/';
if (!strstr($PRO_ROOT, ':')) {
	$PRO_ROOT  = '/' . $PRO_ROOT;
}
define ( 'PRO_ROOT', $PRO_ROOT );
require_once 'dzg.php';
?>