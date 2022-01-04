<?php

function dietcalcController(&$params, $action, $id)
{

    if (empty($action)) $action = 'dietcalc';
    $params['products'] = getDiet();
    $params['sumnvpdiet'] = calcDiet();
    $params['foods'] = getFoods();
    $params['count'] = '10';
    $params['button'] = 'Добавить';
    $params['idfood'] = '';
    $params['idfoodtodiet'] = '';
    $params['action'] = 'add';

    switch ($action) {
        case 'add':
            $msg = addFoodToDiet();
            header("Location: /dietcalc/?message={$msg}");
            break;

        case 'delete':
            deleteFoodDiet($id);
            header("Location: /dietcalc/?message=delete");
            break;

        case 'edit':
            editFoodInDiet($params, $id);
            break;

        case 'save':
            saveDiet();
            header("Location: /dietcalc/?message=edit");
            break;

    }

    if (!empty($_GET)) {
        if ($_GET['message'] == 'ok') $params['message'] = "Продукт добавлен в диету!";
        if ($_GET['message'] == 'edit') $params['message'] = "Продукт изменен в диете!";
        if ($_GET['message'] == 'delete') $params['message'] = "Продукт удален из диеты!";
        if ($_GET['message'] == 'edit') $params['message'] = "Продукт отредактирован в диете!";
    }

    $templateName = '/dietcalc';

    return render($templateName, $params);
}