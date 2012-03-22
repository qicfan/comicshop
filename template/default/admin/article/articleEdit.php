<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>漫淘客商城</title>
<script type="text/javascript" src="http://static.comicyu.com/js/jquery.js"></script>
<script type="text/javascript" src="http://static.comicyu.com/js/ajax.js"></script>
<link href="<?=MEDIA_URL?>css/general.css" rel="stylesheet" type="text/css" />
</head>

<body>
<script src="<?=MEDIA_URL?>plugin/ckeditor3/ckeditor.js"></script>
<script>
$(document).ready(function(){
	//自动选择分类
	$('#sort<?=$article->sort?>').attr('selected', 'selected');
	//自动选择显示状态
	$('#status<?=$article->status?>').attr('checked', 'checked'); 
});

function verify(){
	var title = document.getElementById('title').value;
	var content = document.getElementById('content').value;
	if (title == '' || content== '') {
		alert('请认真填写文章信息');
		return false;
	}
	return true;
}
</script>

  <ul id="container">
    <li id="header">
      <h1>文章管理</h1>
      <div class="link"></div>
      <div id="desc">编辑文章</div>
    </li>
  </ul>
<div style="padding:10px;">
<form action="<?=URL?>index.php/admin/article/articleUpdate" name="form1" method="post" onsubmit="return verify();">
<table style="border:none;">
	<tr>
    	<td width="80"><strong>文章标题</strong></td>
		<td><input type="text" name="title" id="title" value="<?=$article->title?>" size="60" /></td>
    </tr>
    <tr>
    	<td><strong>文章分类</strong></td>
		<td><select name="sort" id="sort">
                <?=other::getArticleTree();?>
            </select></td>
    </tr>
    <tr>
        <td><strong>显示状态</strong></td>
        <td><input type="radio" name="status" id="status1" value="1" checked="checked" />显示
         | <input type="radio" name="status" id="status0" value="0" />不显示
         | <input type="radio" name="status" id="status2" value="2" />显示并置顶</td>
    </tr>
</table>
	<textarea cols="80" name="content" id="content" rows="10"><?=isset($content) ? $content : '文章内容'?></textarea>
	<script>
    if (typeof CKEDITOR == 'undefined') { 
        document.write('加载CKEditor失败');
    } else { 
        var editor = CKEDITOR.replace('content');
    }
    </script>
    <input type="hidden" name="id" value="<?=$article->id?>" />
    <br/><input type="submit" value="提交" />
</form>
</div>
</body>
</html>
