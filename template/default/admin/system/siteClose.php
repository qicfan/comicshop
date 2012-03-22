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
      <div id="desc">关闭网站</div>
    </li>
</ul>
<table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
<form action="" method="post">
	<tr>
	<td><strong>网站状态：</strong></td>
    <?php
		if ($close == 1) {
			$check2 = 'checked="checked"';
		} else {
			$check1 = 'checked="checked"';
		}
	?>
    	<td>
        开启<input type="radio" name="close" value="0" <?=$check1?> /> | 
        关闭<input type="radio" name="close" value="1" <?=$check2?> />
        </td>
    </tr>
    <tr>
    <td><strong>关闭原因描述：</strong></td><td><input type="text" name="reason" value="<?=$reason?>" size="40" /></td>
	</tr>
	<tr><td colspan="2"><input type="submit" value="提交" /></td></tr>
</form>
</table>
</body>
</html>
