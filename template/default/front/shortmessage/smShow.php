<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<script src="<?=MEDIA_ROOT?>js/jquery.js"></script>

<style type="text/css">
body{
font-size:14px;}
td{
width:100px;
background-color:#FFFFCC;
}
#main{
width:600px;}
.m1{

width:600px;
}
.m2{
width:600px;
text-align:center;


}
.m3{
background-color:#FFFFCC;
width:600px;
}

</style>

<script language="javascript">

$(function(){
	$(".m1").next().hide();
	$(".m1").click(function(){
	
		$(this).next().toggle();
	
	});


})


</script>

</head>

<body>
<table id="main">
<tr>
<td>From</td><td>Title</td><td>Content</td><td>状态</td><td>查看</td><td>删除</td>
</tr>
<?php

foreach($page->objectList() as $v){
?>
<table class="m1">
<tr>

<td><?=$v->fname?></td><td><?=$v->title?></a></td>
<td>
<?php
$str=$v->content;
if(strlen($str)>6){
 echo substr($str,0,6).'...';
}else{
echo $str;
}
?>
</td>
<td>
<?php 
$i=$v->iread;
if($i==1){
echo "已读";
}else{
$stri1="未读";
echo $stri1;
}
?></td>
<td><a href="<?=URL?>index.php/front/shortmessage/smSepShow?id=<?=$v->id?>">查看</a></td>
<td><a href="<?=URL?>index.php/front/shortmessage/smDelete?id=<?=$v->id?>">删除</a></td>
</tr>
</table>
<table class="m2">
<div class="m3">
<?=$v->content;?></div>

<?php
}
?>

</table>
</table>


<div><?=$page->getHtml("?")?></div>

</body>
</html>
