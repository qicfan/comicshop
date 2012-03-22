<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>属性列表页</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?=MEDIA_URL?>css/general.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=MEDIA_URL?>js/function.js"></script>
<script type="text/javascript">
	function delattr(aid){
		var con = confirm("您确定删除所选属性和相关的商品中的属性值吗！");
		if(con){
			document.getElementById("delattr").href="<?=URL?>index.php/admin/attribute/attributedel?aid="+aid;
		}
	}
	function delattrs (){
		var attrs = new Array();
		attrs = checkmulti("您还没有选择要输入的选项！","chk");
		if(!attrs){
			return false;
		}
		var con = confirm("您确定删除所选属性和相关的商品中的属性值吗！");
		if(con){
			document.getElementById("delattrs").href="<?=URL?>index.php/admin/attribute/attributesdel?aids="+attrs;
		}
	}
</script>
</head>
<body>
<ul id="container">
  <li id="header">
    <h1>属性管理</h1>
    <div class="link">[<a href="<?=URL?>index.php/admin/attribute/attributeadd">添加属性</a>]</div>
    <div id="desc">
      <div id="page-selector">
		</div>
      <span>属性列表</span> </div>
  </li>
  <li id="tips">
    <form method="GET" name="cateForm" id="cateForm" action="">
      <select name="cate" id="cate" onchange="javascript:document.getElementById('cateForm').submit();">
        <option value="0">所有分类</option>
		<?php
			for($i=0;$i<count($cate);$i++){
				if($cid==$cate[$i]->id){
		?>
			<option selected="selected" value="<?=$cid?>"><?=$cate[$i]->categoryname?></option>
		<?php
				}else{
		?>
			<option value="<?=$cate[$i]->id?>"><?=$cate[$i]->categoryname?></option>
		<?php
				}
			}
		?>
      </select>
    </form>
  </li>
  <li id="wrapper">
    <table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
      <tr>
        <th class="first-cell"> <input id="chkControl" onClick="chkChecked(this.checked,'chk')" type="checkbox" />编号</th>
		<th>属性名称</th>
		<th>属性的可选方式</th>
		<th>属性的可选值</th>
        <th>操作</th>
      </tr>
	  <?php
	  	$pages = $page->objectList();
	  	for($i=0;$i<count($pages);$i++){
	  ?>
      <tr>
        <td class="first-cell"><input name="chk" value="<?=$pages[$i]->id?>" type="checkbox" /><span><?=$pages[$i]->id?></span></td>
		<td><?=$pages[$i]->attributename?></td>
		<td>
			<?php
				switch($pages[$i]->attributetype){
					case 0;
						echo '唯一属性，手动输入';
						break;
					case 1;
						echo '单选属性，下拉选择';
						break;
					case 2;
						echo '复选属性，下拉选择';
				}
			?>
		</td>
		<td><?=$pages[$i]->attributevalue?></td>
        <td class="handlelist"><a href="<?=URL?>index.php/admin/attribute/attributeedit?aid=<?=$pages[$i]->id?>">编辑</a> | <a id="delattr" href="javascript:void(0);" onclick="return delattr(<?=$pages[$i]->id?>);">删除</a></td>
      </tr>
	  <?php
	  	}
	  ?>
      <tr>
        <td colspan="8"><ul id="batch-links" style="margin-top:5px;padding-top:5px;">
            <li class="batch-link" action="batch" param="drop" style="line-height:20px;"><a href="javascript:void(0);" onclick="checkAll('chk','chkControl')">全选</a></li>
			<li class="batch-link" action="batch" param="drop" style="line-height:20px;"><a href="javascript:void(0);" id="delattrs" onclick="return delattrs();">删除所选记录</a></li>
          </ul></td>
      </tr>
    </table>
	<?=$page->getHtml(URL."index.php/admin/attribute/attributelists?cate=".$cid."&")?>
  </li>
  <li id="footer">
    <div>
     Copyright ? 2007-2010 comicyu.com All rights reserved.
    </div>
  </li>
</ul>
</body>
</html>
