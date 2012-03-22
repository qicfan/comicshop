<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="http://static.comicyu.com/js/jquery.js"></script>
<script type="text/javascript" src="http://static.comicyu.com/js/ajax.js"></script>
<link href="<?=MEDIA_URL?>css/general.css" rel="stylesheet" type="text/css" />
<title>漫淘客商城</title>
</head>

<body>
<script type="text/javascript" src="<?=MEDIA_URL?>js/general.js"></script>
<script>
function store(id, amount) {
	$('#gid').attr('value', id);
	$('#amount').attr('value', amount);
	popDiv();
}
</script>

  <ul id="container">
    <li id="header">
      <h1>库存管理</h1>
      <div class="link"></div>
      <div id="desc">库存列表</div>
    </li>
    <li id="tips">
      <form action="" method="post">
        搜索：
        <select name="type" id="type">
          <option value="goodsname">商品名称</option>
          <option value="goods_sn">商品编号</option>
        </select>
        <select name="" id="">
          <option value="">特价</option>
        </select>
        关键字<input type="text" name="keyword" id="keyword" />
        <input type="submit" value="搜索" />
      </form>
    </li>
</ul>
<span style="display:none" id="page"><?=$_GET['page']?></span>
<div id="popDiv">
	<form action="<?=URL?>index.php/admin/stock/stockMod" method="post">
	<input name="gid" id="gid" type="hidden" value="">
    库存数量：<input name="amount" id="amount" type="text" size="10" value="">
     | <input type="submit" value="提交" onclick="" />
    </form>
</div>
<table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
<tr>
    <th width="100">编号</th>
    <th width="200">商品编号</th>
    <th width="200">商品名称</th>
    <th width="100">库存量</th>
    <th width="200">供应商</th>
    <th width="100">市场价</th>
    <th width="100">售价</th>
    <th width="100">操作</th>
</tr>
<?php
foreach ($page->objectList() as $v){
?>
<tr>
	<td><?=$v->id?></td>
    <td><?=$v->goods_sn?></td>
    <td><?=$v->goodsname?></td>
    <td><?=$v->leavingcount?></td>
    <td><?=supply::getSupplyName($v->sid)?></td>
    <td><?=$v->marketprice?></td>
    <td><?=$v->shopprice?></td>
    <td><a href="<?=URL?>index.php/admin/stock/goodsIn?id=<?=$v->id?>">编辑</a>
     | <a href="javascript:void(0);" onclick="return store(<?=$v->id?>, <?=$v->leavingcount?>);">补货</a>
    </td>
</tr>
<?php
}
?>
</table>
<?=$page->getHtml("?type=$type")?>
</body>
</html>
