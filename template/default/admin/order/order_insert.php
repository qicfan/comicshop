<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Expires" CONTENT="0"> 
<meta http-equiv="Cache-Control" CONTENT="no-cache"> 
<meta http-equiv="Pragma" CONTENT="no-cache"> 
<title>订单添加</title>
<link href="<?=URL?>media/css/main.css" rel="stylesheet" type="text/css"/>
<link href="<?=MEDIA_URL?>css/general.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=URL?>media/js/jquery.js"></script>

<script style="text/javascript">
/** 搜索商品信息 */
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
				var opt = new Option(goods[i]['goodsname'],goods[i]['id']);
				document.getElementById('goodsinfo').options.add(opt); 
			}
		} 	
	});
}

/** 根据商品id搜索商品信息并显示 */
function showgoods(gid){
	if(gid==''){
		alert("请选择");
	}else{
		$("#gname").val('');
		$("#gsn").val('');
		$("#gclass").val('');
		
		$("#marketprice").val('');
		$("#shopprice").val('');
		$("#gid").val('');
		$("#gattribute").html('');
		$.ajax({
			type: "POST",
			url: "<?=URL?>index.php/admin/order/getGoodsByGid",
			data: "gid="+gid,
			success: function(msg){
				$arr=msg.split("@");
				var goods=eval("("+$arr[0]+")");
				$("#gname").val(goods['goodsname']);
				$("#gsn").val(goods['goods_sn']);
				$("#marke").val(goods['marketprice']);
				$("#marketprice").val(goods['marketprice']);
				$("#shopprice").val(goods['shopprice']);
				$("#leavingcount").val(goods['leavingcount']);
				$("#gid").val(goods['id']);
				$("#gattribute").val(goods['aid']);
				var groy = eval("("+$arr[2]+")");
				$("#gclass").val(groy['categoryname']);
				var attribute = eval($arr[1]);
				for(var i=0;i<attribute.length;i++){
					$("#gattribute").append("<input type='checkbox' NAME='attr' value="+attribute[i]['id']+","+attribute[i]['attributevalue']+","+attribute[i]['attributeprice']+">"+attribute[i]['attributevalue']);
				}
			}
		});
	}
}







/** 加入订单 */
function orderadd(){
	if($("#gname").val()=='' && $("#gsn").val()==''){
		alert("请选择商品！");
		return false;
	}else{
		var leavingcount =parseInt($("#leavingcount").val());
		var gcount =parseInt($("#gcount").val());
		if(gcount<=0){
			alert("Sorry 请填清楚购买数量！");
			return false;
		}
		if(gcount>leavingcount){
			alert("Sorry 库存量不足！");
			return false;
		}else{
			/** 属性 */
			var att = document.getElementsByName("attr");
			attvalue='';
			amoney=0;
			attrid='';
			for(var i=0;i<att.length;i++){
				if(att[i].checked){
					var arr=(att[i].value).split(',');
					attvalue+=' '+arr[1];
					attrid+=' '+arr[0];
					amoney+=parseFloat(arr[2]);
				}
			}
			$("#attributeid").val(attrid);
			$("#attributevalue").val(attvalue);
			$("#attributemoney").val(amoney);

			var priceobj = document.getElementsByName("price");
			var price = 0;
			for(var j=0;j<priceobj.length;j++){
				if(priceobj[j].checked){
					price = $("#"+priceobj[j].value).val();
				}
			}
			$("#pricevalue").val(price);
		}
	}
	return true;
}

/** 删除订单信息 */
function delorder(cartid,uid,cartcode){
	//var subtotal =parseInt($("#info"+goid).html());
	/*var oldsubtotal=$("#info"+goid).html();    //获取原始金额
	$.ajax({
		type: "POST",
		url: "<?=URL?>index.php/admin/order/del",
		data:"orderid="+oid+"&goid="+goid+"&subtotal="+subtotal,
		success:function (msg){
			if(msg=='ok'){
				document.getElementById("goinfo"+goid).style.display='none';
				$("#subtotal").html(parseFloat($("#subtotal").html())-parseFloat(oldsubtotal));
			}
		}
	});*/

	document.location.href="<?=URL?>index.php/admin/order/cartdel?cartid="+cartid+"&uid="+uid+"&cartcode="+cartcode;
}

/** 更改购买数量 */
function changecount(cartid,uid,cartcode,gid){
	var count=$("#count"+cartid).val();
	$.ajax({
		type: "POST",
		url: "<?=URL?>index.php/admin/order/checkgcount",
		data:"gid="+gid+"&count="+count,
		success:function (msg){
			if(msg=='ok'){
				document.location.href="<?=URL?>index.php/admin/order/updatecount?cartid="+cartid+"&count="+count+"&uid="+uid+"&cartcode="+cartcode+"&gid="+gid;
			}
			if(msg=='nocount'){
				alert('Sorry 库存量不足！');
			}
		}
	});	
}

/** 检查提交信息 */
function checksub(){
	var num=$("#oid").val();
	if(num==''){
		alert("请选择订单！");
		return false;
	}else{
		return true;
	}
}
</script>
</head>

<body>
<ul id="container">
	<li id="header">
		<h1>管理员管理</h1>
		<div class="link"></div>
		<div id="desc">添加订单</div>
    </li>
    <li id="tips">
		<a href="<?=URL?>index.php/admin/order/orlist">订单列表</a>
	</li>
</ul>
<div>
	<div style="border:1px solid #ccffff;margin-top:10px;">
		<table style="width:100%;" id="showorder">
			<tr>
				<td class="tr-td-head">商品名称</td>
				<td class="tr-td-head">商品序列号</td>
				<td class="tr-td-head">店铺价格</td>
				<td class="tr-td-head">优惠额</td>
				<td class="tr-td-head">数量</td>
				<td class="tr-td-head">属性</td>
				<td class="tr-td-head">小计</td>
				<td class="tr-td-head">操作</td>
			</tr>
		<?php
		$reckon = 0;
		foreach ($cartgoods as $item) {
			if($item->largess==0){
			?>
			<tr id="goinfo<?=$item->id?>">
				<td><?=$item->goodsname?></td>
				<td><?=$item->goods_sn?></td>
				<td><?=$item->shoppirce?></td>
				<td><?=$item->cheap?></td>
				<td><input type="txt" id="count<?=$item->id?>" value="<?=$item->goodscount?>"/></td>
				<td><?=$item->attributename?></td>
				<td id="info<?=$item->id?>"><?php echo $item->shoppirce*$item->goodscount-$item->cheap?></td>
				<td style="text-align:center;">
					<span style="cursor:pointer;" onclick="delorder('<?=$item->id?>','<?=$uid?>','<?=$cartcode?>')">删除</span>&nbsp;
					<span style="cursor:pointer;" onclick="changecount('<?=$item->id?>','<?=$uid?>','<?=$cartcode?>','<?=$item->goodsid?>')">修改</span>
				</td>
			</tr>
			<?php
			$reckon +=($item->shoppirce*$item->goodscount-$item->cheap);
			}
			if($item->largess ==1){
			?>
			<tr id="goinfo<?=$item->id?>" style="background:#ECF9F9;">
				<td style="padding-left:10px;">赠品：<?=$item->goodsname?></td>
				<td><?=$item->goods_sn?></td>
				<td><?=$item->shoppirce?></td>
				<td><?=$item->cheap?></td>
				<td><?=$item->goodscount?></td>
				<td><?=$item->attributename?></td>
				<td id="info<?=$item->id?>"><?php echo $item->shoppirce*$item->goodscount?></td>
				<td style="text-align:center;">&nbsp;</td>
			</tr>
		<?php
			}
		}
		?>
		</table>
		<div style="text-align:right;padding:3px;width:100%">注：此处价格包含了属性价 &nbsp;总计：<span id="subtotal"><?=$reckon?></span>元</div>
	</div>


	<div style="margin-top:10px;">
		按商品名或商品序列号搜索&nbsp;<input type="text" id="goodsfield" name="">&nbsp;<input type="button" onclick="searchgoods()" value="搜索"/>&nbsp;<select id="goodsinfo" onchange="showgoods(this.value)"><option>请选择--</option></select>
	</div>


	<form action="<?=URL?>index.php/admin/order/insert" method="POST">
    <div style="margin-top:10px; border:1px solid #FFF;">
		<table style="width:100%;">
			<tr>
				<td class="tr-lefttd-head">商品名</td>
				<td><input type="text" name="gname" id="gname" value=""/></td>
			</tr>
			<tr>
				<td class="tr-lefttd-head">商品序列号</td>
				<td><input type="text" id="gsn" name="gsn" /></td>
			</tr>
			<tr>
				<td class="tr-td-head">分类</td>
				<td><input type="text" name="gclass" id="gclass" /></td>
			</tr>
			<tr>
				<td class="tr-td-head">价格</td>
				<td id="goods_price">
					<input type="radio" value="marketprice" name="price">市场价：<input type="txt" id="marketprice" value="0"/>元
					<input type="radio" value="shopprice" name="price" checked="true">本店价：<input type="txt" id="shopprice" value="0"/>元
					<input type="radio" value="custom" name="price">自定价：<input type="text" id="custom" value='0'/>元
				</td>
			</tr>
			<tr>
				<td class="tr-td-head">属性</td>
				<td id="gattribute"></td>
			</tr>
			<tr>
				<td class="tr-td-head">数量</td>
				<td><input type="text" id="gcount" name="gcount" value='1'/></td>
			</tr>
		</table>
		<input type="hidden" id="gid" name="gid" value=""/>
		<input type="hidden" id="gattributename" name="gattributename" value=""/>
		<input type="hidden" id="uid" name="uid" value="<?=$uid?>"/>
		<input type="hidden" name="cartcode" id="cartcode" value="<?=$cartcode?>"/>
		<input type="hidden" name="pricevalue" id="pricevalue" value=""/>
		<input type="hidden" name="leavingcount" id="leavingcount" value=""/>
		<input type="hidden" name="marketprice" id="marke" value=""/>
		<input type="hidden" name="attributeid" value="" id="attributeid"/>
		<input type="hidden" name="attributevalue" id="attributevalue" value=""/>
		<input type="hidden" name="attributemoney" id="attributemoney" value=""/>
		<div style="background:#ECF9F9;text-align:center;padding:2px;"><input type="submit" value="加入购物车" onclick="return orderadd()"/></div>
    </div>
	</form>


	<form action="<?=URL?>index.php/admin/order/address" method="POST">
	<input type="hidden" name="uid" value="<?=$uid?>"/>
	<input type="hidden" name="cartcode" value="<?=$cartcode?>"/>
	<div style="text-align:center;margin-top:5px;">
		<input type="submit" value="下一步" onclick="return checksub()"/>&nbsp;<input type="button" value="取消"/>
	</div>
	</form>


    <div class="main-footer">版权归comicyu所有</div>
</div>
</body>
</html>