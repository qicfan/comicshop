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
function verify() {
	var name = document.getElementById('name').value;
	var des = document.getElementById('des').value;
	if (name == '' || des == '') {
		alert('请填写详情');
		return false;
	}
}
</script>

  <ul id="container">
    <li id="header">
      <h1>供货商管理</h1>
      <div class="link"></div>
      <div id="desc">编辑供货商信息</div>
    </li>
</ul>
<table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
<form action="<?=URL?>index.php/admin/supply/supplyEdit?id=<?=$id?>" method="post" onsubmit="return verify();">
	<tr>
	<td><strong>名称</strong></td>
    <td><input type="text" name="name" id="name" value="<?=$supply->suppliername?>" size="60" /></td>
    <tr/>
    <tr>
    <td><strong>地址</strong></td>
    <td><input type="text" name="addr" id="addr" value="<?=$supply->addr?>" size="60" /></td>
    </tr>
    <tr>
    <td><strong>联系方式</strong></td>
    <td><input type="text" name="con_way" id="con_way" value="<?=$supply->con_way?>" size="60" /></td>
    </tr>
    <tr>
    <td><strong>联系人</strong></td>
    <td><input type="text" name="con_man" id="con_man" value="<?=$supply->con_man?>" size="60" /></td>
    </tr>
    <tr>
    <td><strong>备注</strong></td>
    <td><input type="text" name="des" id="des" value="<?=$supply->des?>" size="60" /></td>
    </tr>
	<tr><td colspan="2"><input type="submit" value="提交" /></td></tr>
</form>
</table>
</body>
</html>
