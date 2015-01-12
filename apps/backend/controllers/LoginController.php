<?php
/**
 * 后台登录控制 器
 * @author chenlin
 *
 */
namespace  Apps\Backend\Controllers;
use Apps\Common\Lib\Image,
	Phalcon\Mvc\Controller,
	Apps\Backend\Models\Admin;
class LoginController extends Controller{
	public function indexAction(){
	}
	/**
	 * 登录验证
	 */
	public function loginAction(){
		if($this->request->isAjax()){
			$request=$this->request;
			$code=$request->getPost('code');
			$username=$request->getPost("username",array('string'));
			$password=md5($request->getPost('password'));
			if(strtolower($code)!=strtolower($this->session->get('code'))){
				echo json_encode(array('status'=>0,'msg'=>'验证码错误','type'=>'verify'));exit;
			}
			$admin=Admin::findFirst(array(
				"username  = :username: and passwd = :passwd:",
				"bind"=>array('username'=>$username,'passwd'=>$password)
			));
			if($admin==false){
				echo json_encode(array("status"=>0,'msg'=>'用户名密码错误','type'=>'username'));exit;
			}else{
				$this->session->set('auth',array(
						'id'=>$admin->id,
						'username'=>$admin->username
					)
				);
				echo json_encode(array("status"=>1,'location'=>'/admin/index/index'));
			}
		}
	}
	/**
	 * 用户退出
	 */
	public function logoutAction(){
		$this->session->remove('auth');
		return $this->dispatcher->forward(
			array(
				'module'=>'admin',
				'controller'=>'login',
				'action'=>'index'
			)
		);
	}
	
	/**
	 * 产生验证码,不能有视图
	 */
	public function codeAction(){
		$image=new Image();
		$image->createImage();
		exit;
	}
}