<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?=MEDIA_URL?>css/general.css" rel="stylesheet" type="text/css" />
<script src="<?=URL?>media/js/jquery.js" language="javascript"></script>
<script src="<?=URL?>media/plugin/DatePicker/WdatePicker.js" language="javascript"></script>
<style>
.hand{
	cursor:pointer;
}
</style>
<script>
/**
 * 选择商品
 */
function searchgoods(gfield,ginfo){
	var goodsfield = $("#"+gfield).val();
	var option = document.getElementById(ginfo).options;
	for(var j=option.length-1;j>=0;j--){
		document.getElementById(ginfo).remove(j);
	}
	$.ajax({
		type: "POST",
		url: "<?=URL?>index.php/admin/order/getGoodsByField",
		data: "field="+goodsfield,
		success: function(msg){
			goods=eval(msg);
			for(var i=0;i<goods.length;i++){
				var opt = new Option(goods[i]['id']+' '+goods[i]['goodsname'],goods[i]['id']);
				document.getElementById(ginfo).options.add(opt); 
			}
		} 	
	});
}

/**
 * 移动(从左往右)
 */
function moveright(gl,gr){
	var obj = document.getElementById(gl).options;
	for(var i=0;i<obj.length;i++){
		if(obj[i].selected){
			var jet = document.getElementById(gr).options;
			var bol = false;
			for(var j=0;j<jet.length;j++){
				if(obj[i].text==jet[j].text){
					bol = true;
				}
			}
			if(!bol){
				var opt = new Option(obj[i].text,obj[i].value);
				document.getElementById(gr).options.add(opt);
			}
		}
	}
}

/**
 * 移动全部(从左往右)
 */
function moveAllRight(gl,gr){
	var obj = document.getElementById(gl).options;
	for(var i=0;i<obj.length;i++){
		var jet = document.getElementById(gr).options;
		var bol = false;
		for(var j=0;j<jet.length;j++){
			if(obj[i].text==jet[j].text){
				bol = true;
			}
		}
		if(!bol){
			var opt = new Option(obj[i].text,obj[i].value);
			document.getElementById(gr).options.add(opt);
		}
	}
}

/**
 * 移动(从右往左)
 */
function moveleft(gr){
	var obj = document.getElementById(gr).options;
	for(var i=0;i<obj.length;i++){
		if(obj[i].selected){
			document.getElementById(gr).remove(i);
		}
	}
}

/**
 * 移动全部(从右往左)
 */
function moveAllLeft(gr){
	var obj = document.getElementById(gr).options;
	for(var i=0;i<obj.length;i++){
		document.getElementById(gr).remove(i);
	}
}

/**
 * 使option全选中
 */
function selected(gr){
	var obj = document.getElementById(gr).options;
	var act = document.getElementById('actid').value;
	bl = '0';
	if(obj.length==0){
		alert("请选择促销商品！");
		bl='1';
	}
	var opt='';
	for(var i=0;i<obj.length;i++){
		opt+=obj[i].value+',';
		var link=obj[i].text;
		$.ajax({
			type: "GET",
			url: "<?=URL?>index.php/admin/promotion/checkAddActGoods",
			data: "gid="+obj[i].value+'&actid='+act,
			async: false,
			success: function(msg){
				if(msg=='no'){
					bl='1';
					alert("商品【"+link+"】已经存在此类的促销活动，您不可再次添加！");
				}
			} 	
		});
	}
	opts = opt.substring(0,opt.length-1);
	document.getElementById('actgoods').value=opts;
	if(bl=='1'){
		return false;
	}else{
		return true;
	}
	return false;
}
</script>
</head>
<body>
<ul id="container">
	<li id="header">
		<h1>管理员管理</h1>
		<div class="link"></div>
		<div id="desc">添加促销商品</div>
    </li>
    <li id="tips">
		<a href="<?=URL?>index.php/admin/promotion/proGoodsList">促销商品列表</a>
	</li>
</ul>
<div class="tab-page">
	<table class="form-table">
		<tr>
			<td class="label">请选择商品</td>
			<td>
				<input type="text" name="gfield" value="" alt="" id="gfield"/>&nbsp;
				<input type="button" value="搜索" onclick="searchgoods('gfield','gleft')"/>
				<span class="note">根据商品编号或商品名搜索</span>
			</td>
		</tr>
	</table>
	<form action="<?=URL?>index.php/admin/promotion/proGoodsAdd" method="GET">
	<div style="text-align:center;width:100%;padding:10px 0 0 100px;">
		<div style="float:left;">
			<select size="20" id="gleft" style="width:200px" multiple ></select>
		</div>
		<div style="float:left;width:100px;padding-top:20px;">
			<span class="hand" onclick="moveright('gleft','gright')"> &gt;&gt; </span><br><br>	
			<span class="hand" onclick="moveleft('gright')"> &lt;&lt; </span><br><br><br><br><br><br><br><br>
			<span class="hand" onclick="moveAllRight('gleft','gright')"> &gt;&gt;&gt;</span><br><br>	
			<span class="hand" onclick="moveAllLeft('gright')"> &lt;&lt;&lt;</span>
		</div>
		<div style="float:left;">
			<select size="20" id="gright" multiple style="width:200px"></select>
		</div>
	</div>
	<input type="hidden" name="proid" id="actid" value="<?=$proid?>"/>
	<input type="hidden" name="actgoods" id="actgoods" value=""/><br><br>
	<table style="width:100%;text-align:center;margin-top:5px;border-top:1px dashed black">
		<tr><td><input type="submit" onclick="return selected('gright')" value="提交"/></td></tr>
	</table>
	</form>
</div>
<body>
</html>