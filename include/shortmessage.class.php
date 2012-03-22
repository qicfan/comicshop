<?php
/*
 * author MFF
 * date 2010
 * 短消息的操作
*/
if (!defined("PRO_ROOT")) {
	exit();
}
require_once PRO_ROOT . 'models.php';
require_once PRO_ROOT . 'include/base.class.php';

class SmessageFun{

	//	短消息发送接口
	public static function shortmessageSend($toId,$title,$content,$fromName){
		$time = time();
		$shortmessage = new shortmessage();
		$shortmessage->tid = $toId;
		$shortmessage->title = base::wordFilter($title);
		$shortmessage->content = base::wordFilter($content);
		$shortmessage->fromname = $fromName;
		$shortmessage->stime = $time;
		$shortmessage->smtype = 1;
		if($shortmessage->save()){
			return true;
		}else{
			return false;
		}
		
	}
	
//	系统公告添加
	public static function AddAnnouncement($titile,$content,$fromName="漫淘客客服"){
		
		$time = time();
		$shortmessage = new shortmessage();
		$shortmessage->title = base::wordFilter($title);
		$shortmessage->content = base::wordFilter($content);
		$shortmessage->fromname = $fromName;
		$shortmessage->stime = $time;
		$shortmessage->smtype = 0;
		if($shortmessage->save()){
			return true;
		}else{
			return false;
		}
	}
}
?>