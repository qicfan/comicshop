<?php
/**
 * 用户评论显示
 * @author mff
 */

header("content-type:text/html; charset=utf-8");
if (!defined("PRO_ROOT")) {
	exit();
}

require_once PRO_ROOT . 'models.php';
require_once DZG_ROOT . 'core/pagination/pagination.php';
require_once PRO_ROOT . 'include/other.class.php';
require_once PRO_ROOT . 'include/base.class.php';
require_once PRO_ROOT . 'include/commentFun.class.php';
require_once PRO_ROOT . 'include/goods.class.php';
require_once PRO_ROOT . 'include/goodsfront.class.php';


class usercommentViews{
	/**
	 * 用户发表评论
	 */
	public static function userComment() {
		$gid = intval( $_GET['gid'] );
		//$gid=120;
		$act = $_GET['act'];
		if ($act != 'submit' || empty($gid)) {
			template('ucommentShow', array('gid'=>$gid), 'default/front/comment');
		}
		$score = intval($_POST['score']);
		$title = base::wordFilter($_POST['title']);
		$bad = base::wordFilter($_POST['bad']);
		$good = base::wordFilter($_POST['good']);
		$summary = base::wordFilter($_POST['summary']);
		if (empty($title) || empty($summary)|| empty($good) || empty($bad) || $score > 5 || $score < 1 ) {
			core::alert('请认真填写评论');
			exit();
		}
		/* Todo：只有购买了商品才能进行评价,并且没有评价过,购买时间未超过半年 */
		auth::authUser();
		$uid = auth::getUserId();
		$uname=auth::getUserName();//添加用户名，便于查询
		usercommentViews::commentTest($uid,$gid);
		$whereu = "uid='$uid'";
		$userLevel = user::objects()->filter($whereu,'');
		$ulevel = $userLevel[0]->member;
		$time = time();
		//数据库
		$comment = new comment();
		$comment->goodsid = $gid;
		$comment->uid=$uid;
		$comment->uname=$uname;
		$comment->ulevel=$ulevel;
		$comment->score = $score;
		$comment->title = $title;
		$comment->ip = $_SERVER['REMOTE_ADDR'];
		$comment->good = $good;
		$comment->bad = $bad;
		$comment->summary = $summary;
		$comment->createtime = $time;
		if ( $comment->save() ) {
			try{
				$where1="id='$gid'";
				$goodsmanager=goods::objects()->filter($where1,'');
				$count=$goodsmanager[0]->commentcount;
				ware::EditCommentCount($gid,$count);
			}catch(Exception $e){
				core::alert('评论失败');
			}
			core::alert('评论完毕');
		} else {
			core::alert('评论失败');
		}
	}



	//商品评论总页面
	public static function ucommentShow(){//需要添加商品信息，GID查询即可
		$page = intval( $_GET['page'] );
		$goodsid = $_GET['gid'];
		$tab = $_GET['tab'];
		$ty=$tab;
		$uname=auth::getUserName();
		switch($tab){
			case 1:	$where="goodsid='$goodsid' and verify = 1 and score >3";
			break;
			case 2:	$where="goodsid='$goodsid' and verify = 1 and score between 2 and 3";
			break;
			case 3:	$where="goodsid='$goodsid' and verify = 1 and score=1";
			break;

			default: $where="goodsid='$goodsid' and verify = 1";
			break;

		}



		$wherex="id=$goodsid";
		try{
			$goods = goods::objects()->filter($wherex,'');
		}catch(Exception $e){
			core::alert('出错！');
		}
		$goodsname=$goods[0]->goodsname;
		$lastcid = GoodsFront::GetLastCate($goodsid);
		$str = GoodsFront::GetNavigation($lastcid,$goodsname="$goodsname",$goodsid);
		$marketprice=$goods[0]->marketprice;
		$shopprice=$goods[0]->shopprice;//商品信息



		try{
			$manager = comment::objects()->pageFilter($where, 'createtime DESC');//添加try
		}catch(Exception $e){
			core::alert('数据库错误');
		}
		$page = new pagination($manager, 5, $page);  //分页
		//整理评论的回复数组$commentreply["$i"]["$j"],每个一维数组表示一条评论的所有数组
		$reply1 = comment_reply::objects()->all();
		foreach($page->objectList() as $x=>$c){
			//core::alert($c->id);
			$y=0;
			$commentreplycount1["$x"]=0;
			foreach($reply1 as $r){
				if($r->commentid==$c->id){
					$commentreply1["$x"]["$y"] = $r;
					$commentreplycount1["$x"]++;
					$y++;
				}
			}
		}
		$where1="id='$goodsid'";
		$goodsmanager=goods::objects()->filter($where1,'');
		$count=$page->dataCount;
		$goodscomment=array('comment'=>$comment,'page1'=>$page1,'goodsid'=>$goodsid);
		$gid = $goodsid;
		$type='goods';
		$params=array('gid'=>$gid);
		$url = GoodsFront::GetUrl($type,$params,$arr=array(),$keyword='');
		$webTitle = TITLE.'商品评论';
		template('usercomment', array('page'=>$page,'goodsid'=>$goodsid,'count'=>$count,'goodsname'=>$goodsname,'marketprice'=>$marketprice,'shopprice'=>$shopprice,'str'=>$str,'commentreply1'=>$commentreply1,'commentreplycount1'=>$commentreplycount1,'uname'=>$uname,'url'=>$url,'ty'=>$ty,'webTitle'=>$webTitle), 'default/front/comment');
	}





	//回复页面
	public static function comment_replyAdd(){
		$gid=intval($_GET['gid']);//商品ID
		$cid=intval($_GET['cmid']);//评论ID
		//auth::authUser();
		$uname=auth::getUserName();

		$comreply = other::getCommentDetail($cid);
		if(count($_POST)){
			$time=time();
			//添加登录验证
			//级别验证
			auth::authUser();
			$uid = auth::getUserId();
			$uname=auth::getUserName();
			$reply=base::wordFilter($_POST['reply']);
			if(empty($reply)){
				core::alert("回复内容不可以空");
			}
			$c_r=new comment_reply;
			$c_r->commentid=$cid;
			$c_r->uid=$uid;
			//if(ISCHECKREPLY){
			//$c_r->verify=0;
			//}else{
			$c_r->verify=1;
			//}
			//是否需要审查回复
			$c_r->uname=$uname;
			$c_r->replytime=$time;
			$c_r->reply=$reply;
			if($c_r->save()){
				core::alert('回复成功');
			}else{
				core::alert('回复失败，请重试！');
			}
		}
		$type='goods';
		$params=array('gid'=>$gid);
		$url = GoodsFront::GetUrl($type,$params,$arr=array(),$keyword='');

		$where = "id = '$gid'";
		$goodsInfo = goods::objects()->filter($where,'');
		$goodsname = $goodsInfo[0]->goodsname;
		$lastcid = GoodsFront::GetLastCate($gid);
		$str = GoodsFront::GetNavigation($lastcid,$goodsname="$goodsname",$gid);
		$webTitle = TITLE.'评论回复';

		template('commentReply',array('comreply'=>$comreply,'goodsInfo'=>$goodsInfo,'cid'=>$cid,'gid'=>$gid,'str'=>$str,'uname'=>$uname,'url'=>$url,'webTitle'=>$webTitle),'default/front/comment');
	}








	//点击个人中心"我的评论"后显示的列表
	public static function order(){
		$page = intval( $_GET['page'] );

		auth::authUser();
		$uid = auth::getUserId();
		$uname=auth::getUserName();//添加用户名，便于查询

		$where="uid=$uid";
		$mana=orders::objects()->pageFilter('','',$type=2,$sql="select u.id as x ,c.id as y ,u.order_sn as z,c.goodsname as t, u.paytime as f, c.mark as g,c.goodsid as gd from orders u,goodsorder c where u.orderstate=3 and u.uid ='$uid' and u.id = c.orderid");
		$page = new pagination($mana,2, $page);  //分页
		$commentCount=$page->dataCount;
		foreach($page->objectList() as $i=>$v){
			$gd=$v->gd;
			$where1="goodsid='$gd' and uid='$uid'";
			$goodscom=comment::objects()->filter($where1,'');
			if(count($goodscom)){
				$comat["$i"]=1;
				$commentid["$i"]=$goodscom[0]->id;
				$replyCount["$i"]=Comments::getReplyCount($commentid["$i"]);
			}else{
				$comat["$i"]=0;
			}
		}
		$navigation = NAV_MY . '> <a>我的评价</a>';

		$webTitle = TITLE.'我的评价';
		template('usercommentInfo',array('page'=>$page,'comat'=>$comat,'replyCount'=>$replyCount,'commentid'=>$commentid,'commentCount'=>$commentCount,'navigation'=>$navigation,'gd'=>$gd,'uname'=>$uname,'webTitle'=>$webTitle),'default/front/comment');
	}



	public static function commentTest($uid,$gid){
		//是否已经购买此产品，是否评论过
		$a=$uid;
		$b=$gid;

		$where="uid='$a' and goodsid='$b'";
		$manager = comment::objects()->filter($where, 'id DESC');

		$manager1=goodsorder::objects()->filter($where1,'');





		if(count($manager)){
			core::alert('您已经评论过了');
		}else{
			$man = orders::objects()->pageFilter('','',$type=2,$sql="SELECT *
			FROM orders AS o, goodsorder AS g
			WHERE o.uid ='$uid'
			AND o.orderstate = 3
			AND g.goodsid ='$gid' 
			AND g.orderid = o.id");
			$page=1;
			$page = new pagination($man,5,$page);
//			core::alert(count($page->objectList()));			if(!count($page->objectList())){
				core::alert('您未购买此产品不能评论');
			}
		}

	}







}