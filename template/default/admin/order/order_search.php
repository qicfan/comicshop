<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>高级搜索</title>
<link href="<?=URL?>media/css/main.css" rel="stylesheet" type="text/css"/>
<script src="<?=URL?>media/plugin/DatePicker/WdatePicker.js" language="javascript"></script>
<script src="<?=URL?>media/js/jquery.js" language="javascript"></script>
<script>
function searchuser(){
	var userfield = $("#userfield").val();
	var option = document.getElementById('userinfo').options;
	for(var j=option.length-1;j>0;j--){
		option.remove(j);
	}
	$.ajax({
		type: "POST",
		url: "<?=URL?>index.php/admin/order/getUserByField",
		data: "field="+userfield,
		success: function(msg){
			userinfos=eval(msg);
			for(var i=0;i<userinfos.length;i++){
				var opt = new Option(userinfos[i]['uid']+' '+userinfos[i]['uname'],userinfos[i]['uid']);
				document.getElementById('userinfo').options.add(opt); 
			}
		} 	
	});
}

/** 显示条件 */
function showstyle(){   
	var obj = document.getElementsByName("search");
	for(var i=0;i<obj.length;i++){
		document.getElementById("span"+obj[i].value).style.display='none';
		if(obj[i].checked){
			document.getElementById("span"+obj[i].value).style.display='block';
		}
	}
}
</script>
</head>

<body>
<div>
	<div class="main-header">管理中心&nbsp;-&nbsp;<span>订单高级搜索</span></div>
	<form action="<?=URL?>index.php/admin/order/highsearch" method="GET">
	<div class="kuang" style="margin-top:10px;">
		<div class="height-30">
			<input type="radio" name="search" value="1" onclick="showstyle()" style="float:left;"/>根据订单状态搜索
			<span style="margin-left:20px;display:none;" id="span1">
				<select name="orstates">
					<option value="">请选择</option>
					<option value="0">无效</option>
					<option value="1">有效</option>
					<option value="2">取消</option>
					<option value="3">成功</option>
				</select>
			</span>
		</div>
		<div class="height-30">
			<input type="radio" name="search" value="2" onclick="showstyle()"/>根据支付状况搜索
			<span style="margin-left:20px;display:none;" id="span2">
				<select name="paystates">
					<option value="">请选择</option>
					<option value="0">未付款</option>
					<option value="1">已付款</option>
				</select>
			</span>
		</div>
		<div class="height-30">
			<input type="radio" name="search" value="3" onclick="showstyle()"/>根据配货状态搜索
			<span style="margin-left:20px;display:none;" id="span3">
				<select name="poststates">
					<option value="">请选择</option>
					<option value="0">未发货</option>
					<option value="1">配货中</option>
					<option value="2">已发货</option>
				</select>
			</span>
		</div>
		<div class="height-30"><input type="radio" name="search" checked onclick="showstyle()" value="4"/>高级搜索</div>
	</div>

	<div style=" border:1px solid #CCFFFF;height:280px;margin-top:10px;background-color:#FFFFFF;" id="span4">
		<div style="width:50%; height:auto; float:left;text-align:left;padding-top:10px;padding-left:5px;">
			<table>
				<tr>
					<td class="t-right">订单号:</td>
					<td><input type="text" name="order_sn"/></td>
				</tr>
				<tr>
					<td class="t-right">电子邮件:</td>
					<td><input type="text" name="email"/></td>
				</tr>
				<tr>
					<td class="t-right">购货人:</td>
					<td>
						<input type="text" name="utype" id="userfield">
						<input type="button" onclick="searchuser()" value="搜索"/>
						<select id="userinfo" name="purchaser">
							<option value="">请选择--</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="t-right">地址:</td>
					<td><input type="text" name="address"/></td>
				</tr>
				<tr>
					<td class="t-right">电话:</td>
					<td><input type="text" name="tel"/></td>
				</tr>
				<tr>
					<td class="t-right">所在地区:</td>
					<td>
						<select name="country"><option value="">请选择--</option></select>&nbsp;
						<select name="province"><option value="">请选择--</option></select>&nbsp;
						<select name="city"><option value="">请选择--</option></select>&nbsp;
						<select name="county"><option value="">请选择--</option></select></td>
				</tr>
				<tr>
					<td class="t-right">配送方式:</td>
					<td><select name="posttype"><option value="">请选择--</option><option value="0">自提</option><option value="1">快递</option><option value="2">EMS</option></select></td>
				</tr>
				<tr>
					<td class="t-right">下单时间:</td>
					<td><input type="text" onclick="WdatePicker()" name="ctime_start" style="width:100px" value="">&nbsp; ——&nbsp;<input type="text" name="ctime_stop" style="width:100px" onclick="WdatePicker()" value=""></td>
				</tr>
				<tr>
					<td class="t-right">订单状态：</td>
					<td>
						<select name="orstate">
							<option value="">请选择--</option>
							<option value="0">无效</option>
							<option value="1">有效</option>
							<option value="2">取消</option>
							<option value="3">成功</option>
						</select>&nbsp;
						<span style="font-weight:bold;">付款状态：</span>
						<select name="paystate">
							<option value="">请选择--</option>
							<option value="0">未付款</option>
							<option value="1">已付款</option>
						</select>&nbsp;
						<span style="font-weight:bold;">发货状态：</span>
						<select name="poststate">
							<option value="">请选择--</option>
							<option value="0">未发货</option>
							<option value="1">已发货</option>
						</select>
					</td>
				</tr>
			</table>
		</div>
		<div style="width:49%; height:auto; float:right;padding-top:10px;">
			<table>
				<tr>
					<td class="t-right">收货人:</td>
					<td><input type="text" name="consignee"/></td>
				</tr>
				<tr>
					<td class="t-right">邮编:</td>
					<td><input type="text" name="zipcode"/></td>
				</tr>
				<tr>
					<td class="t-right">手机:</td>
					<td><input type="text" name="mobile"/></td>
				</tr>
				<tr>
					<td class="t-right">支付方式:</td>
					<td>
						<select name="paytype">
							<option value="">请选择--</option>
							<option value="0">网上支付</option>
							<option value="1">货到付款</option>
						</select>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div style="width:100%;padding:5px;text-align:center;"><input type="submit" value="搜索"/>&nbsp;<input type="reset" value="取消"/></div>
	</form>
    <div class="main-footer">版权归comicyu所有</div>
</div>
</body>
</html>
