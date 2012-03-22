<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户登录</title>
<link href="<?=MEDIA_URL?>css/mtk.css" rel="stylesheet" type="text/css" />
</head>

<body>
 <!-- 头部-->
<?php include PRO_ROOT."template/default/front/include/nav1.php";?> 

<div class="box2">
  <div class="dl_login">
     <h2>已注册用户登录</h2>
     <form method="post" name="form1" onsubmit="return verify();">
       <p>用户名：</p>
       <input id="username" name="username" class="dl1" type="text" value="<?=$_COOKIE['mtk_rename']?>" />
       <p>密码：</p>
       <input id="password" name="password" class="dl1" type="password" /><span>忘记密码？</span>
       <p class="p2"><input name="rename" type="checkbox" value="1" /><span>记住用户名</span><input type="checkbox" name="auto_login" /><span>自动登录</span></p>
       <input type="submit" class="bt2" value="登 　录" />
     </form>
  </div>
  <div class="x_line"></div>
  <div class="dl_login_z">
    <h2>还不是漫淘客的用户？</h2>
    <p>现在免费注册成为漫淘客商城用户，便能立刻享受便宜又放心的购物乐趣。</p>
    <p><a class="bt2" href="<?=URL?>index.php/front/user/userReg">注册新用户</a></p>
  </div>
  <div class="di"><img src="<?=MEDIA_URL?>img/front/di.gif" /></div>
</div>
</body>
<script>
function verify(){

	var username = document.getElementById('username').value;
	var password = document.getElementById('password').value;
	
	if (username == '') {
		alert('请填写用户名！');
		form1.username.focus();
		return false;
	}
	if (password == '') {
		alert('密码不能为空！');
		form1.password.focus();
		return false;
	}

	return true;
}
</script>
</html>