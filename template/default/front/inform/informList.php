<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<title>漫淘客商城</title>
</head>

<body>

<span style="display:none" id="page"><?=$_GET['page']?></span>
<table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
<tr>
    <th width="250">相关链接</th>
    <th width="150">举报者</th>
    <th width="150">相关商品</th>
    <th width="100">内容</th>
    <th width="160">举报时间</th>
    <th width="160">回复</th>
</tr>
<?php
foreach ($page->objectList() as $v){
?>
<tr>
	<td><a href="<?=$v->url?>"  target="_blank">查看</a></td>
    <td><?=base::getUserName($v->uid)?></td>
    <td><?=base::getGoodsName($v->gid)?></td>
    <td><?=$v->content?></td>
	<td><?=date('Y-m-d H:i:s',$v->questiontime)?></td>
    <td><?=empty($v->replytime) ? '-' : date('Y-m-d H:i:s',$v->replytime)?></td>


</tr>
<?php
}
?>
</table>
<?=$page->getHtml("?type=$type&act=$act")?>
</body>
</html>
