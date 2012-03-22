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
      <h1>管理中心</h1>
      <div class="link"></div>
      <div id="desc">漫淘客商城管理中心</div>
    </li>
    <li id="tips">
    <span><?=$uname?>，欢迎！ 您是：
    <?php
	if ( empty($des) ) {
		echo '自定义权限的管理员';
	} else {
		echo $des;
	}
    ?>
    </span>
   </li>
<li>

<table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">

<tr>
    <th colspan="4">订单统计信息</th>
</tr>
<tr>
    <td width="200">待发货的出库单：<strong><?=$bill?></strong></td>
    <td width="200">配货中的订单：<strong><?=$order['carry']?></strong></td>
    <td width="200">未付款的订单：<strong><?=$order['nopayment']?></strong></td>   
    <td width="200">已付款的订单：<strong><?=$order['payment']?></strong></td>
</tr>
<tr><td colspan="4"></td></tr>

<tr>
    <th colspan="4">商品统计信息</th>
</tr>
<tr>
    <td width="200">缺货的商品：<strong><?=$goodsOut?></strong></td>
    <td width="200"></td>
    <td width="200"></td>
    <td width="200"></td>
</tr>
<tr><td colspan="4"></td></tr>

<tr>
    <th colspan="4">客服中心统计信息</th>
</tr>
<tr>
    <td width="200">待回复的留言：<strong><?=$quiz?></strong></td>
    <td width="200"></td>
    <td width="200"></td>
    <td width="200"></td>
</tr>
<tr><td colspan="4"></td></tr>

</table>

</li>

	<li id="footer">
      <div>
      Copyright © 2010 comicyu.com All rights reserved.
      </div>
    </li>
</ul>
</body>
</html>
