<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>购物车-【漫淘客】</title>
<link href="<?=URL?>media/css/mtk.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=URL?>media/js/jquery-1.3.2.min.js"></script>
<script>
/** 数量修改 */
function upcount(t,cartid,gid){
	var count = parseInt(t.value);
	$.ajax({
		type: "POST",
		url: "<?=URL?>index.php/front/cart/gCount",
		data:"gid="+gid,
		success:function (msg){
			if(count > msg){
				alert('库存量不足');
				t.value=$("#count"+cartid).val();
			}else{
				$.ajax({
					type: "POST",
					url: "<?=URL?>index.php/front/cart/upCount",
					data:"cartid="+cartid+"&count="+count+"&gid="+gid,
					success:function (msg){
						if(msg !='no'){
							var obj =eval("["+msg+"]");
							$("#yh").html(obj[0]['yh']);
							$("#mark").html(obj[0]['mark']);
							$("#money").html(obj[0]['money']);
							$("#count"+cartid).val(count);
						}
						if(msg =='buzu'){
							alert('库存量不足');
						}
					}
				});
			}
		}
	});
}

function cartBrief(){
	$.ajax({
		type:"POST",
		 url:"<?=URL?>index.php/front/cart/cartBrief",
		data:"",
	 success:function (msg){
			obj = eval("("+msg+")");
			count = 0;
			qian = 0;
			document.getElementById('spzs').innerHTML="";
			for(var i=0;i<obj.length;i++){
				count+=parseInt(obj[i]['goodscount']);
				qian+=parseFloat(obj[i]['shoppirce'])*parseInt(obj[i]['goodscount']);
		
				var p = document.createElement("div");
				p.id="show"+obj[i]['id'];
				p.className="xx_1";
				p.innerHTML="<div class='tu_z'><img src=\"<?=URL?>"+obj[i]['pic']+"\"/></div><div class='s_name'>"+obj[i]['goodsname']+"</div><div class='s_pice fn_12px fn_red b'>"+obj[i]['shoppirce']+"*"+obj[i]['goodscount']+"<br/><span class='fn_hs'><a href='<?=URL?>index.php/front/cart/delCart?cart="+obj[i]['id']+"' style='color:#9D9D9D;'>删除</a></span></div>";
				
				document.getElementById('spzs').appendChild(p);
			}
			$("#gcount").html(count);
			$("#submoney").html(qian+"元");
			document.getElementById("xsk").style.display="block";
		}
	});
}

function cartBriefHid(){
	document.getElementById("xsk").style.display="none";
}

</script>
</head>

<body>
<!-- 网页头部 -->
<?php
	include_once(PRO_ROOT."template/default/front/include/nav1.php");
?>
<div id="line"></div> 


<!--头部结束-->
<div class="box4">
  <h1><img src="<?=URL?>media/img/front/order.gif" /></h1>
  <div class="order_top fn_14px b fn_hs">我已挑选的商品</div>
  <table width="912" border="0" cellspacing="0" id="ord">
    <tr bgcolor="#e8e8e8">
      <td height="35" colspan="2">　　商品名称</td>
      <td width="100" align="center">商品编号</td>
      <td width="60" align="center">积分</td>
      <td width="100" align="center">市场价</td>
      <td width="100" align="center">漫淘客价</td>
	  <td width="100" align="center">会员价</td>
      <td width="62" align="center">优惠</td>
      <td width="97" align="center">商品数量</td>
      <td width="100" align="center">删除</td>
    </tr>
	<?php
		$marketmoney = 0;
		$shopmoney = 0;
		$mark = 0;
		foreach ($cart as $item){
		$marketmoney = ($marketmoney +($item->marketprice * $item ->goodscount));
		$shopmoney =($shopmoney + ($item ->mprice * $item ->goodscount));
		$mark = ($mark + $item ->mark);
	?>
    <tr>
      <td width="55" align="center" style=" padding:3px 0 3px 5px;"><img width=61 height=61 src="<?=URL?><?=$item->pic['apath'].$item->pic['filename'].'_61.'.$item->pic['atype']?>" /></td>
      <td width="190" height="50"><a href="#"><?=$item->goodsname?></a></td>
      <td align="center"><?=$item->goods_sn?></td>
      <td align="center"><?=$item->mark?></td>
      <td align="center">￥<?=$item->marketprice?></td>
      <td align="center" class="fn_red">￥<?=$item->shoppirce?></td>
	  <td align="center" class="fn_red">￥<?=$item->mprice?></td>
      <td align="center"><?=$item->cheap?></td>
      <td align="center"><input type="text" value="<?=$item->goodscount?>" onblur="upcount(this,'<?=$item->id?>','<?=$item->goodsid?>','<?=$item->shoppirce?>','<?=$item->goodscount?>')"/>
		<input type="hidden" id="count<?=$item->id?>" value="<?=$item->goodscount?>"/>
	  </td>
      <td align="center"><a href="<?=URL?>index.php/front/cart/delCart?cart=<?=$item->id?>">删除</a></td>
    </tr>
	<?php
	}
	?>
    <tr bgcolor="#E8E8E8">
      <td height="50" colspan="10" align="center">
        <table border="0" align="right" cellspacing="0" id="jq" class="fn_hs">
          <tr>
            <td width="121" align="left" valign="middle" ><h3>您共节省：<span class="fn_red">￥<span id="yh"><?=$marketmoney -$shopmoney?></span></span></h3>
            <h3>获得积分：<span class="fn_red" id="mark"><?=$mark?></span></h3></td>
            <td width="202" valign="middle" id="jq_td" class="fn_16px b">商品金额总计：<span class="fn_red">￥<span id="money"><?=$shopmoney?></span></span></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <table width="912" border="0" cellspacing="0" id="cz">
    <tr>
      <td width="35" valign="bottom"></td>
      <td width="12"><img src="<?=URL?>media/img/front/wj.gif" /></td>
      <td width="78"><a href="<?=URL?>index.php/front/collect">我的收藏夹</a></td>
      <td width="8"><img src="<?=URL?>media/img/front/ds_05.gif" /></td>
      <td width="475"><a href="<?=URL?>index.php/front/cart/clearCart">清空购物车</a></td>
      <td width="134"><a href="<?=URL?>index.php"><img src="<?=URL?>media/img/front/jx_03.gif" /></a></td>
      <td width="118"><a href="<?=URL?>index.php/front/order/orinfo"><img src="<?=URL?>media/img/front/qjs_03.gif" /></a></td>
      <td width="36"></td>
    </tr>
  </table>
  <div class="line2"></div>
  <?php
	if($regoods !='' || count($regoods)!=0){
  ?>
  <div class="tj">
    <h2>根据您挑选的商品，漫淘客为您推荐</h2>
      <ul class="list_tj">
		<?php
			foreach ($regoods as $itm){
		?>
        <li><div class="img2"><img src="<?=URL.$itm->pic['apath'].$itm->pic['filename'].'_61.'.$itm->pic['atype']?>" /></div><h6><?=$itm->goodsname?></h6><h4><span class="m2">￥<?=$itm->shopprice?></span><span class="s">￥<?=$itm->marketprice?></span></h4><h5><a href="<?=URL?>index.php/front/cart/cartInsert?gid=<?=$itm->id?>&loca=2"><img src="<?=URL?>media/img/front/jrgw.gif" /></a></h5></li>
		<?php
			}
		?>
      </ul>
  </div>
  <?php
	}
  ?>
</div>
</body>
</html>
