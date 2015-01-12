<?php
namespace Apps\Common\Models;
class Comment extends  \Phalcon\Mvc\Model{
	public function getSource(){
		return 'ph_comment';
	}
}