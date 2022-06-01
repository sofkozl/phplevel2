<?php

include_once 'config/db.php';

class M_User
{
    public $users_id, $users_name, $users_login, $users_password;
    private $connect;

    public function __construct()
    {
        $this->connect = $this->connecting();
    }

    public function hash_pass($name, $password)
    {
        return strrev(md5($name)) . md5($password);
    }

    public function connecting()
    {
        return new PDO(DB_DRIVER . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }

    public function get($id)
    {
        return $this->connect->query("SELECT * FROM users WHERE users_id= '" . $id . "'")->fetch();
    }

    public function register($name, $login, $password)
    {
        $user = $this->connect->query("SELECT * FROM users WHERE users_login = '" . $login . "'")->fetch();
        if (!$user) {
            if ($this->connect->exec("INSERT INTO users (users_name, users_login, users_password) VALUES (
                '" . $name . "', '" . $login . "', '" . $this->hash_pass($name, $password) . "')")) {
                return "Регистрация прошла успешно!";
            }
        } else {
            return "Логин уже используется.";
        }
    }

    public function auth($login, $password)
    {
        $user = $this->connect->query("SELECT * FROM users WHERE users_login = '" . $login . "'")->fetch();
        if ($user) {
            if ($user['users_password'] == $this->hash_pass($user['users_name'], strip_tags($password))) {
                $_SESSION['users_id'] = $user['users_id'];
                return "Добро пожаловать, " . $user['users_name'] . "!";
            } else {
                return "Неверный пароль";
            }
        } else {
            return "Пользователь с таким логином не зарегистрирован.";
        }
    }

    public function logout()
    {
        if ($_SESSION['users_id']) {
            $_SESSION['users_id'] = null;
            session_destroy();
            return true;
        }

        return false;
    }
}
