<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="http://static.comicyu.com/js/jquery.js"></script>
<script type="text/javascript" src="http://static.comicyu.com/js/ajax.js"></script>
<link href="<?=MEDIA_URL?>css/general.css" rel="stylesheet" type="text/css" />
<title>漫淘客商城</title>
</head>

<body>
<script>
function del() {
	if( !confirm('确定要删除么？') ) {
		return false;
	}
}
</script>

  <ul id="container">
    <li id="header">
      <h1>会员管理</h1>
      <div class="link"></div>
      <div id="desc">等级列表</div>
    </li>
  <li id="tips">
  	<a href="<?=URL?>index.php/admin/user/memberEdit">新增会员等级</a>
  </li>
</ul>
<span style="display:none" id="page"><?=$_GET['page']?></span>
<table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
<tr>
    <th width="150">名称</th>
    <th width="150">等级</th>
    <th width="150">打折</th>
    <th width="150">备注</th>
    <th width="150">操作</th>
</tr>
<?php
foreach ($page->objectList() as $v){
?>
<tr>
    <td><?=$v->mname?></td>
    <td><?=$v->level?></td>
	<td><?=$v->ratio?></td>
    <td><?=$v->des?></td>
    <td><a href="<?=URL?>index.php/admin/user/memberEdit?id=<?=$v->id?>">修改</a>
     | <a href="<?=URL?>index.php/admin/user/memberDel?id=<?=$v->id?>" onclick="return del();">删除</a>
    </td>
</tr>
<?php
}
?>
</table>
<?=$page->getHtml("?type=$type&act=$act")?>
</body>
</html>
