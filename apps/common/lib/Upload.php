<?php
/**
 * 上传图片类 
 * @author chenlin
 *
 */
namespace Apps\Common\Lib;
class Upload{
	protected $maxSize;//文件上传大小 
	protected $allowExt=array('jpeg','jpg','png','gif');//允许上传的后辍
	//允许上传的类型
	protected $allowType=array("image/jpeg","image/png","image/gif");
	//上传的路径
	protected $uploadPath;
	protected $fileInfo;//上传后的文件信息
	protected $ext;//上传的文件后辍
	public $error;//保存错误 信息
	public function __construct($finename){
		$this->fileInfo=$_FILES[$finename];
		$this->maxSize=1024*1024*5;//最大只能上传5M 
		$this->uploadPath=ROOT_PATH."/public/upload/images/";
	}
	public function uploadFile(){
		if($this->checkError()&&$this->checkSize()&&$this->checkExt()&&$this->checkMime()&&$this->checkTrueImage()){
			$path=$this->mkdirPath();
			if($path!==false){
				$destination=$path.time().'.'.$this->ext;
				if(move_uploaded_file($this->fileInfo['tmp_name'], $destination)){
					return str_replace(ROOT_PATH,'',$destination);
				}else{
					$this->error="文件上传失败";
					return false;
				}
			}
			return false;
		}
		return false;
	}
	/**
	 * 检查是不是真实的图片 
	 */
	private function checkTrueImage(){
		if(!getimagesize($this->fileInfo['tmp_name'])){
			$this->error="不是真实的图片";
			return false;
		}
		return true;
	}
	/**
	 * 检查文件类型
	 * @return boolean
	 */
	private function checkMime(){
		if(!in_array($this->fileInfo['type'], $this->allowType)){
			$this->error("不允许的文件类型");
			return false;
		}
		return true;
	}
	/**
	 * 检查文件后辍
	 * @return boolean
	 */
	private function checkExt(){
		$this->ext=strtolower(pathinfo($this->fileInfo['name'],PATHINFO_EXTENSION));
		if(!in_array($this->ext, $this->allowExt)){
			$this->error="不允许上传的文件后辍";
			return false;
		}
		return true;
	}
	/**
	 * 检查文件大小
	 * @return boolean
	 */
	private function checkSize(){
		if($this->fileInfo['size']>$this->maxSize){
			$this->error="文件上传太大";
			return false;
		}
		return true;
	}
	/**
	 * 检查 错误 号
	 */
	private function checkError(){
		if($this->fileInfo['error']>0){
			switch($this->fileInfo['error']){
				case 1:
					$this->error="文件大小超过服务器限制 大小";
					break;
				case 2:
					$this->error="文件大小超过浏览器限制";
					break;
				case 3:
					$this->error="文件被部分上传";
					break;
				case 4:
					$this->error="没有找到上传的文件";
					break;
				case 5:
					$this->error="服务器临时文件夹丢失";
					break;
				case 6:
					$this->error="文件写到入临时文件夹出错";
					break;
				case 7:
					$this->error="文件被中断上传";
					break;
			}
			return false;
		}
		return true;
	}
	/**
	 * 创建目录 
	 */
	private function mkdirPath(){
		$path=$this->uploadPath.date('Y',time()).'/'.date('m',time()).'/';
		if(!file_exists($path)){
			$res=mkdir($path,0777,true);
			if($res===false){
				$this->error="创建目录失败";
				return false;
			}
		}
		return $path;
	}
}