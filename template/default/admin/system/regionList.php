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
	$('.region').mousemove( function(){
		$(this).css('background-color','red');
	});
	$('.region').mouseout( function(){
		$(this).css('background-color','');
	});
	$('.region').click( function(){
		var name = $(this).html();
		var id = $(this).attr('id');
		if ( name.indexOf('value') == -1 ) {
			var str = '<form action="<?=URL?>index.php/admin/system/regionSubmit?act=edit&id=' + id + '" method="post">';
			str += '<input id="e' + id + '" type="text" name="name" size="10" value="' + name + '" />';
			str += '<input type="submit" value="修改"></form>';
			$(this).html(str);
			$('#edit').focus();
		}
	});
});

function confirmDel() {
	if( !confirm('确定要删除么？') ) {
		return false;
	}
	return true;
}
</script>
  <ul id="container">
    <li id="header">
      <h1>地区管理</h1>
      <div class="link"></div>
      <div id="desc">地区列表</div>
    </li>
  <li id="tips">
  <form name="form1" action="<?=URL?>index.php/admin/system/regionSubmit?act=add&lv=<?=$level?>&id=<?=$id?>" method="post">
  <?php
  if ($level != 0) {
  ?>
  <a href="<?=URL?>index.php/admin/system/regionList?id=<?=$parent?>">返回</a>
  <?php
  }
  ?>
   | <span>添加 <?=$level?> 级地区：</span>
  <input type="text" name="name" value="" />
  <input type="submit" value="添加" />
  </form>
  </li>
</ul>
<table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
<?php
foreach ($region as $i=>$v){
	if ( ($i % 3) == 0 ) {
		echo '<tr>';
	}
?>
    <td>
	<span id="<?=$v->id?>" class="region"><?=$v->region_name?></span>
    <?php
	if ( intval($v->region_type) < 3 ) {
	?>
    <a href="<?=URL?>index.php/admin/system/regionList?id=<?=$v->id?>">管理</a> | 
	<?php
	}
	?>
    <a href="<?=URL?>index.php/admin/system/regionSubmit?act=del&id=<?=$v->id?>" onclick="return confirmDel();">移除</a>
    </td>
<?php
	if ( ($i % 3) == 2 ) {
		echo '<tr/>';
	}
}
?>
</table>
<br/>
<!--级联选择-->
<script>
$(document).ready(function(){
	$(':select').change( function(){
		var id = $(this).val();
		var level = $(this).attr('id');
		level = parseInt( level.replace('s', '') );  //得到当前级数
		if (id == '') {  //为空的情况
			if (level == 1) {
				$('#s2').html('');
				$('#s3').html('');
			}
			if (level == 2) {
				$('#s3').html('');
			}
			return false;
		}
		if (level > 2) {
			return false;  //最大级数
		}
		if (level == 1) {
			$('#s3').html('');  //选择第一级的时候清空第三级的结果
		}
		level++;
		post = { id:id };
		$('#s'+level).html('<option>读取中...</option>');
		$.post( '<?=URL?>index.php/views/regionSelect', post,
			function(data) {			
				$('#s'+level).html(data); //将结果显示出来
			}
		);
	});
});
</script>
<select id="s1" style="width:80px">
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
<select id="s2" style="width:80px">
</select>
<select id="s3" style="width:80px">
</select>
<!--级联选择End-->
</body>
</html>
