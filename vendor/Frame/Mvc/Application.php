<?php
namespace Frame\Mvc;

use Frame\Service\ServiceManager;
use Frame\Mvc\Service\ServiceManagerConfig;
use Frame\View\ViewModel;
use Frame\Mvc\Exception\NotFound;

class Application
{
	protected $serviceManager;
	
	protected $eventManager;
	
	public function __construct($config)
	{
		$this->serviceManager	= new ServiceManager($config, new ServiceManagerConfig());
		$this->eventManager		= $this->serviceManager->getService('event_manager');
	}
	
	public function getServiceManager()
	{
		return $this->serviceManager;
	}
	
	public function getEventManager()
	{
		return $this->eventManager;
	}
	
	public function run()
	{
		$event = new MvcEvent($this);
		try {
			// 初始化请求
			$this->eventManager->trigger(MvcEvent::REQUEST, $event);
			// 分发请求
			$result = $this->eventManager->trigger(MvcEvent::DISPATCH, $event);
			if ($result instanceof ViewModel) {
				// 渲染视图
				$event->setViewModel($result);
				$response = $this->eventManager->trigger(MvcEvent::RENDER, $event);
				$event->setResponse(200, $response);
			} else {
				return;
			}
		} catch (NotFound $e) {
			$event->setResponse(404, $e->getMessage());
		} catch (\Exception $e) {
			$event->setResponse(500, $e->getMessage());
		}
		// 返回响应
		$this->eventManager->trigger(MvcEvent::RESPONSE, $event);
	}
}