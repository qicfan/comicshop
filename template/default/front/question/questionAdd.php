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
	var title = document.getElementById('title').value;
	var content = document.getElementById('content').value;
	var type = document.getElementById('type').value;
	if (content== '' ||type== '') {
		alert('请认真填写咨询描述');
		return false;
	}
	return true;
}
</script>

<form action="" name="form1" method="post" onsubmit="return verify();">
<table style="border:none;">
    <tr>
        <td>咨询类型</td>
        <td><input type="radio" name="type" value="1" <? if($type=='1') echo 'checked'; ?> />商品咨询
         | <input type="radio" name="type" value="2" <? if($type=='2') echo 'checked'; ?> />库存配送
         | <input type="radio" name="type" value="3" <? if($type=='3') echo 'checked'; ?> />支付
         | <input type="radio" name="type" value="4" <? if($type=='4') echo 'checked'; ?> />发票保修</td>
    </tr>
	<tr>
    	<td width="80">主题</td>
		<td><input type="text" name="title" id="title" value="<?=$title?>" /></td>
    </tr>
    <tr>
    	<td>描述</td>
		<td><textarea cols="50" name="content" id="content" rows="5"><?=$content?></textarea></td>
    </tr>
</table>
    <br/><input type="submit" value="提交" />
</form>
</body>
</html>
