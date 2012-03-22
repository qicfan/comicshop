<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>漫淘客商城</title>
<script type="text/javascript" src="http://static.comicyu.com/js/jquery.js"></script>
<script type="text/javascript" src="http://static.comicyu.com/js/ajax.js"></script>
<script type="text/javascript" src="<?=MEDIA_URL?>plugin/OFC/swfobject.js"></script>
<script type="text/javascript">
swfobject.embedSWF(
  "<?=MEDIA_URL?>plugin/OFC/open-flash-chart.swf", "chart1",
  "550", "200", "9.0.0", "expressInstall.swf",
  {"data-file":"<?=URL?>index.php/admin/tongji/moneyJSON_1"} );
swfobject.embedSWF(
  "<?=MEDIA_URL?>plugin/OFC/open-flash-chart.swf", "chart2",
  "200", "200", "9.0.0", "expressInstall.swf",
  {"data-file":"<?=URL?>index.php/admin/tongji/moneyJSON_2"} );
</script>
<link href="<?=MEDIA_URL?>css/general.css" rel="stylesheet" type="text/css" />
<style>
.line_char {
	background-color:#999999;
	height:10px;
	padding-left:1px;
}
</style>
</head>

<body>

  <ul id="container">
    <li id="header">
      <h1>统计中心</h1>
      <div class="link"></div>
      <div id="desc">资金明细</div>
    </li>
    <li id="tips">
    <form action="" method="post">
    收入明细查询：
    <select name="year">
    <?php
	for ($i = 2010; $i < 2040; $i++) {
	?>
    	<option value="<?=$i?>"><?=$i?>年</option>
    <?php
	}
	?>
    </select>
    <input type="submit" value="查询" />
    </form>
   </li>
<li>

<table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
<tr>
    <th width="200">完成的订单总额：<strong>￥<?=$amount?></strong></th>
</tr>
<tr>
	<td><strong><?=$year?>年总收入：￥<?=$yearMoney?></strong></td>
</tr>
<tr>
	<td><?=$year?>年每月收入情况示意图<br/><div id="chart1"></div>
    &nbsp;<div id="chart2"></div></td>
</tr>
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
