<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="http://static.comicyu.com/js/jquery.js"></script>
<script type="text/javascript" src="http://static.comicyu.com/js/ajax.js"></script>
<title><?=TITLE?> | 交易记录</title>
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
    <div class="char_title">
      <span class="hovertab">交易记录</span>         
    </div>
    <div id="tbch_01">
      <div class="cx">
        <ul>
        <script language="javascript" type="text/javascript" src="<?=MEDIA_URL?>plugin/DatePicker/WdatePicker.js"></script>
        <form action="" method="post">
          <li>按时间查询
            <input class="kuang" name="date" type="text" onClick="WdatePicker()" /></li>
          <li>按订单号查询<input class="kuang" name="sn" type="text" /><input class="qr" name="提交" type="submit" value="查询" /></li>
        </form>
        </ul>
      </div>
      <table width="832" border="0" cellspacing="0" class="dd_li">
        <tr bgcolor="#e8e8e8" class="fn_hs">
          <td width="246" height="34" align="center">交易编号</td>
          <td width="122" align="center">订单编号</td>
          <td width="125" align="center">订购时间</td>
          <td width="96" align="center">订单金额</td>
          <td width="76" align="center">运费</td>
          <td width="92" align="center">支付金额</td>
          <td width="59" align="center">操作</td>
          
        </tr>
        <tr>     
        </tr>
        <?php
		foreach ($page->objectList() as $i=>$v) {
			if ($i == 0) {
				$flag = $v;
			}
		?>
		<tr>
			<td height="48" align="center"><?=$v->pay_sn?></td>
			<td align="center"><?=empty($v->order_sn) ? '已丢失' : $v->order_sn?></td>
            <td align="center"><?=empty($v->createtime) ? '-' : date('Y-m-d H:i:s', $v->createtime)?></td>					
			<td align="center" class="fn_14px fn_red b">￥<?=$v->payfee?></td>
			<td align="center">￥<?=empty($v->postfee) ? 0 : $v->postfee?></td>
            <td align="center" class="fn_14px fn_red b">￥<?=$v->pay?></td>
			<td align="center"><a href="<?=URL?>index.php/front/userOrder/orderDetail?id=<?=$v->orderid?>">查看</a>
			</td>
		</tr>
		<?php
		}
		?>
        <tr>
          <td height="40" colspan="2" align="center"><?=empty($flag) ? '暂无' : $page->getHtml("?date=$date&sn=$sn")?></td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
<!--          <td colspan="2" align="center">交易记录总数：<span class="fn_red b"></span></td>
          <td colspan="2" align="center">交易总金额：<span class="fn_red b"></span> </td>-->
        </tr>
      </table>
    
    </div>
    
  </div>
  <!-- 主要内容结束-->
  


</div>
</body>
</html>
