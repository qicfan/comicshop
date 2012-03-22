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
	var title = document.getElementById('title').value;
	var linkurl = document.getElementById('linkurl').value;
	if (title == '' || linkurl == '') {
		alert('请填写详情');
		return false;
	}
}
</script>

  <ul id="container">
    <li id="header">
      <h1>友情链接管理</h1>
      <div class="link"></div>
      <div id="desc">编辑友情链接</div>
    </li>
</ul>
<table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
<form action="<?=URL?>index.php/admin/system/linkEdit?id=<?=$id?>" method="post" onsubmit="return verify();">
	<tr>
	<td>名称</td><td><input type="text" name="title" id="title" value="<?=$link->title?>" size="30" /></td>
    <tr/>
    <tr>
    <td>链接</td><td><input type="text" name="linkurl" id="linkurl" value="<?=isset($link->linkurl) ? $link->linkurl : 'http://'?>" size="30" /></td>
    </tr>
    <tr>
    <td>排序</td><td><input type="text" name="sort" id="sort" value="" size="10" /></td>
	</tr>
	<tr><td colspan="2"><input type="submit" value="提交" /></td></tr>
</form>
</table>
</body>
</html>
