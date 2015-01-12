<?php
namespace Apps\Backend\Models;
class Role extends  \Phalcon\Mvc\Model{
	public function getSource(){
		return 'ph_role';
	}
}