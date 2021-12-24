<?php

function get_user()
{
    return $_SESSION['login'];
}

function isAuth()
{

    if (isset($_COOKIE["hash"])) {
        $hash = $_COOKIE["hash"];
        $sql = "SELECT * FROM users WHERE hash='{$hash}'";
        $row = getAssocResult($sql);
        if ($row) {
            $user = $row['login'];
            if (!empty($user)) {
                $_SESSION['login'] = $user;
            }
        }
    }
    return isset($_SESSION['login']);
}

function auth($login, $pass)
{
    var_dump($pass);
    $login = mysqli_real_escape_string(getDb(), strip_tags(stripslashes($login)));
    $sql = "SELECT * FROM users WHERE login = '{$login}'";
    $row = getAssocResult($sql)[0];
    var_dump($row);
    if ($row) {
        if (password_verify($pass, $row['password_hash'])) {
            //Авторизация
            $_SESSION['login'] = $login;
            $_SESSION['id'] = $row['id'];
            return true;
        }
    }
    return false;

}