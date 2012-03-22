<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="http://static.comicyu.com/js/jquery.js"></script>
<script type="text/javascript" src="http://static.comicyu.com/js/ajax.js"></script>
<title><?=TITLE?> | 我的积分</title>
<link href="<?=MEDIA_URL?>css/mtk_yh.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?=MEDIA_URL?>js/hdm.js"></script>
</head>

<body>
<!-- 头部和导航 -->
<?php
require_once(PRO_ROOT . 'template/default/front/include/nav2.php'); 
require_once(PRO_ROOT . 'template/default/front/include/user.php'); 
?>
  <!-- 主要内容-->
  <div class="box_left">
    <div class="char_title">
      <span id="tbh_1" class="normaltab" onclick="x:HoverLih(1);" onmouseover="this.style.cursor='hand'">我的积分</span>
      <span id="tbh_2" class="hovertab" onclick="i:HoverLih(2);" onmouseover="this.style.cursor='hand'">积分明细</span>
      <span id="tbh_3" class="normaltab" onclick="i:HoverLih(3);" onmouseover="this.style.cursor='hand'">我的兑奖记录</span>
         
    </div>
    <div class="undis" id="tbch_01">
      您的现有积分：<?=$integral?>
    </div>
    <div class="dis" id="tbch_02">
      <table width="832" border="0" cellspacing="0" class="dd_li">
        <tr bgcolor="#e8e8e8" class="fn_hs">
          <td width="40%" height="34" align="center">订单编号</td>
          <td width="30%" align="center">获得积分</td>
          <td width="30%" align="center">订购时间</td>       
        </tr>
        <?php
		foreach ($page->objectList() as $i=>$v) {
			if ($i == 0) {
				$flag = $v;
			}
		?>
		<tr>
			<td height="40" align="center">
				<a href="<?=URL?>index.php/front/userOrder/orderDetail?id=<?=$v->id?>"><?=$v->order_sn?></td>
            <td height="40" align="center"><span class="fn_greed b"><?=$v->integral?></span></td>
			<td height="40" align="center"><?=date('Y-m-d H:i:s', $v->createtime)?></td>			
		</tr>
		<?php
		}
		?>  
        <tr>
          <td height="31" align="center"><span class="fn_hs"><?=empty($flag) ? '暂无' : $page->getHtml('?0')?></span></td>
          <td align="center">&nbsp;</td>
          <td colspan="7" align="center">您目前总积分为：<span class="fn_greed b"><?=$integral?></span></td>
        </tr>
      </table>
    </div>
    <div class="undis" id="tbch_03">暂无</div>

  </div>
  <!-- 主要内容结束-->
  


</div>
</body>
</html>
