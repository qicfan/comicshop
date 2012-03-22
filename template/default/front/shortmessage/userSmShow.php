<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$webTitle;?></title>
<script src="<?=MEDIA_URL?>js/jquery.js"></script>
<link href="<?=MEDIA_URL?>css/mtk_yh.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?=MEDIA_URL?>js/hdm.js"></script>
<style type="text/css">
.m1{}

.m2{
}
.m2 td{
padding:12px;}
</style>
<script language="javascript">

$(function(){
	$(".m1").next().hide();
	$(".m1").click(function(){
		var msid =$(this).val();
		var iread=$(this).next().val();
		var mstype=$(this).next().next().val();
		$(this).next().toggle();

		if(iread==0 && mstype ==1 ){
			$.get("<?=URL?>index.php/front/shortmessage/isRead",{msid:msid},function(){});
		}
		
	});


})
</script>
</head>

<body>
<?php require_once(PRO_ROOT . 'template/default/front/include/nav2.php');?>
<?php require_once(PRO_ROOT . 'template/default/front/include/user.php');?>
    <!-- 主要内容-->
  <div class="box_left">
    <div class="char_title">
      <span id="tbs_1" class="hovertab" onclick="x:HoverLis(1);">所有消息(<span class="fn_red"><?=$ShotmessageCount?></span>)</span>
      <span id="tbs_2" class="normaltab" onclick="i:HoverLis(2);">未读消息(<span class="fn_red">
	  <?php
	  	$co=0;
	  	foreach($page->objectList() as $v1){
			$i1=$v1->iread;
			$i4=$v1->smtype;
			if($i1==0 && $i4==1){
			 	$co += 1;
			}
		}
		echo $co;
		
	  ?>
	  
	  
	  </span>)</span>
         
    </div>
    <div class="dis" id="tbcs_01">
      <table width="832" border="0" cellspacing="0" class="dd_li">
        <tr bgcolor="#e8e8e8">
          <td width="89" height="34" align="left">状态</td>
          <td width="407" align="left">标题</td>
          <td width="127" align="left">发件人</td>
          <td width="112" align="left">发送时间</td>
          <td width="87" align="left">操作</td>
        </tr>
        <?php
	foreach($page->objectList() as $v){
?>
        <tr class="m1" value="<?=$v->id;?>">
          <td height="40" align="left"><?php 
			$i=$v->iread;
				if(!$v->smtype==0){
					if($i==1){
							//echo "已读";
					?>
              <img src="<?=MEDIA_URL?>img/front/dk_03.gif" />
            <?php
							
					}else{
					?>
              <img src="<?=MEDIA_URL?>img/front/gb_06.gif" />
            <?php
						}
				}else{
						echo '公告';
				}
			?>          </td>
          <td align="left"><a href="#">
            <?php
				$str=$v->content;
				if(strlen($str)>6){
 					echo substr($str,0,6).'...';
				}else{
					echo $str;
				}
			?>
            ..</a>. </td>
          <td align="left"><?=$v->fname;?></td>
          <td align="left"><?php echo date("Y-m-d",$v->stime);?></td>
          <td align="left"><?php if(!$v->smtype==0){?>
              <a href="<?=URL?>index.php/front/shortmessage/smDelete?id=<?=$v->id?>">删除</a>
              <?php }else{ echo '系统公告';} ?></td>
        </tr>
        <tr class="m2" value="<?=$v->iread;?>">
          <td colspan="5" align="left" >&nbsp;&nbsp;&nbsp;&nbsp;
          <?=$v->content;?></td>
        </tr>
		<tr value="<?=$v->smtype;?>" style="display:none"></tr>

        <?php
}
?>
        <tr>
          <td height="31" colspan="3" align="left"><?=$page->getHtml("?0")?></td>
          <td colspan="2" align="left">[短消息总数：<span class="fn_red b">
            <?=$ShotmessageCount;?>
          </span>]</td>
        </tr>
      </table>
    </div>
    <div class="undis" id="tbcs_02">
      <table width="832" border="0" cellspacing="0" class="dd_li">
        <tr bgcolor="#e8e8e8">
          <td width="89" height="34" align="left">状态</td>
          <td width="407" align="left">标题</td>
          <td width="127" align="left">发件人</td>
          <td width="112" align="left">发送时间</td>
          <td width="87" align="left">操作</td>
        </tr>
<?php
$co1=0;
foreach($page->objectList() as $v2){
		$i2 = $v2->iread;
		$i3 =$v2->smtype;
		if($i2==0 && $i3==1){
			$co1 += 1;
?>

        <tr class="m1" value="<?=$v2->id;?>">
          <td height="40" align="left"><img src="<?=MEDIA_URL?>img/front/gb_06.gif" /></td>
          <td align="left"><a href="#">
		  <?php
				//$str1=$v2->content;
				$str1 = $v2->content;
				if(strlen($str1)>6){
 					echo substr($str1,0,6).'...';
				}else{
					echo $str1;
				}
			?>..</a>. </td>
          <td align="left"><?=$v2->fname;?></td>
          <td align="left"> <?php echo date("Y-m-d",$v2->stime);?></td>
          <td align="left"><a href="<?=URL?>index.php/front/shortmessage/smDelete?id=<?=$v2->id?>">删除</a></td>
        </tr>
		<tr class="m2" value="<?=$v2->iread;?>">
          <td colspan="5" align="left" >&nbsp;&nbsp;&nbsp;&nbsp;
          <?=$v2->content;?></td>
        </tr>
		<tr value="<?=$v2->smtype;?>" style="display:none"></tr>

<?php
}
}		
?>
        <tr>
         
          <td colspan="3" align="left">未读短消息总数：<span class="fn_red b"><?=$co1;?></span></td>
        </tr>
      </table>
    
    </div>

  </div>
  <!-- 主要内容结束-->
  


</div>
</body>
</html>
