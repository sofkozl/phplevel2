<?php

class M_User
{
    public $users_id, $users_name, $users_login, $users_password;

    public function hash_pass($name, $password)
    {
        return strrev(md5($name)) . md5($password);
    }

    public function get($id)
    {
        $query = "SELECT * FROM user WHERE id_user=:id_user";
        $res = DB::Instance()->Select($query, ['id_user' => $id]);
        return $res;
    }

    public function register($name, $login, $password)
    {
        $query = "SELECT * FROM user WHERE user_login=:user_login";
        $res = DB::Instance()->Select($query, ['user_login' => $login]);
        if (!$res) {
            $pass = $this->hash_pass($login, $password);
            $query = "INSERT INTO user (user_name, user_login, user_password) VALUES (:name, :login, :pass)";
            $res = DB::Instance()->Insert($query, [
                'name' => $name,
                'login' => $login,
                'pass' => $pass,
            ]);
            return 'Регистрация прошла успешно!';
        } else {
            return "Логин уже используется.";
        }
    }

    public function auth($login, $password)
    {
        $query = "SELECT * FROM user WHERE user_login=:user_login";
        $res = DB::Instance()->Select($query, ['user_login' => $login]);

        if ($res) {
            if ($res['user_password'] == $this->hash_pass($login, $password)) {
                $_SESSION['user_id'] = $res['id_user'];
                return "Добро пожаловать, " . $res['user_name'] . "!";
            } else {
                return "Неверный пароль";
            }
        } else {
            return "Пользователь с таким логином не зарегистрирован.";
        }
    }

    public function logout()
    {
        if ($_SESSION['user_id']) {
            $_SESSION['user_id'] = null;
            session_destroy();
            return true;
        }

        return false;
    }
}
