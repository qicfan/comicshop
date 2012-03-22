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
		<div id="desc">缺货记录</div>
    </li>
    <li id="tips">
		<a href="<?=URL?>index.php/admin/promotion/proAddPage">商品列表</a>
	</li>
</ul>

<li id="wrapper">
	<table class="grid" cellspacing="0" cellpadding="4">
		<tr>
			<th>商品编号</th>
			<th>商品名</th>
			<th>商品数量</th>
			<th>生产商</th>
			<th>供货商</th>
		</tr>
		<?php
		foreach ($ginfo as $item){
		?>
		<tr>
			<td>&nbsp;<?=$item->goods_sn?></td>
			<td>&nbsp;<?=$item->goodsname?></td>
			<td>&nbsp;<?=$item->leavingcount?></td>
			<td>&nbsp;<?=$item->pname?></td>
			<td>&nbsp;<?=$item->suppliername?></td>
		</tr>
		<?php
		}
		?>
	</table>
	<div><?=$page?></div>
</li>
</body>
</html>