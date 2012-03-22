//弹出层
function popDiv() {
	var nod = $('#popDiv');
	nod.css('display', 'block');
	str = nod.html();
	if (str.indexOf('关闭') == -1) {
		nod.append('<p><a href="###" onclick="return clearDiv();">关闭</a></p>');
	}
}
//关闭弹出曾
function clearDiv() {
	var nod = $('#popDiv');
	nod.css('display', 'none');
}