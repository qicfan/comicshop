<?php
/**
 * 优惠券用户显示
 * @author mff
 */
header("content-type:text/html; charset=utf-8");
if (!defined("PRO_ROOT")) {
	exit();
}

require_once PRO_ROOT . 'models.php';
require_once DZG_ROOT . 'core/pagination/pagination.php';

class usercouponViews{


	public static function cpShow(){
		auth::authUser();
 		$uid = auth::getUserId();
		$uname=auth::getUserName();//添加用户名，便于查询
		$page = intval( $_GET['page'] );
		$ntime=time();
		//$where="uid='$uid' and state = 1";
		$where="uid='$uid'";
		//$where="uid=26 and deadline>'$time' ";
		try{
			$manager = coupon::objects()->filter($where, '');//添加try
		}catch(Exception $e){
			core::alert('数据库连接失败'); 
		}
		$navigation = NAV_MY . '> <a>优惠券</a>';
		$webTitle = TITLE.'优惠券';

		template('cpShow', array('manager'=>$manager,'ntime'=>$ntime,'navigation'=>$navigation,'uname'=>$uname,'webTitle'=>$webTitle), 'default/front/usercoupon');
	}
	
	
	public static function cpAdd(){
		//通过验证输入的密码来查询数据库。如果查到则添加该优惠券至此用户
		auth::authUser();
 		$uid = auth::getUserId();
		if(count($_POST)){
			$cpcode=trim($_POST['cpcode']);
			//core::alert("$cpcode");
			$where="activecode='$cpcode'";
			try{
				$manager=coupon::objects()->get($where,'');
				//core::alert("$manager->id");
			}catch(Exception $e){
			core::alert('密码不存在'); 
			}
		$time=time();
		//core::alert("$time");
		if($manager->deadline<$time){
			core::alert('优惠券过期了');
		}
		if(!$manager->uid&&$manager->state==0){
			$manager->uid=$uid;//应用时改成COOKIE
			$manager->state=1;
			if($manager->save()){
				core::alert('您已经激活了优惠卡！');
				
			}else{
				core::alert('密码不正确或者优惠卡已经用过了！');
			}
		}else{
			core::alert('密码不正确或者已经用过了！');
		}
		}
		template('usercpAdd',array(),'default/front/usercoupon');
		
	}
	
	public static function usedCoupon(){
		auth::authUser();
 		$uid = auth::getUserId();
		$page = intval( $_GET['page'] );
		$time=time();
		$where="uid='$uid' and state=2";
		//$where="uid=26 and deadline>'$time' ";
		try{
			$manager = coupon::objects()->filter($where, '');//添加try
		}catch(Exception $e){
			core::alert('数据库连接失败'); 
		}
		//$page = new pagination($manager, 2, $page);  //分页
		//template('usedcpShow', array('page'=>$page), 'default/front/usercoupon');
		//$test=$page->objectList();
		//echo $j = json_encode($test);
		//return $manager;
		 echo json_encode($manager);
		 
		//$y=json_decode($x);
		//print $x->code;
	}
	
	
	public static function passedCoupon($uid){
		//auth::authUser();
 		//$uid = auth::getUserId();
		$page = intval( $_GET['page'] );
		$time=time();
		$where="uid='$uid' and deadline<'$time'";
		//$where="uid=26 and deadline>'$time' ";
		try{
			$manager = coupon::objects()->filter($where, '');//添加try
		}catch(Exception $e){
			core::alert('数据库连接失败'); 
		}
		return $manager;
		//$page = new pagination($manager, 2, $page);  //分页
		//template('passedcpShow', array('page'=>$page), 'default/front/usercoupon');
	
	}
	

}












?>                 