<?php
/**
 * 商品和订单以外的其它功能的公共类
 * @author wj45
 */
class other {
	/**
	 * 禁止实例化
	 */
	private function __construct() {
	}
	
	/**
	 * 获得文章列表页（文章模块）
	 * @param int $page 当前页数
	 * @param int $page 每页显示多少条数据 默认为10
	 * @param int $type 分类ID，筛选用 默认为获取全部文章
	 * @return array('page'=>$page, 'sort'=>$sort)
	 * @return page为分页数据、sort为所有分类的信息
	 */
	public static function getArticleList($page, $size = 10, $type = '') {
		$where = "state != 0";
		if ( !empty($type) && $type != 1 ) {
			try {
				$son = articlecategory::objects()->filter("parentid = $type");  //获取分类名称
			} catch (Exception $e) {
				$son = '';
			}
			$where .= " AND ( sort = $type";
			foreach ($son as $v) {
				$where .= " OR sort = $v->id";
			}
			$where .= ')';
		}
		$manager = article::objects()->pageFilter($where, 'createtime DESC');  //按下单时间倒序排列
		$page = new pagination($manager, $size, $page);  //分页
		try {
			$sort = articlecategory::objects()->all();  //获取分类名称
		} catch (Exception $e) {
			$sort = '';
		}
		$array = array('page'=>$page, 'sort'=>$sort);
		return $array;
	}
	
	/**
	 * 获得文章分类列表项（option）（文章模块）
	 */
	public static function getArticleTree() {
		function tree( $pid = 0, $level = '') {
			static $str = '';
			try {
				$sort = articlecategory::objects()->filter("parentid = $pid", 'id');
			} catch (Exception $e) {
				$sort = '';
			}
			foreach ($sort as $v) {
				$str .= '<option id="sort' . $v->id . '" value="' . $v->id . '">';
				$str .= $level . $v->sortname . '</option>';
				$pid = $v->id;
				tree($pid, $level . '---');  //递归
			}
			return $str;
		}
		return tree(0, '');
	}
	
	/**
	 * 获得文章分类列表项（li）（文章模块）
	 */
	public static function getArticleTree2() {
		if ( function_exists('tree2') ) {
			return tree2(0, '');
		}
		function tree2( $pid = 0, $level = '') {
			static $str = '';
			if ($level == '') {
				$str = '';
			}
			try {
				$sort = articlecategory::objects()->filter("parentid = $pid", 'id');
			} catch (Exception $e) {
				$sort = '';
			}
			foreach ($sort as $v) {
				$str .= '<li class="article_sort" id="sort' . $v->id . '">';
				$str .= '<a href="' . URL . 'index.php/front/article/articleList?sort=' . $v->id . '">';
				$str .= $level . $v->sortname . '</a></li>';
				$pid = $v->id;
				tree2($pid, $level . '>>');  //递归
			}
			return $str;
		}
		return tree2(0, '');
	}
	
	/**
	 * 获取评论详情和所有相关的回复（评论模块）
	 */
	public static function getCommentDetail( $id ) {
		try {
			$comment = comment::objects()->get("id = $id");
		} catch (Exception $e) {
			core::alert('无此评论！');
		}
		$ulevel=$comment->ulevel;
		$uname=$comment->uname;
		$createtime=$comment->createtime;
		$title=$comment->title;
		$score=$comment->score;
		$good = $comment->good;
		$bad = $comment->bad;
		$summary = $comment->summary;
		//回复
		$page = intval( 1 );
		$manager = comment_reply::objects()->pageFilter("commentid = $comment->id and verify = 1", 'id DESC');
		$page = new pagination($manager, 100000, $page);  //分页
		$array = array('comment'=>$comment,'score'=>$score,'title'=>$title,'ulevel'=>$ulevel,'uname'=>$uname,'createtime'=>$createtime,'good'=>$good, 'bad'=>$bad, 'summary'=>$summary, 'page'=>$page);
		return $array;
	}
	
	/**
	 * 回复评论（Ajax）（评论模块）
	 */
	public static function commentReply() {
		$act = $_GET['act'];
		if ($act == 'admin') {
			AdminAuth::AuthAdmin();
			$uid = '0';  //管理员回复
		} else {
			$uid = '';  //用户回复
		}
		$id = intval( $_POST['id'] );
		$reply = base::wordFilter( $_POST['reply'] );
		if ( $uid == '' || empty($id) || empty($reply) ) {
			die();
		}
		$comment = new comment_reply();
		$comment->uid = $uid;
		$comment->commentid = $id;
		$comment->reply = $reply;
		$time = time();
		$comment->replytime = $time;
		$rs = $comment->save();
		return $rs;
	}
	
	/**
	 * 取得评论的回复总数（评论模块）
	 */
	public static function getCommentCount( $cid ) {
		global $db;
		try {
			$sql = "SELECT COUNT(*) FROM comment_reply WHERE commentid = $cid";
			$rs = $db->prepare($sql);
			$rs->execute();
			$count = $rs->fetchColumn();
			$rs->closeCursor();
		} catch (DZGException $e) {
			$count = false;
		}
		return $count;
	}
	
	/**
	 * 获取问答分页列表（问答模块）
	 */
	public static function getQuizList( $where, $size = 10 ) {
		$page = intval( $_GET['page'] );
		$manager = question::objects()->pageFilter($where, 'id DESC');
		$page = new pagination($manager, $size, $page);  //分页
		return $page;
	}
	
	/**
	 * 获取问答信息（问答模块）
	 * $id为空则取全部，不为空则取一条
	 */
	public static function getQuiz( $id = '' ) {
		if ( empty($id) ) {
			try {
				$quizInfo = question::objects()->all();
			} catch (Exception $e) {
				$quizInfo = false;
			}
		} else {
			try {
				$quizInfo = question::objects()->get("id = $id");
			} catch (Exception $e) {
				$quizInfo = false;
			}
		}
		return $quizInfo;
	}
	
	/**
	 * 获取商品价格举报分页列表
	 */
	public static function getInformList( $where, $size = 10 ) {
		$page = intval( $_GET['page'] );
		$manager = inform::objects()->pageFilter($where, 'id DESC');
		$page = new pagination($manager, $size, $page);  //分页
		return $page;
	}

	/**
	 * 获取举报信息
	 * $id为空则取全部，不为空则取一条
	 */
	public static function getInform( $id = '' ) {
		if ( empty($id) ) {
			try {
				$Info = inform::objects()->all();
			} catch (Exception $e) {
				$Info = false;
			}
		} else {
			try {
				$Info = inform::objects()->get("id = $id");
			} catch (Exception $e) {
				$Info = false;
			}
		}
		return $Info;
	}


	/**
	 * 取得每个商品的被收藏总数，并按收藏数量拍好序（收藏模块）
	 */
	public static function getCollectAll() {
		global $db;
		try {
			$sql = "SELECT gid, COUNT(*) AS count FROM collect GROUP BY gid ORDER BY COUNT(*) DESC";
			$rs = $db->prepare($sql);
			$rs->execute();
			$count = $rs->fetchAll();
			$rs->closeCursor();
		} catch (DZGException $e) {
			$count = false;
		}
		return $count;
	}
	
	/**
	 * 取得一个商品的被收藏总数（收藏模块）
	 */
	public static function getCollectCount( $gid ) {
		global $db;
		try {
			$sql = "SELECT COUNT(*) FROM collect WHERE gid = $gid";
			$rs = $db->prepare($sql);
			$rs->execute();
			$count = $rs->fetchColumn();
			$rs->closeCursor();
		} catch (DZGException $e) {
			$count = false;
		}
		return $count;
	}
	
	/**
	 * 取所有友情链接的信息（友情链接）
	 */
	public static function getFriendLink() {
		try {
			$link = friendship::objects()->all('sort');
		} catch (Exception $e) {
			$link = false;
		}
		return $link;
	}
	
	/**
	 * 获取所有的会员等级（会员等级）
	 */
	public static function getMember() {
		try {
			$member = member::objects()->all("id");
		} catch (Exception $e) {
			$member = false;
		}
		return $member;
	}
	
	/**
	 * 向数据库中插入优惠券信息（优惠券）
	 */
	public static function addCoupon($code, $fee, $starttime, $deadline, $state = 0, $uid = '') {
		$coupon = new coupon();
		$coupon->code = $code;  //编号
		$coupon->fee = $fee;  //金额
		$coupon->starttime = $starttime;  //生效日期
		$coupon->deadline = $deadline;  //过期日期
		$coupon->state = $state;  //优惠券状态
		$coupon->uid = $uid;  //绑定的用户ID
		$rs = $coupon->save();
		return $rs;
	}
	
	/**
	 * 取得未回复的留言总数（问答/留言 统计）
	 */
	public static function getQuizCount() {
		global $db;
		try {
			$sql = "SELECT COUNT(*) AS count FROM question WHERE state = 0";
			$rs = $db->prepare($sql);
			$rs->execute();
			$count = $rs->fetchAll();
			$rs->closeCursor();
		} catch (DZGException $e) {
			$count = false;
		}
		return $count[0][0];
	}
	
	/**
	 * 取得咨询的评价
	 */
	public static function getQuestiomComment($qid='',$val='0') {
		global $db;
		try {
			$sql = "SELECT COUNT(id) AS count FROM questioncomment WHERE qid='$qid' and val='$val'";
			$rs = $db->prepare($sql);
			$rs->execute();
			$count = $rs->fetchAll();
			$rs->closeCursor();
		} catch (DZGException $e) {
			$count = '0';
		}
		return $count[0][0];
	}

	/*
	 * 检查数据库配置里有没有这个配置
	*/
	public static function CheckConfig($key){
		try{
			return config::objects()->get("keyword='".$key."'");
		}catch(DZGException $e){
			return false;
		}
	}
	
	/*
	 * 更新重写开关状态
	*/
	public static function SetConfig($key,$value){
		require_once PRO_ROOT.'include/base.class.php';
		if(self::CheckConfig($key)){
			global $db;
			try{
				$sql = "UPDATE config SET kvalue='".$value."' WHERE keyword='".$key."'";
				$flag = $db->exec($sql);
			}catch(DZGException $e){
				return false;
			}
		}else{
			$config = new config();
			$config->keyword = $key;
			$config->kvalue = $value;
			$flag = $config->save();
		}
		if($flag){
			return base::setConfig($key,$value);
		}else{
			return false;
		}
	}

/**
 * 截取UTF-8编码下字符串的函数
 *
 * @param   string      $str        被截取的字符串
 * @param   int         $length     截取的长度
 * @param   bool        $append     是否附加省略号
 *
 * @return  string
 */
function sub_str($str, $length = 0, $append = true)
{
    $str = trim($str);
    $strlength = strlen($str);

    if ($length == 0 || $length >= $strlength)
    {
        return $str;
    }
    elseif ($length < 0)
    {
        $length = $strlength + $length;
        if ($length < 0)
        {
            $length = $strlength;
        }
    }

    if (function_exists('mb_substr'))
    {
        $newstr = mb_substr($str, 0, $length, 'utf-8');
    }
    elseif (function_exists('iconv_substr'))
    {
        $newstr = iconv_substr($str, 0, $length,'utf-8');
    }
    else
    {
        $newstr = cn_substr_utf8($str, $length, 0);
    }

    if ($append && $str != $newstr)
    {
        $newstr .= '...';
    }

    return $newstr;
}

//utf-8中文截取，单字节截取模式
function cn_substr_utf8($str, $length, $start=0)
{
	if(strlen($str) < $start+1)
	{
		return '';
	}
	preg_match_all("/./su", $str, $ar);
	$str = '';
	$tstr = '';

	//按字节截取
	for($i=0; isset($ar[0][$i]); $i++)
	{
		if(strlen($tstr) < $start)
		{
			$tstr .= $ar[0][$i];
		}
		else
		{
			if(strlen($str) < $length + strlen($ar[0][$i]) )
			{
				$str .= $ar[0][$i];
			}
			else
			{
				break;
			}
		}
	}
	return $str;
}

}
?>