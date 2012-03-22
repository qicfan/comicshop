<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>新入库商品列表</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?=MEDIA_URL?>css/general.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=MEDIA_URL?>js/function.js"></script>
<script type="text/javascript">
	function addselect(){
		var con = confirm("您确定要添加所选吗");
		if(con){
			var goodsids = checkmulti("没有选择添加的选项！","chk");
			if(!goodsids){
				return false;
			}
			document.getElementById("goodsall").href="<?=URL?>index.php/admin/goods/goodsselectadd?gids="+goodsids;
		}
		
		
	}
</script>

</head>
<body>
<ul id="container">
  <li id="header">
    <h1>新入库商品列表</h1>
    
    <div id="desc">
    </div>
  </li>
  <li id="tips">
    <form method="GET" action="">
      <select name="keywordstype">
	  	<option value="0">请选择</option>
		<?php
			if($keytype==1){
		?>
        <option value="1" selected="selected">商品名称</option>
		<?php
			}else{
		?>
		<option value="1">商品名称</option>
		<?php
			}
		?>
		<?php
			if($keytype==2){
		?>
		<option value="2" selected="selected">商品编号</option>
		<?php
			}else{
		?>
		<option value="2">商品编号</option>
		<?php
			}
		?>
      </select>
      <input type="text" name="keywords" onfocus="javascript:this.value='';" id="keywords" <?php if($keywords==''){?> value="关键字"<?php }else{?> value="<?=$keywords?>"<?php }?>/>
      <input type="submit" value="搜索">
    </form>
  </li>
  <li id="wrapper">
    <table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
      <tr>
        <th class="first-cell"><input id="chkControl" onClick="chkChecked(this.checked,'chk')" type="checkbox" />编号</th>
        <th>货号</th>
		<th>商品名称</th>
		<th>库存</th>
        <th>供应商</th>
		<th>进货价</th>
		<th>市场价</th>
		<th>售价</th>
		<th>操作</th>
      </tr>
	  <?php
	  	$goods = $goodsObj->objectList();
	  	for($i=0;$i<count($goods);$i++){
	  ?>
      <tr>
        <td class="first-cell"><input name="chk" value="<?=$goods[$i]->id?>" type="checkbox" /><?=$goods[$i]->id?></td>
        <td><?=$goods[$i]->goods_sn?></td>
		<td><?=$goods[$i]->goodsname?></td>
		<td><?=$goods[$i]->leavingcount?></td>
		<td><?=$goods[$i]->sid?></td>
		<td><?=$goods[$i]->inprice?></td>
		<td><?=$goods[$i]->marketprice?></td>
		<td><?=$goods[$i]->shopprice?></td>
        <td class="handlelist"><a href="<?=URL?>index.php/admin/goods/goodsadd?gid=<?=$goods[$i]->id?>">添加商品</a> </td>
      </tr>
	  <?php
	  	}
	  ?>
      <tr>
        <td colspan="8"><ul id="batch-links" style="margin-top:5px;padding-top:5px;">
			<li class="batch-link" action="batch" param="drop" style="line-height:20px;"><a href="javascript:void(0);" onclick="checkAll('chk','chkControl')">全选</a></li>
            <li class="batch-link" action="batch" param="drop" style="line-height:20px;"><a href="javascript:void(0)" id="goodsall" onclick="return addselect();">添加所选商品</a></li>
          </ul></td>
      </tr>
    </table>
    <?=$goodsObj->getHtml(URL."index.php/admin/goods/goodsnewlist?keywordstype=".$keytype."&keywords=".$keywords)?>
  </li>
  <li id="footer">
    <div>
     Copyright ? 2007-2010 comicyu.com All rights reserved.
    </div>
  </li>
</ul>
</body>
</html>
