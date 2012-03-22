<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>我的咨询</title>

<link href="<?=MEDIA_URL?>css/mtk_yh.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?=MEDIA_URL?>js/hdm.js"></script>
<script src="http://static.comicyu.com/js/jquery.js" type="text/javascript"></script>
</head>

<body>
 <!-- 头部-->
<?php require_once(PRO_ROOT . 'template/default/front/include/nav2.php'); ?> 
 <!-- 左侧导航-->
<?php include PRO_ROOT."template/default/front/include/user.php"; ?>
  <!-- 主要内容-->


  <div class="box_left">
    <div class="char_title">
      <span class="hovertab">我的购买咨询</span>         
    </div>
    <div id="tbch_01">
      <table width="832" border="0" cellspacing="0" class="dd_li">
        <tr bgcolor="#e8e8e8" class="fn_hs">
          <td width="264" height="34" align="center">商品名称</td>
          <td width="77" align="center">咨询时间</td>
          <td width="305" align="center">咨询内容</td>
          <td width="79" align="center">回复</td>
          <td width="95" align="center">回复时间</td>
        </tr>
<?php
foreach ($page->objectList() as $v){
?>
        <tr>
          <td height="40" align="center"><a href="<?=GoodsFront::GetUrl('goods',array('gid'=>($v->gid)))?>"><?=base::getGoodsName($v->gid)?></a></td>
          <td align="center"><?=date('Y-m-d',$v->questiontime)?></td>
          <td align="center"><?=$v->content?></td>
          <td align="center"><span class="fn_red">
	<?php
	switch ($v->state) {
		case 1:
			echo '<a href="#none" class="replydetial" name="'.$v->id.'">查  看 </a>';
			break;
		default:
			echo '未回复';
			break;
	}
	?>
          </span></td>
          <td align="center"><?=empty($v->replytime) ? '-' : date('Y-m-d',$v->replytime)?></td>         
        </tr>
<?php
}
?>
        <tr>
          <td height="31" align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td colspan="7" align="center"><? if($count>PAGE_SIZE){ echo $page->getHtml("?a="); }else {?>咨询总数：<span class="fn_red b"><?=$count?></span><? } ?></td>
        </tr>
      </table>
    
    </div>
    
  </div>
  <!-- 主要内容结束-->
<script>
$(".replydetial").toggle(
	function(){
		var current = $(this);
		$.get("<?php echo URL; ?>index.php/front/question/getReply",{ qid:$(current).attr("name") },function(data,status){
				$(current).parent().parent().parent().after("<tr><td colspan=\"5\"  height=\"30\"><span class=\"fn_red b\">&nbsp;漫淘客回复：</span><span class=\"fn_red\">"+data+"<span class=\"fn_red b\"></td></tr>");   

		});
	},
	function(){
		var current = $(this);
		$(current).parent().parent().parent().next().empty();
	}
);

</script>
</div>
</body>
</html>
