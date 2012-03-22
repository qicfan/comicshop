<?php

/*
 * author：wsh	
 * date  :20100507
 * 分类操作的封装
*/

if (!defined("PRO_ROOT")) {
	exit();
}
require_once PRO_ROOT .'models.php';
class Categorys{
	//全局变量
	public $categorys;
	public $result = array();
	protected $id;
	//在构造函数中给变量赋值
	public function __construct(){
		$this->categorys = category::objects()->all("id DESC");
		$this->result = array();
	}
	
	/*
	 * 分类的添加
	 * @param string $categoryname
	 * @param int $pid
	 * @param int $categorylevel
	*/
	public static function Add($categoryname,$pid,$categorylevel){
		$category = new category();
		$category->categoryname = $categoryname;
		$category->parentid = $pid;
		$category->level = $categorylevel+1;
		$flag = $category->save();
		if($flag){
			return $category->id;
		}	
	}
	
	/*
	 * 修改分类名称的时候，检查分类名称是否存在
	*/
	public static function CheckCategoryName($cid,$cname){
		global $db;
		$sql = "SELECT count(id) FROM category WHERE id!=".$cid." AND categoryname='".$cname."'";
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
	 * 获取全部分类信息
	*/
	public static function GetAll(){
		try{
			return category::objects()->all();
		}catch(DZGException $e){
			return false;
		}
	}
	
	/*
	 * 通过分类名获取分类信息
	 * @param string $cname
	*/
	public static function GetByCName($cname,$pid=100000000){
		$where = "categoryname='".$cname."'";
		if($pid!=100000000){
			$where .= " AND parentid=".$pid;
		}
		try{
			return category::objects()->get($where);
		}catch(DZGException $e){
			return false;
		}
	}
	
	/*
	 * 通过分类的父id获取分类信息
	 * @param int $pid 分类的父id
	*/
	public static function GetByPid($pid){
		global $db;
		//$sql = "SELECT * FROM category WHERE parentid=".$pid;
		$sql = "SELECT * FROM category WHERE parentid=".$pid." ORDER BY id DESC";
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
	 * 获取分类通过cid
	*/
	public static function GetByCid($cid){
		try{
			return category::objects()->get("id=".$cid);
		}catch(DZGException $e){
			return false;
		}
	}
	
	/*
	 * 递归调用获取分类
	 * @param int $pid 父级分类
	 * @param string $f 分类前面的--
	*/
 	public function getcategorys($pid,$f){
		for($i=0;$i<count($this->categorys);$i++){
			if($this->categorys[$i]->parentid == $pid){
				$this->categorys[$i]->categoryname = $f.$this->categorys[$i]->categoryname;
				array_push($this->result,$this->categorys[$i]);
				self::getcategorys($this->categorys[$i]->id,$f.'&nbsp;&nbsp;');
			}
		}
		return $this->result;
	}
	
	/*
	 * 分类名称修改
	*/
	public static function Edit($cid,$cname){
		$category = new category();
		$category->id = $cid;
		$category->categoryname = $cname;
		$flag = $category->save();
		return $flag;
	}
	
	/*
	 * 分类删除
	 * @param int $cid 商品分类的id
	*/
	public static function Del($cid){
		$category = new category();
		$category->id = $cid;
		try{
			return $category->delete();
		}catch(DZGException $e){
			return false;
		}	
	}

}
?>