<?php
namespace Frame\Mvc;

class Autoloader
{
	protected $dirs = array();
	
	public function __construct($dirs = array())
	{
		$this->dirs = $dirs;
	}
	
	public function register()
	{
		spl_autoload_register(array($this, 'loadClass'));
	}
	
	public function loadClass($className)
	{
		foreach ($this->dirs as $dir) {
			$dir = rtrim($dir, '/');
			$fileName = str_replace('\\', '/', $className);
			$classFile = $dir . '/' . $fileName . '.php';
			if (file_exists($classFile)) {
				require $classFile;
				return class_exists($className) || interface_exists($className);
			}
		}
		return false;
	}
}