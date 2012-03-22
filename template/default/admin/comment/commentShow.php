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
function reply() {
	$('#reply1').css('display','');
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
function del( id, way ) {
	if( !confirm('确定要删除么？') ) {
		return false;
	}
	str = {id:id};
	$.get('<?=URL?>index.php/admin/comment/commentDelete?act='+way, str, function(data){
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
      <div id="desc">用户评论详情</div>
    </li>
  <li id="tips">
<table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
<tr>
    <strong>商品：<?=base::getGoodsName($comment->goodsid)?>
    ，<?=base::getUserName($comment->uid)?> 于 <?=date('Y-m-d H:i:s',$comment->createtime)?> 评价
    </strong>
</tr>
<tr>
    <td width="100">标题：</td>
    <td><?=$comment->title?></td>
</tr>
<tr>
    <td>分数：</td>
    <td><?=$comment->score?></td>
</tr>
<tr>
    <td>优点：</td>
    <td><?=$good?></td>
</tr>
<tr>
    <td>缺点：</td>
    <td><?=$bad?></td>
</tr>
<tr>
    <td>总结：</td>
    <td><?=$summary?></td>
</tr>
<tr id="reply1" style="display:none"><td colspan="2">
<input type="text" name="reply" id="commit<?=$comment->id?>" size="80" /> 
<input type="submit" onclick="return commit(<?=$comment->id?>);" value="回复" />
</td></tr>
</table>
<a href="javascript:void(0);" onclick="return del(<?=$comment->id?>, 'comment')">删除该评论</a> | <a href="javascript:void(0);" onclick="return reply();">回复</a>
</ul>
<table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
<?php
foreach ($page->objectList() as $v){
?>
<tr>
	<td><?=$v->reply?></td>
    <td><?=($v->uid !== '0') ? base::getUserName($v->uid) : '管理员'?> 于 <?=date('Y-m-d H:i:s',$v->replytime)?> 回复
     | <a href="javascript:void(0);" onclick="return del(<?=$v->id?>, 'reply')">删除此回复</a>
    </td>
</tr>
<?php
}
?>
</table>
<?=$page->getHtml("?id=$comment->id")?>
</body>
</html>
