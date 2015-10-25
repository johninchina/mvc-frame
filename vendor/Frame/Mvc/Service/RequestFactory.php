<?php
namespace Frame\Mvc\Service;

use Frame\Service\ServiceFactoryInterface;
use Frame\Service\ServiceManager;
use Frame\Http\Request;

class RequestFactory implements ServiceFactoryInterface
{
	public function createService(ServiceManager $serviceManager)
	{
		return new Request();
	}
}