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
$(document).ready(function(){
	//选择分类
	$("#type").change( function(){
		window.location.href = '<?=URL?>index.php/admin/quiz/quizList?type='+$("#type").val();
	});
});

function confirmDel() {
	if ( !confirm('确定要删除么？') ) {
		return false;
	}
	return true;
}
</script>

  <ul id="container">
    <li id="header">
      <h1>供货商管理</h1>
      <div class="link"></div>
      <div id="desc">供货商列表</div>
    </li>
  <li id="tips">
    <a href="<?=URL?>index.php/admin/supply/supplyEdit">添加供货商</a>
  </li>
</ul>
<span style="display:none" id="page"><?=$_GET['page']?></span>
<table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
<tr>
    <th width="100">编号</th>
    <th width="250">供货商名称</th>
    <th width="250">供货商地址</th>
    <th width="150">联系方式</th>
    <th width="150">联系人</th>
    <th width="150">备注</th>
    <th width="100">操作</th>
</tr>
<?php
foreach ($page->objectList() as $v){
?>
<tr>
	<td><?=$v->id?></td>
    <td><?=$v->suppliername?></td>
    <td><?=$v->addr?></td>
    <td><?=$v->con_way?></td>
    <td><?=$v->con_man?></td>
	<td><?=$v->des?></td>
    <td><a href="<?=URL?>index.php/admin/supply/supplyEdit?id=<?=$v->id?>">编辑</a>
     | <a href="<?=URL?>index.php/admin/supply/supplyDelete?id=<?=$v->id?>" onclick="return confirmDel();">移除</a>
    </td>
</tr>
<?php
}
?>
</table>
<?=$page->getHtml("?type=$type")?>
</body>
</html>
