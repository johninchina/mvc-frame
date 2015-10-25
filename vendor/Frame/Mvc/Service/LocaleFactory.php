<?php
namespace Frame\Mvc\Service;

use Frame\Service\ServiceFactoryInterface;
use Frame\Service\ServiceManager;
use Frame\Locale\Locale;

class LocaleFactory implements ServiceFactoryInterface
{
	protected $path = './app/locale/';
	
	protected $lang = 'zh-cn';
	
	public function createService(ServiceManager $serviceManager)
	{
		$localeConfig = $serviceManager->getServiceConfig('locale', array());
		$path = isset($localeConfig['path']) ? $localeConfig['path'] : $this->path;
		$lang = isset($_COOKIE['lang']) ? $_COOKIE['lang'] : (isset($localeConfig['lang']) ? $localeConfig['lang'] : $this->lang);
		$locale = new Locale();
		$locale->setPath($path);
		$locale->setLang($lang);
		return $locale;
	}
}