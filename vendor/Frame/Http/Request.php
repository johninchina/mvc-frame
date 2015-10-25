<?php
namespace Frame\Http;

class Request
{
	protected $requestUri;
	
	protected $baseUrl;
	
	protected $pathInfo;
	
	protected $queryString;
	
	public function setRequestUri($requestUri)
	{
		$this->requestUri = $requestUri;
	}
	
	public function getRequestUri()
	{
		if (null === $this->requestUri) {
			$this->prepareRequestUri();
		}
		return $this->requestUri;
	}
	
	public function setBaseUrl($baseUrl)
	{
		$this->baseUrl = $baseUrl;
	}
	
	public function getBaseUrl()
	{
		if (null === $this->baseUrl) {
			$this->prepareBaseUrl();
		}
		return $this->baseUrl;
	}
	
	public function setPathInfo($pathInfo)
	{
		$this->pathInfo = $pathInfo;
	}
	
	public function getPathInfo()
	{
		if (null === $this->pathInfo) {
			$this->preparePathInfo();
		}
		return $this->pathInfo;
	}
	
	public function setQueryString($queryString)
	{
		$this->queryString = $queryString;
	}
	
	public function getQueryString()
	{
		if (null === $this->queryString) {
			$this->prepareQueryString();
		}
		return $this->queryString;
	}
	
	protected function prepareRequestUri()
	{
		$requestUri = $_SERVER['REQUEST_URI'];
		if (null !== $requestUri) {
			$requestUri = preg_replace('#^[^/:]+://[^/]+#', '', $requestUri);
		}
		$this->setRequestUri($requestUri);
	}
	
	protected function prepareBaseUrl()
	{
		$filename = basename($_SERVER['SCRIPT_FILENAME']);
		
		if ($filename === basename($_SERVER['SCRIPT_NAME'])) {
			$baseUrl = $_SERVER['SCRIPT_NAME'];
		} elseif ($filename === basename($_SERVER['PHP_SELF'])) {
			$baseUrl = $_SERVER['PHP_SELF'];
		} elseif ($filename === basename($_SERVER['ORIG_SCRIPT_NAME'])) {
			$baseUrl = $_SERVER['ORIG_SCRIPT_NAME'];
		} else {
			$baseUrl  = '/';
			$basename = basename($filename);
			if ($basename) {
				$path     = ($_SERVER['PHP_SELF'] ? trim($_SERVER['PHP_SELF'], '/') : '');
				$baseUrl .= substr($path, 0, strpos($path, $basename)) . $basename;
			}
		}
		
		$requestUri = $this->getRequestUri();
		if (0 === strpos($requestUri, $baseUrl)) {
			$this->setBaseUrl($baseUrl);
            return;
        }
        
        $baseDir = str_replace('\\', '/', dirname($baseUrl));
        if (0 === strpos($requestUri, $baseDir)) {
        	$this->setBaseUrl($baseDir);
        	return;
        }
        
        $truncatedRequestUri = $requestUri;
        if (false !== ($pos = strpos($requestUri, '?'))) {
        	$truncatedRequestUri = substr($requestUri, 0, $pos);
        }
        $basename = basename($baseUrl);
        if (empty($basename) || false === strpos($truncatedRequestUri, $basename)) {
        	$this->setBaseUrl('');
        	return;
        }
        
        if (strlen($requestUri) >= strlen($baseUrl) && (false !== ($pos = strpos($requestUri, $baseUrl)) && $pos !== 0)) {
        	$baseUrl = substr($requestUri, 0, $pos + strlen($baseUrl));
        }
        $this->setBaseUrl($baseUrl);
	}
	
	protected function preparePathInfo()
	{
		$baseUrl = $this->getBaseUrl();
		if (null === ($requestUri = $this->getRequestUri())) {
			$this->setPathInfo('/');
			return;
		}
		if ($pos = strpos($requestUri, '?')) {
			$requestUri = substr($requestUri, 0, $pos);
		}
		$pathInfo = substr($requestUri, strlen($baseUrl));
		if (null !== $baseUrl && (false === $pathInfo || '' === $pathInfo)) {
			$pathInfo = '/';
		} elseif (null === $baseUrl) {
			$pathInfo = $requestUri;
		}
		$this->setPathInfo($pathInfo);
	}
	
	protected function prepareQueryString()
	{
		$queryString = $_SERVER['QUERY_STRING'];
		if ('' === $queryString) {
			$this->setQueryString('');
			return;
		}
		$parts = $order = array();
		foreach (explode('&', $queryString) as $param) {
			if ('' === $param || '' === $param[0]) {
				continue;
			}
			$keyValuePair = explode('=', $param, 2);
			$parts[] = isset($keyValuePair[1]) ?
				rawurlencode(urldecode($keyValuePair[0])).'='.rawurlencode(urldecode($keyValuePair[1])) :
				rawurlencode(urldecode($keyValuePair[0]));
			$order[] = urldecode($keyValuePair[0]);
		}
		array_multisort($order, SORT_ASC, $parts);
		$this->setQueryString(implode('&', $parts));
	}
}