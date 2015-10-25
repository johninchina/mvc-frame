<?php
namespace Controller;

use Frame\Mvc\Controller\AbstractController;
use Frame\View\ViewModel;

class PublicController extends AbstractController
{
	public function loginAction()
	{
		// 如果已登录，跳转到首页
		session_start();
		if (isset($_SESSION['key'])) {
			$this->redirect('/index/index');
		}
		// 登陆页面
		if (empty($_POST)) {
			return new ViewModel('Public/login.html');
		}
		// 表单处理
		if (isset($_POST['lang'])) {
			setcookie('lang', $_POST['lang'], time()+60*60*24*30, '/');
		}
		if (isset($_POST['username']) && isset($_POST['password'])) {
			$data = array(
				'user'	=> array(
					'username'	=> $_POST['username'],
					'password'	=> $_POST['password']
				)
			);
			$result = $this->post('/keygen', $data);
			if ($result['result']['success']) {
				$_SESSION['key'] = $result['result']['key'];
				$this->redirect('/index/index');
			}
		}
		$this->redirect('/public/login');
	}
	
	public function loginOutAction()
	{
		session_start();
		unset($_SESSION);
		session_destroy();
		$this->redirect('/public/login');
	}
}