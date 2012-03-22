<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?=MEDIA_URL?>css/general.css" rel="stylesheet" type="text/css" />
<script src="<?=URL?>media/js/jquery.js" language="javascript"></script>
<script src="<?=URL?>media/plugin/DatePicker/WdatePicker.js" language="javascript"></script>
</head>
<ul id="container">
	<li id="header">
		<h1>管理员管理</h1>
		<div class="link"></div>
		<div id="desc">添加促销活动</div>
    </li>
    <li id="tips">
		<a href="<?=URL?>index.php/admin/promotion/proList">促销列表</a>
	</li>
</ul>
<form action="<?=URL?>index.php/admin/promotion/proUpdate" method="GET">
<div class="tab-page">
	<table class="form-table">
		<tr>
			<td class="label">优惠活动名称</td>
			<td>
				<input type="text" name="proname" id="proname" size="40" value="<?=$proinfo->act_title?>" />
				<span class="note">活动的标题</span>
			</td>
		</tr>
		<tr>
			<td class="label">活动开始时间</td>
			<td>
				<input type="text" class="Wdate" name="start_time" id="start_time" size="40" value="<?php echo date('Y-m-d H:i:s',$proinfo->start_time);?>" onclick="WdatePicker()" />
				<span class="note">活动的开始时间</span>
			</td>
		</tr>
		<tr>
			<td class="label">活动结束时间</td>
			<td>
				<input type="text" class="Wdate" name="stop_time" id="stop_time" size="40" value="<?php echo date('Y-m-d H:i:s',$proinfo->stop_time);?>" onclick="WdatePicker()"/>
				<span class="note">活动的结束时间</span>
			</td>
		</tr>
		<tr>
			<td class="label">活动类型</td>
			<td class="note">
				<input type="radio" name="active_type" <?php if($proinfo->act_type==1){?>checked <?php }?>value="1">全场
				<input type="radio" name="active_type" <?php if($proinfo->act_type==2){?>checked <?php }?>value="2">局部
			</td>
		</tr>
		<tr>
			<td class="label">活动方式</td>
			<td class="note">
				<select name="mode" id="mode" onchange="modechange(this.value)">
					<option>请选择--</option>
					<option value="rebate">折扣</option>
					<option value="gift">赠送礼品</option>
					<option value="integral">送积分</option>
					<option value="cheap">送优惠券</option>
					<option value="freight">免运费</option>
				</select>
				<span style="display:none;" id="spanrebate">数量:<input type="text" name="amount" value="<?=$proinfo->buy_amount?>"/>&nbsp;折扣值:<input type="text" value="<?=$proinfo->act_agio?>" name="rebate"/></span>
				<span style="display:none;" id="spanfreight">金额:<input type="text" name="freight" value="<?=$proinfo->money?>"/></span>
				<span style="display:;" id="spangift">数量:<input type="text" name="buyamount" size="10" value="<?=$proinfo->buy_amount?>"/>&nbsp;搜索赠品:<input type="text" name="goodsfield" value="<?=$gift->goodsname?>" id="goodsfield"/>&nbsp;<input type="button" value="搜索" onclick="searchgoods()"/><select name="goodsinfo" id="goodsinfo"><option value='0'>请选择--</option></select>&nbsp;赠送数量:<input type="text" size="10" name="giveamount" value="<?=$proinfo->give_amount?>"/></span>
				<span style="display:none;" id="spanintegral">金额:<input type="text" name="integralmoney" value="<?=$proinfo->money?>"/>&nbsp;积分:<input type="text" name="integral" value="<?=$proinfo->integral?>"/></span>
				<span style="display:none;" id="spancheap">金额:<input type="text" name="cheapmoney" value="<?=$proinfo->money?>"/>&nbsp;券值:<input type="text" name="cheapvalue" value="<?=$proinfo->cheap?>"/></span>
			</td>
		</tr>
	</table>
	<div style="text-align:center;">
		<input type="hidden" name="proid" value="<?=$proinfo->id?>"/>
		<input type="button" onclick="{location.href='<?=URL?>index.php/admin/promotion/proList'}" value="返回"/>
		<input type="submit" value="修改"/>&nbsp;
	</div>
</div>
</form>
</html>
<script>
function spanhidden(){
	document.getElementById('spanrebate').style.display='none';
	document.getElementById('spanfreight').style.display='none';
	document.getElementById('spangift').style.display='none';
	document.getElementById('spanintegral').style.display='none';
	document.getElementById('spancheap').style.display='none';
}
function modechange(val){
	spanhidden();
	document.getElementById("span"+val).style.display="block";
}

/**
 * 商品搜索
 */
function searchgoods(){
	var goodsfield = $("#goodsfield").val();
	var option = document.getElementById('goodsinfo').options;
	for(var j=option.length-1;j>0;j--){
		document.getElementById('goodsinfo').remove(j);
	}
	$.ajax({
		type: "POST",
		url: "<?=URL?>index.php/admin/order/getGoodsByField",
		data: "field="+goodsfield,
		success: function(msg){
			goods=eval(msg);
			for(var i=0;i<goods.length;i++){
				var opt = new Option(goods[i]['id']+' '+goods[i]['goodsname'],goods[i]['id']);
				document.getElementById('goodsinfo').options.add(opt); 
			}
		} 	
	});
}
</script>
<?php
	if ($proinfo->activity_type==1){
?>
<script>
	spanhidden();
	document.getElementById('mode').options[1].selected=true;
	document.getElementById('spanrebate').style.display='block';
</script>
<?php
	}
	if ($proinfo->activity_type==2){
?>
<script>
	spanhidden();
	document.getElementById('mode').options[2].selected=true;
	document.getElementById('spanrebate').style.display='block';
</script>
<?php
	}
	if ($proinfo->activity_type==3){
?>
<script>
	spanhidden();
	document.getElementById('mode').options[3].selected=true;
	document.getElementById('spanintegral').style.display='block';
</script>
<?php	
	}
	if ($proinfo->activity_type==4){
?>
<script>
	spanhidden();
	document.getElementById('mode').options[4].selected=true;
	document.getElementById('spancheap').style.display='block';
</script>
<?php
	}
	if ($proinfo->activity_type==5){
?>
<script>
	spanhidden();
	document.getElementById('mode').options[5].selected=true;
	document.getElementById('spanfreight').style.display='block';
</script>
<?php	
	}
?>
<script>

</script>