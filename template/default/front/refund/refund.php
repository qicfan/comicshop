<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>退款申请</title>
<link href="<?=MEDIA_URL?>css/mtk_yh.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?=MEDIA_URL?>js/hdm.js"></script>
</head>

<body>
 <!-- 头部-->
<?php include PRO_ROOT."template/default/front/include/nav2.php"; ?> 
 <!-- 左侧导航-->
<?php include PRO_ROOT."template/default/front/include/user.php"; ?>

  <!-- 主要内容-->
  <div class="box_left">
    <div class="char_title">
      <span class="hovertab">退款申请单</span>         
    </div>
    <div id="tbch_01">
      <table width="832" border="0" cellspacing="0" class="dd_li">
        <tr bgcolor="#e8e8e8" class="fn_hs">
          <td width="210" height="34" align="center">退款方式</td>
          <td width="132" align="center">退款金额</td>
          <td width="190" align="center">涉及订单</td>
          <td width="112" align="center">申请时间</td>
          <td width="107" align="center">处理状态</td>
          <td width="67" align="center">操作</td>
          
        </tr>
<?php foreach ($refund->objectList() as $v){ ?>
        <tr>
          <td height="40" align="center"><?=($v->type=='1')?'退款至账户余额':'退款至银行卡'?></td>
          <td align="center" class="fn_red b"><?=$v->amount?></td>
          <td align="center"><?=$v->orderid?></td>
          <td align="center"><span class="fn_red"><?=empty($v->refundtime) ? '-' : date('Y-m-d',$v->refundtime)?></span></td> 
          <td align="center"><?=$v->state?></td>
          <td align="center"><a href="#none">详细</a></td>         
        </tr>
<?php } ?>      
        <tr>
          <td height="31" align="center">&nbsp;</td>
          <td align="center" class="fn_red b">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td colspan="2" align="center">退款申请总数：<span class="fn_red"><?=$count?></span></td>
        </tr>
       
      </table>    
    </div>
    <div class="char_title sbj">
      <span class="hovertab">退款申请</span>         
    </div>
<form id="formrefund" method="post">
    <div id="tbch_02" class="bk">
      <div class="nei">
        <div class="tim b">退款方式：</div>
        <ul class="tim_r">
          <li>
           <input id="type" type="radio" name="type" value="1" checked="checked" />
            退款至账户余额（不会收取手续费，今后可随之将账户余额退至银行卡）</li>
          <li>
            <input id="type" type="radio" name="type" value="2" />
            退款至银行卡（跨行退款需要扣除一定积分用以支付银行手续费）</li>
        </ul>
      </div>
      <div class="nei">
        <div class="tim b">申请退款订单编号：</div>
        <ul class="tim_r">
          <li>
            <input type="text" name="orderid" id="orderid" class="kuang" />
            <span id="odtext">（请输入需要申请退款的订单编号，一次退款申请只能输入一个订单编号）</span></li>
        </ul>
        <div class="tim b">申请人姓名：</div>
        <ul class="tim_r">
          <li>
            <input type="text" name="refundname" id="refundname" class="kuang" />
          </li>
        </ul>
      </div>
      <div class="nei">
        <div class="tim b">银行卡信息</div>
        <div class="clear"></div>
        <ul class="tim_r">
          <li><span class="tim">开户行：</span>
<select name="bank" id="bank">
	<option value="1">农业银行</option>
	<option value="2">工商银行</option>
	<option value="3">建设银行</option>
	<option value="4">中国银行</option>
	<option value="5">交通银行</option>
	<option value="5">招商银行</option>
</select>
        </li>
          <li><span class="tim">开户人姓名：</span>
            <input name="accountname" id="accountname" class="kuang" type="text" />
          </li>
          <li><span class="tim">开户银行账号：</span>
            <input name="bankcard" id="bankcard" class="kuang" type="text" />
          </li>
          <li><span class="tim">再次输入账号：</span>
            <input name="rebankcard" id="rebankcard" class="kuang" type="text" />
          </li>
          <li><span class="tim">支行信息：</span>
            <input name="openingbank" id="openingbank" class="kuang kuang3" type="text" />
          </li>
        </ul>
      </div>
      <div class="nei">
        <div class="tim b">退款原因：</div>
        <ul class="tim_r">
          <li><textarea name="remark" id="remark" class="kuang kuang2"></textarea></li>
        </ul>
        <div class="tim b">验证码：</div>
        <ul class="tim_r">
          <li><input type="text" id="seccode" name="seccode" class="kuang" /></li>
          <li><img id="authcode"  onclick="this.src='<?=URL?>index.php/seccode/index?' + Math.round(Math.random()*2)"  src="<?=URL?>index.php/seccode" alt="验证码"  width="90" height="20" /></li>
          <li><input type="button" id="tj" value="提交退款申请" /></li>
        </ul>
      </div>
    </div>
	</form>
  </div>
  <!-- 主要内容结束-->
</div>
<script src="http://static.comicyu.com/js/jquery.js" type="text/javascript"></script>
<script language="javascript">

//    $('#orderid').blur(function(){
//		var oidf = true;
//		if(this.value != ''){
//			//alert(this.value);
//			$.get('<?=URL?>index.php/front/refund/checkOid',{oid:this.value},function(data){
//				if(data==0){
//				    	$("#odtext").addClass("fn_red");
//						$("#odtext").html("<b>订单编号不存在！请查证后再申请！</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
//						var oidf = false;
//				}
//			}, 'json');
//		} else {
//			$("#odtext").addClass("fn_red");
//		    $("#odtext").html("<b>订单编号不能为空</b>！&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
//			var oidf = false;
//		}
//	     
//	});
	$('#tj').click(function(){
		var seccode = $('#seccode').attr("value");
		var accountname  = $('#accountname').attr("value");
        var bankcard  = $('#bankcard').attr("value");
		var rebankcard  = $('#rebankcard').attr("value");
		var openingbank  = $('#openingbank').attr("value");
		var remark  = $('#remark').attr("value");
		var orderid  = $('#orderid').attr("value");

			if (orderid=='') {
				alert('订单编号不能为空！');
				 $('#orderid').focus();
			}else if (accountname=='') {
				alert('开户人姓名不能为空！');
				 $('#accountname').focus();
			}else if(bankcard==''){
				alert('开户银行账号不能为空！');
				$('#bankcard').focus();
			}else if(rebankcard!=bankcard){
				alert('两次输入的银行帐号不一致！');
				$('#rebankcard！').focus();
			}else if(openingbank==''){
				alert('支行信息不能为空！');
				$('#openingbank').focus();
			}else if(remark==''){
				alert('退款原因不能为空！');
				$('#remark').focus();
			}else if(seccode==''){
				alert('请填写验证码！');
				$('#seccode').focus();
			}else{
				$("#formrefund").submit(); 
			}			
		});

</script>
</body>
</html>
