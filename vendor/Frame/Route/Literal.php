<?php
namespace Frame\Route;

class Literal implements RouteInterface
{
	public function __construct()
	{
		if (function_exists('apache_get_modules')) {
			if (!in_array('mod_rewrite', apache_get_modules())) {
				throw new \Exception("Apache module 'rewrite' not found.");
			}
		}
	}
	
	public function match($pathinfo)
	{
		$match = array();
		
		if ($pathinfo == '/') {
			return $match;
		}
		
		$parts = explode('/', trim($pathinfo, '/'));
		
		if (isset($parts[0])) {
			$match['controller'] = ucfirst($parts[0]);
		}
		
		if (isset($parts[1])) {
			$match['action'] = $parts[1];
		}
		
		for ($i = 2; $i < count($parts); $i+=2) {
			if (isset($parts[$i])) {
				$_GET[$parts[$i]] = isset($parts[$i+1]) ? $parts[$i+1] : '';
			}
		}
		
		return $match;
	}
}