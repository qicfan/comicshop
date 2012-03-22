<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <title> 属性添加 </title>
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
	
	function displayarrilist(inputid){
		if(inputid=="only"){
			document.getElementById("attrilist").disabled = true;
		}else{
			document.getElementById("attrilist").disabled = false;
		}
	}
  </script>
 </head>
 <body align="center">
 
  <ul id="container">
    <li id="header">
      <h1>属性管理</h1>
      <div class="link"><a href="<?=URL?>index.php/admin/attribute/attributelists">属性列表</a></div>
      <div id="desc">属性添加</div>
    </li>
    <li>
      <form action="" name="attributeForm" id="attributeForm" method="post">
      <div id="tab-form" > 
        <div class="tab-page">
          <table class="form-table">
         	<tr>
              	<td class="label">属性名称</td><td><input type="text" name="attrname" id="attrname" size="40" /><span class="note"></span></td>
            </tr>
            <tr>
              	<td class="label">商品分类</td><td><select name="catename" id="catename">
			  	<?php
					for($i=0;$i<count($categorys);$i++){
				?>
					<option value="<?=$categorys[$i]->id?>"><?=$categorys[$i]->categoryname?></option>
				<?php
					}
				?>
			  </select><span class="note"></span></td>
            </tr>
			<tr><td class="label">属性是否关联商品</td><td><input type="radio" name="isrelategoods" value="1" checked="checked"/>是<input type="radio" name="isrelategoods" value="0" />否</td></tr>
			<tr>
				<td class="label">商品是否可选</td><td><input type="radio" onclick="displayarrilist('only');" name="attributetype" id="only" value="0" checked="checked"/>唯一属性<input type="radio" onclick="displayarrilist('one');" name="attributetype" id="one" value="1"/>单选属性<input type="radio" onclick="displayarrilist('multi');" name="attributetype" id="multi" value="2"/>多选属性<div class="note">选择"单选/复选属性"时，可以对商品该属性设置多个值，同时还能对不同属性值指定不同的价格加价，用户购买商品时需要选定具体的属性值。选择"唯一属性"时，商品的该属性值只能设置一个值，用户只能查看该值。单选和复选区别在前台的显示是单选和复选。</span></td>
			</tr>
			<tr>
				<td class="label"></td><td><textarea disabled="disabled" name="attrilist" id="attrilist" rows="5" cols="40"></textarea><span class="note">每个选项用英文逗号隔开</span></td>
			</tr>
          </table>
        </div>
        <p class="submitlist"><input type="submit" name="value_submit" value="提交" /> &nbsp; <input type="reset" name="value_submit" value="重置" /></p>
      </div>
      </form>
    </li>
    <li id="footer">
      <div>
      Copyright ? 2007-2010 comicyu.com All rights reserved.
      </div>
    </li>
  </ul>
 </body>
</html>
