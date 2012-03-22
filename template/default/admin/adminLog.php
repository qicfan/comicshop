<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>漫淘客商城</title>

<link href="<?=MEDIA_URL?>css/general.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://static.comicyu.com/js/jquery.js"></script>
<script type="text/javascript" src="http://static.comicyu.com/js/ajax.js"></script>
</head>

<body>
<script>
//全选
function selAll() {
    $('input:checkbox').attr('checked', true);
	return false;
}
//全不选
function selNo() {
    $('input:checkbox').attr('checked', false);
	return false;
}

//单个删除
function soloDel( str ){
	str = {id:str};
	$.post('<?=URL?>index.php/admin/admin/adminLogDel', str, function(data){
		var page = $('#page').html();
		window.location.href = '<?=URL?>index.php/admin/admin/adminLog?page='+page;
	});
	return false;
}
//批量删除
function multiDel(){
	var str = '';
    $(':checkbox:checked').each( function(){
    	str += $(this).val() + ',';
    });
	str = {id:str};
	$.post('<?=URL?>index.php/admin/admin/adminLogDel', str, function(data){
		var page = $('#page').html();
		window.location.href = '<?=URL?>index.php/admin/admin/adminLog?page='+page;
	});
	return false;
}
</script>

<ul id="container">
    <li id="header">
      <h1>管理员管理</h1>
      <div class="link"></div>
      <div id="desc">管理员列表</div>
    </li>
</ul>
	<span style="display:none" id="page"><?=$_GET['page']?></span>
	<table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
    <tr>
        <th class="first-cell" width="100">编号</th>
        <th width="150">操作者</th>
        <th width="200">操作内容</th>
        <th width="160">操作时间</th>
        <th width="150">IP地址</th>
        <!--
        <th width="150">操作</th>
        -->
    </tr>
    <?php
    foreach ($page->objectList() as $v){
    ?>
    <tr>
        <td><input type="checkbox" value="<?=$v->id?>" /><?=$v->id?></td>
        <td>
		<?php
        foreach ($admin as $a) {
            if ($a->id == $v->adminid) {
                echo $a->uname;
                break;
            }
        }
        ?>
        </td>
        <td><?=$v->logcontent?></td>
        <td><?=date('Y-m-d H:i:s',$v->logtime)?></td>
        <td><?=$v->ip?></td>
        <!--
        <td>
        <a href="javascript:void(0);" onclick="return soloDel(<?=$v->id?>);">删除日志</a>
        </td>
        -->
    </tr>
    <?php
    }
    ?>
    <!--
    <tr><td colspan="6">
    <a href="javascript:void(0);" onclick="return selAll();">全选</a>
    /<a href="javascript:void(0);" onclick="return selNo();">全不选</a>
     | <a href="javascript:void(0);" onclick="return multiDel();">批量删除</a>
    </td></tr>
    -->
    </table>
    <?=$page->getHtml("?sort=$type")?>   
</body>
</html>
