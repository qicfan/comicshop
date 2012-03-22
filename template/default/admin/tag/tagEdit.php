<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>漫淘客商城</title>
<script type="text/javascript" src="http://static.comicyu.com/js/jquery.js"></script>
<script type="text/javascript" src="http://static.comicyu.com/js/ajax.js"></script>
<link href="<?=MEDIA_URL?>css/general.css" rel="stylesheet" type="text/css" />
</head>

<body>
<script>
//删除图片
function delpic(id,picdiv){
	var url = "<?=URL?>index.php/admin/tag/delpic";
	$.get(url,{id:id},function(data){
		if(data==1){
			$("#"+picdiv).remove();
		}else{
		    alert("删除失败");
		}
	});
}
function verify(){
	var bname = document.getElementById('bname').value;
	var des = document.getElementById('des').value;
	if (des == '' || bname== '') {
		alert('请认真填写信息');
		return false;
	}
	return true;
}
</script>

  <ul id="container">
    <li id="header">
      <h1>品牌管理</h1>
      <div class="link"></div>
      <div id="desc">发布品牌</div>
    </li>
  </ul>
<div style="padding:10px;">
<form action="<?=URL?>index.php/admin/tag/tagUpdate" name="form1" method="post" enctype="multipart/form-data" onsubmit="return verify();">
<table style="border:none;">
	<tr>
    	<td width="80"><strong>品牌名称</strong></td>
		<td><input type="text" name="bname" id="bname" value="<?=$tags->bname?>" size="60" /></td>
    </tr>

    <tr>
        <td><strong>首页显示</strong></td>
        <td><input type="radio" name="isindex" id="isindex1" value="1" <?=($tags->bname=='1')?'checked':''?> />显示
         | <input type="radio" name="isindex" id="isindex2" value="0" <?=($tags->bname=='1')?'':'checked'?> />不显示
		 </td>
    </tr>
    <tr>
    	<td><strong>品牌描述</strong></td>
		<td>	<textarea cols="80" name="des" id="des" rows="10"><?=isset($tags->des) ? $tags->des : ''?></textarea></td>
    </tr>
	<tr>
    	<td width="80" rowspan='2'><strong>图片</strong></td>
		<td>
		<?php
		if($tags->bpicpath!=''){
		?>	
		<div id="pic<?=$tags->id?>" style="float:left; margin-right:10px;"><a href="javascript:void(0);" onclick="delpic(<?=$tags->id?>,'pic<?=$tags->id?>');">[-]</a><img src="<?=URL.$tags->bpicpath?>"/></div>
		<?php
		}
		?>
		</td>
    </tr>
	<tr><td><input type="file" name="picfile[]" id="" /></td></tr>
</table>


    <input type="hidden" name="id" value="<?=$tags->id?>" />
    <br/><input type="submit" value="提交" />  <input type="button" value="返回品牌列表" onclick="history.go(-1);" />
</form>
</div>
</body>
</html>
