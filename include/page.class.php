<?php
/*
 * 商品列表分页
*/
if (!defined("PRO_ROOT")) {
	exit();
}
include_once DZG_ROOT.'core/pagination/pagination.php';

class page extends pagination{
	public function getPage($url,$type){
		$html = "<div class='pageination'> ";
		$vars = explode('_',$url);
		
		//exit();
		if ($this->page > 1) {
			// 不是一页，显示首页链接
			if($type=='category'){
				$reurl = $vars[0].'_'.$vars[1].'_1'.'_'.$vars[3].'_'.$vars[4];
			}else if($type=='attribute'){
				$reurl = $vars[0].'_'.$vars[1].'_1'.'_'.$vars[3].'_'.$vars[4].'_'.$vars[5].'_'.$vars[6].'_'.$vars[7].'_'.$vars[8].'_'.$vars[9].'_'.$vars[10].'_'.$vars[11].'_'.$vars[12].'_'.$vars[13].'_'.$vars[14];
			}else if($type=='comment'){
				$reurl = $vars[0].'_'.$vars[1].'_'.$vars[2].'_1';
			}else if($type=='zq'){
				$reurl = $vars[0].'_'.$vars[1].'_'.$vars[2].'_1';
			}else if($type=='article'){
				$reurl = $vars[0].'_'.$vars[1].'_1';
			}else if($type=='brand'){
				$reurl = $vars[0].'_'.$vars[1].'_1_'.$vars[3].'_'.$vars[4];
			}
			$html .= "<a class='link' href='{$reurl}'>首页</a> ";
		}
		$pageRange = $this->pageRange();
		foreach ($pageRange as $i) {
			if($type='category'){
				$reurl = $vars[0].'_'.$vars[1].'_'.$i.'_'.$vars[3].'_'.$vars[4];
			}else if($type=='attribute'){
				$reurl = $vars[0].'_'.$vars[1].'_'.$i.'_'.$vars[3].'_'.$vars[4].'_'.$vars[5].'_'.$vars[6].'_'.$vars[7].'_'.$vars[8].'_'.$vars[9].'_'.$vars[10].'_'.$vars[11].'_'.$vars[12].'_'.$vars[13].'_'.$vars[14];
			}else if($type=='comment'){
				$reurl = $vars[0].'_'.$vars[1].'_'.$vars[2].'_'.$i;
			}else if($type=='zq'){
				$reurl = $vars[0].'_'.$vars[1].'_'.$vars[2].'_'.$i;
			}else if($type=='article'){
				$reurl = $vars[0].'_'.$vars[1].'_'.$i;
			}else if($type=='brand'){
				$reurl = $vars[0].'_'.$vars[1].'_'.$i.'_'.$vars[3].'_'.$vars[4];
			}
			
			if ($i == $this->page) {
				$html .= "<a class='current_link'>{$i}</a> ";
			} else {
				$html .= "<a class='link' href='{$reurl}'>{$i}</a> ";
			}
		}
		if ($this->page != $this->pageCount) {
			// 不是最后一页，显示末页链接
			if($type=='category'){
				$reurl = $vars[0].'_'.$vars[1].'_'.$this->pageCount.'_'.$vars[3].'_'.$vars[4];
			}else if($type=='attribute'){
				$reurl = $vars[0].'_'.$vars[1].'_'.$this->pageCount.'_'.$vars[3].'_'.$vars[4].'_'.$vars[5].'_'.$vars[6].'_'.$vars[7].'_'.$vars[8].'_'.$vars[9].'_'.$vars[10].'_'.$vars[11].'_'.$vars[12].'_'.$vars[13].'_'.$vars[14];
			}else if($type=='comment'){
				$reurl = $vars[0].'_'.$vars[1].'_'.$vars[2].'_'.$this->pageCount;
			}else if($type=='zq'){
				$reurl = $vars[0].'_'.$vars[1].'_'.$vars[2].'_'.$this->pageCount;
			}else if($type=='article'){
				$reurl = $vars[0].'_'.$vars[1].'_'.$this->pageCount;
			}else if($type=='brand'){
				$reurl = $vars[0].'_'.$vars[1].'_'.$this->pageCount.'_'.$vars[3].'_'.$vars[4];
			}
			$html .= "<a class='link' href='{$reurl}'>末页</a> ";
		}
		$html .= "<span>{$this->pageCount}/{$this->page}</span> {$this->dataCount}</div>";
		return $html;
	}
}
?>