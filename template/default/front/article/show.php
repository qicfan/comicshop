<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="http://static.comicyu.com/js/jquery.js"></script>
<script type="text/javascript" src="http://static.comicyu.com/js/ajax.js"></script>
<title>漫淘客商城</title>
<link href="<?=MEDIA_URL?>css/mtk.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?=MEDIA_URL?>js/hdm.js"></script>
</head>

<body>
<!-- 头部 -->
<?php 
require_once(PRO_ROOT . 'template/default/front/include/top.php'); 
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
    <div class="wz_zd">
      <div class="wz_bt">
        <h1 class="fn_24px b"> <?=$article->title?></h1>
        <h2 class="fn_hs"><?=$sort?> | <?=date('Y-m-d H:i:s',$article->createtime)?></h2>
        <div style="width:700px; border:#CCCCCC 1px solid; text-align:left; padding:10px;"><?=$content?></div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
