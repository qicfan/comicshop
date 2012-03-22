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
		<div id="desc">促销列表</div>
    </li>
    <li id="tips">
		<a href="<?=URL?>index.php/admin/promotion/proAddPage">添加促销</a>
	</li>
</ul>

<li id="wrapper">
	<table class="grid" cellspacing="0" cellpadding="4">
		<tr>
			<th>优惠活动名称</th>
			<th>开始时间</th>
			<th>结束时间</th>
			<th>活动类型</th>
			<th>操作</th>
		</tr>
		<?php
		foreach ($proinfo as $item) {
		?>
		<tr>
			<td>&nbsp;<?=$item->act_title?></td>
			<td>&nbsp;<?php echo date('Y-m-d H:i:s',$item->start_time);?></td>
			<td>&nbsp;<?php echo date('Y-m-d H:i:s',$item->stop_time);?></td>
			<td>&nbsp;
			<?php
				switch ($item->act_type){
					case 1:
						echo "全场优惠";
						break;
					case 2:
						echo "局部优惠";
						break;
				}
			?>
			</td>
			<td>
				<span class="hand"><a href="<?=URL?>index.php/admin/promotion/proSel?proid=<?=$item->id?>">查看</a></span>&nbsp;
				<span class="hand"><a href="<?=URL?>index.php/admin/promotion/proGoodsAddPage?proid=<?=$item->id?>">添加商品</a></span>&nbsp;
				<?php
					if($item->act_type != 1){
				?>
					<span class="hand"><a href="<?=URL?>index.php/admin/promotion/proDel?proid=<?=$item->id?>">删除</a></span>
				<?php
				}
				?>
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