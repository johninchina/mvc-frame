<?php
namespace Frame\Mvc\Service;

use Frame\Service\ServiceManagerConfigInterface;
use Frame\Service\ServiceManager;

class ServiceManagerConfig implements ServiceManagerConfigInterface
{
	protected $defaultServiceConfig = array(
		'event_manager'		=> 'Frame\Mvc\Service\EventManagerFactory',
		'request'			=> 'Frame\Mvc\Service\RequestFactory',
		'response'			=> 'Frame\Mvc\Service\ResponseFactory',
		'router'			=> 'Frame\Mvc\Service\RouterFactory',
		'locale'			=> 'Frame\Mvc\Service\LocaleFactory',
		'view'				=> 'Frame\Mvc\Service\ViewFactory',
		'curl'				=> 'Frame\Mvc\Service\CurlFactory'
	);
	
	public function configureServiceManager(ServiceManager $serviceManager)
	{
		$serviceConfig = $serviceManager->getServiceConfig('services', array());
		$serviceConfig = array_merge($this->defaultServiceConfig, $serviceConfig);
		foreach ($serviceConfig as $serviceName=>$serviceFactoryName) {
			$serviceManager->registerService($serviceName, $serviceFactoryName);
		}
	}
}