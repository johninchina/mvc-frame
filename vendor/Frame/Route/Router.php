<?php
namespace Frame\Route;

class Router
{
	protected $route;
	
	protected $default;
	
	public function __construct(RouteInterface $route = null, $default = array())
	{
		if ($route) {
			$this->setRoute($route);
		}
		if ($default) {
			$this->setDefault($default);
		}
	}
	
	public function setRoute(RouteInterface $route)
	{
		$this->route = $route;
	}
	
	public function setDefault(array $default)
	{
		$this->default = $default;
	}
	
	public function match($pathinfo)
	{
		if ($match = $this->route->match($pathinfo)) {
			return array_merge($this->default, $match);
		}
		return $this->default;
	}
}