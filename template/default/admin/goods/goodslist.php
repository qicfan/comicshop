<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>列表页面</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?=MEDIA_URL?>css/general.css" rel="stylesheet" type="text/css" />
<!--script type="text/javascript" src="http://static.comicyu.com/js/jquery.js"></script-->
<script type="text/javascript" src="<?=MEDIA_URL?>js/jquery.js"></script>
<script type="text/javascript" src="<?=MEDIA_URL?>js/function.js"></script>
<script type="text/javascript">
	function goodsdel(){
		var con = confirm("你确定要删除此商品！");
		if(!con){
			return false;
		}
	}
	function goodsunsale(){
		var con = confirm("你确定要下架商品！");
		if(!con){
			return false;
		}
	}
</script>
<style>
.isnewimg {border:none;}
.ishotimg {border:none;}
.isproimg {border:none;}
</style>
</head>
<body>
<ul id="container">
  <li id="header">
    <h1>商品列表</h1>
    <div class="link">[<a href="<?=URL?>index.php/admin/goods/goodsnewlist">添加商品</a>]</div>
    <div id="desc">
      <span></span> 
	</div>
  </li>
  <li id="tips">
    <form method="GET" action="">
      <select name="categorys">
        <option value="0">所有分类</option>
		<?php
		for($i=0;$i<count($categorys);$i++){
			if($cid==$categorys[$i]->id){
		?>
        
		<option value="<?=$categorys[$i]->id?>" selected="selected"><?=$categorys[$i]->categoryname?></option>
		<?php
			}else{
		?>
        <option value="<?=$categorys[$i]->id?>"><?=$categorys[$i]->categoryname?></option>
        <?php
			}
		}
		?>
      </select>
	  <!--select name="brands">
	  	<option value="0">所有品牌</option>
		<?php
		for($i=0;$i<count($brands);$i++){
			if($bid==$brands[$i]->id){
		?>
		<option value="<?=$brands[$i]->id?>" selected="selected"><?=$brands[$i]->bname?></option>
		<?php
			}else{
		?>
        <option value="<?=$brands[$i]->id?>"><?=$brands[$i]->bname?></option>
        <?php
			}
		}
		?>
	  </select-->
	  <select name="suppliers">
	  	<option value="0">全部供货商</option>
		<?php
		for($i=0;$i<count($suppliers);$i++){
			if($sid==$suppliers[$i]->id){
		?>
		<option value="<?=$suppliers[$i]->id?>" selected="selected"><?=$suppliers[$i]->suppliername?></option>
		<?php
			}else{
		?>
        <option value="<?=$suppliers[$i]->id?>"><?=$suppliers[$i]->suppliername?></option>
        <?php
			}
		}
		?>
	  </select>
	  <select name="producers">
	  	<option value="0">全部生产商</option>
		<?php
		for($i=0;$i<count($producers);$i++){
			if($pid==$producers[$i]->id){
		?>
		<option value="<?=$producers[$i]->id?>" selected="selected"><?=$producers[$i]->pname?></option>
		<?php
			}else{
		?>
        <option value="<?=$producers[$i]->id?>"><?=$producers[$i]->pname?></option>
        <?php
			}
		}
		?>
	  </select>
	  <select name="promotion">
	  	<option value="0">全部</option>
	  	<option value="1">新品</option>
	  	<option value="2">热销</option>
		<!--option value="3">促销</option-->
	  </select>
	  
      <input type="text" name="keywords" id="keywords" onfocus="javascript:this.value='';" <?php if($keywords==''){?>value="关键字"<?php }else{?> value="<?=$keywords?>" <?php }?>/>
      <input type="submit" value="搜索">
    </form>
  </li>
  <li id="wrapper">
    <table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
      <tr>
        <th class="first-cell"> <input id="chkControl" onClick="chkChecked(this.checked,'chk')" type="checkbox" />编号</th>
		<th>商品名称</th>
		<th>货号</th>
        <th>库存</th>
		<th>进价</th>
		<th>本店价格</th>
		<th>市场售价</th>
		<th>热销</th>
		<th>新品</th>
		<th>促销</th>
		<th>操作</th>
      </tr>
	  <?php
	  	$goodsall = $all->objectList();
		//$goodsall = $all;
	  	for($i=0;$i<count($goodsall);$i++){
	  ?>
      <tr>
        <td class="first-cell"><input name="chk" value="<?=$goodsall[$i]->id?>" type="checkbox" /><?=$goodsall[$i]->id?></span></td>
        <td><?=$goodsall[$i]->goodsname?></td>
		<td><?=$goodsall[$i]->goods_sn?></td>
		<td><?=$goodsall[$i]->leavingcount?></td>
		<td><?=$goodsall[$i]->inprice?></td>
		<td><?=$goodsall[$i]->shopprice?></td>
		<td><?=$goodsall[$i]->marketprice?></td>

		<td><a href="#none"><?php if($goodsall[$i]->ishot){?><img class="ishotimg" id="<?=$goodsall[$i]->id?>" name="<?=$goodsall[$i]->ishot?>" src="<?=MEDIA_URL?>img/admin/yes.gif"/><?php }else{ ?><img class="ishotimg" id="<?=$goodsall[$i]->id?>" name="<?=$goodsall[$i]->ishot?>" src="<?=MEDIA_URL?>img/admin/no.gif"/><?php }?></a></td>
		<td><a href="#none"><?php if($goodsall[$i]->isnew){?><img class="isnewimg" id="<?=$goodsall[$i]->id?>" name="<?=$goodsall[$i]->isnew?>" src="<?=MEDIA_URL?>img/admin/yes.gif"/><?php }else{ ?><img class="isnewimg" id="<?=$goodsall[$i]->id?>" name="<?=$goodsall[$i]->isnew?>" src="<?=MEDIA_URL?>img/admin/no.gif"/><?php }?></a></td>
		<td><a href="#none"><?php if($goodsall[$i]->ispromotion){?><img class="isproimg" id="<?=$goodsall[$i]->id?>" name="<?=$goodsall[$i]->ispromotion?>" src="<?=MEDIA_URL?>img/admin/yes.gif"/><?php }else{ ?><img class="isproimg" id="<?=$goodsall[$i]->id?>" name="<?=$goodsall[$i]->ispromotion?>" src="<?=MEDIA_URL?>img/admin/no.gif"/><?php }?></a></td>

        <td class="handlelist"><a target="_blank" href='javascript:void(0);'>查看</a> | <a href="<?=URL?>index.php/admin/goods/goodsedit?gid=<?=$goodsall[$i]->id?>">编辑</a> | <a onclick="return goodsdel();" href="<?=URL?>index.php/admin/goods/delgoods?gid=<?=$goodsall[$i]->id?>" >删除</a> | <a id="" onclick="return goodsunsale();" href="<?=URL?>index.php/admin/goods/unsale?gid=<?=$goodsall[$i]->id?>">下架</a> | <a href="javascript:void(0);">重新生成缩略图</a></td>
      </tr>
	  <?php
	  	}
	  ?>
      <tr>
        <td colspan="8"><ul id="batch-links" style="margin-top:5px;padding-top:5px;">
			<li class="batch-link" action="batch" param="checkall" style="line-height:20px;"><a href="javascript:void(0);" onclick="checkAll('chk','chkControl');">全选</a></li>
			<!--li class="batch-link" action="batch" param="uncheckall" style="line-height:20px;"><a href="javascript:void(0);" onclick="unCheckAll('chk','chkControl');">全不选</a></li-->
          </ul></td>
      </tr>
    </table>
	<?=$all->getHtml(URL."index.php/admin/goods/goodslist?categorys=".$cid."&brands=".$bid."&producers=".$pid."&suppliers=".$sid."&promotion=".$ispid."&keywords=".$keywords."&");?>
  </li>
  <li id="footer">
    <div>
     Copyright ? 2007-2010 comicyu.com All rights reserved.
    </div>
  </li>
</ul>
<script>
$(".isnewimg").click(function(){
	var current = $(this);
	$.get("<?php echo URL; ?>index.php/admin/goods/changeNew",{gid:$(current).attr("id"),vid:$(current).attr("name")},function(data){
		if(data==1){
             $(current).attr("src","<?php echo MEDIA_URL; ?>img/admin/yes.gif");
			 $(current).attr("name","1");
		}else if (data==2){
			 $(current).attr("src","<?php echo MEDIA_URL; ?>img/admin/no.gif");
			  $(current).attr("name","0");
		}
	});
});
$(".ishotimg").click(function(){
	var current = $(this);
	$.get("<?php echo URL; ?>index.php/admin/goods/changeHot",{gid:$(current).attr("id"),vid:$(current).attr("name")},function(data){
		if(data==1){
             $(current).attr("src","<?php echo MEDIA_URL; ?>img/admin/yes.gif");
			  $(current).attr("name","1");
		}else if (data==2){
			 $(current).attr("src","<?php echo MEDIA_URL; ?>img/admin/no.gif");
			  $(current).attr("name","0");
		}
	});
});
$(".isproimg").click(function(){
	var current = $(this);
	$.get("<?php echo URL; ?>index.php/admin/goods/changePro",{gid:$(current).attr("id"),vid:$(current).attr("name")},function(data){
		if(data==1){
             $(current).attr("src","<?php echo MEDIA_URL; ?>img/admin/yes.gif");
			  $(current).attr("name","1");
		}else if (data==2){
			 $(current).attr("src","<?php echo MEDIA_URL; ?>img/admin/no.gif");
			  $(current).attr("name","0");
		}
	});
});
</script>
</body>
</html>
