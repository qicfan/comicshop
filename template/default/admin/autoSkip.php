<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>漫淘客商城</title>
<script type="text/javascript" src="http://static.comicyu.com/js/jquery.js"></script>
<script type="text/javascript" src="http://static.comicyu.com/js/ajax.js"></script>
<link href="<?=MEDIA_URL?>css/general.css" rel="stylesheet" type="text/css" />
<style>
body{ font-size:14px; line-height:20px; }
.main{ position:absolute; padding:60px;}
.title{ font-size:16px; font-weight:bold; margin-left:10px; }
.word{ margin-left:50px;}
</style>
<script>
function clock(){
	var i = $('#time').html(i);
	i = parseInt(i) - 1;
	$('#time').html(i);
	if (i <= 0){
		window.location.href = '<?=$href?>';
		return false;
	}
	var time = <?=$time?>;
	time = time * 100;
	setTimeout('clock()', time);
}
</script>
</head>

<body onload="clock();">
<div class="main">
	<div><img src="<?=MEDIA_URL?>img/admin/icon_notice.gif" align="absmiddle">
    <span class="title"><?=!empty($title) ? $title : '操作成功' ?></span></div>
    <br/>
	<div class="word">页面将在 <span id="time"><?=$time?></span> 秒之后自动跳转。</div>
    <div class="word"><a href="<?=$href?>"><?=!empty($content) ? $content : '直接进入' ?></a></div>
    <div class="word"><a href="<?=$href2?>"><?=$content2?></a></div>
</div>
</body>
</html>
