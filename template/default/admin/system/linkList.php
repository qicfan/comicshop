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
function confirmDel() {
	if( !confirm('确定要删除么？') ) {
		return false;
	}
	return true;
}
</script>
  <ul id="container">
    <li id="header">
      <h1>友情链接管理</h1>
      <div class="link"></div>
      <div id="desc">友情链接列表</div>
    </li>
  <li id="tips">
  <a href="<?=URL?>index.php/admin/system/linkEdit">添加新的友情链接</a>
  </li>
</ul>
<table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
<tr>
    <th width="200">名称</th>
    <th width="200">链接</th>
    <th width="150">排序（值越小越靠前）</th>
    <th width="150">操作</th>
</tr>
<?php
foreach ($link as $v){
?>
<tr>
	<td><?=$v->title?></td>
    <td><a href="<?=$v->linkurl?>" target="_blank"><?=$v->linkurl?></a></td>
    <td><?=$v->sort?></td>
    <td>
    <a href="<?=URL?>index.php/admin/system/linkEdit?id=<?=$v->id?>">编辑</a>
	 | <a href="<?=URL?>index.php/admin/system/linkDelete?id=<?=$v->id?>" onclick="return confirmDel();">移除</a>
    </td>
</tr>
<?php
}
?>
</table>
</body>
</html>
