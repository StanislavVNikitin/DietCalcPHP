<?php
function autoload($catalog) {
    $arr = array_splice(scandir(ROOT . "/" . $catalog . "/"), 2);
    foreach ($arr as $value) {
        $filename = ROOT . "/" . $catalog . "/" . $value;
        include $filename;
    }
}

//Функция, возвращает текст шаблона $page с подстановкой переменных
//из массива $params, содержимое шабона $page подставляется в
//переменную $content главного шаблона layout для всех страниц
function render($page, $params)
{
    return renderTemplate(LAYOUTS_DIR . $params['layout'], [
        'content' => renderTemplate($page, $params),
        'menu' => renderTemplate('menu', $params)
    ]);
}

//Функция возвращает текст шаблона $page с подставленными переменными из
//массива $params, просто текст
function renderTemplate($page, $params = [])
{
    ob_start();

    if (!is_null($params))
        extract($params);

    $fileName = TEMPLATES_DIR . $page . ".php";

    if (file_exists($fileName)) {
        include $fileName;
    } else {
        Die("Страницы {$page} не существует.");
    }

    return ob_get_clean();
}
