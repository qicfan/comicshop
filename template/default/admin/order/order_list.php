<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="<?=URL?>media/css/main.css" rel="stylesheet" type="text/css"/>
<link href="<?=MEDIA_URL?>css/general.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div>
	<div class="main-header">管理中心&nbsp;-&nbsp;<span>订单列表</span></div>
	<form action="<?=URL?>index.php/admin/order/search" method="GET">
	<div class="main-title">
		订单号<input type="text" name="order_sn"/>&nbsp;
		收货人<input type="text" name="consignee"/>&nbsp;
		订单状态<select name="orstate">
					<option value="">请选择</option>
					<option value="0">无效</option>
					<option value="1">有效</option>
					<option value="2">取消</option>
					<option value="3">成功</option>
				</select>&nbsp;
		<input type="submit" name="" value="搜索"/>
		<span style="margin-left:10px;color:#C6C6C6;">注意：此搜索是全局搜索</span>
	</div>
	</form>
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
				<td>
				<?php
					if($item->freight ==0){
						echo $item->goodsmount + $item ->postfee + $item ->packagefee + $item->tax + $item->cardfee - $item ->cheap;
					}elseif($item->freight ==1){
						echo $item->goodsmount + $item ->packagefee + $item->tax + $item->cardfee - $item ->cheap;
					}
				?>
				</td>
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
