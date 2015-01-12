<?php
/**
 * 后台菜单 控制器
 * @author chenlin
 *
 */
namespace Apps\Backend\Controllers;
use Apps\Backend\Models\Menu;
class MenuController extends ControllerBase{
	public function indexAction(){
		$menu=new Menu();
		$parent=$menu->find('level=0');
		$child=$menu->find('level=1');
		$arr=array();
		foreach($parent as $item){
			$arr[]=$item;
			foreach($child as $value){
				if($item->id==$value->parent_id){
					$arr[]=$value;
				}
			}
		}
		$this->view->setVar('menu',$arr);
	}
	public function addAction(){
		$request=$this->request;
		if($request->isPost()){
			$menu=new Menu();
			$menu->title=$request->getPost('title','string');
			$menu->url=$request->getPost('url','string');
			$menu->parent_id=$request->getPost('parent_id','int');
			$menu->sort=$request->getPost("sort",'int');
			$menu->is_main=$request->getPost("is_main",'int');
			//暂时只支持两层
			if($menu->parent_id>0){
				$menu->level=1;
			}else{
				$menu->level=0;
			}
			if(!$menu->create()){
				$this->flashSession->error("添加失败");
			}
			return $this->redirect('menu/index');
		}
		$menu=new Menu();
		$menus=$menu->find("parent_id=0");
		$this->view->setVar('menus',$menus);
	}
	public function delAction($id=0){
		$menu=Menu::findById($id);
		if(!$menu->delete()){
			$this->flashSession->error("删除失败");
		}
		return $this->redirect("menu/index");
		
	}
	public function editAction($id=0){
		$request=$this->request;
		if($request->isPost()){
			$menu=Menu::findFirstById(intval($id));
			$menu->title=$request->getPost('title','string');
			$menu->url=$request->getPost('url','string');
			$menu->parent_id=$request->getPost('parent_id','int');
			$menu->sort=$request->getPost("sort",'int');
			$menu->is_main=$request->getPost("is_main",'int');
			if(!$menu->save()){
				$this->flashSession->error("修改失败");
			}
			return $this->redirect("menu/index");	
		}
		$menu=new Menu();
		$info=Menu::findFirstById($id);
		$menus=$menu->find();
		$this->view->setVar("menus",$menus);
		$this->view->setVar("menu", $info);
	}
}