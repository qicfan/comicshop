<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="http://static.comicyu.com/js/jquery.js"></script>
<script type="text/javascript" src="http://static.comicyu.com/js/ajax.js"></script>
<title><?=TITLE?> | 订单列表</title>
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
  <!-- 主要内容-->
  <div class="box_left">
    <div class="char_title3">
      <span id="tbm_1" class="<?=isset($tab['t1']) ? 'hover' : 'normal'?>tab3">
      	<a href="<?=URL?>index.php/front/userOrder/orderList?sort=last" style="color:#000000">近一个月订单</a>
      	(<span class="fn_red"><?=$count['t1']?></span>)
      </span>
      <span id="tbm_2" class="<?=isset($tab['t2']) ? 'hover' : 'normal'?>tab3">
      	<a href="<?=URL?>index.php/front/userOrder/orderList?sort=past" style="color:#000000">一个月前订单</a>
      	(<span class="fn_red"><?=$count['t2']?></span>)
      </span>
      <span id="tbm_3" class="<?=isset($tab['t3']) ? 'hover' : 'normal'?>tab3">
      	<a href="<?=URL?>index.php/front/userOrder/orderList?sort=wp" style="color:#000000">等待付款订单</a>
      	(<span class="fn_red"><?=$count['t3']?></span>)
      </span>
      <span id="tbm_4" class="<?=isset($tab['t4']) ? 'hover' : 'normal'?>tab3">
      	<a href="<?=URL?>index.php/front/userOrder/orderList?sort=done" style="color:#000000">已完成的订单</a>
      	(<span class="fn_red"><?=$count['t4']?></span>)
      </span>
      <span id="tbm_5" class="<?=isset($tab['t5']) ? 'hover' : 'normal'?>tab3">
      	<a href="<?=URL?>index.php/front/userOrder/orderList?sort=ab" style="color:#000000">已取消的订单</a>
      	(<span class="fn_red"><?=$count['t5']?></span>)
      </span>
      <span id="tbm_6" class="<?=isset($tab['t6']) ? 'hover' : 'normal'?>tab3">
      	<a href="<?=URL?>index.php/front/userOrder/orderList?sort=all" style="color:#000000">所有订单</a>
      	(<span class="fn_red"><?=$count['t6']?></span>)
      </span>
         
    </div>
    <div class="dis" id="tbcm_01">
      <table width="832" border="0" cellspacing="0" class="dd_li">
        <tr bgcolor="#e8e8e8" class="fn_hs">
          <td width="174" height="34" align="center">订单编号</td>
          <td width="127" align="center">订单金额</td>
          <td width="110" align="center">下单时间</td>
          <td width="100" align="center">收货人</td>
          <td width="116" align="center">支付方式</td>
          <td width="93" align="center">订单状态</td>
          <td width="94" align="center">操作</td>
        </tr>
        <?php
		foreach ($page->objectList() as $v) {
		?>
		<tr>
			<td height="49" align="center">
				<a href="<?=URL?>index.php/front/userOrder/orderDetail?id=<?=$v->id?>"><?=$v->order_sn?></a></td>
            <td align="center" class="fn_red b">￥<?=$v->goodsmount?>
            <?php
			if ($v->paystate == '0' && $v->orderstate != '2') {
			?>
				<br/><a href="<?=URL?>index.php/front/pay/orpay?oid=<?=$v->id?>"><img src="<?=MEDIA_URL?>img/front/xz_03.gif" /></a>
            <?php
			}
            ?></td>
			<td align="center"><?=date('Y-m-d H:i:s', $v->createtime)?></td>
			<td align="center"><?=$v->consignee?></td>			
			<td align="center"><?=orderFun::getPaytypeName($v->paytype)?></td> 
			<td align="center"><?=orderFun::getOrderstateName($v->orderstate)?></td>
			<td align="center">
            	<a href="<?=URL?>index.php/front/userOrder/orderDetail?id=<?=$v->id?>">查看</a>
            <?php
			if ($v->paystate == '0' && $v->orderstate != '2') {
			?>
				 | <a href="<?=URL?>index.php/front/pay/orpay?oid=<?=$v->id?>">付款</a>
            <?php
			}
            ?>
			</td>
		</tr>
		<?php
		}
		?>
        <tr>
        <tr>
          <td height="31" colspan="6" align="center">&nbsp;</td>
          <td align="center">
		  <?php
		  if ( !empty($page->dataCount) ) {
				echo $page->getHtml('?0');
			} else {
				echo '暂无';
			}
			?>
          </td>
        </tr>      
      </table>
    </div>
    <div class="undis" id="tbcm_02">   
    </div>
    <div class="undis" id="tbcm_03">3</div>
    <div class="undis" id="tbcm_04">4</div>
    <div class="undis" id="tbcm_05">5</div>
    <div class="undis" id="tbcm_06">6</div>

  </div>
  <!-- 主要内容结束-->
  


</div>
</body>
</html>
