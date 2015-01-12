<?php
namespace Apps\Backend\Controllers;
use Apps\Common\Models\Category;
class CategoryController extends ControllerBase{
	/**
	 * 添加栏目 
	 */
	public function addAction(){
		$request=$this->request;
		if($request->isPost()){
			$category=new Category();
			$category->cname=$request->getPost('cname','string');
			$category->keywords=$request->getPost('keywords','string');
			$category->description=$request->getPost('description','string');
			$category->isoff=$request->getPost('isoff','int');
			$res=$category->save();
			if($res){
				$this->flashSession->success("ok");
				return $this->redirect("category/index");
			}else{
				$this->flashSession->error("fail");
				return $this->redirect("category/add");
			}
		}
	}
	/**
	 * 栏目 列表
	 */
	public function indexAction(){
		$category=Category::find();
		$this->view->setVar('category', $category);
	}
	/**
	 * 删除栏目 
	 */
	public function delAction($id=0){
		$id=$this->request->get('cid','int');
		$category=Category::findFirst(array('id'=>$id));
		if(!$category){
			$this->flashSession->error("请求参数错误");
			return $this->redirect("categoyr/index");
		}
		if(!$category->delete()){
			$this->flashSession->error("删除失败");
		}
		return $this->redirect("category/index");
	}
	/**
	 * 修改栏目 
	 */
	public function editAction(){
		$id=$this->request->get('id','int');
		if($id){
			$category=Category::findFirstByCid($id);
			if(!$category){
				$this->flashSession->error("请求参数错误");
				return $this->redirect("categoyr/index");
			}
			$this->view->setVar('category', $category);
			$this->view->setMainView("category/edit");
		}
		if($this->request->isPost()){
			$request=$this->request;
			$id=$request->getPost('cid','int');
			$category=Category::findFirst("cid=".$id);
			$category->cname=$request->getPost('cname','string');
			$category->keywords=$request->getPost('keywords','string');
			$category->description=$request->getPost('description','string');
			$category->isoff=$request->getPost('isoff','int');
			if(!$category->save()){
				$this->flashSession->error("修改失败");
			}
			return $this->redirect("category/index");	
		}
	}
	
}