<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>商品列表页</title>
<link href="<?=MEDIA_URL?>css/mtk.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?=MEDIA_URL?>js/hdm.js"></script>
<script src="http://static.comicyu.com/js/jquery.js" type="text/javascript"></script>
<script type="text/javascript">
	function getviewed(){
		var gid = 0;
		var url = "<?=URL?>index.php/front/goodsfront/goodsviewed";
		$.get(url,{gid:gid},function(data){
			$("#viewed").empty();
			$(data).appendTo("#viewed");
		});
	}
	
	$(document).ready(function() {    
		getviewed();
		//setcontent();
		settab();
		//setcontent();
	}); 
	function getobj(na){
		return document.getElementById(na);
	}
	function settab(){
		if(<?=$sort?>==1){
			getobj("tb_1").className="hovertab";
			getobj("tb_2").className="normaltab";
			getobj("tb_3").className="normaltab";
			getobj("tb_4").className="normaltab";
			getobj("tbc_01").className="dis";
			getobj("tbc_02").className="undis";
			getobj("tbc_03").className="undis";
			getobj("tbc_04").className="undis";
		}else if(<?=$sort?>==2){
			//alert(.className);
			getobj("tb_1").className="normaltab";
			getobj("tb_2").className="hovertab";
			getobj("tb_3").className="normaltab";
			getobj("tb_4").className="normaltab";
			getobj("tbc_01").className="undis";
			getobj("tbc_02").className="dis";
			getobj("tbc_03").className="undis";
			getobj("tbc_04").className="undis";
		}else if(<?=$sort?>==3){
			getobj("tb_1").className="normaltab";
			getobj("tb_2").className="normaltab";
			getobj("tb_3").className="hovertab";
			getobj("tb_4").className="normaltab";
			getobj("tbc_01").className="undis";
			getobj("tbc_02").className="undis";
			getobj("tbc_03").className="dis";
			getobj("tbc_04").className="undis";
		}else if(<?=$sort?>==4){
			getobj("tb_1").className="normaltab";
			getobj("tb_2").className="normaltab";
			getobj("tb_3").className="normaltab";
			getobj("tb_4").className="hovertab";
			getobj("tbc_01").className="undis";
			getobj("tbc_02").className="undis";
			getobj("tbc_03").className="undis";
			getobj("tbc_04").className="dis";
		}
	}
	
	function collect(gid){
		var url = "<?=URL?>index.php/front/collect/Add";
		$.get(url,{gid:gid,ajax:1},function(data){
			if(data=="login"){
				alert("请先登录！");
			}else if(data=="exist"){
				alert("此商品已在收藏夹里！");
			}else if(data=="ok"){
				alert("收藏成功！");
			}else {
				alert("收藏失败！");
			}
		});
	}
	
	/** 加入购物车 */
	function cartInert(gid){
		var url = "<?=URL?>index.php/front/cart/cartInsert";
		$.get(url,{gid:gid,loca:1},function(data){
			if(data=='ok'){
				alert("添加成功！");
			}else if(data=='cunzai'){
				alert("商品在购物车里已存在");
			}
		});
	}
	
	//设置显示内容
	function setcontent(){
		if(<?=$sort?>==1){
			alert(1);
		}else if(<?=$sort?>==2){
			alert(2);
		}else if(<?=$sort?>==3){
			alert(3);
		}else if(<?=$sort?>==4){
			alert(4);
		}
	}
	
	function clearviewed(){
		var url = "<?=URL?>index.php/front/goodsfront/clearviewed";
		$.get(url,function(data){
			$("#viewed").empty();
			$(data).appendTo("#viewed");
		});
	}
</script>
</head>

<body>
<!-- 网页头部 -->
<?php
	include_once PRO_ROOT.'template/default/front/include/nav1.php';
?>

<!--头部结束-->

<!-- 页面主体 -->
<div class="box">
  <div id="dh"><?=$navigation?></div>
  
  <!--页面左侧-->
  <div class="zc">
  	<?=$categorys?>
    <div class="list">
      <div class="char_title">
        <div id="listtab" class="tit_z">
			<?=$goodslisttab?>
        </div>
        <div class="tit_y">
       <!--span class="xs xs_2">列表</span><span class="xs xs_1">图标</span-->
       <span>(共有<span class="fn_red b"><?=$goodscount?></span>件商品) </span>
       <span class="up"><a onclick="setcontent();" href="#"><img src="<?=MEDIA_URL?>img/front/s_03.gif" /></a></span>
       <span>1/20页</span>
       <span class="up"><a href="#"><img src="<?=MEDIA_URL?>img/front/x_05.gif" /></a></span>
       </div>
      </div>
     <div class="dis" id="tbc_01">
     	<?=$goodslist?>
     </div>
     <div class="undis" id="tbc_02">
	 	<?=$goodslist?>
	 </div>
     <div class="undis" id="tbc_03">
	 	<?=$goodslist?>
	 </div>
     <!--div class="undis" id="tbc_04">
	 	<?=$goodslist?>
	 </div-->
    </div>
    <div class="line"></div>
    <!--div class="tj">
      <h2>根据您挑选的商品，漫淘客为您推荐</h2>
      <ul class="list_tj">
        <li><div class="img2"><img src="<?=MEDIA_URL?>img/front/tu2.gif" /></div><h3>夏天了！【凉宫春日】</h2><h4><span class="m2">￥85.00</span><span class="s">￥135.00</span></h4><h5><a href="#"><img src="<?=MEDIA_URL?>img/front/jrgw.gif" /></a></h5></li>
        <li><div class="img2"><img src="<?=MEDIA_URL?>img/front/tu2.gif" /></div><h3>夏天了！【凉宫春日】</h2><h4><span class="m2">￥85.00</span><span class="s">￥135.00</span></h4><h5><a href="#"><img src="<?=MEDIA_URL?>img/front/jrgw.gif" /></a></h5></li>
        <li><div class="img2"><img src="<?=MEDIA_URL?>img/front/tu2.gif" /></div><h3>夏天了！【凉宫春日】</h2><h4><span class="m2">￥85.00</span><span class="s">￥135.00</span></h4><h5><a href="#"><img src="<?=MEDIA_URL?>img/front/jrgw.gif" /></a></h5></li>
        <li><div class="img2"><img src="<?=MEDIA_URL?>img/front/tu2.gif" /></div><h3>夏天了！【凉宫春日】</h2><h4><span class="m2">￥85.00</span><span class="s">￥135.00</span></h4><h5><a href="#"><img src="<?=MEDIA_URL?>img/front/jrgw.gif" /></a></h5></li>
        <li><div class="img2"><img src="<?=MEDIA_URL?>img/front/tu2.gif" /></div><h3>夏天了！【凉宫春日】</h2><h4><span class="m2">￥85.00</span><span class="s">￥135.00</span></h4><h5><a href="#"><img src="<?=MEDIA_URL?>img/front/jrgw.gif" /></a></h5></li>
        <li><div class="img2"><img src="<?=MEDIA_URL?>img/front/tu2.gif" /></div><h3>夏天了！【凉宫春日】</h2><h4><span class="m2">￥85.00</span><span class="s">￥135.00</span></h4><h5><a href="#"><img src="<?=MEDIA_URL?>img/front/jrgw.gif" /></a></h5></li>
      </ul>
    </div-->
  </div>
  <!--页面左侧结束-->
  <div class="yc">

      <!--div class="yc_top1">
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
      </div-->

    <div class="yc_top2">
      <h2><span class="qc"><a onclick="clearviewed();" href="javascript:void(0);">清除</a></span></h2>
	  <div id="viewed"></div>
    </div>
    
    <!--div class="yc_top3">
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
    </div-->
      
    
  </div>
  
</div>
<!-- 页面主体结束 -->
</body>
</html>
