<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="http://static.comicyu.com/js/jquery.js"></script>
<script type="text/javascript" src="http://static.comicyu.com/js/ajax.js"></script>
<title><?=TITLE?> | 个人中心</title>
<link href="<?=MEDIA_URL?>css/mtk_yh.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?=MEDIA_URL?>js/hdm.js"></script>
</head>

<body>
<!-- 头部和导航 -->
<?php
require_once(PRO_ROOT . 'template/default/front/include/nav2.php'); 
require_once(PRO_ROOT . 'template/default/front/include/user.php'); 
?>
  <!-- 主体开始-->
  <div class="box_min">
    <div class="xx fn_bs">您上次的登录时间：<?=date('Y年m月d日 H:i:s',$user->lastlogintime)?></div>
    <div class="grx">
      <div class="tou"><img src="<?=MEDIA_URL?>img/front/normalvip.jpg" alt="头像" /></div>
      <div class="Detai">
        <h1 class="fn_14px b">您好！<span class="fn_red fn_16px"><?=$user->uname?></span> 欢迎您回来！</h1>
        <ul class="Deta_lis">
          <li>您目前的级别：<span class="fn_blue"><?=$member->mname?></span></li>
          <li></li>
          <li>帐户积分：<span class="fn_red"><?=$score?></span></li>
          <li>完成订单：<?=$orderDone?></li>
          <li>帐户余额：<span class="fn_red b">￥<?=empty($moeny) ? 0 : $money?></span></li>
          <li>总消费额：￥<?=empty($consume) ? 0 : $consume?></li>
        </ul>
      </div>
    </div>
    <div class="ts fn_blue b">消息提示： 　　 <span class="fn_red b"><?=$sm?></span>条未读短消息 　　<span class="fn_red b"><?=$qr?></span>个咨询回复 　　 <span class="fn_red b"><?=$wp?></span>个待付款订单</div>
    <div class="xx2 fn_14px b fn_hs">我的订单列表</div>
    <table width="669" border="0" cellspacing="0" class="dd_li">
       <tr bgcolor="#e8e8e8">
         <td width="164" height="34" align="center" nowrap="nowrap">订单编号</td>
         <td width="124" align="center">下单时间</td>
         <td width="96" align="center">收货人</td>
         <td width="125" align="center">支付方式</td>
         <td width="75" align="center">订单状态</td>
         <td width="74" align="center">操作</td>
       </tr>
       <tr>
       <?php
	   if ( !empty($order) ) {
	   ?>
         <td height="40" align="center"><?=$order->order_sn?></td>
         <td align="center"><?=date('Y-m-d', $order->createtime)?><br/><?=date('H:i:s', $order->createtime)?></td>
         <td align="center"><?=$order->consignee?></td>
         <td align="center"><?=($order->paytype == 1) ? '货到付款' : '网上付款'?></td>
         <td align="center"><?=orderFun::getOrderstateName($order->orderstate)?></td>
         <td align="center"><a href="<?=URL?>index.php/front/userOrder/orderDetail?id=<?=$order->id?>">详细</a></td>
       <?php } ?>
       </tr>
       <tr>
         <td height="31" colspan="4">&nbsp;</td>
         <td align="center"><a href="#"></a></td>
         <td align="center"><a href="<?=URL?>index.php/front/userOrder/orderList">更多订单&gt;&gt;</a></td>
       </tr>
    </table>
    <div class="xx3 fn_14px b fn_hs">待评价商品</div>
    <table width="669" border="0" cellspacing="0" id="pj">
      <tr bgcolor="#fefefe">
        <td width="201" height="34" align="center">商品名称</td>
        <td width="181" align="center">商品编号</td>
        <td width="182" align="center">本店售价</td>
        <td width="97" align="center">操作</td>
      </tr>     
      	<?php
		foreach ($wc as $v) {
		?>
        <tr>
        <td height="40" align="center"><?=$v->goodsname?></td>
        <td align="center"><?=$v->goods_sn?></td>
        <td align="center">￥<?=$v->shoppirce?></td>
        <td align="center"><a href="<?=URL?>index.php/front/usercomment/ucommentShow?gid=<?=$v->goodsid?>">评价</a></td>
        </tr>
        <?php
		}
		?>     
      <tr>
        <td height="31" colspan="3">&nbsp;</td>
        <td><a href="<?=URL?>index.php/front/usercomment/order">更多商品评价&gt;&gt;</a></td>
      </tr>
    </table>
    
    <div class="tj">
      <h2>根据您挑选的商品，漫淘客为您推荐</h2>
      <ul class="list_tj">
      <?php
	  $i = 0;
	  foreach ($reco as $j=>$v) {
	  	$i++;
		if ($i > 6) {
			break;
		}
      ?>
        <li><div class="img2">
        <a href="<?=URL?>html/goods/<?=$v->id?>.html"><img src="<?=$reco_pic[$j]?>" /></a></div>
        <h6><?=$v->goodsname?></h6><h4><span class="m2">￥<?=$v->shopprice?></span></h4>
        <h5><a href="<?=URL?>index.php/front/cart/cartInsert?gid=<?=$v->id?>&loca=2"><img src="<?=MEDIA_URL?>img/front/jrgw.gif" /></a></h5></li>
      <?php
	  }
	  ?>
      </ul>
    </div>
    
  </div>
  <!--主体结束-->
  
  <!--页面右侧-->
  <div class="yc">   
      <div class="title fn_bs b"><span class="more"><a href="<?=URL?>index.php/front/article/articleList">更多</a></span>漫淘客快讯</div>
      <div class="div">
        <ul>
        <?php
		foreach ($article as $v) {
		?>
          <li><a href="<?=URL?>html/article/<?=$v->id?>.html"><?=$v->title?></a></li>
        <?php
		}
		?>
        </ul>
      </div>
      
      <div class="title fn_bs b">会员帮助</div>
      <div class="div">
        <ul>
          <li><a href="#none">快递运输区域和运费
  是多少？  </a></li>
          <li><a href="#none">如何进行在线支付？ </a></li>
          <li><a href="#none">如何得到优惠券？</a></li>
          <li><a href="#none">售出商品进行保修吗？</a></li>
          <li><a href="#none">买商品后如何获发票？</a></li>
          <li><a href="#none">什么是商品价格？</a></li>
        </ul>
      </div>
      
      <div class="title fn_bs b">会员帮助</div>
      <div class="div">
        <p>您对“漫淘客商城”还满意吗？</p>
        <p>还希望我们为您提供什么样的功能？欢迎您提出意见和建议。</p>
        <textarea class="jy"></textarea><br />
        <input type="submit" value="提交" />
      </div>
    
  </div>
  <!--页面右侧结束-->
  
</div>
</body>
</html>
