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

  <ul id="container">
    <li id="header">
      <h1>系统管理</h1>
      <div class="link"></div>
      <div id="desc">网站信息设置</div>
    </li>
</ul>
<table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
<form action="" method="post">
	<tr>
    	<td><strong>网站标题：</strong></td>
    	<td><input type="text" name="title" value="<?=$title?>" size="40" /></td>
	</tr>
    <tr>
    	<td><strong>网站首页描述：</strong></td>
    	<td><input type="text" name="des" value="<?=$des?>" size="40" /></td>
	</tr>
    <tr>
    	<td><strong>网站首页关键字：</strong></td>
    	<td><input type="text" name="word" value="<?=$word?>" size="40" /></td>
	</tr>
	<tr><td colspan="2"><input type="submit" value="提交" /></td></tr>
</form>
</table>
</body>
</html>
