<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?=MEDIA_URL?>css/general.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.comicyu.com/js/jquery.js"></script>
<script src="<?=URL?>media/plugin/DatePicker/WdatePicker.js" language="javascript"></script>
<script language="javascript">
function modechange(val){
	document.getElementById("spanrebate").style.display="none";
	document.getElementById("spanfreight").style.display="none";
	document.getElementById("spangift").style.display="none";
	document.getElementById("spanintegral").style.display="none";
	document.getElementById("spancheap").style.display="none";
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
<form action="<?=URL?>index.php/admin/promotion/proAdd" method="GET">
<div class="tab-page">
	<table class="form-table">
		<tr>
			<td class="label">优惠活动名称</td>
			<td>
				<input type="text" name="proname" id="proname" size="40" value="" />
				<span class="note">活动的标题</span>
			</td>
		</tr>
		<tr>
			<td class="label">活动开始时间</td>
			<td>
				<input type="text" class="Wdate" name="start_time" id="start_time" value="" onclick="WdatePicker()" />
				<span class="note">活动的开始时间</span>
			</td>
		</tr>
		<tr>
			<td class="label">活动结束时间</td>
			<td>
				<input type="text" class="Wdate" name="stop_time" id="stop_time" value="" onclick="WdatePicker()"/>
				<span class="note">活动的结束时间</span>
			</td>
		</tr>
		<tr>
			<td class="label">活动类型</td>
			<td class="note">
				<input type="radio" name="active_type" checked value="1">全场
				<input type="radio" name="active_type" value="2">局部
			</td>
		</tr>
		<tr>
			<td class="label">活动方式</td>
			<td class="note">
				<select name="mode" onchange="modechange(this.value)">
					<option>请选择--</option>
					<option value="rebate">折扣</option>
					<option value="freight">免运费</option>
					<option value="gift">赠送礼品</option>
					<option value="integral">送积分</option>
					<option value="cheap">送优惠券</option>
				</select>
				<span style="display:none;" id="spanrebate">数量:<input type="text" name="amount" value="0"/>&nbsp;折扣值:<input type="text" value="0" name="rebate"/></span>
				<span style="display:none;" id="spanfreight">金额:<input type="text" name="freight" value="0"/></span>
				<span style="display:none;" id="spangift">数量:<input type="text" name="buyamount" size="10" value="0"/>&nbsp;搜索赠品:<input type="text" name="goodsfield" value="" alt="可通过商品编号或名字进行搜索" id="goodsfield"/>&nbsp;<input type="button" value="搜索" onclick="searchgoods()"/><select name="goodsinfo" id="goodsinfo"><option value='0'>请选择--</option></select>&nbsp;赠送数量:<input type="text" size="10" name="giveamount" value="0"/></span>
				<span style="display:none;" id="spanintegral">金额:<input type="text" name="integralmoney" value="0"/>&nbsp;积分:<input type="text" name="integral" value=""/></span>
				<span style="display:none;" id="spancheap">金额:<input type="text" name="cheapmoney" value="0"/>&nbsp;券值:<input type="text" name="cheapvalue" value=""/></span>
			</td>
		</tr>
	</table>
	<div style="text-align:center;">
		<input type="submit" value="确定"/>&nbsp;
		<input type="reset" value="取消"/>
	</div>
	</form>
</div>
</html>