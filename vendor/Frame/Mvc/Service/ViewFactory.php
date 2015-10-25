<?php
namespace Frame\Mvc\Service;

use Frame\Service\ServiceFactoryInterface;
use Frame\Service\ServiceManager;
use Frame\View\View;

class ViewFactory implements ServiceFactoryInterface
{
	protected $templateDir = './app/view/';
	
	protected $compileDir = './app/com/';
	
	public function createService(ServiceManager $serviceManager)
	{
		$viewConfig = $serviceManager->getServiceConfig('view', array());
		$templateDir = isset($viewConfig['template_dir']) ? $viewConfig['template_dir'] : $this->templateDir;
		$compileDir = isset($viewConfig['compile_dir']) ? $viewConfig['compile_dir'] : $this->compileDir;
		return new View($templateDir, $compileDir);
	}
}