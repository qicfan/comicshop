<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<script language="javascript">
function ck(){
	var a=document.getElementById('reply').value;
	if(a==''){
		alert('请输入回复内容！');
		return false;
	}
	return true;

}

</script>
<style type="text/css">
.c1{
border:#33FF99 solid 1px;
}
.c2{
color:#666699;}
</style>
</head>

<body>
<div>
<table class="c1">
<tr><td><...........客户--<?php
echo $comreply['comment']->uid;?>--的评论.................></td></tr>
<tr><td>
<?=$comreply['good'];?></td></tr>
<tr><td>
<?=$comreply['bad'];?></td></tr>
<tr><td>
<?=$comreply['summary'];?></td></tr>
<tr><td><span class="c2"><...............回复................>：</span></td></tr><br />
<?php 
foreach($comreply['page']->objectList() as $c){
?>
<tr><td><?=$c->uname;?>说:</td><td><?=$c->reply;?></td><td><?php echo date("Y-m-d H:i:s",$c->replytime);?></td></tr>

<?php
}
?>
</table>
</div>
<div>
<form action="" method="post" onsubmit="return ck();">
<textarea name="reply" id="reply" rows="5"></textarea>
<input type="submit" value="ok" />
</form></div>
</body>
</html>
