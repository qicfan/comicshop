<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <title>管理员登录</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link href="<?=MEDIA_URL?>css/general.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="<?=MEDIA_URL?>js/jquery.js"></script>
  <script type="text/javascript">
	$(document).ready(function(){
		var tabs = $("#tab-form .tab-bar");
		tabs.click(function(e){
			var tab = $(this);
			var elem = e.target;
			if (elem.tagName == 'LI'){
				var lis = tab.find('li');
				var pages = $('#tab-form .tab-page');
				var index = 0;
				lis.each(function(i){
					if (this == elem){
						index = i;
					}
				});
				lis.removeClass("actived");
				$(elem).addClass("actived");
				pages.addClass("tab-form");
				$(pages.get(index)).removeClass("tab-form");
			}
		})
	})
  </script>
 </head>
 <body align="center">
  <ul id="container">
    <li id="header">
      <h1>管理员登录</h1>
      <div id="desc">漫淘客商城</div>
    </li>
    <li>
      <form action="" name="login_form" method="post" enctype="multipart/form-data">
      <div id="tab-form" > <!--class="tab-form"-->
        <ul class="tab-bar">
          <li class="actived">登录</li>
        </ul>
        <div class="tab-page">
          <table class="form-table">
            <tr>
              <td class="label">用户名：</td><td><input type="text" name="username" size="40" /><span class="note"></span></td>
            </tr>
            <tr>
              <td class="label">密码：</td><td><input type="password" name="password" size="40" /><span class="note"></span></td>
            </tr>
            <tr>
            <?php
			if ( $code = base::checkCode('isloginman') ) {
			?>
              <td class="label">验证码：</td>
              <td><input type="text" name="seccode" id="seccode" size="10" style="text-transform:uppercase;" />
              <span class="note"><img src="<?=URL?>index.php/seccode" width="<?=$code['width']?>" height="<?=$code['height']?>" /></span></td>
            </tr>
            <?php
			}
			?>
            <tr>
            	<td class="label"><input type="submit" name="submit" value="登录" /></td>
            </tr>
          </table>
        </div>
      </form>
    </li>
    <li id="footer">
      <div>
      Copyright © 2010 comicyu.com All rights reserved.
      </div>
    </li>
  </ul>
 </body>
</html>
