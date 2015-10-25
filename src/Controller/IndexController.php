<?php
namespace Controller;

use Frame\View\ViewModel;

class IndexController extends Controller
{
	public function indexAction()
	{
		return new ViewModel('/Index/index.html');
	}
	
	public function configureAction()
	{
		return new ViewModel('/Index/configure.html');
	}
	
	public function dashboardAction()
	{
		return new ViewModel('/Index/dashboard.html');
	}
}