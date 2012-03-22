<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<style type="text/css">
#box{
width:610px;}
table{
width:608px;
border:solid #00FFCC 1px;}
td{

border:solid #00FFCC 1px;}
#cm{
width:600px;
height:50px;
margin-top:50px;
border:#663399 solid 1px;
float:left;
position:relative;
}
#cm input{
width:600px;}
#mail{
width:600px; 
border:#33FF66 solid 1px;
margin-top:50px;
float:left;
position:relative;
}


</style>
</head>

<body>
<div id="box">
<div id="cominfo">
<table>
<tr><td>被推荐人</td><td>状态</td><td>奖励积分</td><td>奖励时间</td></tr>
<?php foreach($page->objectList() as $v){?>
<tr><td><?=$v->tid;?></td><td></td><td></td><td></td></tr>


<?php }?>
</table></div>
<div id="cm"><div>推荐地址：</div><div><input type="text"   width="500px" id="wanto" value="漫淘客商城现在很火啊，价格便宜服务也不错，我买了不少东西了，快来看看吧！http://www.xxxx.com/?sid=mafangfei2010&t=1"/><input  type="button" onclick="clipboardData.setData('Text',document.getElementById('wanto').value);alert('复制成功！');" value="复制" /></div></div>

<div id="mail">
邮箱推荐：
<form action="" method="post">
<p><span>收信地址	：</span><input type="text" id="to" name="to" /></p>
<p><span>信件标题	：</span><input type="text" id="title" name="title" /></p>
<p><span>信件内容	：</span><textarea  id="content" name="content" rows="6"></textarea></p>
<p><span>发信地址	：</span><input type="text" id="from" name="from" /></p>
<input type="submit" value="ok" /><input type="reset" value="reset" />
</form>
</div>
</div>
</body>
</html>
