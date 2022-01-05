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
    if ($login && $email && ($password === $passwordconfirm)) {
        $sql = "SELECT * FROM users WHERE login = '{$login}'";
        $userNotFound = !getAssocResult($sql);
        if ($userNotFound) {
            $passwordhash = password_hash($password, PASSWORD_DEFAULT);
            $email_confirm_hash = uniqid(rand(), true);
            $sqlinsertuser = "INSERT INTO users (login, password_hash, email, email_confirm_hash) 
                                VALUES('{$login}', '{$passwordhash}', '{$email}', '{$email_confirm_hash}');";
            executeSql($sqlinsertuser);
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function emailConfirm()
{
    if (isset($_GET['confirm_key']) && isset($_GET['confirm_email'])) {
        $confirm_email = mysqli_real_escape_string(getDb(), strip_tags(stripslashes($_GET['confirm_email'])));
        $confirm_key = mysqli_real_escape_string(getDb(), strip_tags(stripslashes($_GET['confirm_key'])));
        $sql = "SELECT id, role_id, email, email_confirm_hash FROM users WHERE email_confirm_hash = '{$confirm_key}';";
        $email_confirm_array = getAssocResult($sql);
        if (!empty($email_confirm_array)) {
            $email_confirm_array = $email_confirm_array[0];
            if ($email_confirm_array['role_id'] == 5) {
                $sql = "UPDATE users SET role_id=4, email_confirm_hash=NULL 
                            WHERE id='{$email_confirm_array['id']}';";
                return executeSql($sql);
            } else {
                die("Роль уже повышена");
            }
        } else {
            die("Некорректные данные подтверждения!");
        }
    } else {
        die("Некорректные  параметры подтверждения!");
    }


}