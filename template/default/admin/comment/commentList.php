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
function reply( id ) {
	$('#reply'+id).css('display','');
	$('#reply').focus();
	return false;
}
function commit( id ) {
	var reply = $('#commit'+id).val();
	if (reply == '') {
		alert('请填写内容');
		return false;
	}
	str = {id:id, reply:reply};
	$.post('<?=URL?>index.php/views/commentReply?act=admin', str, function(data){
		if (data == '1') {
			alert('回复成功');
			window.location.reload();
		} else {
			alert('回复失败');
		}
	});
	return false;
}
function del( id ) {
	if( !confirm('确定要删除么？') ) {
		return false;
	}
	str = {id:id};
	$.get('<?=URL?>index.php/admin/comment/commentDelete?act=comment', str, function(data){
		if (data == '1') {
			alert('删除成功');
			window.location.reload();
		} else {
			alert('删除失败');
		}
	});
	return false;
}
</script>

  <ul id="container">
    <li id="header">
      <h1>评论管理</h1>
      <div class="link"></div>
      <div id="desc">所有用户评论</div>
    </li>
</ul>
<table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
<tr>
    <th width="250">评论标题</th>
    <th width="120">评论者</th>
    <th width="120">被评论的商品</th>
    <th width="120">回复数量</th>
    <th width="160">评论时间</th>
    <?php
	if ( $verify ) {
	?>
    <th width="160">审核状态</th>
    <?php
	}
	?>
    <th width="150">操作</th>
</tr>
<?php
foreach ($page->objectList() as $i=>$v){
?>
<tr>
	<td><?=$v->title?></td>
    <td><?=base::getUserName($v->uid)?></td>
    <td><?=base::getGoodsName($v->goodsid)?></td>
    <td><?=$count[$i]?></td>
    <td><?=date('Y-m-d H:i:s',$v->createtime)?></td>
    <?php
	if ( $verify ) {
		if ($v->verify == '1') {
			echo '<td>已审核</td>';
		} else {
			echo '<td>未审核</td>';
		}
	}
	?>
    <td>
    <a href="<?=URL?>index.php/admin/comment/commentShow?id=<?=$v->id?>" target="_blank">查看</a>
     | <a href="javascript:void(0);" onclick="return reply(<?=$v->id?>)">回复</a>
	 | <a href="javascript:void(0);" onclick="return del(<?=$v->id?>)">删除</a>
    <?php
	if ( $verify ) {
	?>
     | <a href="<?=URL?>index.php/admin/system/verifyPs?id=<?=$v->id?>&act=comment">审核通过</a>
    <?php
	}
	?>
    </td>
</tr>
<tr id="reply<?=$v->id?>" style="display:none"><td colspan="6">
<input type="text" name="reply" id="commit<?=$v->id?>" size="80" />
<input type="submit" onclick="return commit(<?=$v->id?>);" value="回复" />
</td></tr>
<?php
}
?>
</table>
<?=$page->getHtml("?0")?>
</body>
</html>
