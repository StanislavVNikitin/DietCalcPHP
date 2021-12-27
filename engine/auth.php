<?php

function get_user()
{
    $_SESSION['auth']['id'] = getAssocResult("SELECT id FROM users WHERE login = '{$_SESSION['auth']['login']}'")[0]['id'];
    return $_SESSION['auth']['login'];
}

function isAuth()
{

    if (isset($_COOKIE["hash"])) {
        $hash = $_COOKIE["hash"];
        $sql = "SELECT * FROM users WHERE hash='{$hash}'";
        $row = getAssocResult($sql);
        if (isset($row[0])) {
            $user = $row[0]['login'];
            if (!empty($user)) {
                $_SESSION['auth']['login'] = $user;
            }
        }
    }
    return isset($_SESSION['auth']['login']);
}

function auth($login, $pass)
{
    $login = mysqli_real_escape_string(getDb(), strip_tags(stripslashes($login)));
    $sql = "SELECT * FROM users WHERE login = '{$login}'";
    $row = getAssocResult($sql);
    if (isset($row[0])) {
        if (password_verify($pass, $row[0]['password_hash'])) {
            //Авторизация
            $_SESSION['auth']['login'] = $login;
            $_SESSION['auth']['id'] = $row[0]['id'];
            return true;
        }
    }
    return false;

}