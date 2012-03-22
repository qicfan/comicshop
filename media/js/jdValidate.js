var validateRegExp={
	decmal:"^([+-]?)\\d*\\.\\d+$",	//������
	decmal1: "^[1-9]\\d*.\\d*|0.\\d*[1-9]\\d*$",	//��������
	decmal2: "^-([1-9]\\d*.\\d*|0.\\d*[1-9]\\d*)$",	//��������
	decmal3: "^-?([1-9]\\d*.\\d*|0.\\d*[1-9]\\d*|0?.0+|0)$",	//������
	decmal4: "^[1-9]\\d*.\\d*|0.\\d*[1-9]\\d*|0?.0+|0$",	//�Ǹ����������������� + 0��
	decmal5: "^(-([1-9]\\d*.\\d*|0.\\d*[1-9]\\d*))|0?.0+|0$",	//�������������������� + 0��
	intege: "^-?[1-9]\\d*$",	//����
	intege1: "^[1-9]\\d*$",	//������
	intege2: "^-[1-9]\\d*$",	//������
	num: "^([+-]?)\\d*\\.?\\d+$",	//����
	num1: "^[1-9]\\d*|0$",	//������������ + 0��
	num2: "^-[1-9]\\d*|0$",	//������������ + 0��		
	ascii: "^[\\x00-\\xFF]+$",	//��ACSII�ַ�
	chinese: "^[\\u4e00-\\u9fa5]+$",	//������
	color: "^[a-fA-F0-9]{6}$",	//��ɫ
	date: "^\\d{4}(\\-|\\/|\.)\\d{1,2}\\1\\d{1,2}$",	//����
	email: "^\\w+((-\\w+)|(\\.\\w+))*\\@[A-Za-z0-9]+((\\.|-)[A-Za-z0-9]+)*\\.[A-Za-z0-9]+$",	//�ʼ�
	idcard: "^[1-9]([0-9]{14}|[0-9]{17})$",	//���֤
	ip4: "^(25[0-5]|2[0-4]\\d|[0-1]\\d{2}|[1-9]?\\d)\\.(25[0-5]|2[0-4]\\d|[0-1]\\d{2}|[1-9]?\\d)\\.(25[0-5]|2[0-4]\\d|[0-1]\\d{2}|[1-9]?\\d)\\.(25[0-5]|2[0-4]\\d|[0-1]\\d{2}|[1-9]?\\d)$",	//ip��ַ
	letter: "^[A-Za-z]+$",	//��ĸ
	letter_l: "^[a-z]+$",	//Сд��ĸ
	letter_u: "^[A-Z]+$",	//��д��ĸ
	mobile: "^[0](13|15)[0-9]{9}$",	//�ֻ�
	notempty: "^\\S+$",	//�ǿ�
	password: "^[A-Za-z0-9_-]+$",	//����
	picture: "(.*)\\.(jpg|bmp|gif|ico|pcx|jpeg|tif|png|raw|tga)$",	//ͼƬ
	qq: "^[1-9]*[1-9][0-9]*$",	//QQ����
	rar: "(.*)\\.(rar|zip|7zip|tgz)$",	//ѹ���ļ�
	tel: "^[0-9\-()����]{7,18}$",	//�绰����ĺ���(������֤��������,��������,�ֻ���)
	url: "^http[s]?:\\/\\/([\\w-]+\\.)+[\\w-]+([\\w-./?%&=]*)?$",	//url
	username: "^[A-Za-z0-9_\\-\\u4e00-\\u9fa5]+$",	//�û���
	deptname: "^[A-Za-z0-9_()����\\-\\u4e00-\\u9fa5]+$",	//��λ��
	zipcode: "^\\d{6}$",	//�ʱ�
	realname:"^[A-Za-z0-9\\u4e00-\\u9fa5]+$",  // ��ʵ����
	companyname:"^[A-Za-z0-9_()����\\-\\u4e00-\\u9fa5]+$",
	companyaddr:"^[A-Za-z0-9_()����\\#\\-\\u4e00-\\u9fa5]+$",
	companysite:"^http[s]?:\\/\\/([\\w-]+\\.)+[\\w-]+([\\w-./?%&#=]*)?$"
};

//������
(function($) {
    $.fn.jdValidate = function(option, callback, def) {
        var ele = this;
        var id = ele.attr("id");
        var type = ele.attr("type");
        var rel = ele.attr("rel");
        var _onFocus = $("#" + id + validateSettings.onFocus.container);
        var _succeed = $("#" + id + validateSettings.succeed.container);
        var _isNull = $("#" + id + validateSettings.isNull.container);
        var _error = $("#" + id + validateSettings.error.container);
        if (def == true) {
            var str = ele.val();
            var tag = ele.attr("sta");
            if (str == "" || str == "-1") {
                validateSettings.isNull.run({
                    prompts: option,
                    element: ele,
                    isNullEle: _isNull,
                    succeedEle: _succeed
                }, option.isNull);
            } else if (tag == 1 || tag == 2) {
                return;
            } else {
                callback({
                    prompts: option,
                    element: ele,
                    value: str,
                    errorEle: _error,
                    succeedEle: _succeed
                });
            }
        } else {
            if (typeof def == "string") {
                ele.val(def);
            }
            if (type == "checkbox" || type == "radio") {
                if (ele.attr("checked") == true) {
                    ele.attr("sta", validateSettings.succeed.state);
                }
            }
            switch (type) {
                case "text":
                case "password":
                    ele.bind("focus", function() {
                        var str = ele.val();
                        if (str == def) {
                            ele.val("");
                        }
                        validateSettings.onFocus.run({
                            prompts: option,
                            element: ele,
                            value: str,
                            onFocusEle: _onFocus,
                            succeedEle: _succeed
                        }, option.onFocus);
                    })
					.bind("blur", function() {
					    var str = ele.val();
					    if (str == "") {
					        ele.val(def);
					    }
					    if (validateRules.isNull(str)) {
					        validateSettings.isNull.run({
					            prompts: option,
					            element: ele,
					            value: str,
					            isNullEle: _isNull,
					            succeedEle: _succeed
					        }, "");
					    } else {
					        callback({
					            prompts: option,
					            element: ele,
					            value: str,
					            errorEle: _error,
					            isNullEle: _isNull,
					            succeedEle: _succeed
					        });
					    }
					});
                    break;
                default:
                    if (rel && rel == "select") {
                        ele.bind("change", function() {
                            var str = ele.val();
                            callback({
                                prompts: option,
                                element: ele,
                                value: str,
                                errorEle: _error,
                                isNullEle: _isNull,
                                succeedEle: _succeed
                            });
                        })
                    } else {
                        ele.bind("click", function() {
                            callback({
                                prompts: option,
                                element: ele,
                                errorEle: _error,
                                isNullEle: _isNull,
                                succeedEle: _succeed
                            });
                        })
                    }
                    break;
            }
        }
    }
})(jQuery);

//����
var validateSettings={
	onFocus:{
		state:null,
		container:"_error",
		style:"focus",
		run:function(option,str){
			if (!validateRules.checkType(option.element)){
				option.element.removeClass(validateSettings.INPUT_style2).addClass(validateSettings.INPUT_style1);
			}
			option.onFocusEle.removeClass().addClass(validateSettings.onFocus.style).html(str); 
		}
	},
	isNull:{
		state:0,
		container:"_error",
		style:"null",
		run:function(option,str){
			option.element.attr("sta",0);
			if (!validateRules.checkType(option.element)){
				if (str!=""){
					option.element.removeClass(validateSettings.INPUT_style1).addClass(validateSettings.INPUT_style2);
				}else{
					option.element.removeClass(validateSettings.INPUT_style2).removeClass(validateSettings.INPUT_style1);
				}
			}
			option.succeedEle.removeClass(validateSettings.succeed.style);
			option.isNullEle.removeClass().addClass(validateSettings.isNull.style).html(str);
		}
	},
	error:{
		state:1,
		container:"_error",
		style:"error",
		run:function(option,str){
			option.element.attr("sta",1);
			if (!validateRules.checkType(option.element)){
				option.element.removeClass(validateSettings.INPUT_style1).addClass(validateSettings.INPUT_style2);
			}
			option.succeedEle.removeClass(validateSettings.succeed.style);
			option.errorEle.removeClass().addClass(validateSettings.error.style).html(str);
		}
	},
	succeed:{
		state:2,
		container:"_succeed",
		style:"succeed",
		run:function(option){
			option.element.attr("sta",2);
			option.errorEle.empty();
			if (!validateRules.checkType(option.element)){
				option.element.removeClass(validateSettings.INPUT_style1).removeClass(validateSettings.INPUT_style2);
			}
			option.succeedEle.addClass(validateSettings.succeed.style);
		}
	},
	INPUT_style1:"highlight1",
	INPUT_style2:"highlight2"
	
};

//��֤����
var validateRules={
	isNull:function(str){
		return (str==""||typeof str!="string");
	},
	betweenLength:function(str,_min,_max){
		return (str.length>=_min&&str.length<=_max);
	},
	isUid:function(str){
		return new RegExp(validateRegExp.username).test(str);
	},
	isPwd:function(str){
		return new RegExp(validateRegExp.password).test(str);
	},
	isPwd2:function(str1,str2){
		return (str1==str2);
	},
	isEmail:function(str){
		return new RegExp(validateRegExp.email).test(str);
	},
	isTel:function(str){
		return new RegExp(validateRegExp.tel).test(str);
	},
	isMobile:function(str){
		return new RegExp(validateRegExp.mobile).test(str);
	},
	checkType:function(element){
		return (element.attr("type")=="checkbox"||element.attr("type")=="radio"||element.attr("rel")=="select");
	},
	isChinese:function(str){
		return new RegExp(validateRegExp.chinese).test(str);
	},
	isRealName:function(str){
		return new RegExp(validateRegExp.realname).test(str);
	},
	isDeptname:function(str){
	    return new RegExp(validateRegExp.deptname).test(str);
	},
	isCompanyname:function(str){
	    return new RegExp(validateRegExp.companyname).test(str);
	},
	isCompanyaddr:function(str){
	    return new RegExp(validateRegExp.companyaddr).test(str);
	},
	isCompanysite:function(str){
	    return new RegExp(validateRegExp.companysite).test(str);
	}
};
//��֤�ı�
var validatePrompt={
	username:{
		onFocus:"4-20λ�ַ����������ġ�Ӣ�ġ����ּ���_������-�����",
		succeed:"",
		isNull:"�������û���",
		error:{
			beUsed:"���û����ѱ�ʹ�ã���ʹ�������û���ע�ᣬ�������&quot;{1}&quot;����<a href='https://passport.360buy.com/new/login.aspx' class='flk13'>��¼</a>",
			badLength:"�û�������ֻ����4-20λ�ַ�֮��",
			badFormat:"�û���ֻ�������ġ�Ӣ�ġ����ּ���_������-�����"
		}
	},
	pwd:{
		onFocus:"6-16λ�ַ�������Ӣ�ġ����ּ���_������-�����",
		succeed:"",
		isNull:"����������",
		error:{
			badLength:"���볤��ֻ����6-16λ�ַ�֮��",
			badFormat:"����ֻ����Ӣ�ġ����ּ���_������-�����"
		}
	},
	pwd2:{
		onFocus:"���ٴ���������",
		succeed:"",
		isNull:"����������",
		error:{
			badLength:"���볤��ֻ����6-16λ�ַ�֮��",
			badFormat2:"�����������벻һ��",
			badFormat1:"����ֻ����Ӣ�ġ����ּ���_������-�����"
		}
	},
	mail:{
		onFocus:"�����볣�õ����䣬�������һ����롢���ն���֪ͨ��",
		succeed:"",
		isNull:"����������",
		error:{
			beUsed:"�������ѱ�ʹ�ã�������������䣬��ʹ�ø�����<a href='http://passport.360buy.com/retrievepassword.aspx' class='flk13'>�һ�����</a>",
			badFormat:"�����ʽ����ȷ",
			badLength:"����д������������ʼ���ַֻ����50���ַ�����"
		}
	},
	authcode:{
		onFocus:"������ͼƬ�е��ַ��������ִ�Сд",
		succeed:"",
		isNull:"��������֤��",
		error:"��֤�����"
	},
	protocol:{
		onFocus:"",
		succeed:"",
		isNull:"�����Ķ���ͬ�⡶�����̳��û�Э�顷",
		error:""
	},
	referrer:{
		onFocus:"����ע�Ტ��ɶ������Ƽ����л����û���",
		succeed:"",
		isNull:"",
		error:""
	},
	empty:{
		onFocus:"",
		succeed:"",
		isNull:"",
		error:""
	}
};

var nameold,emailold,authcodeold;
var namestate=false,emailstate=false,authcodestate=false;
//�ص�����
var validateFunction={
	username:function(option){
		var format=validateRules.isUid(option.value);
        var length=validateRules.betweenLength(option.value.replace(/[^\x00-\xff]/g,"**"),4,20);
		if(!length&&format){
			validateSettings.error.run(option,option.prompts.error.badLength);
		}
		else if(!length&&!format){
			validateSettings.error.run(option,option.prompts.error.badFormat);
		}
		else if(length&&!format){
			validateSettings.error.run(option,option.prompts.error.badFormat);
		}
		else{ 
	        if(!namestate||nameold!=option.value)
	        {
	            if(nameold!=option.value)
	            {
	                nameold=option.value;
	                option.errorEle.html("<span style='color:#999'>�����С���</span>");
		            $.getJSON("AjaxService.aspx?action=CheckUnicknme&uid="+escape(option.value)+"&r="+Math.random(),function(date){
			        if(date.success==0){
				        validateSettings.succeed.run(option);
				        namestate=true;
			        }else{
				        validateSettings.error.run(option,option.prompts.error.beUsed.replace("{1}",option.value));
				        namestate=false;
			        }
		            })
		        }
		        else
		        {
		            validateSettings.error.run(option,option.prompts.error.beUsed.replace("{1}",option.value));
				    namestate=false;
		        }
		    }
		    else
		    {
		         validateSettings.succeed.run(option);
		    }
		}
	},
	pwd:function(option){
		var str1=option.value;
		var str2=$("#pwd2").val();
		var format=validateRules.isPwd(option.value);
		var length=validateRules.betweenLength(option.value,6,16);
		$("#pwdstrength").hide();
		if(!length&&format){
			validateSettings.error.run(option,option.prompts.error.badLength);
		}
		else if(!length&&!format){
			validateSettings.error.run(option,option.prompts.error.badFormat);
		}
		else if(length&&!format){
			validateSettings.error.run(option,option.prompts.error.badFormat);
		}
		else{
			validateSettings.succeed.run(option);	
			validateFunction.pwdstrength();
		}
		if (str2!=""){
			$("#pwd2").jdValidate(validatePrompt.pwd2,validateFunction.pwd2,true);
		}
	},
	pwd2:function(option){
		var str1=option.value;
		var str2=$("#pwd").val();
		var length=validateRules.betweenLength(option.value,6,16);
		var format2=validateRules.isPwd2(str1,str2);
		var format1=validateRules.isPwd(str1);
		if (!length){
			validateSettings.error.run(option,option.prompts.error.badLength);
		}else{
			if (!format1){
				validateSettings.error.run(option,option.prompts.error.badFormat1);
			}else{
				if(!format2){
					validateSettings.error.run(option,option.prompts.error.badFormat2);
				}
				else{
					validateSettings.succeed.run(option);
				}
			}
		}
	},
	mail:function(option){
		var format=validateRules.isEmail(option.value);
		var format2=validateRules.betweenLength(option.value,0,50);
		if(!format){
			validateSettings.error.run(option,option.prompts.error.badFormat);
		}else{
			if (!format2){
				validateSettings.error.run(option,option.prompts.error.badLength);
			}else{
		        if(!emailstate||emailold!=option.value)
		        {
		            if(emailold!=option.value)
		            {
		                emailold=option.value;
		                option.errorEle.html("<span style='color:#999'>�����С���</span>");
		                $.getJSON("AjaxService.aspx?action=CheckUemail&str="+escape(option.value)+"&r="+Math.random(),function(date){
			                if(date.success==0){
				                validateSettings.succeed.run(option);
				                emailstate=true;
			                }else{
				                validateSettings.error.run(option,option.prompts.error.beUsed);
				                emailstate=false;
			                }
		                })
		            }
		            else
		            {
		                validateSettings.error.run(option,option.prompts.error.beUsed);
				        emailstate=false;
		            }
		        }
		        else
		        {
		           validateSettings.succeed.run(option);
		        }
 			}
		}
	},
	referrer:function(option){
		var bool=validateRules.isNull(option.value);
		if (bool){
			option.element.val("�ɲ���");
			return;
		}else{
			validateSettings.succeed.run(option);
		}
	},
	authcode:function(option){
	    if(!authcodestate||authcodeold!=option.value)
	    {
	        if(authcodeold!=option.value)
	        {
	            authcodeold=option.value;
	            option.errorEle.html("<span style='color:#999'>�����С���</span>");
	            var uuid=$("#JD_Verification1").attr("src").split("&uid=")[1].split("&")[0];
		        $.getJSON("AjaxService.aspx?action=CheckAuthcode&str="+escape(option.value)+"&r="+Math.random()+"&uuid="+uuid,function(date){
			        if (date.success==0){
				        validateSettings.succeed.run(option);
				        authcodestate=true;
			        }else{
				        validateSettings.error.run(option,option.prompts.error);
				        authcodestate=false;
			        }
		        })
		    }
		    else
		    {
		         validateSettings.error.run(option,option.prompts.error);
				 authcodestate=false;
		    }
		}
		else
		{
		     validateSettings.succeed.run(option);
		}
	},
	protocol:function(option){
		if (option.element.attr("checked")==true){
			option.element.attr("sta",validateSettings.succeed.state);
			option.errorEle.html("");
		}else{
			option.element.attr("sta",validateSettings.isNull.state);
			option.succeedEle.removeClass(validateSettings.succeed.style);
		}
	},
	pwdstrength:function(){		
		var element=$("#pwdstrength");
		var value=$("#pwd").val();
		var strength = 0;
		if (value.length>=6&&validateRules.isPwd(value)){
			$("#pwd_error").empty();
			element.show();
			if (/\d/i.test(value)){
				strength += 1;
			}
			if (/[a-z]/i.test(value)){
				strength += 1;
			}
			if (/[-_]/i.test(value)){
				strength += 1;
			}
			switch (strength){
				case 1:
					element.removeClass().addClass("strengthA");
					break;
				case 2:
					element.removeClass().addClass("strengthB");
					break;
				case 3:
					element.removeClass().addClass("strengthC");
					break;
				default:
					break;
			}
		}else{
			element.hide();
		}
	},
	checkGroup:function(elements){
		for (var i=0;i<elements.length;i++){
			if (elements[i].checked){
				return true;
			}
		}
		return false;
	},
	checkSelectGroup:function(elements){
		for (var i=0;i<elements.length;i++){
			if (elements[i].value==-1){
				return false;
			}			
		}
		return true;
	},
	showPassword:function(type){
		var v1=$("#pwd").val(),s1=$("#pwd").attr("sta"),c1=document.getElementById("pwd").className,t1=$("#pwd").attr("tabindex");
		var v2=$("#pwd2").val(),s2=$("#pwd2").attr("sta"),c2=document.getElementById("pwd2").className,t2=$("#pwd2").attr("tabindex");
		var P1=$("<input type='"+ type +"' value='" + v1 + "' sta='"+ s1 +"' class='"+ c1 +"' id='pwd' name='pwd' tabindex='"+ t1 +"'/>");
		$("#pwd").after(P1).remove();
		$("#pwd").bind("keyup",function(){
			validateFunction.pwdstrength();
		}).jdValidate(validatePrompt.pwd,validateFunction.pwd)
		var P2=$("<input type='"+ type +"' value='" + v2 + "' sta='"+ s2 +"' class='"+ c2 +"' id='pwd2' name='pwd2' tabindex='"+ t2 +"'/>");
		$("#pwd2").after(P2).remove();
		$("#pwd2").jdValidate(validatePrompt.pwd2,validateFunction.pwd2);
	},
	FORM_submit:function(elements){
		var bool=true;
		for (var i=0;i<elements.length;i++){
			if ($(elements[i]).attr("sta")==2){
				bool=true;
			}else{
				bool=false;
				break;
			}
		}
		return bool;
	}
};
