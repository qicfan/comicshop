<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <title> 漫淘客商城后台 </title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <!--script type="text/javascript" src="http://static.comicyu.com/js/jquery.js"></script>
  <script type="text/javascript" src="http://static.comicyu.com/js/ajax.js"></script-->
  <script type="text/javascript" src="<?=URL?>media/js/jquery.js"></script>
  <script type="text/javascript" src="<?=URL?>media/js/ajax.js"></script>
  <script>
  function makeAll(){
      if (confirm('确定要更新所有静态网页？\n（请不要随便点这个按钮）')) {
	      return true;
	  } else {
	      return false;
	  }
  }
  </script>
  <style type="text/css">
  body { padding: 0px; margin: 0px; font-size: 14px; background: #FBFDFF url(<?=MEDIA_URL?>img/admin/body_bg.gif) repeat-y; }
  h1 { font-size: 16px; line-height: 24px; margin-bottom: 10px; }
  table { width: 100%; }
  td { vertical-align: top; }
  ul { margin: 0px; padding: 0px; list-style: none;  }

  #topper { height: 68px;; background: url(<?=MEDIA_URL?>img/admin/header_bg.gif) repeat-x; border-bottom: 4px solid #1F62B0; }
  #logo { width: 153px; }
  #top-menu { line-height: 36px; text-align: right; padding-right: 1em; }
  #top-menu a { margin-right:12px; }
  #top-menu #reload { background:url(<?=MEDIA_URL?>img/admin/icon_reload.gif) no-repeat 0 center; padding-left:13px; }
  #top-menu #logout { background:url(<?=MEDIA_URL?>img/admin/icon_logout.gif) no-repeat 0 center; padding-left:13px; }
  #top-menu #clearcache { background:url(<?=MEDIA_URL?>img/admin/icon_clear.gif) no-repeat 0 center; padding-left:13px; }

  #top-tabbar { position: relative; overflow:hidden; }
  #top-tab { height: 32px; overflow:hidden; position:relative;text-align:center;}
  #top-tab ul { position: relative; overflow:hidden;}
  #top-tab li { color: #999; font-weight: bold; font-size: 12px; float: left; margin-right: 2px; width: 124px; height: 32px; line-height: 32px; background: url(<?=MEDIA_URL?>img/admin/toptab_space.gif) no-repeat left; cursor: pointer; }
  #top-tab li.actived { background: url(<?=MEDIA_URL?>img/admin/toptab_active_bg.jpg) no-repeat; color: #FFF; }
  #top-tab img { vertical-align: middle; margin: 11px 15px 2px 2px; float: right; }

  #dropdown-botton { width: 25px }
  #drop-menu { position: absolute; right: 0px; top: 53px; background: #FFF; padding: 2px; margin: 0px 5px; list-style: none; border: 1px solid #A6C1DB; display:none; }
  #drop-menu li { padding: 3px 40px 3px 20px; cursor: pointer; }
  #drop-menu li.hover { background: #185096; color: #FFF; }

  #slide-menu { width: 154px; vertical-align: top; }
  #slide-menu a:visited, #slide-menu a:link { text-decoration: none; color: #006699; }
  #slide-menu a:hover, #slide-menu a:active { text-decoration: none; color: #FF6600; }
  #menu-topper { width: 153px; text-align: center; font-weight: bold; color: #7B3E00; cursor: pointer; height: 36px; line-height: 36px; background: url(<?=MEDIA_URL?>img/admin/nav_back_bg.jpg); margin-bottom: 22px; }
  #menu-topper td { border-bottom: 1px solid #A7C1DB;  }
  #menu-topper td.actived { color: #1A5499; background: url(<?=MEDIA_URL?>img/admin/nav_active_bg.jpg); border-bottom: 1px solid #FFF; }
  #menu-shortcut { width: 153px; display: none; }
  #menu-shortcut li { margin: 0px; padding: 0px 0px 0px 15px; background: url(<?=MEDIA_URL?>img/admin/nav_list_arrow.gif) no-repeat 120px center; border-bottom: 1px dotted #DBE9F6; line-height: 24px; height: 24px; }
  #nav-normal { border-right: 1px solid #A7C1DB; }
  .nav-item { line-height: 18px; }

  .menu-group { width: 153px; margin: 0px; padding: 0px; background: url(<?=MEDIA_URL?>img/admin/nav_list_arrow.gif) no-repeat 120px center; border-bottom: 1px dotted #DBE9F6;}
  .menu-group dt { padding-left: 15px; line-height: 24px; height: 24px; cursor: pointer; }
  .menu-group dd { display: none; }
  .menu-group-actived { margin: 0px; border: none; background: #FEFBFF; background: url(<?=MEDIA_URL?>img/admin/nav_list_bg.gif) repeat-y 5px; }
  .menu-group-actived dt { padding-left: 15px; font-weight: bold; background: url(<?=MEDIA_URL?>img/admin/nav_list_top.gif) no-repeat 5px top; padding-top: 12px; }
  .menu-group-actived dd { margin: 0px; background: url(<?=MEDIA_URL?>img/admin/nav_list_bottom.gif) no-repeat 5px bottom; padding: 5px 2px 10px 25px; display: block; }
  </style>
  <script type="text/javascript">
	$(document).ready(function(){
		$('#menu-normal').click(function(e){
			var div = $(this);
			var dls = div.find('dl');
			var elem = e.target
			if (elem.tagName == 'DT'){
				var dt = $(elem.parentNode);
				if (!dt.hasClass("menu-group-actived")){
					dls.removeClass("menu-group-actived");
					dls.addClass("menu-group");
					dt.removeClass("menu-group");
					dt.addClass("menu-group-actived");
				}
			}
		})
	})
  </script>
 </head>

 <body>
  <table cellspacing="0" cellpadding="0" id="topper">
    <tr>
      <td rowspan="2" id="logo"><img src="<?=MEDIA_URL?>img/admin/ecm_logo.gif" /></td>
      <td id="top-menu" colspan="2">
        <a href="<?=URL?>index.php/admin/admin/main" target="main">首页</a>
        <a href="<?=URL?>index.php/admin/admin/logout?>" id="logout">退出登录</a>
      </td>
    </tr>
    <tr>
      <td>
        <div id="top-tabbar">
          <ul id="top-tab">
			<li>漫淘客商城</li>
		  </ul>
        </div>
      </td>
      <td id="dropdown-botton"><img id="img-dropmenu" src="<?=MEDIA_URL?>img/admin/tab_dropdown.gif" /></td>
    </tr>
  </table>
  <ul id="drop-menu"></ul>
  <table cellspacing="0" cellpadding="0" id="container">
    <tr>
      <td id="slide-menu">
        <table cellpadding="0" cellspacing="0" id="menu-topper">
          <tr>
            <td class="actived" id="nav-normal"><a href="<?=URL?>index.php/admin/admin/main" target="main">菜单</a></td>
            <td id="nav-shortcut"><a href="http://www.comicyu.com" target="_blank">漫域网</a></td>
          </tr>
        </table>
        <div id="menu-normal">
        <dl class="menu-group-actived">
          <dt>商品管理</dt>
          <dd class="nav-item">
		  	<div><a href="<?=URL?>index.php/admin/goods/goodsnewlist" target="main">新入库商品列表</a></div>
		 	<!--div><a href="<?=URL?>index.php/admin/goods/goodsadd" target="main">商品添加</a></div-->
			<div><a href="<?=URL?>index.php/admin/goods/goodslist" target="main">商品列表</a></div>
			<!--div><a href="<?=URL?>index.php/admin/goods/goodsedit" target="main">商品修改</a></div-->
          	<div><a href="<?=URL?>index.php/admin/category/categorylists" target="main">商品分类</a></div>
			<div><a href="<?=URL?>index.php/admin/attribute/attributelists" target="main">商品属性</a></div>
			<div><a href="<?=URL?>index.php/admin/goods/leadgoods" target="main">批量导入商品</a></div>
			<div><a href="<?=URL?>index.php/admin/goods/leadcategory" target="main">批量导入分类</a></div>
			<div><a href="<?=URL?>index.php/admin/goods/makestatic" target="main">生成商品静态页面</a></div>
          </dd>
        </dl>
        
        <dl class="menu-group">
          <dt>订单管理</dt>
          <dd class="nav-item">
			<div><a href="<?=URL?>index.php/admin/order/orlist" target="main">订单列表</a></div>
			<div><a href="<?=URL?>index.php/admin/order/orderAdd" target="main">订单添加</a></div>
			<div><a href="<?=URL?>index.php/admin/order/orsearch" target="main">订单搜索</a></div>
			<div><a href="<?=URL?>index.php/admin/order/futility" target="main">无效订单</a></div>
			<div><a href="<?=URL?>index.php/admin/order/nopayment" target="main">未付款订单</a></div>
			<div><a href="<?=URL?>index.php/admin/order/paymented" target="main">已付款订单</a></div>
			<div><a href="<?=URL?>index.php/admin/order/noconsign" target="main">未发货订单</a></div>
			<div><a href="<?=URL?>index.php/admin/order/wait" target="main">配货中订单</a></div>
			<div><a href="<?=URL?>index.php/admin/order/consigned" target="main">已发货订单</a></div>
			<div><a href="<?=URL?>index.php/admin/order/OOS" target="main">缺货记录</a></div>
          </dd>
        </dl>
        
		<dl class="menu-group">
          <dt>促销活动</dt>
          <dd class="nav-item">
			<div><a href="<?=URL?>index.php/admin/promotion/proList" target="main">促销活动列表</a></div>
			<div><a href="<?=URL?>index.php/admin/promotion/proAddPage" target="main">促销活动添加</a></div>
			<!--<div><a href="<?=URL?>index.php/admin/promotion/proGoodsList" target="main">促销商品列表</a></div>
			<div><a href="<?=URL?>index.php/admin/promotion/proGoodsAddPage" target="main">促销商品添加</a></div>-->
          </dd>
        </dl>
        
        <dl class="menu-group">
          <dt>库存管理</dt>
          <dd class="nav-item">
              <div><a href="<?=URL?>index.php/admin/stock/goodsIn" target="main">商品入库</a></div>
              <div><a href="<?=URL?>index.php/admin/stock/stockList" target="main">库存管理</a></div>
              <div><a href="<?=URL?>index.php/admin/stock/salebillEdit" target="main">添加出库单</a></div>
              <div><a href="<?=URL?>index.php/admin/stock/salebillList" target="main">出库单管理</a></div>
              <div>退货管理</div>
              <div><a href="<?=URL?>index.php/admin/stock/stockWarn" target="main">库存预警</a></div>
              <div><a href="<?=URL?>index.php/admin/stock/logistics" target="main">物流商管理</a></div>
          </dd>
        </dl>
        
        <dl class="menu-group">
          <dt>供货商管理</dt>
          <dd class="nav-item">
              <div><a href="<?=URL?>index.php/admin/supply/supplyList" target="main">供货商列表</a></div>
              <div><a href="<?=URL?>index.php/admin/supply/producer" target="main">生产商管理</a></div>
              <div>订货单管理</div>
              <div>退货单管理</div>
          </dd>
        </dl>
        
        <dl class="menu-group">
          <dt>文章管理</dt>
          <dd class="nav-item">
            <div><a href="<?=URL?>index.php/admin/article/articleList" target="main">文章列表</a></div>
            <div><a href="<?=URL?>index.php/admin/article/articleEdit?id=0" target="main">发布文章</a></div>
            <div><a href="<?=URL?>index.php/admin/article/articleSort" target="main">分类管理</a></div>
            <div><a href="<?=URL?>index.php/admin/article/makeAll" onclick="return makeAll();" target="main">更新所有静态网页</a></div>
          </dd>
        </dl>
        
        <dl class="menu-group">
          <dt>客服中心</dt>
          <dd class="nav-item">
            <div><a href="<?=URL?>index.php/admin/comment/commentList" target="main">用户评论管理</a></div>
            <div><a href="<?=URL?>index.php/admin/quiz/quizList" target="main">用户提问列表</a></div>
            <div><a href="<?=URL?>index.php/admin/inform/informList" target="main">价格举报列表</a></div>
          </dd>
        </dl>
        
        <dl class="menu-group" style="height:0px;"></dl>
        
        <dl class="menu-group">
          <dt>会员管理</dt>
          <dd class="nav-item">
            <div><a href="<?=URL?>index.php/admin/user/userList" target="main">会员列表</a></div>
            <div><a href="<?=URL?>index.php/admin/user/memberList" target="main">会员等级管理</a></div>
          </dd>
        </dl>
        
        <dl class="menu-group">
          <dt>收藏管理</dt>
          <dd class="nav-item">
          	<div><a href="<?=URL?>index.php/admin/collect/collectList" target="main">收藏列表</a></div>
          </dd>
        </dl>

        <dl class="menu-group">
          <dt>品牌管理</dt>
          <dd class="nav-item">
          	<div><a href="<?=URL?>index.php/admin/tag/tagList" target="main">品牌列表</a></div>
          <div><a href="<?=URL?>index.php/admin/tag/tagEdit" target="main">品牌发布</a></div>
          </dd>
        </dl>
 
         <dl class="menu-group">
          <dt>作品管理</dt>
          <dd class="nav-item">
          	<div><a href="<?=URL?>index.php/admin/works/worksList" target="main">作品列表</a></div>
			<div><a href="<?=URL?>index.php/admin/works/worksEdit" target="main">作品发布</a></div>
          <!--	<div><a href="<?=URL?>index.php/admin/tag/tagEdit" target="main">发布Tag</a></div>-->
          </dd>
        </dl>

        <dl class="menu-group">
          <dt>优惠券管理</dt>
          <dd class="nav-item">
            <div><a href="<?=URL?>index.php/admin/coupon/couponList?type=1" target="main">优惠券列表</a></div>
            <div><a href="<?=URL?>index.php/admin/coupon/couponEdit" target="main">批量生成优惠券</a></div>
          </dd>
        </dl>
        
        <dl class="menu-group">
          <dt>系统管理</dt>
          <dd class="nav-item">
          	<div><a href="<?=URL?>index.php/admin/system/sysConfig" target="main">网站基本设置</a></div>
            <div><a href="<?=URL?>index.php/admin/system/verifyEdit" target="main">审核设置</a></div>
            <div><a href="<?=URL?>index.php/admin/system/regionList" target="main">地区管理</a></div>
          	<div><a href="<?=URL?>index.php/admin/system/linkList" target="main">友情链接管理</a></div>
            <div><a href="<?=URL?>index.php/admin/system/codeEdit" target="main">验证码管理</a></div>
            <div><a href="<?=URL?>index.php/admin/system/wordList" target="main">屏蔽关键字</a></div>
            <div><a href="<?=URL?>index.php/admin/system/siteClose" target="main">关闭网站</a></div>
            <div><a href="<?=URL?>index.php/admin/system/rewrite" target="main">开启静态/伪静态</a></div>
          </dd>
        </dl>
        
        <dl class="menu-group">
          <dt>统计中心</dt>
          <dd class="nav-item">
            <div><a href="<?=URL?>index.php/admin/tongji/money" target="main">销售额明细</a></div>
            <div><a href="<?=URL?>index.php/admin/tongji/goods" target="main">商品销售明细</a></div>
            <div><a href="<?=URL?>index.php/admin/tongji/click" target="main">商品人气统计</a></div>
            <div><a href="<?=URL?>index.php/admin/tongji/pay" target="main">在线支付明细</a></div>
            <div><a href="<?=URL?>index.php/admin/tongji/user" target="main">会员情况统计</a></div>
          </dd>
        </dl>
        
        <dl class="menu-group">
          <dt>管理员管理</dt>
          <dd class="nav-item">
            <div><a href="<?=URL?>index.php/admin/admin/adminList" target="main">管理员列表</a></div>
            <div><a href="<?=URL?>index.php/admin/admin/adminEdit" target="main">新增管理员</a></div>
            <div><a href="<?=URL?>index.php/admin/admin/adminLog" target="main">管理员日志</a></div>
          </dd>
        </dl>
        </div>
        
        <div id="menu-shortcut">
          <ul>
            <li><a href="javascript:;">快捷方式</a></li>
          </ul>
        </div>
      </td>
      <td>
	  <iframe name="main" width="100%" height="2000" frameborder="0" src="<?=URL?>index.php/admin/admin/main"></iframe>
	  <!--hack for ie8--><div id="wrapper"></div></td>
    </tr>
  </table>
 </body>
</html>
