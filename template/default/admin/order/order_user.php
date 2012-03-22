<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="css/main.css" rel="stylesheet" type="text/css"/>
<link href="<?=MEDIA_URL?>css/general.css" rel="stylesheet" type="text/css" />
<link href="<?=URL?>media/css/main.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="<?=URL?>media/js/jquery.js"></script>
<script style="text/javascript">
/** 搜寻用户信息 */
function searchuser(){
	var userfield = $("#userfield").val();
	var option = document.getElementById('userinfo').options;
	for(var j=option.length-1;j>0;j--){
		option.remove(j);
	}
	$.ajax({
		type: "POST",
		url: "<?=URL?>index.php/admin/order/getUserByField",
		data: "field="+userfield,
		success: function(msg){
			userinfos=eval(msg);
			for(var i=0;i<userinfos.length;i++){
				var opt = new Option(userinfos[i]['uid']+' '+userinfos[i]['uname'],userinfos[i]['uid']);
				document.getElementById('userinfo').options.add(opt); 
			}
		} 	
	});
}

/** 设置用户id */
function setuser(v){
	$("#user_id").val(v);
	document.getElementById("search2").style.display="none";
}

function setuser2(v){
	$("#user_id").val(v);
}

function showsearch2(){
	document.getElementById("search2").style.display="block";
}

function subcheck(){
	if(document.getElementById("rad1").checked){
		var str=$("#user_id").val();
		if(str==0){
			alert("请选择用户");
			return false;
		}else{
			return true;
		}
	}else{
		return true;
	}
}
</script>
</head>


<body>
<div>
	<div class="main-header">管理中心&nbsp;-&nbsp;<span>添加订单</span></div>
	<div style="border:1px solid #CCFFFF;margin-top:10px;padding:5px;background-color:#ECF9F9;">
		<input type="radio" value="1" name="usertype" onclick="setuser(0)" checked="true"/>匿名用户<br> 
		<input type="radio" value="2" name="usertype" id="rad1" onclick="showsearch2()"/>按用户编号或用户名搜索&nbsp;<span style="display:none;" id="search2"><input type="text" name="utype" id="userfield">&nbsp;<input type="button" value="搜索" style="cursor:pointer;" onclick="searchuser()">&nbsp;<select id="userinfo" name="user" onchange="setuser2(this.value)"><option>请选择--</option></select></span>
	</div>
	<div style="text-align:center;margin-top:5px;">
	<form action="<?=URL?>index.php/admin/order/user" method="GET">
		<input type='hidden' name="userid" id="user_id" value='0'/>
		<input type="submit" onclick="return subcheck()" value="下一步"/>&nbsp;<input type="button" value="取消"/>
	</form>
	</div>
    <div class="main-footer">版权归comicyu所有</div>
</div>
</body>
</html>