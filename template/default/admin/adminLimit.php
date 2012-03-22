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
$(document).ready(function(){
	//自动选择自定义
	$('input:checkbox').click( function(){
		$('#spe').attr('checked', true);
	});
	//自动选择相应的角色
	$(':radio').each( function(){
		var des = '<?=$des?>';
		if (des == $(this).val()) {
			$(this).attr('checked', true);
		}
	});
});

//提交表单，修改
function Mod() {
	var limit = '';
    $(':checkbox:checked').each( function(){
    	limit += $(this).val() + ',';
    });
	var role = $(':radio:checked').val();
	var str = {limit:limit, role:role};
	$.post('<?=URL?>index.php/admin/admin/adminSubmit?act=mod&id=<?=$id?>', str, function(data){
		if (data == '1') {
			alert('修改成功');
		}
		window.location.reload();
	});
	return false;
}

//全不选
function selNo() {
    $('input:checkbox').attr('checked', false);
	return false;
}

//选择管理员角色
function selAdmin( array ) {
	selNo();
	array = eval(array);
	for (var i = 0; i < array.length; i++) {
		$('#c'+array[i]).attr('checked', true);
	}
}
</script>

  <ul id="container">
    <li id="header">
      <h1>管理员管理</h1>
      <div class="link"></div>
      <div id="desc">分派权限</div>
    </li>
</ul>
<p>
<div style="float:left;">
<form style="padding:10px;">
	<?php
    foreach ($limitInfo as $i=>$v) {
    ?>
        <?php
        if (in_array($v->id, $admin)) {
            $check = 'checked="checked"';  //自动选择已经有权限的项目
        } else {
            $check = '';
        }
        if (intval($v->parentid) == 1) {
            echo '__';
        }
        if (intval($v->parentid) > 1) {
            echo '____';
        }
        ?>
        <input type="checkbox" id="c<?=$v->id?>" value="<?=$v->id?>" <?=$check?> />
        <?=$v->actionname?><span class="note"><?=$v->id?></span><br/>
    <?php
    }
    ?>
    <p>
    注：勾选每个大类即已包含其下面小类的所有权限
    <br/>修改权限后对应的用户需重新登录方可生效。
    </p>
    <input type="submit" onclick="return Mod();" value="提交" />
    <input type="reset" value="重置" />
</div>
<div style="float:left;">
	按角色分配权限：<br/>
    <input type="radio" name="role" value="超级管理员" onfocus="selAdmin([1]);" />超级管理员
     | <input type="radio" name="role" value="系统管理员" onfocus="selAdmin([2,3,4,5,6,7,8,9,10,11,12]);" />系统管理员
    <br/><input type="radio" name="role" value="编辑/客服" onfocus="selAdmin([2,3,5]);" />编辑/客服
    <br/><input type="radio" name="role" value="商品管理员" onfocus="selAdmin([6]);" />商品管理员
    <br/><input type="radio" name="role" value="订单管理员" onfocus="selAdmin([7]);" />订单管理员
    <br/><input type="radio" name="role" value="库存管理员" onfocus="selAdmin([9,10]);" />库存管理员
     | <input type="radio" name="role" value="入库库管" onfocus="selAdmin([91,93,94]);" />入库库管
     | <input type="radio" name="role" value="出库库管" onfocus="selAdmin([92,94]);" />出库库管
    <br/><input type="radio" name="role" value="" id="spe" onfocus="selAdmin([0]);" />自定义

</form>
</div>
</body>
</html>
