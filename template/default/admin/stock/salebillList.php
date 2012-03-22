<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--
<script type="text/javascript" src="http://static.comicyu.com/js/jquery.js"></script>
<script type="text/javascript" src="http://static.comicyu.com/js/ajax.js"></script>
-->
<link href="<?=MEDIA_URL?>css/general.css" rel="stylesheet" type="text/css" />
<title>漫淘客商城</title>
</head>

<body>
<script>
function con() {
	if( !confirm('确定要删除么？') ) {
		return false;
	}
	return true;
}
</script>

  <ul id="container">
    <li id="header">
      <h1>库存管理</h1>
      <div class="link"></div>
      <div id="desc">库存预警</div>
    </li>
    <li id="tips">
    <form action="" method="post">
        搜索：
        <select name="type" id="type">
          <option value="iid">发货单流水号</option>
          <option value="order">订单号</option>
          <option value="user">收货人</option>
        </select>
        <select name="state" id="state">
          <option value="2">全部</option>
          <option value="0">未发货</option>
          <option value="1">已发货</option>
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
    <th width="200">出库单流水号</th>
    <th width="200">订单编号</th>
    <th width="100">下单时间</th>
    <th width="100">发货人</th>
    <th width="100">发货时间</th>
    <th width="100">收货人</th>
    <th width="100">收货人电话</th>
    <th width="100">物流公司</th>
    <th width="100">发货单状态</th>
    <th width="100">操作</th>
</tr>
<?php
foreach ($page->objectList() as $v){
?>
<tr>
    <td><?=$v->iid?></td>
    <td><?=$v->order_sn?></td>
    <td><?=date('Y-m-d H:i:s',$v->billtime)?></td>
    <td><?=empty($v->uid) ? '-' : base::getAdminName($v->uid)?></td>
    <td><?=empty($v->outtime) ? '-' : date('Y-m-d H:i:s',$v->outtime)?></td>
    <td><?=$v->consignee?></td>
    <td><?=$v->tel?></td>
    <td><?=supply::getLogisticsName($v->lid)?></td>
    <td><?=supply::getBillState($v->state)?></td>
    <td><a href="<?=URL?>index.php/admin/stock/salebillShow?id=<?=$v->id?>" target="_blank">查看/发货</a>
     | <a href="<?=URL?>index.php/admin/stock/salebillDel?id=<?=$v->id?>" onclick="return con();">删除</a>
    </td>
</tr>
<?php
}
?>
</table>
<a href="<?=URL?>index.php/admin/stock/salebillList?state=0&asc=1" style="margin-left:10px;">待发货的</a>
 | <a href="#" onclick="javascript:window.location.reload();">刷新</a>
<?=$page->getHtml("?type=$type")?>
</body>
</html>
