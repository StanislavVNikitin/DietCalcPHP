<?php

function authController(&$params, $action) {
    
    $templateName = '/auth/register';
    switch ($action) {
        case 'login':
            if(!empty($_POST['login']) && !empty($_POST['pass']) ){
                $login = $_POST['login'];
                $pass = $_POST['pass'];
                if (auth($login, $pass)) {
                    if (isset($_POST['save'])) {
                        $hash = uniqid(rand(), true);
                        $id = mysqli_real_escape_string(getDb(), strip_tags(stripslashes($_SESSION['auth']['id'])));
                        $sql = "UPDATE users SET hash = '{$hash}' WHERE id = {$id}";
                        executeSql($sql);
                        setcookie("hash", $hash, time() + LIFE_TIME_COOKIE, "/");
                    }
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                    die();
                } else {
                    die("Не верный логин пароль");
                }
            }
            $templateName = "/auth/login";
            break;

        case 'logout':
            setcookie("hash", "", time() - 1, "/");
            setcookie("dietcalc", "", time() - 1, "/");
            session_destroy();
            $_SESSION['auth'] = "";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            die();

        case 'register':
            registerUser();
            header("Location: " . "/auth/login");
            die();

        case 'emailconfirm':
            if(emailConfirm()){
                    die('Учетка подтверждена');
            }
 //           header("Location: " . "/auth/login");
            die("");


    }

    return render($templateName, $params);
}