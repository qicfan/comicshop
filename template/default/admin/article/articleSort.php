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
	$("#sort").change( function(){
		window.location.href = '<?=URL?>index.php/admin/article/articleSort?sort='+$("#sort").val();
	});
	
	//选择分类
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
	$.post('<?=URL?>index.php/admin/article/articleSort?act=edit', str, function(data){
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
      <h1>文章管理</h1>
      <div class="link"></div>
      <div id="desc">分类管理</div>
    </li>
  <li id="tips">
<form action="<?=URL?>index.php/admin/article/articleSort?act=add" method="post">
	添加新分类：
    上级ID <input type="text" name="pid" id="pid" value="" size="5" />
     | 分类名称 <input type="text" name="name" id="name" value="" />
	<input type="submit" value="添加" />
</form>
  </li>
</ul>
<table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
<tr>
	<th colspan="4">
    <select name="sort" id="sort">
    <option>选择分类...</option>
    <?=other::getArticleTree();?>
    </select>
	</th>
</tr>
<tr>
	<th width="100">ID</th>
    <th width="100">上级ID</th>
    <th width="150">分类名称</th>
    <th width="150">操作</th>
</tr>
<tr>
	<td><?=empty($sort->id) ? '-' : $sort->id?></td>
    <td><?=empty($sort->parentid) ? '-' : $sort->parentid?></td>
	<td><input type="text" class="input" id="this<?=$sort->id?>" value="<?=$sort->sortname?>" style="border:#DDDDDD 1px solid;" /></td>
    <td>
    <a href="javascript:void(0);" onclick="return edit('<?=$sort->id?>');">更新名称</a>
     | <a href="<?=URL?>index.php/admin/article/articleSort?act=del&id=<?=$sort->id?>" onclick="return confirmDel();">移除</a>
    </td>
</tr>
</body>
</html>
