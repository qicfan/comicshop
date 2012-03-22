<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改个人资料</title>
<link href="<?=MEDIA_URL?>css/mtk_yh.css" rel="stylesheet" type="text/css" />
</head>

<body>
 <!-- 头部-->
<?php require_once(PRO_ROOT . 'template/default/front/include/nav2.php'); ?> 
 <!-- 左侧导航-->
<?php include PRO_ROOT."template/default/front/include/user.php"; ?>

  <!-- 主要内容-->
  <div class="box_left">
    <div class="char_title">
      <span class="hovertab">个人资料</span><span>（带*号的项目为必填项）</span>      
    </div>
    <div id="tbch_01" class="bk">
     <!-- <div class="nei">
        <div class="tou">
		<? if($userInfo->headpic!=''){ ?>
		<img src="<?=URL?>uploadfile/headpics<?=$userInfo->headpic?>" />
		<? }else{ ?>
		<img src="<?=MEDIA_URL?>img/front/touxiang.gif" />
		<? } ?>
		</div>
        <div class="xz_tou">
          <h1>你可以在下方选择自己喜欢的头像</h1>
          
          <div class="char_title_g">
           <span id="tb_1" class="hovertab_g"  onclick="x:HoverLio(1);">帅　哥</span>
           <span id="tb_2" class="normaltab_g" onclick="i:HoverLio(2);">美　　女</span>
           <span id="tb_3" class="normaltab_g" onclick="i:HoverLio(3);">可爱动物</span>
           <span id="tb_4" class="normaltab_g" onclick="i:HoverLio(4);">个　　性</span>
         </div>
          
          <div class="dis" id="tbc_01">
            <ul class="img">
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
            </ul>
          </div>
          <div class="undis" id="tbc_02">
            <ul class="img">
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
            </ul>
          </div>
          <div class="undis" id="tbc_03">
            <ul class="img">
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang2.gif" /></a></li>
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
            </ul>
          </div>
          <div class="undis" id="tbc_04">
            <ul class="img">
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
              <li><a href="#" onclick="return false;"><img src="<?=MEDIA_URL?>img/front/touxiang.gif" /></a></li>
            </ul>
		  </div>
          <div class="clear"></div>
          <div class="bc">
		  <form name="savepic" action="" class="file" method="post">
		  <input id="headpic" name="headpic" type="hidden" value="" />
		  <input name="act" type="hidden" value="savepic" />
		  <a href="#" onclick="document.savepic.submit();"><img src="<?=MEDIA_URL?>img/front/bctx_03.gif" /></a>
		  </form>
		  </div>
          <div class="bc">
            <h1>或从您的电脑中上传图片作为头像：（建议尺寸80*80像素，100k以内）</h1>
            <form class="file" method="post" enctype="multipart/form-data">
              <input  name="uppic" type="file" /> <input class="qr" type="submit" value="上传" />
            </form>
          </div>
        </div>
        
      </div>-->
      
<form action="" name="form1" id="form1" method="post" class="file" onsubmit="return verify();">
      <div class="nei">
        <ul class="tim_r">
          <li><span class="tim b">会员账号：</span><?=$userInfo->uname?></li>
          <li><span class="tim">会员姓名：</span><input type="text" name="fullname" class="kuang kuang5" value="<?=$userInfo->fullname?>" /></li>
          <li><span class="tim">用户类型：</span>
            
            <select name="type">
              <option value="1" <? if($userInfo->type=='1') echo 'selected'; ?>>个人</option>
			  <option value="2" <? if($userInfo->type=='2') echo 'selected'; ?>>团体</option>
              <option value="3" <? if($userInfo->type=='3') echo 'selected'; ?>>企业</option>
          </select></li>
          <li><span class="tim">用户等级：</span>注册会员</li>
          <li><span class="tim">会员性别：</span>
		  <select name="sex">
            <option>男</option>
            <option>女</option>
          </select>
		  </li>
          <li><span class="tim">会员生日：</span>
		  <? $bsd_arr = explode('-',$userInfo->birthday); ?>
		  <select name="y"><? for($y=1930;$y<2016;$y++) { ?> <option value="<?=$y?>" <? if($y==$bsd_arr[0]) echo 'selected'; ?> ><?=$y?></option> <?}?> </select>年
		  <select name="m"><? for($m=1;$m<13;$m++) { ?> <option value="<?=$m?>" <? if($m==$bsd_arr[1]) echo 'selected'; ?>><?=$m?></option> <?}?> </select>月　
		  <select name="d"><? for($d=1;$d<32;$d++) { ?> <option value="<?=$d?>" <? if($d==$bsd_arr[2]) echo 'selected'; ?>><?=$d?></option> <?}?></select>日</li>
          <li><span class="tim">所属地区：</span>
<!--级联选择-->

<select id="s1" name="province" style="width:80px">
  <option value="">请选择...</option>
  <?php
  $rs = base::getRegion(1);
  foreach ($rs as $i=>$v){
  ?>
  <option value="<?=$v->id?>" <? if($v->id==$userInfo->province) echo 'selected'; ?> ><?=$v->region_name?></option>
  <?php
  }
  ?>
</select>
<select id="s2" name="city" style="width:80px">
<?php
$rs = base::getRegionName($userInfo->city);
if($rs!=''){
?>
	<option value="<?=$userInfo->city?>"><?=$rs?></option>
<?php
}else{
?>
<option value="">请选择...</option>
<?php
}
?>
</select>
<select id="s3" name="district" style="width:80px">
<?php
$dt = base::getRegionName($userInfo->district);
if($dt!=''){
?>
	<option value="<?=$userInfo->district?>"><?=$dt?></option>
<?php
}else{
?>
<option value="">请选择...</option>
<?php
}
?>
</select>
<!--级联选择End-->

		  </li>
          <li><span class="tim">身份证号：</span>
            <input type="text" name="idcard" class="kuang" value="<?=$userInfo->idcard?>" />
         </li>
          <li><span class="tim"><span class="fn_red">*</span>电子邮件：</span>
            <input type="text" name="email" class="kuang" value="<?=$userInfo->email?>" <? if($userInfo->email!='') echo 'disabled'; ?>/><span class="fn_hs">请填写常用电子邮件地址</span></li>
          <li><span class="tim"><span class="fn_red">*</span>常用电话：</span><input type="text" id="phone" name="phone" class="kuang" value="<?=$userInfo->phone?>" /><span class="fn_hs">请填写常用电话号码</span></li>
          <li><span class="tim"><span class="fn_red">*</span>手机号码：</span><input type="text" id="mobile" name="mobile" class="kuang" value="<?=$userInfo->mobile?>"/><p class="fn">手机号前不带0，您的订单发出后，商城会发送免费短信告诉您发货日期、货运单号和承运人，便于您及时接收货物。</p></li>
          <li><span class="tim"><span class="fn_red">*</span>收货地址：</span>
            <input type="text" name="address" id="address" class="kuang kuang4" value="<?=$userInfo->address?>" /><span class="fn_hs">请填写收货地址</span>
          </li>
          <li><span class="tim"><span class="fn_red">*</span>邮政编码：</span>
            <input type="text" name="zipcode" class="kuang kuang5" value="<?=$userInfo->zipcode?>" />
            <a href="#none">查询邮政编码</a> <span class="fn_hs">请填写邮政编码</span></li>
          <li><span class="tim">备注：</span><textarea name="remark" class="kuang2"><?=$userInfo->remark?></textarea></li>

		<li><span class="tim"><span class="fn_red">*</span>验证码：</span>
          <input type="text" id="seccode" name="seccode" class="kuang" />
          <span class="fn_hs"><img id="authcode"  onclick="this.src='<?=URL?>index.php/seccode/index?' + Math.round(Math.random()*2)"  src="<?=URL?>index.php/seccode" alt="验证码"  width="90" height="20" /></li>
          <li><span class="tim"></span><input class="qr" id="subnt" type="button" value="确认" /><input class="qr" name="重置" type="reset" value="取消" /></li>
        </ul>
      </div>
</form>
    </div>
  </div>
  <!-- 主要内容结束-->
</div>
<script language="javascript" type="text/javascript" src="<?=MEDIA_URL?>js/hdm.js"></script>
<script src="http://static.comicyu.com/js/jquery.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
	$(':select').change( function(){
		var id = $(this).val();
		var level = $(this).attr('id');
		level = parseInt( level.replace('s', '') );  //得到当前级数
		if (id == '') {  //为空的情况
			if (level == 1) {
				$('#s2').html('');
				$('#s3').html('');
			}
			if (level == 2) {
				$('#s3').html('');
			}
			return false;
		}
		if (level > 2) {
			return false;  //最大级数
		}
		if (level == 1) {
			$('#s3').html('');  //选择第一级的时候清空第三级的结果
		}
		level++;
		post = { id:id };
		$('#s'+level).html('<option>读取中...</option>');
		$.post( '<?=URL?>index.php/views/regionSelect', post,
			function(data) {			
				$('#s'+level).html(data); //将结果显示出来
			}
		);
	});
});
$(".img li").click(function(){
	$(this).addClass("highlight").siblings().removeClass("highlight");
	$("#headpic").attr("value",$(this).children("a").children("img").attr("src"));
});

	$('#subnt').click(function(){
		var mobile = $('#mobile').attr("value");
		var phone  = $('#phone').attr("value");
        var seccode  = $('#seccode').attr("value");
		var address  = $('#address').attr("value");
			if (mobile=='' && phone=='') {
				alert('手机号码和常用电话不能同时为空！');
				 $('#mobile').focus();
			}else if(address==''){
				alert('收货地址不能为空！');
				$('#address').focus();
			}else if(seccode==''){
				alert('请填写验证码！');
				$('#seccode').focus();
			}else {
				$('#form1').submit();
			}			
		});

</script>

</body>
</html>
