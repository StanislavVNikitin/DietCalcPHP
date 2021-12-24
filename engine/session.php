<?php

function sessionCookeGusetStart()
{
    //Функция запускает сессию и копирует id сессии в куки
    session_start();

    if (!isset($_COOKIE['dietcalc'])) {
        if (!isset($_SESSION['guestid'])) {
            $_SESSION['guestid'] = uniqid(rand(), true);
            $_SESSION['guest'] = true;
        }
        setcookie("dietcalc", $_SESSION['guestid'], time() + 3600, "/");
    } else {
        $_SESSION['guestid'] = $_COOKIE['dietcalc'];
    }
    return true;
}

function getGuestSessionId()
{
    if (isset($_SESSION['guestid'])) {
        return $_SESSION['guestid'];
    }

}