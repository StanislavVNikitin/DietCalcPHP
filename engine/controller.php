<?php

//Для каждой страницы готовим массив со своим набором переменных
//для подстановки их в соотвествующий шаблон
function prepareVariables($page, $action, $id)
{

    $params = [];

    if (isset($_SESSION['login'])){
        $params['name'] = get_user();
    }
    $params['auth'] = isAuth();

    switch ($page) {
        case 'index':
            break;


        case 'login':
            $login = $_POST['login'];
            $pass = $_POST['pass'];

            if (auth($login, $pass)) {
                if (isset($_POST['save'])) {
                    $hash = uniqid(rand(), true);
                    $id = mysqli_real_escape_string(getDb(), strip_tags(stripslashes($_SESSION['id'])));
                    $sql = "UPDATE users SET hash = '{$hash}' WHERE id = {$id}";
                    $result = mysqli_query(getDb(), $sql);
                    setcookie("hash", $hash, time() + 3600, "/");
                }
                header("Location: /");
                die();
            } else {
                die("Не верный логин пароль");
            }

        case 'logout':
            setcookie("hash", "", time()-1, "/");
            setcookie("dietcalc", "", time()-1, "/");
            session_destroy();
            header("Location: /");
            die();

        case 'dietcalc':
            doDietAction($params, $action, $id);
            $params['products'] = getDiet();
            $params['sumnvpdiet'] = calcDiet();
            $params['foods'] = getFoods();

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