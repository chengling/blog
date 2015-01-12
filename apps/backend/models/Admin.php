<?php
namespace Apps\Backend\Models;
class Admin extends  \Phalcon\Mvc\Model{
	public function getSource(){
		return 'ph_admin';
	}
}