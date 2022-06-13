<?php

abstract class C_Base extends C_Controller
{
	protected $title;		// заголовок страницы
	protected $content;

	public function before()
	{
		$this->title = 'Интернет-магазин';
		$this->content = '';
	}

	public function render()
	{
		$get_user = new M_User();
		if (isset($_SESSION['id_user'])) {
			$user_info = $get_user->get($_SESSION['id_user']);
		} else {
			$user_info['user_name'] = false;
		}

		$loader = new Twig_Loader_Filesystem('v');
		$twig = new Twig_Environment($loader);
		$template = $twig->loadTemplate('index.tmpl');
		$vars = array(
			'title' => $this->title,
			'content' => $this->content,
			'user' => $user_info['user_name']
		);

		echo $template->render($vars);
	}
}
