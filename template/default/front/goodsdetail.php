<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>商品详细页</title>
<link href="<?=MEDIA_URL?>css/mtk.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?=MEDIA_URL?>js/hdm.js"></script>
<link rel="stylesheet" href="<?=MEDIA_URL?>css/cssreset.css" type="text/css"/>
<link rel="stylesheet" href="<?=MEDIA_URL?>css/mycss.css" type="text/css"/>
<link rel="stylesheet" href="<?=MEDIA_URL?>css/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?=MEDIA_URL?>css/jqzoom.css" type="text/css" media="screen" />
<script src="http://static.comicyu.com/js/jquery.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=MEDIA_URL?>js/jquery.jqzoom.js"></script>

<script language="javascript" type="text/javascript">
	
	jQuery.fn.loadthumb = function(options) {
		options = $.extend({
			 src : ""
		},options);
		var _self = this;
		_self.hide();
		var img = new Image();
		$(img).load(function(){
			_self.attr("src", options.src);
			_self.fadeIn("slow");
		}).attr("src", options.src);  //.atte("src",options.src)要放在load后面，
		return _self;
	}

  $(function(){
	  var i = 5;  //已知显示的<a>元素的个数
	  var m = 5;  //用于计算的变量
      var $content = $("#myImagesSlideBox .scrollableDiv");
	  var count = $content.find("a").length;//总共的<a>元素的个数
	  //下一张
	  $(".next").live("click",function(){
			var $scrollableDiv = $(this).siblings(".items").find(".scrollableDiv");
			if( !$scrollableDiv.is(":animated")){  //判断元素是否正处于动画，如果不处于动画状态，则追加动画。
				if(m<count){  //判断 i 是否小于总的个数
					m++;
					$scrollableDiv.animate({left: "-=50px"}, 600);
				}
			}
			return false;
	  });
	   //上一张
	  $(".prev").live("click",function(){
			var $scrollableDiv = $(this).siblings(".items").find(".scrollableDiv");
			if( !$scrollableDiv.is(":animated")){
				if(m>i){ //判断 i 是否小于总的个数
					m--;
					$scrollableDiv.animate({left: "+=50px"}, 600);
				}
			}
			return false;
	  });

	  $(".scrollableDiv a").live("click",function(){
			var src = $(this).find("img").attr("imgb");
			var bigimgSrc = $(this).find("img").attr("bigimg");
			$(this).parents(".myImagesSlideBox").find(".myImgs").loadthumb({src:src}).attr("bigimg",bigimgSrc);
		
			var jqimg = $(this).find("img").attr("bigimg");
			$(this).parents(".myImagesSlideBox").find(".myImgs").loadthumb({src:src}).attr("jqimg",jqimg)
			
			$(this).addClass("active").siblings().removeClass("active");
			return false;
	  });
	  $(".scrollableDiv a:nth-child(1)").trigger("click");
		
	  $(".myTxts a").live("click",function(){
			var bigimgSrc =$(this).parents(".myImagesSlideBox").find(".myImgs").attr("bigimg");
			popZoom( bigimgSrc , "500" , "500");
			return false;
	  });

		//以新窗口的方式打开图片
		var windowWidth  =$(window).width();
		var windowHeight  =$(window).height();
		function popZoom(pictURL, pWidth, pHeight) {
			var sWidth = windowWidth;
			var sHeight = windowHeight;
			var x1 = pWidth;
			var y1 = pHeight;
			var opts = "height=" + y1 + ",width=" + x1 + ",left=" + ((sWidth-x1)/2) +",top="+ ((sHeight-y1)/2)+",scrollbars=0,menubar=0";
			pZoom = window.open("","", opts);
			pZoom.document.open();
			pZoom.document.writeln("<html><body bgcolor=\"skyblue\"" +" onblur='self.close();' style='margin:0;padding:0;'>");
			pZoom.document.writeln("<img src=\"" + pictURL + "\" width=\"" +pWidth + "px\" height=\"" + pHeight + "px\">");
			pZoom.document.writeln("</body></html>");
			pZoom.document.close();
		} 
		
		/*关闭遮罩层*/
		$(".closeMyDiv a").live("click",function(){
			$("#MyDiv").empty().hide();
			$("#BigDiv").hide();
			return false;
		}).focus(function(){
			$(this).blur();
			return false;
		});

		/*使用遮罩层*/
		$("#myImagesSlideBox .myImages img").click(function(){
			/*遮罩层居中 和 宽度 高度设置 */
			$("#BigDiv").css({
						width:  $("body").width() , 
						height: (   $("body").height()  >  $("html").height() ) ? $("body").height() : $("html").height()  
					});
			$("#MyDiv").css({left: (($(window).width()-300)/2)  ,top: (($(window).height()-390)/2)  });

			var $myDiv = $("#MyDiv").html( $("#myImagesSlideBox").html() ).show();
			$('<div class="closeMyDiv"><a href="#">关闭</a></div>').prependTo( $myDiv );
			$("#BigDiv").show();
			return false;
		});
  })
  $(document).ready(function(){
  
	$(".jqzoom").jqueryzoom({
					xzoom: 350, //zooming div default width(default width value is 200)
					yzoom: 400, //zooming div default width(default height value is 200)
					offset:20, //zooming div default offset(default offset value is 10)
					position: "right", //zooming div position(default position value is "right")
					preload:1,
					lens:1
				});
		
	});
	setTimeout(loadother(),2000);
	function loadother(){
		getviewed();
		getgoodscomments();
		getgoodscount();
		getgoodcount();
		getmedcount();
		getbadcount();
		getzq();
	}
	function HoverCom(n){
		for(var i=1;i<=4;i++){
			g('com_'+i).className='normaltab';
			g('com1_'+i).className='undis';
		}
		g('com1_'+n).className='dis';
		g('com_'+n).className='hovertab';
	}
	
	function getgid(){
		var currenturl = window.location.href;
		var urlarr = currenturl.split("/");
		var suffix = urlarr[urlarr.length-1];
		var gid = 0;
		
		if(suffix.indexOf(".html")>0){
			var tmp = suffix.split(".");
			gid = tmp[0];
		}else{
			gid = <?=$goods->id?>;
		}
		return gid;
	}
	
	function getviewed(){
		var gid = getgid();
		var url = "<?=URL?>index.php/front/goodsfront/goodsviewed";
		$.get(url,{gid:gid},function(data){
			$("#viewed").empty();
			$(data).appendTo("#viewed");
		});
	}

	//获取商品评论数量
	function getgoodscount(){
		var gid = getgid();
		var url = "<?=URL?>index.php/front/goodsfront/goodscommnetcount";
		$.get(url,{gid:gid},function(data){
			$("<span>("+data+")</span>").appendTo("#allcomment");
		});
	}
	//获取商品好评数量
	function getgoodcount(){
		var gid = getgid();
		var url = "<?=URL?>index.php/front/goodsfront/goodcommentcount";
		$.get(url,{gid:gid},function(data){
			$("<span>("+data+")</span>").appendTo("#goodcomment");
		});
	}
	//获取商品中评数量
	function getmedcount(){
		var gid = getgid();
		var url = "<?=URL?>index.php/front/goodsfront/medcommentcount";
		$.get(url,{gid:gid},function(data){
			$("<span>("+data+")</span>").appendTo("#medcomment");
		});
	}
	//获取商品差评数量
	function getbadcount(){
		var gid = getgid();
		var url = "<?=URL?>index.php/front/goodsfront/badcommentcount";
		$.get(url,{gid:gid},function(data){
			$("<span>("+data+")</span>").appendTo("#badcomment");
		});	
	}
	//获取商品评论
	function getgoodscomments(){
		var gid = getgid();
		var url = "<?=URL?>index.php/front/goodsfront/goodscomments";
		$.get(url,{gid:gid},function(data){
		//alert(data);
			$("#com1_1").empty();
			$(data).appendTo("#com1_1");
		});
	}
	
	//获取商品的好评
	function getgoodcomments(){
		var gid = getgid();
		var url = "<?=URL?>index.php/front/goodsfront/goodscomments";
		$.get(url,{gid:gid},function(data){
			$("#com1_2").empty();
			$(data).appendTo("#com1_2");
		});
	}
	//获取商品的中评
	function getmedcomments(){
		var gid = getgid();
		var url = "<?=URL?>index.php/front/goodsfront/medcomments";
		$.get(url,{gid:gid},function(data){
			$("#com1_3").empty();
			$(data).appendTo("#com1_3");
		});
	}
	//获取商品的差评
	function getbadcomments(){
		var gid = getgid();
		var url = "<?=URL?>index.php/front/goodsfront/badcomments";
		$.get(url,{gid:gid},function(data){
			$("#com1_4").empty();
			$(data).appendTo("#com1_4");
		});
	}
	
	//获取全部咨询
	function getzq(){
		var gid = getgid();
		var url = "<?=URL?>index.php/front/goodsfront/getzqall";
		$.get(url,{gid:gid},function(data){
			$("#tbcx_01").empty();
			$(data).appendTo("#tbcx_01");
		});
	}
	//获取商品咨询
	function getzqgoods(){
		var gid = getgid();
		var url = "<?=URL?>index.php/front/goodsfront/getzqgoods";
		$.get(url,{gid:gid},function(data){
			$("#tbcx_02").empty();
			$(data).appendTo("#tbcx_02");
		});
	}
	//获取配送咨询
	function getzqsend(){
		var gid = getgid();
		var url = "<?=URL?>index.php/front/goodsfront/getzqsend";
		$.get(url,{gid:gid},function(data){
			$("#tbcx_03").empty();
			$(data).appendTo("#tbcx_03");
		});
	}
	//获取支付咨询
	function getzqpay(){
		var gid = getgid();
		var url = "<?=URL?>index.php/front/goodsfront/getzqpay";
		$.get(url,{gid:gid},function(data){
			$("#tbcx_04").empty();
			$(data).appendTo("#tbcx_04");
		});
	}
	//获取发票咨询
	function getzqinvoice(){
		var gid = getgid();
		var url = "<?=URL?>index.php/front/goodsfront/getzqinvoice";
		$.get(url,{gid:gid},function(data){
			$("#tbcx_05").empty();
			$(data).appendTo("#tbcx_05");
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
			}else if(data=='buzu'){
				alert("Sorry 库存量不足！");
			}
		});
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
  
    <div class="good">
      <h1 class="title fn_16px b"><?=$goods->goodsname?></h1>
		  <div class="good_p">
			<i><!--img height="350px" width="408px" src="<?=MEDIA_URL?>img/front/fl.gif" /-->
			<div id="myImagesSlideBox" class="myImagesSlideBox">
				<div class="jqzoom">
					<img src="<?=URL.$pic350[0]?>" class="myImgs" alt="shoe"  jqimg="<?=URL.$pic600[0]?>" bigimg="<?=URL.$pic600[0]?>">
				 </div>
				 <div class="myTxts" >
					<a href="javascript:void(0);">在新窗口查看大图.</a>
				 </div>
				 <div id="scrollable">
					<a class="prev" href="javascript:void(0);" title="上一张"></a>
					<div class="items" >
						<div class="scrollableDiv">
							<?php
							for($i=0;$i<count($goodsthumb);$i++){
							?>
							<a><img width="42" height="42" src="<?=URL.$goodsthumb[$i]?>" imgb="<?=URL.$pic350[$i]?>" bigimg="<?=URL.$pic600[$i]?>"/></a>
							<?php
							}
							?>
							<!--a><img src="<?=MEDIA_URL?>images/d1-small.jpg" imgb="<?=MEDIA_URL?>images/d1.jpg"  bigimg="<?=MEDIA_URL?>images/bigimges_01.jpg" ></a-->
						</div>
						<br clear="all"/>            
					</div>
					<a class="next" href="javascript:void(0);" title="下一张"></a>
				</div>
			</div>
		</i>
      </div>
      <div class="good_nei">
        <ul class="good_jb">
          <li><span>市 场 价：</span><a class="s">￥<?=$goods->marketprice?></a></li>
          <li><span>漫淘客价：</span><a class="m fn_16px">￥<?=$goods->shopprice?></a></li> 
          <li><span>库　　存：</span>现货</li>
        </ul>
        <h3 class="fn_hs"><span class="bt">运费说明：</span><span class="fn_red">免运费</span>　　48小时内完成发货，全国2-4天到达　　<span class="fn_blue">可货到付款区域</span></h3>
		<?php
			//if($goods->integral>0){
		?>
        <div class="jfsm">购买该商品，可获<span class="fn_greed b" ><?=$goods->integral?></span>积分</div>
		<?php
			//}
		?>
		<?=$attribute?>
		
		<!--div class="col"><div class="bt">颜    色：</div><ul><li><h2 class="b">粉红</h2><img src="<?=MEDIA_URL?>img/front/xtu.gif" /></li><li><h2 class="b">黑色</h2><img src="<?=MEDIA_URL?>img/front/xtu.gif" /></li></ul></div-->

        <div class="ord2"><span class="bt"> 我要买：</span><input type="text" />件</div>
        <div class="niu"><a href="<?=URL?>index.php/front/cart/cartInsert?gid=<?=$goods->id?>&loca=2"><img src="<?=MEDIA_URL?>img/front/lj_03.gif" /></a><a href="javascript:void(0);" onclick="cartInert(<?=$goods->id?>)"><img src="<?=MEDIA_URL?>img/front/123.gif" /></a></div>
      </div>     
  </div>
  
  <div class="list">
    <div class="char_title">
         <span id="tb_1" class="hovertab" onclick="x:HoverLi(1);">商品信息</span>
         <!--span id="tb_2" class="normaltab" onclick="i:HoverLi(2);">买家评价</span>
         <span id="tb_3" class="normaltab" onclick="i:HoverLi(3);">购买咨询</span-->
         <span id="tb_2" class="normaltab" onclick="i:HoverLi(2);">相关商品</span>
    </div>
    <div class="dis" id="tbc_01">
      <div class="wz_nei">
       <ul class="spxx">
        <!--li>商品名称：火柴人液晶屏幕保护膜</li>
        <li>生产厂家：火柴人</li>
        <li>商品产地：中国大陆 </li>
        <li>商品毛重：0.01  </li>
        <li>上架时间：2010-1-25 18:09:41</li>
        <li>价格举报：如果您发现有比京东价格更低的，欢迎举报</li>
        <li>纠错信息：如果您发现商品信息不准确，欢迎纠错</li-->
		<?php
			for($i=0;$i<count($normalattr);$i++){
		?>
		<li><?=$normalattr[$i]['aname']?>：<?=$normalattr[$i]['avalue']?></li>
		<?php
			}
		?>
       </ul>
       <div class="clear"></div>
	   <div><?=$goodsext?></div>
       <!--p>
         ● 抗刮度（3H-4H）。<br />
● 高强度Pet ,防尘，防磨，防刮花，防眩光。<br />
● 高透光率95%以上。<br />
● 静电吸附，可水洗，无残留胶质。<br />
● LCD贴心保护,优质画面表现。 
       </p>
       <p>品牌：火柴人<br />
尺寸：10.7*5.7cm（长*宽） 贴膜一张，擦镜布一张 本产品质保期为：无</p>
<p>
漫淘客商城服务承诺：
漫淘客商城向您保证所售商品均为正品行货，自带机打发票，与商品一起寄送。凭质保证书及京东商城发票，可享受全国联保服务，与您亲临商场选购的商品享受相同的质量保证。
漫淘客商城还为您提供具有竞争力的商品价格和免运费政策，请您放心购买！</p> 

<p>声明：因厂家会在没有任何提前通知的情况下更改产品包装、产地或者一些附件，本司不能确保客户收到的货物与商城图片、产地、附件说明完全一致。只能确保为原厂正货！并且保证与当时市场上同样主流新品一致。若本商城没有及时更新，请大家谅解！</p-->
      </div>
    </div>
    <!-- 相关商品 -->
    <div class="undis" id="tbc_02">
		<div class="tj">
		  <ul class="list_tj">
		  	<?php
				for($i=0;$i<3;$i++){
					if(isset($relategoods[$i]['id'])){
						$relatepic = GoodsFront::GetChangeImg(61,$relategoods[$i]['imgcurrent']);
			?>
			<li><div class="img2"><a href="<?=GoodsFront::GetUrl('goods',array('gid'=>$relategoods[$i]['id']));?>"><img src="<?=URL.$relatepic?>" /></a></div><h6><a href="<?=GoodsFront::GetUrl('goods',array('gid'=>$relategoods[$i]['id']));?>"><?=$relategoods[$i]['goodsname']?></a></h6><h4><span class="m2">￥<?=$relategoods[$i]['shopprice']?></span><span class="s">￥<?=$relategoods[$i]['marketprice']?></span></h4><h5><a onclick="cartInert(<?=$relategoods[$i]['id']?>);" href="javascript:void(0);"><img src="<?=MEDIA_URL?>img/front/jrgw.gif" /></a></h5></li>
			<?php
					}
				}
			?>
		  </ul>
		</div>
	</div>
    <!--div class="undis" id="tbc_03">3</div>
    <div class="undis" id="tbc_04">4</div--> 
  </div>
  <div>
    <div class="char_title">
	  <span id="com_1" class="hovertab" onclick="x:HoverCom(1);getgoodscomments();">全部评价<span id="allcomment"></span></span>
	  <span id="com_2" class="normaltab" onclick="i:HoverCom(2);getgoodcomments();">好评<span id="goodcomment"></span></span>
	  <span id="com_3" class="normaltab" onclick="i:HoverCom(3);getmedcomments();">中评<span id="medcomment"></span></span>
	  <span id="com_4" class="normaltab" onclick="i:HoverCom(4);getbadcomments();">差评<span id="badcomment"></span></span>
    </div>
    <div class="dis" id="com1_1">
     
    </div>
	<div class="undis" id="com1_2"></div>
	<div class="undis" id="com1_3"></div>
	<div class="undis" id="com1_4"></div>
  </div>
    
    <div class="char_title">
      <span id="tbx_1" class="hovertab" onclick="x:HoverLix(1);getzq();">全部购买咨询</span>
      <span id="tbx_2" class="normaltab" onclick="i:HoverLix(2);getzqgoods();">商品咨询</span>
      <span id="tbx_3" class="normaltab" onclick="i:HoverLix(3);getzqsend();">库存配送</span>
      <span id="tbx_4" class="normaltab" onclick="i:HoverLix(4);getzqpay();">支付</span>
         <span id="tbx_5" class="normaltab" onclick="i:HoverLix(5);getzqinvoice();">发票保修</span>
         <span id="tbx_6" class="normaltab" onclick="i:HoverLix(6);">支付帮助</span>
         <span id="tbx_7" class="normaltab" onclick="i:HoverLix(7);">配送帮助</span>
         <span id="tbx_8" class="normaltab" onclick="i:HoverLix(8);">常见问题</span>
    </div>
    <div class="dis" id="tbcx_01">
     
      <!--table width="98%" border="0" align="center" cellpadding="5" cellspacing="0" class="ly">
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
      </table-->
      
    </div>
    <div class="undis" id="tbcx_02"></div>
    <div class="undis" id="tbcx_03"></div>
    <div class="undis" id="tbcx_04"></div> 
    <div class="undis" id="tbcx_05"></div>
    <div class="undis" id="tbcx_06"></div>
    <div class="undis" id="tbcx_07"></div>
    <div class="undis" id="tbcx_08"></div>
    
 
  
  
  </div>
  <!--页面左侧结束-->
  
  <div class="yc">
	<!-- 你可能喜欢的 -->
      <div class="yc_top1">
        <h2></h2>
        <div class="yc_nei">
          <ul>
			<?php
				for($i=0;$i<6;$i++){
					if (isset($favorgoods[$i])) {
						$favpic = GoodsFront::GetChangeImg(62,$favorgoods[$i]['imgcurrent']);
			?>
            <li><div class="img2"><a href="<?=GoodsFront::GetUrl('goods',array('gid'=>$favorgoods[$i]['id']))?>"><img src="<?=MEDIA_URL.$favpic?>" /></a></div><h3 class="fn_hs"><a href="<?=GoodsFront::GetUrl('goods',array('gid'=>$favorgoods[$i]['id']))?>"><?=$favorgoods[$i]['goodsname']?></a></h3><h4 class="s">￥<?=$favorgoods[$i]['marketprice']?></h4><h4 class="m2">￥<?=$favorgoods[$i]['shopprice']?></h4></li>  
			<?php
					}
				}
			?>          
          </ul>
        </div>
      </div>
	<!-- 浏览过的商品 -->
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
