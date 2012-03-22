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

  <ul id="container">
    <li id="header">
      <h1>会员管理</h1>
      <div class="link"></div>
      <div id="desc">会员详情</div>
    </li>
</ul>
<table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
    <tr>
        <td>用户名：<?=$info->uname?></td>
        <td>积分：<?=empty($score) ? 0 : $score?></td>
        <td>编号：<?=$info->id?></td>
        <td>漫域通行证ID：<?=$info->uid?></td>
    </tr>
    <tr>
    	<td colspan="4"><a href="<?=URL?>index.php/admin/user/userShow?act=1&id=<?=$id?>&uid=<?=$info->uid?>">查看Ta的购物车</a>
		 | <a href="<?=URL?>index.php/admin/user/userShow?act=2&id=<?=$id?>&uid=<?=$info->uid?>">查看Ta的收藏</a>
    	 | <a href="<?=URL?>index.php/admin/user/userShow?act=3&id=<?=$id?>&uid=<?=$info->uid?>">查看Ta的订单</a></td>
    </tr>
</table>

<table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
	<?php
	if ($act == 1) {
	?>  
		<tr>
			<th>商品货号</td>
			<th>商品名称</td>
            <th>商品属性</td>
			<th>商品价格</td>
			<th>购买数量</td>
		</tr>
    <?php
	} else if ($act == 3) {
	?>
    	<tr>
			<th>订单编号</td>
            <th>下单时间</td>
            <th>收货人</td>
            <th>商品总价</td>
            <th>订单状态</td>		
		</tr>
	<?php
	}
	?>
        
	<?php
	if ( !empty($detail) ) {
		foreach ($detail->objectList() as $v) {
	?>
		<?php
			if ($act == 1) {
        ?>    
            <tr>
            	<td><?=$v->goods_sn?></td>
                <td><?=$v->goodsname?></td>
                <td><?=$v->attributename?></td>
                <td><?=$v->shoppirce?></td>
                <td><?=$v->goodscount?></td>
            </tr>
    	<?php
			} else if ($act == 2) {
		?>
        	<tr>
            	<td> + <?=base::getGoodsName($v->gid)?></td>
            </tr>
        <?php
			} else if ($act == 3) {
		?>
        	<tr>
            	<td><?=$v->order_sn?></td>
                <td><?=date('Y-m-d H:i:s', $v->createtime)?></td>
                <td><?=$v->consignee?></td>
                <td><?=$v->goodsmount?></td>
                <td><?php
				switch ($v->orderstate){
					case 0;
						echo "无效订单";
						break;
					case 1;
						echo "有效订单";
						break;
					case 2;
						echo "已取消";
						break;
					case 3;
						echo "成功";
						break;
				}
				?></td>            
            </tr>
    <?php
			}
		}
	}
	?>
</table>
<?php
if ( !empty($detail) ) {
	echo $detail->getHtml("?act=$act&id=$id");
}
?>
</body>
</html>
