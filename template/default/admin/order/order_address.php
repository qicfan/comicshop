<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="<?=URL?>media/css/main.css" rel="stylesheet" type="text/css"/>
<link href="<?=MEDIA_URL?>css/general.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=URL?>media/js/jquery.js"></script>
<script language="javascript">
function checkaddr(){
	var consignee = $("#consignee").val();
	var postboat = $("#postboat").val();
	var address = $("#address").val();
	var tel = $("#tel").val();
	var phone = $("#phone").val();
	if(consignee!='' && postboat!='' && address!='' && (tel!='' || phone!='')){
		return true;
	}else{
		alert("请填写清楚您的收货信息，以确保您能快速收到货。");
		return false;
	}


}
</script>
</head>

<body>
<div>
	<div class="main-header">管理中心&nbsp;-&nbsp;<span>订单收货地址</span></div>
	<form action="<?=URL?>index.php/admin/order/addrInsert" method="POST">
    <div class="main-border">
		<table style="width:100%;">
			<tr>
				<td class="tr-lefttd-head">收货人</td>
				<td><input type="txt" name="consignee" id="consignee" value=""/></td>
			</tr>
			<tr>
				<td class="tr-lefttd-head">所在地区</td>
				<td>
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
				  <option value="">请选择...</option>
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
				</select>
				<select id="s3" name="county" style="width:80px">
				</select>
				<!--级联选择End-->
				</td>
			</tr>
			<tr>
				<td class="tr-lefttd-head">电子邮件</td>
				<td><input type="txt" name="email" value=""/></td>
			</tr>
			<tr>
				<td class="tr-lefttd-head">地址</td>
				<td><input type="txt" name=" " id="address" style="width:400px;" value=""/></td>
			</tr>
			<tr>
				<td class="tr-lefttd-head">邮编</td>
				<td><input type="txt" name="postboat" id="postboat" value=""/></td>
			</tr>
			<tr>
				<td class="tr-lefttd-head">电话</td>
				<td><input type="txt" name="tel" id="tel" value=""/></td>
			</tr>
			<tr>
				<td class="tr-lefttd-head">手机</td>
				<td><input type="txt" name="phone" id="phone" value=""/></td>
			</tr>
			<tr>
				<td class="tr-lefttd-head">标志性建筑</td>
				<td><input type="txt" name="sign" value=""/></td>
			</tr>
			<tr>
				<td class="tr-lefttd-head">最佳送货时间</td>
				<td>
					<input type="radio" name="optimaltime" value="1"/>随时 &nbsp;
					<input type="radio" name="optimaltime" value="2"/>周一至周五 &nbsp;
					<input type="radio" name="optimaltime" value="3"/>周末
				</td>
			</tr>
		</table>
    </div>
	<div class="main-border">
		<table style="width:100%">
			<tr>
				<td class="tr-lefttd-head">支付方式</td>
				<td><input type="radio" name="paytype" value="0" checked="true"/>网上支付&nbsp;<input type="radio" value="1" name="paytype"/>货到付款</td>
			</tr>
			<tr>
				<td class="tr-lefttd-head">提货方式</td>
				<td>
					<input type="radio" name="consigntype" checked="true" value="0"/>自提&nbsp;
					<input type="radio" name="consigntype" value="1"/>快递&nbsp;
					<input type="radio" name="consigntype" value="2"/>EMS
				</td>
			</tr>
			<tr>
				<td class="tr-lefttd-head">库存量不足时</td>
				<td>
					<input type="radio" name="stock" checked="true" value="0"/>退款&nbsp;
					<input type="radio" name="stock" value="1"/>待齐发货
				</td>
			</tr>
		</table>
	</div>
	<input type="hidden" name="oid" value="<?=$oid?>"/>
	<div style="text-align:center;margin-top:5px;"><input type="button" value="上一步" onclick="{history.go(-1)}"/>&nbsp;<input type="submit" value="下一步" onclick="return checkaddr()"/>&nbsp;<input type="reset" value="取消"/></div>
	</form>
    <div class="main-footer">版权归comicyu所有</div>
</div>
</body>
</html>
