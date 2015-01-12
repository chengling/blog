<?php
/**
 * 文章管理操作 
 * @author chenlin
 *
 */
namespace Apps\Backend\Controllers;
use Apps\Common\Models\Article,
	Apps\Common\Lib\Upload,
	Apps\Backend\Models\Category;
class ArticleController extends ControllerBase{
	/**
	 * 文章列表  
	 */
	public function indexAction($isdel=0){
		$queryBuilder=$this->modelsManager->createBuilder()
			->from(array('a'=>'Apps\Backend\Models\Article'))
			->leftJoin('Apps\Backend\Models\Category','a.cid=b.cid','b');
		if($isdel){
			$queryBuilder->where('a.isdel=1');
		}else{
			$queryBuilder->where('a.isdel=0');
		}
		$totalBuilder=clone $queryBuilder;
		$totalBuilder->columns("count(*) as count");//下面的属性与这里对应 
		$queryBuilder->columns(array(
					'aid'=>'a.aid',
					'title'=>'a.title',
					'cname'=>'b.cname',
					'click'=>'a.click',
					'time'=>'a.time'
		));
		$totalRecord=$totalBuilder->getQuery()->setUniqueRow(true)->execute()->count;//count属性 
		$this->getPage($totalRecord);
		$articles=$queryBuilder->limit($this->pageSize,$this->offset)->getQuery()->execute();
		$this->view->setVar('articles',$articles);
		if($isdel){
			$this->view->pick("article/recycle");
		}
	}
	/**
	 * 添加 文章 
	 */
	public function addAction(){
		$request=$this->request;
		if($request->getPost()){
			$upload=new Upload("thumb");
			$thumb=$upload->uploadFile();
			if($thumb===false){
				$this->flashSession->error($upload->error);
				return $this->redirect("article/index");
			}
			$article=new Article();
			$article->title=$request->getPost('title','string');
			$article->content=$request->getPost("content","string");
			$article->thumb=$thumb;
			$article->intro=$request->getPost("intro","string");
			$article->click=$request->getPost("click","int");
			$article->time=time();
			$article->cid=$request->getPost("cid","int");
			if(!$article->save()){
				foreach($article->getMessages() as $a){
					print_r($a);exit;
				}
				$this->flashSession->success("添加失败");
			}
			return $this->redirect("article/index");
		}else{
			$category=Category::find();
			$this->view->setVar("category", $category);
		}
		
	}
	/**
	 * 删除文章改变文章的状态  
	 */
	public function delAction(){
		$id=$this->request->get('id','int');
		$article=Article::findFirstByAid($id);
		$article->isdel=1;
		if(!$article->save()){
			$this->flashSession->error("删除失败");
		}
		return $this->redirect("article/index");
	}
	/**
	 * 修改文章
	 */
	public function editAction(){
		$request=$this->request;
		if($request->isPost()){
			$id=$this->request->get('id','int');
			$article=Article::findFirst("aid=".$id);
			if(!$article){
				$this->flashSession->error("参数请求错误 ");
				return $this->redirect("article/index");
			}
			if(!empty($_FILES['tmp_name'])){
				//上传图片
				$upload=new Upload("thumb");
				$thumb=$upload->uploadFile();
				if($thumb===false){
					$this->flashSession->error($upload->error);
					return $this->redirect("article/index");
				}
				$article->thumb=$thumb;
			}
			$article->title=$request->getPost('title','string');
			$article->content=$request->getPost("content","string");
			
			$article->intro=$request->getPost("intro","string");
			$article->click=$request->getPost("click","int");
			$article->cid=$request->getPost("cid","int");
			if(!$article->save()){
				$this->flashSession->error("修改失败");
			}
			return $this->redirect("article/index");
			
		}else{
			$id=$request->get('id','int');
			if($id){
				$article=Article::findFirstByAid($id);
				if(!$article){
					$this->flashSession->error("你要修改的不存在");
					return $this->redirect("article/index");
				}
				$category=Category::find();
				$this->view->setVar("category", $category);
				$this->view->setVar("article", $article);
			}
		}
	}
	/**
	 * 置顶文章 
	 */
	public function topAction(){
		$id=$this->request->get('id','int');
		$article=Article::findFirst("aid=".$id);
		if($article){
			$article->istop=1;
			if(!$article->save()){
				$this->flashSession->error("置顶失败");
			}
			return $this->redirect("article/index");
		}
	}
	/**
	 * 恢复删除 
	 */
	public function recoverAction(){
		$id=$this->request->get('id','int');
		$article=Article::findFirst("aid=".$id);
		$article->isdel=0;
		if($article->save()){
			$this->flashSession->error("恢复失败");
		}
		return $this->redirect("article/index/1");
	}
	/**
	 * 彻底删除
	 */
	public function deleteAction(){
		$id=$this->request->get('id','int');
		$article=Article::findFirst("aid=".$id);
		if(!$article->delete()){
			$this->flashSession->error("删除失败");
		}
		$this->redirect("article/index/1");
	}
}