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

  <ul id="container">
    <li id="header">
      <h1>统计中心</h1>
      <div class="link"></div>
      <div id="desc">销量明细</div>
    </li>
    <li id="tips">
      <a href="<?=URL?>index.php/admin/tongji/user">按订单数量排序</a>
       | <a href="<?=URL?>index.php/admin/tongji/user?sort=1">按订单金额排序</a>
    </li>
<li>

<table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">

<tr>
    <th>用户名</th>
    <th>通行证ID</th>
    <th>完成订单数量</th>
    <th>完成订单总额</th>
</tr>
<?php
foreach ($page->objectList() as $i=>$v) {
	$p = isset($_GET['page']) ? $_GET['page'] : 1;
	$p = ($p - 1) * 10;
?>
<tr>
    <td width="200"><span style="color:#999999"><?=$p+$i+1?></span> 
	<?=base::getUserName($v->uid)?></td>
    <td width="200"><?=$v->uid?></td>
    <td width="200"><?=$v->count?></td>
    <td width="200">￥<?=$v->sum?></td>
</tr>
<?php
}
?>
</table>
<?=$page->getHtml('?0')?>

</li>

	<li id="footer">
      <div>
      Copyright © 2010 comicyu.com All rights reserved.
      </div>
    </li>
</ul>
</body>
</html>
