<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>修改商品</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?=MEDIA_URL?>css/general.css" rel="stylesheet"
	type="text/css" />
<script type="text/javascript"
	src="http://static.comicyu.com/js/jquery.js"></script>
<script type="text/javascript">     
	function changemod(){
		var tp=$("#mod :selected").val();
		if(tp==0){
			var o = '';
			var oEditor = FCKeditorAPI.GetInstance('description');
			oEditor.SetHTML(o,true);
		}
		if(tp==1){	
			var a='	<div style="width:795px;"><div class="content_template01"><p class="content_template_div1"></p></div><div class="content_template02"><p class="content_template_div1"></p></div><div class="content_template03"><p class="content_template_div1"></p></div></div>';
			//editor.setData(a);
			var oEditor = FCKeditorAPI.GetInstance('description');
			oEditor.SetHTML(a,true);


		}
		if(tp==2){
			var b=' <div style="width:795px;"><div class="content_template11"><p class="content_template_div2"></p></div><div class="content_template12"><p class="content_template_div2"></p></div><div class="content_template13"><p class="content_template_div2"></p></div></div>';
			var oEditor = FCKeditorAPI.GetInstance('description');
			oEditor.SetHTML(b,true);
		}
		if(tp==3){
			var c='	<div style="width:795px;"><div class="content_template21"><p class="content_template_div3"></p></div><div class="content_template22"><p class="content_template_div3"></p></div><div class="content_template23"><p class="content_template_div3"></p></div></div>';
			var oEditor = FCKeditorAPI.GetInstance('description');
			oEditor.SetHTML(c,true);
		}		
	}
  	var cid = 0;
	var extend = 1;
	var selectcount = <?=count($directcates)?>;
	var imgcount = 1;
	
	var cates = [
	<?php for($i=0;$i<count($cates);$i++){?>
		{cid:<?=$cates[$i]->id?>,pid:<?=$cates[$i]->parentid?>,cname:'<?=$cates[$i]->categoryname?>'},
	<?php }?>
	];

	$(document).ready(function(){
		
		var tabs = $("#tab-form .tab-bar");
		
		tabs.click(function(e){
			var tab = $(this);
			var elem = e.target;
			if (elem.tagName == 'LI'){
				var lis = tab.find('li');
				var pages = $('#tab-form .tab-page');
				var index = 0;
				lis.each(function(i){
					if (this == elem){
						index = i;
					}
				});
				lis.removeClass("actived");
				$(elem).addClass("actived");
				pages.addClass("tab-form");
				$(pages.get(index)).removeClass("tab-form");
			}
		})
	});
	setTimeout(loadother(),2000);
	function loadother(){
		initdirectorycate();
		initattribute();
		initrelategoods();
		initrelatearticle(); 
		initprofun();
	}
	
	//初始化促销方案
	function initprofun(){
		var funarr = <?=$profunarr?>;
		$("#rightprofun").empty();
		$("#divhiddprofun").children().remove();
		for(i=0;i<funarr.length;i++){
			var optionobj = $("<option value='"+funarr[i]['act_id']+"'>"+funarr[i]['act_title']+"</option>");
			$("#rightprofun").append(optionobj);
			var hidobj = $("<input type='hidden' name='profuns[]' value='"+funarr[i]['act_id']+"'/>");
			$("#divhiddprofun").append(hidobj);
		}
	}
	//初始关联文章
	function initrelategoods(){
		var relategoodsinfos = <?=$relategoodsinfo?>;
		var divobj = $("#divhiddrelatesgoods");
		var selectobj = $("#relateright");
		for(i=0;i<relategoodsinfos.length;i++){
			var optionobj = $("<option value='"+relategoodsinfos[i].goodsid+"'>"+relategoodsinfos[i].goodsname+"</option>");
			selectobj.append(optionobj);
			var inputobj = $("<input type='hidden' name='relatesgoods[]' id='regoods"+relategoodsinfos[i].goodsid+"' value='"+relategoodsinfos[i].goodsid+"' />");
			divobj.append(inputobj);
		}
	}
	//初始化关联文章
	function initrelatearticle(){
		var relatearticleinfos= <?=$relatearticleinfo?>;
		var divobj = $("#divhiddrelatearticle");
		var selectobj = $("#articleright");
		
		for(i=0;i<relatearticleinfos.length;i++){
			var optionobj = $("<option value='"+relatearticleinfos[i].articleid+"'>"+relatearticleinfos[i].title+"</option>");
			selectobj.append(optionobj);
			var inputobj = $("<input type='hidden' name='relatearticle[]' id='' value='"+relatearticleinfos[i].title+"' />");
			divobj.append(inputobj);
		}
	}
	//初始化属性信息
	function initattribute(){
		var tab = $("#tabattri");
		if(<?=count($displayattrkeys)?>>0){
			tab.children().remove();
		}
		$("#cid").val(<?=$displayattrkeys[0]['cid']?>);;
		<?php
		for($i=0;$i<count($displayattrkeys);$i++){
		?>
			var trobj = $("<tr></tr>");
			var tdobj =  $("<td class='label'>"+'<?=$displayattrkeys[$i]['attributename']?>'+"</td>");
			var tdobj1 = "";
			if(<?=$displayattrkeys[$i]['attributetype']?>==0){
				if(<?=$displayattrkeys[$i]['isrelate']?>==1){
					<?php
					for($j=0;$j<count($displayattrvalues);$j++){
					?>
						if(<?=$displayattrkeys[$i]['id']?>==<?=$displayattrvalues[$j]['aid']?>){
							tdobj1 = $("<td><input type='text' id='attri"+<?=$i?>+"' name='attri["+<?=$i?>+"][0]' value='<?=$displayattrvalues[$j]['attributevalue']?>'> 与此属性关联的商品<input type='text' name='' value='<?=$displayattrvalues[$j]['goods_sn']?>' id='attrisearch"+<?=$i?>+"'/> <input type='button' onclick='searchgoods("+<?=$i?>+","+<?=$i?>+",0,0);' value=' 搜索 '/><input type='text' id='attridisplay"+<?=$i?>+"' name='' value='<?=$displayattrvalues[$j]['goodsname']?>' disabled='disabled'/></td>");
							//把商品id赋值给hidden
							if(typeof($("#relateattrgoods<?=$i?>").val())!="undefined"){
								$("#relateattrgoods<?=$i?>").remove();
							}
							var relategoodshid = $("<input type='hidden' name='relategoods[<?=$i?>][0]' value='<?=$displayattrvalues[$j]['relategoods']?>' id='relateattrgoods<?=$i?>' />");
							$("#relatehid").append(relategoodshid);
							
						}
					<?php
					}
					if(!in_array($displayattrkeys[$i]['id'],$displayattrvalueaids)){
					?>
						tdobj1 = $("<td><input type='text' id='attri"+<?=$i?>+"' name='attri["+<?=$i?>+"][0]' value=''> 与此属性关联的商品<input type='text' name='' value='' id='attrisearch"+<?=$i?>+"'/> <input type='button' onclick='searchgoods("+<?=$i?>+","+<?=$i?>+",0,0);' value=' 搜索 '/><input type='text' id='attridisplay"+<?=$i?>+"' name='' value='' disabled='disabled'/></td>");
					<?php
					}
					?>
				}else{
					<?php
					for($j=0;$j<count($displayattrvalues);$j++){
					?>
						if(<?=$displayattrkeys[$i]['id']?>==<?=$displayattrvalues[$j]['aid']?>){
							tdobj1 = $("<td><input type='text' id='attri"+<?=$i?>+"' name='attri["+<?=$i?>+"][0]' value='<?=$displayattrvalues[$j]['attributevalue']?>'></td>");	
						}
					<?php
					}
					if(!in_array($displayattrkeys[$i]['id'],$displayattrvalueaids)){
					?>
						tdobj1 = $("<td><input type='text' id='attri"+<?=$i?>+"' name='attri["+<?=$i?>+"][0]' value=''></td>");
					<?php
					}
					?>	
				}
				
			}else{
				var valuestr = '<?=$displayattrkeys[$i]['attributevalue']?>';
				var valuearr = valuestr.split(",");
				tdobj1 = $("<td></td>");
				var goods_sn = new Array();
				var goodsname = new Array();
				var gids = new Array();
				if(<?=$displayattrkeys[$i]['isrelate']?>==1){
					for(k=0;k<valuearr.length;k++){
						divobj = $("<div></div>");
						var flag = <?=$i?>+""+k;
						var prevflag = <?=$i?>+""+(k-1);

						selectobj = $("<select name='attri["+<?=$i?>+"]["+k+"]' id='arrtselect"+flag+"' onfocus='checkrelate(\""+prevflag+"\",\""+flag+"\");'></select>");
						option1 = $("<option value='1000000'>请选择属性值</option>");
						selectobj.append(option1);
						<?php
						for($m=0;$m<count($displayattrvalues);$m++){
						?>
							if(valuearr[k]=='<?=$displayattrvalues[$m]['attributevalue']?>'){
								for(j=0;j<valuearr.length;j++){
									if(valuearr[j]=='<?=$displayattrvalues[$m]['attributevalue']?>'){
										var optionObj = $("<option value='"+valuearr[j]+"' selected='selected'>"+valuearr[j]+"</option>");
										goods_sn[k] = '<?=$displayattrvalues[$m]['goods_sn']?>';
										goodsname[k] = '<?=$displayattrvalues[$m]['goodsname']?>';
										gids[k] = <?=$displayattrvalues[$m]['relategoods']?>;
									}else{
										var optionObj = $("<option value='"+valuearr[j]+"'>"+valuearr[j]+"</option>");
									}
									selectobj.append(optionObj);
								} 
							}
						<?php
						}
						?>
						//alert(valuearr[k]);
						var disattrsvalues = new Array();
						<?php
							for($u=0;$u<count($disattrsvalues);$u++){
						?>
							disattrsvalues.push('<?=$disattrsvalues[$u]?>');
						<?php
							}
						?>
						if(!in_array(valuearr[k],disattrsvalues)){
							//alert(valuearr[k]+"kk");
							for(j=0;j<valuearr.length;j++){	
								var optionobj = $("<option value='"+valuearr[j]+"'>"+valuearr[j]+"</option>");
								selectobj.append(optionobj);
							}
						}
						
						divobj.append(selectobj);
						if(typeof(goods_sn[k])!="undefined"){
							var searchtext = $("<span> 与此属性关联的商品</span><input type='text' name='' value='"+goods_sn[k]+"' id='attrisearch"+flag+"'/> <input type='button' onclick='searchgoods(\""+flag+"\","+<?=$i?>+","+k+",1);' value=' 搜索 '/><input type='text' id='attridisplay"+flag+"' name='' value='"+goodsname[k]+"' disabled='disabled'/><span class='note'>如果选择属性，请务必关联属性</span>");
							
							if(typeof($("#relateattrgoods"+flag).val())!="undefined"){
								$("#relateattrgoods"+flag).remove();
							}
							var relategoodshid = $("<input type='hidden' name='relategoods[<?=$i?>]["+k+"]' value='"+gids[k]+"' id='relateattrgoods"+flag+"' />");
							$("#relatehid").append(relategoodshid);
							
						}else{
							var searchtext = $("<span> 与此属性关联的商品</span><input type='text' name='' value='' id='attrisearch"+flag+"'/> <input type='button' onclick='searchgoods(\""+flag+"\","+<?=$i?>+","+k+",1);' value=' 搜索 '/><input type='text' id='attridisplay"+flag+"' name='' value='' disabled='disabled'/><span class='note'>如果选择属性，请务必关联属性</span>");
						}
						divobj.append(searchtext);
						tdobj1.append(divobj);
					}
				}else{
					<?php
					for($k=0;$k<count($displayattrvalues);$k++){
					?>
						if(<?=$displayattrkeys[$i]['id']?>==<?=$displayattrvalues[$k]['aid']?>){
							selectobj = $("<select name='attri["+<?=$i?>+"][0]'></select>");
							option1 = $("<option value='1000000'>请选择属性值</option>");
							selectobj.append(option1);
							var optionobj ='';
							for(j=0;j<valuearr.length;j++){
								if(valuearr[j]=='<?=$displayattrvalues[$k]['attributevalue']?>'){
									optionobj = $("<option value='"+valuearr[j]+"' selected='selected'>"+valuearr[j]+"</option>");
								}else{
									optionobj = $("<option value='"+valuearr[j]+"'>"+valuearr[j]+"</option>");
								}
								selectobj.append(optionobj);
							}
							tdobj1.append(selectobj);
						}
					<?php
					}
					if(!in_array($displayattrkeys[$i]['id'],$displayattrvalueaids)){
					?>
						selectobj = $("<select name='attri["+<?=$i?>+"][0]'></select>");
						option1 = $("<option value='1000000'>请选择属性值</option>");
						selectobj.append(option1);
						var optionobj ='';
						for(j=0;j<valuearr.length;j++){
							optionobj = $("<option value='"+valuearr[j]+"'>"+valuearr[j]+"</option>");
							selectobj.append(optionobj);
						}
						tdobj1.append(selectobj);
					<?php
					}
					?>	
				}
			}
			
			trobj.append(tdobj);
			trobj.append(tdobj1);
			tab.append(trobj);
		<?php
		}
		?>
	}
	
	//初始化所属分类信息
	function initdirectorycate(){
		//加载所属分类的下拉框
		<?php
		for($i=1;$i<count($directcates);$i++){
		?>
		if(<?=count($subcates[$i-1])?>>0){
			var _select = $("<select name='category[]' onchange=\"addselect("+(<?=$i+1?>)+",'catebox1','category','category',1)\" id='category"+(<?=$i+1?>)+"'></select>");
			//var option1 = document.createElement("option");
//			option1.text = "请选择分类";
//			option1.value = 1000000;
//			_select.append(option1);
			_select.append("<option value='1000000'>请选择分类</option>");
			<?php
			for($j=0;$j<count($subcates[$i-1]);$j++){
			?>
				if(<?=$directcates[$i]['id']?>==<?=$subcates[$i-1][$j]['id']?>){
					_select.append("<option selected='selected' value='<?=$subcates[$i-1][$j]['id']?>'><?=$subcates[$i-1][$j]['categoryname']?></option>");
				}else{
					_select.append("<option value='<?=$subcates[$i-1][$j]['id']?>'><?=$subcates[$i-1][$j]['categoryname']?></option>");
				}
			<?php
			}
			?>
		}
		$("#catebox1").append(_select);
		<?php
		}
		?>
	}
	
	//在数组中搜索某个选项
	function in_array(word,wordarr){
		for(n=0;n<wordarr.length;n++){
			//alert(wordarr[n]+"n");
			if(word==wordarr[n]){
				return wordarr[n];
			}
		}
		return false;
	}
	
	//搜索商品通过文章标题
	function searcharticle(){
		$("#articleleft").empty();
		var atitle = $("#article").attr('value');
		var url = "<?=URL?>index.php/admin/goods/searcharticle";
		$.get(url,{title:atitle},function(data){
			var selectobj = $("#articleleft");
			eval(data);
			for(i=0;i<artiles.length;i++){
				var optionobj = document.createElement("option");
				optionobj.text = artiles[i].title;
				optionobj.value = artiles[i].id;
				selectobj.append(optionobj);
			}
		});
	}
	//搜索商品通过品牌分类关键字
	function searchgoodsby(gid){
		$("#relateleft").empty();
		
		var cate = $("#relatecate").attr('value');
		var brand = $("#relatebrand").attr('value');
		var keywords = $("#relategoodswords").attr('value');
		var url = "<?=URL?>index.php/admin/goods/goodssearch";
		$.get(url,{cid:cate,bid:brand,keywords:keywords},function(data){
			var selectobj = $("#relateleft");
			eval(data);
			for(i=0;i<goods.length;i++){
				if(goods[i].id!=gid){
					var optionobj = document.createElement("option");
					optionobj.text = goods[i].goodsname;
					optionobj.value = goods[i].id;
					selectobj.append(optionobj);
				}
			}
		});
	}
	//商品，文章关联，左边向右移动单项
	function copytoright(leftobj,rightobj){
		var leftvalue = $("#"+leftobj).attr('value');
		var lefttext = $("#"+leftobj).find("option:selected").text();
		var selectrightobj = $("#"+rightobj);
		
		var rightcount = document.getElementById(rightobj).length;
		for(i=0;i<rightcount;i++){
			if(lefttext==selectrightobj.get(0).options[i].text){
				return false;
			}
		}
		
		var optionobj = document.createElement("option");
		optionobj.text = lefttext;
		optionobj.value = leftvalue;
		selectrightobj.append(optionobj);
		//左右移动的时候先清除相对应的hidden，在获取值
		if(leftobj=="relateleft"){
			$("#divhiddrelatesgoods").children().remove();
			evaluategoods();
		}else if(leftobj=="articleleft"){
			$("#divhiddrelatearticle").children().remove();
			evaluatearticle();
		}else if(leftobj=="leftprofun"){
			$("#divhiddprofun").children().remove();
			evaluateprofun();
		}
		
	}
	//商品，文章关联，左边向右移动多项
	function copystoright(leftobj,rightobj,divname){
		var rightobj = $("#"+rightobj);
		rightobj.empty();
		$("#"+divname).children().remove();
		var rightcount = document.getElementById(leftobj).length;
		var valueArr = new Array();
		var textArr = new Array();
		for(i=0;i<rightcount;i++){
			valueArr.push(document.getElementById(leftobj).options[i].value);
			textArr.push($("#"+leftobj).get(0).options[i].text);
		}
		
		for(i=0;i<valueArr.length;i++){
			var optionobj = document.createElement("option");
			optionobj.text = textArr[i];
			optionobj.value = valueArr[i];
			rightobj.append(optionobj);
		}
	}
	//商品，文章关联，去除右面的部分单项
	function moveright(rightobj){
		$("#"+rightobj).find("option:selected").remove();
		//左右移动的时候先清除相对应的hidden，在获取值
		if(rightobj=="relateright"){
			$("#divhiddrelatesgoods").children().remove();
		}else if(rightobj=="articleright"){
			$("#divhiddrelatearticle").children().remove();
		}else if(rightobj=="rightprofun"){
			$("#divhiddprofun").children().remove();
		}
	}
	//商品，文章关联，右面的部分全部去除
	function moverights(rightobj,divname){
		$("#"+rightobj).empty();
		$("#"+divname).children().remove();
	}
	
	function searchgoods(flag,nameflagi,nameflagk,arrflag){
		var searchvalue = $("#attrisearch"+flag).attr('value');
		var url = "<?=URL?>index.php/admin/goods/searchgoods";
		$.get(url,{gsn:searchvalue},function(data){
			eval(data);
			
			$("#attridisplay"+flag).val('');
			$("#attridisplay"+flag).val(goods.goodsname);
			if(typeof($("#relateattrgoods"+flag).val())!="undefined"){
				$("#relateattrgoods"+flag).remove();
			}
			if(goods.goodsname!=null||typeof(goods.goodsname)!="undefined" ){
				createrelatehid(goods.id,flag,nameflagi,nameflagk,arrflag);
			}
		});
	}
	
	//创建hidden存放关联商品
	function createrelatehid(gid,flag,nameflagi,nameflagk,arrflag){
		var relatehid = $("#relatehid");
		var relategoods = '';
		if(arrflag==0){
			relategoods = $("<input type='hidden' name='relategoods["+nameflagi+"][0]' id='relateattrgoods"+flag+"' value='"+gid+"' />");
		}else{
			relategoods = $("<input type='hidden' name='relategoods["+nameflagi+"]["+nameflagk+"]' id='relateattrgoods"+flag+"' value='"+gid+"' />");
		}
		
		relatehid.append(relategoods);
	}
	//选择属性后，检查是否关联了商品
	function checkrelate(prevflag,flag){
		if(prevflag!="0-1"){
			if($("#arrtselect"+prevflag).val()!=1000000){
				if($("#attridisplay"+prevflag).val()==''){
					alert("请填写关联商品编号，搜索其是否存在！");
				}
			}
		}
	}
	//添加属性
	function createattribute(pid){
		
		var cid = $("#category"+(pid)).attr('value');
		var relatehid = $("#relatehid");
		relatehid.children().remove();
		var tab = $("#tabattri");
		tab.children().remove();
		
		$.get("<?=URL?>index.php/admin/goods/createattribute",{cid:cid},function(data){
			eval(data);
			for(i=0;i<attris.length;i++){
				var trobj = $("<tr></tr>");
				var tdobj =  $("<td class='label'>"+attris[i].attributename+"</td>");
				var tdobj1 = "";
				if(attris[i].attributetype==0){
					if(attris[i].isrelate==1){
						
						tdobj1 = $("<td><input type='text' id='attri"+i+"' name='attri["+i+"][0]' value=''> 与此属性关联的商品<input type='text' name='' value='' id='attrisearch"+i+"'/> <input type='button' onclick='searchgoods("+i+","+i+",0,0);' value=' 搜索 '/><input type='text' id='attridisplay"+i+"' name='' value='' disabled='disabled'/></td>");
						
					}else{
						tdobj1 = $("<td><input type='text' id='attri"+i+"' name='attri["+i+"][0]' value=''></td>");
					}
					
				}else{
					var valuearr = attris[i].attributevalue.split(",");
					tdobj1 = $("<td></td>");
					if(attris[i].isrelate==1){
						for(k=0;k<valuearr.length;k++){
							divobj = $("<div></div>");
							var flag = i+""+k;
							var prevflag = i+""+(k-1);
							selectobj = $("<select name='attri["+i+"]["+k+"]' id='arrtselect"+flag+"' onfocus='checkrelate(\""+prevflag+"\",\""+flag+"\");'></select>");
							//option1 = document.createElement("option");
//							option1.text = "请选择属性值";
//							option1.value = 1000000;
//							selectobj.append(option1);
							selectobj.append("<option value='1000000'>请选择属性值</option>");
							for(j=0;j<valuearr.length;j++){
								selectobj.append("<option value='"+valuearr[j]+"'>"+valuearr[j]+"</option>");
								//var optionObj = document.createElement("option");
//								optionObj.text = valuearr[j];
//								optionObj.value = valuearr[j];
//								selectobj.append(optionObj);
							} 
							divobj.append(selectobj);
							
							var searchtext = $("<span> 与此属性关联的商品</span><input type='text' name='' value='' id='attrisearch"+flag+"'/> <input type='button' onclick='searchgoods(\""+flag+"\","+i+","+k+",1);' value=' 搜索 '/><input type='text' id='attridisplay"+flag+"' name='' value='' disabled='disabled'/><span class='note'>如果选择属性，请务必关联属性</span>");
							divobj.append(searchtext);
							tdobj1.append(divobj);
						}
					}else{
						selectobj = $("<select name='attri["+i+"][0]'></select>");
						//option1 = document.createElement("option");
//						option1.text = "请选择属性值";
//						option1.value = 1000000;
//						selectobj.append(option1);
						selectobj.append("<option value='1000000'>请选择属性值</option>");
						for(j=0;j<valuearr.length;j++){
							selectobj.append("<option value='"+valuearr[j]+"'>"+valuearr[j]+"</option>");
							//var optionObj = document.createElement("option");
//							optionObj.text = valuearr[j];
//							optionObj.value = valuearr[j];
//							selectobj.append(optionObj);
						}
						tdobj1.append(selectobj);
					}
				}
				
				trobj.append(tdobj);
				trobj.append(tdobj1);
				tab.append(trobj);
			}
			//$("#attrcount").val(attris.length);
		});
	}
	//分类添加下拉菜单
	function addselect(pid,catediv,cateid,catename,cateattr){
		var pid = pid;
		if(cateattr==1){
			createattribute(pid);
		}
		if(pid <selectcount){
			for(i=(pid+1);i<=selectcount;i++){
				$('#'+cateid+i).remove();
			}
		}
		
		cid = $("#"+cateid+pid).attr("value");
		if(cateattr==1){
			$("#cid").val(cid);
		}
		var newcate = new Array();
		for(i=0;i<cates.length;i++){
			if(cates[i]['pid']==cid){
				newcate.push(cates[i]);
			}
		}
		
		if(!newcate.length){
			return false;
		}
		return createselect(newcate,pid+1,catediv,cateid,catename,cateattr);
	}
	
	function createselect(cateArr,pid,catediv,cateid,catename,cateattr){
		var pid = pid;
		selectcount++;
		var selectdiv = $("#"+catediv);
		var _select = $("#"+cateid+pid);
		if(_select.length==0){
			var _select = $("<select name='"+catename+"[]' onchange=\"addselect("+pid+",'"+catediv+"','"+cateid+"','"+catename+"',"+cateattr+")\" id='"+cateid+pid+"'></select>");
			//var option1 = document.createElement("option");
//			option1.text = "请选择分类";
//			option1.value = 1000000;
//			_select.append(option1);
			_select.append("<option vlaue='1000000'>请选择分类</option>");
			for(i=0;i<cateArr.length;i++){
				_select.append("<option value='"+cateArr[i]['cid']+"'>"+cateArr[i]['cname']+"</option>");
				//var optionObj = document.createElement("option");
//				optionObj.text = cateArr[i]['cname'];
//				optionObj.value = cateArr[i]['cid'];
//				_select.append(optionObj);
			}
			selectdiv.append(_select);
		}else{
			_select.empty();
		}
		return false;
	}
	//添加扩展分类
	function addextend(){
		extend++;
		var divObj = $("#categorybox");
		catediv = "categorybox"+extend+extend;
		cateid = "category"+extend;
		catename = "category"+extend;
		var divc = $("<div id="+catediv+"></div>");
		var selectobj = $("<select name='"+catename+"[]' onchange=\"addselect(1,'"+catediv+"','"+cateid+"','"+catename+"',0)\" id='"+cateid+"1'></select>");
		//var option1 = document.createElement("option");
//		option1.text = "请选择分类";
//		option1.value = 1000000;
//		selectobj.append(option1);
		selectobj.append("<option value='1000000'>请选择分类</option>");
		<?php
		for($i=0;$i<count($cate);$i++){
		?>
			selectobj.append("<option value='<?=$cate[$i]['id']?>'>"+'<?=$cate[$i]['categoryname']?>'+"</option>");
			//var optionObj = document.createElement("option");
//			optionObj.text = "<?=$cate[$i]['categoryname']?>";
//			optionObj.value = <?=$cate[$i]['id']?>;
//			selectobj.append(optionObj);
		<?php
		}
		?>
		divc.append(selectobj);
		divObj.append(divc);
		//扩展的数量控制
		$("#cateextend").val(extend);
	}
	//添加上传
	function addfile(){
		imgcount++;
		var tab = $("#uploadimg");
		var trobj = $("<tr id='img"+imgcount+"'><td class='label'><a href='javascript:void(0);' onclick='cutfile();'>[-]</a><input type='radio' name='checkimg' value='' />图片描述<input type='text' name='imgs[]' id='' size='40' /> 上传文件 <input type='file' name='picfile[]' id='' /></td></tr>");
		tab.append(trobj);
	}
	//删除上传文件
	function cutfile(){
		$("#img"+imgcount).remove();
		imgcount--;
	}
	//关联商品赋值
	function evaluategoods(){
		var goodslength = document.getElementById("relateright").length;
		var divobj = $("#divhiddrelatesgoods");
		for(i=0;i<goodslength;i++){
			var hidobj = $("<input type='hidden' id='regoods"+document.getElementById("relateright").options[i].value+"' name='relatesgoods[]' value='"+document.getElementById("relateright").options[i].value+"' />");
			divobj.append(hidobj);
		}
	}
	//关联文章赋值
	function evaluatearticle(){
		var articlelength = document.getElementById("articleright").length;
		var divobj = $("#divhiddrelatearticle");
		for(i=0;i<articlelength;i++){
			var hidobj = $("<input type='hidden' id='rearticle"+document.getElementById("articleright").options[i].value+"' name='relatearticle[]' value='"+document.getElementById("articleright").options[i].value+"' />");
			divobj.append(hidobj);
		}
	}
	
	//促销赋值
	function evaluateprofun(){
		var profunlength = document.getElementById("rightprofun").length;
		var divobj = $("#divhiddprofun");
		for(i=0;i<profunlength;i++){
			var hidobj = $("<input type='hidden' name='profuns[]' value='"+document.getElementById("rightprofun").options[i].value+"' />");
			divobj.append(hidobj);
		}
	}
	
	function clearbox(){
		$("#catebox1").children().remove();
	}
	function delextendcate(divid,cid,gid){
		var url = "<?=URL?>index.php/admin/goods/delcategoods";
		$.get(url,{cid:cid,gid:gid},function(data){
			if(data){
				$("#"+divid).remove();
			}
		});
		
	}
	function delgoodspic(aid,gid,picdiv){
		var url = "<?=URL?>index.php/admin/goods/delgoodspic";
		$.get(url,{aid:aid,gid:gid},function(data){
			if(data==1){
				$("#"+picdiv).remove();
			}
		});
	}
	

  </script>
</head>
<body align="center">
<div id="aa"></div>
<ul id="container">
	<li id="header">
	<h1>修改商品</h1>
	<div class="link"><a href="<?=URL?>index.php/admin/goods/goodslist">商品列表</a></div>
	<div id="desc"></div>
	</li>
	<li>
	<form name="goodsForm" onsubmit="" method="post"
		enctype="multipart/form-data">
	<div id="tab-form"><!--class="tab-form"-->
	<ul class="tab-bar">
		<li class="actived">基本信息</li>
		<li>详细信息</li>
		<li>商品属性</li>
		<li>商品图片</li>
		<li>关联商品</li>
		<li>关联文章</li>
		<li>促销方案</li>
		<li>推荐选项</li>
	</ul>
	<div class="tab-page">
	<table class="form-table">
		<tr>
			<td class="label">商品名称</td>
			<td><input type="text" name="goodsname" id="goodsname" size="40"
				value="<?=$goods->goodsname?>" /><span class="note">备注信息</span></td>
		</tr>
		<tr>
			<td class="label">商品编号</td>
			<td><input type="text" name="goods_sn" id="goods_sn" size="40"
				value="<?=$goods->goods_sn?>" disabled="disabled" /><span
				class="note">备注信息</span></td>
		</tr>
		<tr>
			<td class="label">所属标签</td>
			<td><?php
			for($i=0;$i<count($brand);$i++){
				if(in_array($brand[$i]->id,$lables)){
				?>
			<input type="checkbox"
				name="brands[]" checked="checked" value="<?=$brand[$i]->id?>" /><?=$brand[$i]->bname?></div>
				<?php
				}else{
					?>
			<div style="margin-right: 10px; float: left;"><input type="checkbox"
				name="brands[]" value="<?=$brand[$i]->id?>" /><?=$brand[$i]->bname?></div>
				<?php
				}
			}
			?> <!--select name="brand">
				<?php
					for($i=0;$i<count($brand);$i++){
				?>
					<option value="<?=$brand[$i]->id?>"><?=$brand[$i]->bname?></option>
				<?php
					}
				?>
				</select--></td>
		</tr>
        <tr>
        	<td class="label">所属品牌</td>
            <td>
            <select name="tags">
            <option value="0">请选择品牌</option>
            <?php
				for($i=0;$i<count($tags);$i++){
					if($goods->bid==$tags[$i]->id){
			?>
            	<option selected="selected" value="<?=$tags[$i]->id?>"  checked="checked"/><?=$tags[$i]->bname?></option>
            <?php
					}else{
			?>
            	<option	value="<?=$tags[$i]->id?>" /><?=$tags[$i]->bname?></option>
            <?php
					}
				}
            ?>
            </select>
            </td>
        </tr>
        <tr>
        	<td class="label">所属作品</td>
            <td>
            <select name="works">
            <option value="0">请选择作品</option>
            <?php
				for($i=0;$i<count();$i++){
					if($goods->wid==$works[$i]->id){
			?>
            	<option selected="selected" value="<?=$works[$i]->id?>" /><?=$works[$i]->wname?></option>
            <?php	
					}else{
			?>
            	<option value="<?=$works[$i]->id?>" /><?=$works[$i]->wname?></option>
            <?php	
					}
				}
            ?>
            </select>
            </td>
        </tr>
		<tr>
			<td class="label">所属分类</td>
			<td>
			<div style="float: left"><select
				onchange="clearbox();return addselect(1,'categorybox1','category','category',1);"
				name="category[]" id="category1">
				<option value="1000000">请选择分类</option>
				<?php
				for($i=0;$i<count($cate);$i++){
					if($cate[$i]['id']==$directcates[0]['id']){
						?>
				<option value="<?=$cate[$i]['id']?>" selected="selected"><?=$cate[$i]['categoryname']?></option>
				<?php
					}else {
						?>
				<option value="<?=$cate[$i]['id']?>"><?=$cate[$i]['categoryname']?></option>
				<?php
					}
				}
				?>
			</select></div>
			<div id="categorybox1"></div>
			<div id="catebox1"></div>
			<span class="note">备注信息</span></td>
		</tr>
		<tr>
			<td class="label"></td>
			<td><?php	
			for($i=0;$i<count($extendcates);$i++){
				?>
			<div id='ext<?=$i?>'><a href="javascript:void(0);"
				onclick="delextendcate('ext<?=$i?>',<?=$extendcates[$i]['id']?>,<?=$extendcates[$i]['goodsid']?>);"><span>[-]</span></a><?=$extendcates[$i]['categoryname']?></div>
				<?php
			}
			?> <input type="button" onclick="addextend();" value=" 扩展分类 "/>
			<div id="categorybox"></div>
				<span class="note">扩展按钮上面的分类是已经添加的分类，点击[-]可删除这个扩展分类</span></td>
		</tr>
		<tr>
			<td class="label">商品单位</td>
			<td><input type="text" name="unit" id="unit"
				value="<?=$goods->unit?>"><span class="note">备注信息</span></td>
		</tr>
		<tr>
			<td class="label">生产商</td>
			<td><select id="producer" name="producer">
			<?php
			for($i=0;$i<count($producer);$i++){
				if($goods->pid==$producer[$i]->id){
					?>
				<option value="<?=$producer[$i]->id?>" selected="selected"><?=$producer[$i]->pname?></option>
				<?php
				}else{
					?>
				<option value="<?=$producer[$i]->id?>"><?=$producer[$i]->pname?></option>
				<?php
				}
			}
			?>
			</select><span class="note">备注信息</span></td>
		</tr>
		<tr>
			<td class="label">供应商</td>
			<td><select id="suppliers" name="suppliers">
			<?php
			for($i=0;$i<count($supply);$i++){
				if($goods->sid==$supply[$i]->id){
					?>
				<option value="<?=$supply[$i]->id?>" selected="selected"><?=$supply[$i]->suppliername?></option>
				<?php
				}else{
					?>
				<option value="<?=$supply[$i]->id?>"><?=$supply[$i]->suppliername?></option>
				<?php
				}
			}
			?>
			</select><span class="note">备注信息</span></td>
		</tr>
		<tr>
			<td class="label">库存数量</td>
			<td><input type="text" id="stock" name="stock"
				value="<?=$goods->leavingcount?>" disabled="disabled"><span
				class="note">备注信息</span></td>
		</tr>
		<tr>
			<td class="label">商品进价</td>
			<td><input type="text" id="buyprice" name="buyprice"
				value="<?=$goods->inprice?>" disabled="disabled"><span class="note">备注信息</span></td>
		</tr>
		<tr>
			<td class="label">市场价格</td>
			<td><input type="text" id="marketprice" name="marketprice"
				value="<?=$goods->marketprice?>" disabled="disabled"><span
				class="note"></span></td>
		</tr>
		<tr>
			<td class="label">本店售价</td>
			<td><input type="text" id="shopprice" name="shopprice"
				value="<?=$goods->shopprice?>" disabled="disabled"><span
				class="note">备注信息</span></td>
		</tr>
		<tr>
			<td class="label">会员价格</td>
			<td><?php
			for($i=0;$i<count($member);$i++){
				?> <?=$member[$i]->mname?>:<input type="text" name="member[]"
				id="<?=$member[$i]->id?>" value="<?=$memberprice[$i]['mprice']?>"
				disabled="disabled" size="5" /> 元 <?php
			}
			?> <span class="note">备注信息</span></td>
		</tr>
		<tr>
			<td class="label">赠送积分</td>
			<td><input type="text" name="points" id="points"><span class="note">备注信息</span></td>
		</tr>
	</table>
	</div>
	<div class="tab-page tab-form">
	<table class="form-table">
		<tr>
			<td class="label">重量</td>
			<td><input type="text" name="weight" id="weight" size="40"
				value="<?=$goods->weight?>" /><select name="weightunit">
				<option value="克" <?php if($goods->weightunit=="克"){?>
					selected="selected" <?php }?>>克</option>
				<option value="千克" <?php if($goods->weightunit=="千克"){?>
					selected="selected" <?php }?>>千克</option>
			</select><span class="note"></span></td>
		</tr>
		<tr>
			<td class="label">关键字</td>
			<td><input type="text" name="keywords" id="keywords" size="40"
				value="<?=$goods->keywords?>" /><span class="note">（关键字之间用英文的逗号隔开）</span></td>
		</tr>
		<tr>
			<td class="label">简单描述</td>
			<td><textarea name="des" id="des" cols="200" rows="10"><?=$goods->des?></textarea><span
				class="note">备注信息</span></td>
		</tr>
		<tr>
			<td class="label">详细描述</td>
			<td> 
			<?php 
			require_once (MEDIA_ROOT . 'fckeditor/fckeditor.php');
			//include_once(MEDIA_URL.'fckeditor/fckeditor.php');//加载FCKeditor文件 
			$oFCKeditor = new FCKeditor('description');//创建一个FCKeditor对象 ID为FCKeditor1 
			$oFCKeditor ->BasePath = URL.'media/fckeditor/';//设置FCKeditor路径 
			//$model1=""
			$oFCKeditor ->Value = $goodsext->description;//设置默认值 
			//工具按钮设置 
			$oFCkeditor->ToolbarSet='Default';
			//设置它的宽度 
			$oFCKeditor->Width='100%';
			//设置它的高度 
			$oFCKeditor->Height='600px';
			$oFCKeditor ->create();
			?> 
			<select id="mod" onchange="changemod();">
				<option value="0">默认模版</option>
				<option value="1">模版一</option>
				<option value="2">模版二</option>
				<option value="3">模版三</option>
			</select> <span class="note">备注信息</span></td>
		</tr>
	</table>
	</div>
	<div class="tab-page tab-form">
	<table id="tabattri" class="form-table">
		<td class="label"><span class="note">选择分类后，才显示所选的最后一级的分类属性</span></td>
	</table>
	</div>

	<div class="tab-page tab-form">
	<table id="uploadimg" class="form-table">
		<tr>
			<td colspan="2"><?php
			for($i=0;$i<count($goodspic);$i++){
				?>
			<div id="goodspic<?=$i?>" style="float: left; margin-right: 10px;"><a
				href="javascript:void(0);"
				onclick="delgoodspic(<?=$goodspic[$i]['aid']?>,<?=$goodspic[$i]['goodsid']?>,'goodspic<?=$i?>');">[-]</a><img
				src="<?=URL.$goodspic[$i]['apath'].$goodspic[$i]['filename'].'_62.'.$goodspic[$i]['atype']?>" /></div>
				<?php
			}
			?></td>
		</tr>
		<tr>
			<td class="label"><a href="javascript:void(0);" onclick="addfile();">[+]</a>图片描述<input
				type="text" name="imgs[]" id="" size="40" /> 上传文件 <input type="file"
				name="picfile[]" id="" /></td>
		</tr>
	</table>
	</div>

	<div class="tab-page tab-form">
	<table id="relategoods" class="form-table">
		<tr>
			<td colspan="2" style="padding-left: 35px;"><select id="relatecate"
				name="relatecate">
				<option value="0">所有分类</option>
				<?php
				for($i=0;$i<count($cateall);$i++){
			  ?>
				<option value="<?=$cateall[$i]->id?>"><?=$cateall[$i]->categoryname?></option>
				<?php
				}
				?>
			</select>&nbsp;<select id="relatebrand" name="relatebrand">
				<option value="0">所有品牌</option>
				<?php
				for($i=0;$i<count($brand);$i++){
			  ?>
				<option value="<?=$brand[$i]->id?>"><?=$brand[$i]->bname?></option>
				<?php
				}
				?>
			</select>&nbsp;<input type="text" name="relategoodswords"
				id="relategoodswords" /><input type="button"
				onclick="searchgoodsby(<?=$goods->id?>);" value=" 搜索 " /></td>
		</tr>
		<tr>
			<td class="label">可选商品</td>
			<td class="label">跟该产品相关联的产品</td>
		</tr>
	</table>
	<div style="margin-left: 35px; float: left;"><select id="relateleft"
		name="relateleft"
		style="width: 300px; height: 270px; cursor: pointer;"
		multiple="multiple"></select></div>
	<div style="float: left; padding: 80px;">
	<div style="margin-bottom: 10px;"><input type="button"
		onclick="copystoright('relateleft','relateright','divhiddrelatesgoods');evaluategoods();"
		value=">>" /></div>
	<div style="margin-bottom: 10px;"><input type="button"
		onclick="return copytoright('relateleft','relateright');" value=">" /></div>
	<div style="margin-bottom: 10px;"><input type="button"
		onclick="moveright('relateright');evaluategoods();"
		value="<"/></div><div ><input type="button" onclick="moverights('relateright','divhiddrelatesgoods');evaluategoods();" value="<<" /></div></div>
		  <div><select id="relateright" name="relateright" style="width:300px;height:270px;cursor:pointer;" multiple="multiple"></select></div>
        </div>

		<div class="tab-page tab-form">
          <table id="relatearticles" class="form-table">
            <tr>
              <td colspan="2" style="padding-left:35px;width:40px;">文章标题 <input type="text" name="article" id="article" size="40"/><input type="button" onclick="searcharticle();" value=" 搜索 " /></td>
            </tr>
            <tr>
              <td class="label">可选文章</td><td class="label">跟该产品相关联的文章</td>
            </tr>
          </table>
		  <div style="margin-left:35px;float:left;"><select id="articleleft" name="articleleft" style="width:300px;height:270px;cursor:pointer;" multiple="multiple"></select></div>
		  <div style="float:left;padding:80px;"><div style="margin-bottom:10px;"><input type="button" onclick="copystoright('articleleft','articleright','divhiddrelatearticle');evaluatearticle();" value=">>"/></div><div  style="margin-bottom:10px;"> <input type="button" onclick="return copytoright('articleleft','articleright');" value=">"/></div><div style="margin-bottom:10px;"><input type="button" onclick="moveright('articleright');evaluatearticle();" value="<"/></div><div ><input type="button" onclick="moverights('articleright','divhiddrelatearticle');evaluatearticle();" value="<<" /></div></div>
		  <div><select id="articleright" name="articleright" style="width:300px;height:270px;cursor:pointer;" multiple="multiple"></select></div>
        </div>
		
		<div class="tab-page tab-form">
          <table class="form-table">
            <tr>
              <td class="label">请选择促销方案</td><td></td>
            </tr>
          </table>
		  <div style="margin-left:35px;float:left;">
		  <select name="leftprofun" id="leftprofun" style="width:300px;height:270px;cursor:pointer;" multiple="multiple">
			  <?php
			  	for($i=0;$i<count($profun);$i++){
			  ?>
			  <option value="<?=$profun[$i]->id?>"><?=$profun[$i]->act_title?></option>
			  <?php
			  	}
			  ?>
		 </select>
		  </div>
		  <div style="float:left;padding:80px;"><div style="margin-bottom:10px;"><input type="button" onclick="copystoright('leftprofun','rightprofun','divhiddprofun');evaluateprofun();" value=">>"/></div><div  style="margin-bottom:10px;"> <input type="button" onclick="return copytoright('leftprofun','rightprofun');" value=">"/></div><div style="margin-bottom:10px;"><input type="button" onclick="moveright('rightprofun');evaluateprofun();" value="<"/></div><div ><input type="button" onclick="moverights('rightprofun','divhiddprofun');evaluateprofun();" value="<<" /></div></div>
		  <div><select id="rightprofun" name="rightprofun" style="width:300px;height:270px;cursor:pointer;" multiple="multiple"></select></div>
        </div>

       <div class="tab-page tab-form">
          <table id="recommend" class="form-table">
            <tr>
               <td class="label"><div style="float:right">是否热销：</div></td><td><div style="float:left">
			   <select id="ishot" name="ishot"><option value="0" <?php if($goods->ishot=='0') echo 'selected'; ?> >否</option><option value="1" <?php if($goods->ishot=='1') echo 'selected'; ?>>是</option></select></div></td>
            </tr>
            <tr>
               <td class="label"><div style="float:right">是否新品：</div></td><td><div style="float:left">
                 <select id="isnew" name="isnew"><option value="0" <?php if($goods->isnew=='0') echo 'selected'; ?>>否</option><option value="1" <?php if($goods->isnew=='1') echo 'selected'; ?>>是</option></select></div></td>
            </tr>
            <tr>
               <td class="label"><div style="float:right">是否促销：</div></td><td><div style="float:left">
			   <select id="ispromotion" name="ispromotion"><option value="0" <?php if($goods->ispromotion=='0') echo 'selected'; ?>>否</option><option value="1" <?php if($goods->ispromotion=='1') echo 'selected'; ?>>是</option></select></div></td>
            </tr>
          </table>
       </div>

		<div id="divhidd">
		<input type="hidden" name="cateextend" id="cateextend" value=""/>
		
		<input type="hidden" name="leavingcounthid" id="leavingcounthid" value="<?=$goods->leavingcount?>"/>
		<input type="hidden" name="buypricehid" id="buypricehid" value="<?=$goods->inprice?>" />
		<input type="hidden" name="marketpricehid" id="marketpricehid" value="<?=$goods->marketprice?>" />
		<input type="hidden" name="shoppricehid" id="shoppricehid" value="<?=$goods->shopprice?>" />
		<input type="hidden" name="gid" id="gid" value="<?=$goods->id?>"/>
		<input type="hidden" name="cid" id="cid" value="" />
		</div>
		<!-- 放置产生的hidden相关联的产品和属性的总量 -->
		<div id="relatehid"></div>
		<div id="divhiddrelatesgoods"></div>
		<div id="divhiddrelatearticle"></div>
		<div id="divhiddprofun"></div>
        <p class="submitlist"><input type="submit" name="value_submit" value="提交" /> &nbsp; <input type="reset" name="value_submit" value="重置" /></p>
      </div>
      </form>
    </li>
    <li id="footer">
      <div>
      	Copyright ? 2007-2010 comicyu.com All rights reserved.
      </div>
    </li>
  </ul>
 </body>
</html>
