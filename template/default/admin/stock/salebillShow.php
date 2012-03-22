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
</script>

  <ul id="container">
    <li id="header">
      <h1>库存管理</h1>
      <div class="link"></div>
      <div id="desc">出库单查看</div>
    </li>
</ul>
<table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
<tr><th colspan="4" style="background-color:#EEEEEE">基本信息</th></tr>
<tr>
	<td width="150"><strong>发货单流水号：</strong></td>
	<td width="200"><?=$bill->iid?></td>
    <td width="150"><strong>订单号：</strong></td>
	<td width="200"><?=$order->order_sn?></td>
</tr>
<tr>
	<td width="150"><strong>购货人：</strong></td>
	<td width="200"><?=base::getUserName($order->uid)?></td>
    <td width="150"><strong>发货单状态：</strong></td>
	<td width="200"><?=supply::getBillState($bill->state)?></td>
</tr>
<tr>
	<td width="150"><strong>下单时间：</strong></td>
	<td width="200"><?=date('Y-m-d H:i:s', $bill->billtime)?></td>
    <td width="150"><strong>发货时间：</strong></td>
	<td width="200"><?=empty($bill->outtime) ? '-' : date('Y-m-d H:i:s',$bill->outtime)?></td>
</tr>
<tr>
	<td width="150"><strong>配送方式：</strong></td>
	<td width="200"><?=supply::getPostType($posttype)?></td>
    <td width="150"><strong>缺货处理：</strong></td>
	<td width="200"></td>
</tr>
<tr>
	<td width="150"><strong>配送费用：</strong></td>
	<td width="200"><?=$order->postfee?></td>
    <td width="150"><strong>包装费用：</strong></td>
	<td width="200"><?=$order->packagefee?></td>
</tr>
<tr>
	<td width="150"><strong>物流公司：</strong></td>
	<td width="200"><?=supply::getLogisticsName($bill->lid)?></td>
    <td width="150"><strong>快递单号：</strong></td>
	<td width="200"><?=$bill->express?></td>
</tr>

<tr><th colspan="4" style="background-color:#EEEEEE">收货人信息</th></tr>
<tr>
	<td width="150"><strong>收货人：</strong></td>
	<td width="200"><?=$order->consignee?></td>
    <td width="150"><strong>电子邮件：</strong></td>
	<td width="200"><?=$order->email?></td>
</tr>
<tr>
	<td width="150"><strong>地址：</strong></td>
	<td width="200"><?=$order->address?></td>
    <td width="150"><strong>邮编：</strong></td>
	<td width="200"><?=$order->zipcode?></td>
</tr>
<tr>
	<td width="150"><strong>电话：</strong></td>
	<td width="200"><?=$order->tel?></td>
    <td width="150"><strong>手机：</strong></td>
	<td width="200"><?=$order->moblie?></td>
</tr>
<tr>
	<td width="150"><strong>最佳送货时间：</strong></td>
	<td width="200"><?=supply::getBestTime($order->besttime)?></td>
    <td width="150"><strong></strong></td>
	<td width="200"></td>
</tr>

<tr><th colspan="4" style="background-color:#EEEEEE">商品信息</th></tr>
<tr>
	<th>商品名称</th>
    <th>货号</th>
    <th>数量</th>
    <th>库存余量</th>
</tr>
<?php
foreach ($goods as $v) {
?>
<tr>
	<td><?=$v->goodsname?></td>
    <td><?=$v->goods_sn?></td>
    <td><?=$v->goodscoutn?></td>
    <td>
    <?php
	$lv = Ware::getGoodsLevaing($v->goodsid);
	echo $lv;
	if ($v->goodscoutn > $lv) {
		echo '<span class="note">库存余量不足</span>';
	}
	?>
    </td>
</tr>
<?php
}
?>

<?php
AdminAuth::AuthAdmin();
if ( AdminAuth::AdminCheck(92, 1) ) {
	if ($bill->state != 1) {
?>
<tr><th colspan="4" style="background-color:#990000; color:#FFFFFF">发货</th></tr>
<form action="" method="post">
<tr>
	<td><strong>操作人：</strong></td>
    <td><?=$name?></td>
</tr>
<tr>
	<td><strong>发货备注：</strong></td>
    <td><textarea name="remark" id="remark" ></textarea></td>
</tr>
<tr>
	<td colspan="2"><input type="submit" value="发货" /></td>
</tr>
</form>
<?php
	} else {
?>
		<tr><th>【已发货】</th></tr>
		<tr><td><strong>备注：</strong></td><td><?=$bill->remark?></td></tr>
<?php
	}
}
?>

</table>
<hr/>
</body>
</html>
