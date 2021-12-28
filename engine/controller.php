<?php

//Для каждой страницы готовим массив со своим набором переменных
//для подстановки их в соотвествующий шаблон
function prepareVariables($page, $action, $id)
{
    session_start();
    $params = [];
    $params['auth'] = isAuth();
    if (isset($_SESSION['auth']['login'])){
        $params['name'] = get_user();
    } else {
        sessionCookeGuestStart();
    }

    switch ($page) {
        case 'index':
            break;

        case 'api':

            if ($action == 'addtodiet') {
                echo json_encode();
                die();
            }

            if ($action == 'delete') {
                echo json_encode();
                die();
            }
            break;

        case 'login':
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

        case 'logout':
            setcookie("hash", "", time()-1, "/");
            setcookie("dietcalc", "", time()-1, "/");
            session_destroy();
            $_SESSION['auth'] = "";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            die();

        case 'dietcalc':
            doDietAction($params, $action, $id);
            $params['products'] = getDiet();
            $params['sumnvpdiet'] = calcDiet();
            $params['foods'] = getFoods();
            break;

        case 'category':
            $params['category'] = getCategory();
            break;

        case 'categoryitem':
            getCategoryfood($action);
            break;

//        case 'catalog':
//            $params['catalog'] = getCatalog();
//            break;
//
//        case 'news':
//            $params['news'] = getNews();
//            break;
//
//        case 'newsone':
//            $id = (int)$_GET['id'];
//            $params['news'] = getOneNews($id);
//            break;
//
//        case 'feedback':
//
//            doFeedbackAction($action);
//
//            $params['feedback'] = getAllFeedback();
//            break;
//
//        case 'gallery':
//
//            if (!empty($_FILES)) {
//                upload();
//            }
//            $params['gallery'] = getGallery();
//            break;
//
//        case 'apicatalog':
//            echo json_encode(getCatalog(), JSON_UNESCAPED_UNICODE);
//            die();
    }

    return $params;
}