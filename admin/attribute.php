<?php
/*
 * author wsh
 * date 20100510 
 * 对属性的显示
*/

if (!defined("PRO_ROOT")) {
	exit();
}

require_once PRO_ROOT .'include/base.class.php';
require_once PRO_ROOT.'include/categorys.class.php';
require_once PRO_ROOT.'include/attributes.class.php';
require_once DZG_ROOT.'core/pagination/pagination.php';
class attributeViews{
	
	/*
	 * 属性列表 
	*/
	public static function attributelists(){
		
		$cates = new Categorys();
		$cates->categorys = $cates->getcategorys(0,'--');
		
		$page = isset($_GET['page'])?$_GET['page']:1;
		$cid = isset($_GET['cate'])?$_GET['cate']:0;
		
		$attrs = Attributes::GetKeys($cid);
		$pager = new pagination($attrs,8,$page);
		template('attributelist',array('page'=>$pager,'cate'=>$cates->categorys,'cid'=>$cid),'default/admin/attribute');
	}
	
	/*
	 * 属性添加
	*/
	public static function attributeadd(){
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(6);
		
		if(!count($_POST)&&!count($_GET)){
			$cates = new Categorys();
			$cates->categorys = $cates->getcategorys(0,'--');
			template('attributeadd',array('categorys'=>$cates->categorys),'default/admin/attribute');
		}
		
		$attriname = trim($_POST['attrname']);
		$cate = $_POST['catename'];
		$attrtype = $_POST['attributetype'];
		$isrealtegoods = $_POST['isrelategoods'];
		$attrilist = $_POST['attrilist'];
		
		if($attriname==''){
			core::alert('属性不能为空！');
		}
		//添加属性前，检查属性名称是否存在
		$checkflag = Attributes::GetKeyByName($attriname);
		if($checkflag||!empty($checkflag)){
			core::alert("属性名称已经存在，请重新填写！");
		}
		$flag = Attributes::AddKey($cate,$attrtype,$attriname,$attrilist,$isrealtegoods);
		if($flag){
			base::autoSkip('添加属性成功','继续添加属性',URL.'index.php/admin/attribute/attributeadd','返回属性列表',URL.'index.php/admin/attribute/attributelists');
		}else{
			core::alert('添加属性失败！');
		}
	}
	
	/*
	 * 属性的修改
	*/
	public static function attributeedit(){
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(6);
		$aid = isset($_GET['aid'])?$_GET['aid']:0;
		$attr = Attributes::GetKey($aid);		
			
		if(!count($_POST)){
			$cates = new Categorys();
			$cates->categorys = $cates->getcategorys(0,'--');
			template('attributeedit',array('attr'=>$attr,'cates'=>$cates->categorys,'cid'=>$attr->cid),'default/admin/attribute');
			
		}
		
		$attriname = trim($_POST['attrname']);
		$cid = $_POST['catename'];
		$attrtype = $_POST['attributetype'];
		$attrilist = $_POST['attrilist'];
		
		if($attriname==''){
			core::alert('属性不能为空！');
		}
		//添加属性前，先检查一下有没有相同的属性名
		$checkflag = Attributes::CheckAttributeName($aid,$attriname);
		if($checkflag){
			core::alert("属性名称已经存在！请重新填写！");
		}
		$flag = Attributes::EditKey($aid,$cid,$attrtype,$attriname,$attrilist);
		if($flag){
			base::autoSkip('修改属性成功','重新修改属性',URL.'index.php/admin/attribute/attributeedit?aid='.$aid,'返回属性列表',URL.'index.php/admin/attribute/attributelists');
		}else{
			core::alert('修改属性失败！');
		}
	}
	
	/*
	 * 删除属性
	*/
	public static function attributedel(){
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(6);
		$aid = $_GET['aid'];
		if($aid==''){
			core::alert('aid传递错误！');
		}
		$attr = Attributes::GetKey($aid);
		if($attr){
			Attributes::DelValue($aid);
			$flag = Attributes::DelKey($aid);
			if($flag){
				base::autoSkip('商品属性删除成功！','返回属性列表',URL.'index.php/admin/attribute/attributelists');
			}
		}else{
			core::alert('此商品属性不存在！');
		}
		
	}
	
	/*
	 * 批量删除属性
	*/
	public static function attributesdel(){
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(6);
		$aids = $_GET['aids'];
		if($aids==''||$aids=="false"){
			core::alert("属性选项为空！");
		}
		$aidArr = explode(',',$aids);
		for($i=0;$i<count($aidArr);$i++){
			$flag = Attributes::DelKey($aidArr[$i]);
			if(!$flag){
				core::alert("批量删除没有全部完成！");
			}
		}
		base::autoSkip('所选属性全部删除！','返回属性列表',URL.'index.php/admin/attribute/attributelists');
	}
}
?>