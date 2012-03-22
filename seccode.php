<?php
class seccodeViews {
	public static function index() {
		// 显示验证码
		//生成验证码图片 
		header("Content-type: image/PNG"); 
		srand((double)microtime()*1000000);//播下一个生成随机数字的种子，以方便下面随机数生成的使用
		//session_start();//将随机数存入session中
		$_SESSION['seccode']="";
		$authnum = "";
		$im = imagecreate(90,20) or die("Cant's initialize new GD image stream!");   //制定图片背景大小
		$red = ImageColorAllocate($im, 255,0,0); //设定三种颜色
		$white = ImageColorAllocate($im, 255,255,255); 
		$gray = ImageColorAllocate($im, 200,200,200); 
		//imagefill($im,0,0,$gray); //采用区域填充法，设定（0,0）
		imagefill($im,0,0,$white);//ed
		//生成数字和字母混合的验证码方法
		$ychar="0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z";
		$list=explode(",",$ychar);
		for($i=0;$i<4;$i++){
		   $randnum=rand(0,35);
		   $authnum.=$list[$randnum]." ";//ed 加入一个空格
		   $authnum1 .= $list[$randnum];
		}
		//while(($authnum=rand()%100000)<10000); //生成随机的四位数
		//将四位整数验证码绘入图片
		$_SESSION['seccode']=$authnum1;
		//int imagestring(resource image,int font,int x,int y,string s, int col)
		imagestring($im, 5, 10, 3, $authnum, $red);
		//用col颜色将字符串s画到image所代表的图像的x，y座标处（图像的左上角为0,0）。
		//如果 font 是 1，2，3，4 或 5，则使用内置字体
		
		for($i=0;$i<400;$i++){ //加入干扰象素 { 
		$randcolor = ImageColorallocate($im,rand(0,255),rand(0,255),rand(0,255));
		// imagesetpixel($im, rand()%90 , rand()%30 , $randcolor); 
		imagesetpixel($im, rand()%90 , rand()%30 , $gray); 
		} 
		ImagePNG($im); 
		ImageDestroy($im); 
	}
}