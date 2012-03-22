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
	$(".input").focus( function(){
		this.style.color = 'red';
	});
	$(".input").blur( function(){
		this.style.color = 'black';
	});
});

function edit(id) {
	var name = $('#this'+id).val();
	str = {id:id, name:name};
	$.post('<?=URL?>index.php/admin/stock/logistics?act=edit', str, function(data){
		window.location.reload();
	});
}

function confirmDel() {
	if( !confirm('确定要删除么？') ) {
		return false;
	}
	return true;
}
</script>

  <ul id="container">
    <li id="header">
      <h1>库存管理</h1>
      <div class="link"></div>
      <div id="desc">物流商管理</div>
    </li>
  <li id="tips">
<form action="<?=URL?>index.php/admin/stock/logistics?act=add" method="post">
	添加新物流商：
    名称 <input type="text" name="name" id="name" value="" />
	<input type="submit" value="添加" />
</form>
  </li>
</ul>
<table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
<tr>
	<th width="100">编号</th>
    <th width="150">物流商名称</th>
    <th width="150">操作</th>
</tr>
<?php
foreach ($page->objectList() as $v){
?>
<tr>
	<td><?=empty($v->id) ? '-' : $v->id?></td>
	<td><input type="text" class="input" id="this<?=$v->id?>" value="<?=$v->lname?>" style="border:#DDDDDD 1px solid;" /></td>
    <td>
    <a href="javascript:void(0);" onclick="return edit('<?=$v->id?>');">更新名称</a>
     | <a href="<?=URL?>index.php/admin/stock/logistics?act=del&id=<?=$v->id?>" onclick="return confirmDel();">移除</a>
    </td>
</tr>
<?php
}
?>
</body>
</html>
