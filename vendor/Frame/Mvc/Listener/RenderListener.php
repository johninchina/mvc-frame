<?php
namespace Frame\Mvc\Listener;

use Frame\Event\ListenerInterface;
use Frame\Event\EventManager;
use Frame\Event\Event;
use Frame\Mvc\MvcEvent;

class RenderListener implements ListenerInterface
{
	public function onRender(Event $event)
	{
		$serviceManager = $event->getApplication()->getServiceManager();
		$view = $serviceManager->getService('view');
		$viewModel = $event->getViewModel();
		$view->assign($viewModel->getVariables());
		return $view->fetch($viewModel->getTemplate());
	}
	
	public function attach(EventManager $eventManager)
	{
		$eventManager->attach(MvcEvent::RENDER, array($this, 'onRender'));
	}
}