<?php
namespace Frame\Mvc\Service;

use Frame\Service\ServiceFactoryInterface;
use Frame\Service\ServiceManager;
use Frame\Event\EventManager;

class EventManagerFactory implements ServiceFactoryInterface
{
	protected $defaultListeners = array(
		'Frame\Mvc\Listener\DebugListener',
		'Frame\Mvc\Listener\RouteListener',
		'Frame\Mvc\Listener\DispatchListener',
		'Frame\Mvc\Listener\LocaleListener',
		'Frame\Mvc\Listener\RenderListener',
		'Frame\Mvc\Listener\ResponseListener'
	);
	
	public function createService(ServiceManager $serviceManager)
	{
		$listeners = $serviceManager->getServiceConfig('listeners', array());
		$listeners = array_merge($this->defaultListeners, $listeners);
		$eventManager = new EventManager();
		foreach ($listeners as $listener) {
			$eventManager->attach(new $listener());
		}
		return $eventManager;
	}
}