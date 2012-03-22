<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>订单提示-【漫淘客】</title>
<link href="<?=URL?>media/css/mtk.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
	include_once(PRO_ROOT."template/default/front/include/nav1.php");
?>
<div id="line"></div>  
<!--头部结束-->

<div class="box4">
  <div class="zck">
    <h3><img src="<?=URL?>media/img/front/ord3.gif" /></h3>
    <div class="fn_16px b fn_red">订单已成功提交！</div>
    <p class="b fn_16px">您的订单<span class="fn_blue"><?=$orcode?></span>已经成功提交，请耐心等待卖家发货。</p>
    <p class="fn_14px fn_hs">如有疑问请咨询在线客服，或拨打客服电话400-500-8888。</p>
    <div>
		<a href="<?=URL?>index.php/front/order/orinfo"><img src="<?=URL?>media/img/front/return.gif" /></a>
		<a href="<?=URL?>index.php/front/pay/orpay?oid=<?=$oid?>">立即支付</a>
	</div>
  </div>
  <!--<div class="line2"></div>
   <div class="tj">
    <h2>根据您挑选的商品，漫淘客为您推荐</h2>
      <ul class="list_tj">
        <li><div class="img2"><img src="<?=URL?>media/img/front/tu2.gif" /></div><h6>夏天了！【凉宫春日】</h6><h4><span class="m2">￥85.00</span><span class="s">￥135.00</span></h4><h5><a href="#"><img src="<?=URL?>media/img/front/jrgw.gif" /></a></h5></li>
        <li><div class="img2"><img src="<?=URL?>media/img/front/tu2.gif" /></div><h6>夏天了！【凉宫春日】</h6><h4><span class="m2">￥85.00</span><span class="s">￥135.00</span></h4><h5><a href="#"><img src="<?=URL?>media/img/front/jrgw.gif" /></a></h5></li>
        <li><div class="img2"><img src="<?=URL?>media/img/front/tu2.gif" /></div><h6>夏天了！【凉宫春日】</h6><h4><span class="m2">￥85.00</span><span class="s">￥135.00</span></h4><h5><a href="#"><img src="<?=URL?>media/img/front/jrgw.gif" /></a></h5></li>
        <li><div class="img2"><img src="<?=URL?>media/img/front/tu2.gif" /></div><h6>夏天了！【凉宫春日】</h6><h4><span class="m2">￥85.00</span><span class="s">￥135.00</span></h4><h5><a href="#"><img src="<?=URL?>media/img/front/jrgw.gif" /></a></h5></li>
      </ul>
    </div>
	-->
</div>
</body>
</html>
