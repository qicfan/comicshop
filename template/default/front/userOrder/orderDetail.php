<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="http://static.comicyu.com/js/jquery.js"></script>
<script type="text/javascript" src="http://static.comicyu.com/js/ajax.js"></script>
<title><?=TITLE?> | 订单详情</title>
<link href="<?=MEDIA_URL?>css/mtk_yh.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?=MEDIA_URL?>js/hdm.js"></script>
</head>

<body>
<!-- 头部和导航 -->
<?php 
require_once(PRO_ROOT . 'template/default/front/include/top.php');
require_once(PRO_ROOT . 'template/default/front/include/nav2.php'); 
require_once(PRO_ROOT . 'template/default/front/include/user.php'); 
?>

<div class="box_left">
   <div class="ckd fn_14px b">查看订单详细信息</div>
   <div class="box_nei">
      
      <div class="xx_top">
        <h1><strong>订单信息</strong></h1>
        <ul>
          <li><span class="tim_z">订单编号：</span><?=$order->order_sn?></li>
          <li><span class="tim_z">订单状态：</span><?=empty($order->confirmtiem) ? '-' : date('Y-m-d H:i:s', $order->confirmtiem)?></li>
          <li><span class="tim_z">用户提交订单：</span><?=date('Y-m-d H:i:s', $order->createtime)?></li>
          <li><span class="tim_z">系统确认订单：</span><?=empty($order->confirmtiem) ? '-' : date('Y-m-d H:i:s', $order->confirmtiem)?></li>
          <li><span class="tim_z">发货时间：</span><?=empty($order->posttime) ? '-' : date('Y-m-d H:i:s', $order->posttime)?></li>
          <li><span class="tim_z">确认收货：</span><?=empty($order->accepttime) ? '-' : date('Y-m-d H:i:s', $order->accepttime)?></li>
        </ul>
      </div>
      
      <div class="xx_top">
        <h1><strong>收货人信息</strong></h1>
        <ul>
          <li><span class="tim_z">收货人：</span><?=$order->consignee?></li>
          <li><span class="tim_z">地区：</span><?=base::getRegionName($order->province)?>-<?=base::getRegionName($order->city)?>-<?=base::getRegionName($order->district)?></li>
          <li><span class="tim_z">地址：</span><?=$order->address?></li>
          <li><span class="tim_z">邮编：</span><?=$order->zipcode?></li>
          <li><span class="tim_z">固定电话：</span><?=$order->tel?></li>
          <li><span class="tim_z">手机号码：</span><?=$order->mobile?></li>
          <li><span class="tim_z">电子邮件：</span><?=$order->email?></li>
        </ul>
      </div>
      
      <div class="xx_top">
        <h1><strong>支付及配送方式</strong></h1>
        <ul>
          <li><span class="tim_z">支付方式：</span><?=orderFun::getPaytypeName($order->paytype)?></li>
          <li><span class="tim_z">运费：</span><?=$order->postfee?></li>
          <li><span class="tim_z">送货方式：</span><?=orderFun::getPosttypeName($order->posttype)?></li>
          <li><span class="tim_z">送货时间：</span><?=orderFun::getBesttimeName($order->besttime)?></li>
        </ul>
      </div>
      
      <div class="xx_top">
      <h1><strong>商品清单</strong></h1>
  <table width="820" border="0" cellspacing="0" id="ord">
    <tr bgcolor="#e8e8e8">
      <th height="32" align="center" width="300">商品名称</th>
      <th align="center" width="300">商品编号</th>
      <th align="center" width="150">商品单价</th>
      <th align="center" width="150">商品数量</th>
      <th align="center" width="100">备注</th>
    </tr>
	<?php
    foreach ($goods as $v) {
    ?>
    <tr>
        <td height="50" align="center"><?=$v->goodsname?></td>
        <td align="center"><?=$v->goods_sn?></td>
        <td align="center" class="fn_red"><?=$v->shoppirce?></td>
        <td align="center"><?=$v->goodscoutn?></td>
        <td align="center"><?=($v->goods_type == 1) ? '赠品' : '-'?></td>
        <td>
        </td>
    </tr>
    <?php
	}
	?>    
  </table>
  <div class="xx_top">
    <ul>
      <li><span class="tim_z">商品总价：</span>￥<?=$order->goodsmount?></li>
      <li><span class="tim_z">配送费用：</span>+￥<?=$order->postfee?></li>
      <li><span class="tim_z">包装费用：</span>+￥<?=$order->packagefee?></li>
      <li><span class="tim_z">优惠金额：</span>-￥<?=$order->cardfee?></li>
    </ul>
  </div>
  <div id="spz">应付金额：<span class="fn_red"><strong>￥<?=$order->goodsmount+$order->postfee+$order->packagefee-$order->cardfee?></strong></span></div>
  <div ><span class="tim_z">获得积分：</span><?=$order->integral?></div>
  </div>
   </div>

  </div>
</body>
</html>
