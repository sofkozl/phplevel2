<?php

class M_User
{
    public function hash_pass($name, $password)
    {
        return strrev(md5($name)) . md5($password);
    }

    public function get($id)
    {
        $query = "SELECT * FROM user WHERE id_user=:id_user";
        $res = M_PDO::Instance()->Select($query, ['id_user' => $id]);
        return $res;
    }

    public function register($name, $login, $password)
    {
        $query = "SELECT * FROM user WHERE user_login=:user_login";
        $res = M_PDO::Instance()->Select($query, ['user_login' => $login]);
        if (!$res) {
            $query = "INSERT INTO user (user_name, user_login, user_password) VALUES (:name, :login, :password)";
            $res = M_PDO::Instance()->Insert($query, [
                'name' => $name,
                'login' => $login,
                'password' => $this->hash_pass($name, $password)
            ]);
            return 'Регистрация прошла успешно!';
        } else {
            return "Логин уже используется.";
        }
    }

    public function auth($login, $password)
    {
        $query = "SELECT * FROM user WHERE user_login=:user_login";
        $res = M_PDO::Instance()->Select($query, ['user_login' => $login]);
        if ($res) {
            if ($res['user_password'] == $this->hash_pass($res['user_name'], strip_tags($password))) {
                $_SESSION['id_user'] = $res['id_user'];
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
        if ($_SESSION['id_user']) {
            $_SESSION['id_user'] = null;
            session_destroy();
            return true;
        }

        return false;
    }
}
