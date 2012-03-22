<?php
header("Status: 404 Not Found");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$webTitle;?></title>
<link href="<?=MEDIA_URL?>css/mtk.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?=MEDIA_URL?>js/hdm.js"></script>
<script src="http://static.comicyu.com/js/jquery.js" type="text/javascript"></script>
<script>
$(function(){
	
		

	 	$("#reply").blur(function(){
		
        if(!$(this).val())
        {
            alert("内容不能为空");
					return false;

        }

     });
	
	
	
});
	/** 加入购物车 */
	function cartInert(gid){
		var url = "<?=URL?>index.php/front/cart/cartInsert";
		$.get(url,{gid:gid,loca:1},function(data){
		//alert(data);
			if(data=='ok'){
				alert("添加成功！");
			}else if(data=="cunzai"){
				alert("此商品在购物车中已经存在");
			}
		});
	}
	//




</script>

<style type="text/css">
.hovertab a{
color:#FFFFFF;}
</style>
</head>

<body>
<!-- 网页头部 -->
<?php require_once(PRO_ROOT . 'template/default/front/include/nav1.php');?>
<!--头部结束-->
<!-- 页面主体 -->
<div class="box">
  <div id="dh"><?=$str;?> > 评论回复</div>
  <div class="zx_zc">
    <div class="zx_zc_top">商品信息</div>
    <ul>
      <li>
        <div class="img"><a href="<?=$url;?>"><img src="<?=MEDIA_URL?>img/front/tu_03.gif" /></a></div>
        <div class="g_name fn_14px b"><a href="#"><?=$goodsInfo[0]->goodsname;?></a></div>
        <div class="pice"><span >市 场 价</span><span class="s">￥<?=$goodsInfo[0]->marketprice;?></span></div>
        <div class="pice"><span >漫淘客价</span><span class="m">￥<?=$goodsInfo[0]->shopprice;?></span></div>
        <div class="ord1"><a href="javascript:void(0);" onclick="cartInert(<?=$goodsInfo[0]->id?>);"><img src="<?=MEDIA_URL?>img/front/123.gif" /></a></div>
        <div class="ord"><img src="<?=MEDIA_URL?>img/front/tj.gif" /><a href="<?=URL?>index.php/front/collect/Add?gid=<?=$gid?>"><img src="<?=MEDIA_URL?>img/front/sc.gif" /></a></div>
      </li>
    </ul>
  </div>
  

  <div class="zx_yc">
      <div class="char_title">
	 <span class="hovertab">评论回复</span>
</div>
    <div class="dis" id="tbw5">
      <div class="tj">
<div class="pl">

          <div class="tou"><?php switch($comreply['ulevel']){
		  case 0:?><img src="<?=MEDIA_URL?>img/front/normalvip.jpg" height="62px" width="62px" /><?php break;
		  case 1:?><img src="<?=MEDIA_URL?>img/front/goldvip.jpg" height="62px" width="62px"  /><?php break;
		  case 2:?><img src="<?=MEDIA_URL?>img/front/diamondvip.jpg" height="62px" width="62px" /><?php break;
		  default:?><img src="<?=MEDIA_URL?>img/front/normalvip.gif" height="62px" width="62px" /><?php break; }?> <h4 class="fn_red b" style="width:100px;"><?php
echo $comreply['uname'];?></h4></div>
          <div class="pl_y" style="padding-top:20px;">
            <p class="fn_s_blue b conect"><?=$comreply['title'];?></p>
            <p class="fn_hs sj"><span class="right fn_hs">[发表于<?php 
			
			echo date("Y-m-d H:i:s",$comreply['createtime']);?>]</span><span>个人评分:<?php 
				for($xx=0;$xx<$comreply['score'];$xx++){
				?><img src="<?=MEDIA_URL?>img/front/xx_03.gif" /><?php
				}
			?>
			
		</span><span></span></p>
			<P>优点:<?=$comreply['good'];?></P>
			<p>不足:<?=$comreply['bad'];?></p>
			<p>总结:<?=$comreply['summary'];?></p>
            <div class="hf"><span class="right">有0人认为此评论有用</span>回复(<?=$comreply['page']->dataCount;?>)</div>
			<?php 
foreach($comreply['page']->objectList() as $j=>$c){?>
	<div class="hfp">
	          <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-top:1px dashed #d3d9e3;">
                <tr>
                  <td width="8%" rowspan="2" align="center" valign="top"><span style="font-size:24px"><?=$j+1;?></span><span>楼:</span></td>
                  <td width="68%"><a href="javascript:void(0);"><?=$c->uname;?></a> 回复说:</td>
                  <td width="24%">&nbsp;</td>
                </tr>
                <tr>
                  <td><?=$c->reply;?></td>
                  <td align="left" valign="top" class="fn_hs">[回复于<?php echo date("Y-m-d H:i",$c->replytime);?>] </td>
                </tr>
              </table>

	
	
</div>

<?php
	}
	
?>
          </div></div>




      </div>
      
      <!--添加回复-->

	  
	  
	  <div class="tj">
	  <form action="<?=URL?>index.php/front/usercomment/comment_replyAdd?cmid=<?=$cid;?>&gid=<?php echo $gid;?>" name="form1" method="post" onsubmit="ck();">

        <h1 class="b">发表回复：</h1>
        <div class="nei">
          <ul>
            <li>
              <div class="tim b">回复内容：</div>
              <textarea  name="reply" id="reply"></textarea>
            </li>
            <li>
              <div class="tim">　　　　</div>
              <input type="submit"  value="确认" />
              <input name="重置" type="reset" value="取消" />
            </li>
          </ul>
          <p class="fn_hs"><span class="b">声明：</span><br />
            您可在购买前对产品包装、颜色、运输、库存等方面进行咨询，我们有专人进行回复！因厂家随时会更改一些产品的<br />
            包装、颜色、产地等参数，所以该回复仅在当时对提问者有效，其他网友仅供参考！ </p>
        </div>
		</form>
      </div>
    </div>
  </div>
</div>
</body>
</html>
