<?php
namespace Apps\Common\Models;
use Phalcon\Mvc\Model;
class Category extends Model{
	public function getSource(){
		return 'ph_category';
	}
}