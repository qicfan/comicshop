<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="<?=URL?>media/css/main.css" rel="stylesheet" type="text/css"/>
<link href="<?=MEDIA_URL?>css/general.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=URL?>media/js/jquery.js"></script>
<style>
.title-background-left{
	font-size:12px;
	font-weight:bold;
	width:20%;
}
.title-background-right{
	width:30%;
}

.margin_10{
	margin-top:10px;
}
</style>
<script>
function fomsub(oid,sta,act){
	var str = document.getElementById("remark").value;
	if(str==''){
		alert("请填写操作备注内容！");
	}else{
		if(confirm("您确定要执行此项操作吗?")){
			document.getElementById("oid").value=oid;
			document.getElementById("act").value=act;
			if(act==1){    //订单
				document.getElementById("sta").value=sta;
			}
			if(act==2){    //支付
				document.getElementById("pstate").value=sta;
			}
			if(act==3){    //配货
				document.getElementById("poststate").value=sta;
			}
			document.getElementById("fom").action="<?=URL?>index.php/admin/order/state";
			document.getElementById("fom").submit();
		}
	}
}

/** 更改购买数量 */
function changecount(oid,gorid,gid){
	var count=$("#count"+gorid).val();
	$.ajax({
		type: "POST",
		url: "<?=URL?>index.php/admin/order/checkgcount",
		data:"gid="+gid+"&count="+count,
		success:function (msg){
			if(msg=='ok'){	document.location.href="<?=URL?>index.php/admin/order/updateOrGoods?gorid="+gorid+"&count="+count+"&oid="+oid+"&gid="+gid;
			}
			if(msg=='nocount'){
				alert('Sorry 库存量不足！');
			}
		}
	});	

}

/** 删除订单信息 */
function delorder(oid,gorid,gid){
	if(confirm("您确定要删除此项吗?")){	
		document.location.href="<?=URL?>index.php/admin/order/del?orderid="+oid+"&gorid="+gorid+"&gid="+gid;
	}
}

/** 显示编辑费用 */
function showFee(){
	document.getElementById("fee").style.display = "block";
	document.getElementById("feeinfo").style.display = "none";
}

/** 修改费用信息 */
function updateFee(oid){
	var cardfee = $("#cardfee").val();
	var tax = $("#tax").val();
	var packagefee = $("#packagefee").val();
	var postfee = $("#postfee").val();
	document.location.href="<?=URL?>index.php/admin/order/fee?oid="+oid+"&cardfee="+cardfee+"&tax="+tax+"&packagefee="+packagefee+"&postfee="+postfee;
}

/** 发票修改显示 */
function showhidden(obj){
	document.getElementById("fp").style.display="none";
	document.getElementById("fpxg").style.display="block";
}

/** 发票保存 */
function savefp(oid){
	obj1 = document.getElementsByName("fpty");
	obj2 = document.getElementsByName("fphead");
	obj3 = document.getElementsByName("fpcontent");
	var ty ='';
	for(var i=0;i<obj1.length;i++){
		if(obj1[i].checked){
			ty= obj1[i].value;
		}
	}
	var head='';
	for(var j=0;j<obj2.length;j++){
		if(obj2[j].checked){
			head= obj2[j].value;
		}
	}
	var cont='';
	for(var m=0;m<obj3.length;m++){
		if(obj3[m].checked){
			cont= obj3[m].value;
		}
	}
	window.location.href="<?=URL?>index.php/admin/order/fpsave?oid="+oid+"&fpty="+ty+"&fphead="+head+"&fpcont="+cont;
}

</script>
</head>

<body>
<div>
	<div class="main-header">管理中心&nbsp;-&nbsp;<span>订单详情</span></div>
    <div class="main-border">
		<div>
			<div style="background-color:#D9EEED;height:25px;line-height:25px;text-align:center;font-weight:bold;">基本信息</div>
			<div>
				<table width="0" style="width:100%;text-align:center;border:1px;">
					<tr>
						<td class="title-background-left">订单号</td>
						<td class="title-background-right"><?=$orinfo[0]->order_sn?></td>
						<td class="title-background-left">订单状态</td>
						<td class="title-background-right">
						<?php
							switch ($orinfo[0]->orderstate){
								case 0:
									echo "无效订单 ";
									break;
								case 1:
									echo "有效订单 ";
									break;
								case 2:
									echo "已取消 ";
									break;
								case 3:
									echo "成功订单 ";
									break;
							}
							switch ($orinfo[0]->paystate){
								case 0:
									echo "未付款 ";
									break;
								case 1:
									echo "已付款 ";
									break;
							}
							switch ($orinfo[0]->poststate){
								case 0:
									echo "未发货 ";
									break;
								case 1:
									echo "配货中 ";
									break;
								case 2:
									echo "已发货 ";
									break;
							}
						?>
						</td>
					</tr>
					<tr>
						<td class="title-background-left">购货人</td>
						<td class="title-background-right"><?=$userinfo[0]->uname?></td>
						<td class="title-background-left">下单时间</td>
						<td class="title-background-right"><?php echo date('Y-m-d H:i:s',$orinfo[0]->createtime);?></td>
					</tr>
					<tr>
						<td class="title-background-left">支付方式</td>
						<td class="title-background-right">
						<?php
							switch ($orinfo[0]->paytype){
								case 0:
									echo "网上支付";
									break;
								case 1:
									echo "货到付款";
									break;
							}
						?>
						</td>
						<td class="title-background-left">付款时间</td>
						<td class="title-background-right">
						<?php
							if($orinfo[0]->paystate=='0'){
								echo "未支付";
							}
							if($orinfo[0]->paystate=='1')
							{
								echo date('Y-m-d H:i:s',$orinfo[0]->paytime);
							}
						?>
						</td>
					</tr>
					<tr>
						<td class="title-background-left">配送方式</td>
						<td class="title-background-right">
						<?php
							switch ($orinfo[0]->posttype){
								case 0:
									echo "自提";
									break;
								case 1:
									echo "快递";
									break;
								case 2:
									echo "EMS";
									break;
							}
						?>
						</td>
						<td class="title-background-left">配送费用</td>
						<td class="title-background-right"><?=$orinfo[0]->postfee?></td>
					</tr>
					<tr>
						<td class="title-background-left">订单来源</td>
						<td class="title-background-right">
						<?php
							switch ($orinfo[0]->operator){
								case 1:
									echo "管理员添加";
									break;
								case 2:
									echo "用户生成";
									break;
							}
						?>
						</td>
						<td class="title-background-left">发货时间</td>
						<td class="title-background-right">
						<?php
							if($orinfo[0]->poststate=='0'){
								echo "未发货";
							}
							if($orinfo[0]->poststate=='1'){
								echo date('Y-m-d H:i:s',$orinfo[0]->posttime);
							}
						?>
						</td>
					</tr>
				</table>
			</div>
		</div>

		<div class="margin_10">
			<div id="fp">
			<div style="background-color:#D9EEED;height:25px;line-height:25px;text-align:center;font-weight:bold;" id="fp">发票信息<span style="margin-left:10px;font-size:12px;font-weight:normal;cursor:pointer;" onclick="showhidden('fp')">编辑</span></div>
			<div style="text-align:center;">
				<table style="width:100%;">
					<tr>
						<td class="title-background-left">发票类型</td>
						<td class="title-background-right">
							<?php
								switch ($orinfo[0]->invoicetype){
									case 0:
										echo "普通发票";
										break;
									case 1:
										echo "增值税发票";
										break;
								}
							?>
						</td>
						<td class="title-background-left">发票抬头</td> 
						<td class="title-background-right">
							<?php
								switch ($orinfo[0]->invoicehead){
									case 1:
										echo "个人";
										break;
									case 2;
										echo "单位";
										break;
								}
							?>
						</td>
					</tr>
					<tr>
						<td class="title-background-left">发票内容</td>
						<td class="title-background-right">
							<?php
								switch($orinfo[0]->invoicecontent){
									case 1:
										echo "明细";
										break;
									case 2:
										echo "办公用品";
										break;
									case 3:
										echo "电脑组件";
										break;
									case 4:
										echo "耗材";
										break;
								}
							?>
						</td>
					</tr>
				</table>
			</div>
			</div>
			
			<div id="fpxg" style="display:none;">
			<div style="background-color:#D9EEED;height:25px;line-height:25px;text-align:center;font-weight:bold;">发票信息<span style="margin-left:10px;font-size:12px;font-weight:normal;cursor:pointer;">关闭</span></div>
			<div style="text-align:center;">
				<table style="width:100%;">
					<tr>
						<td class="title-background-left">发票类型</td>
						<td class="title-background-right">
							<input type="radio" name="fpty" value="0" <?php if($orinfo[0]->invoicetype==0){echo 'checked';}?>>普通发票
							<input type="radio" name="fpty" value="1" <?php if($orinfo[0]->invoicetype==1){echo 'checked';}?>>增值税发票
						</td>
						<td class="title-background-left">发票抬头</td> 
						<td class="title-background-right">
							<input type="radio" name="fphead" value="1" <?php if($orinfo[0]->invoicehead==1){echo 'checked';}?>>个人
							<input type="radio" name="fphead" value="2" <?php if($orinfo[0]->invoicehead==2){echo 'checked';}?>>单位
						</td>
					</tr>
					<tr>
						<td class="title-background-left">发票内容</td>
						<td class="title-background-right">
							<input type="radio" name="fpcontent" value="1" <?php if($orinfo[0]->invoicecontent==1){echo 'checked';}?> />明细
							<input type="radio" name="fpcontent" value="2" <?php if($orinfo[0]->invoicecontent==2){echo 'checked';}?>/>办公用品
							<input type="radio" name="fpcontent" value="3" <?php if($orinfo[0]->invoicecontent==3){echo 'checked';}?>/>电脑配件
							<input type="radio" name="fpcontent" value="4" <?php if($orinfo[0]->invoicecontent==4){echo 'checked';}?>/>耗材
						</td>
						<td class="title-background-left"><input type="button" onclick="savefp('<?=$orinfo[0]->id?>')" value="保存"/></td>
					</tr>
				</table>
			</div>
			</div>

		</div>

		<div class="margin_10">
			<div style="background-color:#D9EEED;height:25px;line-height:25px;text-align:center;font-weight:bold;">商品信息</div>
			<div style="width:100%;">
				<table style="width:100%;text-align:center;">
					<tr style="font-weight:bold;font-size:12px;">
						<td>商品名</td>
						<td>货号</td>
						<td>市场价格</td>
						<td>店铺售价</td>
						<td>会员价</td>
						<td>数量</td>
						<td>属性</td>
						<td>小计</td>
						<?php
							if($orinfo[0]->orderstate!=3 && $orinfo[0]->paystate==0 && $orinfo[0]->poststate==0){
						?>
						<td>操作</td>
						<?php }?>
					</tr>
					<?php
					$subtotal=0;
					foreach ($goinfo as $item){
						if($item->goods_type==0){
					?>
						<tr id="goinfo<?=$item->id?>">
							<td><?=$item->goodsname?></td>
							<td><?=$item->goods_sn?></td>
							<td><?=$item->marketprice?></td>
							<td><?=$item->shoppirce?></td>
							<td><?=$item->mprice?></td>
							<?php
								if($orinfo[0]->orderstate!=3 && $orinfo[0]->paystate==0 && $orinfo[0]->poststate==0){
							?>
							<td><input type="text" value="<?=$item->goodscoutn?>" id="count<?=$item->id?>"/></td>
							<?php
							}else{
							?>
							<td><input type="text" value="<?=$item->goodscoutn?>" disabled id="count<?=$item->id?>"/></td>
							<?php }?>
							<td><?=$item->attributename?></td>
							<td id="info<?=$item->id?>"><?php echo $item->mprice*$item->goodscoutn;?></td>
							<?php
								if($orinfo[0]->orderstate!=3 && $orinfo[0]->paystate==0 && $orinfo[0]->poststate==0){
							?>
							<td>
								<span style="cursor:pointer;" onclick="changecount('<?=$orinfo[0]->id?>','<?=$item->id?>','<?=$item->goodsid?>')">修改</span>&nbsp;
								<span style="cursor:pointer;" onclick="delorder('<?=$orinfo[0]->id?>','<?=$item->id?>','<?=$item->goodsid?>')">删除</span>
							</td>
							<?php }?>
						</tr>
					<?php
						$subtotal+=($item->mprice*$item->goodscoutn-$item->cheap);
						}
						if($item->goods_type==1){
					?>
						<tr id="goinfo<?=$item->id?>">
							<td>赠品：<?=$item->goodsname?></td>
							<td><?=$item->goods_sn?></td>
							<td><?=$item->marketprice?></td>
							<td><?=$item->shoppirce?></td>
							<td><?=$item->mprice?></td>
							<td><?=$item->goodscoutn?></td>
							<td><?=$item->attributename?></td>
							<td id="info<?=$item->id?>"><?php echo $item->mprice*$item->goodscoutn;?></td>
							<td>&nbsp;</td>
						</tr>
					<?php
						}
					}
					?>
				</table>
				<div style="text-align:right;height:25px;line-height:25px;padding-right:10px;">总计：<span id="subtotal"><?=$subtotal?></span>元</div>
			</div>
		</div>

		<div class="margin_10">
			<div style="background-color:#D9EEED;height:25px;line-height:25px;text-align:center;font-weight:bold;">收货人信息<span style="margin-left:10px;font-size:12px;font-weight:normal;cursor:pointer;"><a href="<?=URL?>index.php/admin/order/addr_sel?oid=<?=$orinfo[0]->id?>" target="main">编辑</a></span></div>
			<div style="text-align:center;">
				<table style="width:100%;">
					<tr>
						<td class="title-background-left">收货人</td>
						<td class="title-background-right"><?=$orinfo[0]->consignee?></td>
						<td>&nbsp;</td>
						<td class="title-background-right"></td>
					</tr>
					<tr>
						<td class="title-background-left">所在地</td>
						<td class="title-background-right">
						<!--级联选择-->
						<select id="s1" name="province" style="width:80px">
							<?php
							$rs = base::getRegionName($orinfo[0]->province);
							if($rs!=''){
							?>
								<option value=""><?=$rs?></option>
							<?php
							}else{
							?>
							<option value="">请选择...</option>
							<?php
							}
							?>
						</select>
						<select id="s2" name="city" style="width:80px">
							<?php
							$rs = base::getRegionName($orinfo[0]->city);
							if($rs!=''){
							?>
								<option value=""><?=$rs?></option>
							<?php
							}else{
							?>
							<option value="">请选择...</option>
							<?php
							}
							?>
						</select>
						<select id="s3" name="county" style="width:80px">
							<?php
							$rs = base::getRegionName($orinfo[0]->district);
							if($rs!=''){
							?>
								<option value=""><?=$rs?></option>
							<?php
							}else{
							?>
							<option value="">请选择...</option>
							<?php
							}
							?>
						</select>
						<!--级联选择End-->
						</td>
						<td class="title-background-left">地址</td>
						<td class="title-background-right"><?=$orinfo[0]->address?></td>
					</tr>
					<tr>
						<td class="title-background-left">电话</td>
						<td class="title-background-right"><?=$orinfo[0]->tel?></td>
						<td class="title-background-left">手机</td>
						<td class="title-background-right"><?=$orinfo[0]->mobile?></td>
					</tr>
					<tr>
						<td class="title-background-left">邮编</td>
						<td class="title-background-right"><?=$orinfo[0]->zipcode?></td>
						<td class="title-background-left">邮箱</td>
						<td class="title-background-right"><?=$orinfo[0]->email?></td>
					</tr>
					<tr>
						<td class="title-background-left">最佳送货时间</td>
						<td class="title-background-right">
							<?php if($orinfo[0]->besttime!=0){echo date('Y-m-d',$orinfo[0]->besttime);}?>
						</td>
						<td class="title-background-left">标志性建筑</td>
						<td class="title-background-right"></td>
					</tr>
				</table>
			</div>
		</div>

		<div class="margin_10">
			<div style="background-color:#D9EEED;height:25px;line-height:25px;text-align:center;font-weight:bold;">费用信息<span style="margin-left:10px;font-size:12px;font-weight:normal;cursor:pointer;" onclick="showFee()">编辑</span></div>
			<div style="height:30px;line-height:30px;text-align:right;padding-right:10px;" id="feeinfo">
				商品总金额：￥<?=$orinfo[0]->goodsmount?> +配送费用：￥<?=$orinfo[0]->postfee?> +包装费：￥<?=$orinfo[0]->packagefee?> +税费：￥<?=$orinfo[0]->tax?> -优惠金额：￥<?=$orinfo[0]->cardfee?> =订单总金额：￥<?php echo ($orinfo[0]->goodsmount+$orinfo[0]->postfee+$orinfo[0]->packagefee+$orinfo[0]->tax-$orinfo[0]->cardfee)?>
			</div>
			<div id="fee" style="display:none;">
				<table style="width:100%;">
					<tr>
						<td>配送费用</td>
						<td><input type="text" name="" id="postfee" value="<?=$orinfo[0]->postfee?>"/></td>
						<td>包装费</td>
						<td><input type="text" name="" id="packagefee" value="<?=$orinfo[0]->packagefee?>"></td>
					</tr>
					<tr>
						<td>税费</td>
						<td><input type="text" name="" id="tax" value="<?=$orinfo[0]->tax?>"></td>
						<td>优惠金额</td>
						<td><input type="text" name="" id="cardfee" value="<?=$orinfo[0]->cardfee?>"></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td><input type="button" onclick="updateFee('<?=$orinfo[0]->id?>')" value="保存"/></td>
					</tr>
				</table>
			</div>
		</div>

		<div class="margin_10" style="text-align:center;">
			<div style="background-color:#D9EEED;height:25px;line-height:25px;text-align:center;font-weight:bold;">操作信息</div>
			<form action="" name="fom" id="fom" method="POST">
			<div style="margin-top:5px;">
				操作备注：<textarea name="remark" id="remark" rows="3" cols="100"></textarea>
			</div>
			<div style="padding:5px;">
			<?php
				if($orinfo[0]->orderstate==0){
			?>
				<input type='button' onclick="fomsub('<?=$orinfo[0]->id?>',1,1)" value='确定'/>
				<input type="button" onclick="fomsub('<?=$orinfo[0]->id?>',2,1)" value="取消"/>
			<?php } ?>

			<?php
				if($orinfo[0]->orderstate==2){
			?>
				<input type="button" onclick="{location.href='<?=URL?>index.php/admin/order/drop?oid=<?=$orinfo[0]->id?>'}" value="移除"/>
			<?php }?>

			<?php    //有效订单
				if($orinfo[0]->orderstate==1){
			?>
				<input type="button" onclick="fomsub('<?=$orinfo[0]->id?>',2,1)" value="取消"/>

				<!-- 不是货到付款 -->
				<?php
					if($orinfo[0]->paytype==0){
						if($orinfo[0]->paystate==0){
				?>
							<input type="button" onclick="fomsub('<?=$orinfo[0]->id?>',1,2)" value="付款"/>
				<?php	} ?>
				<?php	if($orinfo[0]->paystate==1){
							if($orinfo[0]->poststate==0){
				?>
								<input type="button" onclick="fomsub('<?=$orinfo[0]->id?>',1,3)" value="去配货"/>
					<?php	} ?>
					<?php
							if($orinfo[0]->poststate==1){
					?>
								<input type="button" onclick="{location.href='<?=URL?>index.php/admin/stock/salebillList?oid=<?=$orinfo[0]->id?>'}" value="生成发货单"/>
								<input type="button" onclick="fomsub('<?=$orinfo[0]->id?>',2,3)" value="发货"/>
					<?php	}
							if($orinfo[0]->poststate==2){
					?>
								<input type="button" onclick="fomsub('<?=$orinfo[0]->id?>',3,1)" value="设为成功订单"/>
					<?php
							}
						}
					}
				?>
				<!-- end -->

				<!-- 货到付款 -->
				<?php
					if($orinfo[0]->paytype==1){
						if($orinfo[0]->poststate==0){
				?>
							<input type="button" onclick="fomsub('<?=$orinfo[0]->id?>',1,3)" value="配货"/>
				<?php
						}
						if($orinfo[0]->poststate==1){
				?>
							<input type="button" onclick="fomsub('<?=$orinfo[0]->id?>',2,3)" value="发货"/>
				<?php
						}
						if($orinfo[0]->poststate==2){
							if($orinfo[0]->paystate==0){
				?>
								<input type="button" onclick="fomsub('<?=$orinfo[0]->id?>',1,2)" value="付款"/>
				<?php
							}
							if($orinfo[0]->paystate==1){
				?>
								<input type="button" onclick="fomsub('<?=$orinfo[0]->id?>',3,1)" value="设为成功订单"/>
				<?php
							}
						}
					}
				?>
				<!-- end -->
			<?php }?>
			</div>
			<input type="hidden" name="act" id="act" value=""/>
			<input type="hidden" name="oid" id="oid" value=""/>
			<input type="hidden" name="sta" id="sta" value="<?=$orinfo[0]->orderstate?>"/>
			<input type="hidden" name="pstate" id="pstate" value="<?=$orinfo[0]->paystate?>"/>
			<input type="hidden" name="poststate" id="poststate" value="<?=$orinfo[0]->poststate?>"/>
			</form>
			<div class="margin_10" style="width:100%;">
				<table style="width:100%">
					<tr>
						<td style="background-color:#DEEFF3;">操作者</td>
						<td style="background-color:#DEEFF3;">操作</td>
						<td style="background-color:#DEEFF3;">订单状态</td>
						<td style="background-color:#DEEFF3;">支付状态</td>
						<td style="background-color:#DEEFF3;">发货状态</td>
						<td style="background-color:#DEEFF3;">备注</td>
						<td style="background-color:#DEEFF3;">操作时间</td>
					</tr>
					<?php
						foreach ($orderaction as $item){
					?>
					<tr>
						<td><?=$item['uname']?></td>
						<td>
						<?php
							switch ($item['action']){
								case '1';
									echo "更改了订单状态";
									break;
								case '2';
									echo "更改了支付状态";
									break;
								case '3';
									echo "更改了配货状态";
									break;
							}
						?>
						</td>
						<td>
						<?php
							switch ($item['orderstate']){
								case '0':
									echo "无效订单";
									break;
								case '1':
									echo "有效订单";
									break;
								case '2':
									echo "订单已取消";
									break;
								case '3':
									echo "成功订单";
									break;
							}
						?>
						</td>
						<td>
						<?php
							switch ($item['paystate']){
								case 0:
									echo "未付款";
									break;
								case 1:
									echo "已付款";
									break;
							}
						?>
						</td>
						<td>
						<?php
							switch ($item['poststate']){
								case 0:
									echo "未发货";
									break;
								case 1:
									echo "配货中";
									break;
								case 2:
									echo "已发货";
									break;
							}
						?>
						</td>
						<td><?=$item['note']?></td>
						<td><?php echo date('Y-m-d H:i:s',$item['operationtime'])?></td>
					</tr>
					<?php }?>
				</table>
			</div>
		</div>

    </div>
    <div class="main-footer">版权归comicyu所有</div>
</div>
</body>
</html>
