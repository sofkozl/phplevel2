<?php

abstract class C_Base extends C_Controller
{
	protected $title;		// заголовок страницы
	protected $content;		// содержание страницы

	protected function before()
	{
		$this->title = 'Основная страница';
		$this->content = 'Пробный контент';
	}

	public function render()
	{
		$get_user = new M_User();
		if (isset($_SESSION['user_id'])) {
			$user_info = $get_user->get($_SESSION['user_id']);
		} else {
			$user_info['user_name'] = false;
		}

		$loader = new Twig_Loader_Filesystem('v');
		$twig = new Twig_Environment($loader);
		$template = $twig->loadTemplate('index.tmpl');
		$vars = array(
			'user' => $user_info['name']
		);
		echo $template->render($vars);
	}
}
