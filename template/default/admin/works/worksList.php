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
	$.post('<?=URL?>index.php/admin/works/worksDelete', str, function(data){
		alert(data);
		var page = $('#page').html();
		window.location.href = '<?=URL?>index.php/admin/works/worksList?page='+page;
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
	$.post('<?=URL?>index.php/admin/works/worksDelete', str, function(data){
		var page = $('#page').html();
		window.location.href = '<?=URL?>index.php/admin/works/worksList?page='+page;
	});
	return false;
}


</script>


<ul id="container">
  <li id="header">
    <h1>作品管理</h1>
    <div class="link"></div>
    <div id="desc">
      <div id="page-selector">
		</div>
      <span>作品列表</span> </div>
  </li>
  <li id="tips">
 	<a href="<?=URL?>index.php/admin/works/worksEdit"><span style="font-size:14px;font-weight:bold;"> >>发布作品</span></a>
  </li>
</ul>
	<span style="display:none" id="page"><?=$_GET['page']?></span>
    <table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
    <tr>
        <th class="first-cell" width="100">编号</th>
        <th width="250">作品名称</th>
        <th width="120">作品描述</th>
        <th width="120">显示图片</th>
        <th width="160">显示首页</th>
        <th width="150">操作</th>
    </tr>
    <?php
    foreach ($works->objectList() as $v){
    ?>
    <tr>
        <td><input type="checkbox" value="<?=$v->id?>" /><?=$v->id?></td>
        <td><?=$v->wname?></td>
        <td><?=$v->des?></td>
        <td>查看</td>
        <td><a href="#none"><?php if($v->isindex){?><img class="isindex" id="<?=$v->id?>" name="<?=$v->isindex?>" src="<?=MEDIA_URL?>img/admin/yes.gif"/><?php }else{ ?><img class="isindex" id="<?=$v->id?>" name="<?=$v->isindex?>" src="<?=MEDIA_URL?>img/admin/no.gif"/><?php }?></a></td>
        <td>
          <a href="<?=URL?>index.php/admin/works/worksEdit?id=<?=$v->id?>">修改</a>
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
    <?=$works->getHtml("?sort=$type")?>
</body>
<script>
//更改是否显示首页
$(".isindex").click(function(){
	var current = $(this);
	$.get("<?php echo URL; ?>index.php/admin/works/changeInd",{id:$(current).attr("id"),vid:$(current).attr("name")},function(data){
		if(data==1){
             $(current).attr("src","<?php echo MEDIA_URL; ?>img/admin/yes.gif");
			 $(current).attr("name","1");
		}else if (data==2){
			 $(current).attr("src","<?php echo MEDIA_URL; ?>img/admin/no.gif");
			  $(current).attr("name","0");
		}
	});
});

</script>
</html>
