<?php
namespace Apps\Common\Models;
class Article extends  \Phalcon\Mvc\Model{
	public function getSource(){
		return 'ph_article';
	}
	public function initialize(){
		$this->skipAttributes(array('intro'));
	}
	public function beforeValidationOnCreate(){
		$this->istop='0';
		$this->isdel='0';
	}
}