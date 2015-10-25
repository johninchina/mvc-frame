<?php
namespace Frame\Mvc\Listener;

use Frame\Event\ListenerInterface;
use Frame\Event\EventManager;
use Frame\Event\Event;
use Frame\Mvc\MvcEvent;

class RouteListener implements ListenerInterface
{
	public function onRoute(Event $event)
	{
		$serviceManager = $event->getApplication()->getServiceManager();
		$request = $serviceManager->getService('request');
		$router = $serviceManager->getService('router');
		$routeMatch = $router->match($request->getPathinfo());
		$event->setRouteMatch($routeMatch);
	}
	
	public function attach(EventManager $eventManager)
	{
		$eventManager->attach(MvcEvent::REQUEST, array($this, 'onRoute'));
	}
}