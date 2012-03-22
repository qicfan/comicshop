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
	var source = document.getElementById('source').value;
	if (source == '') {
		alert('请填写被屏蔽的词语');
		return false;
	}
}
</script>

  <ul id="container">
    <li id="header">
      <h1>评论管理</h1>
      <div class="link"></div>
      <div id="desc">屏蔽关键字</div>
    </li>
  <li id="tips">
<form action="" method="post" onsubmit="return verify();">
	添加屏蔽词语：将词语 <input type="text" name="source" id="source" value="" />
     屏蔽为 <input type="text" name="replace" id="replace" value="" /> 
	<input type="submit" value="确定" />
</form>
  </li>
</ul>
<table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
<tr>
    <th width="150">被屏蔽的词语</th>
    <th width="150">替换为</th>
    <th width="150">操作</th>
</tr>
<?php
foreach ($page->objectList() as $v){
?>
<tr>
	<td><?=$v->source?></td>
    <td><?=$v->replace?></td>
    <td>
	<a href="<?=URL?>index.php/admin/system/wordDelete?id=<?=$v->id?>">移除</a>
    </td>
</tr>
<?php
}
?>
</table>
<?=$page->getHtml("?0")?>
</body>
</html>
