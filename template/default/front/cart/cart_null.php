<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>购物车-【漫淘客】</title>
<link href="<?=URL?>media/css/mtk.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=URL?>media/js/jquery-1.3.2.min.js"></script>
</head>

<body>
<!-- 网页头部 -->
<?php
	include_once(PRO_ROOT."template/default/front/include/nav1.php");
?>
<div id="line"></div>  
<!--头部结束-->
<div class="box4">
  <h1><img src="<?=URL?>media/img/front/order.gif" /></h1>
  <div class="order_top fn_14px b fn_hs">我已挑选的商品</div>
  <table width="912" border="0" cellspacing="0" id="ord">
    <tr bgcolor="#e8e8e8">
      <td width="55" height="35">　</td>
      <td width="119" align="center"></td>
      <td width="60" align="center"></td>
      <td width="108" align="center"></td>
      <td width="101" align="center"></td>
      <td width="62" align="center"></td>
      <td width="97" align="center"></td>
      <td width="100" align="center"></td>
    </tr>
    <tr>
      <td height="50" colspan="8" align="center" class="fn_16px b fn_hs">还没有挑选任何商品</td>
    </tr>
     <tr bgcolor="#E8E8E8">
      <td height="50" colspan="8" align="center">
        <table border="0" align="right" cellspacing="0" id="jq" class="fn_hs">
          <tr>
            <td width="121" align="left" valign="middle" ><h3>您共节省：<span class="fn_red">￥0.00</span></h3>
            <h3>获得积分：<span class="fn_red">0</span></h3></td>
            <td width="202" valign="middle" id="jq_td" class="fn_16px b">商品金额总计：<span class="fn_red">￥</span></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <table width="912" border="0" cellspacing="0" id="cz">
    <tr>
      <td width="35" valign="bottom"></td>
      <td width="12"><img src="<?=URL?>media/img/front/wj.gif" /></td>
      <td width="78"><a href="#">我的收藏夹</a></td>
      <td width="8"><img src="<?=URL?>media/img/front/ds_05.gif" /></td>
      <td width="475"><a href="#">清空购物车</a></td>
      <td width="134"><a href="<?=URL?>index.php"><img src="<?=URL?>media/img/front/jx_03.gif" /></a></td>
      <td width="118">&nbsp;</td>
      <td width="36"></td>
    </tr>
  </table>
  <div class="line2"></div>
</div>
</body>
</html>
