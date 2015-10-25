<?php
namespace Frame\Mvc;

use Frame\Event\Event;
use Frame\View\ViewModel;
use Frame\Http\Response;

class MvcEvent extends Event
{
	const REQUEST	= 'request';
	const DISPATCH	= 'dispatch';
	const RENDER	= 'render';
	const RESPONSE	= 'response';
	
	public function __construct(Application $application)
	{
		$this->setApplication($application);
	}
	
	public function setApplication(Application $application)
	{
		$this->setParam('_application', $application);
	}
	
	public function getApplication()
	{
		return $this->getParam('_application');
	}
	
	public function setDebug($debug)
	{
		$this->setParam('_debug', $debug);
	}
	
	public function getDebug()
	{
		return $this->getParam('_debug', false);
	}
	
	public function setRouteMatch($routeMatch)
	{
		$this->setParam('_route_match', $routeMatch);
	}
	
	public function getRouteMatch()
	{
		return $this->getParam('_route_match', array());
	}
	
	public function setViewModel(ViewModel $viewModel)
	{
		$this->setParam('_view_model', $viewModel);
	}
	
	public function getViewModel()
	{
		return $this->getParam('_view_model');
	}

	public function setResponse($code, $content)
	{
		$this->setParam('_response', new Response($code, $content));
	}
	
	public function getResponse()
	{
		return $this->getParam('_response', new Response());
	}
}