<?php
use Phalcon\Mvc\Router,
	Phalcon\Mvc\Application,
	Phalcon\Config\Adapter\Ini as ConfigIni,
	Phalcon\Events\Manager as EventsManager,
	Phalcon\DI\FactoryDefault;
define('ROOT_PATH', dirname(dirname(__FILE__)));
$config=new ConfigIni(ROOT_PATH.'/apps/common/config/config.ini');
$loader=new \Phalcon\Loader();
$loader->registerNamespaces(
	array(
		'Apps\Common\Lib'=>ROOT_PATH.'/apps/common/lib/',
		'Apps\Common\Model'=>ROOT_PATH.'/apps/common/model/'
	))->register();

$di=new FactoryDefault();
$di->set('router',function(){
	$router=new Router();
	$router->setDefaultModule("frontend");
	$router->add("/admin", array(
			'module'     => 'backend',
			'controller' => 'index'
	));
	$router->add('/admin/:controller/:action', array(
			'module'=>'backend',
			'controller' => 1,
			'action' => 2,
	));
	$router->add('/admin/:controller/:action/:params', array(
			'module'=>'backend',
			'controller' => 1,
			'action' => 2,
			'params' => 3,
	));
	
        $router->add('/', array(
                        'module' => 'frontend',
                        'controller' => 'index',
                        'action' => 'index'
          ));
	$router->add('/admin/:controller[/]?', array(
			'module' => 'backend',
			'controller' => 1,
			'action' => 'index',
	));
	$router->add('/admin[/]?', array(
			'module' => 'backend',
			'controller' => 'login',
			'action' => 'index',
	));
	
	return $router;
});
$di->set('url',function(){
	$url=new \Phalcon\Mvc\Url();
	$url->setBaseUri("/");
	return $url;
});
$di->set('session',function(){
	$session=new \Phalcon\Session\Adapter\Files();
	$session->start();
	return $session;
});
$di->set('config',function()use($config){
	return $config;
});
$di->set('db',function()use($config){
	$eventsManager=new EventsManager();
	$logger=new Phalcon\Logger\Adapter\File("debug.log");
	$eventsManager->attach('db', function($event,$connection)use($logger){
		if($event->getType()=='beforeQuery'){
			$logger->log($connection->getSQLStatement());
		}		
	});
	$mysql= new \Phalcon\Db\Adapter\Pdo\Mysql(
			array(
				'host'=>$config->database->host,
				'username'=>$config->database->username,
				'password'=>$config->database->password,
				'dbname'=>$config->database->dbname,
				'charset'=>'utf8',
			)
	);
	$mysql->setEventsManager($eventsManager);
	return $mysql;
});
try {
	
	$application=new Application($di);
	$application->registerModules(
		array(
			'frontend'=>array(
				'className'=>'Apps\Frontend\Module',
				'path'=>ROOT_PATH.'/apps/frontend/Module.php'
			),
			'backend'=>array(
				'className'=>'Apps\Backend\Module',
				'path'=>ROOT_PATH.'/apps/backend/Module.php'
			)
		)
	);
	echo $application->handle()->getContent();
} catch (Exception $e){
	echo $e->getMessage();
}
