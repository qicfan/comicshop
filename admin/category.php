<?php
/*
 * author wsh
 * date 20100506
 * 主要是对分类的显示
*/

if (!defined("PRO_ROOT")) {
	exit();
}
require_once PRO_ROOT.'include/categorys.class.php';
require_once PRO_ROOT.'include/attributes.class.php';
require_once PRO_ROOT.'include/base.class.php';
class categoryViews{
	
	/*
	 * 分类的添加
	*/
	public static function add(){
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(6);
		$cate = new Categorys();
		$cate->categorys = $cate->getcategorys(0,'--');
		if(!count($_POST)){
			template('categoryadd',array('categorys'=>$cate->categorys),'default/admin/category');
		}
		
		$categoryname = trim($_POST['categoryname']);
		$categoryidlevel = trim($_POST['parentcate']);
		
		if($categoryname==''||$categoryidlevel==''){
			core::alert('分类名称或分类类型为空！');
		}
		//检查是否存在分类名
		$isexists = $cate->GetByCName($categoryname);
		if($isexists){
			core::alert('分类名称已存在！');
		}
		
		$categoryarr = explode(',',$categoryidlevel);
		if($categoryidlevel==0){
			$categoryid = 0;
			$categorylevel = 0;
		}else{
			$categoryid = $categoryarr[0];
			$categorylevel = $categoryarr[1];
		}
		$cid = $cate->Add($categoryname,$categoryid,$categorylevel);
		
		//给分类添加属性，继承父类属性
		if($cid){
			$attrs = Attributes::GetKeyByCid($categoryid);
			for($i=0;$i<count($attrs);$i++){
				$addflag = Attributes::AddKey($cid,$attrs[$i]['attributetype'],$attrs[$i]['attributename'],$attrs[$i]['attributevalue'],$attrs[$i]['isrelate']);
				if(!$addflag){
					core::alert('父级分类的属性没有全部继承成功！');
				}
			}
			
			base::autoSkip('分类添加成功！','继续添加分类',URL.'index.php/admin/category/add','分类列表页',URL.'index.php/admin/category/categorylists');
		}
	}
	
	/*
	 * 分类列表和分类名称修改
	*/
	public static function categorylists(){
		$cate = new Categorys();
		$cate->categorys = $cate->getcategorys(0,'');
		if(!count($_POST)){	
			template('categorylist',array('categorys'=>$cate->categorys),'default/admin/category');
		}
		
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(6);
		$categoryname = trim($_POST['categoryname']);
		$cid = $_POST['cid'];
		if($cid==0||$cid==''){
			core::alert('没有点击分类后的编辑按钮！');
		}
		if($categoryname==''){
			core::alert('分类名称不能为空！');
		}
		//检查分类名称是否存在
		//$checkflag = Categorys::CheckCategoryName($cid,$categoryname);
		
		if($checkflag){
			core::alert("分类名称已经存在，请重新填写！");
		}
		
		$flag = $cate->Edit($cid,$categoryname);
		if($flag){
			base::autoSkip('修改分类成功','返回分类列表',URL.'index.php/admin/category/categorylists');
		}
	}
	
	/*
	 * 删除商品分类
	*/
	public static function categorydel(){
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(6);
		require_once PRO_ROOT.'include/goods.class.php';
		$cid = $_GET['cid'];
		$type = $_GET['type'];	
		if($type=="ca"){
			$attributes = Attributes::GetKeyByCid($cid);
			//删除值
			for($i=0;$i<count($attributes);$i++){
				Attributes::DelValue($attributes[$i]['id']);
			}
			//删除key
			Attributes::DelKeys($cid);
			//删除分类和商品的关系
			Ware::DelGoodsCategorys($cid);
			$flag = Categorys::Del($cid);
		}else if($type=="attri"){
			$attributes = Attributes::GetKeyByCid($cid);
			//删除值
			for($i=0;$i<count($attributes);$i++){
				Attributes::DelValue($attributes[$i]['id']);
			}
			//删除key
			Attributes::DelKeys($cid);
		}else if($type=="goods"){
			Ware::DelGoodsCategorys($cid);
			$flag = Categorys::Del($cid);
		}else if($type=="none"){
			$flag = Categorys::Del($cid);
		}
		if($flag){
			echo $flag.",".$cid;
			//base::autoSkip('删除分类成功！','继续删除分类',URL.'index.php/admin/category/categorylists');
		}
			
		
	}
	
	/*
	 * 删除商品之前的搜索
	*/
	public static function beforecatedel(){
		require_once PRO_ROOT.'include/goods.class.php';
		$cid = $_GET['cid'];
		$category = Categorys::GetByPid($cid);
		$attributes = Attributes::GetKeyByCid($cid);
		$goods = Ware::GetByCB($cid);
		if(!empty($category)||$category){
			echo 'cate';
		}else if(!empty($attributes[0])&&!empty($goods[0])){
			echo 'ca';
		}else if(!empty($attributes[0])){
			echo 'attri';
		}else if(!empty($goods[0])){
			echo 'goods';
		}else{
			echo 'none';
		}
		
	}
}
?>