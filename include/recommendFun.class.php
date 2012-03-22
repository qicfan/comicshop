<?php
class recommendFun{
	
	/********************************************
	 * 获取商品所属品牌
	 * @param int $gid 商品id
	 ********************************************/
	public static function getGoodsBrand($gid){
		try{
			return goodsbrand::objects()->filter("gid='$gid'");
		}catch (Exception $e) {
			return array();
		}
	}

	/********************************************
	 * 获取品牌标签下的商品
	 * @param int $bid 品牌id
	 ********************************************/
	public static function getBrandGoods($bid){
		try{
			return  goodsbrand::objects()->filter("bid='$bid'");
		}catch (Exception $e) {
			return array();
		}
	}


	/********************************************
	 * 获取商品的推荐商品
	 * @param int $gid 商品id
	 ********************************************/
	public static function recommendGoods($gid){
		$rel = self::getGoodsBrand($gid);    //获取商品品牌标签
		if($rel){
			$arr = array();
			foreach ($rel as $itm){
				$bg = self::getBrandGoods($itm->bid);    //获取品牌标签商品
				if($bg){
					foreach ($bg as $obj){
						if($obj->gid != $gid){
							$ary['gid']=$obj->gid;
							$arr[]=$ary;
						}
					}
				}
			}
			return $arr;
		}
	}

	/*********************************************
	 * 二维数组去重复项
	 * @param array $array2D 二维数组
	 *********************************************/
	public static function array_unique_TD($array2D){
		foreach ($array2D as $item){
			$item = join(",",$item);    //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
			$temp[] = $item;
		}
		$tem = array_unique($temp);    //去掉重复的字符串,也就是重复的一维数组
		
		/*foreach ($tem as $k => $v){    //重组成二维数组
			$arry[$k] = explode(",",$v);   //再将拆开的数组重新组装
		}*/
		//print_r($arry);
		return $tem;
	}

}
?>