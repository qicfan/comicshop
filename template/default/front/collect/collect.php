<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>我的收藏夹</title>

<link href="<?=MEDIA_URL?>css/mtk_yh.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?=MEDIA_URL?>js/hdm.js"></script>
</head>

<body>

 <!-- 头部-->
<?php require_once(PRO_ROOT . 'template/default/front/include/nav2.php');  ?>  
 <!-- 左侧导航-->
<?php require_once(PRO_ROOT . 'template/default/front/include/user.php'); ?>
  <!-- 主要内容-->
  <div class="box_left">
    <div class="char_title1">
      <span class="hovertab1">我的收藏夹</span>         
    </div>
    <div id="tbch_01">
      <table width="832" border="0" cellspacing="0" class="dd_li">
        <tr bgcolor="#e8e8e8" class="fn_hs">
          <td width="81" height="34" align="center"><input type="checkbox" onClick="chkChecked(this.checked,'chk')" />全部</td>
          <td width="320" align="center">商品名称</td>
          <td width="140" align="center">放入时间</td>
          <td width="92" align="center">市场价</td>
          <td width="91" align="center">漫淘客价</td>
          <td width="94" align="center">操作</td>
        </tr>
<?php
foreach ($collect->objectList() as $v){
?>  
        <tr>
          <td height="85" align="center"><input type="checkbox" name="chk" /></td>
          <td height="85" align="center" valign="middle"><a href="<?=GoodsFront::GetUrl('goods',array('gid'=>($v->gid)))?>"><img src="img/front/sp.gif" /></a><a href="<?=GoodsFront::GetUrl('goods',array('gid'=>($v->gid)))?>"><?=base::getGoodsName($v->gid)?></a></td>
          <td height="85" align="center"><?=empty($v->collecttime) ? '-' : date('Y-m-d H:i',$v->collecttime)?></td>
          <td height="85" align="center" class="fn_14px fn_red b">￥<? $info = base::getGoodsInfo($v->gid); echo $info->marketprice; ?></td>
          <td height="85" align="center">￥<?=$info->shopprice?></td> 
          <td align="center">
            <table border="0" cellspacing="0" class="biao_nei">
              <tr><td height="40" align="center"><a href="<?=URL?>index.php/front/collect/Del?id=<?=$v->id?>" onclick="return cancel();">删除</a></td></tr>
			  <tr><td height="40" align="center"><a href="<?=URL?>index.php/front/collect/intoCart?gid=<?=$v->gid?>">放入购物车</a></td></tr>
            </table>
          </td> 
        </tr>
<?php
}
?>
      </table>
    
    </div>
    
  </div>
  <!-- 主要内容结束-->
</div>
<script type="text/javascript"> 
function cancel(){
	var con = confirm("你确定要取消么！");
	if(!con){
		return false;
	}
}
function chkChecked(flag,chkName){	
	var chkObj=  document.getElementsByName(chkName);
	for(i=0;i<chkObj.length;i++){
		chkObj[i].checked = flag;
	}
}
</script>

</body>
</html>
