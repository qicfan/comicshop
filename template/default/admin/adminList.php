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
//删除
function Del(id) {
	if (confirm('确定要删除该管理员么？')){
		$.post('<?=URL?>index.php/admin/admin/adminSubmit?act=del&id='+id, '', function(data){
			if (data == '1') {
				alert('删除成功');
			} else {
				alert('删除失败');
			}
			window.location.reload();
		});
	}
	return false;
}
</script>

  <ul id="container">
    <li id="header">
      <h1>管理员管理</h1>
      <div class="link"></div>
      <div id="desc">管理员列表</div>
    </li>
    <li id="tips">
    <a href="<?=URL?>index.php/admin/admin/adminEdit">添加新的管理员</a>
  </li>
</ul>
<span style="display:none" id="page"><?=$_GET['page']?></span>
<table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
<tr>
	<th width="150">用户名</th>
    <th width="160">真实姓名</th>
    <th width="160">电子邮件</th>
    <th width="160">权限描述</th>
    <th width="150">操作</th>
</tr>
<?php
foreach ($page->objectList() as $v){
?>
<tr>
	<td><?=$v->uname?></td>
    <td><?=$v->realname?></td>
	<td><?=$v->email?></td>
    <td><?=empty($v->des) ? '自定义权限' : $v->des?></td>
    <td>
	<a href="<?=URL?>index.php/admin/admin/adminLimit?id=<?=$v->id?>">分派权限</a>
     | <a href="<?=URL?>index.php/admin/admin/adminEdit?id=<?=$v->id?>">编辑</a>
     | <a href="javascript:void(0);" onclick="return Del(<?=$v->id?>);">删除</a>
    </td>
</tr>
<?php
}
?>
</table>
<?=$page->getHtml("?0")?>
</body>
</html>
