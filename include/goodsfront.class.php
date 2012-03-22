<?php

/*
 * author:wsh
 * date:20100628
 * 对前台的列表页和详细页的调用的方法的封装
 * 
*/

if (!defined("PRO_ROOT")) {
	exit();
}
require_once PRO_ROOT .'models.php';

class GoodsFront{
	
	protected static $currentsql = '';
	
	/*
	 * 获取商品数量
	*/
	public static function GetGoodsCount(){
		global $db;
		try{
			$stm = $db->query(self::$currentsql);
			return $stm->rowCount();
		}catch(DZGException $e){
			return 0;
		}
	}
	
	/*
	 * 获取商品列表的数据（品牌）
	*/
	public static function GetGoodsListDataB($bid,$wid,$sort,$sortflag='DESC'){
		$sql = "SELECT * FROM goods WHERE ";
		if($bid){
			$sql .= "bid=".$bid;
		}else{
			$sql .= "wid=".$wid;
		}
		switch($sort){
			case 1:
				$sql .= " ORDER BY shopprice ".$sortflag;
				break;
			case 2:
				$sql .= " ORDER BY salecount DESC";
				break;
			case 3:
				$sql .= " ORDER BY onsaletime DESC";
				break;
		}
		try{
			return goods::objects()->pageFilter('','',2,$sql);
		}catch(DZGException $e){
			return false;
		}
	}
	
	/*
	 * 获取商品列表的数据
	*/
	public static function GetGoodsListData($cid,$sort,$sortflag='DESC'){
		$sql = "SELECT * FROM goods as g INNER JOIN goodscategory as gc ON g.id=gc.goodsid WHERE gc.categoryid=".$cid." AND g.isonsale>0";
		switch($sort){
			case 1:
				$sql .= " ORDER BY shopprice ".$sortflag;
				break;
			case 2:
				$sql .= " ORDER BY salecount DESC";
				break;
			case 3:
				$sql .= " ORDER BY onsaletime DESC";
				break;
			case 4:
				$sql .= " ORDER BY commentrate,commentcount DESC";
				break;
		}
		self::$currentsql = $sql;
		//echo $sql;
		try{
			return goods::objects()->pageFilter('','',2,$sql);
		}catch(DZGException $e){
			return false;
		}
	}
		
	/*
	 * 获取属性表连接的语句
	*/
	public static function GetINNERJOIN($attr){
		require_once PRO_ROOT.'include/attributes.class.php';
		
		$keys = array(0=>'a',1=>'b',2=>'c',3=>'d',4=>'e',5=>'f',6=>'g',7=>'h',8=>'j',9=>'k',10=>'l');
		$newattr = array();
		$innerstr = '';
		$wherestr = '';
		$newattr = explode('_',$attr);
		//属性值的数组
		$avarr = array();
		
		for($i=0;$i<count($newattr);$i++){
			$tmp = explode(',',$newattr[$i]);
			if($tmp[0]){
				$attrtmp = Attributes::GetKey($tmp[0]);
				$attrvaluetmpe = explode(',',$attrtmp->attributevalue);
				$avarr[] = $attrvaluetmpe[$tmp[1]];
			}
		}
		
		if(count($avarr)==1&&!count($avarr)){
			$innerstr = " INNER JOIN attribute_value ".$keys[0]." ON ak.id=".$keys[0].".aid INNER JOIN goods g ON g.id=".$keys[0].".goodsid";
			$wherestr = " AND ".$keys[0].".attributevalue='".$avarr[0]."' AND g.isonsale>0 GROUP BY ".$keys[0].".goodsid";
		}
		else{
			$innerstr = " INNER JOIN attribute_value ".$keys[0]." ON ak.id=".$keys[0].".aid INNER JOIN goods g ON g.id=".$keys[0].".goodsid";
			for($i=0;$i<count($avarr);$i++){
				if($i>0){
					$innerstr .= " INNER JOIN attribute_value ".$keys[$i]." ON ".$keys[0].".goodsid=".$keys[$i].".goodsid";
				}
				$wherestr .= " AND ".$keys[$i].".attributevalue='".$avarr[$i]."'";
			}
			$wherestr .= " AND g.isonsale>0 GROUP BY ".$keys[0].".goodsid";
		}
		return array($innerstr,$wherestr);
	}
	
	/*
	 * 获取属性下的商品列表的数据
	*/
	public static function GetGoodsListDataA($cid,$sort,$attr=array(),$sortflag='DESC'){
		$joinwhere = self::GetINNERJOIN($attr);
		//$sql = "SELECT * FROM attribute_key ak INNER JOIN  attribute_value a ON ak.id=a.aid INNER JOIN goods g ON g.id=a.goodsid ".$joinwhere[0]." WHERE ak.cid=".$cid.$joinwhere[1];
		$sql = "SELECT * FROM attribute_key ak ".$joinwhere[0]." WHERE ak.cid=".$cid.$joinwhere[1];
		switch($sort){
			case 1:
				$sql .= " ORDER BY shopprice ".$sortflag;
				break;
			case 2:
				$sql .= " ORDER BY salecount DESC";
				break;
			case 3:
				$sql .= " ORDER BY onsaletime DESC";
				break;
			case 4:
				$sql .= " ORDER BY commentrate,commentcount DESC";
				break;
		}
		//echo $sql;
		self::$currentsql = $sql;
		//echo $sql;
		try{
			return goods::objects()->pageFilter('','',2,$sql);
		}catch(DZGException $e){
			return false;
		}
	}
	
	/*
	 * 获取全部的分类
	*/
	public static function GetCateAll(){
		try{
			$cates = category::objects()->all();
		}catch(DZGException $e){
			return false;
		}
		return $cates;
	}
	
	/*
	 * 静态重写的url获取
	 * @param string $type 执行的页面，比如是商品页面，文章页面
	 * @param array $params 传过来页面的参数,比如分类id，商品id
	 * @param array $arr 页面中的其他参数
	 * @param string $keyword 查询的关键字
	*/
	public static function GetUrl($type,$params=array(),$arr=array(),$keyword=''){
		$idarr = array(
			'gid'=>0,
			'cid'=>0,
			'bid'=>0,
			'aid'=>0,
			'cmid'=>0,
		);
		
		$attr = array(
			'page'=>1,
			'sort'=>1,
			'sortflag'=>1,	
			'attr'=>'0,0_0,0_0,0_0,0_0,0_0,0_0,0_0,0_0,0_0,0',
			'tab'=>0,
		);
		
		$url = '';
		extract(array_merge($idarr,$params));
		extract(array_merge($attr,$arr));
		$i=0;
		//获取伪静态的路径
		define('REWRITE',1);
		if(REWRITE){
			switch($type){
				case 'category':
					$url = "http://".$_SERVER['HTTP_HOST']."/goodslist";
					$url .= "_".$cid;
					$url .= "_".$page;
					$url .= "_".$sort;
					$url .= "_".$sortflag;
					break;
				case 'attribute':
					$url = "http://".$_SERVER['HTTP_HOST']."/goodslista";
					$url .= "_".$cid;
					$url .= "_".$page;
					$url .= "_".$sort;
					$url .= "_".$sortflag;
					$url .= "_".$attr;
					break;
				case 'article':
					$url .= "http://".$_SERVER['HTTP_HOST']."/goodslistb";
					$url .= "_".$sort;
					$url .= "_".$page;
					break;
				case 'brand':
					$url .= "http://".$_SERVER['HTTP_HOST']."/goodslistc";
					$url .= "_".$bid;
					$url .= "_".$page;
					$url .= "_".$sort;
					$url .= "_".$sortflag;
					break;
				case 'works':
					$url .= "http://".$_SERVER['HTTP_HOST']."/workslist";
					$url .= "_".$wid;
					$url .= "_".$page;
					$url .= "_".$sort;
					$url .= "_".$sortflag;
					break;
				case 'comment':
					$url .= "http://".$_SERVER['HTTP_HOST']."/commentlist";
					$url .= "_".$gid;
					$url .= "_".$tab;
					$url .= "_".$page;
					break;
				case 'reply':
					$url .= "http://".$_SERVER['HTTP_HOST']."/replylist";
					$url .= "_".$cmid;
					$url .= "_".$gid;
					break;
				case 'zq':
					$url .= "http://".$_SERVER['HTTP_HOST']."/zqlist";
					$url .= "_".$gid;
					$url .= "_".$tab;
					$url .= "_".$page;
					break;
				case 'cart':
					$url .= "http://".$_SERVER['HTTP_HOST']."/cart";
					//$url .= "_".$gid;
					//$url .= "_".$loca;
					break;
				case 'myindex':
					$url .= "http://".$_SERVER['HTTP_HOST']."/my/index";
					break;
				case 'index':
					$url .= "http://".$_SERVER['HTTP_HOST']."/index";
					break;
				case 'login':
					$url .= "http://".$_SERVER['HTTP_HOST']."/login"; 
					$url .= "_".$ref;
					break;
				case 'reg':
					$url .= "http://".$_SERVER['HTTP_HOST']."/reg";
					$url .= "_".$ref;
					break;
			}
			$url .= ".html";
		}else{
			switch($type){
				case 'category':
					$url = URL."index.php/front/goodsfront/goodslist?cid=".$cid."&page=".$page."&sort=".$sort."&sortflag=".$sortflag;
					break;
				case 'attribute':
					break;
				case 'acticle':
					$url = URL."index.php/front/article/articleList?sort=".$sort."&page=".$page;
					break;
				case 'brand':
					$url = URL."index.php/front/goodsfront/goodslist?bid=".$bid."page=".$page."&sort=".$sort."&sortflag=".$sortflag;
				case 'works':
					$url = URL."index.php/front/goodsfront/goodslist?bid=".$wid."page=".$page."&sort=".$sort."&sortflag=".$sortflag;
					break;
				case 'comment':
					$url = URL."index.php/front/usercomment/ucommentShow?gid=".$gid."&tab=".$tab."&page=".$page;
					break;
				case 'reply':
					$url = URL."index.php/front/usercomment/comment_replyAdd?gid=".$gid."cmid=".$cmid;
					break;
				case 'zq':
					$url = URL."index.php/front/question/questionlist?gid=".$gid."&tab=".$tab."&page=".$page;
					break;
				case 'cart':
					//$url = URL."index.php/front/cart/cartInsert?gid=".$gid."&loca=".$loca;
					$url = URL."index.php/front/cartInsert";
					break;
				case 'myindex':
					$url = URL."index.php/front/user/index";
				case 'index':
					$url = URL."index.php";
					break;
				case 'login':
					$url = URL."index.php/front/user/userLogin?ref=".$ref;
					break;
				case 'reg':
					$url = URL."index.php/front/user/userReg?ref=".$ref;
					break;
			}
		}
		
		//获取静态的路径
		define('CREATESTATIC',1);
		if(CREATESTATIC){
			switch($type){
				case 'goods':
					$url = URL."html/goods/".$gid.".html";
					break;
				case 'article':
					break;
			}
		}else{
			switch($type){
				case 'goods':
					$url = URL."index.php/front/goodsfront/goodsdetail?gid=".$gid;
					break;
				case 'article':
					break;
			}
		}
		
		return $url;
	}
	
	/*
	 * 获取页面的导航品牌列表
	*/
	public static function GetNavigationB($bid,$wid){
		$str = "<a href='".self::GetUrl('index',array(),array())."'>首页 </a>";
		if($bid){
			$brand = tag::objects()->get('id='.$bid);
			$str .= "&gt; ".$brand->bname;
		}else{
			$works = works::objects()->get('id='.$wid);
			$str .= "&gt; ".$works->wname;
		}
	}
	
	/*
	 * 获取页面的导航
	 * @param int $lastid 分类id
	 * @param string $goodsname 商品名称
	*/
	public static function GetNavigation($lastcid,$goodsname='',$gid=0){
		$cates = self::GetCateAll();//所有分类
		$lastcid = $lastcid;
		
		$catearr = array();
		$index = 0;
	
		$filename = substr($cur_url,0,-4);
		while(1){
			foreach($cates as $c){
				if($lastcid == $c->id){
					$lastcid = $c->parentid;
					
					$catearr[$index]['cid'] = $c->id;
					$catearr[$index]['categoryname'] = $c->categoryname;
					
					$index++;
					break;
				}
			}
			if($index==0||$lastcid==0){
				break;
			}
		}
		krsort($catearr);
		
		$str = "<a href='".self::GetUrl('index',array(),array())."'>首页 </a>";
		foreach($catearr as $cs){
			$args = array('cid'=>$cs['cid']);
			$arr = array('sort'=>1,'sortflag'=>1,'page'=>1);
			$str .= "&gt; <a href='".self::GetUrl('category',$args,$arr)."'>".$cs['categoryname']."</a>";
		}
		if($goodsname!=''){
			$str .= "&gt; <a href='".self::GetUrl('goods',array('gid'=>$gid))."'>".$goodsname."</a>";
		}

		return $str;
	}
	
	/*
	*获取根级分类,根据goodsid
	*/
	public static function GetLastCate($gid){
		$where="goodsid='$gid'";
		$manager = goodscategory::objects()->filter($where,'categoryid desc');
		$lastcid=$manager[0]->categoryid;
		return $lastcid;
	}
	
	/*
	 * 获取页面的分类的显示
	*/
	public static function GetCateNavi($cid,$attr='0,0_0,0_0,0_0,0_0,0_0,0_0,0_0,0_0,0_0,0'){
		require_once PRO_ROOT.'include/categorys.class.php';
		require_once PRO_ROOT.'include/attributes.class.php';
		$str = '';
		//$cates = self::GetCategory($cid);
		$cates = Categorys::GetByPid($cid);
		$cate = Categorys::GetByCid($cid);
		
		
		if(empty($cates)){
			$newattr = explode('_',$attr);
			
			$attrites = Attributes::GetKeyByCid($cid);	
			$attvalues = array();
			$str .= "<div class='sx'>
      			<ul class='good_sx'>
       			 <li><span class='fn_red fn_14px b p7'>".$cate->categoryname." </span>- 商品筛选</li>";
			for($j=0;$j<count($attrites);$j++){
				$str .="<li><span class='b'>".$attrites[$j]['attributename']."：</span>";
				if($attrites[$j]['attributevalue']!=''){
					$attvalues[$j] = explode(',',$attrites[$j]['attributevalue']);
        			for($k=0;$k<count($attvalues[$j]);$k++){
        				$args = array('cid'=>$cid);
        				$tmpattr = $newattr; 
        				$tmpattr[$j] = $attrites[$j]['id'].','.$k;
        				$attrsstr = implode('_',$tmpattr);
        				$arr = array('sort'=>1,'sortflag'=>1,'page'=>1,'attr'=>$attrsstr);
        				unset($attrsstr);
        				unset($tmpattr);
        				$str .= "<a href='".self::GetUrl('attribute',$args,$arr)."'>".$attvalues[$j][$k]."</a>";
        			}
				}
        		$str .="</li>";
			}
	  		$str .= "</ul>
    		</div>";
		}else{
		
			$str .= "<div class='sx'>
			  <ul class='good_sx'>
			    <li><span class='fn_red fn_14px b p7'>".$cate->categoryname." </span>- 选择分类 </li>
				  <li class='un_border'><span class='b'>分类名称：</span>
			  ";
			foreach($cates as $cs){
				$args = array('cid'=>$cs['id']);
				$arr = array('sort'=>1,'sortflag'=>1,'page'=>1);
				$str .= "<a href='".self::GetUrl('category',$args,$arr)."'>".$cs['categoryname']."</a>";
				//$str .= "<li><a style='text-decoration:none;float:left;' href='".self::GetUrl('category',$args)."'>".$cs['categoryname']."</a></li>";
			}	
			  $str .= "</li></ul>
			</div>";
		}
		return $str;
	}
	
	/*
	 * 创建浏览过的商品的查询条件
	*/
	public static function GetWhere($goodslist,$gid='id'){
		$sqlin = '';
		if($goodslist==''){
			return $gid." IN('') ";
		}else{
			if(!is_array($goodslist)){
				$goodsidarr = explode(',',$goodslist);
			}
			
			$goodsidarr = array_unique($goodsidarr);
			if(!empty($goodsidarr)){
				foreach($goodsidarr as $goodsid){
					if($goodsid!=''){
						$sqlin .= $sqlin ? ','.$goodsid : $goodsid;
					}
				}
				return $gid." IN(".$sqlin.") ";
			}else{
				return $gid." IN('') ";
			}
		}
	}
	
	/*
	 * 获取浏览过的商品
	*/
	public static function GetViewed($goodslist,$gid){
		$condition = self::GetWhere($goodslist,$gid)." AND isonsale!=0";
		$goods = goods::objects()->filter($condition);
		$str = "<div class='yc_nei'>";
		if($goods){
			for($i=0;$i<count($goods);$i++){
				$viewedpic = self::GetChangeImg(61,$goods[$i]->imgcurrent);
				$str .= "<ul><li><div class='img2'><a href='".self::GetUrl('goods',array('gid'=>$goods[$i]->id))."'><img width='61' height='61' src='".URL.$viewedpic."' /></div><h3 class='fn_hs'><a href='".self::GetUrl('goods',array('gid'=>$goods[$i]->id))."'>".$goods[$i]->goodsname."</a></h3><h4 class='s'>￥".$goods[$i]->marketprice."</h4><h4 class='m2'>￥".$goods[$i]->shopprice." </h4></li>";
			}
		}else{
			$str .= "<span style='font-weight:bold;margin:auto;'>暂无浏览记录</span>";
		}
		$str .= "</div>";
		return $str;
	}
	
	/*
	 * 过滤多表联合查询属性的值，虑掉重复的数据
	*/
	public static function getValue($checkArr,$kid){
		if(in_array($kid,$checkArr)){
			return true;
		}
		return false;
	}
	
	/*
	 * 获取咨询数量
	*/
	public static function GetZQCount($where){
		global $db;
		$sql = "SELECT id FROM question WHERE ".$where;
		try{
			$stm = $db->query($sql);
			return $stm->rowCount();
		}catch(DZGException $e){
			return 0;
		}
	}
	
	/*
	 * 获取咨询前5条
	*/
	public static function GetZQ($where){
		try{
			return question::objects()->filter($where,"questiontime DESC",0,5);
		}catch(DZGException $e){
			return false;
		}
	}
	
	/*
	 * 获取商品内容页 的咨询
	*/
	public static function GetZQList($where,$gid){
		$str = '';
		$zq = self::GetZQ($where);
		$zqcount = self::GetZQCount($where);
		
		$str .="<table width='98%' border='0' align='center' cellpadding='5' cellspacing='0' class='ly'>";
		for($i=0;$i<count($zq);$i++){
		$str .="
        <tr class='tr'>
          <td width='6%' valign='top'><span class='b'>提问：</span></td>
          <td width='62%'>".$zq[$i]->content." </td>
          <td width='13%' align='center' valign='top'><span class='fn_red b'>".$zq[$i]->uname."</span></td>
          <td width='19%' valign='top'><span class='fn_hs'>发表于 ".date("Y-m-d H:i:s",$zq[$i]->questiontime)."</span></td>
        </tr>";
			if($zq[$i]->reply!=""){
	        	$str .="
	        <tr class='tr'>
	          <td valign='top'><span class='fn_red b'>回复：</span></td>
	          <td colspan='2'><span class='fn_red'>".$zq[$i]->reply."</span></td>
	          <td valign='top'><span class='fn_hs'>发表于 ".date("Y-m-d H:i:s",$zq[$i]->replytime)."</span></td>
	        </tr>
	        <tr>
	          <td colspan='4'>您对我们的回复： <span class='fn_blue'>满意</span> (0)   <span class='fn_blue'>不满意</span> (0) </td>
	        </tr>";
			}
        }
        
        $str .= "<tr>
        	<td colspan='2'><span style='font-weight:bold;'>共有咨询".$zqcount." 条</span></td>
        	<td><a href='".self::GetUrl('zq',array('gid'=>$gid),array('tab'=>0,'page'=>1))."'>查看全部咨询 >></a></td>
        	<td></td>
        </tr>";
        $str .="</table>";
        return $str;
	}
	
	/*
	 * 获取关联商品的属性
	*/
	public static function GetRelateAttr($attribute){
		require_once PRO_ROOT.'include/goods.class.php';
		$checkArr = array();
		$str = '';
		$attrstr = '';
		for($i=0;$i<count($attribute);$i++){
			if($attribute[$i]['isrelate']){
				if(!self::getValue($checkArr,$attribute[$i]['kid'])){
					$checkArr[] = $attribute[$i]['kid'];
					$str .= '-'.$attribute[$i]['aname'].','.$attribute[$i]['vvalue'].".".$attribute[$i]['relategoods'];
				}else{
					$str .= ','.$attribute[$i]['vvalue'].'.'.$attribute[$i]['relategoods'];
				}
			}
		}
		$relateattrarr = explode('-',$str);
		$relateattrs = array();
		for($i=0;$i<count($relateattrarr);$i++){
			$relateattrs[$i] = explode(',',$relateattrarr[$i]);
		}
		if($relateattrs[0][0]!=""){
		for($i=0;$i<count($relateattrs);$i++){

			$attrstr .= "<div class='col'><div class='bt'>".$relateattrs[$i][0]."：</div>";

			if($relateattrs[$i][0]=='颜色'){
				$attrstr .= "<ul>";
				for($j=1;$j<count($relateattrs[$i]);$j++){
					$tmp = explode('.',$relateattrs[$i][$j]);
					$goodspic = Ware::GetOne($tmp[1]);
					$attrpic = self::GetChangeImg(42,$goodspic->imgcurrent);
					$attrstr .= "<li><a href='".self::GetUrl('goods',array('gid'=>$tmp[1]))."'>".$tmp[0]."</a><img src='".URL.$attrpic."' height='80' width='80'/></li>";
				}
				$attrstr .= "</ul>";
			}else{
				$attrstr .= "<ul>";
				for($j=1;$j<count($relateattrs[$i]);$j++){
					$tmp = explode('.',$relateattrs[$i][$j]);
					$attrstr .= "<li><a href='".self::GetUrl('goods',array('gid'=>$tmp[1]))."'>".$tmp[0]."</a></li>";
				}
				$attrstr .= "</ul>";
			}
			$attrstr .= "</div><div class='clear'></div>";
		}
		}
		return $attrstr;
	}
	
	/*
	 * 转换图片的路径(把原图路径加上缩略图的数字)
	*/
	public static function GetChangeImg($num,$path){
		$patharr = explode('/',$path);
		$pathsuffix = $patharr[count($patharr)-1];
		$pathsuffixarr = explode('.',$pathsuffix);
		$pathsuffixarr [count($pathsuffixarr)-2] = $pathsuffixarr [count($pathsuffixarr)-2].'_'.$num;
		$patharr[count($patharr)-1] = implode('.',$pathsuffixarr);
		return implode('/',$patharr);
	}
	
	/*
	 * 获取商品显示的大图
	*/
	public static function GetCurrentImg($num,$path){
		return self::GetChangeImg($num,$path);
	}
	
	/*
	 * 获取商品显示的小图裂表
	*/
	public static function GetListImg($num,$patharr){
		$picpaths = array();
		for($i=0;$i<count($patharr);$i++){
			$picpaths[] = self::GetChangeImg($num,$patharr[$i]);
		}
		return $picpaths;
	}
	
	/*
	 * 获取同一个商品所属的标签
	*/
	public static function GetGoodsByTab($gid){
		global $db;
		$sql = "SELECT * FROM goodsbrand WHERE gid=".$gid;
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
	 * 获得多个标签下的商品
	*/
	public static function GetGoodsByTabs($bid){
		global $db;
		$sql = "SELECT * FROM goods AS g INNER JOIN goodsbrand AS gb ON g.id=gb.gid WHERE gb.bid=".$bid;
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
	 * 获取评价列表的tab
	*/
	public static function GetGoodsListTab($cid,$page=1,$sortflag=1,$attr='0,0_0,0_0,0_0,0_0,0_0,0_0,0_0,0_0,0_0,0',$bid=0,$wid=0){
		$args = array('cid'=>$cid,'bid'=>$bid,'wid'=>$wid);
		if($sortflag==1){
			$sortflag = 2;
		}else{
			$sortflag = 1;
		}
		$str = '';
		if($attr=='0,0_0,0_0,0_0,0_0,0_0,0_0,0_0,0_0,0_0,0'){
			$str .= "
			 <a href='".self::GetUrl('category',$args,array('sort'=>1,'sortflag'=>$sortflag,'page'=>$page))."'><span id='tb_1'><span></span>价格</span></a>
	         <a href='".self::GetUrl('category',$args,array('sort'=>2,'sortflag'=>$sortflag,'page'=>$page))."'><span id='tb_2'>销量</span></a>
	         <a href='".self::GetUrl('category',$args,array('sort'=>3,'sortflag'=>$sortflag,'page'=>$page))."'><span id='tb_3'>上架时间</span></a>";
	         //<a href='".self::GetUrl('category',$args,array('sort'=>4,'sortflag'=>1,'page'=>$page))."'><span id='tb_4'>评价排序</span></a>";
		}else if($bid||$wid){	
			$tmptype = 'brand';
			if($bid){
				$tmptype = 'brand';
			}else{
				$tmptype = 'works';
			}
			$str .="
			 <a href='".self::GetUrl($tmptype,$args,array('sort'=>1,'sortflag'=>$sortflag,'page'=>$page))."'><span id='tb_1'><span></span>价格</span></a>
	         <a href='".self::GetUrl($tmptype,$args,array('sort'=>2,'sortflag'=>$sortflag,'page'=>$page))."'><span id='tb_2'>销量</span></a>
	         <a href='".self::GetUrl($tmptype,$args,array('sort'=>3,'sortflag'=>$sortflag,'page'=>$page))."'><span id='tb_3'>上架时间</span></a>";
		}else{
			$str .= "
			 <a href='".self::GetUrl('attribute',$args,array('sort'=>1,'sortflag'=>$sortflag,'page'=>$page,'attr'=>$attr))."'><span id='tb_1'><span></span>价格</span></a>
	         <a href='".self::GetUrl('attribute',$args,array('sort'=>2,'sortflag'=>$sortflag,'page'=>$page,'attr'=>$attr))."'><span id='tb_2'>销量</span></a>
	         <a href='".self::GetUrl('attribute',$args,array('sort'=>3,'sortflag'=>$sortflag,'page'=>$page,'attr'=>$attr))."'><span id='tb_3'>上架时间</span></a>";
		}
		return $str;
	}
	
	/*
	 * 用于获取列表中的商品
	*/
	public static function GetGoods($type,$pager){
		$str = '';
		$str .= "<ul class='list_ul'>";
		$goodslist = $pager->objectList();
		//print_r($goodslist);
			for($i=0;$i<count($goodslist);$i++){
				$str .="
		         <li>
		           <div class='img'><a href='".self::GetUrl($type,array('gid'=>$goodslist[$i]->goodsid))."'><img width='149' height='149' src='".$goodslist[$i]->imgcurrent."'/></a></div>
		           <div class='g_name fn_14px'><a href='".self::GetUrl($type,array('gid'=>$goodslist[$i]->goodsid))."'>".$goodslist[$i]->goodsname."</a></div>
		           <div class='pice'><span >漫淘客价</span><span class='m'>￥".$goodslist[$i]->shopprice."</span></div>
		           <div class='pice'><span >市 场 价</span><span class='s'>￥".$goodslist[$i]->marketprice."</span></div>
		           <div class='ord'><span class='sc'><a onclick='collect(".$goodslist[$i]->goodsid.");' href='javascript:void(0);'><img src='".MEDIA_URL."img/front/sc.gif' /></a><span class='gw'><a onclick='cartInert(".$goodslist[$i]->goodsid.");' href='javascript:void(0);' /><img src='".MEDIA_URL."img/front/jrc.gif' /></a></span></span></div>
		         </li>";
			}
        $str .="
       </ul>
       <div class='line clear'></div>
       <div class='fy'>";
        return $str;
	}
	
	/*
	 * 获取商品列表
	*/
	public static function GetGoodsList($cid,$sort,$page,$sortflag='DESC'){
		include_once PRO_ROOT.'include/page.class.php';
		//$str = '';
		$data = self::GetGoodsListData($cid,$sort,$sortflag);
		//$pager = new pagination($data,6,$page);
		$pager = new page($data,6,$page);
		
		$str = self::GetGoods('goods',$pager);
//		$str .= "<ul class='list_ul'>";
//		$goodslist = $pager->objectList();
//		//print_r($goodslist);	
//			for($i=0;$i<count($goodslist);$i++){
//				$str .="
//		         <li>
//		           <div class='img'><a href='".self::GetUrl('goods',array('gid'=>$goodslist[$i]->goodsid))."'><img width='149' height='149' src='".$goodslist[$i]->imgcurrent."'/></a></div>
//		           <div class='g_name fn_14px'><a href='".self::GetUrl('goods',array('gid'=>$goodslist[$i]->goodsid))."'>".$goodslist[$i]->goodsname."</a></div>
//		           <div class='pice'><span >漫淘客价</span><span class='m'>￥".$goodslist[$i]->shopprice."</span></div>
//		           <div class='pice'><span >市 场 价</span><span class='s'>￥".$goodslist[$i]->marketprice."</span></div>
//		           <div class='ord'><span class='sc'><a onclick='collect(".$goodslist[$i]->goodsid.");' href='javascript:void(0);'><img src='".MEDIA_URL."img/front/sc.gif'/></a><span class='gw'><a onclick='cartInert(".$goodslist[$i]->goodsid.");' href='javascript:void(0);'><img src='".MEDIA_URL."img/front/jrc.gif' /></a></span></span></div>
//		         </li>";
//			}
//         $str .="
//       </ul>
//       <div class='line clear'></div>
//       <div class='fy'>";
         
         
        $args = array('cid'=>$cid);
		if($sortflag=='DESC'){
			$flag = 1;
		}else {
			$flag = 2;
		}
        $url = self::GetUrl('category',$args,array('sort'=>$sort,'sortflag'=>$flag,'page'=>$page));
       	if(REWRITE){
	    	$str .= $pager->getPage($url,'category');
       	}else{
       		$str .= $pager->getPage(URL."index.php/front/goodsfront/goodslist?cid=".$cid."&sort=".$sort."&page=".$page."&sortflag=1");
       	}
       	
	    $str .="
	   	<span class='top'><a href='javascript:void(0)'><img src='".MEDIA_URL."img/front/top.gif' /></a></span>";
        $str .= "</div>";
        return $str;
	}
	
	/*
	 * 获取属性下的商品列表
	*/
	public static function GetGoodsListA($cid,$sort,$page,$attr,$sortflag='DESC'){
		include_once PRO_ROOT.'include/page.class.php';
		$data = self::GetGoodsListDataA($cid,$sort,$attr,$sortflag);
		//$str = '';
		//$pager = new pagination($data,1,$page);
		$pager = new page($data,1,$page);
		$str = self::GetGoods('goods',$pager);
//		$str .= "<ul class='list_ul'>";
//		$goodslist = $pager->objectList();
//		//print_r($goodslist);
//			for($i=0;$i<count($goodslist);$i++){
//				$str .="
//		         <li>
//		           <div class='img'><a href='".self::GetUrl('goods',array('gid'=>$goodslist[$i]->goodsid))."'><img width='149' height='149' src='".$goodslist[$i]->imgcurrent."'/></a></div>
//		           <div class='g_name fn_14px'><a href='".self::GetUrl('goods',array('gid'=>$goodslist[$i]->goodsid))."'>".$goodslist[$i]->goodsname."</a></div>
//		           <div class='pice'><span >漫淘客价</span><span class='m'>￥".$goodslist[$i]->shopprice."</span></div>
//		           <div class='pice'><span >市 场 价</span><span class='s'>￥".$goodslist[$i]->marketprice."</span></div>
//		           <div class='ord'><span class='sc'><a onclick='collect(".$goodslist[$i]->goodsid.");' href='javascript:void(0);'><img src='".MEDIA_URL."img/front/sc.gif' /></a><span class='gw'><a onclick='cartInert(".$goodslist[$i]->goodsid.");' href='javascript:void(0);' /><img src='".MEDIA_URL."img/front/jrc.gif' /></a></span></span></div>
//		         </li>";
//			}
//         $str .="
//       </ul>
//       <div class='line clear'></div>
//       <div class='fy'>";
         
         
	   if($sortflag=='DESC'){
	    	$flag = 1;
	   }else{
	   		$flag = 2;
	   }
        $args = array('cid'=>$cid);
        $url = self::GetUrl('attribute',$args,array('sort'=>$sort,'sortflag'=>$flag,'page'=>$page,'attr'=>$attr));
       	if(REWRITE){
	    	$str .= $pager->getPage($url,'attribute');
       	}else{
       		$str .= $pager->getHtml($url);
       	}
       	
	    $str .="
	   	<span class='top'><a href='javascript:void(0)'><img src='".MEDIA_URL."img/front/top.gif' /></a></span>";
        $str .= "</div>";
        return $str;
	}
	
	/*
	 * 获取品牌下的商品
	*/
	public static function GetGoodsListB($bid,$wid,$sort,$page,$sortflag='DESC'){
		include_once PRO_ROOT.'include/page.class.php';
		$data = self::GetGoodsListDataB($bid,$wid,$sort,$sortflag);
		
		//$pager = new pagination($data,1,$page);
		$pager = new page($data,6,$page);
		
		$str = self::GetGoods('goods',$pager);
        
	    if($sortflag=='DESC'){
	    	$flag = 1;
	    }else{
	   		$flag = 2;
	    }
        $args = array('bid'=>$bid,'wid'=>$wid);
        $tmptype = 'brand';
        if($bid){
        	$tmptype = 'brand';
        }else{
        	$tmptype = 'works';
        }
        $url = self::GetUrl($tmptype,$args,array('sort'=>$sort,'sortflag'=>$flag,'page'=>$page));
       	if(REWRITE){
	    	$str .= $pager->getPage($url,$tmptype);
       	}else{
       		$str .= $pager->getHtml($url);
       	}
       	
	    $str .="
	   	<span class='top'><a href='javascript:void(0)'><img src='".MEDIA_URL."img/front/top.gif' /></a></span>";
        $str .= "</div>";
        return $str;
	}
	
}
?>