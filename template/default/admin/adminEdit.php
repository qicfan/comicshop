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
function verify(){
	var uname = document.getElementById('uname').value;
	var realname = document.getElementById('realname').value;
	var email = document.getElementById('email').value;
	var password = document.getElementById('password').value;
	var repassword = document.getElementById('repassword').value;
	if (uname == '' || password == ''){
		alert('请认真填写信息');
		return false;
	} else if (password != repassword){
		alert('两次密码输入不一致');
		return false;
	} else {
		str = {uname:uname, realname:realname, email:email, password:password};
		$.post('<?=URL?>index.php/admin/admin/adminSubmit?act=add&id=<?=isset($admin->id) ? $admin->id : 0?>', str, function(data){
			if (data == '1') {
				alert('操作成功');
			} else {
				alert('操作失败');
			}
			window.location.href = '<?=URL?>index.php/admin/admin/adminList';
		});
	}
	return false;
}
</script>

<ul id="container">
  <li id="header">
    <h1>管理员管理</h1>
    <div class="link"></div>
    <div id="desc">
      <div id="page-selector">
		</div>
      <span>编辑管理员信息</span> </div>
  </li>
</ul>
<table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
<form action="<?=URL?>index.php/admin/admin/adminSubmit?act=add&id=<?=isset($admin->id) ? $admin->id : 0?>" method="post" onsubmit="return verify();">
    <tr>
    	<td>用户名：</td>
    	<td><input type="text" name="uname" id="uname" value="<?=$admin->uname?>" /></td>
    </tr>
    <tr>
    	<td>真实姓名：</td>
    	<td><input type="text" name="realname" id="realname" value="<?=$admin->realname?>" /></td>
    </tr>
    <tr>
    	<td>电子邮件：</td>
    	<td><input type="text" name="email" id="email" value="<?=$admin->email?>" /></td>
    </tr>
    <tr>
    	<td>密码：</td>
    	<td><input type="password" name="password" id="password" value="<?=$admin->password?>" /></td>
    </tr>
    <tr>
    	<td>确认密码：</td>
        <td><input type="password" name="repassword" id="repassword" value="<?=$admin->password?>" /></td>
    </tr>
	<tr><td><input type="submit" value="提交" /></td></tr>
</form>
</table>
</body>
</html>
