<?php
namespace Frame\Mvc\Controller;

use Frame\Mvc\Application;
use Frame\Util\Json;

abstract class AbstractController
{
	protected $application;
	
	protected $curl;
	
	protected $baseUrl;
	
	public function __construct(Application $application)
	{
		$this->application = $application;
		$this->curl = $application->getServiceManager()->getService('curl');
		$this->baseUrl = $application->getServiceManager()->getService('request')->getBaseUrl();
	}
	
	public function get($url)
	{
		return $this->curl->exec($url, 'get');
	}
	
	public function post($url, $data)
	{
		return $this->curl->exec($url, 'post', $data);
	}
	
	public function put($url, $data)
	{
		return $this->curl->exec($url, 'put', $data);
	}
	
	public function delete($url)
	{
		return $this->curl->exec($url, 'delete');
	}
	
	public function returnJson($data = array())
	{
		header("Content-type: application/json");
		exit(new Json($data));
	}
	
	public function redirect($url, $time = 0, $message = '')
	{
		$url = $this->baseUrl . '/' . ltrim($url, '/');
		if (0 === $time) {
			header("Location: $url");
		} else {
			header("refresh: {$time};url={$url}");
		}
		exit($message);
	}
}