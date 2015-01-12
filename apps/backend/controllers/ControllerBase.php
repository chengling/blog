<?php
namespace Apps\Backend\Controllers;
use Phalcon\Mvc\Controller,
	Apps\Backend\Models\RoleAdmin,
	Apps\Backend\Models\Menu,
	Apps\Common\Lib\Page;
class ControllerBase extends Controller{
	protected $pageSize=10;
	protected $offset;
	protected function initialize(){
		if(!$this->session->get('auth')){
			$this->redirect("login/index");
		}
		
		//权限控制
		$actionName=$this->dispatcher->getActionName();
		$controllerName=$this->dispatcher->getControllerName();
		$currentUrl='admin/'.$controllerName.'/'.$actionName;
		$menus=$this->getAllNodes();
		$menus=$this->array_unique($menus);
		$this->splitMenus($menus);
		if($this->session->get('auth')['id']!=1){
			$nodes=array_column($menus,'url');
			if(!in_array($currentUrl, $nodes)){
				return $this->redirect("login/index");
			}
		}
		$this->view->setVar("menus",$menus);
	}
	protected function getPage($totalRecord){
		$currentPage=$this->request->get('page','int');
		$currentPage=$currentPage?$currentPage:1;
		$this->offset=($currentPage-1)*$this->pageSize;
		$page=new Page($currentPage,ceil($totalRecord/$this->pageSize));
		 $this->view->setVar("page", $page->page);
	}
	protected function redirect($url){
		$urlParts=explode('/',$url);
		$params=array_slice($urlParts,2);
		return $this->dispatcher->forward(
			array(
				'module'=>'admin',
				'controller'=>$urlParts[0],
				'action'=>$urlParts[1],
				'params'=>$params
			)
		);
	}
	protected  function getAllNodes(){
		$admin_id=$this->session->get('auth')['id'];
		$roles=RoleAdmin::query()->where("admin_id=:admin_id:")
		->bind(array('admin_id'=>$admin_id))->execute()->toArray();
		if($admin_id==1){
			return Menu::find()->toArray();
		}else{
			$arr=array();
			foreach($roles as $role){
				$res=$this->preparQueries()
				->where("a.role_id=".$role['role_id'])->getQuery()->execute()->toArray();
				if(count($res)>0){
					foreach($res as $item){
						$arr[]=$item;
					}
				}
			}
			return $arr;
		}
		
	}
	protected function preparQueries(){
		return $this->modelsManager->createBuilder()
			->from(array('a'=>'Apps\Backend\Models\RoleMenu'))
			->leftJoin('Apps\Backend\Models\Menu','b.id=a.menu_id','b')
			->columns(array('url'=>'b.url','level'=>'b.level','parent_id'=>'b.parent_id','title'=>'b.title','id'=>'b.id','is_main'=>'b.is_main'))
		->orderBy("b.sort desc");
			
	}
	protected function splitMenus($menus){
		$parentMenus=array();
		$childMenus=array();
		foreach($menus as $item){
			if($item['is_main']!=1){
				continue;
			}
			if($item['level']==0){
				$parentMenus[]=$item;
			}else{
				$childMenus[]=$item;
			}
		}
		$this->view->setVar('parentMenus',$parentMenus);
		$this->view->setVar('childMenus',$childMenus);
	}
	protected function array_unique($menus){
		$arr=array();
		$res=array();
		foreach($menus as $menu){
			if(!in_array($menu['id'],$arr)){
				$arr[]=$menu['id'];
				$res[]=$menu;			
			}
		}
		return $res;
	}
}