<?php
/**
 * 验证码生成类
 * @author chenlin
 */
namespace Apps\Common\Lib;
use Phalcon\Mvc\User\Component;
class Image extends  Component{
	public function  createImage(){
		//创建画布
		$image=imagecreatetruecolor(100, 30);
		$bgcolor=imagecolorallocate($image,rand(120,180),rand(120,180),rand(120,180));
		imagefill($image, 0,0,$bgcolor);
		//填充数字
		$str='';
		for($i=0;$i<4;$i++){
			$fontsize=6;
			$color=imagecolorallocate($image, 0, 0, 0);
			$code=rand(0,9);
			$str.=$code;
			$x=($i*100/4)+rand(5,10);
			$y=rand(5,10);
			imagestring($image,$fontsize,$x,$y,$code,$color);
		}
		$this->session->set('code',$str);
		//增加干扰点
		for($i=0;$i<50;$i++){
			$pointcolor=imagecolorallocate($image, rand(100,200),  rand(100,200),rand(100,200));
			imagesetpixel($image, rand(1,100), rand(1,29), $pointcolor);
		}
		ob_clean();
		header("content-type:image/png");
		imagepng($image);
		imagedestroy($image);
	}
}