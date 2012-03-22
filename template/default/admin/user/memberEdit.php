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

  <ul id="container">
    <li id="header">
      <h1>会员管理</h1>
      <div class="link"></div>
      <div id="desc">等级管理</div>
    </li>
</ul>
<table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
<form action="<?=URL?>index.php/admin/user/memberEdit?id=<?=$id?>" method="post"> 
    <tr>
    <td>名称</td>
    <td><input type="text" name="mname" id="mname" value="<?=$info->mname?>" /></td>
    </tr>
    <tr>
    <td>等级</td>
    <td><input type="text" name="level" id="level" value="<?=$info->level?>" size="5" />
    	<span class="note">正整数</span></td>
    </tr>
    <tr>
    <td>打折</td>
    <td><input type="text" name="ratio" id="ratio" value="<?=empty($info->ratio) ? '0.99' : $info->ratio?>" size="5" />
    	<span class="note">小数，精确到小数点后两位</span></td>
    </tr>
    <tr>
    <td>备注</td>
    <td><input type="text" name="des" id="des" value="<?=$info->des?>" />
    	<span class="note">可以不填</span></td>
    </tr>
    <tr><td colspan="2"> 
    	<input type="submit" value="提交" />
    </td></tr>
</form>
</table>
</body>
</html>
