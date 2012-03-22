<?php
if (!defined("PRO_ROOT")) {
	exit();
}
require_once PRO_ROOT .'models.php';
class Comments{
	
	/*
	 * 获取全部的商品评论的前5条
	*/
	public static function GetComments($where){
		try{
			return comment::objects()->filter($where, 'createtime desc',0,5);
		}catch(DZGException $e){
			return false;
		}
	}
	
	/*
	 * 获取回复5条
	*/
	public static function GetReplys($commentid){
		try{
			return comment_reply::objects()->filter("commentid=".$commentid,"replytime DESC",0,5);
		}catch(DZGException $e){
			return false;
		}
	}
	
	/*
	 * 获取商品评论的5条
	*/
	public static function GoodsComments($where,$gid){
		require_once PRO_ROOT.'include/goodsfront.class.php';
		$str = '';
		$comments = self::GetComments($where);
		$ccount = self::GetCommentCount("goodsid=".$gid);
		$count = self::GetCommentCount($where);
		$str = "<div class='tj'><h3>商品评论 共<span class='fn_blue b'>".$ccount."</span>条 (<a href='".GoodsFront::GetUrl('comment',array('gid'=>$gid),array('tab'=>0,'page'=>1))."'><span class='fn_blue'>查看所有评论</span></a>) </h3>
        <div class='pf'>
          <div class='pf_top'>购买过的顾客评分：</div>
          <div class='pf_too_y'><p><a href='".GoodsFront::GetUrl('comment',array('gid'=>$gid),array('tab'=>0,'page'=>1))."'><span class='fn_14px b'>我要发表评论</span></a> | <a href='".GoodsFront::GetUrl('reg')."'><span class='fn_blue'>马上注册</span></a></p><p class='fn_hs'>请您先以会员身份登录后再进行评论</p></div>
        </div>
        <div id='comments'>";
		
		for($i=0;$i<count($comments);$i++){
			$pic = '';
			switch ($comments[$i]->ulevel){
				case 1:
					$pic = MEDIA_URL."img/front/normalvip.jpg";
					break;
				case 2:
					$pic = MEDIA_URL."img/front/goldvip.jpg";
					break;
				case 3:
					$pic = MEDIA_URL."img/front/diamondvip.jpg";
					break;
			}
			$arrstr = array('cmid'=>$comments[$i]->id,'gid'=>$gid);
			$str .="<div class='pl'>
          	<div class='tou'><img width=62 height=62 src='".$pic."' /><h4 class='fn_red b'>".$comments[$i]->uname."</h4></div>
          	<div class='pl_y'>
            	<p class='fn_s_blue b conect'><a href='".GoodsFront::GetUrl('reply',$arrstr)."'>".$comments[$i]->title."</a></p>
            	<p class='fn_hs sj'><span class='right fn_hs'>[发表于".date('Y',$comments[$i]->createtime)."年".date('m',$comments[$i]->createtime)."月".date('d',$comments[$i]->createtime)."号]</span><span>个人评分</span></p>
            	<p class='' style='margin-bottom:3px;'><span style='font-weight:bold;'>优点：</span>".$comments[$i]->good."</p>
				<p class='' style='margin-bottom:3px;'><span style='font-weight:bold;'>不足：</span>".$comments[$i]->bad."</p>
				<p class='' style='margin-bottom:3px;'><span style='font-weight:bold;'>总结：</span>".$comments[$i]->summary."</p>";
            	
            	$replays = self::GetReplys($comments[$i]->id);
            	$str .="<div style='background:#efefef;'>";
            	$str .= "<div class='hf sj'><span class='right'>有0人认为此评论有用</span><a href='".GoodsFront::GetUrl('reply',$arrstr)."'>回复(".count($replays).")</a></div>";
            	for($j=0;$j<count($replays);$j++){
            		$str .= "<div class='hf sj'><div><span style='color:#3366cc;font-size:14px;'>".$replays[$j]->uname." <span style='color:#8d8d8d;'>回复说：</span></span></div><div>".$replays[$j]->reply."</div></div>";
            	}
            	if(self::getReplyCount($comments[$i]->id)>5){
            		$str .= "<div class='hf sj'><a href='".GoodsFront::GetUrl('reply',$arrstr)."'>查看所有的回复 >></a></div>";
            	}
            	$str .= "</div>";
         	$str .= "</div>
        	</div>";
		}
		$str .= "</div>";
		if($count>5){
			$str .= "<div class='pl'><a href='".GoodsFront::GetUrl('comment',array('gid'=>$gid),array('tab'=>0,'page'=>1))."'>查看所有评论 >></a></div>";
		}
		$str .= "</div>";
		return $str;
	}
	
	/*
	 * 获取全部的商品评论
	*/
	public static function goodscomment($goodsid){
		$page = intval($_GET['page'] );
		$where="goodsid='$goodsid'";
		try{
			$manager = comment::objects()->pageFilter($where, 'createtime desc');
		}catch(Exception $e){
				core::alert('数据库错误');
		}
		$page1 = new pagination($manager, 10, $page); 
		$goodscommentCount=$page1->dataCount;
		foreach($page1->objectList() as $i=>$c){
			$comment[$i]= other::getCommentDetail($c->id);//获取评论及其回复，整合到数组$comment中
		}
		$goodscomment = array('comment'=>$comment,'page1'=>$page1,'goodsid'=>$goodsid,'goodcommentCount'=>$goodcommentCount);
		return $goodscomment;
	}
	
	/*
	 * 获取好评的前5条
	*/
	public static function GoodComment($goodsid){
		$page = intval( $_GET['page'] );
		$goodsid=42;		//$goodsid=$_GET[''];
		$where="goodsid='$goodsid' and score >3";
		try{
			$manager = comment::objects()->pageFilter($where, 'createtime desc');
		}catch(Exception $e){
				core::alert('数据库错误');
		}
		$page1 = new pagination($manager, 10, $page); 
		$goodcommentCount=$page1->dataCount;
		foreach($page1->objectList() as $i=>$c){
			$comment[$i]= other::getCommentDetail($c->id);//获取评论及其回复，整合到数组$comment中
		}
		$goodcomment = array('comment'=>$comment,'page1'=>$page1,'goodsid'=>$goodsid,'goodcommentCount'=>$goodcommentCount);
		return $goodcomment;
	}
	 //获取好评数量
		public static function goodcommentCount($goodsid){
		$goodsid=100;		//$goodsid=$_GET[''];
		$where="goodsid='$goodsid' and score > 3";
		try{
			$manager = comment::objects()->pageFilter($where, 'createtime desc');
		}catch(Exception $e){
				core::alert('数据库错误');
		}
		$page1 = new pagination($manager, 10, $page); 
		$goodcommentCount=$page1->dataCount;
		return $goodcommentCount;
	}

	
	/*
	 * 获取中评的前5条
	*/
	public static function MedComment($goodsid){
		$page = intval( $_GET['page'] );
		$goodsid=42;		//$goodsid=$_GET[''];
		$where="goodsid='$goodsid' and score between 2 and 3";
		try{
			$manager = comment::objects()->pageFilter($where, 'createtime desc');
		}catch(Exception $e){
				core::alert('数据库错误');
		}
		$page1 = new pagination($manager, 10, $page); 
		$normalcommentCount=$page1->dataCount;
		foreach($page1->objectList() as $i=>$c){
			$comment[$i]= other::getCommentDetail($c->id);//获取评论及其回复，整合到数组$comment中
		}
		
		$normalcomment=array('comment'=>$comment,'page1'=>$page1,'normalcommentCount'=>$normalcommentCount,'goodsid'=>$goodsid);
		return $normalcomment;
	}
		//获取中评数量
		public static function normalcommentCount($goodsid){
		$goodsid=100;		//$goodsid=$_GET[''];
		$where="goodsid='$goodsid' and score between 2 and 3";
		try{
			$manager = comment::objects()->pageFilter($where, 'createtime desc');
		}catch(Exception $e){
				core::alert('数据库错误');
		}
		$page1 = new pagination($manager, 10, $page); 
		$normalcommentCount=$page1->dataCount;
		return $normalcommentCount;
	}
	
	/*
	 * 获取差评的前5条
	*/
	public static function BadComment($goodsid){
		$page = intval( $_GET['page'] );
		$goodsid=42;		//$goodsid=$_GET[''];
		$where="goodsid='$goodsid' and score=1";
		try{
			$manager = comment::objects()->pageFilter($where, 'createtime desc');
		}catch(Exception $e){
				core::alert('数据库错误');
		}
		$page1 = new pagination($manager, 10, $page); 
		$badcommentCount=$page1->dataCount;
		
		
		foreach($page1->objectList() as $i=>$c){
			$comment[$i]= other::getCommentDetail($c->id);//获取评论及其回复，整合到数组$comment中
		}
		$badcomment=array('comment'=>$comment,'page1'=>$page1,'badcommentCount'=>$badcommentCount,'goodsid'=>$goodsid);
		return $badcomment;
	}
	//获取差评数量
		public static function badcommentCount($goodsid){
		$goodsid=100;		//$goodsid=$_GET[''];
		$where="goodsid='$goodsid' and score=1";
		try{
			$manager = comment::objects()->pageFilter($where, 'createtime desc');
		}catch(Exception $e){
				core::alert('数据库错误');
		}
		$page1 = new pagination($manager, 10, $page); 
		$badcommentCount=$page1->dataCount;
		return $badcommentCount;
	}
	
	//获取评论的回复条数
	public static function getReplyCount($commentid){
			global $db;
			$sql = "select id from comment_reply where commentid='$commentid' and verify = 1";
			$stmt = $db->query($sql);
    		$crCount = $stmt->rowCount();
			return $crCount;
	
	}
	
	/*
	 * 获取评论的数量
	*/
	public static function GetCommentCount($where){
		global $db;
		$sql = "SELECT id FROM comment WHERE ".$where;
		try{
			$stm = $db->query($sql);
			return $stm->rowCount();
		}catch(DZGException $e){
			return 0;
		}
	}
	
	public static function getGoodsArray($uid){
		$sql="select gooodsorder.gid as gid,orders.orders_sn as orders_sn,goodsorder.mark as mark from goodsorder,orders where orders.uid ='$uid' and orders.id=goodsorder.orderid";
	
	}
	
	
	
}