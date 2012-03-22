<?php
/**
 * 短信息系统
 * @author mff
 */
header("content-type:text/html; charset=utf-8");
if (!defined("PRO_ROOT")) {
	exit();
}

require_once PRO_ROOT . 'models.php';
require_once DZG_ROOT . 'core/pagination/pagination.php';
require_once PRO_ROOT . 'include/base.class.php';
require_once PRO_ROOT . 'include/userFun.class.php';
class shortmessageViews{
	/*
	public static function smShow(){
		//	AdminAuth::AuthAdmin();		
		$page = intval( $_GET['page'] );
		//$where="tid='$_COOKIE['id']'";
		//$a=1;
		//$where="tid=".$a;
		try{
			$manager = shortmessage::objects()->pageFilter($where='', 'stime DESC');//添加try
		}catch(DGZException $e){
			core::alert('数据库连接失败');
		}
		$webTitle = TITLE.'短消息';
		$page = new pagination($manager, 7, $page);  //分页
		template('smShow', array('page'=>$page,'webTitle'=>$webTitle), 'default/front/shortmessage');
	
	}
*/
		
		
	public static function smDelete(){
		//AdminAuth::AuthAdmin();
		
		$id = intval( $_GET['id'] );
		if ( empty($id) ) {
			core::alert('操作失败');
		}else{
			$shortmessage = new shortmessage();
			$shortmessage->id = $id;
			if ( $shortmessage->delete() ) {
					core::alert('删除成功');
			} else {
					core::alert('删除失败');
				}
			}

	}
	
	
	
	public static function smAdd(){
		//AdminAuth::AuthAdmin();
		if(count($_POST)){
			$time=time();
 			$shortmessage1=new shortmessage;
			$shortmessage1->fname=base::wordFilter($_POST['fname']);//cookie
			$shortmessage1->tid=$_POST['tid'];
			$shortmessage1->title=base::wordFilter($_POST['title']);
			$shortmessage1->content=base::wordFilter($_POST['content']);
			$shortmessage1->stime=$time;
			$shortmessage1->smtype=1;
			if($shortmessage1->save()){
				core::alert('发送成功！');
			}else{
				core::alert('发送失败！');
			}
		}
    	template('smAdd', array(), 'default/front/shortmessage');
	}
	
	
	
/*	public static function smSepShow(){
		$id=intval($_GET['id']);
		if($id){
			$where="id='$id'";
			$info=shortmessage::objects()->get($where);
			$sm=new shortmessage;
			$sm->id=$id;
			$sm->iread=1;
			$sm->save();
		template('smSepShow',array('info'=>$info),'default/front/shortmessage');
		}else{
			core::alert('出错了！');
		}
	
	}
*/
	
//
	public static function sendAll(){
		if(count($_POST)){
				$time=time();
 				$shortmessage1=new shortmessage;
				$shortmessage1->fname=base::wordFilter($_POST['fname']);//cookie
				$shortmessage1->title=base::wordFilter($_POST['title']);
				$shortmessage1->content=base::wordFilter($_POST['content']);
				$shortmessage1->stime=$time;
				if($shortmessage1->save()){
					core::alert('发送成功！');
				}else{
					core::alert('发送失败！');
				}
			}
    	template('addAll', array(), 'default/front/shortmessage');
	
	}
		
	//我的短消息（个人中心）	
		public static function userSmShow(){
			auth::authUser();
 			$uid = auth::getUserId();
			$uname=auth::getUserName();

			$page = intval( $_GET['page'] );

			$where="tid='$uid' or smtype=0";
			try{
				$manager = shortmessage::objects()->pageFilter($where, 'stime DESC');//添加try
			}catch(Exception $e){
				core::alert('数据库连接失败');
			}

			$page = new pagination($manager, 5, $page); 
			$ShotmessageCount=$page->dataCount;
			$navigation = NAV_MY . '> <a>短消息</a>';

			$webTitle = TITLE.'短消息';
			template('userSmShow', array('page'=>$page,'ShotmessageCount'=>$ShotmessageCount,'navigation'=>$navigation,'uname'=>$uname,'webTitle'=>$webTitle), 'default/front/shortmessage');

		}
		
		//验证是否读过
		public static function isRead(){
			$msid=$_GET['msid'];
				$where="id='$msid'";
			
				$sm=shortmessage::objects()->get($where,'');
				if(count($sm->content)){
					$shortmessage=new shortmessage;
					$shortmessage->id = $msid;
					$shortmessage->iread=1;
					$shortmessage->save();
				}			
		}
		public static function test(){
			require_once PRO_ROOT . 'include/shortmessage.class.php';
			$title = 'nihao';
			$content = 'hello';
			$s = SmessageFun::AddAnnouncement($title,$content,'');
			if($s){
				core::alert('11');
			}else{
				core::alert('22');
			}
			template('test',array(),'default/front/shortmessage');
		
		}


}
























?>