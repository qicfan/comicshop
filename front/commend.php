<?php
/**
 * 推荐用户显示
 * @author mff
 */
 
 
require_once PRO_ROOT . 'models.php';
require_once DZG_ROOT . 'core/pagination/pagination.php';


class commendViews{


	//个人推荐列表
	public static function commendShow(){
		//	AdminAuth::AuthAdmin();		
		$page = intval( $_GET['page'] );
		//$where='uid="$_COOKIE['id']"';
		try{
			$manager = commend::objects()->pageFilter($where, '');//添加try
		}catch(Exception $e){
			core::alert('数据库连接失败');
		}
		$page = new pagination($manager, 10, $page);  //分页
		
		
		/*$to="$_POST['to']";
		$subject="$_POST['title']";
		$message="$_POST['content']";
		$from="$_POST['from']";
		$headers="From:$from";
		mail($to,$subject,$message,$headers);
		echo "Mail Sent.";*/
		template('commend', array('page'=>$page), 'default/front/commend');
		}
		
		public static function commendAdd(){
			
			
		}







}









?>