function AjaxGet(url, target, functions) {
	var targetsobj = $('#' + target);
	$.ajax({
	    url: url, type: 'GET', dataType: 'html', data:"in_ajax=1", cache:false, timeout: 1000,
	    error: function(data){
	        alert(data.responseText);
	        return false;
	    },
	    beforeSend: function() {
	    	CreateWait();
	    },
	    success: function(data){
			a = null;
			try { eval(data); } catch (e) {	}
			if (typeof(a) != 'object') {
				alert(a.msg);
				return false;
			}
			$('#' + target).html(data);
			if (functions){
				functions();
			}
			ClearWait();
			return false;
	    }
	});
	return false;
}
function AjaxPost(obj_form, btn, functions) {
	var formUrl = obj_form.attr('action');
	var formData = obj_form.serialize()+'&in_ajax=1';
	btn.disabled = true;
	$.ajax({
	    url: formUrl, 
	    type: 'POST', 
	    data: formData,
	    dataType: 'json',
	    error: function(data){
			ClearWait();
			//ClearMaskLayer();			
			btn.disabled = false;
			CreateTip(data.responseText, '');
	        return false;
	    },
	    beforeSend: function() {
	    	//CreateMaskLayer();
			CreateWait();
	    },
	    success: function(data){
	    	ClearWait();    		
	    	if (data.stat) {
	    		if (functions){
					functions();
				}
	    		DzgBox({msg:data.msg, type:3})
	    	} else {
	    		DzgBox({msg:data.msg, type:4})
	    		btn.disabled = false;
	    	}
			return false;
	    }
	});
	return false;
}


function AjaxLevel(url, LevelTitle) {
	CreateLevel(LevelTitle);
	AjaxLevelGet(url);
	return false;
}

function AjaxLevelGet(url){
	targetsobj = $('#cm_new_level');
	url = url+'&in_ajax=1';
	$.ajax({
	    url: url, type: 'GET', dataType: 'html', timeout: 1000,
	    error: function(data){
	        alert(data.responseText);
	        return false;
	    },
	    beforeSend: function() {
	    	CreateMaskLayer();
			CreateWait();
	    },
	    success: function(data){
			a = null;
			try { eval(data); } catch (e) {	}
			if (typeof(a) != 'object') {
				alert(a.msg);
				ClearMaskLayer();
				ClearProcess();
				return false;
			}
			targetsobj.html(data);
			ChangeLevel();
			ClearWait();
			return false;
	    }
	});
    return false;
}

function AjaxLevelPost(obj_form, btn, functions) {
	var formUrl = obj_form.attr('action');
	var formData = obj_form.serialize()+'&in_ajax=1';
	btn.disabled = true;
	$.ajax({
	    url: formUrl, 
	    type: 'POST', 
	    data: formData,
	    dataType: 'json',
	    error: function(data){
			alert(data.responseText);
			btn.disabled = false;
	        return false;
	    },
	    beforeSend: function() {
	    	CreateMaskLayer();
			CreateWait();
	    },
	    success: function(data){
	    	ClearWait();
	    	if (data.stat) {
	    		if (functions){
					functions();
				}
	    		ClearLevel();
	    		DzgBox({msg:data.msg, type:3})
	    	} else {
	    		DzgBox({msg:data.msg, type:4})
	    		btn.disabled = false;
	    	}
			return false;
	    }
	});
    return false;
}

function CreateMaskLayer(){
    // 创建一个与页面宽高相同的遮罩层
    var ml = $('#cm_maskplayer_div');
	if (ml.length == 0) {
		var ml = $('<div id="cm_maskplayer_div" class="cm_maskplayer" style="display:none"></div>');
		$('body').append(ml);
	}
	if (ml.css('display') != '') {
		ml.css({
			'width': $(document).width(),
			'height': $(document).height(),
			'display': ''
		});
	}
}

function ClearMaskLayer(){
	$('#cm_maskplayer_div').remove();
	return false;	
}

function CreateProcess() {
	windowWidth = $(document).width();
	windowHeight = $(document).height;
	var pl = $('#cm_process_div');
	if (pl.length == 0) {
		var pl = $('<div id="cm_process_div" class="cm_process" style="display:none"><img src="/test/media/img/ajax-loader.gif" /><br />正在载入，请稍后</div>');
		$('body').append(pl);
	}
	var thiswidth = pl.width();
	var thisheight = pl.height();
	if (pl.css('display') != '') {
		pl.css({
			'top': $(document).scrollTop() - 100 + window.screen.height / 2 - thisheight / 2,
			'left': windowWidth / 2 - thiswidth / 2,
			'display': ''
		});
	}
}

function ClearProcess() {
	$('#cm_process_div').remove();
	return false;
}

function CreateWait() {
	var pl = $('#cm_wait_div');
	if (pl.length == 0) {
		var pl = $('<div id="cm_wait_div" class="cm_wait" style="display:none">正在载入...</div>');
		$('body').append(pl);
	}
	var thiswidth = pl.width();
	var thisheight = pl.height();
	if (pl.css('display') != '') {
		pl.css({
			'top': $(document).scrollTop(),
			'left': $(document).width() - 90,
			'display': ''
		});
	}
}

function ClearWait() {
	$('#cm_wait_div').remove();
	return false;
}

function DzgBox(attr, event) {
	var box = $('#dzgbox');
	if (box.length == 0) {
		box = $('<div class="dzgbox" id="dzgbox"><div id="dzgbox_title" class="dzgbox_title"></div><div id="dzgbox_content"></div><div id="dzgbox_button" class="dzgbox_button"></div></div>'); 
		$('body').append(box);
		$('#dzgbox_title').bind('mousedown', function(e) {DzgDrag.init({'drag': box}, e)});
	}
	type = attr.type;
	if (type == 1) {
		// 问号
		$('#dzgbox_content').attr('class', 'dzgbox_content_bg1');
		$('#dzgbox_title').html('确定要进行该操作吗？');
	}
	if (type == 2) {
		// 警告
		$('#dzgbox_content').attr('class', 'dzgbox_content_bg2');
		$('#dzgbox_title').html('警告！');
	}
	if (type == 3) {
		// 成功
		$('#dzgbox_content').attr('class', 'dzgbox_content_bg3');
		$('#dzgbox_title').html('操作成功！');
	}
	if (type == 4) {
		// 错误
		$('#dzgbox_content').attr('class', 'dzgbox_content_bg4');
		$('#dzgbox_title').html('操作失败！');
	}
	// 加入要显示的内容
	$('#dzgbox_content').html(attr.msg);
	// 添加按钮
	if (type == 1) {
		// 是或否
		var yes_btn = $('<input type="button" value="是" id="dzgbox_btn_yes" class="dzgbox_btn" />');
		var no_btn = $('<input type="button" value="否" id="dzgbox_btn_no" class="dzgbox_btn" />');
		$('#dzgbox_button').append(yes_btn);
		$('#dzgbox_button').append(no_btn);
		yes_btn.click(function(){if(typeof(attr.yes) == 'function'){(attr.yes)();}$('#dzgbox').remove();});
		no_btn.click(function(){if(typeof(attr.no) == 'function'){(attr.no)()}$('#dzgbox').remove();});
	} else {
		// 确定按钮
		var enter_btn = $('<input type="button" value="确定" id="dzgbox_btn_enter" class="dzgbox_btn" />');
		$('#dzgbox_button').append(enter_btn);
		enter_btn.click(function(){if(typeof(attr.enter) == 'function'){(attr.enter)()}$('#dzgbox').remove();});
	}
	if (typeof(attr.mouse) == 'undefined') {
		// 设置到屏幕中间
		windowWidth = $(document).width();
		windowHeight = $(window).height();
		var width = box.width() / 2;
		if (width == 0) {
			width = 300;
		}
		var height = box.height() / 2;
		var tmpw = windowWidth / 2;
		var tmph = windowHeight / 2;
		box.css('top', $(document).scrollTop() + tmph - height);
		box.css('left', tmpw - width);
	} else {
		// 设置到鼠标当前位置
		evt = event || window.event; 
		ev = getEventXY(evt);
		var mx = ev[0];
		var my = ev[1];
		box.css('top', my);
		box.css('left', mx);
	}
	return false;
}

function getEventXY(ev) {
	if(ev.pageX || ev.pageY){
		return [ev.pageX, ev.pageY];
	}
	return [ev.clientX + document.body.scrollLeft - document.body.clientLeft,
		ev.clientY + document.body.scrollTop  - document.body.clientTop
		]; 
}

function CreateLevel(LevelTitle, event) {
	windowWidth = $(document).width();
	windowHeight = $(document).height();
	var newLevel = $('#cm_new_level_div');
	if (newLevel.length == 0) {
		newLevel = $('<div class="cm_level" id="cm_new_level_div"><div class="cm_level_menu"><span><a href="javascript:void(0)" onclick="ClearLevel()" class="cm_level_close"></a></span>'+LevelTitle+'</div><div class="cm_level_content" id="cm_new_level"></div></div>');
		$('body').append(newLevel);
		newLevel.bind('mousedown', function(e) {DzgDrag.init({'drag': newLevel}, e)});
	}
	newLevel.css({
		'top': windowHeight,
		'left': 220,
		'display': 'none'
	});
	return false;
}

function ClearLevel() {
	ClearMaskLayer();
	$('#cm_new_level_div').remove();
    return false;
}

function ChangeLevel() {
	windowWidth = $(document).width();
	windowHeight = $(window).height();
	var newLevel = $('#cm_new_level_div');
	var width = newLevel.width() / 2;
	if (width == 0) {
		width = 300;
	}
	var height = newLevel.height() / 2;
	var tmpw = windowWidth / 2;
	var tmph = windowHeight / 2;
	newLevel.css({
		'top': $(document).scrollTop() + tmph - height,
		'left': tmpw - width,
		'display': ''
	});
	return false;
}
var DzgDrag = {
		'event': null,
		'drag': null,
		'area': null,
		'areaTop': 0,
		'areaLeft': 0,
		'areaBottom': 0,
		'areaRight': 0,
		'areaWidth': 0,
		'areaHeight': 0,
		'dragWidth': 0,
		'dragHeight': 0,
		'dragX': 0,
		'dragY': 0,
		'start': false,
		'onMove': null,
		'onUp': null,
		'onDown': null,
		'inArea': false,
		'init': function(attr, event) {
			if(event.preventDefault) {
				event.preventDefault();
		    } else {
		    	event.returnValue=false;
		    }
			var ev = getEventXY(event);
			DzgDrag.drag = attr.drag;
			DzgDrag.drag.css('position', 'absolute');
			DzgDrag.dragWidth = DzgDrag.drag.width();
			DzgDrag.dragHeight = DzgDrag.drag.height();
			if (typeof(attr.area) != 'undefined') {
				// 在某一范围内进行拖动
				DzgDrag.area = attr.area;
				DzgDrag.area.css('overflow', 'hidden');
				DzgDrag.area.css('position', 'relative');
				// 计算出范围元素的坐标
				DzgDrag.areaTop = DzgDrag.area.offset().top;
				DzgDrag.areaLeft = DzgDrag.area.offset().left;
				DzgDrag.areaBottom = DzgDrag.areaTop + DzgDrag.area.height();
				DzgDrag.areaRight = DzgDrag.areaLeft + DzgDrag.area.width();
				DzgDrag.areaWidth = DzgDrag.area.width();
				DzgDrag.areaHeight = DzgDrag.area.height();
				if (DzgDrag.area.css('position') == 'relative') {
					DzgDrag.dragX = ev[0] - DzgDrag.area.offset().left - DzgDrag.drag.position().left;
					DzgDrag.dragY = ev[1] - DzgDrag.area.offset().top - DzgDrag.drag.position().top;
				}
			} else {
				// 计算出鼠标离拖动元素边界的位置
				DzgDrag.dragX = ev[0] - DzgDrag.drag.offset().left;
				DzgDrag.dragY = ev[1] - DzgDrag.drag.offset().top;
			}
			if (typeof(attr.inArea)) {
				DzgDrag.inArea = attr.inArea;
			}
			// 设定好各个阶段的事件
			if (attr.onMove) {
				DzgDrag.onMove = attr.onMove;
			}
			if (attr.onUp) {
				DzgDrag.onUp = attr.onUp;
			}
			DzgDrag.start = true;
			// 设定两个事件
			$(document).mousemove(DzgDrag.move);
			$(document).mouseup(DzgDrag.up);
			if (attr.onDown) {
				atrr.onDown();
			}
		},
		'move': function(event) {
			if (!DzgDrag.start) {
				return false;
			}
			if(event.preventDefault) {
				event.preventDefault(); 
		    } else {
		    	event.returnValue=false;
		    }
			var ev = getEventXY(event);
			var x = ev[0];
			var y = ev[1];
			//alert(x + '  ' + y);
			// 根据鼠标坐标计算出拖动元素的实时位置
			var left = x - DzgDrag.dragX;
			var top = y - DzgDrag.dragY;
			if (DzgDrag.area != null) {
				if (DzgDrag.area.css('position') == 'relative') {
					var left = x - DzgDrag.dragX - DzgDrag.area.offset().left;
					var top = y - DzgDrag.dragY - DzgDrag.area.offset().top;
				}
				if (DzgDrag.inArea) {
					// 限定在区域范围内
					if (DzgDrag.area.css('position') == 'relative') {
						// 相对位置
						if (left < 0) {
							left = 0;
						} else {
							if (left > (DzgDrag.areaWidth - DzgDrag.dragWidth)) {
								left = (DzgDrag.areaWidth - DzgDrag.dragWidth);
							}
						}
						if (top < 0) {
							top = 0;
						} else {
							if (top > (DzgDrag.areaHeight - DzgDrag.dragHeight)) {
								top = DzgDrag.areaHeight - DzgDrag.dragHeight;
							}
						}
					} else {
						// 绝对位置
						if (left < DzgDrag.areaLeft) {
							left = DzgDrag.areaLeft;
						} else {
							if (left > DzgDrag.areaRight - DzgDrag.dragWidth) {
								left = (DzgDrag.areaRight - DzgDrag.dragWidth);
							}
						}
						if (top < DzgDrag.areaTop) {
							top = DzgDrag.areaTop;
						} else {
							if (top > DzgDrag.areaBottom - DzgDrag.dragHeight) {
								top = DzgDrag.areaBottom - DzgDrag.dragHeight;
							}
						}
					}
				}
			}
			DzgDrag.drag.css('left', left);
			DzgDrag.drag.css('top', top);
			if (DzgDrag.onMove != null) {
				DzgDrag.onMove();
			}
		},
		'up': function() {
			DzgDrag.start = false;
			$(document).unbind('mousemove', DzgDrag.move);
			if (DzgDrag.onUp != null) {
				DzgDrag.onUp();
			}
		}
}