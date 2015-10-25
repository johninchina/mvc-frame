<?php
namespace Frame\Mvc\Service;

use Frame\Service\ServiceFactoryInterface;
use Frame\Service\ServiceManager;
use Frame\Route\RouteInterface;
use Frame\Route\Router;

class RouterFactory implements ServiceFactoryInterface
{
	protected $routeClass = 'Frame\Route\Literal';
	
	protected $default = array(
		'controller'	=> 'Index',
		'action'		=> 'index'
	);
	
	public function createService(ServiceManager $serviceManager)
	{
		$config = $serviceManager->getServiceConfig('router');
		
		$routeClass = isset($config['class']) ? $config['class'] : $this->routeClass;
		if (!class_exists($routeClass)) {
			throw new \Exception(sprintf("Route class '%s' not found.", $routeClass));
		}
		$route = new $routeClass();
		if (!$route instanceof RouteInterface) {
			throw new \Exception(sprintf("Route class '%s' must implements '%s'.", $routeClass, 'Frame\Route\RouteInterface'));
		}
		
		$default = isset($config['default']) ? $config['default'] : $this->default;
		
		$router = new Router($route, $default);
		return $router;
	}
}