<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<style type="text/css">
table{

border:solid #00FFCC 1px;}
td{

border:solid #00FFCC 1px;}

</style>
</head>	

<body>
<table>
<tr><td>优惠券编号</td><td>优惠金额</td><td>开始时间</td><td>结束时间</td><td>状态</td></tr>
<?php  foreach($page->objectList() as $v){ ?>
<tr><td><?=$v->code;?></td><td><?=$v->fee?></td><td><?php echo date("Y-m-d G:i:s",$v->starttime);?></td><td><?php echo date("Y-m-d G:i:s",$v->deadline);?></td><td><?php if($v->state){ echo '已使用';}else{echo '未激活';}?></td>



<?php
}
?>
</table>
<div><?=$page->getHtml("?0")?></div>

<div><a href="<?=URL?>index.php/front/usercoupon/cpAdd">优惠卡激活</a></div>

</body>
</html>
