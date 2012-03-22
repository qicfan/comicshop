<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>漫淘客商城</title>
<script type="text/javascript" src="http://static.comicyu.com/js/jquery.js"></script>
<script type="text/javascript" src="http://static.comicyu.com/js/ajax.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?=MEDIA_URL?>css/general.css" rel="stylesheet" type="text/css" />
</head>
<body>
<script>
$(document).ready(function(){
	//选择分类
	$("#sort").change( function(){
		window.location.href = '<?=URL?>index.php/admin/article/articleList?sort='+$("#sort").val();
	});
});

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
	if( !confirm('确定要删除么？') ) {
		return false;
	}
	str = {id:str};
	$.post('<?=URL?>index.php/admin/article/articleDelete', str, function(data){
		var page = $('#page').html();
		window.location.href = '<?=URL?>index.php/admin/article/articleList?page='+page;
	});
	return false;
}
//批量删除
function multiDel(){
	if( !confirm('确定要删除么？') ) {
		return false;
	}
	var str = '';
    $(':checkbox:checked').each( function(){
    	str += $(this).val() + ',';
    });
	str = {id:str};
	$.post('<?=URL?>index.php/admin/article/articleDelete', str, function(data){
		var page = $('#page').html();
		window.location.href = '<?=URL?>index.php/admin/article/articleList?page='+page;
	});
	return false;
}
</script>


<ul id="container">
  <li id="header">
    <h1>文章管理</h1>
    <div class="link"></div>
    <div id="desc">
      <div id="page-selector">
		</div>
      <span>文章列表</span> </div>
  </li>
  <li id="tips">
    <select name="sort" id="sort">
    	<option>选择分类...</option>
        <?=other::getArticleTree();?>
    </select>
     | <a href="<?=URL?>index.php/admin/article/articleEdit">添加新文章</a>
  </li>
</ul>
	<span style="display:none" id="page"><?=$_GET['page']?></span>
    <table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
    <tr>
        <th class="first-cell" width="100">编号</th>
        <th width="250">文章标题</th>
        <th width="120">文章分类</th>
        <th width="120">文章状态</th>
        <th width="160">发布日期</th>
        <th width="150">操作</th>
    </tr>
    <?php
    foreach ($page->objectList() as $v){
    ?>
    <tr>
        <td><input type="checkbox" value="<?=$v->id?>" /><?=$v->id?></td>
        <td><?=$v->title?></td>
        <td>
        <?php
        foreach ($sort as $s) {
            if ($s->id == $v->sort) {
                echo $s->sortname;
                break;
            }
        }
        ?>
        </td>
        <td>
        <?php
        switch ($v->state) {
            case 2:
                echo '显示并置顶';
                break;
            case 1:
                echo '显示';
                break;
            default:
                echo '不显示';
                break;
        }
        ?>
        </td>
        <td><?=date('Y-m-d H:i:s',$v->createtime)?></td>
        <td>
        <a href="<?=URL?>index.php/admin/article/articleShow?id=<?=$v->id?>" target="_blank">查看</a>
         | <a href="<?=URL?>index.php/admin/article/articleEdit?id=<?=$v->id?>">修改</a>
         | <a href="javascript:void(0);" onclick="return soloDel(<?=$v->id?>);">删除</a>
        </td>
    </tr>
    <?php
    }
    ?>    
    <tr><td colspan="6">
    <a href="javascript:void(0);" onclick="return selAll();">全选</a>
    /<a href="javascript:void(0);" onclick="return selNo();">全不选</a>
     | <a href="javascript:void(0);" onclick="return multiDel();">批量删除</a>
    </td></tr>
    </table>
    <?=$page->getHtml("?sort=$type")?>
</body>
</html>
