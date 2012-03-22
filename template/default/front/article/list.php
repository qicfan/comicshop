<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="http://static.comicyu.com/js/jquery.js"></script>
<script type="text/javascript" src="http://static.comicyu.com/js/ajax.js"></script>
<title><?=TITLE?> | 文章列表</title>
<link href="<?=MEDIA_URL?>css/mtk.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?=MEDIA_URL?>js/hdm.js"></script>
<script>
$(document).ready(function(){
	//选择分类
	$("#sort").change( function(){
		window.location.href = '<?=URL?>index.php/front/article/articleList?sort='+$("#sort").val();
	});
});
</script>
</head>

<body>
<!-- 头部 -->
<?php 
require_once(PRO_ROOT . 'template/default/front/include/nav2.php');
?>
<!-- 页面主体 -->
<div class="box">
  <div class="zx_zc">
    <div class="zx_zc_top">全部文章分类</div>
    <ul class="list3 fn_red fn_14px">
      <?=$tree2?>
    </ul>    
  </div>
  
  
  
  
  <div class="zx_yc">
    <div class="char_title">
      <span id="tbz_1" class="hovertab">文章列表</span>
      <span style="float:left; margin:0px; margin-left:10px;">
          <select name="sort" id="sort">
          <option>选择分类...</option>
          <?=$tree1?>
          </select>
      </span>
    </div>
    <div class="dis" id="tbcz_01">
      <div class="tj">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr bgcolor="#e8e8e8">
            <td width="16%" height="34" align="center">标题</td>
            <td width="67%" align="center"></td>
            <td width="17%" align="center">时间</td>
          </tr>
        </table>
        <ul class="list3">
        <?php
		foreach ($page->objectList() as $v) {
		?>
          <li><span class="rq fn_hs" style="width:150px;"><?=date('Y-m-d H:i:s', $v->createtime)?></span>
          <a href="<?=URL?>html/article/<?=$v->id?>.html"><?=$v->title?></a></li>
        <?php
		}
        ?>
        </ul>
      
        <div class="fy">
        <?php
		if ( !empty($page->dataCount) ) {
        	echo $page->getHtml('?0');
		} else {
			echo '暂无';
		}
		?>
        </div>
        
      </div>
      
      <!--添加问题-->
      
    </div>
    
    <div class="undis" id="tbcz_02">2</div>
    <div class="undis" id="tbcz_03">3</div>
    <div class="undis" id="tbcz_04">4</div> 
    <div class="undis" id="tbcz_05">5</div>
  </div>
</div>
</body>
</html>
