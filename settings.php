<?php
require_once('config.php');  //网站设置
define('DEBUG', true);
define('MEDIA_ROOT' , PRO_ROOT . 'media/');
define('MEDIA_URL', URL . 'media/');
define('DATABASE_ENGINE', 'mysql');
define('DATABASE_NAME', 'mantaoke');
define('DATABASE_USER', '');
define('DATABASE_PASSWORD', '');
define('DATABASE_HOST', 'la.comicyu.com');
define('SESSION', true);
define('SESSION_AUTO', true);
define('TIME_ZONE', 'Asia/Shanghai');
define('DZG_TPLPATH', 'default');
define('CACHE_ENGINE', 'mem');
define('MEM_HOST', '127.0.0.1:11211');
define('CACHE_VIEWS', false);
define('CACHE_VIEWS_TIME', 20);
define('CACHE_TEMPLATE', false);
define('CACHE_TEMPLATE_TIME', 10);
define('DZG_WARTERMARK_FILE', MEDIA_ROOT . 'img/watermark.png');
define('DZG_WARTERMARK_FONT','hapcomic.com');
define('DZG_WARTERMARK_FONT', 'comicyu.com');
define('DZG_AUTHKEY', 'anIcf@@*(^dn12');
define('DZG_COOKIEDOMAIN', '');
define('PAGE_SIZE', '10');    //分页每页显示项数。
define('USEFUL_LIFE', '30');   //����Ż�ȯ��Ч��(��)
define('COUPON','30');    //赠送优惠券时限（天）
define('PAYKEY','71fa71ce9953cb1f');    //支付key  md5(comicyu_mall_paykey)取16位
//define('PAYKEY','{pay^comic+yu#com188}');
define('PAYURL','http://10.69.10.68/pay/src/');    //支付地址
define('CREATESTATIC',1);
define('REWRITE',1);
define('VIEWSCOUNT',6);
define('APPID',1);
define('SERVICESERVER','passport.hapcomic.com');
define('SERVICEKEY','1234567890');
define('SERVICEPORT',80);
define('SERVICEURL','/index.php/json');
define('NAV_MY', '> <a href="'.URL.'/my/index.html">我的漫淘客</a> ');
$TEMPLATE_DIR = array(PRO_ROOT . 'template');
$MIDDLEWARE = array(DZG_ROOT . 'core/middleware/commonMiddleware.php', 
					PRO_ROOT . 'middleware/authMiddleware.php',
					PRO_ROOT . 'middleware/adminAuthMiddleware.php',
					);
?>