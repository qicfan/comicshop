<?php

/*
 * author：johz
 * date  :2010-07-15
 * 我的咨询--操作的封装
*/

if (!defined("PRO_ROOT")) {
	exit();
}
require_once PRO_ROOT .'models.php';
class Questions{
	//全局变量
	public $categorys;
	public $result = array();
	protected $id;

	//什么也不做 
	public function __construct(){
	}
	
	/*
	 * 添加咨询
	 * @param int  $uid $gid $type 
	 * @param string  $title $content
	 * @return int 
	*/
	public static function Add($uid, $gid, $type, $title, $content){
		$question = new question();
		$question->uid = $uid;
		$question->gid = $gid;
		$question->type = $type;
		$question->title = $title;
		$question->content = $content;
		$flag = $question->save();
		if($flag){
			return $question->id;
		}else {
			return 0;
		}
	}
	
	/*
	 * 根据商品id、分类 获取咨询信息
	 *@param int  $gid $type $start  $end
	 *return array
	*/
	public static function Get($gid='',$type='',$start=0,$end=10){
		$gid = ($gid) ? $gid : intval($_GET['gid']);
		$type = ($type)?$type:intval( $_GET['type'] );

		if ( empty($type) ) {
			$where = " 1 = 1 ";  //所有
		} else {
			$where = " type = $type ";  //1留言 2询问 3投诉 4求购
		} 
		$verify = base::checkVerify('question');                 //是否需求审核
		if($verify == '1') {
			$where .= " and verify='1' ";
		}

		$where .= " and gid=$gid";

		try{
			$rel = question::objects()->filter($where, 'id DESC', $start = 0, $end = 20);
		}catch (Exception $e) {
			$rel = '';
		}
		return $rel;
	}
	
	/**
	 * 删除咨询
	 *@param $id $uid
	 *@return int (1 成功 0 失败 -1 记录不存在 -2无权限)
	 */
	public static function Del($id='',$uid='') {
        auth::authUser();   // 用户验证
		base::checkRefresh();  //防刷新

		$id = ($id)?$id:intval( $_GET['id'] );
		$uid = ($uid)?$uid:auth::getUserId();

		//数据库
        $sql = "select uid from question where id='$id'";             // 判断是否本人删除
		$result = question::objects()->QuerySql($sql);
		if(empty($result)){
			return -1;             
		}elseif($result[0]['uid']!=$uid){
			return -2;
		}

		$quiz = new question();                                       //开始删除
        $quiz->id = $id;
		$rs = $quiz->delete();
		
		if ($rs){
			return 1;
		}else {
			return 0;
		}
		
	}
	
	/*
	 * 获取某个商品咨询的数量
	*/
	public static function GetZQCount($gid){
		$sql = "SELECT id FROM question WHERE gid=".$gid;
		global $db;
		try{
			$stm = $db->query($sql);
			return $stm->rowCount();
		}catch(DZGException $e){
			return 0;
		}
	}

}
?>