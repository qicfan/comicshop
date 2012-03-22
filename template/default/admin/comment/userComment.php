<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>漫淘客商城</title>
</head>

<body>
<script>
function verify(){
	var title = document.getElementById('title').value;
	var good = document.getElementById('good').value;
	var bad = document.getElementById('bad').value;
	var summary = document.getElementById('summary').value;
	if (title == '') {
		alert('请填写标题');
		return false;
	}
	if (good == '' && bad == '') {
		alert('缺点和优点至少填一项');
		return false;
	}
	if (summary == '') {
		alert('请填写总结');
		return false;
	}
}
</script>

<form action="<?=URL?>index.php/admin/comment/userComment?act=submit&gid=<?=$gid?>" name="form1" method="post" onsubmit="return verify();">
<table style="border:none;">
    <tr>
        <td>打个总分</td>
        <td><input type="radio" name="score" value="1" />1
         | <input type="radio" name="score" value="2" />2
         | <input type="radio" name="score" value="3" />3
         | <input type="radio" name="score" value="4" />4
         | <input type="radio" name="score" value="5" checked="checked" />5</td>
    </tr>
	<tr>
    	<td width="80">写个标题</td>
		<td><input type="text" name="title" id="title" value="" /></td>
    </tr>
    <tr>
    	<td>优点</td>
		<td><textarea cols="50" name="good" id="good" rows="5"></textarea></td>
    </tr>
    <tr>
    	<td>缺点</td>
		<td><textarea cols="50" name="bad" id="bad" rows="5"></textarea></td>
    </tr>
    <tr>
    	<td>总结</td>
		<td><textarea cols="50" name="summary" id="summary" rows="5"></textarea></td>
    </tr>
</table>
    <br/><input type="submit" value="提交" />
</form>
</body>
</html>
