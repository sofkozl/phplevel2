<?php

// include_once('m/M_User.php');

class C_User extends C_Base
{
	public function action_info()
	{
		$get_user = new M_User();
		$user_info = $get_user->get($_SESSION['user_id']);
		$this->title .= '::' . $user_info['user_name'];

		$loader = new Twig_Loader_Filesystem('v');
		$twig = new Twig_Environment($loader);
		$template = $twig->loadTemplate('user_info.tmpl');
		$vars = array(
			'username' => $user_info['user_name'],
			'userlogin' => $user_info['user_login']
		);
		echo $template->render($vars);
	}

	public function action_register()
	{
		$this->title .= '::Регистрация';
		$loader = new Twig_Loader_Filesystem('v');
		$twig = new Twig_Environment($loader);
		$template = $twig->loadTemplate('user_reg.tmpl');

		if ($this->isPost()) {
			$new_user = new M_User();
			$res = $new_user->register($_POST['name'], $_POST['login'], $_POST['password']);
			echo $template->render(array('text' => $res));
		} else {
			echo $template->render(array());
		}
	}

	public function action_auth()
	{
		$this->title .= '::Вход';
		$loader = new Twig_Loader_Filesystem('v');
		$twig = new Twig_Environment($loader);
		$template = $twig->loadTemplate('user_login.tmpl');
		echo $template->render(array());

		if ($this->isPost()) {
			$login = new M_User();
			$res = $login->auth($_POST['login'], $_POST['password']);
			echo $res;
		}
	}

	public function action_logout()
	{
		$logout = new M_User();
		$result = $logout->logout();
	}
}
