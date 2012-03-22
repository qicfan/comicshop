<?php
if (!defined("PRO_ROOT")) {
	exit();
}
require_once PRO_ROOT .'models.php';
class Brands{
	
	public static function AddBrand($bname,$bpicpath='',$des='',$isindex=0){
		$brand = new tag();
		$brand->bname = $bname;
		$brand->bpicpath = $bpicpath;
		$brand->des = $des;
		$brand->isindex = $isindex;
		if($brand->save()){
			return $brand->id;
		}
	}
	
	public static function CheckBrand($bname){
		try {
			return tag::objects()->get("bname='".$bname."'");
		}catch(DZGException $e){
			return false;
		}
	}
	
	/*
	 * ��ȡ���а�Ʒ��
	*/
	public static function GetBrandAll(){
		try{
			return tag::objects()->all();
		}catch(DZGException $e){
			return false;	
		}
	}
	
	/*
	 * ��ȡ���е���Ʒ
	*/
	public static function GetWorksAll(){
		try{
			return works::objects()->all();
		}catch(DZGException $e){
			return false;
		}
	}
	
}
?>