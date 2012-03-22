<?php
	if (!defined("PRO_ROOT")) {
		exit();
	}
/**
 * 购物车
 */
require_once PRO_ROOT . 'models.php';
require_once PRO_ROOT . 'include/cartFun.class.php';
require_once PRO_ROOT . 'include/goods.class.php';
require_once PRO_ROOT . 'include/base.class.php';
require_once PRO_ROOT . 'include/recommendFun.class.php';
class cartViews{
	/**********************************************************
	 * 添加购物车 （更据loca区分是添加购物车1，还是立即购买2）
	 ***********************************************************/
	public static function cartInsert(){
		$gid = $_GET['gid'];    //传来的商品
		$loca = $_GET['loca'];
		$count = isset($_GET['count'])?$_GET['count']:1;
		$login = auth::isUserLogin();    //判断用户是否登录
		if($login){
			$uid = auth::getUserId();
			$che = cartFun::checkCartGoods($gid,$uid,'');    //检查购物车中是否存在此商品
			if($che == 'exist'){
				if($loca == 2){
					base::autoSkip("sorry 购物车中已经存在此商品！","正在转入",URL."index.php/front/cart/cartSelect",3);
				}
				if($loca ==1){
					echo 'cunzai';
					//echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"> ";
					//echo "<script>alert('Sorry,您的购物车中已经存在此商品了！');<script>";
				}
				die;
			}
			$goods = Ware::GetOne($gid);
			if($count > $goods->leavingcount){
				if($loca == 2){
					base::autoSkip("sorry 库存量不足！","正在转入",URL."index.php/front/cart/cartSelect",3);
				}
				if($loca ==1){
					echo 'buzu';
					//echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"> ";
					//echo "<script>alert('Sorry,库存量不足！');<script>";
				}
				die;
			}		
			$rel = cartFun::cartAdd($gid,$uid,'',$count);	
		}else{
			if(isset($_COOKIE['cart'])){
				$cartcode = $_COOKIE['cart'];
				$che = cartFun::checkCartGoods($gid,0,$cartcode);    //检查购物车中是否存在此商品
				if($che =='exist'){
					if($loca == 2){
						base::autoSkip("sorry 购物车中已经存在此商品！","正在转入",URL."index.php/front/cart/cartSelect",3);
					}
					if($loca ==1 ){
						echo 'cunzai';
						//echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"> ";
						//echo "<script>alert('Sorry,购物车中已经存在此商品！');<script>";
					}
					die;
				}
				$goods = Ware::GetOne($gid);
				if($count > $goods->leavingcount){
					if($loca == 2){
						base::autoSkip("sorry 库存量不足！","正在转入",URL."index.php/front/cart/cartSelect",3);
					}
					if($loca ==1){
						echo 'buzu';
						//echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"> ";
						//echo "<script>alert('Sorry,库存量不足！');<script>";
					}
					die;
				}		
				$rel = cartFun::cartAdd($gid,0,$cartcode,$count);
			}else{
				$cartcode = cartFun::getCartNumber();    //获取购物车编号
				setcookie('cart',$cartcode,null,'/');
				$goods = Ware::GetOne($gid);
				if($count > $goods->leavingcount){
					if($loca == 2){
						base::autoSkip("sorry 库存量不足！","正在转入",URL."index.php/front/cart/cartSelect",3);
					}
					if($loca ==1){
						echo 'buzu';
						//echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"> ";
						//echo "<script>alert('Sorry,库存量不足！');<script>";
					}
					die;
				}		
				$rel = cartFun::cartAdd($gid,0,$cartcode,$count);
			}
		}
		
		if($rel && $loca ==1){
			echo 'ok';
			//echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"> ";
			//echo "<script>alert('恭喜您，已成功加入购物车！');<script>";
			die;
		}
		if($rel && $loca ==2){
			//base::autoSkip("恭喜您，购买成功！","正在转入",URL."index.php/front/cart/cartSelect",0);
			header("location:".URL."index.php/front/cart/cartSelect");
			die;
		}
	}


	/************************************************************
	 * 我的购物车
	 ************************************************************/
	public static function cartSelect(){
		$login = auth::isUserLogin();    //判断用户是否登录
		if($login){
			$uid = auth::getUserId();
			$cart = cartFun::getCart($uid,'');
		}else{
			if($_COOKIE['cart']){
				$cart = cartFun::getCart(0,$_COOKIE['cart']);
			}else{
				$cart =null;
			}
		}
		if($cart){
			foreach ($cart as $item){    //获取商品图片
				$pic = Ware::GetGoodsImg($item->goodsid);
				$item->pic=$pic[0];
			}
			$arry =array();
			$gidarry =array();
			foreach($cart as $itm){
				$gidarry[]=$itm->goodsid;
				$recommend=recommendFun::recommendGoods($itm->goodsid);    //获取此商品的推荐商品
				foreach ($recommend as $obj){
					$arry[]=$obj;
				}
			}
			$gids = recommendFun::array_unique_TD($arry);    //去重复项
			$regoods = array();
			foreach ($gids as $gd){    //获取商品信息
				if(!in_array($gd,$gidarry)){    //去掉原商品
					$ginfo = Ware::GetOne($gd);
					if($ginfo){
						$pic = Ware::GetGoodsImg($gd);
						$ginfo->pic=$pic[0];
						$regoods[]=$ginfo;
					}
				}
			}
			template("cart_list", array('cart'=>$cart,'regoods'=>$regoods), "default/front/cart");
		}else{

			template("cart_null", array('cart'=>$cart), "default/front/cart");
		}
	}


	/*****************************************************
	 * 购物车简要信息（用于header）
	 *****************************************************/
	public static function cartBrief(){
		$login = auth::isUserLogin();    //判断用户是否登录
		if($login){
			$uid = auth::getUserId();
			$cart = cartFun::getCart($uid,'');
		}else{
			if($_COOKIE['cart']){
				$cart = cartFun::getCart(0,$_COOKIE['cart']);
			}else{
				$cart =null;
			}
		}
		foreach ($cart as $item){    //获取商品图片
			$pic = Ware::GetGoodsImg($item->goodsid);
			$item->pic=$pic[0]['apath'].$pic[0]['filename'].'.'.$pic[0]['atype'];
		}
		print_r(json_encode($cart));
	}

	
	/*****************************************************
	 * 购物车数量修改
	 *****************************************************/
	public static function upCount(){
		$cart = $_POST['cartid'];
		$count = $_POST['count'];
		$gid = $_POST['gid'];
		//$rel = cartFun::updateCount($cart,$count,$gid);
		$goods = Ware::GetOne($gid);
		if($count > $goods->leavingcount){
			echo 'buzu';
			die;
		}
		$login = auth::isUserLogin();    //判断用户是否登录
		if($login){    //判断是否登录
			$uid = auth::getUserId();
			$cartcode = '';
		}else{
			$uid = 0;
			$cartcode = $_COOKIE['cart'];
		}
		$rel = cartFun::changeCartCount($cart,$count,$uid,$cartcode,$gid);
		if($rel == 1){
			$shopmoney = 0;
			$marketmoney = 0;
			$mark = 0;
			$cartinfo = cartFun::getCart($uid,$cartcode);
			foreach ($cartinfo as $item){
				$shopmoney = ($shopmoney + $item ->mprice * $item ->goodscount);
				$marketmoney = ($marketmoney + $item->marketprice * $item ->goodscount);
				$mark = ($mark + $item ->mark);
			}
			$yh = $marketmoney - $shopmoney;
			$arr = array('yh'=>$yh,'money'=>$shopmoney,'mark'=>$mark);
			echo json_encode($arr);
		}else{
			echo 'no';
		}
		die;
	}

	/*************************************************
	 * 获取商品的剩余数量
	 *************************************************/
	 public static function gCount(){
		$gid =$_POST['gid'];
		$goods = Ware::GetOne($gid);
		echo  $goods->leavingcount;
	 }

	/*****************************************************
	 * 购物车删除
	 *****************************************************/
	public static function delCart(){
		$cart = $_GET['cart'];
		$login = auth::isUserLogin();    //判断用户是否登录
		if($login){
			$uid = auth::getUserId();
			$cartcode = '';
		}else{
			$uid = 0;
			$cartcode = $_COOKIE['cart'];
		}
		$check = cartFun::checkUserCart($cart,$uid,$cartcode);    //检查购物车中的商品
		if($check){
			$rel = cartFun::delCart($cart);
			if($rel){
				base::autoSkip("删除成功","正在转入",URL."index.php/front/cart/cartSelect",3);
			}
		}
		die;
	}

	/****************************************************
	 * 清空购物车
	 ****************************************************/
	public static function clearCart(){
		//auth::authUser();
		$login = auth::isUserLogin();    //判断用户是否登录
		if($login){    //判断是否登录
			$uid = auth::getUserId();
			$cartcode = '';
		}else{
			if(isset($_COOKIE['cart'])){
				$cartcode = $_COOKIE['cart'];
				$uid = 0;
			}
		}
		$rel = cartFun::clearCart($uid,$cartcode);
		if($rel){
			base::autoSkip("清除成功","正在转入",URL."index.php/front/cart/cartSelect",3);
		}
		die;
	}
}
?>