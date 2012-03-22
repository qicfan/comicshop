<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>订单信息页-【漫淘客】</title>
<link href="<?=URL?>media/css/mtk.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?=URL?>media/js/hdm.js"></script>
<script type="text/javascript" src="<?=URL?>media/js/jquery-1.3.2.min.js"></script>
<script src="<?=URL?>media/plugin/DatePicker/WdatePicker.js" type="text/javascript"></script>
<script type="text/javascript">
/** 下一步 */
function nextstep(){
	var consigner = $link("consigner").value;
	if(checkConsigner(consigner)){    //验证用户名
		var addr = $link("addr").value;
		if(addr.length !=0){
			var zip = $link("zip").value;
			if(checkZip(zip)){    //验证邮编
				var email = $link("email").value;
				if(checkEmail(email)){
					var phone = $link("phone").value;
					var tel = $link("tel").value;
					if(phone.length==0 && tel.length==0){
						alert("固定电话和手机号码不能同时为空。");
					}else{
						if(phone.length !=0){
							if(checkPhone(phone)){    //验证电话
								document.getElementById('fom').action="<?=URL?>index.php/front/order/makeOrder";
								document.getElementById('fom').submit();
							}
						}
						if(tel.length !=0){
							if(checkTel(tel)){
								document.getElementById('fom').action="<?=URL?>index.php/front/order/makeOrder";
								document.getElementById('fom').submit();
							}
						}
					}
				}
			}
		}else{
			alert('收货地址不能为空！');
		}
	}
}

/** 验证电子邮件 */
function checkEmail(email){
	if(email.length==0){
		alert('请输入电子邮件地址！');
		return false;
	}
	var check = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
	if(check.test(email)){
		return true;
	}else{
		alert("您的电子邮件地址有误！");
		return false;
	}
}

/** 验证手机 */
function checkTel(tel){
	if(tel.length==0)
    {
        return false;
    }
    if(tel.length!=11)
    {
        alert('请输入有效的手机号码！');
        return false;
    }
	if(tel.match(/^(((13[0-9]{1})|159|153|158|150|151|152|154|155|156|157)+\d{8})$/)){
		return true;
	}else{
		alert('手机号码有误，请重新输入！');
		return false;
	}
}

/** 验证固定电话 */
function checkPhone(phone){
	if(phone.length ==0){
		return false;
	}
	var reg3 = /\d{3}-\d{8}|\d{4}-\d{7}/;
	if(reg3.test(phone)){
		return true;
	}else{
		alert("固定电话可能有误！");
		return false;
	}
}

/** 验证邮编 */
function checkZip(zip){
	if(zip == ''){
		alert("邮政编码不能为空！");
		return false;
	}
	var reg2 = /^[1-9]\d{5}$/;
	if(reg2.test(zip)){
		if(zip.length!=6){
			alert("邮政编码有误！");
			return false;
		}else{
			return true;
		}
	}else{
		alert("邮政编码有误！");
		return false;
	}
}

/** 验证收货人 */
function checkConsigner(consigner){
	if(consigner == ''){
		alert("收货人姓名不能为空。");
		return false;
	}
	var reg = /[^\u4e00-\u9fa5]/;
	if(!reg.test(consigner)){
		if(consigner.length >4){
			alert("您的收货人名字有那么长吗？");
			return false;
		}else{
			return true;
		}
	}else{
		var reg1 =/^[A-Za-z]/;
		if(reg1.test(consigner)){
			if(consigner.length >20){
				alert("您的收货人名字有那么长吗？");
				return false;
			}else{
				return true;
			}
		}else{
			alert("您的收货人名字有误。");
			return false;
		}
	}
}

/** 点击修改 */
function updateinfo(obj){
	document.getElementById(obj+'xg').style.display='block';
	document.getElementById(obj).style.display='none';
}

/** 点击关闭 */
function closeinfo(obj){
	document.getElementById(obj).style.display='block';
	document.getElementById(obj+'xg').style.display='none';
}

/**  删除常用地址 */
function consigndel(conid){
	$.ajax({
		type: "POST",
		url: "<?=URL?>index.php/front/order/infodel",
		data:"conid="+conid,
		success:function (msg){
			if(msg == 'ok'){
				document.getElementById("chyaddr"+conid).style.display='none';
				alert("删除成功！");
			}
		}
	});
}

/** id取对象 */
function $link(val){
	return document.getElementById(val);
}

/** 根据值选中单选按钮 */
function defvalue(val,obj){
	var opt = document.getElementById(obj).innerHTML.toString();
	//alert(opt);
	var re = new RegExp(val,"g");
	var opts = opt.replace(/<OPTION|<\/OPTION>| selected|val/g,"").match(/=.*?>/g).toString().replace(/=|>/g,"").replace(re,"┢").replace(/[^,┢]/g,"").indexOf("┢");
	document.getElementById(obj).options[opts].selected = true;
	
}

function  province(prov,city,county){
	if(junior(1,'s1')){
		defvalue(prov,'s1');	
	}
	setTimeout("city('"+prov+"','"+city+"','"+county+"')",500);
}

function city(prov,city,county){
	if(junior(prov,'s2')){
		defvalue(city,'s2');
	}
	setTimeout("county('"+city+"','"+county+"')",500);
}

function county(city,county){
	if(junior(city,'s3')){
		defvalue(county,'s3');
	}
}

/**  选择常用地址 */
function consign(conid,consign,addr,zip,phone,tel,email,prov,city,county,pro,cit,coun){
	setTimeout("province('"+prov+"','"+city+"','"+county+"')",500);
	$link('upconsid').value=conid;
	$link('upcons').value=consign;
	$link('upaddr').value=addr;
	$link('upzip').value=zip;
	$link('upphone').value=phone;
	$link('uptel').value=tel;
	$link('upemail').value=email;

	$link('consigner').value=consign;
	$link('prov').innerHTML=pro+cit+coun;
	$link('pro').value = prov;
	$link('city').value = city;
	$link('county').value = county;
	$link('addr').value = addr;
	$link('zip').value = zip;
	$link('phone').value = phone;
	$link('tel').value = tel;
	$link('email').value = email;
}

/** 更新省市县下级 */
function junior(pid,s){
	bl = false;
	if(pid == ''){
		bl = false;
	}else{
		$.ajax({
			type: "POST",
			 url: "<?=URL?>index.php/views/regionSelect",
			data: "id="+pid,
		   async: false,
		 success: function(data){
				if(data != ''){
					$('#'+s).html(data);
					bl = true;
				}
			}
		})
	}
	return bl;
}



/** 地址保存 */
function conssave(){
	var consigner = document.getElementById('upcons').value;
	var addr = document.getElementById('upaddr').value;
	var zip = document.getElementById('upzip').value;
	var phone = document.getElementById('upphone').value;
	var tel = document.getElementById('uptel').value;
	var email = document.getElementById('upemail').value;
	pro = '';
	cit = '';
	coun = '';
	if(document.getElementById('s1').selectedIndex>0){
		var s1 = document.getElementById('s1').options[document.getElementById('s1').selectedIndex].value;
		var pro = document.getElementById('s1').options[document.getElementById('s1').selectedIndex].text;
	}
	if(document.getElementById('s2').selectedIndex>0){
		var s2 = document.getElementById('s2').options[document.getElementById('s2').selectedIndex].value;
		var cit = document.getElementById('s2').options[document.getElementById('s2').selectedIndex].text;
	}
	if(document.getElementById('s3').selectedIndex>0){
		var s3 = document.getElementById('s3').options[document.getElementById('s3').selectedIndex].value;
		var coun = document.getElementById('s3').options[document.getElementById('s3').selectedIndex].text;
	}
	$.ajax({
		type: "POST",
		url: "<?=URL?>index.php/front/order/infoSave",	data:"consigner="+consigner+"&uptel="+tel+"&upaddr="+addr+"&zip="+zip+"&phone="+phone+"&upemail="+email+"&province="+s1+"&city="+s2+"&county="+s3,
		success:function (msg){
			if(msg=='ok'){
				$link('consigner').value=consigner;
				$link('prov').innerHTML=pro+cit+coun;
				$link('pro').value = s1;
				$link('city').value = s2;
				$link('county').value = s3;
				$link('addr').value = addr;
				$link('zip').value = zip;
				$link('phone').value = phone;
				$link('tel').value = tel;
				$link('email').value = email;
				$link('cons').style.display='block';
				$link('consxg').style.display='none';
			}
		}
	});
}

/** 添加常用地址 */
function consadd(){
	var consigner = $link('upcons').value;
	var addr = $link('upaddr').value;
	var zip = $link('upzip').value;
	var phone = $link('upphone').value;
	var tel = $link('uptel').value;
	var email = $link('upemail').value;
	pro = '';
	cit = '';
	coun = '';
	if(document.getElementById('s1').selectedIndex>0){
		var s1 = document.getElementById('s1').options[document.getElementById('s1').selectedIndex].value;
		var pro = document.getElementById('s1').options[document.getElementById('s1').selectedIndex].text;
	}
	if(document.getElementById('s2').selectedIndex>0){
		var s2 = document.getElementById('s2').options[document.getElementById('s2').selectedIndex].value;
		var cit = document.getElementById('s2').options[document.getElementById('s2').selectedIndex].text;
	}
	if(document.getElementById('s3').selectedIndex>0){
		var s3 = document.getElementById('s3').options[document.getElementById('s3').selectedIndex].value;
		var coun = document.getElementById('s3').options[document.getElementById('s3').selectedIndex].text;
	}

	$.ajax({
		type: "POST",
		url: "<?=URL?>index.php/front/order/infoAdd",	data:"consigner="+consigner+"&tel="+tel+"&addr="+addr+"&zip="+zip+"&phone="+phone+"&email="+email+"&province="+s1+"&city="+s2+"&county="+s3,
		success:function (msg){
			if(msg !='error'){
				var p = document.createElement("p");
				p.id="chyaddr"+msg;
				p.innerHTML="<span class='rq'><a href='#' onclick=\"consigndel('"+msg+"')\">删除</a></span><input type='radio' name='banally' onclick=\"consign('"+msg+"','"+consigner+"','"+addr+"','"+zip+"','"+phone+"','"+tel+"','"+email+"','"+s1+"','"+s2+"','"+s3+"','"+pro+"','"+cit+"','"+coun+"')\"/>"+consigner+"&nbsp;"+pro+cit+coun+addr;
				document.getElementById('chy').appendChild(p);
				document.getElementById('chy').style.display='block';
			}
		}
	});
}

/** 配送与支付方式 */
function postty(ty){
	if(ty==0){
		$link("ztt").style.display="block";
	}else{
		$link("ztt").style.display="none";
	}
}

/** 保存配送支付方式 */
function paypost(){
	var obj = document.getElementsByName('posttype');
	var ty ='';
	var tyt = '';
	var ptxt = '';
	for(var i=0;i<obj.length;i++){
		if(obj[i].checked==1){
			ty = obj[i].value;
		}
	}
	if(ty==1){
		tyt = '快递';
	}
	if(ty==0){
		tyt = '上门自提';
	}
	if(ty==3){
		tyt = '货到付款';
	}
	var payobj =document.getElementsByName('payt');
	var pay = '';
	
	for(var i=0;i<payobj.length;i++){
		if(payobj[i].checked == 1){
			pay = payobj[i].value;
		}
	}
	if(pay == 1){
		ptxt = '货到付款';
	}
	if(pay == 0){
		ptxt = '在线支付';
	}
	$link('paytyp').value=pay;
	$link('zhftyp').innerHTML= ptxt;
	$link('payty').value=ty;
	$link('zhf').innerHTML=tyt;
	var tim = $link('ztim').value;
	$link('szttime').innerHTML= tim;
	$link('zttime').value = tim;
	$link("pay").style.display="block";
	$link("payxg").style.display="none";
}

/** 保存发票 */
function savefp(){
	var fptyobj = document.getElementsByName('fpty');
	var fpttobj = document.getElementsByName('fptt');
	var fpcontent = document.getElementsByName('fpcontent');
	var fpty = '';
	var fptt = '';
	var fpcont = '';
	for(var i=0;i<fptyobj.length;i++){
		if(fptyobj[i].checked ==1){
			fpty = fptyobj[i].value;
		}
	}
	for(var j=0;j<fptyobj.length;j++){
		if(fptyobj[j].checked ==1){
			fptt = fptyobj[j].value;
		}
	}
	for(var l=0;l<fpcontent.length;l++){
		if(fpcontent[l].checked ==1){
			fpcont = fpcontent[l].value;
		}
	}
	if(fpty == 0){
		$link("fptype").innerHTML='普通发票';
	}
	if(fpty == 1){
		$link("fptype").innerHTML="增值税发票";
	}
	$link("fplx").value=fpty;
	if(fptt == 1){
		$link("fphead").innerHTML="个人";
	}
	if(fptt == 2){
		$link("fphead").innerHTML="单位";
	}
	$link("fptaitou").value=fptt;
	if(fpcont == 1){
		$link("fpcont").innerHTML="明细";
	}
	if(fpcont == 2){
		$link("fpcont").innerHTML="办公用品";
	}
	if(fpcont ==3){
		$link("fpcont").innerHTML="电脑配件";
	}
	if(fpcont ==4){
		$link("fpcont").innerHTM="耗材";
	}
	$link("fpnr").value=fpcont;
	$link("fpxg").style.display="none";
	$link("fp").style.display="block";
}

/** 选择优惠券 */
function tickets(t){
	var tid = t.value;
	var tx= t.options[t.selectedIndex].text;
	$link("tickid").value=tid;
	$link("ticket").innerHTML = tx;
	var tickmoney = tx.substring(tx.indexOf('用')+1,tx.indexOf('元'));
	$link('tickmoney').value=tickmoney;
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
 <form action="" method="POST" id="fom">
  <div class="box_top m_top"></div>
  <div class="box_bj">
    <h6><img src="<?=URL?>media/img/front/ord2_03.gif" /></h6>
    <div class="box_nei">
      <div class="order_top fn_14px b fn_hs">请核对订单信息</div>
      <div id="cons" class="xx" style="display:block;">
        <h1>收货人信息<span><a href="#" onclick="updateinfo('cons')">修改</a></span></h1>
        <ul>
		<?php
			$prov = base::getRegionName($zjconsign[0]->province);
			$city = base::getRegionName($zjconsign[0]->city);
			$county = base::getRegionName($zjconsign[0]->county);
		?>
          <li><span class="tim_z">收货人姓名：</span><input type="text" class="kuang" readonly="readonly" style="border:0;" id="consigner" name="consigner" value="<?=$zjconsign[0]->consigner?>"/></li>
         <li><span class="tim_z">省    份：</span><span id="prov"><?=$prov.$city.$county?></span>
			<input type="hidden" id="pro" name="pro" readonly="readonly" style="border:0;" value="<?=$zjconsign[0]->province?>"/>
			<input type="hidden" id="city" name="city" readonly="readonly" style="border:0;" value="<?=$zjconsign[0]->city?>"/>
			<input type="hidden" id="county" name="county" readonly="readonly" style="border:0;" value="<?=$zjconsign[0]->county?>"/>
		  </li>
          <li><span class="tim_z">地    址：</span><input type="text" readonly="readonly" style="border:0;" id="addr" name="addr" value="<?=$zjconsign[0]->address?>"/></li>
          <li><span class="tim_z">邮    编：</span><input type="text" readonly="readonly" style="border:0;" id="zip" name="zip" value="<?=$zjconsign[0]->zipcode?>"/></li>
          <li><span class="tim_z">固定电话：</span><input type="text" readonly="readonly" style="border:0;" id="phone" name="phone" value="<?=$zjconsign[0]->phone?>"/></li>
          <li><span class="tim_z">手机号码：</span><input type="text" readonly="readonly" style="border:0;" id="tel" name="tel" value="<?=$zjconsign[0]->tel?>"/></li>
          <li><span class="tim_z">电子邮件：</span><input type="text" readonly="readonly" style="border:0;" id="email" name="email" value="<?=$zjconsign[0]->email?>"/></li>
        </ul>
      </div>

	  <div id="consxg" class="xx" style="display:none;">
        <h1>收货人信息<span><a href="#" onclick="closeinfo('cons')">关闭</a></span></h1>
       <?php
		if($consign !=''){
	   ?>
		<div style=" padding:25px 0 0 60px;">
			<div id="chy" class="kuai">
				<h4 class="fn_hs b">常用地址：</h4>
				<?php
					foreach ($consign as $item){
					$prov = base::getRegionName($item->province);
					$city = base::getRegionName($item->city);
					$county = base::getRegionName($item->county);
				?>
				<p id="chyaddr<?=$item->id?>">
					<span class="rq"><a href="#" onclick="consigndel('<?=$item->id?>')">删除</a></span>
					<input type="radio" name="banally" onclick="consign('<?=$item->id?>','<?=$item->consigner?>','<?=$item->address?>','<?=$item->zipcode?>','<?=$item->phone?>','<?=$item->tel?>','<?=$item->email?>','<?=$item->province?>','<?=$item->city?>','<?=$item->county?>','<?=$prov?>','<?=$city?>','<?=$county?>')"/><?=$item->consigner.' '.$prov.$city.$county.$item->address?>  
				</p>
				<?php
				}
				?>
			</div>
		</div>
		<?php
		 }
		?>
        <div class="clear"></div>
        <ul class="sh">
			<input type="hidden" id="upconsid" value=""/>
          <li>
			<span class="tim_z"><span class="fn_red">*</span>　收货人姓名：</span>
            <input type="text" class="kuang" id="upcons" value="<?=$zjconsign[0]->consigner?>"/>
		  </li>
          <li><span class="tim_z"><span class="fn_red">*</span>　省    份：</span>
			<!--级联选择-->
			<script>
			$(document).ready(function(){
				$(':select').change( function(){
					var id = $(this).val();
					var level = $(this).attr('id');
					level = parseInt( level.replace('s', '') );  //得到当前级数
					if (level > 2) {
						return false;  //最大级数
					}
					if (level == 1) {
						$('#s3').html('');  //选择第一级的时候清空第三级的结果
					}
					level++;
					post = { id:id };
					$.post( '<?=URL?>index.php/views/regionSelect', post,
						function(data) {
							$('#s'+level).html(data); //将结果显示出来
						}
					);
				});
			});
			</script>
			<select id="s1" name="province" style="width:80px">
			  <option value=" ">请选择...</option>
			  <?php
			  $rs = base::getRegion(1);
			  foreach ($rs as $i=>$v){
			  ?>
			  <option value="<?=$v->id?>"><?=$v->region_name?></option>
			  <?php
			  }
			  ?>
			</select>
			<select id="s2" name="city" style="width:80px">
				<option value=" ">请选择...</option>
				<?php
				$rs = base::getRegion($zjconsign[0]->province);
				foreach ($rs as $i=>$v){
				?>
				<option value="<?=$v->id?>"><?=$v->region_name?></option>
				<?php
				}
				?>
			</select>
			<select id="s3" name="county" style="width:80px">
				<option value=" ">请选择...</option>
				<?php
				$rs = base::getRegion($zjconsign[0]->city);
				foreach ($rs as $i=>$v){
				?>
				<option value="<?=$v->id?>"><?=$v->region_name?></option>
				<?php
				}
				?>
			</select>
			<script>
				var obj1=document.getElementById("s1").options;
				for(var i=0;i<obj1.length;i++){
					if(obj1[i].value=='<?=$zjconsign[0]->province?>'){
						obj1[i].selected=true;
					}
				}
				var obj2=document.getElementById("s2").options;
				for(var i=0;i<obj2.length;i++){
					if(obj2[i].value=='<?=$zjconsign[0]->city?>'){
						obj2[i].selected=true;
					}
				}
				var obj3=document.getElementById("s3").options;
				for(var i=0;i<obj3.length;i++){
					if(obj3[i].value=='<?=$zjconsign[0]->county?>'){
						obj3[i].selected=true;
					}
				}
			</script>
			<!--级联选择End-->	
		  </li>
          <li><span class="tim_z"><span class="fn_red">*</span>　地    址：</span>
            <input type="text" class="kuang" id="upaddr" value="<?=$zjconsign[0]->address?>"/>
          <a href="#">查看货到付款地区</a></li>
          <li>
			<span class="tim_z">邮    编：</span>
			<input type="text" class="kuang" id="upzip" value="<?=$zjconsign[0]->zipcode?>"/>
			<span class="fn_hs">有助于快速确定送货地址</span>
		  </li>
          <li>
			<span class="tim_z">固定电话：</span>
			<input type="text" class="kuang" id="upphone" value="<?=$zjconsign[0]->phone?>"/>
			<span class="fn_hs">如：010-12345678，固话与手机至少填写一项</span></li>
          <li>
			<span class="tim_z">手机号码：</span>
			<input type="text" class="kuang" id="uptel" value="<?=$zjconsign[0]->tel?>"/>
			<span class="fn_hs">填写手机号便于接收发货通知短信及送货前确认</span>
		  </li>
          <li>
			<span class="tim_z">电子邮件：</span>
			<input type="text" class="kuang" id="upemail" value="<?=$zjconsign[0]->email?>"/>
			<span class="fn_hs">用来接收订单提醒邮件，便于您及时了解订单状态</span>
		  </li>
        </ul>
        <div class="bz">
			<img src="<?=URL?>media/img/front/an1_03.gif" onclick="conssave()" style="cursor:pointer;"/>
			<img src="<?=URL?>media/img/front/an1_05.gif" onclick="consadd()" style="cursor:pointer;"/>
		</div>
      </div>
      
      <div id="pay" class="xx" style="display:block;">
        <h1><strong>支付及配送方式</strong><span><a href="#" onclick="updateinfo('pay')">修改</a></span></h1>
        <ul id="zt">
          <li><span class="tim_z">配送方式：</span><span id="zhf">快递</span><input type="hidden" name="payty" id="payty" value="1"/></li>
		  <li><span class="tim_z">支付方式：</span><span id="zhftyp">在线支付</span><input type="hidden" name="paytyp" id="paytyp" value="0"/></li>
          <li><span class="tim_z">自 提 点：</span><span id="zt"></span><input type="hidden" name="ztaddr"></li>
          <li><span class="tim_z">运    费：</span>0.00元(<span class="fn_red">免运费</span>)<input type="hidden" name="yunfee" id="yunfee"></li>
          <li><span class="tim_z">自提时间：</span><span class="fn_red" id="szttime"></span><input type="hidden" name="zttime" id="zttime"/></li>
        </ul>
      </div>

	  <div id="payxg" class="xx" style="display:none;">
        <h1><strong>支付及配送方式</strong><span><a href="#" onclick="closeinfo('pay')">关闭</a></span></h1>
        <ul class="bz">
          <li class="b">配送方式</li>
          <li><input type="radio" name="posttype" value="1" checked onclick="postty(1)"/>快    递 <span class="fn_hs">（只能在线支付）</span></li>
          <li><input type="radio" name="posttype" value="0" onclick="postty(0)"/>上门自提 <span class="fn_hs">（可以在线支付或者线下支付）</span></li>
          <li>　　运    费：0.00元<span class="fn_red">(免运费)</span></li>
        </ul>
        <div class="clear"></div>

        <ul class="bz">
          <li class="b">支付方式</li>
		  <li id="ztt" style="display:none;">自提时间：
			<input type="text" id="ztim" name="ztim" class="Wdate" value="" onclick="WdatePicker()"/>
		  </li>
          <li><input type="radio" name="payt" value="1"/>货到付款</li>
          <li><input type="radio" name="payt" value="0" checked />在线支付</li>
        </ul>
        <div class="kuai2">
          <table width="95%" border="0" cellspacing="0" cellpadding="0" class="biao">
		  <tr>
			<td>支持以下银行在线支付：</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td width="150"><img src="<?=URL?>media/img/front/bank (2).gif" /></td>
			<td>&nbsp;</td>
			<td width="150"><img src="<?=URL?>media/img/front/bank (3).gif" /></td>
			<td>&nbsp;</td>
			<td width="150"><img src="<?=URL?>media/img/front/bank (4).gif" /></td>
			<td>&nbsp;</td>
			<td width="150"><img src="<?=URL?>media/img/front/bank (5).gif" /></td>
		  </tr>
		  <tr>
			<td width="150"><img src="<?=URL?>media/img/front/bank (6).gif" /></td>
			<td>&nbsp;</td>
			<td width="150"><img src="<?=URL?>media/img/front/bank (7).gif" /></td>
			<td>&nbsp;</td>
			<td width="150"><img src="<?=URL?>media/img/front/bank (8).gif" /></td>
			<td>&nbsp;</td>
			<td width="150"><img src="<?=URL?>media/img/front/bank (9).gif" /></td>
		  </tr>
		  <tr>
			<td width="150"><img src="<?=URL?>media/img/front/bank (10).gif" /></td>
			<td>&nbsp;</td>
			<td width="150"><img src="<?=URL?>media/img/front/bank (11).gif" /></td>
			<td>&nbsp;</td>
			<td width="150"><img src="<?=URL?>media/img/front/bank (12).gif" /></td>
			<td>&nbsp;</td>
			<td width="150"><img src="<?=URL?>media/img/front/bank (13).gif" /></td>
		  </tr>
		  <tr>
			<td width="150"><img src="<?=URL?>media/img/front/bank (14).gif" /></td>
			<td>&nbsp;</td>
			<td width="150">&nbsp;</td>
			<td>&nbsp;</td>
			<td width="150">&nbsp;</td>
			<td>&nbsp;</td>
			<td width="150">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="150">支持以下支付平台：</td>
			<td>&nbsp;</td>
			<td width="150">&nbsp;</td>
			<td>&nbsp;</td>
			<td width="150">&nbsp;</td>
			<td>&nbsp;</td>
			<td width="150">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="150"><img src="<?=URL?>media/img/front/bank_34.jpg" /></td>
			<td>&nbsp;</td>
			<td width="150"><img src="<?=URL?>media/img/front/bank.gif" /></td>
			<td>&nbsp;</td>
			<td width="150">&nbsp;</td>
			<td>&nbsp;</td>
			<td width="150">&nbsp;</td>
		  </tr>
		</table>
		</div>

         <div class="bz"><img src="<?=URL?>media/img/front/an1_09.gif" style="cursor:pointer;" onclick="paypost()"/></div>
      </div>



      <!-- 发票开始 -->
      <div id="fp" class="xx">
        <h1><strong>发票信息</strong><span><a href="#" onclick="updateinfo('fp')">修改</a></span></h1>
        <ul>
          <li><span class="tim_z">发票类型：</span><span id="fptype">普通发票</span><input type="hidden" id="fplx" name="fplx" value="0"/></li>
          <li><span class="tim_z">发票抬头：</span><span id="fphead">个人</span><input type="hidden" id="fptaitou" name="fptaitou" value="1"/></li>
          <li><span class="tim_z">发票内容：</span><span id="fpcont">明细</span><input type="hidden" id="fpnr" name="fpnr" value="1"/></li>
        </ul>
      </div>

	   <div id="fpxg" class="xx" style="display:none;">
        <h1><strong>发票信息</strong><span><a href="#" onclick="closeinfo('fp')">关闭</a></span></h1>
        <ul class="bz">
          <li><span>发票类型：</span><input type="radio" name="fpty" value="0" checked/>普通发票     <input type="radio" name="fpty" value="1"/>增值税发票</li>
          <li><span>发票抬头：</span><input type="radio" name="fptt" value="1" checked />个人     <input type="radio" name="fptt" value="2" />单位 </li>
          <li><span>发票内容：</span><input type="radio" name="fpcontent" value="1" checked />明细     <input type="radio" name="fpcontent" value="2"/>办公用品     <input type="radio" name="fpcontent" value="3"/>电脑配件     <input type="radio" name="fpcontent" value="4"/>耗材</li>
          <li class="fn_hs">特殊声明：尊敬的客户您好，建议您将发票内容开为产品明细，否则您将无法享受产品厂商和漫淘客商城的正常质保，且漫淘客商城
不对此承担责任。谢谢！祝您购物愉快！</li>
        </ul>
        <div class="bz"><img src="<?=URL?>media/img/front/an1_12.gif" style="cursor:pointer;" onclick="savefp()"/><img src="<?=URL?>media/img/front/an1_14.gif" /></div>
      </div>
	  <!-- 发票end -->

      
      <div class="xx">
        <h1><strong>订单备注</strong><span><a href="#">修改</a></span>声明：备注中有关收货人信息、支付方式、配送方式、发票信息等购买要求一律以上面的选择为准，备注无效。</h1>
        <p class="bz"><input type="text" class="kuang" name="remark"/><span class="fn_hs">限15个字</span></p>
		<div class="bz">
			期望收货时间：<input type="radio" name="furl" value="1">随时&nbsp;&nbsp;<input type="radio" name="furl" value="2">周一到周五&nbsp;&nbsp;<input type="radio" name="furl" value="3">周末
		</div>
        <div class="bz"><img src="<?=URL?>media/img/front/an1_18.gif" /></div>
      </div>

       <div class="order_top fn_14px b fn_hs">我已挑选的商品</div>
  <table width="912" border="0" cellspacing="0" id="ord">
    <tr bgcolor="#e8e8e8">
      <td height="35" colspan="2">　　商品名称</td>
      <td width="119" align="center">商品编号</td>
      <td width="60" align="center">积分</td>
      <td width="108" align="center">市场价</td>
      <td width="101" align="center">漫淘客价</td>
	  <td width="101" align="center">会员价</td>
      <td width="62" align="center">优惠</td>
      <td width="97" align="center">商品数量</td>
      <td width="100" align="center">删除</td>
    </tr>
   	<?php
	$js = 0;
	$jf = 0;
	$ze = 0;
	foreach ($cart as $ite){
		if($ite->largess==0){
			$js = $js + $ite->cheap;
			$jf = $jf + $ite->mark;
			$ze = $ze + ($ite->mprice * $ite->goodscount - $ite->cheap);
	?>
    <tr>
      <td width="55" align="center"><img src="<?=URL.substr($ite->pic,0,strrpos($ite->pic,'.')).'_61'.substr($ite->pic,strrpos($ite->pic,'.'),strlen($ite->pic));?>"/></td>
      <td width="190" height="50"><a href="#">《<?=$ite->goodsname?>》</a></td>
      <td align="center"><?=$ite->goods_sn?></td>
      <td align="center"><?=$ite->mark?></td>
      <td align="center">￥<?=$ite->marketprice?></td>
      <td align="center" class="fn_red">￥<?=$ite->shoppirce?></td>
	  <td align="center" class="fn_red">￥<?=$ite->mprice?></td>
      <td align="center"><?=$ite->cheap?></td>
      <td align="center"><?=$ite->goodscount?></td>
      <td align="center"><a href="<?=URL?>index.php/front/order/delorcart?cartid=<?=$ite->id?>">删除</a></td>
    </tr>
	<?php
	  }}
	?>
     <tr bgcolor="#E8E8E8">
      <td height="50" colspan="10" align="center">
		<?php
		if($cheapticket !='' && count($cheapticket)!=0){
		?>
        <table width="500" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="121" height="50"></td>
            <td width="148">
			<select onchange="tickets(this)">
			  <option value=''>请选择使用优惠券</option>
			<?php foreach($cheapticket as $itm){?>
              <option value="<?=$itm->id;?>">使用<?=$itm->fee;?>元优惠券</option>
			 <?php }?>
            </select></td>
            <td width="92"><img src="<?=URL?>media/img/front/mz_03.gif" id="ticketimg" /></td>
            <td width="183">选择<span id="ticket">请选择使用优惠券</span></td>
          </tr>
        </table>
		<?php }?>
        <table border="0" align="right" cellspacing="0" id="jq" class="fn_hs">
          <tr>
            <td width="121" align="left" valign="middle" ><h3>您共节省：<span class="fn_red">￥<?=$js?></span></h3>
            <h3>获得积分：<span class="fn_red"><?=$jf?></span></h3></td>
            <td width="202" valign="middle" id="jq_td" class="fn_16px b">商品金额总计：<span class="fn_red">￥<?=$ze?></span></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
	  <input type="hidden" name="tickid" id="tickid" value=""/>
	  <input type="hidden" name="tickmoney" id="tickmoney" value="0"/>
      <div class="fh">
		<a href="<?=URL?>index.php/front/cart/cartSelect"><img src="<?=URL?>media/img/front/fh.gif"/></a>
		<a href="#"><img src="<?=URL?>media/img/front/tjj.gif" style="cursor:pointer;" onclick="nextstep()"/></a>
	  </div>
    </div>
   
    
  </form>  
  </div>
  
  <div class="box_bottom"></div>
</div>

</body>
</html>
