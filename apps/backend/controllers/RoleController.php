<?php
namespace Apps\Backend\Controllers;
use Apps\Backend\Models\Menu,
	Apps\Backend\Models\Role,
	Apps\Backend\Models\RoleAdmin,
	Apps\Backend\Models\RoleMenu;
class RoleController extends ControllerBase{
	public function indexAction(){
		$roles=Role::find();
		$this->view->setVar('roles', $roles);
	}
	public function addAction(){
		$request=$this->request;
		if($request->isPost()){
			$role=new Role();
			$role->name=$request->getPost('name','string');
			$role->des=$request->getPost('des','string');
			$role->sort=$request->getPost("sort",'int');
			$role->is_main=$request->getPost("is_main",'int');
			if(!$role->save()){
				$this->flashSession->error("添加失败");
			}
			return $this->redirect("role/index");
		}
	}
	public function editAction($id=0){
		$request=$this->request;
		$role=Role::findFirstById($id);
		if(empty($role)){
			$this->flashSession->error("参数请求错误");
			return $this->redirect('role/index');
		}
		//查找 已经拥有的权限
		$prepareQuery=RoleMenu::query()->where("role_id=:role_id:")
		->bind(array('role_id'=>$id));
		$menuIds=$prepareQuery->columns("menu_id")->execute()->toArray();
		$menuIds=array_column($menuIds,'menu_id');
		if($request->isPost()){
			$role->name=$request->getPost('name','string');
			$role->des=$request->getPost('des','string');
			if(!$role->save()){
				$this->flashSession->error("修改失败");
			}
	
			$ids=$request->getPost('ids');
			foreach($menuIds as $item){
				if(!in_array($item, $ids)){
					$roleMenuObj=RoleMenu::find(array("role_id=:role_id: and menu_id=:menu_id:",
							"bind"=>array('role_id'=>$id,'menu_id'=>$item)));
					if(count($roleMenuObj)>0){
						$roleMenuObj->delete();
					}
				}
			}
			foreach($ids as $item){
				if(!in_array($item, $menuIds)){
					$roleMenu=new RoleMenu();
					$roleMenu->role_id=$id;
					$roleMenu->menu_id=$item;
					if(!$roleMenu->save()){
						$this->flashSession->error("修改失败");
						return $this->redirect("role/index");
					}
				}
			}
			return $this->redirect('role/index');
		}
		$parent=Menu::find(array('level=0'));
		$children=Menu::find(array('level>0'));
		$this->view->setVar("role", $role);
		$this->view->setVar("parent", $parent);
		$this->view->setVar("children", $children);
		$this->view->setVar("menuIds", $menuIds);
	}
	public function delAction($id){
		$admin=RoleAdmin::query()->where("role_id=:role_id:")
		->bind(array('role_id'=>$id))->execute()->toArray();
		if(count($admin)>0){
			$this->flashSession->error("请及时解除此角色的管理人员");
			return $this->redirect("role/index");
		}
		$role=Role::findFirstById($id);
		if(!$role){
			$this->flashSession->error("参数错误");
			return $this->redirect("role/index");
		}
		$role->delete();
		
	}
}