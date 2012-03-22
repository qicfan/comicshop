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
$(document).ready(function(){
	//选择分类
	$("#type").change( function(){
		window.location.href = '<?=URL?>index.php/admin/coupon/couponList?type='+$("#type").val();
	});
});
</script>

<span style="display:none" id="page"><?=$_GET['page']?></span>
  <ul id="container">
    <li id="header">
      <h1>优惠券管理</h1>
      <div class="link"></div>
      <div id="desc">优惠券列表</div>
    </li>
  <li id="tips">
<select name="type" id="type">
  <option value="">选择分类</option>
  <option value="0">未过期的优惠券</option>
  <option value="1">所有的优惠券</option>
</select>
  </li>
</ul>
<table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
<tr>
    <th width="250">编号</th>
    <th width="100">优惠金额</th>
    <th width="100">状态</th>
    <th width="160">生效日期</th>
    <th width="160">到期日期</th>
    <th width="100">操作</th>
</tr>
<?php
foreach ($page->objectList() as $v){
?>
<tr>
	<td><?=$v->code?></td>
    <td><?=$v->fee?>元</td>
    <td>
	<?php
	if ($v->deadline > time()) {
		if ( $v->starttime < time() ) {
			echo '有效';
		} else {
			echo '未生效';
		}
	} else if ($v->state == 1) {
		echo '已使用';
	} else {
		echo '已过期';
	}
	?>
    </td>
    <td><?=date('Y-m-d H:i:s',$v->starttime)?></td>
	<td><?=date('Y-m-d H:i:s',$v->deadline)?></td>
    <td><a href="#">?</a>
    </td>
</tr>
<?php
}
?>
</table>
<?=$page->getHtml("?type=$type")?>
</body>
</html>
