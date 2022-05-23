<?php

include_once('m/M_User.php');

class C_User extends C_Base
{
	// вместо вызова класса М_юзер можно задать сво-во создания объекта класса и прописать его в конструкторе

	public function action_info()
	{
		$get_user = new M_User();
		$user_info = $get_user->get($_SESSION['users_id']);
		$this->title .= '::' . $user_info['users_name'];
		$this->content = $this->Template('v/v_info.php', array('username' => $user_info['users_name'], 'userlogin' => $user_info['users_login']));
	}

	public function action_register()
	{
		$this->title .= '::Регистрация';
		$this->content = $this->Template('v/v_reg.php', array());

		if ($this->IsPost()) {
			$new_user = new M_User();
			$result = $new_user->register($_POST['users_name'], $_POST['users_login'], $_POST['users_password']);
			$this->content = $this->Template('v/v_reg.php', array('text' => $result));
		}
	}


	public function action_auth()
	{
		$this->title .= '::Вход';
		$this->content = $this->Template('v/v_login.php', array());

		if ($this->IsPost()) {
			$login = new M_User();
			$result = $login->auth($_POST['users_login'], $_POST['users_password']);
			$this->content = $this->Template('v/v_login.php', array('text' => $result));
		}
	}

	public function action_logout()
	{
		$logout = new M_User();
		$result = $logout->logout();
	}
}
