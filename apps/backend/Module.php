<?php 
namespace  Apps\Backend;
use Phalcon\Loader,
	Phalcon\Mvc\Dispatcher,
	Phalcon\Mvc\View,
	Phalcon\Mvc\ModuleDefinitionInterface;
class Module implements  ModuleDefinitionInterface{
	public function registerAutoloaders(){
		$loader=new Loader();
		$loader->registerNamespaces(
			array(
				'Apps\Backend\Controllers'=>'../apps/backend/controllers/',
				'Apps\Backend\Models'=>'../apps/backend/models/'
			)
		);
		$loader->register();
	}
	public function registerServices($di){
		$di->set('dispatcher',function(){
			$dispatcher=new Dispatcher();
			$dispatcher->setDefaultNamespace("Apps\\Backend\\Controllers");
			return $dispatcher;
		});
		$di->set('view',function(){
			$view=new View();
			$view->setViewsDir("../apps/backend/views/");
			return $view;
		});
	}
	
}