<?php
class proFun {
	/**
	 * 禁止实例化
	 */
	private function __construct() {
	}

	/**
	 * 判断某活动是否可以添加某商品
	 * @param int $gid 商品id
	 * @param int $actid 活动id
	 */
	public static function checkActivityGoods($gid,$actid){
		$t1 = proFun::checkActivityByGid($gid,$actid);    //检查促销商品是否存在
		$t2 = proFun::checkIsonsaleByGid($gid);    //检查商品是否上架
		if($t1){
			return false;
		}
		$rel = proFun::getActivityByGid($gid);    //获取商品所对应的活动
		if($t2){
			if($rel){
				$typ1 = proFun::getTypeByActid($actid);    //获取目标活动的类型
				foreach ($rel as $item){
					$typ = proFun::getTypeByActid($item->act_id);    //获取活动所对应的类型
					if($typ==$typ1){
						return false;
					}
				}
			}
		}
		return true;
	}

	/**
	 * 检查商品是否上架
	 * @param int $gid 商品id
	 */
	public static function checkIsonsaleByGid($gid){
		try{
			$rel = goods::objects()->get("id='$gid' AND isonsale!=0");
		} catch (Exception $e) {
			$rel = false;
		}
		return $rel;
	}

	/**
	 * 检查促销商品是否存在
	 * @param int actid 活动id
	 * @param int gid 商品id
	 * @return 存在返回true 不存在false
	 */
	public static function checkActivityByGid($gid,$actid){
		try{
			$rel = goods_activity::objects()->get("goods_id = $gid AND act_id = $actid");
		} catch (Exception $e) {
			$rel = false;
		}
		return $rel;
	}

	/**
	 * 获取商品所对应的活动
	 * @param int $gid 商品id
	 */
	public static function getActivityByGid($gid){
		try{
			$rel = goods_activity::objects()->filter("goods_id = $gid");
		} catch (Exception $e) {
			$rel = false;
		}
		return $rel;
	}
	
	/*
	 * 获取商品所对应的活动（无分页）
	*/
	public static function GetActivitiesByGid($gid){
		global $db;
		$sql = "SELECT * FROM activity as a INNER JOIN goods_activity as ga ON a.id=ga.act_id WHERE ga.goods_id=".$gid;
		try{
			$rs = $db->prepare($sql);
			$rs->setFetchMode(PDO::FETCH_ASSOC);
			$rs->execute();
			$result = $rs->fetchAll();
			$rs->closeCursor();
			return $result;
		}catch(DZGException $d){
			return false;
		}
	}

	/**
	 * 获取促销活动对应的类型
	 * @param int act_id 活动id
	 */
	public static function getTypeByActid($act_id){
		try{
			$rel = activity::objects()->get("id = '$act_id'");
		} catch (Exception $e) {
			$rel = false;
		}
		if($rel){
			return $rel->activity_type;
		}
	}

	/**
	 * 删除促销说对应的促销商品
	 */
	public static function proGoodsDel($proid){
		$gact = new goods_activity();
		$gact->act_id = $proid;
		$rel = $gact->delete();
		if($rel){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * 判断全局活动中是否存在此类活动
	 * @param int $typ 类
	 */
	public static function proGlobalByType($typ){
		try{
			$rel = activity::objects()->filter("activity_type ='$typ' AND act_type =1");
		} catch (Exception $e) {
			$rel = false;
		}
		if($rel){
			return true;
		}else{
			return false;
		}
	}
	
	/*
	 * 获取全部的方案
	*/
	public static function GetAll(){
		try{
			return activity::objects()->all(" id DESC");
		}catch(DZGException $d){
			return false;
		}
	}
	
	/*
	 * 给商品添加促销方案
	 * @param int $gid
	 * @param int $aid 促销方案的id
	*/
	public static function Add($gid,$aid){
		try{
			$ac = new goods_activity();
			$ac->goods_id = $gid;
			$ac->act_id = $aid;
			return $ac->save();
		}catch(DZGException $d){
			return false;
		}
	}
	
}
?>