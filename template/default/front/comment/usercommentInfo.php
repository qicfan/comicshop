<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$webTitle;?></title>
<link href="<?=MEDIA_URL?>css/mtk_yh.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?=MEDIA_URL?>js/hdm.js"></script>

</head>

<body>
<?php require_once(PRO_ROOT . 'template/default/front/include/nav2.php');?>
<?php require_once(PRO_ROOT . 'template/default/front/include/user.php');?>
<!-- 主要内容-->
  <div class="box_left">
    <div class="char_title">
      <span id="tbs_1" class="hovertab" onclick="x:HoverLis(1);">商品评价</span>
      <span id="tbs_2" class="normaltab" onclick="i:HoverLis(2);">交易评价</span>
         
    </div>
    <div class="dis" id="tbcs_01">
      <table width="832" border="0" cellspacing="0" class="dd_li">
        <tr bgcolor="#e8e8e8">
          <td width="234" height="34" align="center">商品名称</td>
          <td width="207" align="center">订单编号</td>
          <td width="109" align="center">购买时间</td>
          <td width="100" align="center">是否评价</td>
          <td width="55" align="center">积分</td>
          <td width="53" align="center">回复</td>
          <td width="58" align="center">有用</td>
        </tr>
<?php
if(count($page->objectList())){
	foreach($page->objectList() as $i=>$v){
?> 
        <tr>
          <td height="40" align="center"><a href="<?=URL?>index.php/front/usercomment/comment_replyAdd?cmid=<?=$commentid["$i"];?>&gid=<?=$gd;?>"><?=$v->t;?></a></td>
          <td align="center"><?=$v->z;?></td>
          <td align="center"> <?php echo date("Y-m-d,H:i:s",$v->f);?></td>
          <td align="center"><?php
if($comat["$i"]==1){echo '已评';}else{?><a href="<?=URL?>index.php/front/usercomment/ucommentShow?gid=<?php echo $v->gd; ?>"><?php echo '未评';?></a><?php }?></td>
          <td align="center"><span class="fn_greed b"><?=$v->g?></span></td>
          <td align="center"><?php if($replyCount["$i"]){echo $replyCount["$i"];}else{echo 0;};?></td>
          <td align="center">0</td>
        </tr>
		
		
<?php
}}else{
	echo '<tr><td colspan="7">暂无信息...</td></tr>';
}
?>		
		
		
		
		
		
		
		
		
		
        <tr>
		 <?php
		  		if(count($page->objectList())){?>
		<td height="31" colspan="3" align="center">
		<?php
		  		$page->getHtml("?type=$type&act=$act");
		?>
		</td>
<?php }else{
?><td height="31" colspan="3"></td><?php
}?>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td colspan="2" align="center">评价总数：<span class="fn_red b"><?php echo $commentCount;?></span></td>
        </tr>
      </table>      
    </div>
    <div class="undis" id="tbcs_02">
	功能暂未开放.
    <!-- <table width="832" border="0" cellspacing="0" class="dd_li">
        <tr bgcolor="#e8e8e8">
          <td width="148" height="34" align="center">订单编号</td>
          <td width="107" align="center">评价时间</td>
          <td width="473" align="center">评价内容</td>
          <td width="94" align="center">奖励积分</td>
          
        </tr>
        <tr>
          <td height="40" align="center"><a href="#">NH1357879465</a></td>
          <td align="center">2010-5-23</td>
          <td align="center">挺不错的我非常喜欢！东西质量很好包装也非常好！</td>
          <td align="center"><span class="fn_greed b">888</span></td>         
        </tr>
        <tr>
          <td height="40" align="center"><a href="#">NH1357879465</a></td>
          <td align="center">2010-5-23</td>
          <td align="center">挺不错的我非常喜欢！东西质量很好包装也非常量很好包装也好量很好包装也</td>
          <td align="center"><span class="fn_greed b">888</span></td>         
        </tr>
       
        <tr>
          <td height="31" align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">
</td>
          <td colspan="2" align="center">评价总数：<span class="fn_red b"></span></td>
        </tr>
      </table>
	  -->
    
    </div>

  </div>
  <!-- 主要内容结束-->
  



</body>
</html>

