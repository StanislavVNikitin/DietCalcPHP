<?php


function findFoodToDiet($foodid)
{

    $guestsessionid = getGuestSessionId();
    $sql = "SELECT * FROM diet_temp WHERE foods_id = '{$foodid}' AND guestsessionid = '{$guestsessionid}'";

    if (empty(getAssocResult($sql))) {
        return false;
    }
    return true;
}

function getDiet()
{
    $guestsessionid = getGuestSessionId();
    $sql = "SELECT  d.id,
                    f.name,
                    ROUND(d.count,0) as count, 
                    ROUND(f.protein*d.count/100, 1) as protein, 
                    ROUND(f.fat*d.count/100, 1) as fat,
                    ROUND(f.carbohydrates*d.count/100, 1) as carbohydrates,
                    ROUND(f.calories*d.count/100, 0) as calories,
                    f.special_foods,
                    d.guestsessionid
            FROM `diet_temp` as d, `foods` as f 
            WHERE d.foods_id = f.id AND d.guestsessionid='{$guestsessionid}'";
    return getAssocResult($sql);
}

function calcDiet()
{

    $guestsessionid = getGuestSessionId();
    $sql = "SELECT SUM(ROUND(f.protein*d.count/100, 1)) as sumprotein, 
        SUM(ROUND(f.fat*d.count/100, 1)) as sumfat,
        SUM(ROUND(f.carbohydrates*d.count/100, 1)) as sumcarbohydrates,
        SUM(ROUND(f.calories*d.count/100, 0)) as sumcalories
        FROM `diet_temp` as d, `foods` as f 
        WHERE d.foods_id = f.id AND guestsessionid='{$guestsessionid}'";
    return getAssocResult($sql)[0];

}

function addFoodToDiet()
{
    if (!empty($_POST)) {
        $guestsessionid = getGuestSessionId();
        $foodid = (int)($_POST['foodid']);
        $foodcount = (int)($_POST['foodcount']);
        if (!findFoodToDiet($foodid)) {
            $sql = "INSERT INTO diet_temp (guestsessionid, foods_id, count) VALUES ('{$guestsessionid}', '{$foodid}', '{$foodcount}')";
            $message = 'ok';
        } else {
            $sql = "UPDATE diet_temp SET `count` = `count` +'{$foodcount}', `updated_at` = NOW() WHERE `diet_temp`.`foods_id` = '{$foodid}' AND guestsessionid = '{$guestsessionid}'";
            $message = 'edit';
        }
        executeSql($sql);
    }
    return $message;
}

function deleteFoodDiet($id)
{

    if (isset($id)) {
        $guestsessionid = getGuestSessionId();
        $iddel = (int)$id;
        $sql = "DELETE FROM diet_temp WHERE id = '{$iddel}' AND guestsessionid = '{$guestsessionid}'";
        executeSql($sql);
    }

}

function editFoodInDiet(&$params, $id)
{
    $idfood = (int)$id;
    $guestsessionid = getGuestSessionId();
    $sql = "SELECT d.id,
            d.foods_id,
            f.name,
            ROUND(d.count,0) as count 
            FROM `diet_temp` as d, `foods` as f 
            WHERE d.foods_id = f.id 
            AND d.id = '{$idfood}' AND guestsessionid = '{$guestsessionid}'";
    $result_food = getAssocResult($sql);
    $params['name'] = $result_food[0]['name'];
    $params['count'] = $result_food[0]['count'];
    $params['action'] = 'save';
    $params['idfood'] = $result_food[0]['foods_id'];
    $params['idfoodtodiet'] = $result_food[0]['id'];
    $params['button'] = 'Править';
}

function saveDiet()
{
    if (!empty($_POST)) {
        $guestsessionid = getGuestSessionId();
        $idfoodtodiet = (int)($_POST['idfoodtodiet']);
        $foodcount = (int)($_POST['foodcount']);
        $sql = "UPDATE diet_temp SET `count` = '{$foodcount}', `updated_at` = NOW() WHERE `diet_temp`.`id` = '{$idfoodtodiet}' AND guestsessionid = '{$guestsessionid}'";
        echo executeSql($sql);
    }
}

function doDietAction(&$params, $action, $id)
{
    $params['name'] = '';
    $params['count'] = '10';
    $params['button'] = 'Добавить';
    $params['action'] = 'add';
    $params['idfood'] = '';
    $params['idfoodtodiet'] = '';

    if ($action == "add") {
        $msg = addFoodToDiet();
        header("Location: /dietcalc/?message={$msg}");
    }

    if ($action == "delete") {
        deleteFoodDiet($id);
        header("Location: /dietcalc/?message=delete");
    }

    if ($action == "edit") {
        editFoodInDiet($params, $id);
    }

    if ($action == "save") {
        saveDiet();
        header("Location: /dietcalc/?message=edit");
    }
    if (!empty($_GET)) {
        if ($_GET['message'] == 'ok') $params['message'] = "Продукт добавлен!";
        if ($_GET['message'] == 'edit') $params['message'] = "Продукт изменен!";
        if ($_GET['message'] == 'delete') $params['message'] = "Продукт удален!";
        if ($_GET['message'] == 'edit') $params['message'] = "Продукт отредактирован!";
    }
}