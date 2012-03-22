<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$webTitle;?></title>
<script src="http://static.comicyu.com/js/jquery.js" type="text/javascript"></script>
<link href="<?=MEDIA_URL?>css/mtk_yh.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?=MEDIA_URL?>js/hdm.js"></script>
<script type="text/javascript">
function ck111(){
	var url="<?=URL?>index.php/front/usercoupon/usedCoupon";
	$.get(url,{},function(data){
		var data = eval(data);
		for(i=0;i<data.length;i++){
			var code = data[i].code;
			
			var info='<tr bgcolor="#e8e8e8" class="fn_hs"><td width="104" height="34" align="center">类别</td><td width="201" align="center">'+data[i].code+'</td><td width="113" align="center">面值</td><td width="130" align="center">开始时间</td><td width="150" align="center">结束时间</td><td width="120" align="center">使用状态</td></tr>';
			$("#table2").append(info);
	}
});
}
</script>

</head>	
<body>
<?php require_once(PRO_ROOT . 'template/default/front/include/nav2.php');?>
<?php require_once(PRO_ROOT . 'template/default/front/include/user.php');?>
    <!-- 主要内容-->
  <div class="box_left">
    <div class="char_title3">
      <span id="tbt_1" class="hovertab3" onclick="x:HoverLin(1);">未使用的优惠券</span>
      <span id="tbt_2" class="normaltab3" onclick="i:HoverLin(2);ck111();">已使用的优惠券</span>
      <span id="tbt_3" class="normaltab3" onclick="i:HoverLin(3);">已过期的优惠券</span>
      <span id="tbt_4" class="normaltab3" onclick="i:HoverLin(4);">激活优惠券</span>
         
    </div>
    <div class="dis" id="tbct_01">
<?php
	$vcount=0;
	$wcount=0;
	$ycount=0;
?>	
	
	<table width="832" border="0" cellspacing="0" class="dd_li">
        <tr bgcolor="#e8e8e8" class="fn_hs">
          <td width="104" height="34" align="center">类别</td>
          <td width="201" align="center">编号</td>
          <td width="113" align="center">面值</td>
          <td width="130" align="center">开始时间</td>
          <td width="150" align="center">结束时间</td>
          <td width="120" align="center">使用状态</td>
        </tr>
<?php  foreach($manager as $i=>$v){ 
		if($v->state==1){
		$vcount++;
?>
<tr>
    <td height="40" align="center">优惠券</td>
	<td align="center"><?=$v->code;?></td>
	<td align="center"><?=$v->fee?><img src="<?=MEDIA_URL?>img/front/mz_03.gif" /></td>
	<td align="center"><?php echo date("Y-m-d G:i:s",$v->starttime);?></td>
	<td align="center"><?php echo date("Y-m-d G:i:s",$v->deadline);?></td>
	<td align="center"><?php if($v->state==1){ echo '未使用';}else{echo '已使用';}?></td>
</tr>
 <?php }
 
 
 }?>       

        <tr>
          <td height="31" align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td colspan="2" align="center">未使用的优惠券总数：<span class="fn_red b"><?=$vcount;?></span></td>
        </tr>
      </table>
    </div>
    <div class="undis" id="tbct_02">
      <table width="832" border="0" cellspacing="0" class="dd_li" id="table2">
        <tr bgcolor="#e8e8e8" class="fn_hs">
          <td width="104" height="34" align="center">类别</td>
          <td width="201" align="center">编号</td>
          <td width="113" align="center">面值</td>
          <td width="130" align="center">开始时间</td>
          <td width="150" align="center">结束时间</td>
          <td width="120" align="center">使用状态</td>
        </tr>
<?php  foreach($manager as $j=>$w){ 
			if($w->state == 2){
				$wcount++;
?>
	
<tr>
    <td height="40" align="center">优惠券</td>
	<td align="center"><?=$w->code;?></td>
	<td align="center"><?=$w->fee?><img src="<?=MEDIA_URL?>img/front/mz_03.gif" /></td>
	<td align="center"><?php echo date("Y-m-d G:i:s",$w->starttime);?></td>
	<td align="center"><?php echo date("Y-m-d G:i:s",$w->deadline);?></td>
	<td align="center"><?php if($w->state==2){ echo '已使用';}else{echo '未使用';}?></td>
</tr>
 <?php } }?>       

        <tr>
          <td height="31" align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td colspan="2" align="center">已使用的优惠券总数：<span class="fn_red b"><?=$wcount;?></span></td>
        </tr>
        
      </table>
    
    </div>
    <div class="undis" id="tbct_03">      <table width="832" border="0" cellspacing="0" class="dd_li">
        <tr bgcolor="#e8e8e8" class="fn_hs">
          <td width="104" height="34" align="center">类别</td>
          <td width="201" align="center">编号</td>
          <td width="113" align="center">面值</td>
          <td width="130" align="center">开始时间</td>
          <td width="150" align="center">结束时间</td>
          <td width="120" align="center">使用状态</td>
        </tr>
<?php  foreach($manager as $k=>$y){

			if($y->deadline < $ntime){
				$ycount++;
				
?>
	
<tr>
    <td height="40" align="center">优惠券</td>
	<td align="center"><?=$y->code;?></td>
	<td align="center"><?=$y->fee?><img src="<?=MEDIA_URL?>img/front/mz_03.gif" /></td>
	<td align="center"><?php echo date("Y-m-d G:i:s",$y->starttime);?></td>
	<td align="center"><?php echo date("Y-m-d G:i:s",$y->deadline);?></td>
	<td align="center">已过期</td>
</tr>
 <?php } }?>       

        <tr>
          <td height="31" align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td colspan="2" align="center">已使用的优惠券总数：<span class="fn_red b"><?=$ycount;?></span></td>
        </tr>
        
      </table></div>
    <div class="undis" id="tbct_04">
      <div class="bk nei">
      <form action="<?=URL?>index.php/front/usercoupon/cpAdd" method="post">
 激活优惠券：<input type="text" id="cpcode" name="cpcode" /><input type="submit"  value="提交"/>
</form><span class="fn_hs">(请输入优惠券激活密码)</span>
       <div class="yh_ts">
         <span class="fn_red">提示：</span>如果您想将优惠券转让给他人使用，可将优惠券激活密码发给他人，其他用户在我的漫淘客 > 优惠券 > 激活优惠券 页面进行激活。 
      如果您有优惠券激活密码，可以输入到上面的输入框，点击激活按纽进行激活，激活后该优惠券将与您的帐户绑定，不能转让。 
       </div>
      </div>
    
    </div>

  </div>
  <!-- 主要内容结束-->
  


</div>
</body>

</html>
