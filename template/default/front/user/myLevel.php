<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="http://static.comicyu.com/js/jquery.js"></script>
<script type="text/javascript" src="http://static.comicyu.com/js/ajax.js"></script>
<title><?=TITLE?> | 我的等级</title>
<link href="<?=MEDIA_URL?>css/mtk_yh.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?=MEDIA_URL?>js/hdm.js"></script>
</head>

<body>
<!-- 头部和导航 -->
<?php 
require_once(PRO_ROOT . 'template/default/front/include/nav2.php'); 
require_once(PRO_ROOT . 'template/default/front/include/user.php'); 
?>
  <!-- 主要内容-->
  <div class="box_left">
    <div class="char_title">
      <span class="hovertab">我的级别</span>         
    </div>
    <div id="tbch_01" class="bk">
      <div class="nei">
        <p>您目前的会员级别：<span class="fn_red b"><?=empty($member->mname) ? '暂无' : $member->mname?></span></p>   
      </div>
      <div class="nei fn_hs">
        注册会员权利及优惠：<br />
1、可以享受注册会员所能购买的产品及服务；<br />
2、快递运费优惠：送至一区、二区订单满400元免快递费（查看运费说明）；<br />
3、可享受返修取件运费优惠（查看返修说明）。 </div>
     <div class="nei">
      <p> 注册成功后即成为注册会员<br />
      消费满一定金额自动升级为高一级别会员，得到不同会员卡和漫淘客商城更多优惠项目，具体如下：</p>     
      <ul class="ka">
        <li><img src="<?=MEDIA_URL?>img/front/goldvip.jpg" /><h2>金卡会员</h2></li>
        <li><img src="<?=MEDIA_URL?>img/front/diamondvip.jpg" /><h2>钻石会员</h2></li>          
      </ul>
     </div>
    </div>
      
  </div>
  <!-- 主要内容结束-->
  


</div>
</body>
</html>
