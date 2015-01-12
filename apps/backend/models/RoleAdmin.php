<?php
namespace Apps\Backend\Models;
class RoleAdmin extends  \Phalcon\Mvc\Model{
	public function getSource(){
		return 'ph_role_admin';
	}
}