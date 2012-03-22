<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?=MEDIA_URL?>css/general.css" rel="stylesheet" type="text/css" />
<style>
.hand{
	cursor:pointer;
}
</style>
</head>
<body>
<ul id="container">
	<li id="header">
		<h1>管理员管理</h1>
		<div class="link"></div>
		<div id="desc">商品促销列表</div>
    </li>
    <li id="tips">
		<a href="<?=URL?>index.php/admin/promotion/proGoodsAddPage">添加促销商品</a>
	</li>
</ul>

<li id="wrapper">
	<table class="grid" cellspacing="0" cellpadding="4">
		<tr>
			<th>商品编号</th>
			<th>商品名称</th>
			<th>促销活动名称</th>
			<th>开始时间</th>
			<th>结束时间</th>
			<th>操作</th>
		</tr>
		<?php
		foreach ($proinfo as $item) {
		?>
		<tr>
			<td><?=$item->goods_sn?></td>
			<td><?=$item->goodsname?></td>
			<td><?=$item->act_title?></td>
			<td><?php echo date('Y-m-d H:i:s',$item->start_time);?></td>
			<td><?php echo date('Y-m-d H:i:s',$item->stop_time);?></td>
			<td>
				<span style="cursor:pointer;" onclick="{location.href='<?=URL?>index.php/admin/promotion/proGoodsDel?gproid=<?=$item->gaid?>'}">删除</span>
			</td>
		</tr>
		<?php
		}
		?>
	</table>
	<div>
		<?=$page?>
	</div>
</li>
</body>
</html>