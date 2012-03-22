<?php
/*
 * author wsh
 * date 2010
 * 商品的操作
*/
if (!defined("PRO_ROOT")) {
	exit();
}
require_once PRO_ROOT . 'models.php';
require_once PRO_ROOT . '/include/commentFun.class.php';
class Ware{
	/**
	 * 商品的入库相关
	 * @param 
	 */
	public static function Add( $id, $goods_sn, $goodsname, $shopprice, $marketprice, $leavecount, $sid, $pid, $inprice, $autoonsale, $unit ){
		$goods = new goods();
		if ( !empty($id) ) {
			$goods->id = $id;
		}else{
			$goods->createtime = time();
		}
		$goods->goods_sn = $goods_sn;  //商品货号
		$goods->goodsname = $goodsname;  //商品名称
		$goods->shopprice = $shopprice;  //本店价格
		$goods->marketprice = $marketprice;  //市场价格
		$goods->leavingcount = $leavecount;  //库存量
		$goods->autoonsale = $autoonsale;  //缺货是否自动下架
		$goods->unit = $unit;  //商品的单位
		$goods->isonsale = 0;  //入库状态
		$goods->sid = $sid;  //供货商ID
		$goods->pid = $pid;  //生产商ID
		$goods->inprice = $inprice;  //进货价格
		$goods->edittime = time();
		$rs = $goods->save();
		return $rs;
	}
	
	/*
	 * 批量添加商品
	*/
	public static function Adds($goodsname,$bid,$goods_sn,$sid,$weight,$des,$shopprice,$marketprice,$inprice,$currentcount,$state=0,$picurl){
		//echo $goodsname.'goodsname=='.$bid.'bid=='.$goods_sn.'goods_sn'.$sid.'sid'.$weight.'weight'.$des.'des'.$shopprice.'shoppirce';
		$goods = new goods();
		$goods->goodsname = $goodsname;
		$goods->goods_sn = $goods_sn;
		$goods->bid = $bid;
		$goods->sid = $sid;
		$goods->weight = $weight;
		$goods->des = $des;
		$goods->shopprice = $shopprice;
		$goods->marketprice = $marketprice;
		$goods->inprice = $inprice;
		$goods->leavingcount = $currentcount;
		$goods->isonsale = $state;
		$goods->imgcurrent = $picurl;
		$flag = $goods->save();
		if($flag){
			return $goods->id;
		}
	}
	
 	/*
 	 * 添加商品
	*/
 	public static function AddGoods($gid,$bid,$wid,$sid,$pid,$goodsname,$isonsale,$isnew,$ishot,$ispromotion,$unit,$recommend,$onsaletime,$edittime,$weight,$weightunit,$des,$keywords,$imgcurrent,$integral){
 		$goods = new goods();
 		$goods->id = $gid;
		$goods->bid = $bid;
		$goods->wid = $wid;
 		$goods->sid = $sid;
 		$goods->pid = $pid;
 		$goods->goodsname = $goodsname;
 		$goods->isonsale = $isonsale;
 		$goods->isnew = $isnew;
 		$goods->ishot = $ishot;
 		$goods->ispromotion = $ispromotion;
 		$goods->unit = $unit;
 		$goods->recommend = $recommend;
 		$goods->onsaletime = $onsaletime;
 		$goods->edittime = $edittime;
 		$goods->weight = $weight;
 		$goods->weightunit = $weightunit;
 		$goods->des = $des;
 		$goods->keywords = $keywords;
 		$goods->imgcurrent=$imgcurrent;
 		$goods->integral = $integral;
 		$flag = $goods->save();
 		return $flag;
 	}
 	
 	public static function AddDropGoods($gid,$bid,$sid,$pid,$goods_sn,$goodsname,$inprice,$shopprice,$marketprice,$leavingcount,$salecount,$remindcunt,$storecount,$viewcount,$isonsale,$isnew,$ishot,$ispromotion,$autoonsale,$unit,$recommend,$createtime,$onsaletime,$edittime,$weight,$weightunit,$des,$keywords,$description,$brand){
 		$dropgoods = new dropgoods();
 		$dropgoods->goodsid = $gid;
 		$dropgoods->bid = $bid;
 		$dropgoods->sid = $sid;
 		$dropgoods->pid = $pid;
 		$dropgoods->goods_sn = $goods_sn;
 		$dropgoods->goodsname = $goodsname;
 		$dropgoods->inprice = $inprice;
 		$dropgoods->shopprice = $shopprice;
 		$dropgoods->marketprice = $marketprice;
 		$dropgoods->leavingcount = $leavingcount;
 		$dropgoods->salecount = $salecount;
 		$dropgoods->recommend = $recommend;
 		$dropgoods->storecount = $storecount;
 		$dropgoods->viewcount = $viewcount;
 		$dropgoods->isonsale = $isonsale;
 		$dropgoods->isnew = $isnew;
 		$dropgoods->ishot = $ishot;
 		$dropgoods->ispromotion = $ispromotion;
 		$dropgoods->autoonsale = $autoonsale;
 		$dropgoods->unit = $unit;
 		$dropgoods->recommend = $recommend;
 		$dropgoods->createtime = $createtime;
 		$dropgoods->onsaletime = $onsaletime;
 		$dropgoods->edittime = $edittime;
 		$dropgoods->weight = $weight;
 		$dropgoods->weightunit = $weightunit;
 		$dropgoods->des = $des;
 		$dropgoods->keywords = $keywords;
 		$dropgoods->description = $description;
 		$dropgoods->brand = $brand;
 		$flag = $dropgoods->save();
 		return $flag;
 	}
 	/*
 	 * 添加商品与分类的关系
 	 * @param int $gid 商品id
 	 * @param int $cid 分类的id
	*/
 	public static function AddGoodsCatetory($gid,$cid,$isextend){
 		$goodscate = new goodscategory();
 		$goodscate->goodsid = $gid;
 		$goodscate->categoryid = $cid;
 		$goodscate->isextend = $isextend;
 		$goodscate->save();
 	}
 	
 	/*
 	 * 添加图片
	*/
 	public static function AddGoodsPic($uid,$filename,$apath,$asize,$atype,$addtime,$ayear,$amonth,$aday,$usecount,$state,$des){
 		$attach = new attachment();
 		$attach->uid = $uid;
 		$attach->filename = $filename;
 		$attach->apath = $apath;
 		$attach->asize = $asize;
 		$attach->atype = $atype;
 		$attach->addtime = $addtime;
 		$attach->ayear = $ayear;
 		$attach->amonth = $amonth;
 		$attach->aday = $aday;
 		$attach->usecount = $usecount;
 		$attach->state = $state;
 		$attach->des = $des;
		$flag = $attach->save();
		if($flag){
			return $attach->id;
		}
 	}
 	
 	/*
 	 * 添加商品和图片的关联
 	 * @param int $gid 
 	 * @param int $aid
	*/
 	public static function AddGoodsAttach($gid,$aid){
 		$goodsattach = new goodsattachment();
 		$goodsattach->goodsid = $gid;
 		$goodsattach->aid = $aid;
 		$flag = $goodsattach->save();
 		return $flag;
 	}
 	
 	/*
 	 * 添加属性
	*/
 	public static function AddAttributeValue($aid,$goodsid,$attributevalue,$attributeprice,$realtegoods){
 		$attrvalue = new attribute_value();
 		$attrvalue->aid = $aid;
 		$attrvalue->goodsid = $goodsid;
 		$attrvalue->attributevalue = $attributevalue;
 		$attrvalue->attributeprice = $attributeprice;
 		$attrvalue->relategoods = $realtegoods;
 		$flag = $attrvalue->save();
 		return $flag;
 	}
 	
 	/*
 	 * 添加商品关联
 	 * @param int $pgid 被关联的商品
 	 * @param int $gid 关联的商品
	*/
 	public static function AddGoodsRelate($pgid,$gid){
 		$goodsrelate = new goodsrelevancy();
 		$goodsrelate->parentgoodsid = $pgid;
 		$goodsrelate->goodsid = $gid;
 		$flag = $goodsrelate->save();
 		if($flag){
 			return $goodsrelate;
 		}
 	}
 	
 	/*
 	 * 添加于商品关联的文章
 	 * @param int $gid 
 	 * @param int $aid 文章id
	*/
 	public static function AddGoodsArticle($gid,$aid){
 		$goodsarticle = new goodsarticle();
 		$goodsarticle->goodsid = $gid;
 		$goodsarticle->articleid = $aid;
 		$flag = $goodsarticle->save();
 		if($flag){
 			return $goodsarticle->id;
 		}
 	}	
 		
 	/*
 	 * 添加商品的附属信息
	*/
 	public static function AddGoods_ext($gid,$des,$brand){
 		global $db;
 		$sql = "INSERT INTO goods_ext SET goodsid=".$gid.",description='".$des."',tagname='".$brand."'";
 		try{
 			$db->exec($sql);
 		}catch(DZGException $e){
 			return false;
 		}	
 		return true;
 	}
 	
	/*
 	 * 修改商品
	*/
	public static function EditGoods($gid,$bid,$wid,$sid,$pid,$goodsname,$isonsale,$isnew,$ishot,$ispromotion,$unit,$recommend,$edittime,$weight,$weightunit,$des,$keywords,$integral){
 		$goods = new goods();
 		$goods->id = $gid;
		$goods->bid = $bid;
		$goods->wid = $wid;
 		$goods->sid = $sid;
 		$goods->pid = $pid;
 		$goods->goodsname = $goodsname;
 		$goods->isonsale = $isonsale;
 		$goods->isnew = $isnew;
 		$goods->ishot = $ishot;
 		$goods->ispromotion = $ispromotion;
 		$goods->unit = $unit;
 		$goods->recommend = $recommend;
 		$goods->edittime = $edittime;
 		$goods->weight = $weight;
 		$goods->weightunit = $weightunit;
 		$goods->des = $des;
 		$goods->keywords = $keywords;
 		$goods->integral = $integral;
 		$flag = $goods->save();
 		return $flag;
 	}
 	
 	/*
 	 * 修改商品的扩展信息
 	 * @param int $gid
	*/
 	public static function EditGoodsExt($gid,$description,$brand=''){
 		global $db;
 		$sql = "UPDATE goods_ext SET description='".$description."',tagname='".$brand."' WHERE goodsid=".$gid;
 		try{
 			return $db->exec($sql);
 		}catch(DZGException $e){
 			return false;
 		}
 	}
 	
 	/*
 	 * 修改商品的上下架状态
	*/
 	public static function EditOnsale($gid,$state){
 		global $db;
 		$sql = "UPDATE goods SET edittime=".time().",isonsale=".$state." WHERE id=".$gid;
 		try{
 			return $db->exec($sql);
 		}catch(DZGException $e){
 			return false;	
 		}
 	}
 	
 	/*
 	 * 更新评论数
 	 * @param int $gid 要更新的商品id
 	 * @param int $count 更新前的评论数
	*/
 	public static function EditCommentCount($gid,$count){
 		$goods = new goods();
 		$goods->id = $gid;
 		$commentcount = $count+1;
		$goods->commentcount=$commentcount;
		$goodcommentCount = Comments::goodcommentCount($gid);
		$commentrate=$goodcommentCount / $commentcount;
		$goods->commentrate = sprintf('%0.2f',$commentrate);
		
 		$goods->save();
 	}
 	
 	/*
 	 * 修改商品之前检查是否存在这个商品名称
	*/
 	public static function CheckGoodsName($gid,$goodsname){
 		global $db;
 		$sql = "SELECT count(id) FROM goods WHERE id!=".$gid." 	AND goodsname='".$goodsname."'";
 		try{
 			$rs = $db->prepare($sql);
 			$rs->setFetchMode(PDO::FETCH_ASSOC);
 			$rs->execute();
 			$count = $rs->fetchColumn();
 			$rs->closeCursor();
 			return $count;
 		}catch(DZGException $e){
 			return false;
 		}
 	}
 	
 	/*
 	 * 检查编号是否存在
	*/
 	public static function CheckGoods_sn($gid,$goods_sn){
 		global $db;
 		$sql = "SELECT count(id) FROM goods WHERE id!=".$gid." AND goods_sn='".$goods_sn."'";
 		try{
 			$rs = $db->prepare($sql);
 			$rs->setFetchMode(PDO::FETCH_ASSOC);
 			$rs->execute();
 			$count = $rs->fetchColumn();
 			$rs->closeCursor();
 			return $count;
 		}catch(DZGException $e){
 			return false;
 		}
 	}
 	
 	/*
 	 * 获取商品信息根据名称
	*/
	public static function GetByName($goodsname){
		try{
			return goods::objects()->pageFilter("isonsale=0 AND goodsname like '%".$goodsname."%'", 'edittime DESC');
		}catch(DZGException $e){
			return false;
		}
	}
	
	/*
	 * 获取商品信息根据商品的名字
	*/
	public static function GetGoodsByName($goodsname){
		try{
			return goods::objects()->get("goodsname='".$goodsname."'");
		}catch(DZGException $e){
			return false;
		}
	}
	
 	/*
 	 * 获取商品信息根据商品编号
 	 * @param string $goods_sn
	*/
	public static function GetBySN($goods_sn){
		try{
			return goods::objects()->pageFilter("isonsale=0 AND goods_sn like '%".$goods_sn."%'", 'edittime DESC');
		}catch(DZGException $e){
			return false;
		}
	}
	
	/*
	 * 获取商品信息根据商品编号(获得一个)
	 * @param string $goods_sn
	*/
	public static function GetByGoods_sn($goods_sn){
		try{
			return goods::objects()->get("goods_sn='".$goods_sn."'");
		}catch(DZGException $e){
			return false;
		}
	}
 	
	/*
	 * 获取商品通过分类，品牌，关键字
	 * @param int $cid 分类id	
	 * @param int $bid 品牌id
	 * @param string $keywords 关键字（商品名称）
	*/
	public static function GetByCB($cid,$order='edittime DESC',$bid=0,$keywords=''){
		global $db;
		$sql = "SELECT * FROM goods as g INNER JOIN goodscategory as gc ON g.id=gc.goodsid WHERE isonsale!=0 AND gc.categoryid=".$cid;
		if($bid){
			$sql = "SELECT * FROM goods AS g INNER JOIN goodscategory AS gc ON g.id = gc.goodsid INNER JOIN goodsbrand AS gb ON g.id = gb.gid WHERE isonsale !=0 AND gc.categoryid =".$cid." AND gb.bid=".$bid;
		}
		if($keywords!=''){
			$sql .= " AND goodsname LIKE '%".$keywords."%'";
		}
		$sql .= " ORDER BY ".$order;
		try{
			$rs = $db->prepare($sql);
			$rs->setFetchMode(PDO::FETCH_ASSOC);
			$rs->execute();
			$result = $rs->fetchAll();
			$rs->closeCursor();
			return $result;
		}catch(DZGException $e){
			return false;
		}
	}
	
	/*
	 * 获取商品的
	*/
	public static function GetByCid($cid,$order,$start,$len){
		global $db;
		$sql = "SELECT * FROM goods as g INNER JOIN goodscategory as gc ON g.id=gc.goodsid WHERE isonsale!=0 AND gc.categoryid=".$cid.$roder." LIMIT ".$start.",".$len;
		try{
			$rs = $db->prepare($sql);
			$rs->setFetchMode(PDO::FETCH_ASSOC);
			$rs->execute();
			$result = $rs->fetchAll();
			$rs->closeCursor();
			return $result;
		}catch(DZGException $d){
			return false;
		}
	}
	
	/*
	 * 获取商品通过品牌
	 * @param int $bid 品牌id
	 * @param string  $keywords
	*/
	public static function GetByBid($bid=0,$keywords=''){
		global $db;
		$sql = "SELECT * FROM goods WHERE isonsale!=0";
		if($bid){
			$sql = "SELECT * FROM goods as g INNER JOIN goodsbrand as gb ON g.id=gb.gid WHERE isonsale!=0 ";
			//$sql .= " AND bid=".$bid;
		}
		if($keywords!=''){
			$sql .= " AND goodsname LIKE '%".$keywords."%'";
		}
		$sql .= " ORDER BY edittime DESC";
		try{
			$rs = $db->prepare($sql);
			$rs->setFetchMode(PDO::FETCH_ASSOC);
			$rs->execute();
			$result = $rs->fetchAll();
			$rs->closeCursor();
			return $result;
		}catch(DZGException $e){
			return false;
		}
	}
	
	/*
	 * 获取全部商品(有分页)
	*/
	public static function GetAll(){
		try{
			return goods::objects()->pageFilter(NULL, 'edittime DESC');
		}catch(DZGException $e){
			return false;
		}
	}
	
	/*
	 * 获取全部商品（无分页）
	*/
	public static function GetAllGoods(){
		try{
			return goods::objects()->all();
		}catch(DZGException $e){
			return false;
		}
	}
	
	/*
	 * 获取新入库的商品
	*/
	public static function GetStock(){
		try{
			return goods::objects()->pageFilter("isonsale=0"," edittime DESC");
		}catch(DZGException $e){
			return false;
		}
	}
	
	/*
	 * 获取全部已经入库的商品(有分页)
	*/
	public static function GetGoodsOnsale(){
		//$sql = "SELECT * FROM goods WHERE isonsale!=0 ORDER BY edittime ASC";
		try{
			//return goods::objects()->QuerySql($sql);
			return goods::objects()->pageFilter("isonsale != 0","edittime DESC");
		}catch(DZGException $d){
			return false;
		}
	}
	
	public static function GetGooodsOnsaleByLim(){
		
	}
	/*
	 * 获取全部商品(没有分页)
	*/
	public static function GetAllNOP(){
		global $db;
		$sql = "SELECT * FROM goods WHERE isonsale!=0";
		try{
			$rs = $db->prepare($sql);
			$rs->setFetchMode(PDO::FETCH_ASSOC);
			$rs->execute();
			$result = $rs->fetchAll();
			$rs->closeCursor();
			return $result;
		}catch(DZGException $e){
			return false;
		}
	}
	
	/**
	 * 获取一个商品的信息
	 */
	public static function GetOne( $id ) {
		try {
			$goods = goods::objects()->get("id = $id");
		} catch (Exception $e) {
			$goods = false;
		}
		return $goods;
	}
	
	/**
	 * 获取一个商品的库存量信息
	 */
	public static function getGoodsLevaing( $id ) {
		try {
			$goods = goods::objects()->get("id = $id");
			$goods = $goods->leavingcount;
		} catch (Exception $e) {
			$goods = false;
		}
		return $goods;
	}
	
	/**
	 * 扣除商品库存余量
	 */
	public static function goodsOut( $id, $amount ) {
		try {
			$goodsInfo = goods::objects()->get("id = $id");
		} catch (Exception $e) {
			return false;
		}
		if ($goodsInfo->leavingcount < $amount) {
			return false;
		}
		$goods = new goods;
		$goods->id = $id;
		$goods->leavingcount = $goodsInfo->leavingcount - $amount;
		$rs = $goods->save();
		return $rs;
	}
	
	/**
	 * 给一个商品添加或编辑品牌
	 */
	public static function addGoodsBrand( $gid, $brandInfo ) {
		//先删除数据库中的该商品已有的品牌信息
		$brands = Ware::getGoodsBrand($gid);
		foreach ($brands as $i=>$v) {
			$brand = new goodsbrand();
			$brand->id = $v->id;
			$brand->delete();
		}
		//插入数据库
		foreach ($brandInfo as $i=>$v) {
			$brand = new goodsbrand();
			$brand->gid = $gid;
			$brand->bid = $v;
			$brand->save();
		}
	}
	
	/**
	 * 获得商品的全部品牌
	 */
	public static function getBrand() {
		try {
			$brand = brand::objects()->all();
		} catch (Exception $e) {
			$brand = false;
		}
		return $brand;
	}
	
	/**
	 * 获得一件商品的品牌
	 */
	public static function getGoodsBrand( $id ) {
		try {
			$brand = goodsbrand::objects()->filter("gid = $id");
		} catch (Exception $e) {
			$brand = false;
		}
		return $brand;
	}
	
	/**
	 * 获得一件商品的所有会员价格(有分页)
	 */
	public static function getMemberPrice( $gid ) {
		try {
			$price = goodsmemberprice::objects()->filter("goodsid = $gid", "mid");
		} catch (Exception $e) {
			$price = false;
		}
		return $price;
	}
	
	/*
	 * 获得一件商品的所有会员价格(无分页)
	 * @param int $gid 
	*/
	public static function GetMembersPrice($gid){
		global $db;
		$sql = "SELECT * FROM goodsmemberprice WHERE goodsid=".$gid." ORDER BY mid";
		try{
			$rs = $db->prepare($sql);
			$rs->setFetchMode(PDO::FETCH_ASSOC);
			$rs->execute();
			$result = $rs->fetchAll();
			$rs->closeCursor();
			return $result;
		}catch(DZGException $e){
			return false;
		}
	}
	
	/**
	 * 获得缺货商品的总数量
	 */
	public static function getOutCount() {
		global $db;
		try {
			$sql = "SELECT COUNT(*) AS count FROM goods WHERE leavingcount = 0";
			$rs = $db->prepare($sql);
			$rs->execute();
			$count = $rs->fetchAll();
			$rs->closeCursor();
		} catch (DZGException $e) {
			$count = false;
		}
		return $count[0][0];
	}
	
	/*
	 * 获取分类id根据商品id(无分页)
	 * @param int $gid
	*/
	public static function GetCatesByGid($gid,$type=1){
		$sql = "SELECT * FROM goodscategory WHERE goodsid=".$gid;
		//echo $sql;
		try{
			return goodscategory::objects()->QuerySql($sql,$type);
		}catch(DZGException $e){
			return false;
		}
	}
	
	/*
	 * 获取直接所属分类根据商品id（无分页）
	 * @param int $gid 
	*/
	public static function GetDirectcatesByGid($gid){
		$sql = "SELECT * FROM goodscategory gc INNER JOIN category c ON gc.categoryid=c.id WHERE gc.goodsid=".$gid." AND gc.isextend=0";
		try{
			return goodscategory::objects()->QuerySql($sql);
		}catch(DZGException $d){
			return false;
		}
	}
	
	/*
	 * 获取扩展分类根据商品id(无分页)
	 * @param int $gid
	*/
	public static function GetExtendcatesByGid($gid){
		$sql = "SELECT * FROM goodscategory gc INNER JOIN category c ON gc.categoryid=c.id WHERE goodsid=".$gid." AND isextend=1";
		try{
			return goodscategory::objects()->QuerySql($sql);
		}catch(DZGException $e){
			return false;
		}
	}
	
	/*
	 * 获取搜索 的商品列表(有分页)
	*/
	public static function GetGoodsBySearch($cid,$bid,$sid,$pid,$ispromotion,$keywords='',$byid=2,$byleavingcount=2,$inprice=2){
//		global $db;
		$sql = "";
		//有促销方案
		if($ispromotion==3){
			if($cid){
				$sql .= "SELECT * FROM goods INNER JOIN goodscategory gc ON goods.id=gc.goodsid WHERE isonsale!=0 AND gc.categoryid=".$cid;
			}else{
				$sql .= "SELECT * FROM goods WHERE isonsale!=0";
			}
		}else{
			if($cid){
				$sql .= "SELECT * FROM goods INNER JOIN goodscategory gc ON goods.id=gc.goodsid WHERE isonsale!=0 AND gc.categoryid=".$cid;
			}else{
				$sql .= "SELECT * FROM goods WHERE isonsale!=0";
			}
		}
		
		
		if($bid){
			$sql .= " AND goods.bid=".$bid;
		}
		if($sid){
			$sql .= " AND goods.sid=".$sid;
		}
		if($pid){
			$sql .= " AND goods.pid=".$pid;
		}
		
		if($ispromotion==1){
			$sql .= " AND isnew=1";
		}else if($ispromotion==2){
			$sql .= " AND ishot=1";
		}
		
		if($keywords!=''&&$keywords!='关键字'){
			$sql .= " AND goodsname like'%".$keywords."%'";
		}
		
		if($byid==1){
			$sql .= " ORDER BY goods.id";
		}else if($byid==0){
			$sql .= " ORDER BY goods.id DESC";
		}
		
		if($byleavingcount==1){
			$sql .= " ORDER BY leveingcount";
		}else if($byleavingcount==0){
			$sql .= " ORDER BY leveingcount DESC";
		}
		
		if($inprice==1){
			$sql .= " ORDER BY inprice";
		}else if($inprice==0){
			$sql .= " ORDER BY inprice DESC";
		}
		if($byid=2&&$byleavingcount=2&&$inprice=2){
			$sql .= " ORDER BY goods.edittime DESC";
		}
		//echo $sql;
		try{
			return goods::objects()->pageFilter('','',2,$sql);
		}catch(DZGException $d){
			return false;
		}
	}
	
	/**
	 * 获取商品的详细信息
	 * @param int $gid 商品id
	 * link
	 */
	public static function getGoodsInfo($gid){
		global $db;
		try{
			$goods = goods::objects()->get("id = '$gid'");
		} catch (DZGException $e) {
			$goods = '';
		}
		return $goods;
	}

	/**
	 * 获取商品的类别
	 * @param int $gid 商品id
	 * link
	 */
	public static function getGoodsCategory($gid){
		global $db;
		try{
			$sql = "SELECT c.categoryname FROM goodscategory gc JOIN category c ON gc.categoryid=c.id WHERE gc.goodsid='$gid'";
			$rs = $db ->prepare($sql);
			$rs->execute();
			$gcategory = $rs->fetch();
			$rs->closeCursor();
		} catch (DZGException $e) {
			$gcategory = '';
		}
		return $gcategory;
	
	}

	/**
	 * 获取商品属性
	 * @param int $gid 商品id
	 * link
	 */
	public static function getGoodsAttribute($gid){
		global $db;
		try{
			$sql = "SELECT av.id,av.attributevalue,av.attributeprice,ak.attributename FROM attribute_value av JOIN attribute_key ak ON av.aid=ak.id WHERE av.goodsid='$gid'";
			$rel = $db ->prepare($sql);
			$rel->execute();
			$attribute = $rel->fetchAll();
			$rel->closeCursor();
		} catch (DZGException $e) {
			$attribute = ''; 
		}
		return $attribute;
	}
	
	/*
	 * 获取商品属性值
	 * @param int $gid
	*/
	public static function GetGoodsAttrValue($gid){
		$sql = "SELECT * FROM attribute_value WHERE goodsid=".$gid;
		try{
			return attribute_value::objects()->QuerySql($sql);
		}catch(DZGException $e){
			return false;
		}
	}
	
	/*
	 * 获取关联商品根据被关联的商品
	 * @param int $gid
	*/
	public static function GetRelateGoods($gid){
		$sql = "SELECT * FROM goodsrelevancy WHERE parentgoodsid=".$gid;
		try{
			return goodsrelevancy::objects()->QuerySql($sql);
		}catch(DZGException $e){
			return false;
		}
	}
	
	/*
	 * 获取商品的相关联的商品信息
	*/
	public static function GetRelateGoodsInfo($gid){
		global $db;
		$sql = "SELECT * FROM goods g INNER JOIN goodsrelevancy gr ON g.id=gr.goodsid WHERE gr.parentgoodsid=".$gid;
		try{
			$rs = $db->prepare($sql);
			$rs->setFetchMode(PDO::FETCH_ASSOC);
			$rs->execute();
			$result = $rs->fetchAll();
			$rs->closeCursor();
			return $result;
		}catch(DZGException $e){
			return false;
		}
	}
	
	/*
	 * 获取商品的关联的商品信息
	*/
	public static function GetRelateGoodsInfoLim($gid,$start,$len){
		global $db;
		$sql = "SELECT * FROM goods g INNER JOIN goodsrelevancy gr ON g.id=gr.goodsid WHERE gr.parentgoodsid=".$gid." LIMIT ".$start.",".$len;
		try{
			$rs = $db->prepare($sql);
			$rs->setFetchMode(PDO::FETCH_ASSOC);
			$rs->execute();
			$result = $rs->fetchAll();
			$rs->closeCursor();
			return $result;
		}catch(DZGException $e){
			return false;
		}
	}
	
	/*
	 * 获取关联的文章根据商品id
	 * @param int $gid 
	*/
	public static function GetRelateArticle($gid){
		$sql = "SELECT * FROM goodsarticle WHERE goodsid=".$gid;
		try{
			return goodsarticle::objects()->QuerySql($sql);
		}catch(DZGException $e){
			return false;
		}
	}
	
	/*
	 * 获取商品的关联的文章信息
	*/
	public static function GetRelateArticleInfo($gid){
		global $db;
		$sql = "SELECT * FROM article a INNER JOIN goodsarticle ga ON a.id=ga.articleid WHERE ga.goodsid=".$gid;
		try{
			$rs = $db->prepare($sql);
			$rs->setFetchMode(PDO::FETCH_ASSOC);
			$rs->execute();
			$result = $rs->fetchAll();
			$rs->closeCursor();
			return $result;
		}catch(DZGException $e){
			return false;
		}
	}
	
	/*
	 * 获取图片信息
	 * @param int $gid
	*/
	public static function GetGoodsPic($gid){
		global $db;
		$sql = "SELECT * FROM attachment a INNER JOIN goodsattachment ga ON a.id=ga.aid WHERE ga.goodsid=".$gid;
		try{
			$rs = $db->prepare($sql);
			$rs->setFetchMode(PDO::FETCH_ASSOC);
			$rs->execute();
			$result = $rs->fetchAll();
			$rs->closeCursor();
			return $result;
		}catch(DZGException $d){
			return false;
		}
	}
	
	/*
	 * 获取单个图片信息
	 * @param int $gid
	*/
	public static function GetGoodsImg($gid){
		global $db;
		$sql = "SELECT * FROM attachment a INNER JOIN goodsattachment ga ON a.id=ga.aid WHERE ga.goodsid=".$gid." LIMIT 0,1";
		try{
			$rs = $db->prepare($sql);
			$rs->setFetchMode(PDO::FETCH_ASSOC);
			$rs->execute();
			$result = $rs->fetchAll();
			$rs->closeCursor();
			return $result;
		}catch(DZGException $e){
			return false;
		}
	}
	
	/*
	 * 获取商品的扩展信息
	 * @param int $gid
	*/
	public static function GetGoodsExt($gid){
		//$sql = "SELECT * FROM goods_ext WHERE =".$gid;
		try{
			return goods_ext::objects()->get("goodsid=".$gid);
		}catch(DZGException $d){
			return false;
		}
	}
	
	/*
	 * 删除属性值（某个商品）
	 * @param int $gid
	*/
	public static function DelAttris($gid){
		global $db;
		$sql = "DELETE FROM attribute_value WHERE goodsid=".$gid;
		try{
			return $db->exec($sql);
		}catch(DZGException $e){
			return false;
		}
	}
	
	/*
	 * 删除商品和分类的关系根据分类id和商品id
	 * @param int $cid 
	 * @param int $gid
	*/
	public static function DelGoodsCate($cid,$gid,$isextend){
		global $db;
		$sql = "DELETE FROM goodscategory WHERE goodsid=".$gid." AND categoryid=".$cid." AND isextend=".$isextend;
		try{
			return $db->exec($sql);
		}catch(DZGException $d){
			return false;
		}
	}

	/*
	 * 删除商品和分类的关系根据商品id
	 * @param int $gid
	*/
	public static function DelGoodsCates($gid,$isextend){
		global $db;
		$sql = "DELETE FROM goodscategory WHERE goodsid=".$gid." AND isextend=".$isextend;
		try{
			return $db->exec($sql);
		}catch(DZGException $e){
			return false;
		}
	}
	
	/*
	 * 删除分类下的商品
	 * @param int $cid 
	*/
	public static function DelGoodsCategorys($cid){
		global $db;
		$sql = "DELETE FROM goodscategory WHERE categoryid=".$cid;
		try{
			return $db->exec($sql);
		}catch(DZGException $d){
			return false;
		}
	}
	
	/*
	 * 删除图片
	 * @param int $aid
	*/
	public static function DelPic($aid){
		try{
			$att = new attachment();
			$att->id = $aid;
			$flag = $att->delete();
			return $flag;
		}catch(DZGException $d){
			return false;
		}
	}
	
	/*
	 * 删除图片和商品的关系
	*/
	public static function DelGoodsPic($aid,$gid){
		global $db;
		$sql = "DELETE FROM goodsattachment WHERE aid=".$aid." AND goodsid=".$gid;
		try{
			return $db->exec($sql);
		}catch(DZGException $e){
			return false;
		}
	}
	
	/*
	 * 删除商品的所有图片
	*/
	public static function DelGoodsPics($gid){
		global $db;
		$sql = "DELETE FROM goodsattachment WHERE goodsid=".$gid;
		try{
			return $db->exec($sql);
		}catch(DZGException $d){
			return false;
		}
	}
	
	/*
	 * 删除商品的 关联商品
	*/
	public static function DelRelateGoods($gid){
		global $db;
		$sql = "DELETE FROM goodsrelevancy WHERE parentgoodsid=".$gid;
		try{
			return $db->exec($sql);
		}catch(DZGException $e){
			return false;
		}
	}
	
	/*
	 * 删除关联的 文章
	*/
	public static function DelRelateArticle($gid){
		global $db;
		$sql = "DELETE FROM goodsarticle WHERE goodsid=".$gid;
		try{
			return $db->exec($sql);
		}catch(DZGException $d){
			return false;
		}
	}
	
	/*
	 * 删除商品的促销关系
	 * @param int $gid
	*/
	public static function DelProFun($gid){
		global $db;
		$sql = "DELETE FROM goods_activity WHERE goods_id=".$gid;
		try{
			return $db->exec($sql);
		}catch(DZGException $e){
			return false;
		}
	}
	
	/*
	 * 删除商品
	*/
	public static function DelGoods($gid){
		try{
			$goods = new goods();
			$goods->id = $gid;
			return $goods->delete();
		}catch(DZGException $d){
			return false;
		}
	}
	
	/*
	 * 删除商品的品牌
	*/
	public static function DelGoodsBrand($gid){
		global $db;
		$sql = "DELETE FROM goodsbrand WHERE gid=".$gid;
		try{
			return $db->exec($sql);
		}catch(DZGException $e){
			return false;
		}
	}
	
	/*
	 * 导入商品csv
	*/
	public static function ImportCSV($filename){
		require_once PRO_ROOT.'include/base.class.php';
		require_once PRO_ROOT.'include/categorys.class.php';
		require_once PRO_ROOT.'include/attributes.class.php';
		require_once PRO_ROOT.'include/supply.class.php';
		require_once PRO_ROOT.'include/brand.class.php';
		
		$data = base::ParseCSV($filename);
		//分析数据
		$category = base::conv($data[0][0]);
		$categoryarr = explode(',',$category);
		$pid  = 0;
		for($i=0;$i<count($categoryarr);$i++){
			if($i==0){
				$cids[$i] = Categorys::GetByCName($categoryarr[$i],0);
				$pid = $cid[$i]->parentid;
			}else{
				$cids[$i] = Categorys::GetByCName($categoryarr[$i]);
				$pid = $cid[$i]->parentid;
			}
			
		}
		
		$goodsinfo = array();
		$attribute = array();
		$supplier = array();
		$brand = array();
		for($i=2;$i<count($data)-2;$i++){
			$goodsinfo[$i-2]['picurl'] = base::conv($data[$i][1]);
			$goodsinfo[$i-2]['goodsname'] = base::conv($data[$i][3]);
			$goodsinfo[$i-2]['goods_sn'] = base::conv($data[$i][4]);
			$goodsinfo[$i-2]['weight'] = base::conv($data[$i][9]);
			//$goodsinfo[$i-2]['netweight'] = base::conv($data[$i][5]);
			$goodsinfo[$i-2]['des'] = base::conv($data[$i][12]);
			$goodsinfo[$i-2]['shopprice'] = base::conv($data[$i][13]);
			$goodsinfo[$i-2]['marketprice'] = base::conv($data[$i][14]);
			$goodsinfo[$i-2]['inprice'] = base::conv($data[$i][15]);
			$goodsinfo[$i-2]['goodscount'] = base::conv($data[$i][22]);
			$goodsinfo[$i-2]['currentcount'] = base::conv($data[$i][23]);
			$goodsinfo[$i-2]['state'] = base::conv($data[$i][24]);
			
			$attribute[$i-2]['material'] = base::conv($data[$i][6]);
			$attribute[$i-2]['bolus'] = base::conv($data[$i][7]);
			$attribute[$i-2]['ratio'] = base::conv($data[$i][8]);
			$attribute[$i-2]['weight'] = base::conv($data[$i][9]);
			$attribute[$i-2]['size'] = base::conv($data[$i][10]);
			$attribute[$i-2]['color'] = base::conv($data[$i][11]);
			
			$supplier[$i-2]['sname'] = base::conv($data[$i][16]);
			$supplier[$i-2]['saddr'] = base::conv($data[$i][17]);
			$supplier[$i-2]['con_way'] = base::conv($data[$i][18]);
			$supplier[$i-2]['con_man'] = base::conv($data[$i][19]);
			$supplier[$i-2]['remark'] = base::conv($data[$i][20]);
			$supplier[$i-2]['other'] = base::conv($data[$i][21]);
			
			$brand[$i-2]['bname'] = base::conv($data[$i][5]);
		}
		$sid = 0;
		$aids = array();
		for($i=0;$i<count($cids);$i++){
			$aids[] = Attributes::AddKey($cids[$i]->id,0,'尺寸','',0);
			$aids[] = Attributes::AddKey($cids[$i]->id,0,'产品材质','',0);
			$aids[] = Attributes::AddKey($cids[$i]->id,0,'主要填充物','',0);
			$aids[] = Attributes::AddKey($cids[$i]->id,0,'实物比例','',0);
			$aids[] = Attributes::AddKey($cids[$i]->id,0,'重量','',0);
			$aids[] = Attributes::AddKey($cids[$i]->id,0,'颜色','',0);
		}
		
		for($i=0;$i<count($goodsinfo);$i++){
			if($goodsinfo[$i]['goodsname']!=''){

				if($sup = supply::CheckSupplier($supplier[$i]['sname'])){
					$sid = $sup->id;
				}else{
					supply::setSupply(null,$supplier[$i]['sname'],$supplier[$i]['saddr'],$supplier[$i]['con_way'],$supplier[$i]['con_man'],$supplier[$i]['remark']);
					$sid = base::getInsertId();
				}
				
				if($br=Brands::CheckBrand($brand[$i]['bname'])){
					$bid = $br->id;
				}else{
					$bid = Brands::AddBrand($brand[$i]['bname']);
				}
				//echo $goodsinfo[$i]['goodsname'].'==goodsname=='.$bid.'==bid=='.$goodsinfo[$i]['goods_sn'].'==goods_sn=='.$sid.'==sid=='.$goodsinfo[$i]['netweight'].'==netweight=='.$goodsinfo[$i]['des'].'==des=='.$goodsinfo[$i]['shopprice'].'==shopprice=='.$goodsinfo[$i]['marketprice'].'==marketprice=='.$goodsinfo[$i]['inprice'].'==inpirce=='.$goodsinfo[$i]['currentcount'].'==currentcount=='.$goodsinfo[$i]['state'].'==state=='.$goodsinfo[$i]['picurl'];
				
				$gid = self::Adds($goodsinfo[$i]['goodsname'],$bid,$goodsinfo[$i]['goods_sn'],$sid,$goodsinfo[$i]['weight'],$goodsinfo[$i]['des'],$goodsinfo[$i]['shopprice'],$goodsinfo[$i]['marketprice'],$goodsinfo[$i]['inprice'],$goodsinfo[$i]['currentcount'],$goodsinfo[$i]['state'],$goodsinfo[$i]['picurl']);
				
				for($j=0;$j<count($cids);$j++){
					self::AddGoodsCatetory($gid,$cids[$j]->id,0);
					self::AddAttributeValue($aids[$j],$gid,$attribute[$i]['material'],0,0);
					self::AddAttributeValue($aids[$j],$gid,$attribute[$i]['bolus'],0,0);
					self::AddAttributeValue($aids[$j],$gid,$attribute[$i]['ratio'],0,0);
					self::AddAttributeValue($aids[$j],$gid,$attribute[$i]['weight'],0,0);
					self::AddAttributeValue($aids[$j],$gid,$attribute[$i]['size'],0,0);
					self::AddAttributeValue($aids[$j],$gid,$attribute[$i]['color'],0,0);
				}
			}
		}
		
//		for($i=2;$i<count($data)-2;$i++){
//			$goodsinfo[$i-2]['picurl'] = base::conv($data[$i][1]);
//			$goodsinfo[$i-2]['goodsname'] = base::conv($data[$i][2]);
//			$goodsinfo[$i-2]['goods_sn'] = base::conv($data[$i][3]);
//			$goodsinfo[$i-2]['weight'] = base::conv($data[$i][6]);
//			$goodsinfo[$i-2]['netweight'] = base::conv($data[$i][7]);
//			$goodsinfo[$i-2]['des'] = base::conv($data[$i][9]);
//			$goodsinfo[$i-2]['shopprice'] = base::conv($data[$i][10]);
//			$goodsinfo[$i-2]['marketprice'] = base::conv($data[$i][11]);
//			$goodsinfo[$i-2]['inprice'] = base::conv($data[$i][12]);
//			$goodsinfo[$i-2]['goodscount'] = base::conv($data[$i][19]);
//			$goodsinfo[$i-2]['currentcount'] = base::conv($data[$i][20]);
//			$goodsinfo[$i-2]['state'] = base::conv($data[$i][21]);
//			
//			$attribute[$i-2]['material'] = base::conv($data[$i][4]);
//			$attribute[$i-2]['bolus'] = base::conv($data[$i][5]);
//			$attribute[$i-2]['size'] = base::conv($data[$i][8]);
//			
//			$supplier[$i-2]['sname'] = base::conv($data[$i][13]);
//			$supplier[$i-2]['saddr'] = base::conv($data[$i][14]);
//			$supplier[$i-2]['con_way'] = base::conv($data[$i][15]);
//			$supplier[$i-2]['con_man'] = base::conv($data[$i][16]);
//			$supplier[$i-2]['remark'] = base::conv($data[$i][17]);
//			$supplier[$i-2]['other'] = base::conv($data[$i][18]);
//		}
		//print_r($supplier);
		//print_r($goodsinfo);
		//echo '===========================================';
		//print_r($attribute);
		//echo '==============================================';
		//print_r($supplier);
	}
	
	/*
	 * 导入商品分类csv
	*/
	public static function ImportCategory($filename){
		require_once PRO_ROOT.'include/base.class.php';
		require_once PRO_ROOT.'include/categorys.class.php';
		
		$data = base::ParseCSV($filename);
		
		$parentid = 0;
		$parentsid = 0;
		for($i=1;$i<=count($data);$i++){	
			$pid = 0;
			for($j=0;$j<count($data[$i]);$j++){
				if(base::conv($data[$i][0])&& base::conv($data[$i][1])){
					if($j==0){
						$pid = Categorys::Add(base::conv($data[$i][$j]),$pid,$j);
						$parentid = $pid;
					}else{
						if($j==1){
							$pid = Categorys::Add(base::conv($data[$i][$j]),$pid,$j);
							$parentsid = $pid;
						}else{
							$pid = Categorys::Add(base::conv($data[$i][$j]),$pid,$j);
						}
					}
				}else if(!base::conv($data[$i][0])&& base::conv($data[$i][1])){
					if($j==1){
						$pid = Categorys::Add(base::conv($data[$i][$j]),$parentid,$j);
						$parentsid = $pid;
					}
					if($j==2){
						$pid = Categorys::Add(base::conv($data[$i][$j]),$pid,$j);
					}
				}else if(!base::conv($data[$i][0])&& !base::conv($data[$i][1])){
					if($j==2&&base::conv($data[$i][$j])){
						$pid = Categorys::Add(base::conv($data[$i][$j]),$parentsid,$j);
					}
				}
			}
		}
		
	}
	
	/*
	 * 获得前台商品详细页要显示的数据
	*/
	public static function GetFrontData($gid){
		require_once PRO_ROOT.'include/attributes.class.php';
		require_once PRO_ROOT.'include/goodsfront.class.php';
		require_once PRO_ROOT.'include/base.class.php';
		//通过gid获取商品的最后一个分类id
		$cids = self::GetCatesByGid($gid);
		$cidarr = array();
		for($i=0;$i<count($cids);$i++){
			$cidarr[] = $cids[$i]['categoryid'];
		}
		for($i=0;$i<count($cidarr);$i++){
			for($j=0;$j<count($cidarr);$j++){
				if($cidarr[$j]<$cidarr[$j+1]){
					$temp = $cidarr[$j];
					$cidarr[$j] = $cidarr[$j+1];
					$cidarr[$j+1] = $temp;
				}
			}
		}

		$goods = Ware::GetOne($gid);
		//获取导航
		$navigation = goodsfront::GetNavigation($cidarr[0],$goods->goodsname);
		
		$goodspic = self::GetGoodsPic($gid);
		$goodspicarr = array();
		for($i=0;$i<count($goodspic);$i++){
			$goodspicarr[] = $goodspic[$i]['apath'].$goodspic[$i]['filename'].'.'.$goodspic[$i]['atype'];
		}
		$piclist = GoodsFront::GetListImg(42,$goodspicarr);
		$pic350 = GoodsFront::GetListImg(350,$goodspicarr);
		$pic600 = GoodsFront::GetListImg(600,$goodspicarr);
		
		$attribute = Attributes::GetAttrRelateByGid($gid,$cidarr[0]);
		//$relategoods = self::GetRelateGoodsInfoLim($gid,0,5);
		$relategoods = self::GetRelateGoodsInfoLim($gid,0,5);
		//获取可能喜欢的商品
		$goodstabs = GoodsFront::GetGoodsByTab($gid);
		$favorgoods = array();
		$favorgoodsarr = array();
		for($i=0;$i<count($goodstabs);$i++){
			$favorgoodstmp = GoodsFront::GetGoodsByTabs($goodstabs[$i]['bid']);
			for($j=0;$j<count($favorgoodstmp);$j++){
				$favorgoods[] = $favorgoodstmp[$i];
			}
		}
		//print_r($favorgoods);
		$favorgoods = array_unique($favorgoods);
		foreach ($favorgoods as $f){
			$favorgoodsarr[] = $f;
		}
		
		//获取关联商品的 属性 的显示		
		$relateattrs = GoodsFront::GetRelateAttr($attribute);
		
		//获取不关联商品的属性
		$normalattr = Attributes::GetAttrByGid($gid,$cidarr[0]);
		
		
		//获取商品的详细描述
		$goodsext = self::GetGoodsExt($gid);
		
		$detail = array(
			'navigation'=>$navigation,
			'goods'=>$goods,
			'goodsthumb'=>$piclist,
			'pic350'=>$pic350,
			'pic600'=>$pic600,
			'goodspics'=>$goodspicarr,
			'attribute'=>$relateattrs,
			'relategoods'=>$relategoods,
			'normalattr'=>$normalattr,
			'favorgoods'=>$favorgoodsarr,
			'goodsext'=>$goodsext->description,
		);
		return $detail;
	}
	
	/*
	 * 生成静态
	*/
	public static function MakeStaticHtml($gid){
		$detail = self::getfrontdata($gid);
		base::makeHtml('goodsdetail',$detail,'default/admin/goods','html/goods/'.$gid.'.html');
	}
}
?>