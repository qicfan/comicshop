<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<script src="<?=MEDIA_ROOT?>js/jquery.js"></script>
<script src="<?=MEDIA_URL?>plugin/ckeditor3/ckeditor.js"></script>

<script type="text/javascript">
 $(function(){

        $("#fname").blur(function(){//用户名文本框失去焦点触发验证事件
		var reg=/^[a-zA-Z][a-zA-Z0-9_]{1,19}$/;
        if(!reg.test($(this).val()))
        {
            $("#nametip").html("用户名不能为空且只能为2-20个字符");
					return false;

        }
        else
        {
            $("#nametip").html("输入正确");
        }

     });
	 
	   		 $("#tid").blur(function(){//用户名文本框失去焦点触发验证事件
       			if(!$(this).val())//只处验证不能为空并且只能为英文或者数字或者下划线组成的２－１５个字符
      			{
            		$("#tidtip").html("不能为空");
							return false;

        		}
       			else
       			{
           			$("#tidtip").html("输入正确");
       			}

    		});
	 	    $("#title").blur(function(){//用户名文本框失去焦点触发验证事件
       			if(!$(this).val())//只处验证不能为空并且只能为英文或者数字或者下划线组成的２－１５个字符
      			{
            		$("#titletip").html("不能为空");
							return false;

        		}
       			else
       			{
           			$("#titletip").html("输入正确");
       			}

     		});
			$("#content").blur(function(){//用户名文本框失去焦点触发验证事件
       			if(!$(this).val())//只处验证不能为空并且只能为英文或者数字或者下划线组成的２－１５个字符
      			{
            		$("#contenttip").html("不能为空");
							return false;


        		}
       			else
       			{
           			$("#contenttip").html("输入正确");
       			}

     		});
})
function ck(){
	if(!$("#content").val()){
		return false;
	}
	if(!$("#title").val()){
		return false;
	}
		if(!$("#tid").val()){
		return false;
	}

	if(!$("#fname").val()){
		return false;
	}

	
}
 </script>

</head>

<body>
<form action="" method="post" id="smform" onsubmit="return ck();">
<label>发信人</label><input type="text" name="fname" id="fname" /><span id="nametip"></span><br />
<label>收信ID</label><input type="text" name="tid" id="tid" /><span id="tidtip"></span><br />
<label>题目</label><input type="text"  name="title" id="title"/><span id="titletip"></span><br />
<label>内容</label><textarea name="content" id="content"></textarea>	<span id="contenttip"></span><br />
<input type="submit" value="ok" onclick="ck();"/><input type="reset" />


</form>
</body>
</html>
