<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="http://static.comicyu.com/js/jquery.js"></script>
<script type="text/javascript" src="http://static.comicyu.com/js/ajax.js"></script>
<link href="<?=MEDIA_URL?>css/general.css" rel="stylesheet" type="text/css" />
<title>漫淘客商城</title>
</head>

<body>
<script>
$(document).ready(function(){
	//选择分类
	$("#state").change( function(){
		window.location.href = '<?=URL?>index.php/admin/quiz/quizList?type=<?=$type?>&state='+$("#state").val();
	});
	$("#type").change( function(){
		window.location.href = '<?=URL?>index.php/admin/quiz/quizList?state=<?=$state?>&type='+$("#type").val();
	});
});
</script>

  <ul id="container">
    <li id="header">
      <h1>留言管理</h1>
      <div class="link"></div>
      <div id="desc">
      <?php
	  if ( empty($act) ) {
      	  echo '用户提问列表';
	  } else if ($act == 1) {
	  	  echo '用户投诉列表';
	  }
	  ?>
      </div>
    </li>
  <li id="tips">
<select name="state" id="state">
  <option value="" <? if($state=='') echo 'selected'; ?> >所有状态</option>
  <option value="2" <? if($state=='2') echo 'selected'; ?>>未回复</option>
  <option value="1" <? if($state=='1') echo 'selected'; ?>>已回复</option>
</select>
<select name="type" id="type">
  <option value="" <? if($type=='') echo 'selected'; ?>>所有分类</option>
  <option value="1" <? if($type=='1') echo 'selected'; ?>>商品咨询</option>
  <option value="2" <? if($type=='2') echo 'selected'; ?>>库存配送</option>
  <option value="4" <? if($type=='3') echo 'selected'; ?>>发票保修</option>
  <option value="3" <? if($type=='4') echo 'selected'; ?>>支    付</option>

</select>
  </li>
</ul>
<span style="display:none" id="page"><?=$_GET['page']?></span>
<table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
<tr>
    <th width="250">留言主题</th>
    <th width="150">留言者</th>
    <th width="150">相关商品</th>
    <th width="100">状态</th>
    <th width="160">留言时间</th>
    <th width="160">回复时间</th>
    <?php
	if ( $verify ) {
	?>
    <th width="160">审核状态</th>
    <?php
	}
	?>
    <th width="100">操作</th>
</tr>
<?php
foreach ($page->objectList() as $v){
?>
<tr>
	<td><?=$v->title?></td>
    <td><?=base::getUserName($v->uid)?></td>
    <td><?=base::getGoodsName($v->gid)?></td>
    <td>
	<?php
	switch ($v->state) {
		case 1:
			echo '已回复';
			break;
		default:
			echo '未回复';
			break;
	}
	?>
    </td>
	<td><?=date('Y-m-d H:i:s',$v->questiontime)?></td>
    <td><?=empty($v->replytime) ? '-' : date('Y-m-d H:i:s',$v->replytime)?></td>
    <?php
	if ( $verify ) {
		if ($v->verify == '1') {
			echo '<td>已审核</td>';
		} else {
			echo '<td>未审核</td>';
		}
	}
	?>
    <td><a href="<?=URL?>index.php/admin/quiz/quizReply?id=<?=$v->id?>&act=<?=$act?>">查看/回复</a>
    <?php
	if ( $verify ) {
	?>
     | <a href="<?=URL?>index.php/admin/system/verifyPs?id=<?=$v->id?>&act=question">审核通过</a>
    <?php
	}
	?>
    </td>
</tr>
<?php
}
?>
</table>
<?=$page->getHtml("?type=$type&act=$act")?>
</body>
</html>
