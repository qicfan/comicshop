<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>商品分类列表</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?=MEDIA_URL?>css/general.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.comicyu.com/js/jquery.js"></script>
<!--script type="text/javascript" src="<?=MEDIA_URL?>js/jquery.js"></script-->
<script type="text/javascript">
	function editcategory(cid,cname){
		var catenameobj = document.getElementById("categoryname");
		catenameobj.disabled = false;
		catenameobj.value = cname;
		var valuesubmitobj = document.getElementById("value_submit");
		valuesubmitobj.disabled = false;
		document.getElementById("cid").value = cid;
	}
	function hidtr(str){	
		var arr = new Array();
		arr = str.split(",");
		if(arr[0]){
			document.getElementById("cate"+arr[1]).style.display="none";
			alert("删除分类成功！");
		}
		
	}
	function delcate(cid){
		var url = "<?=URL?>index.php/admin/category/beforecatedel";
		$.get(url,{cid:cid},function(data){
			if(data=="cate"){
				alert("分类下面还有分类，不能删除！");
				return false;
			}else if(data=="ca"){
				var cc = confirm("分类下还有属性和商品，是否一起删除！");
				if(cc){
					var u = "<?=URL?>index.php/admin/category/categorydel";
					$.get(u,{cid:cid,type:'ca'},function(data){
						//alert(data);
						hidtr(data);
					});
				}else{
					return false;
				}
			}else if(data=="attri"){
				var aa = confirm("分类下有属性，是否要一起删除！");
				if(aa){
					var u = "<?=URL?>index.php/admin/category/categorydel";
					$.get(u,{cid:cid,type:'attri'},function(data){
						hidtr(data);
						//alert(data);
					});
				}else{
					return false;
				}
			}else if(data=="goods"){
				var bb = confirm("分类下有商品，是否要一起删除！");
				if(bb){
					var u = "<?=URL?>index.php/admin/category/categorydel";
					$.get(u,{cid:cid,type:'goods'},function(data){
						hidtr(data);
						//alert(data);
					});
				}else{
					return false;
				}
			}else{
				var u = "<?=URL?>index.php/admin/category/categorydel";
				$.get(u,{cid:cid,type:'none'},function(data){
					hidtr(data);
					//alert(data);
				});
			}
		});
	}

	function show(cid) {
		var box = $("#box" + cid);
		var link = $("#link" + cid);
		if (box.css("display") == "table-row") {
			box.css("display", "none");
			link.html("+");
		} else {
			box.css("display", "table-row");
			link.html("-");
		}
	}
</script>
</head>
<body>
<ul id="container">
  <li id="header">
    <h1>商品分类管理</h1>
    <div class="link">[<a href="<?=URL?>index.php/admin/category/add">添加分类</a>]</div>
    <div id="desc">
      <span>商品分类列表</span> </div>
  </li>
  <li id="wrapper">
    <table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid" width="500">
      <tr>
	    <th width="20">&nbsp;</th>
        <th width="300">分类名称</th>
		<th width="20">等级</th>
        <th width="150">操作</th>
      </tr>
	  <?php
	  	for($i=0;$i<count($categorys);$i++){
			if ($categorys[$i]->level == 1) {
	  ?>
      <tr id="cate<?=$categorys[$i]->id?>">
	    <td><a href="javascript:show(<?=$categorys[$i]->id?>)" id="link<?=$categorys[$i]->id?>">+</a></td>
        <td><?=$categorys[$i]->categoryname?></td>
		<td><?=$categorys[$i]->level?></td>
        <td class="handlelist"><a href="<?=URL?>index.php/admin/attribute/attributelists?cate=<?=$categorys[$i]->id?>">属性列表</a> | <a href="#categoryname" onclick="editcategory(<?=$categorys[$i]->id?>,'<?=$categorys[$i]->categoryname?>');">编辑</a> | <a onclick="return delcate(<?=$categorys[$i]->id?>);" href="javascript:void(0);">删除</a></td>
      </tr>
	  <tr id="box<?=$categorys[$i]->id?>" style="display:none;"><td colspan="4"><table cellspacing="0" cellpadding="4" class="grid">
	  <?php
			} else {
	  ?>		
      <?php
	  			if($categorys[$i]->level==2){
	  ?>
	  <tr id="cate<?=$categorys[$i]->id?>">
	    <td width="20"><a href="javascript:show(<?=$categorys[$i]->id?>)" id="link<?=$categorys[$i]->id?>">+</a></td>
        <td width="300"><?=$categorys[$i]->categoryname?></td>
		<td width="20"><?=$categorys[$i]->level?></td>
        <td width="150" class="handlelist"><a href="<?=URL?>index.php/admin/attribute/attributelists?cate=<?=$categorys[$i]->id?>">属性列表</a> | <a href="#categoryname" onclick="editcategory(<?=$categorys[$i]->id?>,'<?=$categorys[$i]->categoryname?>');">编辑</a> | <a onclick="return delcate(<?=$categorys[$i]->id?>);" href="javascript:void(0);">删除</a></td>
      </tr>
      <tr id="box<?=$categorys[$i]->id?>" style="display:none;"><td colspan="4"><table cellspacing="0" cellpadding="4" class="grid">
      <?php
				}else{
	  ?>
      <tr id="cate<?=$categorys[$i]->id?>">
        <td width="20">&nbsp;</td>
        <td width="300"><?=$categorys[$i]->categoryname?></td>
        <td width="20"><?=$categorys[$i]->level?></td>
        <td width="150" class="handlelist"><a href="<?=URL?>index.php/admin/attribute/attributelists?cate=<?=$categorys[$i]->id?>">属性列表</a> | <a href="#categoryname" onclick="editcategory(<?=$categorys[$i]->id?>,'<?=$categorys[$i]->categoryname?>');">编辑</a> | <a onclick="return delcate(<?=$categorys[$i]->id?>);" href="javascript:void(0);">删除</a></td>
      </tr>
      <?php			
				}
				if($categorys[$i+1]->level == 1 || $categorys[$i+1]->level == 2){
	  ?>
      </table></td></tr>
      <?php	
				}
      ?>
          
     
     
	  <?php
			}
			if (!isset($categorys[$i+1]) || $categorys[$i+1]->level == 1) {
	  ?>
	  </table></td></tr>
	  <?php
			}
	  	}
	  ?>
      <tr>
        <td colspan="8"><ul id="batch-links" style="margin-top:5px;padding-top:5px;">
          </ul></td>
      </tr>
	  
    </table>
    <div id="page-list" style="clear:both">
	</div>
  </li>
  <li>
 
      <form action="" name="cateForm" id="cateForm" method="post">
      <div id="tab-form" > 
        <ul class="tab-bar">
        </ul>
		<div style="font-weight:bold;font-size:15px;">编辑</div>
        <div class="tab-page">
          <table class="form-table">
            <tr>
              <td class="label">分类名称</td><td><input type="text" disabled="disabled" name="categoryname" onfocus="javascript:this.value='';" id="categoryname" size="40" /><span class="note">直接写分类名称，不要加横杠</span></td>
            </tr>
          </table>
		  <input type="hidden" name="cid" id="cid" value=""/>
        </div>
        <p class="submitlist"><input type="submit" disabled="disabled" id="value_submit" name="value_submit" value=" 保 存 " /> &nbsp; <input type="reset" name="value_submit" value=" 重 置 " /></p>
      </div>
      </form>
    </li>
  <li id="footer">
    <div>
     Copyright © 2007-2010 MacFou.com All rights reserved.
    </div>
  </li>
</ul>
</body>
</html>
