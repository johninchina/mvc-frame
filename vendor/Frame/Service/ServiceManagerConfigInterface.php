<?php
namespace Frame\Service;

interface ServiceManagerConfigInterface
{
	public function configureServiceManager(ServiceManager $serviceManager);
}