$.extend(validateFunction,{
	FORM_validate:function(){
		$("#username").jdValidate(validatePrompt.username,validateFunction.username,true);
		$("#pwd").jdValidate(validatePrompt.pwd,validateFunction.pwd,true);
		$("#pwd2").jdValidate(validatePrompt.pwd2,validateFunction.pwd2,true);
		$("#mail").jdValidate(validatePrompt.mail,validateFunction.mail,true);
		$("#authcode").jdValidate(validatePrompt.authcode,validateFunction.authcode,true);
		return validateFunction.FORM_submit(["#username","#pwd","#pwd2","#mail","#authcode"])
	}		 
});

//调用
setTimeout(function(){$("#username").get(0).focus();},0); 
$("#username").jdValidate(validatePrompt.username,validateFunction.username);
$("#pwd").bind("keyup",function(){
	validateFunction.pwdstrength();
}).jdValidate(validatePrompt.pwd,validateFunction.pwd)
$("#pwd2").jdValidate(validatePrompt.pwd2,validateFunction.pwd2);
$("#mail").jdValidate(validatePrompt.mail,validateFunction.mail);
$("#referrer").bind("keydown",function(){
	$(this).css({"color":"#333333","font-size":"14px"});
}).bind("keyup",function(){
	if ($(this).val()==""||$(this).val()=="可不填"){
		$(this).css({"color":"#999999","font-size":"12px"});
	}
}).bind("blur",function(){
	if ($(this).val()==""||$(this).val()=="可不填"){
		$(this).css({"color":"#999999","font-size":"12px"});
	}
}).jdValidate(validatePrompt.referrer,validateFunction.referrer,"可不填");
$("#authcode").jdValidate(validatePrompt.authcode,validateFunction.authcode);
$("#viewpwd").bind("click",function(){
	if ($(this).attr("checked")==true){
		validateFunction.showPassword("text");
		$("#o-password").addClass("pwdbg");
	}else{
		validateFunction.showPassword("password");
		$("#o-password").removeClass("pwdbg");
	}
});

$("#registsubmit").click(function() {
    var flag = validateFunction.FORM_validate();
    if (flag) {
        $(this).attr({"disabled":"disabled"}).attr({"value":"提交中,请稍等"}); 
        var uuid=$("#JD_Verification1").attr("src").split("&uid=")[1].split("&")[0];
        $.ajax({
            type: "POST",
            url: "RegistService.aspx?rtype=personal&uuid=" + uuid,
            contentType: "application/x-www-form-urlencoded; charset=utf-8",
            data: $("#formpersonal").serialize(),
            success: function(result) {
                if (result) {
                    var obj = eval(result);
                    if (obj.info) {
                        $("#registsubmit").removeAttr("disabled");
                        $("#registsubmit").attr({"value":"同意以下协议，提交"});
                        alert(obj.info);
                    }
                    if (obj.success == true) {
                        window.location = "registmobile.aspx" + location.search;
                    }
                }
            }
        });
    }
});

function verc(){
	$("#JD_Verification1").click();
}

$("#authcode").bind('keyup',function(event) {  
    if(event.keyCode==13){  
        $("#registsubmit").click();
    }     
});   
