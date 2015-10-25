<?php
namespace Frame\Mvc\Listener;

use Frame\Event\ListenerInterface;
use Frame\Event\EventManager;
use Frame\Event\Event;
use Frame\Mvc\MvcEvent;

class DebugListener implements ListenerInterface
{
	public function onRequest(Event $event)
	{
		$debug = $event->getApplication()->getServiceManager()->getServiceConfig('debug', false);
		error_reporting($debug ? 7 : 0);
		ini_set('display_errors', $debug ? 'On' : 'Off');
		$event->setDebug($debug);
	}
	
	public function attach(EventManager $eventManager)
	{
		$eventManager->attach(MvcEvent::REQUEST, array($this, 'onRequest'), -1);
	}
}