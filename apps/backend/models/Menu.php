<?php
namespace Apps\Backend\Models;
class Menu extends  \Phalcon\Mvc\Model{
	public function getSource(){
		return 'ph_menu';
	}
}