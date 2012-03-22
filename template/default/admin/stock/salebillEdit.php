<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="http://static.comicyu.com/js/jquery.js"></script>
<script type="text/javascript" src="http://static.comicyu.com/js/ajax.js"></script>
<link href="<?=MEDIA_URL?>css/general.css" rel="stylesheet" type="text/css" />
<title>漫淘客商城</title>
</head>

<body>
<script>
function check() {
	var sn = $('#order_sn').val();
	if (sn == '') {
		$('#rs').html('请填写订单编号');
		return false;
	}
	str = {sn:sn};
	$.post('<?=URL?>index.php/views/checkOrderSn', str, function(data){
		if (data == '') {
			return false;
		} else if (data == '0') {
			$('#rs').html('错误的订单号，请审核后重新填写。');
			return false;
		} else {
			$('#oid').val(data);
			$('#rs').html('订单ID：'+data);
			return true;
		}
	});
}
</script>

  <ul id="container">
    <li id="header">
      <h1>库存管理</h1>
      <div class="link"></div>
      <div id="desc">添加出库单</div>
    </li>
    <li id="tips">
    <form action="" method="post" onsubmit="return check();">
    关联的订单编号：<input type="text" name="order_sn" id="order_sn" size="30" value="<?=$order->order_sn?>" onblur="return check();" />
    <input type="button" value="检查" onclick="return check();" />
    <span id="rs"><?=empty($order->id) ? '' : '订单ID：'.$order->id?></span>
    <input type="hidden" name="oid" id="oid" value="<?=$order->id?>" />
    </li>
</ul>
<table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
	<tr>
    	<td><strong>物流公司：</strong></td>
		<td>
        <select name="lid">
          <?php
          foreach ($logistics as $i=>$v){
          ?>
          <option value="<?=$v->id?>"><?=$v->lname?></option>
          <?php
          }
          ?>
        </select>
        </td>
    </tr>
	<tr>
    	<td><strong>快递单号：</strong></td>
		<td><input name="express" type="text" value="" size="30"></td>
    </tr>
	<tr>
		<td colspan="2"><input type="submit" value="生成发货单"></td>
    </tr>
    </form>
</table>
</body>
</html>
