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

function registerUser()
{
    $login = mysqli_real_escape_string(getDb(), strip_tags(stripslashes($_POST['username'])));
    $email = mysqli_real_escape_string(getDb(), strip_tags(stripslashes($_POST['email'])));
    $password = mysqli_real_escape_string(getDb(), strip_tags(stripslashes($_POST['password'])));
    $passwordconfirm = mysqli_real_escape_string(getDb(), strip_tags(stripslashes($_POST['password_confirm'])));
    if ($login && $email && ($password === $passwordconfirm)){
        $sql = "SELECT * FROM users WHERE login = '{$login}'";
        $userNotFound = !getAssocResult($sql);
        if ($userNotFound){
            $passwordhash = password_hash($password, PASSWORD_DEFAULT);
            $sqlinsertuser = "INSERT INTO users (login, password_hash) VALUES('{$login}', '{$passwordhash}');";
            $userid = executeSqlAndReturnId($sqlinsertuser);
            $sqlinsertprofile = "INSERT INTO profiles (user_id, disease_id, email ) VALUES('{$userid}','1', '{$email}');";
            executeSql($sqlinsertprofile);
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}