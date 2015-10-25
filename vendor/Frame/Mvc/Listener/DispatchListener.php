<?php
namespace Frame\Mvc\Listener;

use Frame\Event\ListenerInterface;
use Frame\Event\EventManager;
use Frame\Event\Event;
use Frame\Mvc\MvcEvent;
use Frame\Mvc\Exception\NotFound;

class DispatchListener implements ListenerInterface
{
	public function onDispatch(Event $event)
	{
		$routeMatch = $event->getRouteMatch();
		$controllerName = $routeMatch['controller'];
		$actionName = $routeMatch['action'];
		
		$class = 'Controller\\' . $controllerName . 'Controller';
		$action = $actionName . 'Action';
		
		if (!class_exists($class) || !method_exists($class, $action)) {
			throw new NotFound(sprintf("Controller or action '%s::%s' not found.", $class, $action));
		}
		
		$reflectionClass = new \ReflectionClass($class);
		if (!$reflectionClass->isSubclassOf('Frame\Mvc\Controller\AbstractController')) {
			throw new \Exception(sprintf("Controller class '%s' must be instance of '%s'.", $class, 'Frame\Mvc\Controller\AbstractController'));
		}
		
		$controller = new $class($event->getApplication());
		$callback = array($controller, $action);
		if (!is_callable($callback)) {
			throw new \Exception(sprintf("Controller's action '%s::%s' must be public.", $class, $action));
		}
		return call_user_func($callback);
	}
	
	public function attach(EventManager $eventManager)
	{
		$eventManager->attach(MvcEvent::DISPATCH, array($this, 'onDispatch'));
	}
}