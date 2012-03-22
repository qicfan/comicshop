<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?=MEDIA_URL?>css/general.css" rel="stylesheet" type="text/css" />
<title>漫淘客商城</title>
</head>

<body>
  <ul id="container">
    <li id="header">
      <h1>退货单管理</h1>
      <div class="link"></div>
    </li>
  <li id="tips">
    <a href="<?=URL?>index.php/admin/supply/supplyEdit">退货单管理</a>
  </li>
</ul>
<table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid" style="font-size:12px;">
<tr>
    <th width="12%">订单号</th>
    <th width="8%">金额</th>
	<th width="10%">退款方式</th>
    <th width="10%">申请时间</th>
    <th width="10%">账号</th>
    <th width="10%">账户</th>
	<th width="10%">所属银行</th>
    <th width="15%">备注</th>
	<th width="5%">状态</th>
    <th width="10%">操作</th>
</tr>
<?php
foreach ($refund as $ref){
?>
<tr>
	<td><?=$ref->orderid?></td>
    <td><?=$ref->amount?></td>
	<td>
	<?php
		switch ($ref->type){
			case 1:
				echo "退款至账户余额";
				break;
			case 2:
				echo "退款至银行账号";
				break;
		}
	?>
	</td>
    <td><?=$ref->refundtime?></td>
    <td><?=$ref->bankcard?></td>
    <td><?=$ref->accountname?></td>
	<td>
	<?php
		switch ($ref->bank){
			case 1:
				echo "农业银行";
				break;
			case 2:
				echo "工商银行";
				break;
			case 3:
				echo "建设银行";
				break;
			case 4:
				echo "中国银行";
				break;
			case 5:
				echo "交通银行";
				break;
			case 6:
				echo "招商银行";
				break;

		}
	?>
	</td>
	<td><?=$ref->remark?></td>
	<td>
	<?php
		switch ($ref->state){
			case 0:
				echo "未处理";
				break;
			case 1:
				echo "已审批";
				break;
			case 2:
				echo "已驳回";
				break;
		}
	?>
	</td>
    <td><a href="<?=URL?>index.php/admin/refund/refundMoney?ordercode=<?=$ref->orderid?>&user=<?=$ref->uid?>">退款</a>
     | <a href="<?=URL?>index.php/admin/refund/reject?ordercode=<?=$ref->orderid?>&refid=<?=$ref->id?>">驳回</a>
    </td>
</tr>
<?php
}
?>
</table>
<?=$page?>
</body>
</html>
