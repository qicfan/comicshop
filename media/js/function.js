//复选框选择
function chkChecked(flag,chkName){	
	var chkObj=  document.getElementsByName(chkName);
	for(i=0;i<chkObj.length;i++){
		chkObj[i].checked = flag;
	}
}
//全选
function checkAll(chk,controlchk){
	chkChecked("true",chk);
	document.getElementById(controlchk).checked=true;
}
//全不选
function unCheckAll(chk,controlchk){
	chkChecked("false",chk);
	document.getElementById(controlchk).checked=false;
}
//dialog="没有选择操作对象",chkname,多选框的name
function checkmulti(dialog,chkname){
	var chkObj = document.getElementsByName(chkname);
	var idArr = new Array();
	var j = 0;
	for(i=0;i<chkObj.length;i++){
		if(chkObj[i].checked==true){
			idArr.push(chkObj[i].value);
			j++;
		}
	}

	if(!j){
		alert(dialog);
		return false;
	}
	return idArr;
}