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

<script type="text/javascript" src="<?=MEDIA_URL?>js/general.js"></script>
<script>
function verify() {
	var name = document.getElementById('goodsname').value;
	var sn = document.getElementById('goods_sn').value;
	var supply = document.getElementById('supply').value;

	if (name == '' || sn == '' || supply == '') {
		alert('请填写详情');
		return false;
	}
}
function newProducer() {
	var str = '<input name="producer2" id="producer">';
	$('#oldProducer').html(str);
}
function newSupply() {
	var str = '<input name="supply2" id="supply">';
	$('#oldSupply').html(str);
}

//自动计算会员价
function autoC() {
	var count = '<?=count($member)?>';
	count = parseInt(count);
	
	price = $('#shopprice').val();
	price = parseInt(price * 100) / 100;
	if (price == '') {
		return false;
	}
	$('#shopprice').val( price );
	
	for (var i = 0; i < count; i++) {
		var value = $('#userprice'+i).attr('title');
		value = parseFloat(value) * parseFloat(price);
		value = parseInt(value * 100) / 100;
		$('#userprice'+i).val( value );
	}
}
</script>
<script>
function pop_brand() {
	popDiv();
}
function add_brand() {
	clearDiv();
	var brand = $('#new_brand').val();
	var post = {brand:brand};
	$.post('<?=URL?>index.php/admin/stock/ajaxAddBrand', post, function(data){
		if (data == '') {
			alert('添加失败');
		} else {
			str = '<input type="checkbox" name="brand[]" value="' + data + '" />' + brand + ' | ';
			$('#append_brand').append(str);
		}
	});
}
</script>

  <ul id="container">
    <li id="header">
      <h1>库存管理</h1>
      <div class="link"></div>
      <div id="desc">商品入库</div>
    </li>
</ul>
<table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
<form action="" method="post" onsubmit="return verify();">
	<tr>
        <td><strong>商品名称</strong></td>
        <td><input type="text" name="goodsname" id="goodsname" value="<?=$info->goodsname?>" size="60" /></td>
    <tr/>
    <tr>
        <td><strong>商品编号</strong></td>
        <td><input type="text" name="goods_sn" id="goods_sn" value="<?=$info->goods_sn?>" size="60" /></td>
    </tr>
    <tr>
        <td><strong>商品标签</strong></td>
        <td>        
        	<?php
				foreach ($brand as $v) {
			?>
			<input type="checkbox" name="brand[]" value="<?=$v->id?>" <?=(in_array($v->id, $goodsBrand)) ? 'checked="checked"' : ''?> /><?=$v->bname?> | 
			<?php
				}
			?>
            <span id="append_brand"></span>
            <a href="javascript:void(0);" onclick="return pop_brand();">添加标签</a>
            <div id="popDiv">
                标签名称：<input name="new_brand" id="new_brand" type="text" size="10" value="">
                 | <input type="button" value="添加" onclick="return add_brand();" />
            </div>
        </td>
    </tr>
    <tr>
        <td><strong>商品单位</strong></td>
        <td><input type="text" name="unit" id="unit" value="<?=$info->unit?>" size="10" /></td>
    </tr>
    <tr>
        <td><strong>生产商</strong></td>
        <td>
        <div id="oldProducer">
        <select name="producer" id="producer">
        	<?php
            foreach ($producer as $v) {
            ?>
      		<option value="<?=$v->id?>" <?=($v->id == $info->pid) ? 'selected="selected"' : ''?> >
			<?=$v->pname?></option>
            <?php
			}
			?>
        </select>
<!--         | <input type="button" value="新增生产商" onclick="return newProducer();" />-->
        </div>
        </td>
    </tr>
    <tr>
        <td><strong>供应商</strong></td>
        <td>
        <div id="oldSupply">
        <select name="supply" id="supply">
      		<?php
            foreach ($supply as $v) {
            ?>
      		<option value="<?=$v->id?>" <?=($v->id == $info->sid) ? 'selected="selected"' : ''?> >
			<?=$v->suppliername?></option>
            <?php
			}
			?>
        </select>
<!--         | <input type="button" value="新增供货商" onclick="return newSupply();" />-->
        </div>
        </td>
    </tr>
    <?php
	if ( empty($info) ) {
	?>
    <tr>
        <td><strong>库存数量</strong></td>
        <td><input type="text" name="stock" id="stock" value="<?=$info->leavingcount?>" size="10" /></td>
    </tr>
    <?php
	}
	?>
    <tr>
        <td><strong>商品进价</strong></td>
        <td><input type="text" name="inprice" id="inprice" value="<?=$info->inprice?>" size="10" />
        <span class="note">单位为RMB元</span></td>
    </tr>
    <tr>
        <td><strong>市场价格</strong></td>
        <td><input type="text" name="marketprice" id="marketprice" value="<?=$info->marketprice?>" size="10" /></td>
    </tr>
    <tr>
        <td><strong>本店售价</strong></td>
        <td><input type="text" name="shopprice" id="shopprice" value="<?=$info->shopprice?>" size="10" />
        </td>
    </tr>
    <tr>
        <td><strong>会员价</strong></td>
        <td>
        <?php
        foreach ($member as $i=>$v) {
        ?>
        <?=$v->mname?>
        <input type="hidden" name="mid[]" value="<?=$v->id?>" />
        <input type="text" name="userprice[]" id="userprice<?=$i?>" value="<?=$price[$i]->mprice?>" title="<?=$v->ratio?>" size="10" /> | 
        <?php
		}
		?>
        <input type="button" value="自动计算" onclick="return autoC();" /></td>
    </tr>
    <tr>
        <td><strong>选项</strong></td>
        <?php
		if ($info->autoonsale == 1) {
			$check = 'checked = "checked"';
		} else {
			$check = '';
		}
		?>
        <td><input type="checkbox" name="autoonsale" id="autoonsale" value="1" <?=$check?> />缺货自动下架</td>
    </tr>
	<tr><td colspan="2"><input type="submit" value="提交" /></td></tr>
</form>
</table>
</body>
</html>
