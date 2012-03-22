<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="<?=URL?>media/css/main.css" rel="stylesheet" type="text/css"/>
<script src="<?=URL?>media/js/jquery.js" language="javascript"></script>
<script src="<?=URL?>media/plugin/DatePicker/WdatePicker.js" language="javascript"></script>
</head>

<body>
<div>
	<div class="main-header">管理中心&nbsp;-&nbsp;<span>订单收货地址</span></div>
	<form action="<?=URL?>index.php/admin/order/addr_update" method="POST">
    <div class="main-border">
		<table style="width:100%;">
			<tr>
				<td class="tr-lefttd-head">收货人</td>
				<td><input type="txt" name="consignee" value="<?=$orinfo[0]->consignee?>"/></td>
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
					<option value="">请选择...</option>
					<?php
					$rs = base::getRegion($orinfo[0]->province);
					foreach ($rs as $i=>$v){
					?>
					<option value="<?=$v->id?>"><?=$v->region_name?></option>
					<?php
					}
					?>
				</select>
				<select id="s3" name="county" style="width:80px">
					<option value="">请选择...</option>
					<?php
					$rs = base::getRegion($orinfo[0]->city);
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
						if(obj1[i].value=='<?=$orinfo[0]->province?>'){
							obj1[i].selected=true;
						}
					}
					var obj2=document.getElementById("s2").options;
					for(var i=0;i<obj2.length;i++){
						if(obj2[i].value=='<?=$orinfo[0]->city?>'){
							obj2[i].selected=true;
						}
					}
					var obj3=document.getElementById("s3").options;
					for(var i=0;i<obj3.length;i++){
						if(obj3[i].value=='<?=$orinfo[0]->district?>'){
							obj3[i].selected=true;
						}
					}
				</script>
				<!--级联选择End-->
				</td>
			</tr>
			<tr>
				<td class="tr-lefttd-head">电子邮件</td>
				<td><input type="txt" name="email" value="<?=$orinfo[0]->email?>"/></td>
			</tr>
			<tr>
				<td class="tr-lefttd-head">地址</td>
				<td><input type="txt" name="address" style="width:400px;" value="<?=$orinfo[0]->address?>"/></td>
			</tr>
			<tr>
				<td class="tr-lefttd-head">邮编</td>
				<td><input type="txt" name="postboat" value="<?=$orinfo[0]->zipcode?>"/></td>
			</tr>
			<tr>
				<td class="tr-lefttd-head">电话</td>
				<td><input type="txt" name="tel" value="<?=$orinfo[0]->tel?>"/></td>
			</tr>
			<tr>
				<td class="tr-lefttd-head">手机</td>
				<td><input type="txt" name="phone" value="<?=$orinfo[0]->mobile?>"/></td>
			</tr>
			<tr>
				<td class="tr-lefttd-head">标志性建筑</td>
				<td><input type="txt" name="sign" value=""/></td>
			</tr>
			<tr>
				<td class="tr-lefttd-head">最佳送货时间</td>
				<td>
					<input type="text" value="<?php if($orinfo[0]->besttime!=0){echo date('Y-m-d',$orinfo[0]->besttime);}?>" class="Wdate" name="optimaltime" onclick="new WdatePicker(this)"/>
				</td>
			</tr>
		</table>
    </div>
	
	<input type="hidden" name="oid" value="<?=$orinfo[0]->id?>"/>
	<div style="text-align:center;margin-top:5px;"><input type="submit" value="更改"/>&nbsp;<input type="reset" onclick="{location.href='<?=URL?>index.php/admin/order/detail?oid=<?=$orinfo[0]->id?>'}" value="返回"/></div>
	</form>
    <div class="main-footer">版权归comicyu所有</div>
</div>
</body>
</html>
