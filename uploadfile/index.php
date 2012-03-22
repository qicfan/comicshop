<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <title> Index </title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 
 </head>

 <body>


<div id="main">

<? if($uid){ ?>
您已成功登录，用户名为 <?=$uname?>
<br/>
<a href="<?=URL?>index.php/front/user/userLogout">退出登录</a>
<? }else{ ?>
<a href="<?=URL?>index.php/front/user/userReg" >点击注册</a>
<br/>
<a href="<?=URL?>index.php/front/user/userLogin" >点击登录</a>
<? } ?>
</div>
 </body>
</html>
