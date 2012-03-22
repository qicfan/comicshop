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
	
	$("#title").blur(function(){//用户名文本框失去焦点触发验证事件
		
        if(!$(this).val())
        {
            alert("标题不能为空");
					return false;

        }


     });
	 	$("#good").blur(function(){//用户名文本框失去焦点触发验证事件
		
        if(!$(this).val())
        {
            alert("优点不能为空");
					return false;

        }

     });
	 	$("#bad").blur(function(){//用户名文本框失去焦点触发验证事件
		
        if(!$(this).val())
        {
            alert("缺点不能为空");
					return false;

        }

     });
	 	$("#summary").blur(function(){//用户名文本框失去焦点触发验证事件
		
        if(!$(this).val())
        {
            alert("总结不能为空");
					return false;

        }

     });

	
	
	
});

	/** 加入购物车 */
	function cartInert(gid){
		var url = "<?=URL?>index.php/front/cart/cartInsert";
		$.get(url,{gid:gid,loca:1},function(data){
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
<?php require_once(PRO_ROOT . 'template/default/front/include/nav1.php');?>
<!-- 页面主体 -->
<div class="box">
<div id="dh"><?=$str;?> > 商品评论</div>
  <div class="zx_zc">
    <div class="zx_zc_top">商品信息</div>
    <ul>
      <li>
        <div class="img"><a href="<?=$url;?>"><img src="<?=MEDIA_URL?>img/front/tu_03.gif" /></a></div>
        <div class="g_name fn_14px b"><a href="<?=$url;?>"><?=$goodsname;?></a></div>
        <div class="pice"><span >市 场 价</span><span class="s">￥<?=$marketprice;?></span></div>
        <div class="pice"><span >漫淘客价</span><span class="m">￥<?=$shopprice;?></span></div>
        <div class="ord1"><a href="javascript:void(0);" onclick="cartInert(<?=$goodsid;?>);"><img src="<?=MEDIA_URL?>img/front/123.gif"/></a></div>
        <div class="ord"><img src="<?=MEDIA_URL?>img/front/tj.gif" /><a href="<?=URL?>index.php/front/collect/Add?gid=<?=$goodsid?> "><img src="<?=MEDIA_URL?>img/front/sc.gif" /></a></div>
      </li>
    </ul>
  </div>
  <div class="zx_yc">
    <div class="char_title">
	<a href="<?=URL?>index.php/front/usercomment/ucommentShow?gid=<?php echo $goodsid;?>&tab=0" />
	<?php if($ty==0){?><span class="normaltab">商品评论</span><?php }else{ ?><span class="hovertab">商品评论</span><?php }?></a>
	<a href="<?=URL?>index.php/front/usercomment/ucommentShow?gid=<?php echo $goodsid;?>&tab=1" />
	<?php if($ty==1){?><span class="normaltab">好评</span><?php }else{ ?><span class="hovertab">好评</span><?php }?></a>
	<a href="<?=URL?>index.php/front/usercomment/ucommentShow?gid=<?php echo $goodsid;?>&tab=2" />
	<?php if($ty==2){?><span class="normaltab">中评</span><?php }else{ ?><span class="hovertab">中评</span><?php }?></a>
	<a href="<?=URL?>index.php/front/usercomment/ucommentShow?gid=<?php echo $goodsid;?>&tab=3" />
	<?php if($ty==3){?><span class="normaltab">差评</span><?php }else{ ?><span class="hovertab">差评</span><?php }?></a>
	</div>
    <div class="dis" id="tbw5">
      <div class="tj">
        <h3>商品评论 共<span class="fn_blue b"><?php echo $count;?></span>条 </h3>
<?php 
if(count($page->objectList())){
	foreach($page->objectList() as $i=>$v){
?>
<div class="pl">

          <div class="tou">
		  <?php switch($v->ulevel){
		  			case 0:?><img src="<?=MEDIA_URL?>img/front/normalvip.jpg" height="62px" width="62px" /><?php break;
		  			case 1:?><img src="<?=MEDIA_URL?>img/front/goldvip.jpg" height="62px" width="62px"  /><?php break;
		  			case 2:?><img src="<?=MEDIA_URL?>img/front/diamondvip.jpg" height="62px" width="62px" /><?php break;
		  			default:?><img src="<?=MEDIA_URL?>img/front/normalvip.gif" height="62px" width="62px" /><?php break; 
					}?>
					 <h4 class="fn_red b" style="width:100px;"><?php echo $v->uname;?></h4></div>
          <div class="pl_y" style="padding-top:20px;">
            <p class="fn_s_blue b conect"><?=$v->title;?></p>
            <p class="fn_hs sj"><span class="right fn_hs">[发表于<?php 
			
			echo date("Y-m-d H:i:s",$v->createtime);?>]</span><span>个人评分:<?php 
				for($xx=0;$xx<$v->score;$xx++){
				?><img src="<?=MEDIA_URL?>img/front/xx_03.gif" /><?php
				}
			?>
			
		</span><span></span></p>
			<P>优点:<?=$v->good;?></P>
			<p>不足:<?=$v->bad;?></p>
			<p>总结:<?=$v->summary;?></p>
            <div class="hf"><span class="right">有0人认为此评论有用</span><a href="<?=URL?>index.php/front/usercomment/comment_replyAdd?cmid=<?php echo $v->id;?>&gid=<?=$v->goodsid;?>">回复(<?=$commentreplycount1["$i"];?>)</a></div>
			<?php 
			if(count($commentreply1["$i"])){
	foreach($commentreply1["$i"] as $j=>$c){
		if($j < 5){
?>
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
	}else{
	?>
	<div class="hf"><span><a href="<?=URL?>index.php/front/usercomment/comment_replyAdd?cmid=<?php echo $v->id;?>&gid=<?=$v->goodsid;?>">查看全部回复</a></span></div>
	<?php
	break;
	}
	}
	}
?>
          </div></div>

<?php
}}else{
echo '没有评论！';
}

?>

<?php
 /*foreach($commentreplycount1 as $sss=>$aaaa){
 		echo $aaaa;
		echo $sss;
 }*/
?>


      </div>
      <div class="fy"><span class="top" style="float:right;"><a href="#"><img src="<?=MEDIA_URL?>img/front/top.gif" /></a></span><span><?=$page->getHtml("?gid=$goodsid&tab=$ty")?></span> 
      </span>  </div>
      <!--添加问题-->

	  
	  
	  <div class="tj"><a name="formpos" id="formpos" style="display:none"></a>
	  <form action="<?=URL?>index.php/front/usercomment/userComment?act=submit&gid=<?php echo $goodsid;?>" name="form1" method="post">

        <h1 class="b">发表评论：</h1>
        <div class="nei">
          <ul>
            <li>
              <div class="tim b">评分：</div>
              <input type="radio"  name="score" checked="checked" value="5"/>
              5星　
              <input type="radio" name="score"  value="4" />
              4星　
              <input type="radio" name="score" value="3" />
              3星　
              <input type="radio" name="score" value="2" />
              2星　
              <input type="radio" name="score" value="1" />
              1星　<span class="fn_hs">请针对商品质量进行评价</span></li>
            <li>
              <div class="tim b">标题：</div>
              <input type="text" class="kuang" name="title" id="title"  />
            </li>
            <li>
              <div class="tim b">优点：</div>
              <textarea  name="good" id="good"></textarea>
            </li>
            <li>
              <div class="tim b">缺点：</div>
              <textarea  name="bad" id="bad"></textarea>
            </li>
            <li>
              <div class="tim b">总结：</div>
              <textarea  name="summary" id="summary"></textarea>
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
