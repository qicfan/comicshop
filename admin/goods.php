<?php
/*
 * author wsh
 * date 20100513
 * 商品
*/

if (!defined("PRO_ROOT")) {
	exit();
}

require_once PRO_ROOT.'include/goods.class.php';
require_once DZG_ROOT.'core/pagination/pagination.php';


class goodsViews{
	
	/*
	 * 商品的添加
	*/

	public static function goodsadd(){
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(6);
		require_once PRO_ROOT.'include/supply.class.php';
		require_once PRO_ROOT.'include/other.class.php';
		require_once PRO_ROOT.'include/categorys.class.php';
		require_once PRO_ROOT.'include/base.class.php';
		require_once PRO_ROOT.'include/brand.class.php';
		require_once PRO_ROOT.'include/attributes.class.php';
		require_once PRO_ROOT.'include/proFun.class.php';
		require_once DZG_ROOT.'core/image/gd.php';
		
		$gid = $_GET['gid'];
		if(!count($_POST)){
			$categorys = new Categorys();
			$categorys->categorys = $categorys->getcategorys(0,'--');
			
			$goods = Ware::GetOne($gid);
			$goodsmemberprice = Ware::GetMembersPrice($gid);
			$cates = Categorys::GetAll();
			$cate = Categorys::GetByPid(0);
			$producer = supply::getProducer();
			$brands = Ware::getBrand();
			$members = other::getMember();
			$suppliers = supply::getSupply();
			$promotion = proFun::GetAll();
			$lables = Ware::getGoodsBrand($gid);
			
			$lablearr = array();
			for($i=0;$i<count($lables);$i++){
				$lablearr[] = $lables[$i]->bid;
			}
			
			//获取所有品牌和所有作品
			$tags = Brands::GetBrandAll();
			$works = Brands::GetWorksAll();
			
			$displays = array(
				'memberprice'=>$goodsmemberprice,
				'goods'=>$goods,
				'brand'=>$brands,
				'cateall'=>$categorys->categorys,
				'cates'=>$cates,
				'cate'=>$cate,
				'producer'=>$producer,
				'member'=>$members,
				'supply'=>$suppliers,
				'pros'=>$promotion,
				'lables'=>$lablearr,
				'tags'=>$tags,
				'works'=>$works,
			);
			
			template('goodsadd',$displays,'default/admin/goods');
		}
		/** 基本信息**/
		$gid = $_POST['gid'];
		$bid = $_POST['brands'];
		
		$goodsname = $_POST['goodsname'];
		$goodsintegral = $_POST['points'];
		//品牌id
		$tid = $_POST['tags'];
		//作品id
		$wid = $_POST['works'];
		//$goods_sn = $_POST['goods_sn'];
		//分类的每级分类id的数组
		$category1 = $_POST['category'];
		
		//扩展分类的每个下拉框的每级分类的id
		$cateextend = $_POST['cateextend'];
		$category = array();
		if($cateextend>1){
			for($i=2;$i<=$cateextend;$i++){
				$category[] = $_POST['category'.$i];
			}
		}
		$unit = $_POST['unit'];
		$producerid = $_POST['producer'];
		$supplyid = $_POST['suppliers'];
		//$stock = $_POST['leavingcounthid'];
		//$inprice = $_POST['buypricehid'];
		//$marketprice = $_POST['marketpricehid'];
		//$shopprice = $_POST['shoppricehid'];
		//$members = $_POST['member'];
		$points = $_POST['points'];
		
		/** 描述信息 **/
		$keywords = $_POST['keywords'];
		$des = $_POST['des'];
		$description = $_POST['description'];
		$weight = $_POST['weight'];
		$weightunit = $_POST['weightunit'];
		
		/** 促销方案 **/
		$profunction = $_POST['profuns'];

		/**  推荐选项  **/
		$ishot = $_POST['ishot'];
		$isnew = $_POST['isnew'];
		$ispromotion = $_POST['ispromotion'];	
		
		/** 属性 （添加）**/
		$attrkeys = array();
		$attrvalues = array();
		$attrs = $_POST['attri'];
		$relategoods = $_POST['relategoods'];
		$cateid = $_POST['cid'];
		$attrsArr = Attributes::GetKeyByCid($cateid);
			
		/** 添加商品之前先查一下是否有重名的 **/
		$checkflag = Ware::CheckGoodsName($gid,$goodsname);
		if($checkflag){
			core::alert("商品名称已经存在！请重新填写！");
		}
		
		
		/** 图片(上传) **/
		$picpath = '';
		$upload = new Uploadfile();
		$upload->CreatePath('goods','',2);
		
		$imgdes = $_POST['imgs'];
		$fileType = array('image/gif','image/pjpeg','image/jpg','image/bmp','image/png','image/jpeg');
		for($i=0;$i<count($_FILES['picfile']['name']);$i++){
			if($_FILES['picfile']['name'][$i]!=""){
				$upload->upload_file(PRO_ROOT.$upload->path,$fileType,'picfile','goods',$gid);
				//生成缩略图
				$filename = PRO_ROOT.$upload->path.$upload->upload_server_name[$i].'.'.$upload->suffix[$i][count($upload->suffix[$i])-1];
				$picpath = $upload->path.$upload->upload_server_name[0].'.'.$upload->suffix[0][count($upload->suffix[0])-1];
				
				$img = new gd($filename);
				$dst42 = PRO_ROOT.$upload->path.$upload->upload_server_name[$i].'_42';
				$img->createThumb($dst42,42,42,true);
				
				$img = new gd($filename);
				$dst61 = PRO_ROOT.$upload->path.$upload->upload_server_name[$i].'_61';
				$img->createThumb($dst61,61,61,true);
				
				$img = new gd($filename);
				$dst99 = PRO_ROOT.$upload->path.$upload->upload_server_name[$i].'_99';
				$img->createThumb($dst99,99,99,true);
				
				$img = new gd($filename);
				$dst129 = PRO_ROOT.$upload->path.$upload->upload_server_name[$i].'_129';
				$img->createThumb($dst129,129,129,true);
				
				$img = new gd($filename);
				$dst149 = PRO_ROOT.$upload->path.$upload->upload_server_name[$i].'_149';
				$img->createThumb($dst149,149,149,true);
				
				$img = new gd($filename);
				$dst350 = PRO_ROOT.$upload->path.$upload->upload_server_name[$i].'_350';
				$img->createThumb($dst350,350,350,true);
				
				$img = new gd($filename);
				$dst600 = PRO_ROOT.$upload->path.$upload->upload_server_name[$i].'_600';
				$img->createThumb($dst600,600,600,true);
		
				$adminid = AdminAuth::GetAdminId();
				$state = 1;
				$aid = Ware::AddGoodsPic($adminid,$upload->upload_server_name[$i],$upload->path,$upload->upload_file_size[$i],$upload->suffix[$i][count($upload->suffix[$i])-1],time(),date('Y',time()),date('m',time()),date('d',time()),0,$state,$imgdes[$i]);
				Ware::AddGoodsAttach($gid,$aid);
			}
		}
		
		
		/** 添加商品 **/
		$goodsflag = Ware::AddGoods($gid,$tid,$wid,$sid,$pid,$goodsname,1,$isnew,$ishot,$ispromotion,$unit,0,time(),time(),$weight,$weightunit,$des,$keywords,$picpath,$goodsintegral);
		
		/** 添加商品的附属信息 **/
		$bids = '';
		if(!empty($bid)){
			$bids = implode(',',$bid);
		}
		Ware::AddGoods_ext($gid,$description,$bids==''?'':$bids);

		/** 添加商品的标签 **/
		//添加之前先删除
		$aa = Ware::DelGoodsBrand($gid);
		Ware::addGoodsBrand($gid,$bid);
		
		/** 添加促销费方案 **/
		for($i=0;$i<count($profunction);$i++){
			if(proFun::checkActivityGoods($gid,$profunction[$i])){
				proFun::Add($gid,$profunction[$i]);
			}else{
				core::alert("不能添加同类型的促销方案！");
			}
		}
		/** 添加属性 **/
		
		//获取这个商品的属性，封进$attrvalueArr，判断是否会有重复的属性，当插入属性的时候
//		$attrvalue = Ware::GetGoodsAttrValue($gid);
//		$attrvalueArr = array();
//		for($i=0;$i<count($attrvalue);$i++){
//			$attrvalueArr[] = $attrvalue[$i]['aid'];
//		}
		
		for($i=0;$i<count($attrs);$i++){
			$aid = $attrsArr[$i]['id'];
			for($j=0;$j<count($attrs[$i]);$j++){
				//!in_array($attrs[$i][$j],$attrvalueArr)&&
				if($attrs[$i][$j]!=''&&isset($relategoods[$i][$j])&&$attrs[$i][$j]!=1000000){
					Ware::AddAttributeValue($aid,$gid,$attrs[$i][$j],0,$relategoods[$i][$j]);	
				}else if($attrs[$i][$j]!=''&&$attrs[$i][$j]!=1000000&& !isset($relategoods[$i][$j])){
					Ware::AddAttributeValue($aid,$gid,$attrs[$i][$j],0,0);
				}else{
					
				}
			}
		}
		
		/** 添加分类和商品的关系 **/
		
		//获取这个商品所有的分类，并将cid封进一个数组
		$goodscateArrs = Ware::GetCatesByGid($gid);
		$goodscateArr = array();
		for($i=0;$i<count($goodscateArrs);$i++){
			$goodscateArr[] = $goodscateArrs[$i]['categoryid'];
		}
		
		for($i=0;$i<count($category1);$i++){
			if(!empty($goodscateArr)){
				//新添加的分类不在数据库里的写进数据库
				if(!in_array($category1[$i],$goodscateArr)&&$category1[$i]!=1000000){
					Ware::AddGoodsCatetory($gid,$category1[$i],0);
				}
			}else{
				if($category1[$i]!=1000000){
					Ware::AddGoodsCatetory($gid,$category1[$i],0);
				}
			}
		}
	
		/** 添加商品和扩展分类的关系 **/
		
		//获取这个商品所有的分类，并将cid封进一个数组
		$goodsextcateArrs = Ware::GetCatesByGid($gid);
		$goodsextcateArr = array();
		for($i=0;$i<count($goodsextcateArrs);$i++){
			$goodsextcateArr[] = $goodsextcateArrs[$i]['categoryid'];
		}
		//print_r($category);
		for($i=0;$i<count($category);$i++){
			for($k=0;$k<count($category[$i]);$k++){
				if(!empty($goodsextcateArr)){
					if(!in_array($category[$i][$k],$goodsextcateArr)&&$category[$i][$j]!=1000000){
						Ware::AddGoodsCatetory($gid,$category[$i][$k],1);
					}
				}else{
					if($category[$i][$j]!=1000000){
						Ware::AddGoodsCatetory($gid,$category[$i][$k],1);
					}
				}
			}
		}
		
		/** 关联商品 **/
		$relategoods = $_POST['relatesgoods'];
		$realtegoodsArr = array();
		foreach(array_unique($relategoods) as $v){
			$realtegoodsArr[] = $v;
		}
		
		/** 添加关联商品 **/
		
		//获取这个商品相关联的商品id，封进$relategoodsbydbArr，用于判断
		$relategoodsbydb = Ware::GetRelateGoods($gid);
		$relategoodsbydbArr = array();
		for($i=0;$i<count($relategoodsbydb);$i++){
			$relategoodsbydbArr[] = $relategoodsbydb[$i]['goodsid'];
		} 
		
		for($i=0;$i<count($realtegoodsArr);$i++){
			if(!in_array($realtegoodsArr[$i],$relategoodsbydbArr)){
				Ware::AddGoodsRelate($gid,$realtegoodsArr[$i]);
			}
		}
		
		/** 关联文章 **/
		$relatearticle = $_POST['relatearticle'];
		$relatearticleArr = array();
		foreach(array_unique($relatearticle) as $v){
			$relatearticleArr[] = $v;
		}
		
		/** 添加关联文章 **/
		
		//获取这个商品相关联的文章id，封进$relategoodsbydbArr，用于判断
		$relatearticlebydb = Ware::GetRelateArticle($gid);
		$relatearticlebydbArr = array();
		for($i=0;$i<count($relatearticlebydb);$i++){
			$relatearticlebydbArr[] = $relatearticlebydb[$i]['articleid'];
		}
		
		for($i=0;$i<count($relatearticleArr);$i++){
			if(!in_array($relatearticleArr[$i],$relatearticlebydbArr)){
				Ware::AddGoodsArticle($gid,$relatearticleArr[$i]);
			}
		}

		if($goodsflag){
			base::autoSkip('添加商品成功！','返回新入库商品列表',URL.'index.php/admin/goods/goodsnewlist','修改此商品信息',URL.'index.php/admin/goods/goodsedit?gid='.$gid);
		}
	}
	
	/*
	 * 商品的修改
	*/
	public static function goodsedit(){
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(6);
		require_once PRO_ROOT.'include/supply.class.php';
		require_once PRO_ROOT.'include/other.class.php';
		require_once PRO_ROOT.'include/categorys.class.php';
		require_once PRO_ROOT.'include/base.class.php';
		require_once PRO_ROOT.'include/attributes.class.php';
		require_once PRO_ROOT.'include/proFun.class.php';
		require_once PRO_ROOT.'include/brand.class.php';
		require_once DZG_ROOT.'core/image/gd.php';
		
		$gid = $_GET['gid'];
		if(!count($_POST)){
			$categorys = new Categorys();
			$categorys->categorys = $categorys->getcategorys(0,'--');
			$goods = Ware::GetOne($gid);
			$goodsmemberprice = Ware::GetMembersPrice($gid);
			$cates = Categorys::GetAll();
			$cate = Categorys::GetByPid(0);
			$producer = supply::getProducer();
			$brands = Ware::getBrand();
			$members = other::getMember();
			$suppliers = supply::getSupply();
			//给不扩展的分类排序，让他按顺序显示
			$directcates = Ware::GetDirectcatesByGid($gid);
			$temp = '';
			for($i=0;$i<count($directcates);$i++){
				for($j=$i+1;$j<count($directcates);$j++){
					if($directcates[$i]['level']>$directcates[$j]['level']){
						$temp = $directcates[$i];
						$directcates[$i] = $directcates[$j];
						$directcates[$j] = $temp;
					}
				}
			}
			//获取直接分类的子分类用于填充select
			$subcates = array();
			for($i=0;$i<count($directcates)-1;$i++){
				$subcates[] = Categorys::GetByPid($directcates[$i]['id']);
			}
			
			$extendcates = Ware::GetExtendcatesByGid($gid);
			//获取不是扩展的最后一个分类的id
			$lastcid = $directcates[count($directcates)-1]['id'];
			//获取商品的最后一个分类下的attribute key
			$disattrskey = Attributes::GetKeyByCid($lastcid);
			//获取本商品的所有属性
			$disattrsvalue = Ware::GetGoodsAttrValue($gid);
			//在属性值的表里如果有关联的在数组后面添加商品编号和商品名称两个字段用于显示
			for($i=0;$i<count($disattrsvalue);$i++){
				$goodsinfo = Ware::GetOne($disattrsvalue[$i]['relategoods']);
				if(!empty($goodsinfo)){
					$disattrsvalue[$i]['goods_sn'] = $goodsinfo->goods_sn;
					$disattrsvalue[$i]['goodsname'] = $goodsinfo->goodsname;
				}
			}
			
			//把用于显示的属性值的aid封进数组，用于前台页面显示时候的判断
			$disattrsvalueaid = array();
			$disattrsvalues = array();
			for($i=0;$i<count($disattrsvalue);$i++){
				$disattrsvalueaid[] = $disattrsvalue[$i]['aid'];
				$disattrsvalues[] = $disattrsvalue[$i]['attributevalue'];
			}
			//print_r($disattrsvalues);
			//获取图片信息
			$goodspic = Ware::GetGoodsPic($gid);
			//获取关联商品信息
			$realtegoodsinfo = Ware::GetRelateGoodsInfo($gid);
			//获取关联文章信息
			$relatearticleinfo = Ware::GetRelateArticleInfo($gid);
			//获取商品的扩展信息
			$goods_ext = Ware::GetGoodsExt($gid);
			
			$profun = proFun::GetAll();
			//选择的促销方案
			$profunArr = proFun::GetActivitiesByGid($gid);
			//echo $gid;
			
			$lables = Ware::getGoodsBrand($gid);
			//获取所有品牌和所有作品
			$tags = Brands::GetBrandAll();
			$works = Brands::GetWorksAll();
			
			$lablearr = array();
			for($i=0;$i<count($lables);$i++){
				$lablearr[] = $lables[$i]->bid;
			}
			
			//print_r($profunArr);
			$displays = array(
				'memberprice'=>$goodsmemberprice,
				'goods'=>$goods,
				'brand'=>$brands,
				'cateall'=>$categorys->categorys,
				'cates'=>$cates,
				'cate'=>$cate,
				'producer'=>$producer,
				'member'=>$members,
				'supply'=>$suppliers,
				'directcates'=>$directcates,
				'subcates'=>$subcates,
				'extendcates'=>$extendcates,
				'displayattrkeys'=>$disattrskey,
				'displayattrvalues'=>$disattrsvalue,
				'displayattrvalueaids'=>$disattrsvalueaid,
				'disattrsvalues'=>$disattrsvalues,
				'goodspic'=>$goodspic,
				'relategoodsinfo'=>json_encode($realtegoodsinfo),
				'relatearticleinfo'=>json_encode($relatearticleinfo),
				'goodsext'=>$goods_ext,
				'profun'=>$profun,
				'profunarr'=>json_encode($profunArr),
				'lables'=>$lablearr,
				'tags'=>$tags,
				'works'=>$works,
			);
			template('goodsedit',$displays,'default/admin/goods');
		}
		/** 基本信息**/
		
		$gid = $_POST['gid'];
		$bid = $_POST['brands'];
		
		$goodsname = $_POST['goodsname'];
		$goods_sn = $_POST['goods_sn'];
		$tid = $_POST['tags'];
		$wid = $_POST['works'];
		
		//分类的每级分类id的数组
		$category1 = $_POST['category'];
		
		//扩展分类的每个下拉框的每级分类的id
		$cateextend = $_POST['cateextend'];
		$category = array();
		if($cateextend>1){
			for($i=2;$i<=$cateextend;$i++){
				$category[] = $_POST['category'.$i];
			}
		}
		$unit = $_POST['unit'];
		$producerid = $_POST['producer'];
		$supplyid = $_POST['suppliers'];
		//$stock = $_POST['leavingcounthid'];
		//$inprice = $_POST['buypricehid'];
		//$marketprice = $_POST['marketpricehid'];
		//$shopprice = $_POST['shoppricehid'];
		//$members = $_POST['member'];
		$points = $_POST['points'];
		
		/** 描述信息 **/
		$keywords = $_POST['keywords'];
		$des = $_POST['des'];
		$description = $_POST['description'];

		$weight = $_POST['weight'];
		$weightunit = $_POST['weightunit'];
		
		/** 促销方案 **/
		$pros = $_POST['profuns'];

		/**  推荐选项  **/
		$ishot = $_POST['ishot'];
		$isnew = $_POST['isnew'];
		$ispromotion = $_POST['ispromotion'];
		
		/** 属性 （添加）**/
		$attrkeys = array();
		$attrvalues = array();
		$attrs = $_POST['attri'];
		$relategoods = $_POST['relategoods'];
		//print_r($relategoods);
		$cateid = $_POST['cid'];
		$attrsArr = Attributes::GetKeyByCid($cateid);
		
		/** 修改商品之前，检查是否存在商品名称 **/
		$checkflag = Ware::CheckGoodsName($gid,$goodsname);
		//echo $checkflag.'CheckGoodsName';
		if($checkflag){
			core::alert("商品名称已经存在！请重新填写！");
		}
		
		/** 图片(上传) **/
		$imgcurrent = '';
		$upload = new Uploadfile();
		$upload->CreatePath('goods','',2);
		
		$imgdes = $_POST['imgs'];
		$fileType = array('image/gif','image/pjpeg','image/jpg','image/bmp','image/png','image/jpeg');
		for($i=0;$i<count($_FILES['picfile']['name']);$i++){
			if($_FILES['picfile']['name'][$i]!=""){
				$upload->upload_file(PRO_ROOT.$upload->path,$fileType,'picfile','goods',$gid);
				
				//生成缩略图
				$filename = PRO_ROOT.$upload->path.$upload->upload_server_name[$i].'.'.$upload->suffix[$i][count($upload->suffix[$i])-1];
				$imgcurrent = $upload->path.$upload->upload_server_name[0].'.'.$upload->suffix[0][count($upload->suffix[0])-1];
				$img = new gd($filename);
				
				$dst42 = PRO_ROOT.$upload->path.$upload->upload_server_name[$i].'_42';
				$img->createThumb($dst42,42,42,true);
				
				$img = new gd($filename);
				$dst61 = PRO_ROOT.$upload->path.$upload->upload_server_name[$i].'_61';
				$img->createThumb($dst61,61,61,true);
				
				$img = new gd($filename);
				$dst99 = PRO_ROOT.$upload->path.$upload->upload_server_name[$i].'_99';
				$img->createThumb($dst99,99,99,true);
				
				$img = new gd($filename);
				$dst129 = PRO_ROOT.$upload->path.$upload->upload_server_name[$i].'_129';
				$img->createThumb($dst129,129,129,true);
				
				$img = new gd($filename);
				$dst149 = PRO_ROOT.$upload->path.$upload->upload_server_name[$i].'_149';
				$img->createThumb($dst149,149,149,true);
				
				$img = new gd($filename);
				$dst350 = PRO_ROOT.$upload->path.$upload->upload_server_name[$i].'_350';
				$img->createThumb($dst350,350,350,true);
				
				$img = new gd($filename);
				$dst600 = PRO_ROOT.$upload->path.$upload->upload_server_name[$i].'_600';
				$img->createThumb($dst600,600,600,true);
				
				$adminid = 2;
				$state = 1;
				$aid = Ware::AddGoodsPic($adminid,$upload->upload_server_name[$i],$upload->path,$upload->upload_file_size[$i],$upload->suffix[$i][count($upload->suffix[$i])-1],time(),date('Y',time()),date('m',time()),date('d',time()),0,$state,$imgdes[$i],$points);
				Ware::AddGoodsAttach($gid,$aid);
			}
		}
			
		/** 更新商品 **/
		$goodsflag = Ware::EditGoods($gid,$tid,$wid,$sid,$pid,$goodsname,2,$isnew,$ishot,$ispromotion,$unit,0,time(),$weight,$weightunit,$des,$keywords,$imgcurrent);
		
		/** 更新商品的附属信息 **/
		$bids = '';
		if(!empty($bid)){
			$bids = implode(',',$bid);
		}
		if(Ware::GetGoodsExt($gid)){
			Ware::EditGoodsExt($gid,$description,$bids==''?'':$bids);
		}else{
			Ware::AddGoods_ext($gid,$description,$bids==''?'':$bids);
		}
		
		//添加之前先删除
		Ware::DelGoodsBrand($gid);
		Ware::addGoodsBrand($gid,$bid);
		
		/** 添加促销方案 **/
		Ware::DelProFun($gid);
		for($i=0;$i<count($pros);$i++){
			if(proFun::checkActivityGoods($gid,$pros[$i])){
				proFun::Add($gid,$pros[$i]);
			}else{
				core::alert("不能添加同类型的促销方案！");
			}
		}
		
		//插入属性之前，先删除这个商品的属性

		Ware::DelAttris($gid);
		for($i=0;$i<count($attrs);$i++){
			$aid = $attrsArr[$i]['id'];
			for($j=0;$j<count($attrs[$i]);$j++){
				if($attrs[$i][$j]!=''&&isset($relategoods[$i][$j])&&$attrs[$i][$j]!=1000000){
					Ware::AddAttributeValue($aid,$gid,$attrs[$i][$j],0,$relategoods[$i][$j]);	
				}else if($attrs[$i][$j]!=''&&$attrs[$i][$j]!=1000000&& !isset($relategoods[$i][$j])){
					Ware::AddAttributeValue($aid,$gid,$attrs[$i][$j],0,0);
				}else{
				}
			}
		}
		
		/** 添加分类和商品的关系 **/
		
		//获取这个商品所有的分类，并将cid封进一个数组
		$goodscateArrs = Ware::GetCatesByGid($gid);
		$goodscateArr = array();
		for($i=0;$i<count($goodscateArrs);$i++){
			$goodscateArr[] = $goodscateArrs[$i]['categoryid'];
		}
		//上传非扩展分类之前，先删除非扩展分类
		Ware::DelGoodsCates($gid,0);
		for($i=0;$i<count($category1);$i++){
			if($category1[$i]!=1000000){
				Ware::AddGoodsCatetory($gid,$category1[$i],0);
			}
		}
	
		/** 添加商品和扩展分类的关系 **/
		
		//获取这个商品所有的分类，并将cid封进一个数组
		$goodsextcateArrs = Ware::GetCatesByGid($gid);
		$goodsextcateArr = array();
		for($i=0;$i<count($goodsextcateArrs);$i++){
			$goodsextcateArr[] = $goodsextcateArrs[$i]['categoryid'];
		}
		
		for($i=0;$i<count($category);$i++){
			for($k=0;$k<count($category[$i]);$k++){
				if(!empty($goodsextcateArr)){
					if(!in_array($category[$i][$k],$goodsextcateArr)&&$category[$i][$k]!=1000000){
						Ware::AddGoodsCatetory($gid,$category[$i][$k],1);
					}
				}else{
					if($category[$i][$k]!=1000000){
						Ware::AddGoodsCatetory($gid,$category[$i][$k],1);
					}
				}
			}
		}
		
		/** 关联商品 **/
		$relategoods = $_POST['relatesgoods'];
		$realtegoodsArr = array();
		foreach(array_unique($relategoods) as $v){
			$realtegoodsArr[] = $v;
		}
		
		/** 添加关联商品 **/
		
		//在修改之前先删除关联商品
		Ware::DelRelateGoods($gid);
		for($i=0;$i<count($realtegoodsArr);$i++){
			Ware::AddGoodsRelate($gid,$realtegoodsArr[$i]);
		}
		
		/** 关联文章 **/
		$relatearticle = $_POST['relatearticle'];
		$relatearticleArr = array();
		foreach(array_unique($relatearticle) as $v){
			$relatearticleArr[] = $v;
		}
		
		/** 添加关联文章 **/
		
		//在修改之前先删除关联的文章
		Ware::DelRelateArticle($gid);
		for($i=0;$i<count($relatearticleArr);$i++){
			Ware::AddGoodsArticle($gid,$relatearticleArr[$i]);
		}

		if($goodsflag){
			base::autoSkip('修改商品成功！','返回商品列表',URL.'index.php/admin/goods/goodslist','修改此商品信息',URL.'index.php/admin/goods/goodsedit?gid='.$gid);
		}
	}
	
	/*
	 * 新入库商品列表
	*/
	public static function goodsnewlist(){
		$keywordstype = isset($_GET['keywordstype'])?$_GET['keywordstype']:0;
		$keywords = isset($_GET['keywords'])?$_GET['keywords']:'';
		$page = isset($_GET['page'])?$_GET['page']:1;
		switch($keywordstype){
			case 0:
				$goods = Ware::GetStock();
				break;
			case 1:
				$goods = Ware::GetByName($keywords);
				break;
			case 2:
				$goods = Ware::GetBySN($keywords);
				break;
		}
		
		$pager = new pagination($goods,PAGE_SIZE,$page);
	
		template('goodsnewlist',array('goodsObj'=>$pager,'keytype'=>$keywordstype,'keywords'=>$keywords),'default/admin/goods');
	}
	
	/*
	 * 商品列表
	*/
	public static function goodslist(){
		require_once PRO_ROOT.'include/supply.class.php';
		require_once PRO_ROOT.'include/categorys.class.php';
		
		$page = $_GET['page'];
		$categorys = new Categorys();
		$categorys->categorys = $categorys->getcategorys(0,'--');
		$brands = Ware::getBrand();
		$suppliers = supply::getSupply();
		try{
			$producer = producer::objects()->all();
		}catch(DZGException $e){
			core::alert("获取生产商发生错误!");
		}

		if(!count($_GET)){
			$onsaleallgoods = Ware::GetGoodsOnsale();
			$all = new pagination($onsaleallgoods,PAGE_SIZE,$page);
			$displays = array(
				'all'=>$all,
				'brands'=>$brands,
				'suppliers'=>$suppliers,
				'producers'=>$producer,
				'categorys'=>$categorys->categorys,
			);
			template('goodslist',$displays,'default/admin/goods');
		}
		$cateid = $_GET['categorys'];
		$brandid = $_GET['brands'];
		$supplier = $_GET['suppliers'];
		$producer = $_GET['producers'];
		$promotion = $_GET['promotion'];
		$keywords = $_GET['keywords'];
		$goodsresult = Ware::GetGoodsBySearch($cateid,$brandid,$supplier,$producer,$promotion,$keywords);
		$goodsobj = new pagination($goodsresult,PAGE_SIZE,$page);
		$redisplays = array(
			'all'=>$goodsobj,
			'brands'=>$brands,
			'suppliers'=>$suppliers,
			'producers'=>$producer,
			'categorys'=>$categorys->categorys,
			'cid'=>$cateid,
			'bid'=>$brandid,
			'sid'=>$supplier,
			'pid'=>$producer,
			'ispid'=>$promotion,
			'keywords'=>$keywords,
		);
		template('goodslist',$redisplays,'default/admin/goods');
	}
	
	/*
	 * 关联商品搜索
	*/
	public static function goodssearch(){
		$cid = $_GET['cid'];
		$bid = $_GET['bid'];
		$keywords = isset($_GET['keywords'])?$_GET['keywords']:'';
		
		if($cid==0&&$bid!=0){
			$goods = Ware::GetByCB($cid,'edittime DESC',0,$keywords);
		}else if($cid!=0&&$bid==0){
			$goods = Ware::GetByBid($bid,$keywords);
		}else if($cid!=0&&$bid!=0){
			$goods = Ware::GetByCB($cid,'edittime DESC',$bid,$keywords);
		}else{
			if($keywords==''){
				$goods = Ware::GetAllNOP();
			}else {
				$goods = Ware::GetByBid(0,$keywords);
			}
		}
		echo "var goods=".json_encode($goods);
	}
	
	/*
	 * 关联文章搜索
	*/
	public static function searcharticle(){
		global $db;
		$article = $_GET['title'];
		$sql = "SELECT * FROM article WHERE state!=0";
		$where = '';
		if($article != ''){
			$sql .= " AND title like '%".$article."%'";
		}
		 
		try{
			$rs = $db->prepare($sql);
			$rs->setFetchMode(PDO::FETCH_ASSOC);
			$rs->execute();
			$result = $rs->fetchAll();
			$rs->closeCursor();
			echo "var artiles = ".json_encode($result);
		}catch(DZGException $e){
			echo '文章查询失败！';	
		}
	}
	
	/*
	 * 关联属性的时候显示作用
	*/
	public static function searchgoods(){
		$goods_sn = trim($_GET['gsn']);
		$goods = Ware::GetByGoods_sn($goods_sn);
		echo 'var goods='.json_encode($goods);
	}
	/*
	 * 选完分类后显示分类下的属性
	*/
	public static function createattribute(){
		require_once PRO_ROOT.'include/attributes.class.php';
		$cid = $_GET['cid'];
		$attris = Attributes::GetKeyByCid($cid);
		echo "attris = ".json_encode($attris);
	}
	
	/*
	 * 删除商品分类和商品的关系
	*/
	public static function delcategoods(){
		$cid = $_GET['cid'];
		$gid = $_GET['gid'];
		$flag = Ware::DelGoodsCate($cid,$gid,1);
		echo $flag;
	}
	
	/*
	 * 删除图片
	*/
	public static function delgoodspic(){	
		$aid = $_GET['aid'];
		$gid = $_GET['gid'];
		$picflag = Ware::DelPic($aid);
		$goodspicflag = Ware::DelGoodsPic($aid,$gid);
		if($picflag&&$goodspicflag){
			echo 1;
		}else{
			echo 0;
		}
	}
	
	/*
	 * 删除商品
	*/
	public static function delgoods(){
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(6);
		$gid = $_GET['gid'];
		$goods = Ware::GetOne($gid);
		$goods_ext = Ware::GetGoodsExt($gid);
		$flag = Ware::AddDropGoods($goods->id,$goods->bid,$goods->sid,$goods->pid,$goods->goods_sn,$goods->goodsname,$goods->inprice,$goods->shopprice,$goods->marketprice,$goods->leavingcount,$goods->salecount,$goods->remindcount,$goods->storecount,$goods->viewcount,$goods->isonsale,$goods->isnew,$goods->ishot,$goods->ispromotion,$goods->autoonsale,$goods->unit,$goods->recommend,$goods->createtime,$goods->onsaletime,$goods->edittime,$goods->weight,$goods->weightunit,$goods->des,$goods->keywords,$goods_ext->description,$goods_ext->tagname);
		if($flag){
			if(Ware::DelGoods($gid)){
				Ware::DelRelateGoods($gid);
				Ware::DelRelateArticle($gid);
				Ware::DelGoodsPics($gid);
				Ware::DelGoodsCates($gid,0);
				Ware::DelGoodsCates($gid,1);
				Ware::DelAttris($gid);
				Ware::DelProFun($gid);
				core::alert("删除成功！");
			}
		}
	}
	
	/*
	 * 下线商品
	*/
	public static function unsale(){
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(6);
		$gid = $_GET['gid'];
		$flag = Ware::EditOnsale($gid,0);
		if($flag){
			core::alert("下架成功！");
		}
	}
	
	/*
	 * 添加所选商品
	*/
	public static function goodsselectadd(){
		require_once PRO_ROOT.'include/base.class.php';
		$gids = $_GET['gids'];
		if($gids==''||$gids=="false"){
			core::alert("商品选项为空！");
		}
		$gidArr = explode(',',$gids);
		for($i=0;$i<count($gidArr);$i++){
			$flag = Ware::EditOnsale($gidArr[$i],1);
			if(!$flag){
				core::alert("批量添加没有全部完成！");
			}
		}
		base::autoSkip('所选商品全部上架！','返回新入库商品列表，继续添加商品',URL.'index.php/admin/goods/goodsnewlist','进入商品列表，编辑商品',URL.'index.php/admin/goods/goodslist');
	}
	
	/*
	 * 批量导入商品
	*/
	public static function leadgoods(){
		if(!count($_FILES)){
			template('goodslead',array(),'default/admin/goods');
		}
		require_once PRO_ROOT.'include/base.class.php';
		$upload = new Uploadfile();
		$upload->upload_must_size = 10000000;
		$upload->CreatePath('goodscvs','',2);
		$fileType = array('application/vnd.ms-excel','application/octet-stream');
		$upload->upload_file(PRO_ROOT.$upload->path,$fileType,'mydata','goods',time());
		$rootpath = "./../../mall/src/";
		$filename = $upload->path.$upload->upload_server_name[0].'.'.$upload->suffix[0][count($upload->suffix[0])-1];
		//$filename = $rootpath.$upload->path.$upload->upload_server_name[0].'.'.$upload->suffix[0][count($upload->suffix[0])-1];
		$flag = Ware::ImportCSV($filename);
	}
	
	/*
	 * 导入商品分类的数据
	*/
	public static function leadcategory(){
		if(!count($_FILES)){
			template('goodslead',array(),'default/admin/goods');
		}
		require_once PRO_ROOT.'include/base.class.php';
		$upload = new Uploadfile();
		$upload->CreatePath('goodscvs','',2);
		$fileType = array('application/vnd.ms-excel','application/octet-stream');
		$upload->upload_file(PRO_ROOT.$upload->path,$fileType,'mydata','goods',time());
		$rootpath = "./../../mall/src/";
		$filename = $upload->path.$upload->upload_server_name[0].'.'.$upload->suffix[0][count($upload->suffix[0])-1];
		//$filename = $rootpath.$upload->path.$upload->upload_server_name[0].'.'.$upload->suffix[0][count($upload->suffix[0])-1];
		//$filename = "./../../mall/src/uploadfile/goodscvs/2010/07/category.csv";
		
		$flag = Ware::ImportCategory($filename);
	}
	
	/*
	 * 生成商品静态页面
	*/
	public static function makestatic(){
		$goods = Ware::GetAllNOP();
		for($i=0;$i<count($goods);$i++){
			Ware::makestatichtml($goods[$i]->id);
		}
	}
	/*
	* 改变商品 是否新品
	*/
	public static function changeNew($gid='',$vid=''){
		require_once PRO_ROOT.'models.php';
		$gid = ($gid) ? $gid : $_GET['gid'];
		$vid = ($vid) ? $vid : $_GET['vid'];

        if($vid=='1'){
			$val = '0';
			$ret = '2';
		} else {
			$val = '1';
			$ret = '1';
		}

        $sql = "update goods set isnew='$val',edittime='".time()."' where id='$gid' ";             // 判断是否已投票
		try{
			 goods::objects()->QuerySql($sql);
			 die($ret);
		}catch(Exception $e){
			 die('0'); 
		}
	}
	/*
	* 改变商品 是否新品
	*/
	public static function changeHot($gid='',$vid=''){
		require_once PRO_ROOT.'models.php';
		$gid = ($gid) ? $gid : $_GET['gid'];
		$vid = ($vid) ? $vid : $_GET['vid'];

        if($vid=='1'){
			$val = '0';
			$ret = '2';
		} else {
			$val = '1';
			$ret = '1';
		}

        $sql = "update goods set ishot='$val',edittime='".time()."' where id='$gid' ";             // 判断是否已投票
		try{
			 goods::objects()->QuerySql($sql);
			 die($ret);
		}catch(Exception $e){
			 die('0'); 
		}
	}
	/*
	* 改变商品 是否新品
	*/
	public static function changePro($gid='',$vid=''){
		require_once PRO_ROOT.'models.php';
		$gid = ($gid) ? $gid : $_GET['gid'];
		$vid = ($vid) ? $vid : $_GET['vid'];

        if($vid=='1'){
			$val = '0';
			$ret = '2';
		} else {
			$val = '1';
			$ret = '1';
		}

        $sql = "update goods set ispromotion='$val',edittime='".time()."' where id='$gid' ";             // 判断是否已投票
		try{
			 goods::objects()->QuerySql($sql);
			 die($ret);
		}catch(Exception $e){
			 die('0'); 
		}
	}

}
?> 