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
      <h1>收藏管理</h1>
      <div class="link"></div>
      <div id="desc">收藏列表</div>
  </li>
</ul>
<span style="display:none" id="page"><?=$_GET['page']?></span>
<table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
<tr>
	<th width="150">ID</th>
    <th width="250">商品名称</th>
    <th width="160">被收藏次数</th>
</tr>
<?php
foreach ($collect as $v){
?>
<tr>
	<td><?=$v['gid']?></td>
	<td><?=base::getGoodsName($v['gid'])?></td>
    <td><?=$v['count']?></td>
</tr>
<?php
}
?>
</table>
</body>
</html>
