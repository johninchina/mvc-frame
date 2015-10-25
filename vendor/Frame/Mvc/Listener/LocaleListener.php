<?php
namespace Frame\Mvc\Listener;

use Frame\Event\ListenerInterface;
use Frame\Event\EventManager;
use Frame\Event\Event;
use Frame\Mvc\MvcEvent;

class LocaleListener implements ListenerInterface
{
	public function onRender(Event $event)
	{
		$locale = $event->getApplication()->getServiceManager()->getService('locale');
		$viewModel = $event->getViewModel();
		$variables = $viewModel->getVariables();
		$variables = array_merge($variables, array('lang' => $locale->getLocale()));
		$viewModel->setVariables($variables);
		$event->setViewModel($viewModel);
	}
	
	public function attach(EventManager $eventManager)
	{
		$eventManager->attach(MvcEvent::RENDER, array($this, 'onRender'), -1);
	}
}