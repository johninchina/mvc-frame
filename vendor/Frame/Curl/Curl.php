<?php
namespace Frame\Curl;

use Frame\Util\Json;
class Curl
{
	protected $baseUrl;
	
	public function __construct($baseUrl = '', $contentType = 'json')
	{
		if (!extension_loaded('curl')) {
			throw new \Exception("Php extension 'curl' not found.");
		}
		if (!extension_loaded('openssl')) {
			throw new \Exception("Php extension 'openssl' not found.");
		}
		$this->setBaseUrl($baseUrl);
	}
	
	public function setBaseUrl($baseUrl)
	{
		$this->baseUrl = rtrim($baseUrl, '/');
	}
	
	public function setContentType($contentType)
	{
		$this->contentType = $contentType;
	}
	
	public function init()
	{
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		
		return $ch;
	}
	
	public function exec($url, $method, $data = null)
	{
		$ch = $this->init();

		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-type: application/json',
			'key: ' . $_SESSION['key']
		));
		
		if ('' !== $this->baseUrl) {
			$url = $this->baseUrl . '/' . ltrim($url, '/');
		}
		curl_setopt($ch, CURLOPT_URL, $url);
		
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
		
		if (null !== $data) {
			curl_setopt($ch, CURLOPT_POSTFIELDS, (string) new Json($data));
		}
		
		$result = Json::toArray(curl_exec($ch));
		
		if(curl_errno($ch)){
			$result = curl_error($ch);
		}
		
		return $result;
	}
}