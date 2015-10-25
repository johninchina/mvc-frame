<?php
namespace Frame\Mvc\Listener;

use Frame\Event\ListenerInterface;
use Frame\Event\EventManager;
use Frame\Event\Event;
use Frame\Mvc\MvcEvent;

class ResponseListener implements ListenerInterface
{
	public function onResponse(Event $event)
	{
		$response = $event->getResponse();
		$code = $response->getCode();
		if (false === $event->getDebug()) {
			if ($code == 404) {
				$response->setBody('Page not found.');
			}
			if ($code == 500) {
				$response->setBody('Internal error.');
			}
		}
		$response->send();
	}
	
	public function attach(EventManager $eventManager)
	{
		$eventManager->attach(MvcEvent::RESPONSE, array($this, 'onResponse'));
	}
}