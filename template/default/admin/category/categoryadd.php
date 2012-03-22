<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <title> 分类的添加 </title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link href="<?=MEDIA_URL?>css/general.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="http://static.comicyu.com/js/jquery.js"></script>
  <!--script type="text/javascript" src="<?=MEDIA_URL?>js/jquery.js"></script-->
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
 <?php
 	//print_r($categorys);
 ?>
  <ul id="container">
    <li id="header">
      <h1>商品分类管理</h1>
      <div class="link"><a href="<?=URL?>index.php/admin/category/categorylists">分类列表</a></div>
      <div id="desc">分类添加</div>
    </li>
    <li>
      <form action="" name="categoryForm" id="categoryForm" method="post">
      <div id="tab-form" >
        <div class="tab-page">
          <table class="form-table">
            <tr>
              <td class="label">分类的名称</td><td><input type="text" name="categoryname" id="categoryname" size="40" /><span class="note"></span></td>
            </tr>
            <tr>
              <td class="label">上级分类</td><td>
			  <select name="parentcate" id="parentcate" >
			  	<option value="0">顶级分类</option>
				<?php
					for($i=0;$i<count($categorys);$i++){
				?>
					<option value="<?=$categorys[$i]->id.','.$categorys[$i]->level?>"><?=$categorys[$i]->categoryname?></option>
				<?php
					}
				?>
			  </select><span class="note"></span></td>
            </tr>
          </table>
        </div>
        <p class="submitlist"><input type="submit" name="value_submit" value=" 确 定 " /> &nbsp; <input type="reset" name="value_submit" value=" 重 置 " /></p>
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
