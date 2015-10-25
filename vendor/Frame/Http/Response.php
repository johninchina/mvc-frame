<?php
namespace Frame\Http;

class Response
{
	protected $headers = array();
	
	protected $code = 200;
	
	protected $body = '';
	
	public function __construct($code = 200, $body = '', $headers = array())
	{
		$this->setCode($code);
		$this->setBody($body);
		$this->setHeaders($headers);
	}
	
	public function setHeaders(array $headers = array())
	{
		$this->headers = $headers;
	}
	
	public function getHeaders()
	{
		return $this->headers;
	}
	
	public function setCode($code)
	{
		$this->code = $code;
	}
	
	public function getCode()
	{
		return $this->code;
	}
	
	public function setBody($body)
	{
		$this->body = $body;
	}
	
	public function getBody()
	{
		return $this->body;
	}
	
	public function send()
	{
		$this->sendHeaders();
		$this->sendBody();
		
		if (function_exists('fastcgi_finish_request')) {
			fastcgi_finish_request();
		} elseif ('cli' !== PHP_SAPI) {
			static::closeOutputBuffers(0, true);
		}
		
		return $this;
	}
	
	public function sendHeaders()
	{
		if (headers_sent()) {
			return;
		}
		header(sprintf('HTTP/1.0 %s', $this->code));
		foreach ($this->headers as $key=>$value) {
			header(sprintf('%s: s%', $key, $value));
		}
	}
	
	public function sendBody()
	{
		echo $this->body;
	}
	
	public static function closeOutputBuffers($targetLevel, $flush)
	{
		$status = ob_get_status(true);
		$level = count($status);
		$flags = defined('PHP_OUTPUT_HANDLER_REMOVABLE') ? PHP_OUTPUT_HANDLER_REMOVABLE | ($flush ? PHP_OUTPUT_HANDLER_FLUSHABLE : PHP_OUTPUT_HANDLER_CLEANABLE) : -1;
	
		while ($level-- > $targetLevel && ($s = $status[$level]) && (!isset($s['del']) ? !isset($s['flags']) || $flags === ($s['flags'] & $flags) : $s['del'])) {
			if ($flush) {
				ob_end_flush();
			} else {
				ob_end_clean();
			}
		}
	}
}