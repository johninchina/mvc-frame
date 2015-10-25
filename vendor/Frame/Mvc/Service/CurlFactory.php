<?php
namespace Frame\Mvc\Service;

use Frame\Service\ServiceFactoryInterface;
use Frame\Service\ServiceManager;
use Frame\Curl\Curl;

class CurlFactory implements ServiceFactoryInterface
{
	public function createService(ServiceManager $serviceManager)
	{
		$curlConfig = $serviceManager->getServiceConfig('curl');
		$baseUrl = isset($curlConfig['base_url']) ? $curlConfig['base_url'] : '';
		return new Curl($baseUrl);
	}
}