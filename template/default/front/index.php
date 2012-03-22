<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=base::getConfig('TITLE')?></title>
<meta name="description" content="<?=base::getConfig('DES')?>" />
<meta name="keywords" content="<?=base::getConfig('KEY_WORD')?>" />
<link href="<?=MEDIA_URL?>css/mtk.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=URL?>media/js/jquery-1.3.2.min.js"></script>
<script language="javascript" type="text/javascript" src="<?=MEDIA_URL?>js/hdm.js"></script>
<style type="text/css">
#play img {border:0px}
#play {width:970px;height:392px;overflow:hidden;margin: 0 auto; border: 1px solid #fff; padding:2px; }
#play_info{position:absolute;margin-top:340px;padding:8px 0 0 20px;height:42px;width:400px;color:#fff;z-index:1001;cursor:pointer}
#play_info b{font-size:24px;display:block}
#play_bg {position:absolute;background-color:#000;margin-top:340px;height:50px;width:970px;filter: Alpha(Opacity=30);opacity:0.3;z-index:1000}
#play_text {position:absolute;margin:370px 0 0 370px;height:50px;width:600px;z-index:1002}
#play_text ul {list-style-type:none; width:600px;height:30px;display:block;padding-top:0px;_padding-top:0px;filter: Alpha(Opacity=80);opacity:0.8;}
#play_text ul li {width:14px;height:14px;float:left;background-color:#000;display:block;color:#fff;text-align:center;margin:1px;cursor:pointer;font-family:"微软雅黑"; font-size:9px;}
#play_list a{display:block;width:970px;height:392px;position:absolute;overflow:hidden}
</style>
</head>

<body>
<!-- 网页头部 -->
<?php
	include_once PRO_ROOT.'template/default/front/include/nav1.php';
?> 
<!--头部结束-->

<div id="flash" class="h_bj">
<!--幻灯 970*392 开始-->
<div id="play"> <div id="play_bg"></div> <div id="play_info"></div>
<div id="play_text">
  <ul>
<?php for($i=0;$i<count($pics);$i++){ ?>
   <li><?=($i+1)?></li>
<? } ?>
  </ul>
 </div>
 <div id="play_list">
<?php for($i=0;$i<count($pics);$i++){ ?>
 <a href="javascript:void(0);" target="_blank">
<img src="<?=MEDIA_URL?>img/front/flash_03.gif" title="" alt="<b><?=$pics[$i]['goodsname']?></b><?=other::cn_substr_utf8($pics[$i]['des'],80,0)?>" height="392" width="970" />
 </a>
<? } ?>
 </div>
</div>
<!--幻灯 970*392 结束--></div>

<div id="bod" class="box">
 
 <div class="yc">    
    <div class="yc_top3">
	    <h2></h2>
      <div class="yc_nei2">
        <ul>
		<?php for($i=0;$i<count($brand);$i++){ ?>
        	<!--width="186" height="87" -->
          <li><a href="javascript:void(0);"><img src="<?php if($brand[$i]['bpicpath']==''){ echo MEDIA_URL.'img/no_picture.gif'; } else { echo $brand[$i]['bpicpath'];} ?>" title="<?=$brand[$i]['bname']?>" width="186" height="87" /></a></li>
		  <?php } ?>
        </ul>
      </div>
    </div>
    <div class="clear"></div>
    
    <div class="yc_top3">
    <h2></h2>
    	<?php
			for($i=0;$i<count($works);$i++){
		?>
        	<a href="javascript:void(0);"><img src="<?=$works[$i]->wpicpath?>"  title="<?=$works[$i]->wname?>"/></a>
        <?php
			}
        ?>
    </div>
    
	<!--
    <div class="yc_top3">
      <h2></h2>
      <div class="zmp">
       <img src="<?=MEDIA_URL?>img/front/logo2.gif" /><img src="<?=MEDIA_URL?>img/front/logo2.gif" /><img src="<?=MEDIA_URL?>img/front/yaa_06.gif" /><img src="<?=MEDIA_URL?>img/front/logo2.gif" /><img src="<?=MEDIA_URL?>img/front/logo2.gif" /><img src="<?=MEDIA_URL?>img/front/yaa_06.gif" /><img src="<?=MEDIA_URL?>img/front/logo2.gif" /><img src="<?=MEDIA_URL?>img/front/logo2.gif" /><img src="<?=MEDIA_URL?>img/front/yaa_06.gif" />
      </div>
    </div>
	-->
</div>


<div class="zt">

  <div class="new_sp h_bj">
       <div class="new_sp_top">
       <!-- <span id="tbh_1" class="hovertab" onmouseover="x:HoverLih(1);">本日新品</span>
        <span id="tbh_2" class="normaltab" onmouseover="i:HoverLih(2);">本周新品</span>
        <span id="tbh_3" class="normaltab" onmouseover="i:HoverLih(3);">本月新品</span>        -->  
       </div>
     <div class="dis" id="tbch_01">
       <ul class="index_img">
<?php for($i=0;$i<count($new_goods);$i++){ ?>
         <li><div class="tu"><a href="<?=GoodsFront::GetUrl('goods',array('gid'=>$new_goods[$i]['id']))?>" title="<?=$new_goods[$i]['goodsname']?>"><img src="<? if($new_goods[$i]['imgcurrent']=='') {echo MEDIA_URL.'img/no_picture.gif'; }else {echo GoodsFront::GetChangeImg('99',$new_goods[$i]['imgcurrent']);} ?>"  height="99" width="99" /></a></div><a href="<?=GoodsFront::GetUrl('goods',array('gid'=>$new_goods[$i]['id']))?>" title="<?=$new_goods[$i]['goodsname']?>"><h2 style="text-align:center"><?=other::cn_substr_utf8($new_goods[$i]['goodsname'],15,0)?></h2></a><p class="fn_hs s">市场价：￥<?=$new_goods[$i]['marketprice']?></p><p class="fn_red">现价：<span class="fn_14px b">￥<?=$new_goods[$i]['shopprice']?></span></p></li>
<? } ?>
       </ul>
     </div>
  
  </div>
  <div class="index_yc">
    <div class="de_yc_top"><img src="<?=MEDIA_URL?>img/front/mrtj_03.gif" /></div>
<?php for($i=0;$i<count($promote);$i++){ ?>
    <div class="xk h_bj">
      <div class="tu"><a href="<?=GoodsFront::GetUrl('goods',array('gid'=>$promote[$i]['id']))?>" title="<?=$promote[$i]['goodsname']?>"><img src="<?php if($promote[$i]['imgcurrent']=='') {echo MEDIA_URL.'img/no_picture.gif'; }else {echo GoodsFront::GetChangeImg('129',$promote[$i]['imgcurrent']);}?>"  height="129" width="129" /></a></div><p ><a href="<?=GoodsFront::GetUrl('goods',array('gid'=>$promote[$i]['id']))?>" title="<?=$promote[$i]['goodsname']?>"><?=other::cn_substr_utf8($promote[$i]['goodsname'],15,0)?></a></p><p class="fn_red">现价：￥<?=$promote[$i]['shopprice']?>元</p>
    </div>
<? } ?>
    <div class="de_yc_top"><img src="<?=MEDIA_URL?>img/front/scgg_03.gif" /></div>

<?php for($i=0;$i<count($notice);$i++){ ?>
    <P class="gg"><a href="<?=URL?>html/article/<?=$notice[$i]['id']?>.html"><?=$notice[$i]['title']?></a></P>
<? } ?>
  </div>
  
 </div>

<div class="zt">
  <div class="h_bj ku">
      <div class="new_sp_top top2">
        <span id="tb_1" class="hovertab" name="1" >创意产品</span>
         <span id="tb_2" class="normaltab" name="38795" >桌游</span>
         <span id="tb_3" class="normaltab" name="38792" >动漫周边</span>
       </div>
     <div class="dis" id="tbc_01">
       <ul class="index_img">
<?php for($i=0;$i<count($hot_goods);$i++){ ?>
         <li>
    <div class="tu"><a href="<?=GoodsFront::GetUrl('goods',array('gid'=>$hot_goods[$i]['id']))?>" title="<?=$hot_goods[$i]['goodsname']?>"><img src="<?php if($hot_goods[$i]['imgcurrent']=='') {echo MEDIA_URL.'img/no_picture.gif'; }else {echo GoodsFront::GetChangeImg('129',$hot_goods[$i]['imgcurrent']);}?>"  height="99" width="99"/></a><?php if($i<5){ ?><div class="gj2"><?=($i+1)?></div> <? } ?></div>
		 <h2 style="text-align:center"><a href="<?=GoodsFront::GetUrl('goods',array('gid'=>$hot_goods[$i]['id']))?>" title="<?=$hot_goods[$i]['goodsname']?>"><?=other::cn_substr_utf8($hot_goods[$i]['goodsname'],15,0)?></a></h2><p class="fn_hs s">市场价：￥<?=$hot_goods[$i]['marketprice']?></p><p class="fn_red">现价：<span class="fn_14px b">￥<?=$hot_goods[$i]['shopprice']?></span></p></li>
<? } ?>

       </ul>
     </div>

  </div>
</div>

</div>
<div class="clear"></div>
<div id="footer">
 <div class="l_line"></div>
 <div class="gy">
   <div class="bq" id="bq1">
     <p><a href="javascript:void(0);">关于我们</a></p>
     <p><a href="javascript:void(0);">诚征英才</a></p>
     <p><a href="javascript:void(0);">合作伙伴</a></p>
     <p><a href="javascript:void(0);">联系漫淘客</a></p> 
   </div>
   <div class="bq" id="bq2">
     <p><a href="javascript:void(0);">支付安全</a></p>
     <p><a href="javascript:void(0);">诚征英才</a></p>
     <p><a href="javascript:void(0);">合作伙伴</a></p>
   </div>
   <div class="bq" id="bq3">
     <p><a href="javascript:void(0);">法律声明</a></p>
     <p><a href="javascript:void(0);">知识产权声明</a></p>
   </div>
    <div class="bq" id="bq4">
     <p><a href="javascript:void(0);">网站加盟</a></p>
     <p><a href="javascript:void(0);">合作加入</a></p>
   </div>
   
    <div class="bq" id="bq5">
     <p><a href="javascript:void(0);">网站使用帮助</a></p>
     <p><a href="javascript:void(0);">客服投拆</a></p>
   </div>
   
 </div>
 <div><img src="<?=MEDIA_URL?>img/front/di.gif" /></div>
 <div id="warm_bot">关于漫域 | 公司简介 | 广告服务 | 商务洽谈 | 招贤纳士 | 联系我们<br />
Copyright  ©  2008-2010 Jilin Yushuo ACG Technology Co.,Ltd, All Rights   Reserved   禹硕公司   版权所有<br />
   <a href="http://www.miibeian.gov.cn/" target="_blank">增值电信业务经营许可证吉  B-2-4-20090003</a>   <a href="http://www.comicyu.com/html/DYJD/GYMY/2009/01/12808.shtml" target="_blank" title="广播电视节目制作经营许可证">广播电视节目制作经营许可证</a>   <a href="http://www.comicyu.com/html/DYJD/GYMY/2009/03/14275.shtml" target="_blank" title="文网文 [2009]011号">文网文 [2009]011号</a>
</div>
</div>
<script src="<?=MEDIA_URL?>js/jquery.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript">

$(".normaltab , .hovertab").click(function(){
	var current = $(this);
	$.get("<?php echo URL; ?>index.php/front/goodsfront/gethotgoods",{cid: $(current).attr("name")},function(data){
		$("#tbc_01").html(data);

	});
	$(".hovertab").attr("class","normaltab"); 
	$(this).attr("class","hovertab");
});

var t = n = 0, count = $("#play_list a").size();
$(function(){ 
 $("#play_list a:not(:first-child)").hide();
 $("#play_info").html($("#play_list a:first-child").find("img").attr('alt'));
 $("#play_text li:first-child").css({"background":"#fff",'color':'#000'});
 $("#play_info").click(function(){window.open($("#play_list a:first-child").attr('href'), "_blank")});
 $("#play_text li").click(function() {
  var i = $(this).text() - 1;
  n = i;
  if (i >= count) return;
  $("#play_info").html($("#play_list a").eq(i).find("img").attr('alt'));
  $("#play_info").unbind().click(function(){window.open($("#play_list a").eq(i).attr('href'), "_blank")})
  $("#play_list a").filter(":visible").fadeOut(500).parent().children().eq(i).fadeIn(1000);
  $(this).css({"background":"#fff",'color':'#000'}).siblings().css({"background":"#000",'color':'#fff'});
 });
 t = setInterval("showAuto()", 2000);
 $("#play").hover(function(){clearInterval(t)}, function(){t = setInterval("showAuto()", 2000);});
})

function showAuto()
{
 n = n >= (count - 1) ? 0 : ++n;
 $("#play_text li").eq(n).trigger('click');
}
</script>
</script>
</body>
</html>
