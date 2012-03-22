<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改密码</title>
<link href="<?=MEDIA_URL?>css/mtk_yh.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?=MEDIA_URL?>js/hdm.js"></script>
</head>

<body>
 <!-- 头部-->
<?php require_once PRO_ROOT.'template/default/front/include/nav2.php'; ?> 
 <!-- 左侧导航-->
<?php include_once PRO_ROOT."template/default/front/include/user.php"; ?>

  <!-- 主要内容-->
  <div class="box_left">
    <div class="char_title">
      <span class="hovertab">密码修改</span>         
    </div>
    <div id="tbch_01" class="bk">
     <form action="" name="form1" method="post" onsubmit="return verify();">
        <ul>
          <li><span class="wz b">旧密码：</span><input class="kuang" id="oldpwd" type="password" name="oldpwd" /></li>
          <li><span class="wz b">新密码：</span><input class="kuang" id="newpwd" type="password" name="newpwd" /><span class="fn_hs">密码可由大小写英文字母、数字组成，长度6－20位。</span></li>
          <li><span class="wz b">再次输入：</span><input class="kuang" id="renewpwd" type="password" name="renewpwd" /></li>
          <li><span class="wz"></span><input class="qr" type="submit" value="确认" /><input class="qr" name="重置" type="reset" value="取消" /></li>
        </ul>
      </form>
    </div>
  </div>
  <!-- 主要内容结束-->
</div>
<script>
function verify(){
	var oldpwd = document.getElementById('oldpwd').value;
	var newpwd = document.getElementById('newpwd').value;
	var renewpwd = document.getElementById('renewpwd').value;
	
	if (oldpwd == '') {
		alert('旧密码不能为空！');
		form1.oldpwd.focus();
		return false;
	}
	if (newpwd == '') {
		alert('新密码不能为空！');
		form1.newpwd.focus();
		return false;
	}
	if (newpwd != renewpwd) {
		alert('两次输入的新密码不一致！');
		form1.renewpwd.focus();
		return false;
	}
	return true;
}
</script>
</body>
</html>
