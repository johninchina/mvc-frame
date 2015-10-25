<?php
namespace Frame\Event;

class Event
{
	protected $params;
	
	protected $stopped = false;
	
	public function setParams($params)
	{
		$this->params = $params;
	}
	
	public function getParams()
	{
		return $this->params;
	}
	
	public function setParam($name, $value)
	{
		$this->params[$name] = $value;
	}
	
	public function getParam($name, $default = null)
	{
		return isset($this->params[$name]) ? $this->params[$name] : $default;
	}
	
	public function isStopped()
	{
		return $this->stopped;
	}
	
	public function stop($flag = true)
	{
		$this->stopped = false;
	}
}