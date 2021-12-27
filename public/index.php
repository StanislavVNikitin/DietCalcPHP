<?php

//Первым делом подключим файл с константами настроек
include "../config/config.php";

//Запускаем сессию и куки через фукнцияю sessionCookeGusetStart()


$url_array = explode('/', $_SERVER['REQUEST_URI']);

// Формируем $action из url

if (isset($url_array[2])) {
    $action = $url_array[2];
} else {
    $action = "";
}

// Формируем $id из url
if (isset($url_array[3])) {
    $id = $url_array[3];
} else {
    $id = "";
}
//Читаем параметр page из url, чтобы определить, какую страницу-шаблон
//хочет увидеть пользователь, по умолчанию это будет index


if ($url_array[1] == "") {
    $page = 'index';
} else {
    $page = $url_array[1];
}

$params = prepareVariables($page, $action, $id);


//_log($params, "render");
echo render($page, $params);

