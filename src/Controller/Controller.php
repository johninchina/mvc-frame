<?php
namespace Controller;

use Frame\Mvc\Controller\AbstractController;
use Frame\Mvc\Application;

class Controller extends AbstractController
{
	final public function __construct(Application $application)
	{
		parent::__construct($application);
		$this->checkLogin();
		$this->init();
	}
	
	protected function checkLogin()
	{
		session_start();
		if (!isset($_SESSION['key'])) {
			$this->redirect('/public/login');
		}
	}
	
	public function init()
	{
		// something to do...
	}
}