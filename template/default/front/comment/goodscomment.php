<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<script src="<?=MEDIA_URL?>js/jquery.js"></script>
<link href="<?=MEDIA_URL?>css/mtk.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?=MEDIA_URL?>js/hdm.js"></script>

<script type="text/javascript">
$(function(){
	$("#good").hide();
	$("#bad").hide();
	$("#normal").hide();
}
);
function ck1(){
	$("#goods").hide();
	$("#good").show();
	$("#normal").hide();
	$("#bad").hide();
}
function ck2(){
	$("#goods").show();
	$("#good").hide();
	$("#normal").hide();
	$("#bad").hide();
}
function ck3(){
	$("#goods").hide();
	$("#good").hide();
	$("#normal").show();
	$("#bad").hide();
}
function ck4(){
	$("#goods").hide();
	$("#good").hide();
	$("#normal").hide();
	$("#bad").show();
}


</script>
<style type="text/css">
#good{
}
#goods{
}
#normal{
}
#bad{
}
</style>

</head>

<body>
<!-- 网页头部 -->
<div class="head">
  <div class="login fn_hs">您好：XXXXXXX<span class="out_login fn_hs">[<a href="#">退出登录</a>]</span></div>
  <div class="serch">
    <div id="logo"><!--此处放logo--></div>
    <div id="so">
      <form>
        <input class="ssk" type="text" /><div id="so_niu">搜　索</div>
      </form>
    </div>
    <div class="kf"><img src="<?=MEDIA_URL?>img/front/kf.gif" /></div>
  </div> 
  <!-- 挂件 
  <div class="wygj">
    <span><a href="#"><img src="<?=MEDIA_URL?>img/front/wdmtk_02.gif" /></a></span>
    <span><a href="#"><img src="<?=MEDIA_URL?>img/front/wddd_02.gif" /></a></span>
    <span><a href="#"><img src="<?=MEDIA_URL?>img/front/wdscj_02.gif" /></a></span>
  </div>
  挂件结束-->
</div>
  
<div class="nav">
  <div class="nav_nei">
    <div class="nav_dh fn_14px fn_bs">
      <a href="#">首  页</a><a href="#">动  漫</a><a href="#">游  戏</a><a href="#">创  意</a><a href="#">COSPLAY</a><a href="#">全部分类</a>
    </div>
    <div class="kjfs"><span class="order">我的购物车</span><span><img src="<?=MEDIA_URL?>img/front/niu1.gif" /></span><span class="go">去结算</span></div>
  </div>   
</div>
<div id="line"></div>  
<!--头部结束-->

<!-- 页面主体 -->
<div class="box">
  <div id="dh">首页 > 动漫 > 毛绒玩具 > 海贼王</div>
  
  
  
  
    <div class="char_title">
      <span class="hovertab" onclick="ck2();">商品评论(<?=$commentCount;?>)</span><span class="hovertab" onclick="ck1();">好评(<?=$goodcomment['goodcommentCount'];?> )</span><span class="hovertab" onclick="ck3();">中评(<?=$normalcomment['normalcommentCount'];?>)</span><span class="hovertab" onclick="ck4();">差评(<?=$badcomment['badcommentCount'];?>)</span>



    </div>
    <div class="dis" id="tbw5">
      <div class="tj">
        <h3>商品评论 共<span class="fn_blue b"><?=$commentCount;?></span>条 (<span class="fn_blue">查看所有评论</span>) </h3>
        <div class="pf">
          <div class="pf_top">购买过的顾客评分：</div>
          <div class="pf_too_y"><p><span class="fn_14px b">我要发表评论</span> | <span class="fn_blue">马上注册</span></p><p class="fn_hs">请您先以会员身份登录后再进行评论</p></div>
        </div>

<div class="pl" id="goods">
<?php 
if($goodscomment['comment']){
	foreach($goodscomment['comment'] as $i=>$v){
			if($i>4){//让foreach执行5次输出5条或者5条以下评论
					break;
			}
?>
          <div class="tou"><img src="<?=MEDIA_URL?>img/front/tou.gif" /><h4 class="fn_red b"><?php
echo $goodscomment['comment']["$i"]['comment']->uname;?></h4></div>
          <div class="pl_y">
            <p class="fn_s_blue b conect"><?=$goodscomment['comment']["$i"]['title']?></p>
            <p class="fn_hs sj"><span class="right fn_hs">[发表于<?php 
			
			echo date("Y-m-d H:m:s",$goodscomment['comment']["$i"]['createtime']);?>]</span><span>个人评分:<?=$goodscomment['comment']["$i"]['score'];?></span><span></span></p>
			<P>优点:<?=$goodscomment['comment']["$i"]['good'];?></P>
			<p>不足:<?=$goodscomment['comment']["$i"]['bad'];?></p>
			<p>总结:<?=$goodscomment['comment']["$i"]['summary'];?></p>
            <div class="hf"><span class="right">有0人认为此评论有用</span><a href="<?=URL?>index.php/front/usercomment/comment_replyAdd?gid=<?php echo $goodscomment['comment']["$i"]['comment']->id;?>">回复</a></div>
			<?php 
	foreach($goodscomment['comment']["$i"]['page']->objectList() as $j=>$c){
?>
	<div class="hf"><p><span><?=$c->uname;?>说:</span><span><?=$c->reply;?></span></p><p><span><?php echo date("Y-m-d H:i:s",$c->replytime);?></span></p></div>

<?php
	}
?>
          </div>
<?php
}}else{
echo '没有评论！';
}

?>
</div>
<div class="pl" id="good">
<?php 
if($goodcomment['comment']){
	foreach($goodcomment['comment'] as $i=>$v){
			if($i>4){//让foreach执行5次输出5条或者5条以下评论
					break;
			}
?>
          <div class="tou"><img src="<?=MEDIA_URL?>img/front/tou.gif" /><h4 class="fn_red b"><?php
echo $goodcomment['comment']["$i"]['comment']->uname;?></h4></div>
          <div class="pl_y">
            <p class="fn_s_blue b conect"><?=$goodcomment['comment']["$i"]['title']?></p>
            <p class="fn_hs sj"><span class="right fn_hs">[发表于<?php 
			
			echo date("Y-m-d H:m:s",$goodcomment['comment']["$i"]['createtime']);?>]</span><span>个人评分:<?=$goodcomment['comment']["$i"]['score'];?></span><span></span></p>
			<P>优点:<?=$goodcomment['comment']["$i"]['good'];?></P>
			<p>不足:<?=$goodcomment['comment']["$i"]['bad'];?></p>
			<p>总结:<?=$goodcomment['comment']["$i"]['summary'];?></p>
            <div class="hf"><span class="right">有0人认为此评论有用</span><a href="<?=URL?>index.php/front/usercomment/comment_replyAdd?gid=<?php echo $goodcomment['comment']["$i"]['comment']->id;?>">回复</a></div>
			<?php 
	foreach($goodcomment['comment']["$i"]['page']->objectList() as $j=>$c){
?>
	<div class="hf"><p><span><?=$c->uname;?>说:</span><span><?=$c->reply;?></span></p><p><span><?php echo date("Y-m-d H:i:s",$c->replytime);?></span></p></div>

<?php
	}
?>
          </div>
<?php
}}else{
echo '没有评论！';
}
?>
</div>
        <div class="pl" id="normal">
<?php 
if($normalcomment['comment']){
	foreach($normalcomment['comment'] as $i=>$v){
			if($i>4){//让foreach执行5次输出5条或者5条以下评论
					break;
			}
?>
          <div class="tou"><img src="<?=MEDIA_URL?>img/front/tou.gif" /><h4 class="fn_red b"><?php
echo $normalcomment['comment']["$i"]['comment']->uname;?></h4></div>
          <div class="pl_y">
            <p class="fn_s_blue b conect"><?=$normalcomment['comment']["$i"]['title']?></p>
            <p class="fn_hs sj"><span class="right fn_hs">[发表于<?php 
			
			echo date("Y-m-d H:m:s",$normalcomment['comment']["$i"]['createtime']);?>]</span><span>个人评分:<?=$normalcomment['comment']["$i"]['score'];?></span><span></span></p>
			<P>优点:<?=$normalcomment['comment']["$i"]['good'];?></P>
			<p>不足:<?=$normalcomment['comment']["$i"]['bad'];?></p>
			<p>总结:<?=$normalcomment['comment']["$i"]['summary'];?></p>
            <div class="hf"><span class="right">有0人认为此评论有用</span><a href="<?=URL?>index.php/front/usercomment/comment_replyAdd?gid=<?php echo $normalcomment['comment']["$i"]['comment']->id;?>">回复</a></div>
			<?php 
	foreach($normalcomment['comment']["$i"]['page']->objectList() as $j=>$c){
?>
	<div class="hf"><p><span><?=$c->uname;?>说:</span><span><?=$c->reply;?></span></p><p><span><?php echo date("Y-m-d H:i:s",$c->replytime);?></span></p></div>

<?php
	}
?>
          </div>
<?php
}}else{
echo '没有评论！';
}
?>
</div>
        <div class="pl" id="bad">
<?php 
if($badcomment['comment']){
	foreach($badcomment['comment'] as $i=>$v){
			if($i>4){//让foreach执行5次输出5条或者5条以下评论
					break;
			}
?>
          <div class="tou"><img src="<?=MEDIA_URL?>img/front/tou.gif" /><h4 class="fn_red b"><?php
echo $badcomment['comment']["$i"]['comment']->uname;?></h4></div>
          <div class="pl_y">
            <p class="fn_s_blue b conect"><?=$badcomment['comment']["$i"]['title']?></p>
            <p class="fn_hs sj"><span class="right fn_hs">[发表于<?php 
			
			echo date("Y-m-d H:m:s",$badcomment['comment']["$i"]['createtime']);?>]</span><span>个人评分:<?=$badcomment['comment']["$i"]['score'];?></span><span></span></p>
			<P>优点:<?=$badcomment['comment']["$i"]['good'];?></P>
			<p>不足:<?=$badcomment['comment']["$i"]['bad'];?></p>
			<p>总结:<?=$badcomment['comment']["$i"]['summary'];?></p>
            <div class="hf"><span class="right">有0人认为此评论有用</span><a href="<?=URL?>index.php/front/usercomment/comment_replyAdd?gid=<?php echo $badcomment['comment']["$i"]['comment']->id;?>">回复</a></div>
			<?php 
	foreach($badcomment['comment']["$i"]['page']->objectList() as $j=>$c){
?>
	<div class="hf"><p><span><?=$c->uname;?>说:</span><span><?=$c->reply;?></span></p><p><span><?php echo date("Y-m-d H:i:s",$c->replytime);?></span></p></div>

<?php
	}
?>
          </div>
<?php
}}else{
echo '没有评论！';
}
?>
</div>

        
      </div>
    </div>
    
    <div class="char_title">
      <span id="tbx_1" class="hovertab" onmouseover="x:HoverLix(1);">全部购买咨询</span>
      <span id="tbx_2" class="normaltab" onmouseover="i:HoverLix(2);">商品咨询</span>
      <span id="tbx_3" class="normaltab" onmouseover="i:HoverLix(3);">库存配送</span>
      <span id="tbx_4" class="normaltab" onmouseover="i:HoverLix(4);">支付</span>
         <span id="tbx_5" class="normaltab" onmouseover="i:HoverLix(5);">发票保修</span>
         <span id="tbx_6" class="normaltab" onmouseover="i:HoverLix(6);">支付帮助</span>
         <span id="tbx_7" class="normaltab" onmouseover="i:HoverLix(7);">配送帮助</span>
         <span id="tbx_8" class="normaltab" onmouseover="i:HoverLix(8);">常见问题</span>
    </div>
    <div class="dis" id="tbcx_01">
     
      <table width="98%" border="0" align="center" cellpadding="5" cellspacing="0" id="ly">
        <tr class="tr">
          <td width="6%" valign="top"><span class="b">提问：</span></td>
          <td width="62%">15626298订单号刚下的单我在上海杨浦区明天能不能到货？ </td>
          <td width="13%" align="center" valign="top"><span class="fn_red b">liuliubaobei1</span></td>
          <td width="19%" valign="top"><span class="fn_hs">发表于 2010-04-04 10:16</span></td>
        </tr>
        <tr class="tr">
          <td valign="top"><span class="fn_red b">回复：</span></td>
          <td colspan="2"><span class="fn_red">您好！该单显示已经完成，感谢您的支持！祝您购物愉快！</span></td>
          <td valign="top"><span class="fn_hs">发表于 2010-04-04 10:16</span></td>
        </tr>
        <tr>
          <td colspan="4">您对我们的回复： <span class="fn_blue">满意</span> (0)   <span class="fn_blue">不满意</span> (0) </td>
        </tr>
      </table>
      
    </div>
    <div class="undis" id="tbcx_02">2</div>
    <div class="undis" id="tbcx_03">3</div>
    <div class="undis" id="tbcx_04">4</div> 
    <div class="undis" id="tbcx_05">5</div>
    <div class="undis" id="tbcx_06">6</div>
    <div class="undis" id="tbcx_07">7</div>
    <div class="undis" id="tbcx_08">8</div>
    
 
  
  
  </div>
  <!--页面左侧结束-->
  <div class="yc">

      <div class="yc_top1">
        <h2></h2>
        <div class="yc_nei">
          <ul>
            <li><div class="img2"><img src="<?=MEDIA_URL?>img/front/tu2.gif" /></div><h3 class="fn_hs">夏天了！【凉宫春日】</h3><h4 class="s">￥135.00</h4><h4 class="m2">￥85.00 </h4></li>
            <li><div class="img2"><img src="<?=MEDIA_URL?>img/front/tu2.gif" /></div><h3 class="fn_hs">夏天了！【凉宫春日】</h3><h4 class="s">￥135.00</h4><h4 class="m2">￥85.00 </h4></li>
            <li><div class="img2"><img src="<?=MEDIA_URL?>img/front/tu2.gif" /></div><h3 class="fn_hs">夏天了！【凉宫春日】</h3><h4 class="s">￥135.00</h4><h4 class="m2">￥85.00 </h4></li>
            <li><div class="img2"><img src="<?=MEDIA_URL?>img/front/tu2.gif" /></div><h3 class="fn_hs">夏天了！【凉宫春日】</h3><h4 class="s">￥135.00</h4><h4 class="m2">￥85.00 </h4></li>
            <li><div class="img2"><img src="<?=MEDIA_URL?>img/front/tu2.gif" /></div><h3 class="fn_hs">夏天了！【凉宫春日】</h3><h4 class="s">￥135.00</h4><h4 class="m2">￥85.00 </h4></li>
            <li><div class="img2"><img src="<?=MEDIA_URL?>img/front/tu2.gif" /></div><h3 class="fn_hs">夏天了！【凉宫春日】</h3><h4 class="s">￥135.00</h4><h4 class="m2">￥85.00 </h4></li>            
          </ul>
        </div>
      </div>

    <div class="yc_top2">
      <h2><span class="qc"><a href="#">清除</a></span></h2>
      <div class="yc_nei">
          <ul>
            <li><div class="img2"><img src="<?=MEDIA_URL?>img/front/tu2.gif" /></div><h3 class="fn_hs">夏天了！【凉宫春日】</h3><h4 class="s">￥135.00</h4><h4 class="m2">￥85.00 </h4></li>
            <li><div class="img2"><img src="<?=MEDIA_URL?>img/front/tu2.gif" /></div><h3 class="fn_hs">夏天了！【凉宫春日】</h3><h4 class="s">￥135.00</h4><h4 class="m2">￥85.00 </h4></li>
            <li><div class="img2"><img src="<?=MEDIA_URL?>img/front/tu2.gif" /></div><h3 class="fn_hs">夏天了！【凉宫春日】</h3><h4 class="s">￥135.00</h4><h4 class="m2">￥85.00 </h4></li>
            <li><div class="img2"><img src="<?=MEDIA_URL?>img/front/tu2.gif" /></div><h3 class="fn_hs">夏天了！【凉宫春日】</h3><h4 class="s">￥135.00</h4><h4 class="m2">￥85.00 </h4></li>
            <li><div class="img2"><img src="<?=MEDIA_URL?>img/front/tu2.gif" /></div><h3 class="fn_hs">夏天了！【凉宫春日】</h3><h4 class="s">￥135.00</h4><h4 class="m2">￥85.00 </h4></li>
            <li><div class="img2"><img src="<?=MEDIA_URL?>img/front/tu2.gif" /></div><h3 class="fn_hs">夏天了！【凉宫春日】</h3><h4 class="s">￥135.00</h4><h4 class="m2">￥85.00 </h4></li>            
          </ul>
      </div>
    </div>
    
    <div class="yc_top3">
      <h2></h2>
      <div class="yc_nei2">
        <ul>
          <li><img src="<?=MEDIA_URL?>img/front/tu1.gif" /></li>
          <li><img src="<?=MEDIA_URL?>img/front/tu3.gif" /></li>
          <li><img src="<?=MEDIA_URL?>img/front/tu4.gif" /></li>
          <li><img src="<?=MEDIA_URL?>img/front/tu5.gif" /></li>
          <li><img src="<?=MEDIA_URL?>img/front/tu6.gif" /></li>
        </ul>
      </div>
    </div>
      
    
  </div>
  
</div>
<!-- 页面主体结束 -->

</body>
</html>
