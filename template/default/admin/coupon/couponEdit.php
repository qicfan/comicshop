<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>漫淘客商城</title>
<script type="text/javascript" src="http://static.comicyu.com/js/jquery.js"></script>
<script type="text/javascript" src="http://static.comicyu.com/js/ajax.js"></script>
<link href="<?=MEDIA_URL?>css/general.css" rel="stylesheet" type="text/css" />
</head>

<body>
<script>
function verify(){
	var amount = document.getElementById('amount').value;
	var fee = document.getElementById('fee').value;
	var startTime = document.getElementById('startTime').value;
	var deadLine = document.getElementById('deadLine').value;
	if (amount < 1 || amount > 9999 || fee < 1 || deadLine == '') {
		alert('请填写合理的优惠券信息');
		return false;
	}
	str = {amount:amount, fee:fee, startTime:startTime, deadLine:deadLine};
	$.post('<?=URL?>index.php/admin/coupon/couponProduce', str, function(data){
		document.getElementById('submit').disabled = 'true';
		$("#rs").html('优惠券生成中，请稍候……');
		if (data == '1') {
			$("#rs").html('优惠券生成成功！');
		} else {
			alert(data);
			$("#rs").html('优惠券生成失败！');
		}
	});
	return false;
}
</script>
<script language="javascript" type="text/javascript" src="<?=MEDIA_URL?>plugin/DatePicker/WdatePicker.js"></script>

<span style="display:none" id="page"><?=$_GET['page']?></span>
  <ul id="container">
    <li id="header">
      <h1>优惠券管理</h1>
      <div class="link"></div>
      <div id="desc">批量生成优惠券</div>
    </li>
</ul>
<form action="" name="form1" method="post" onsubmit="return verify();">
<table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
    <tr>
        <td>生成数量</td>
        <td><input type="text" name="amount" id="amount" value="" />（一次最多生成9999张）</td>
    </tr>
	<tr>
    	<td width="80">优惠金额</td>
		<td><input type="text" name="fee" id="fee" value="" />（整数元，不少于1元）</td>
    </tr>
    <tr>
    	<td>生效日期</td>
		<td><input name="startTime" id="startTime" class="Wdate" type="text" value="<?=date('Y-m-d',time())?>" onClick="WdatePicker()"> （00:00:00）</td>
    </tr>
    <tr>
    	<td>过期日期</td>
		<td><input name="deadLine" id="deadLine" class="Wdate" type="text" onClick="WdatePicker()"> （00:00:00）</td>
    </tr>
</table>
	<div style="padding:10px;">
	<br/><div id="rs" style="color:red"></div>
    <br/><input type="submit" id="submit" value="生成" />
    </div>
</form>
</body>
</html>
