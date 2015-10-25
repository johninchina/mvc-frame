<?php
namespace Frame\Service;

interface ServiceFactoryInterface
{
	public function createService(ServiceManager $serviceManager);
}