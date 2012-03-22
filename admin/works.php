<?php
/**
 * 作品管理
 * @author johz
 */
header("content-type:text/html; charset=utf-8");
if (!defined("PRO_ROOT")) {
	exit();
}
require_once PRO_ROOT . 'models.php';
require_once DZG_ROOT . 'core/pagination/pagination.php';
require_once PRO_ROOT . 'include/base.class.php';
require_once PRO_ROOT . 'include/other.class.php';
		
class worksViews {
	public static function index() {
		self::worksList();
	}
	
	/**
	 * 显示列表
	 */
	public static function worksList() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(2);
		
		$page = intval( $_GET['page'] );

		$manager = works::objects()->pageFilter('', 'id DESC');  //按下单时间倒序排列

		$works = new pagination($manager, 10, $page);  //分页
		
		template("worksList", array('works'=>$works) , 'default/admin/works');
	}
	
	/**
	 * 编辑
	 */
	public static function worksEdit() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(2);
		$id = intval( $_GET['id'] );
		if ( empty($id) ) {
			template("worksEdit", array('works'=>$works), 'default/admin/works');
		} else {
			try {
				$works = works::objects()->get("id = $id");
			} catch (Exception $e) {
			}
	
			template("worksEdit", array('works'=>$works), 'default/admin/works');
		}
	}
	
	/**
	 * 发布或更新
	 */
	public static function worksUpdate() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(2);
		base::checkRefresh();  //防刷新
		$id = intval($_POST['id']);
		$wname = htmlspecialchars( $_POST['wname'], ENT_QUOTES );
		$isindex = htmlspecialchars( $_POST['isindex'], ENT_QUOTES );
		$des = $_POST['des'];
		if (empty($wname)) {
			core::alert('内容不完整！');
			exit();
		}

		/** 图片(上传) **/
		$picpath = '';
		$upload = new Uploadfile();
		$fileType = array('image/gif','image/pjpeg','image/jpg','image/bmp','image/png','image/jpeg');
		for($i=0;$i<count($_FILES['picfile']['name']);$i++){
			if($_FILES['picfile']['name'][$i]!=""){
				$upload->upload_file(PRO_ROOT.'/uploadfile/works/',$fileType,'picfile','works','');
				$picpath = 'uploadfile/works/'.$upload->upload_server_name[0].'.'.$upload->suffix[0][count($upload->suffix[0])-1];
			}
		}


		//数据库
		$works = new works();
		if ( !empty($id) ) {
			$works->id = $id;  //如果有ID，那么是更新操作
		}
		$works->wname = $wname;
		$works->wpicpath = $picpath;
		$works->isindex = $isindex;
		$works->des = $des;
		$rs = $works->save();
	

		if ($rs) {
			base::autoSkip("发布成功，正在跳转", '', URL . "index.php/admin/works/worksList");
		} else {
			core::alert('发布失败！');
		}		
	}
	
	/**
	 * 删除，支持批量删除（Ajax）
	 */
	public static function worksDelete() {
		AdminAuth::AuthAdmin();
		AdminAuth::AdminCheck(2);
		base::checkRefresh();  //防刷新
		$id = $_POST['id'];
		$id = trim($id, ',');
		$id = explode(',', $id);
         
		if (empty($id)) {

			core::alert('非法操作！');
			exit();
		}

		foreach ($id as $i=>$v) {
			if (empty($v)) {
				continue;
			}
			try {
				$worksInfo = works::objects()->get("id = $v");
			} catch (Exception $e) {
			}
			$works = new works;
			$works->id = $v;
			$works->delete();  //删除数据库数据
		}

	}

	/*
	 * 删除图片
	*/
	public static function delpic($id){	
		$id = ($id) ? $id : $_GET['id'];
        $select = "select wpicpath from works where id = '$id' ";
		$pic = works::objects()->QuerySql($select);
		if(@unlink(PRO_ROOT.$pic['0']['wpicpath'])){
			works::objects()->QuerySql("update works set wpicpath='' where id='$id'");
			die('1');
		}else{
			die('0');
		}
	}

	/*
	* 改变商品 是否新品
	*/
	public static function changeInd($id='',$vid=''){
		require_once PRO_ROOT.'models.php';
		$id = ($id) ? $id : $_GET['id'];
		$vid = ($vid) ? $vid : $_GET['vid'];

        if($vid=='1'){
			$val = '0';
			$ret = '2';
		} else {
			$val = '1';
			$ret = '1';
		}

        $sql = "update works set isindex='$val' where id='$id' ";             // 判断
		try{
			 goods::objects()->QuerySql($sql);
			 die($ret);
		}catch(Exception $e){
			 die('0'); 
		}
	}
	

}