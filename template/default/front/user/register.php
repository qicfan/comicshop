<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>用户注册</title>
<link href="<?=MEDIA_URL?>css/mtk.css" rel="stylesheet" type="text/css" />
</head>

<body>
 <!-- 头部-->
<?php include PRO_ROOT."template/default/front/include/nav1.php"; ?> 

<div class="box2">
  <div class="zck">
    <h2>欢迎注册漫淘客商城</h2>
    <div class="h_line"></div>
    <h3><img src="<?=MEDIA_URL?>img/front/zc1.gif" /></h3>
    <form id="formreg" method="post" onSubmit="return false;">
      <table width="85%" border="0" cellspacing="0"  class="zcb">
        <tr>
          <td width="14%" align="right" valign="top"><span class="fn_red">*</span>Email地址：</td><td width="57%"><input type="text" id="email" name="email" /></td><td width="29%"><label id="email_text"></label></td>
        </tr>
        <tr>
          <td align="right" valign="top"><span class="fn_red">*</span>用户名：</td><td colspan="2"><input type="text" id="username" name="username" /><p class="fn_hs">4-20位字符，可由中文、英文、数字及“_”、“-”组成</p></td>
        </tr>
        <tr>
          <td align="right" valign="top"><span class="fn_red">*</span>登录密码：</td><td><input type="password" id="password" name="password" /></td><td> <label id="password_text"></label></td>
        </tr>
        <tr>
          <td align="right" valign="top"><span class="fn_red">*</span>确认密码：</td><td><input type="password" id="repassword" name="repassword" /></td><td><label id="repassword_text"></label></td>
        </tr>
        <tr>
          <td align="right" valign="top"><span class="fn_red">*</span>验证码：</td><td><input type="text" id="seccode" name="seccode" /></td><td><label id="seccode_text" ></label></td>
        </tr>
        <tr>
          <td align="right" valign="top">&nbsp;</td>
          <td><img id="Verification"  onclick="this.src='<?=URL?>index.php/seccode/index?' + Math.round(Math.random()*2)"  src="<?=URL?>index.php/seccode" alt="验证码" />看不清？<a  href="javascript:void(0)" onClick="verc()" class="flk13">换一张</a></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3" align="center" valign="top"><input name="agreencomicserv" id="agreencomicserv" class="fx" type="checkbox" />
          我已阅读并同意《漫淘客商城交易条款》和《漫淘客社区条款》</td>
        </tr>
        <tr>
          <td colspan="3" align="center" valign="top">
		 <input type="button" id="login_zc" class="bt2" disabled="disabled" value="提交注册" tabindex="8" /> 
		  </td>
        </tr>
      </table>
    </form>
  </div>
  <div class="di"><img src="<?=MEDIA_URL?>img/front/di.gif" /></div>
</div>
<script src="http://static.comicyu.com/js/jquery.js" type="text/javascript"></script>
<script type="text/javascript"> 
function verc(){
	$("#Verification").click();
} 
//默认
setTimeout(function(){$("#email").get(0).focus();},0); 

$(document).ready(function(){
	var username = false;
	var email = false;
	var password = false;
	var repassword = false;
	var seccode = false;
	var agree = false;
	$(":text,:password").focus(function(){
			//this.style.background = '#FAFFBD';
			this.style.border = '1px solid #E9CB8F';
		});	
	$(":text,:password").blur(function(){
			this.style.background = '#FFF';
			this.style.border = '1px solid #999999';
			if (this.id=='username') {
				if (this.value != '') {
					if (this.value.length < 3 || this.value.length > 12) {
						$("p.fn_hs").addClass("fn_red");
						$("p.fn_hs").html("用户名长度错误！");
						return ;
					}
					var re1 = new RegExp("^([\u4E00-\uFA29]|[\uE7C7-\uE7F3]|[a-zA-Z0-9])*$");
					if (!re1.test(this.value)) {
						$("p.fn_hs").addClass("fn_red");
						$("p.fn_hs").html("用户名格式错误！");
						return;
					}
					$.get('<?=URL?>index.php/front/user/checkName', {in_ajax:1, username:this.value}, function(data) {
							if (data == 1) {
								$("p.fn_hs").addClass("fn_red");
					            $("p.fn_hs").html("用户已存在！");
								return;
							}
						}, 'json');
				} else {
					$("p.fn_hs").addClass("fn_red");
					$("p.fn_hs").html("用户名不能为空！");
					return;
				}

				username = true;
					$("p.fn_hs").removeClass("fn_red");
					$("p.fn_hs").html("该用户名可以注册！");
			}
			if (this.id=='password') {
				if (this.value == '') {
					setStatus(0, '密码不能为空', 'password_text');
					return;
				}
				if (this.value.length < 5 || this.value.length > 16) {
					setStatus(0, '密码长度错误', 'password_text');
					return;
				}
				password = true;
				setStatus(1, '', 'password_text');
			}
			if (this.id=='repassword') {
				if (this.value != $('#password').attr('value')) {
					setStatus(0, '两次输入的密码不一致', 'repassword_text');
				} else {
					repassword = true;
					setStatus(1, '', 'repassword_text');
				}
				return;
			}
			if (this.id=='email') {
				if (this.value != '') {
					var re1 = new    RegExp("^(([0-9a-zA-Z]+)|([0-9a-zA-Z]+[_.0-9a-zA-Z-]*))@([a-zA-Z0-9-]+[.])+([a-zA-Z]{2}|net|NET|com|COM|gov|GOV|mil|MIL|org|ORG|edu|EDU|int|INT|name|NAME)$");
					if (!re1.test(this.value)) {
						setStatus(0, '邮箱格式错误', 'email_text');
						return;
					}
					$.get('<?=URL?>index.php/front/user/checkEmail', {in_ajax:1, email:this.value}, function(data) {
						if (data == 1) {
							setStatus(0,'Email已存在', 'email_text');
							return;
						}

					}, 'json');					
				} else {
					setStatus(0, '邮箱不能为空', 'email_text');
					return;
				}	
				email = true;
				setStatus(1, '', 'email_text');
			}
			if (this.id=='seccode') {
				if (this.value != '') {
					if (this.value.length != 4) {
						setStatus(0, '验证码错误', 'seccode_text');
						return ;
					}
					$.get('<?=URL?>index.php/front/user/checkSeccode', {in_ajax:1, seccode:this.value}, function(data) {
						if (data == 0) {
							setStatus(0, '验证码错误', 'seccode_text');
							return;
						}
					}, 'json');
				} else {
					setStatus(0, '验证码不能为空', 'seccode_text');
					return;
				}
				seccode = true;
				setStatus(1, '', 'seccode_text');
			}				
		});
	$('#agreencomicserv').click(function(){
			if (this.checked) {
				$('#login_zc').attr('disabled', '');
				agree = true;
			} else {
				$('#login_zc').attr('disabled', 'disabled');
				agree = false;
			}			
		});
	$('#login_zc').click(function(){
			if (username && password && repassword && email && seccode && agree) {
				$('#formreg').submit();
			} else {
				alert('请准确填写注册内容！');
				return false;
			}
		});
});
 
function setStatus(right, message, id) {
	if (right == 1) {
		$('#'+id).html('<img src="http://reg.comicyu.com/media/img/check_right.gif" />');
	} else {
		$('#'+id).html('<div><img src="http://reg.comicyu.com/media/img/check_error.gif" />'+message+'</div>');
	}
}
</script>

</body>
</html>
