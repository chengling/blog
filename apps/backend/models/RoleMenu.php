<?php
namespace Apps\Backend\Models;
class RoleMenu extends  \Phalcon\Mvc\Model{
	public function getSource(){
		return 'ph_role_menu';
	}
}