<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="<?=URL?>media/css/main.css" rel="stylesheet" type="text/css"/>
</head>

<body>
<div>
	<div class="main-header">管理中心&nbsp;-&nbsp;<span>订单列表</span></div>
    <div class="main-border">
		<table style="width:100%;text-align:center;">
			<tr>
				<td class="tr-td-head">订单号</td>
				<td class="tr-td-head">下单时间</td>
				<td class="tr-td-head">收货人</td>
				<td class="tr-td-head">总金额</td>
				<td class="tr-td-head">应付金额</td>
				<td class="tr-td-head">订单状态</td>
				<td class="tr-td-head">操作</td>
			</tr>
			<?php
				foreach($orinfo as $item){
			?>
			<tr>
				<td><?=$item->order_sn?></td>
				<td><?php echo date('Y-m-d H:i:s',$item->createtime)?></td>
				<td><?=$item->consignee?></td>
				<td><?=$item->goodsmount?></td>
				<td></td>
				<td>
				<?php
				switch ($item->orderstate){
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
				?>
				</td>
				<td><a href="<?=URL?>index.php/admin/order/detail?oid=<?=$item->id?>">查看</a></td>
			</tr>
			<?php
			}
			?>
		</table>
		<div style="height:25px; line-height:25px;text-align:right;padding-right:10px;"><?=$page?></div>
    </div>
    <div class="main-footer">版权归comicyu所有</div>
</div>
</body>
</html>
