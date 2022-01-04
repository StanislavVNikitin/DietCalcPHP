<?php

function categoryController(&$params, $action, $id) {

    $params['count'] = '10';
    $params['button'] = 'Добавить';
    $params['namecategory'] = '';

    if ($action == "item") {

        $params['categoryfood'] = getCategoryfood($id);
        $params['namecategory'] = getCategoryName($id);

    }
    $templateName = "/category";
    return render($templateName, $params);
}