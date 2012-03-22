<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<style type="text/css">
#box{
width:400px;
float:left;
text-align:center;
}
#a{
font-size:9px;
}



</style>
</head>

<body>
<div id="box">
<table border="solid">
<tr>
<td>
标题：<?=$info->title;?>
</td>
</tr>
<tr>
<td id="a">
发信人：<?=$info->fname;?>
</td>
</tr>
<tr>
<td>
<?=$info->content;?>
</td>
</tr></table></div>
</body>
</html>
