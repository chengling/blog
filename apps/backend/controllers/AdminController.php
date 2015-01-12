<?php
/**
 * 管理员控制器
 * @author chenlin
 *
 */
namespace Apps\Backend\Controllers;
use Apps;
use Apps\Backend\Models\Admin,
	Apps\Backend\Models\RoleAdmin,
	Apps\Backend\Models\Role;
class AdminController extends ControllerBase{
	public function indexAction(){
		$totalRecord=Admin::count();
		$this->getPage($totalRecord);
		$admins=Admin::find(array("limit"=>array('number'=>$this->pageSize,'offset'=>$this->offset)));
		$this->view->setVar("admins", $admins);
	}
	public function addAction(){
		$request=$this->request;
		if($request->isPost()){
			$admin=new Admin();
			$admin->username=$request->getPost('username','string');
			$admin->passwd=md5($request->getPost('passwd'));
			if(!$admin->save()){
				foreach ($admin->getMessages() as $a){
					print_r($a);exit;
				}
				$this->flashSession->error("添加出错");
			}
			return $this->redirect("admin/index");
		}
	}
	public function delAction($id){
		$admin=Admin::findFirstById($id);
		if(!$admin){
			$this->flashSession->error("请求错误");
			return $this->redirect("admin/index");
		}
		$admin->delete();
		return $this->redirect("admin/index");
	}
	public function editAction($id){
		$admin=Admin::findFirstById($id);
		if(!$admin){
			$this->flashSession->error("请求错误");
			return $this->redirect("admin/index");
		}
		//查找 已有的角色
		$roleIds=RoleAdmin::query()->where("admin_id = :admin_id:")->bind(array('admin_id'=>$id))->execute()->toArray();
		$roleIds=array_column($roleIds,'role_id');
		$request=$this->request;
		if($request->isPost()){
			$ids=$request->getPost("ids");
			
			foreach($roleIds as $item){
				if(!in_array($item,$ids)){
					$roleAdminObj=RoleAdmin::query()->where("admin_id =:admin_id: and role_id =:role_id:")
					->bind(array('admin_id'=>$id,'role_id'=>$item))->execute();
					if(count($roleAdminObj)>0){
						$roleAdminObj->delete();
					}
				}
			}
			foreach($ids as $item){
				if(!in_array($item, $roleIds)){
					$roleAdmin=new RoleAdmin();
					$roleAdmin->role_id=$item;
					$roleAdmin->admin_id=$id;
					if(!$roleAdmin->save()){
						$this->flashSession->error("操作失败");
						return $this->redirect("admin/index");
					}
				}
			}
			return $this->redirect("admin/index");
		}
		$roles=Role::find();
		$this->view->setVar('roles', $roles);
		$this->view->setVar('admin', $admin);
		$this->view->setVar("roleIds", $roleIds);
	}
}