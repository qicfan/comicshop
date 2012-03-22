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
<script>
function verify(){
	var reply = document.getElementById('reply').value;
	if (reply == '') {
		alert('请认真填写留言信息');
		return false;
	}
	return true;
}
</script>

<ul id="container">
    <li id="header">
      <h1>留言管理</h1>
      <div class="link"></div>
      <div id="desc">回复</div>
    </li>
</ul>

<div style="padding:10px;">
    <table class="grid" cellspacing="0" cellpadding="4" id="myDataGrid">
        <tr><td><strong>主题：</strong><?=$quiz->title?></td>
        </tr>
        <tr><td><strong>相关商品：</strong><?=base::getGoodsName($quiz->gid)?></td>
        </tr>
        <tr><td><?=$content?></td>
        </tr>
        <tr><td><?=base::getUserName($quiz->uid)?> 于 <?=date('Y-m-d H:i:s',$quiz->questiontime)?> 
        <?php
		  $act = intval( $_GET['act'] );
		  if ( empty($act) ) {
			  echo '提问';
		  } else if ($act == 1) {
			  echo '投诉';
		  }
		?>
        </td>
        </tr>
    </table>
    <?php
        if ($quiz->state == 1){
    ?>
    <div>
        <p><strong><?=base::getAdminName($quiz->aid)?> 于 <?=date('Y-m-d H:i:s',$quiz->replytime)?> 回复：</strong></p>
        <p><?=$reply?></p>
    </div>
    <?php
        }
    ?>
    <form action="" name="form1" method="post" onsubmit="return verify();">
    <table style="border:none;">
        <tr>
            <td>回复</td>
            <td><textarea cols="50" name="reply" id="reply" rows="5"></textarea></td>
        </tr>
    </table>
        <p>
        <?php
        if ($quiz->state == 1){
            echo '提示: 此条留言已有回复, 如果继续回复将更新原来回复的内容!';
        }
        ?>
        </p>
        <input type="submit" value="提交" />
    </form>
</div>
</body>
</html>
