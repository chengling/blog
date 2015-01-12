<?php
namespace  Apps\Frontend;
use Phalcon\Loader,
Phalcon\Mvc\Dispatcher,
Phalcon\Mvc\View,
Phalcon\Mvc\ModuleDefinitionInterface;
class Module implements  ModuleDefinitionInterface{
	public function registerAutoloaders(){
		$loader=new Loader();
		$loader->registerNamespaces(
				array(
						'Apps\Frontend\Controllers'=>'../apps/frontend/controllers/',
						'Apps\Frontend\Models'=>'../apps/frontend/models/'
				)
		);
		$loader->register();
	}
	public function registerServices($di){
		$di->set('dispatcher',function(){
			$dispatcher=new Dispatcher();
			$dispatcher->setDefaultNamespace("Apps\\Frontend\\Controllers");
			return $dispatcher;
		});
		$di->set('view',function(){
			$view=new View();
			$view->setViewsDir("../apps/frontend/views/");
			return $view;
		});
	}

}