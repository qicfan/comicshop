<?php
/*
 * author wsh
 * date 20100510
 * 商品属性的封装
*/
if (!defined("PRO_ROOT")) {
	exit();
}
require_once PRO_ROOT .'models.php';
class Attributes{
	
	public function __construct(){
		
	} 
	
	/*
	 * 获取全部属性的键根据所属分类
	 * @param int $cid 分类id
	*/
	public static function GetKeys($cid){
		$where ='';
		
		if($cid){
			$where = "cid=".$cid;
		}
		
		try{
			return attribute_key::objects()->pageFilter($where,"id DESC");
		}catch(DZGException $e){
			return false;
		}
	}
	
	/*
	 * 获取属性根据所属分类(没有分页的)
	 * @param int $cid 
	*/
	public static function GetKeyByCid($cid){
		global $db;
		$sql = "SELECT * FROM attribute_key WHERE cid=".$cid;
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
	 * 获取键根据属性id
	 * @param int $aid 
	*/
	public static function GetKey($aid){
		try{
			return attribute_key::objects()->get("id=".$aid);
		}catch(DZGException $e){
			return false;
		}
	}
	
	/*
	 * 获取属性键，根据键的名称
	*/
	public static function GetKeyByName($name){
		try{
			return attribute_key::objects()->get("attributename='".$name."'");
		}catch(DZGException $d){
			return false;
		}
	}
	
	/*
	 * 修改属性名称之前，先检查名称是否存在
	*/
	public static function CheckAttributeName($aid,$aname){
		global $db;
		$sql = "SELECT count(id) FROM attribute_key WHERE id!=".$aid." AND attributename='".$aname."'";
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
	 * 添加属性的键
	 * @param int $cid 
	 * @param string $attributename 0-唯一属性,1-单选属性,2-多选属性
	*/
	public static function CheckKey($cid,$attriubtename){
		try{
			return attribute_key::objects()->get(" cid=".$cid." AND attributename='".$attriubtename."'");
		}catch(DZGException $e){
			return false;
		}
	}
	
	/*
	 * 添加属性的键
	 * @param int $cid 
	 * @param int $attributetype 0-唯一属性,1-单选属性,2-多选属性
	 * @param string $attributename
	 * @param string $attributevalue
	*/
	public static function AddKey($cid,$attributetype,$attributename,$attributevalue,$isrelate){
		if(self::CheckKey($cid,$attributename)){
			return 0;
		}else{
			$attrkey = new attribute_key();
			$attrkey->cid = $cid;
			$attrkey->attributetype = $attributetype;
			$attrkey->attributename = $attributename;
			$attrkey->attributevalue = $attributevalue;
			$attrkey->isrelate = $isrelate;
			$flag = $attrkey->save();
			if($flag){
				return $attrkey->id;
			}
		}
	}
	
	/*
	 * 修改属性的键
	 * @param int $aid 属性键的id	
	 * @param int $cid 分类的id
	 * @param int $attrtype 0-唯一属性,1-单选属性,2-多选属性
	 * @param string $attrname 
	 * @param string $attrvalue
	*/
	public static function EditKey($aid,$cid,$attrtype,$attrname,$attrvalue){
		$attrkey = new attribute_key();
		$attrkey->id = $aid;
		$attrkey->cid = $cid;
		$attrkey->attributetype = $attrtype;
		$attrkey->attributename = $attrname;
		$attrkey->attributevalue = $attrvalue;
		$flag = $attrkey->save();
		return $flag;
	}
	
	/*
	 * 删除属性键值
	 * @param int $aid
	*/
	public static function DelKey($aid){
		$attrkey = new attribute_key();
		$attrkey->id = $aid;
		try{
			return $attrkey->delete();
		}catch(DZGException $e){
			return false;
		}
	}
	
	/*
	 * 删除属性键值
	 * @param int $cid
	*/
	public static function DelKeys($cid){
		global $db;
		$sql = "DELETE FROM attribute_key WHERE cid=".$cid;
		try{
			return $db->exec($sql);
		}catch(DZGException $e){
			return false;
		}
	}
	
	/*
	 * 删除属性的值
	 * @param int $aid
	*/
	public static function DelValue($aid){
		global $db;
		$sql = "DELETE FROM attribute_value WHERE aid=".$aid;
		try{
			return $db->exec($sql);
		}catch(DZGException $f){
			return false;
		}
	}

	/*
	 * 根据健获取值
	 * @param int $aid
	*/
	public static function GetValue($aid){
		$sql = "SELECT * FROM attribute_value WHERE aid=".$aid;
		try{
			return attribute_value::objects()->QuerySql($sql);
		}catch(DZGException $d){
			return false;
		}
	}
	
	/*
	 * 获取有关联商品的属性
	*/
	public static function GetAttrRelateByGid($gid,$cid){
		global $db;
		$sql = "SELECT ak.id as kid,ak.cid as cid,ak.attributetype as type,ak.attributename as aname,ak.attributevalue as kvalue,ak.isrelate as isrelate,av.aid as aid,av.goodsid as gid,av.attributevalue as vvalue,av.relategoods as relategoods FROM attribute_key as ak INNER JOIN attribute_value as av ON ak.id=av.aid WHERE ak.cid=".$cid." AND av.goodsid=".$gid;
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
	 * 获取商品的非关联属性
	*/
	public static function GetAttrByGid($gid,$cid){
		global $db;
		$sql = "SELECT ak.id as id,ak.attributename as aname,ak.isrelate as isrelate,av.aid as aid,av.goodsid as gid,av.attributevalue as avalue FROM attribute_key ak INNER JOIN attribute_value av ON ak.id=av.aid WHERE ak.isrelate=0 AND av.goodsid=".$gid." AND ak.cid=".$cid;

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
}
?>