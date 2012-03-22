<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>漫淘客商城</title>
<script type="text/javascript" src="http://static.comicyu.com/js/jquery.js"></script>
<script type="text/javascript" src="http://static.comicyu.com/js/ajax.js"></script>
</head>

<body>
<script>
function verify(){
	var url = document.getElementById('url').value;
	var content = document.getElementById('content').value;
	
	if (url == '' || content== '' ) {
		alert('请认真填写留言信息');
		return false;
	}
	return true;
}
</script>

<form action="" name="form1" method="post" onsubmit="return verify();">
<table style="border:none;">
	<tr>
    	<td width="80">相关链接</td>
		<td><input type="text" name="url" id="url" value="<? echo ($url)?$url:'http://'; ?>" /></td>
    </tr>
    <tr>
    	<td>举报内容</td>
		<td><textarea cols="50" name="content" id="content" rows="5"><?=$content?></textarea></td>
    </tr>
</table>
    <br/><input type="submit" value="提交" />
</form>
</body>
</html>