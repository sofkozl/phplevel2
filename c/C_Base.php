<?php
//
// Базовый контроллер сайта.
//
include_once 'm/M_User.php';

abstract class C_Base extends C_Controller
{
	protected $title;		// заголовок страницы
	protected $content;		// содержание страницы
	protected $keyWords;


	protected function before()
	{

		$this->title = 'тест';
		$this->content = '';
		$this->keyWords = "...";
	}

	//
	// Генерация базового шаблонаы
	//	
	public function render()
	{
		$get_user = new M_User();
		if (isset($_SESSION['users_id'])) {
			$user_info = $get_user->get($_SESSION['users_id']);
		} else {
			$user_info['users_name'] = false;
		}
		$vars = array('title' => $this->title, 'content' => $this->content, 'kw' => $this->keyWords, 'user' => $user_info['users_name']);
		$page = $this->Template('v/v_main.php', $vars);
		echo $page;
	}
}
