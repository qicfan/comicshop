<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>所有咨询信息</title>
<link href="<?=MEDIA_URL?>css/mtk.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?=MEDIA_URL?>js/hdm.js"></script>
<script src="http://static.comicyu.com/js/jquery.js" type="text/javascript"></script>
</head>

<body>
 <!-- 头部-->
<?php include PRO_ROOT."template/default/front/include/nav1.php"; ?> 


<?php $cat_arr = Ware::GetDirectcatesByGid($_GET['gid']); ?>
<!-- 页面主体 -->
<div class="box">
  <div id="dh"><a href="<?=URL?>">首页</a> > <a href="<?=URL?>index.php/front/goodsfront/goodsdetail?gid=<?=$_GET['gid']?>"><?=$good->goodsname?></a> > 所有咨询</div>
  <div class="zx_zc">
    <div class="zx_zc_top"></div>
    <ul>
      <li>
        <div class="img"><a href="<?=GoodsFront::GetUrl('goods',array('gid'=>($_GET['gid'])))?>"><img src="<?=MEDIA_URL?>img/front/tu_03.gif" /></a></div>
           <div class="g_name fn_14px b"><a href="<?=GoodsFront::GetUrl('goods',array('gid'=>($_GET['gid'])))?>"><?=$good->goodsname?></a></div>
           <div class="pice"><span >市 场 价</span><span class="s">￥<?=$good->marketprice?></span></div>
           <div class="pice"><span >漫淘客价</span><span class="m">￥<?=$good->shopprice?></span></div>
           <div class="ord1"><a href="#none" onclick="cartInert(<?=$_GET['gid']?>)"><img src="<?=MEDIA_URL?>img/front/123.gif" /></a></div> 
           <div class="ord">
		   <img src="<?=MEDIA_URL?>img/front/tj.gif" />
		   <a href="#none" onclick="collect(<?=$_GET['gid']?>)"><img src="<?=MEDIA_URL?>img/front/sc.gif" /></a>
		   </div>     
      </li>
    </ul>
  </div>
  
  <div class="zx_yc">
  <?php 
	for($i=0;$i<8;$i++){
		$class ='tab'.$i;
		if($type==$i){
			$$class='hovertab';
		}
		else{
			$$class='normaltab';
		}
   }
	?>
     <div class="char_title">
      <a href="<?=URL?>index.php/front/question/questionList?gid=<?=$_GET['gid']?>"><span id="tbx_1" class="<?=$tab0?>" >全部购买咨询</span></a>
      <a href="<?=URL?>index.php/front/question/questionList?gid=<?=$_GET['gid']?>&tab=1"><span id="tbx_2" class="<?=$tab1?>" >商品咨询</span></a>
      <a href="<?=URL?>index.php/front/question/questionList?gid=<?=$_GET['gid']?>&tab=2"><span id="tbx_3" class="<?=$tab2?>" >库存配送</span></a>
      <a href="<?=URL?>index.php/front/question/questionList?gid=<?=$_GET['gid']?>&tab=3"><span id="tbx_4" class="<?=$tab3?>" >支付</span></a>
      <a href="<?=URL?>index.php/front/question/questionList?gid=<?=$_GET['gid']?>&tab=4"> <span id="tbx_5" class="<?=$tab4?>" >发票保修</span></a>
      <a href="<?=URL?>index.php/front/question/questionList?gid=<?=$_GET['gid']?>&tab=5"><span id="tbx_6" class="<?=$tab5?>" >支付帮助</span></a>
      <a href="<?=URL?>index.php/front/question/questionList?gid=<?=$_GET['gid']?>&tab=6"><span id="tbx_7" class="<?=$tab6?>" >配送帮助</span></a>
      <a href="<?=URL?>index.php/front/question/questionList?gid=<?=$_GET['gid']?>&tab=7"><span id="tbx_8" class="<?=$tab7?>" >常见问题</span></a>
    </div>
    <div class="dis" id="tbcx_01">
<?php if(in_array($type,array('5','6','7'))){ ?>
<?php
	} else {
foreach ($page->objectList() as $v){
?>     
      <table width="98%" border="0" align="center" cellpadding="5" cellspacing="0" class="ly" id="<?=$v->id?>">
        <tr class="tr">
          <td width="6%" valign="top"><span class="b">提问：</span></td>
          <td width="60%" align="left"><?=$v->content?> </td>
          <td width="14%" align="center" valign="top"><span class="fn_red b"><?=base::getUserName($v->uid)?></span></td>
          <td width="20%" valign="top"><span class="fn_hs">发表于 <?=date('Y-m-d H:i',$v->questiontime)?></span></td>
        </tr>

        <tr class="tr">
          <td valign="top"><span class="fn_red b">回复：</span></td>
          <td colspan="2" align="left"><span class="fn_red"><?=$v->reply?></span></td>
          <td valign="top"><span class="fn_hs">发表于 <?=empty($v->replytime) ? '-' : date('Y-m-d H:i',$v->replytime)?></span></td>
        </tr>

        <tr>
          <td colspan="4">您对我们的回复： 
		  <a name="1" class="fn_blue" href="#none">满意</a>(<span><?=other::getQuestiomComment($v->id,'1')?></span>)  
		  <a name="0" class="fn_blue" href="#none">不满意</a>(<span><?=other::getQuestiomComment($v->id,'0')?></span>) 
		  </td>
        </tr>
      </table>
<?php
}
?>
      <div class="fy">
         <span class="next_up"><?=$page->getHtml("?type=$type&gid=$gid")?></span>
         <span class="top"><a href="#top"><img src="<?=MEDIA_URL?>img/front/top.gif" /></a></span>
       </div>
<?php } ?>
      <!--添加问题-->
      <div class="tj">
        <h1 class="b">发表咨询：</h1>
        <div class="nei">
<form action="<?=URL?>index.php/front/question/questionAdd?gid=<?=$_GET['gid']?>" name="form1" method="post" onsubmit="return verify();">
          <ul>
		    <li><div class="tim b">咨询类型：</div>
			<input type="radio" name="type" value="1"  />商品咨询
          <input type="radio" name="type" value="2" />库存配送
         <input type="radio" name="type" value="3" />支付
          <input type="radio" name="type" value="4" />发票保修
		  </li>
            <li><div class="tim b">咨询内容：</div><textarea name="content"></textarea></li>
            <li>
              <div class="tim">　　　　</div><input type="submit"  value="确认" />　　<input name="重置" type="reset" value="取消" /></li>
          </ul>

          <p class="fn_hs"><span class="b">声明：</span><br />
您可在购买前对产品包装、颜色、运输、库存等方面进行咨询，我们有专人进行回复！因厂家随时会更改一些产品的<br />
包装、颜色、产地等参数，所以该回复仅在当时对提问者有效，其他网友仅供参考！
</p>
        </div>
      </div>
      
    </div>
    <div class="undis" id="tbcx_02">2</div>
    <div class="undis" id="tbcx_03">3</div>
    <div class="undis" id="tbcx_04">4</div> 
    <div class="undis" id="tbcx_05">5</div>
    <div class="undis" id="tbcx_06">6</div>
    <div class="undis" id="tbcx_07">7</div>
    <div class="undis" id="tbcx_08">8</div>
  </div>
</div>

<script>
	$(".fn_blue").click(function(){
		var current = $(this);
			$.get("<?php echo URL; ?>index.php/front/question/comment",{
				qid : $(current).parent().parent().parent().parent().attr("id") ,
				val : parseInt($(current).attr("name"))
				
			},function (data, textstatus){
			 if(data==1){
				  $(current).text("已投票");
				  $(current).next("span").text(parseInt($(current).next("span").text()) + 1);
			 }else if(data=='login'){
				 alert("请先登录");
			 }else{
				  $(current).text("已投票");
			 }
			});
		});
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
function collect(gid){
		var url = "<?=URL?>index.php/front/collect/Add";
		$.get(url,{gid:gid,ajax:1},function(data){
			if(data=='ok'){
				alert("添加成功！");
			}else if(data=="exist"){
				alert("您已收藏该商品！");
			}else if(data=='login'){
				alert("请先登录！");
			}
		});
	}
function verify(){
	var content = document.getElementById('content').value;
	var type = document.getElementById('type').value;
	if (content== '' ||type== '') {
		alert('请认真填写咨询描述');
		return false;
	}
	return true;
}
</script>

</body>
</html>
