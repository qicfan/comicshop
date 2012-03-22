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
      <div id="desc">会员管理</div>
    </li>
</ul>
<table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
<form action="<?=URL?>index.php/admin/user/userEdit?id=<?=$id?>" method="post"> 
    <tr>
    <td>用户名</td>
    <td><?=$info->uname?></td>
    </tr>
    <tr>
    <td>会员等级</td>
    <td><select name="member" id="member">
			<?php
            foreach ($member as $v) {
            ?>
      		<option value="<?=$v->id?>" <?=($v->id == $info->member) ? 'selected="selected"' : ''?> >
			<?=$v->mname?></option>
            <?php
			}
			?>
        </select>
    </td>
    </tr>
    <tr>
    <td>移动电话</td>
    <td><input type="text" name="mobile" id="mobile" value="<?=$info->mobile?>" />
    	</td>
    </tr>
    <td>联系地址</td>
    <td><input type="text" name="address" id="address" value="<?=$info->address?>" size="30" />
    	</td>
    </tr>
    <td>E-Mail</td>
    <td><input type="text" name="email" id="email" value="<?=$info->email?>" />
    	</td>
    </tr>
    <tr><td colspan="2"> 
    	<input type="submit" value="提交" />
    </td></tr>
</form>
</table>
</body>
</html>
