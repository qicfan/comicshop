
<!-- 网页头部 -->
<div class="head">

<div class="head">
  <div class="login fn_hs">
  <?php
  if (auth::isUserLogin() == true) {
  ?>
  您好：<?=$uname?><span class="out_login fn_hs">[<a href="<?=URL?>my/index.html">个人中心</a>] | [<a href="<?=URL?>index.php/front/user/userLogout">退出登录</a>]</span>
  <?php
  } else {
	  $this_url = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
  ?>
  <span class="out_login fn_hs">[<a href="<?=URL?>index.php/front/user/userLogin?ref=<?=urlencode($this_url)?>">登录</a>] | [<a href="<?=URL?>index.php/front/user/userReg?ref=<?=urlencode($this_url)?>">注册</a>]</span>
  <?php
  }
  ?>
  </div>
  <div class="serch">
    <div id="logo"><a href="<?=URL?>"><img src="<?=MEDIA_URL . 'img/front/logo.jpg'?>" alt="漫淘客" /></a></div>
    <div id="so">
      <form>
        <input class="ssk" type="text" /><div id="so_niu">搜　索</div>
      </form>
    </div>
    <div class="kf"><img src="<?=MEDIA_URL?>img/front/kf.gif" /></div>
  </div> 
 
  <div class="wygj">
    <span><a href="#"><img src="<?=URL?>media/img/front/wdmtk_02.gif" /></a></span>
    <span><a href="#"><img src="<?=URL?>media/img/front/wddd_02.gif" /></a></span>
    <span><a href="#"><img src="<?=URL?>media/img/front/wdscj_02.gif" /></a></span>
  </div>

</div>
<div class="nav">
  <div class="nav_nei">
    <div class="nav_dh fn_14px fn_bs">
      <a href="<?=URL?>">首  页</a><a href="<?=URL?>goodslist_38792_1_1_1.html">动  漫</a><a href="<?=URL?>goodslist_38795_1_1_1.html">桌  游</a><a href="<?=URL?>goodslist_38796_1_1_1.html">创  意</a><a href="<?=URL?>goodslist_38797_1_1_1.html">COSPLAY</a><a href="#">全部分类</a>
    </div>
   <div class="kjfs"><span class="order" style="cursor:pointer;" onmousemove="cartBrief()">我的购物车</span><span style="cursor:pointer;"><img src="<?=URL?>media/img/front/niu1.gif"/></span><span class="go"><a href="<?=URL?>index.php/front/cart/cartSelect" style="color:black;">去结算</a></span></div>

		<div id="xsk" style="z-index:100;position:absolute;display:none;">
			<div id="spzs">
			<div class="xx_1">
				<div class="tu_z"><img src="img/front/imgs_07.gif" /></div>
				<div class="s_name">商品名称唱片名称商品名称商品名称称唱片名称商名称商品名称称唱片名称商名称商品名称称唱</div>
				<div class="s_pice fn_14px fn_red b">300*2<br /><span class="fn_hs"><a href="#">删除</a></span></div>
			</div>
			</div>
			<div class="tatil">共<span class="fn_red" id="gcount">0</span>件商品&nbsp;&nbsp;&nbsp;&nbsp;金额共计：<span class="fn_red b" id="submoney">0元</span></div>
			<div><!--<span class="left"><a href="#">寄存购物车</a></span>--><span class="right"><a href="<?=URL?>index.php/front/cart/cartSelect" style="color:#0066FF;">去购物车并结算</a></span></div>
		</div>
	</div> 
</div>

<div id="line"></div>
<!--头部结束-->

<script type="text/javascript">
$.get("<?=URL?>index.php/front/user/checklogin",function(data){
	$("#headline").empty();
	$(data).appendTo("#headline");
});

function cartBrief(){
	$.ajax({
		type:"POST",
		 url:"<?=URL?>index.php/front/cart/cartBrief",
		data:"",
	 success:function (msg){
			obj = eval("("+msg+")");
			if(obj != null){
				count = 0;
				qian = 0;
				document.getElementById('spzs').innerHTML="";
				for(var i=0;i<obj.length;i++){
					count+=parseInt(obj[i]['goodscount']);
					qian+=parseFloat(obj[i]['shoppirce'])*parseInt(obj[i]['goodscount']);
			
					var p = document.createElement("div");
					p.id="show"+obj[i]['id'];
					p.className="xx_1";
					p.innerHTML="<div class='tu_z'><img src=\"<?=URL?>"+obj[i]['pic']+"\"/></div><div class='s_name'>"+obj[i]['goodsname']+"</div><div class='s_pice fn_12px fn_red b'>"+obj[i]['shoppirce']+"*"+obj[i]['goodscount']+"<br/><span class='fn_hs'><a href='<?=URL?>index.php/front/cart/delCart?cart="+obj[i]['id']+"' style='color:#9D9D9D;'>删除</a></span></div>";
					
					document.getElementById('spzs').appendChild(p);
				}
				$("#gcount").html(count);
				$("#submoney").html(qian+"元");
				document.getElementById("xsk").style.display="block";
			}
		}
	});
}

document.onclick=function(){
	document.getElementById("xsk").style.display="none";
}
</script>