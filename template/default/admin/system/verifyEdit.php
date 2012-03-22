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
    <div id="desc">
      <div id="page-selector">
		</div>
      <span>审核管理</span> </div>
  </li>
</ul>
<table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
<form action="" method="post">
	<?php
	foreach ($verify as $v) {
	?>
    <tr>
    	<td><?=$v->des?> 需要审核</td>
        <?php
        if ($v->value == '1') {
            $check = 'checked="checked"';  //自动选择
        } else {
            $check = '';
        }
		?>
        <td><input type="checkbox" name="value[]" id="v<?=$v->id?>" value="1" <?=$check?> />
        <input type="hidden" name="id[]" value="<?=$v->id?>" />
        <span class="note">开启之后将在相应后台功能中显示“审核”栏目，需要管理员审核才能显示对应的信息</span></td>
    </tr>
    <?php
	}
	?>
    <input type="hidden" name="null" value="1" />
	<tr><td><input type="submit" value="提交" /></td></tr>
</form>
</table>
</body>
</html>
