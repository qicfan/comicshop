<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <title> form </title>
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
	function aa(self){
		alert(self.value);
	}
  </script>
 </head>
 <body align="center">
  <ul id="container">
    <li id="header">
      <h1>批量导入商品</h1>
      <div class="link"></div>
      <div id="desc"></div>
    </li>
    <li>
      <form name="leadform" method="post" enctype="multipart/form-data">
      <div id="tab-form" > 
        <div class="tab-page">
          <table class="form-table">
            <tr>
              <td class="label"></td><td><input type="file" name="mydata[]" /><span class="note"></span></td>
            </tr>
            
          </table>
        </div>
        <p class="submitlist"><input type="submit" value=" 提 交 "/>
		</p>
      </div>
      </form>
    </li>
    <li id="footer">
      <div>
      Copyright © 2007-2010 comicyu.com All rights reserved.
      </div>
    </li>
  </ul>
 </body>
</html>
