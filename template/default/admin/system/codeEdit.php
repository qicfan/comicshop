<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>漫淘客商城</title>
<script type="text/javascript" src="http://static.comicyu.com/js/jquery.js"></script>
<script type="text/javascript" src="http://static.comicyu.com/js/ajax.js"></script>
<link href="<?=MEDIA_URL?>css/general.css" rel="stylesheet" type="text/css" />
</head>

<body>
<script>
$(document).ready(function(){
	//自动选择
	var isreg = <?=$code->isreg?>;
	var islogin = <?=$code->islogin?>;
	var isquestion = <?=$code->isquestion?>;
	var iscomment = <?=$code->iscomment?>;
	var isloginman = <?=$code->isloginman?>;
	if (isreg == 1) {
		$("#isreg").attr('checked', 'checked');
	}
	if (islogin == 1) {
		$("#islogin").attr('checked', 'checked');
	}
	if (isquestion == 1) {
		$("#isquestion").attr('checked', 'checked');
	}
	if (iscomment == 1) {
		$("#iscomment").attr('checked', 'checked');
	}
	if (isloginman == 1) {
		$("#isloginman").attr('checked', 'checked');
	}
});
</script>

<ul id="container">
  <li id="header">
    <h1>系统管理</h1>
    <div class="link"></div>
    <div id="desc">
      <div id="page-selector">
		</div>
      <span>验证码管理</span> </div>
  </li>
</ul>
<table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
<form action="" method="post">
    <tr>
    	<td>注册页面 使用验证码</td>
    	<td><input type="checkbox" name="isreg" id="isreg" value="1" />
        <span class="note">（推荐勾选）</span></td>
    </tr>
    <tr>
    	<td>用户登录 使用验证码</td>
    	<td><input type="checkbox" name="islogin" id="islogin" value="1" /></td>
    </tr>
    <tr>
    	<td>用户提问 使用验证码</td>
    	<td><input type="checkbox" name="isquestion" id="isquestion" value="1" /></td>
    </tr>
    <tr>
    	<td>评论商品 使用验证码</td>
    	<td><input type="checkbox" name="iscomment" id="iscomment" value="1" /></td>
    </tr>
    <tr>
    	<td>后台登录 使用验证码</td>
    	<td><input type="checkbox" name="isloginman" id="isloginman" value="1" />
        <span class="note">（推荐勾选）</span></td>
    </tr>
    <tr>
    	<td>验证码图片长度：</td>
    	<td><input type="text" name="codewidth" value="<?=$code->codewidth?>" />
        <span class="note">（整数像素，不超过300，推荐长度90）</span></td>
    </tr>
    <tr>
    	<td>验证码图片宽度：</td>
        <td><input type="text" name="codeheight" value="<?=$code->codeheight?>" />
        <span class="note">（整数像素，不超过150，推荐宽度20）</span></td>
    </tr>
	<tr><td><input type="submit" value="提交" /></td></tr>
</form>
</table>
</body>
</html>
