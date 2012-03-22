<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>支付-【漫淘客】</title>
<link href="<?=URL?>media/css/mtk.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?=URL?>media/js/hdm.js"></script>
<script src="http://static.comicyu.com/js/jquery.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript">
var payment = function(money){
	var radio = document.getElementsByName("paymode");
	var paymode = 0;
	for(var i=0;i<radio.length;i++){
		if(radio[i].checked==1){
			paymode=radio[i].value;
		}
	}
	document.getElementById("ortype").value=paymode;
	if(paymode ==0){    //如果是漫币支付则先判断登录，余额。
		$.ajax({
			type: "POST",
			 url: "<?=URL?>index.php/front/pay/accountM",
			data: "",
		 success:function (msg){
				if(msg == 'logon'){
					if(confirm("漫币支付需要您的登录，您现在还未登录，现在要登录吗?")){
						window.location="<?=URL?>index.php/front/user/userLogin?ref=<?=URL?>index.php/front/pay/orpay?oid=<?=$oid?>";
					}
				}
				if(msg !='logon' && msg !='error'){
					if(parseInt(money)<=parseInt(msg)){
						document.getElementById('fom').submit();
					}else{
						alert('余额不足');
					}
				}
			}
		});
	}
}
</script>
</head>

<body>
<?php
	include_once(PRO_ROOT."template/default/front/include/nav1.php");
?>
<div id="line"></div>  
<!--头部结束-->
<div class="box">
 
  <div class="box_top m_top"></div>
  <div class="box_bj">
    <h6><img src="<?=URL?>media/img/front/ord3.gif" /></h6>
    <div class="box_nei red_bk">
      <h6 class="fn_24px b">在线支付</h6>
      <div class="cg"><span class="fn_red fn_16px b"><img src="<?=URL?>media/img/front/dui_03.gif" />订单已提交，请尽快付款！</span><span class="fn_hs">还差一步，请在3日内付清款项，否则订单会被自动取消</span></div>
      <div class="cg"><span class="fn_14px b">您的订单号：</span><a href="#"><?=$orderId?></a>     <span class="fn_14px b">应付金额：</span><span class="fn_red b"><?=$orderAmount?>元</span></div>
      <div class="cg"><span class="b">请点击以下银行支付：</span><a href="#">查看订单状态</a>    <a href="#">查看银行限额帮助</a></div>
      <table width="90%" border="0" cellspacing="0" cellpadding="0" class="biao">
        <tr>
          <td width="25"><input type="radio" name="paymode" value="ICBC"/></td>
          <td width="150"><img src="<?=URL?>media/img/front/zg_03.gif" title="中国工商银行"/></td>
          <td>&nbsp;</td>
          <td width="25"><input type="radio" name="paymode" value="CCB" /></td>
          <td width="150"><img src="<?=URL?>media/img/front/bank (2).gif" title="中国建设银行"/></td>
          <td>&nbsp;</td>
          <td width="25"><input type="radio" name="paymode" value="CMB" /></td>
          <td width="150"><img src="<?=URL?>media/img/front/bank (3).gif" title="招商银行"/></td>
          <td>&nbsp;</td>
          <td width="25"><input type="radio" name="paymode" value="BCOM" /></td>
          <td width="150"><img src="<?=URL?>media/img/front/bank (4).gif" title="交通银行"/></td>
        </tr>
        <tr>
          <td><input type="radio" name="paymode" value="GDB" /></td>
          <td><img src="<?=URL?>media/img/front/bank (5).gif" title="广东发展银行"/></td>
          <td>&nbsp;</td>
          <td><input type="radio" name="paymode" value="CIB" /></td>
          <td><img src="<?=URL?>media/img/front/bank (6).gif" title="兴业银行"/></td>
          <td>&nbsp;</td>
          <td><input type="radio" name="paymode" value="CEB" /></td>
          <td><img src="<?=URL?>media/img/front/bank (7).gif" title="中国光大银行"/></td>
          <td>&nbsp;</td>
          <td><input type="radio" name="paymode" value="ABC" /></td>
          <td><img src="<?=URL?>media/img/front/bank (8).gif" title="中国农业银行"/></td>
        </tr>
        <tr>
          <td><input type="radio" name="paymode" value="BOC_SH"/></td>
          <td><img src="<?=URL?>media/img/front/bank (9).gif" title="中国银行-上海"/></td>
          <td>&nbsp;</td>
          <td><input type="radio" name="paymode" value="BOC_GZ"/></td>
          <td><img src="<?=URL?>media/img/front/bank (9).gif" title="中国银行-广州"/></td>
          <td>&nbsp;</td>
          <td><input type="radio" name="paymode" value="SDB" /></td>
          <td><img src="<?=URL?>media/img/front/bank (10).gif" title="深圳发展银行"/></td>
          <td>&nbsp;</td>
          <td><input type="radio" name="paymode" value="SPDB" /></td>
          <td><img src="<?=URL?>media/img/front/bank (11).gif" title="上海浦东发展银行"/></td>
        </tr>
        <tr>
          <td><input type="radio" name="paymode" value="CITIC" /></td>
          <td><img src="<?=URL?>media/img/front/bank (12).gif" title="中信银行"/></td>
          <td>&nbsp;</td>
          <td><input type="radio" name="paymode" value="BOB" /></td>
          <td><img src="<?=URL?>media/img/front/bank (14).gif" title="北京银行"/></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
<div class="cg b">请选择一下支付平台</div>
      <table width="90%" border="0" cellspacing="0" class="biao">
         <tr>
          <td width="18"><input type="radio" name="paymode" value="1"/></td>
          <td width="158"><img src="<?=URL?>media/img/front/bank.gif" title="支付宝"/></td>
          <td width="35">&nbsp;</td>
          <td width="19"><input type="radio" name="paymode" value="KQ" /></td>
          <td width="176"><img src="<?=URL?>media/img/front/bank_34.jpg" title="快钱"/></td>
          <td width="59">&nbsp;</td>
          <td width="57">&nbsp;</td>
          <td width="57">&nbsp;</td>
          <td width="57">&nbsp;</td>
          <td width="57">&nbsp;</td>
          <td width="107">&nbsp;</td>
        </tr>
        <tr>
      </table>
       <table width="90%" cellpadding="0" cellspacing="0">
        <tr>
          <td width="11%" class="fn_16px b">应付金额：</td>
          <td width="15%" class="fn_14px b fn_red"><?=$orderAmount?>元</td>
          <!--<td width="10%" class="fn_14px b">支付密码：</td>
          <td width="25%"><input type="text" class="kuang" id="pwd" value=""/></td>-->
          <td width="39%"><img src="<?=URL?>media/img/front/qrzf_03.gif" style="cursor:pointer;" onclick="payment('<?=$orderAmount?>')"/></td>
        </tr>
      </table> 
      <!--<div class="hz"><img src="<?=URL?>media/img/front/th.gif" />您的购买款项付到漫淘客，等待您收到货确认后，才会将款项转汇给漫淘客，请放心使用！ </div>-->
    </div>
    <form action="<?=PAYURL?>index.php/pay/mall?act=1" method="POST" id="fom">
		<input type="hidden" name="orderId" value="<?=$orderId?>" />
		<input type="hidden" name="payerId" value="<?=$payerId?>" />
		<input type="hidden" name="orderAmount" value="<?=$orderAmount?>" />
		<input type="hidden" name="orderType" id="ortype" value="0" />
		<input type="hidden" name="orderTime" value="<?=$orderTime?>" />
		<input type="hidden" name="rtnUrl" value="<?=$rtnUrl?>" />
		<input type="hidden" name="signMsg" value="<?=$signMsg?>" />
	</form>
    <div class="fn_16px b fn_hs center">如有疑问请咨询在线客服，或拨打客服电话400-500-8888。</div>
   
   <!-- <div class="line2 clear"></div>
    <div class="tj tj2">
      <h2>最近您浏览过的商品</h2>
      <ul class="list_tj">
        <li><div class="img2"><img src="<?=URL?>media/img/front/tu2.gif" /></div><h6>夏天了！【凉宫春日】</h6><h4><span class="m2">￥85.00</span><span class="s">￥135.00</span></h4><h5><a href="#"><img src="<?=URL?>media/img/front/jrgw.gif" /></a></h5></li>
        <li><div class="img2"><img src="<?=URL?>media/img/front/tu2.gif" /></div><h6>夏天了！【凉宫春日】</h6><h4><span class="m2">￥85.00</span><span class="s">￥135.00</span></h4><h5><a href="#"><img src="<?=URL?>media/img/front/jrgw.gif" /></a></h5></li>
        <li><div class="img2"><img src="<?=URL?>media/img/front/tu2.gif" /></div><h6>夏天了！【凉宫春日】</h6><h4><span class="m2">￥85.00</span><span class="s">￥135.00</span></h4><h5><a href="#"><img src="<?=URL?>media/img/front/jrgw.gif" /></a></h5></li>
        <li><div class="img2"><img src="<?=URL?>media/img/front/tu2.gif" /></div><h6>夏天了！【凉宫春日】</h6><h4><span class="m2">￥85.00</span><span class="s">￥135.00</span></h4><h5><a href="#"><img src="<?=URL?>media/img/front/jrgw.gif" /></a></h5></li>
      </ul>
    </div>-->
    
  </div>
  
  <div class="box_bottom"></div>
</div>
</body>
</html>
