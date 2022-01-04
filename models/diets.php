<?php


function findFoodToDiet($foodid)
{

    if (isset($_SESSION['auth']['login'])) {
        $userid = $_SESSION['auth']['id'];
        $sql = "SELECT * FROM diets WHERE foods_id = '{$foodid}' AND user_diets_id='{$userid}'";
    } else {
        $guestsessionid = getGuestSessionId();
        $sql = "SELECT * FROM diet_temp WHERE foods_id = '{$foodid}' AND guestsessionid = '{$guestsessionid}'";
    }
    if (empty(getAssocResult($sql))) {
        return false;
    }
    return true;
}

function getDiet()
{
    if (isset($_SESSION['auth']['login'])) {
        $userid = $_SESSION['auth']['id'];
        $sql = "SELECT  d.id,
                        f.name,
                        ROUND(d.count,0) as count, 
                        ROUND(f.protein*d.count/100, 1) as protein, 
                        ROUND(f.fat*d.count/100, 1) as fat,
                        ROUND(f.carbohydrates*d.count/100, 1) as carbohydrates,
                        ROUND(f.calories*d.count/100, 0) as calories,
                        f.special_foods
                FROM `diets` as d, `foods` as f 
                WHERE d.foods_id = f.id AND d.user_diets_id='{$userid}'";
    } else {
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
    }
    return getAssocResult($sql);
}

function calcDiet()
{
    if (isset($_SESSION['auth']['login'])) {
        $userid = $_SESSION['auth']['id'];
        $sql = "SELECT SUM(ROUND(f.protein*d.count/100, 1)) as sumprotein, 
        SUM(ROUND(f.fat*d.count/100, 1)) as sumfat,
        SUM(ROUND(f.carbohydrates*d.count/100, 1)) as sumcarbohydrates,
        SUM(ROUND(f.calories*d.count/100, 0)) as sumcalories
        FROM `diets` as d, `foods` as f 
        WHERE d.foods_id = f.id AND d.user_diets_id='{$userid}'";
    } else {
        $guestsessionid = getGuestSessionId();
        $sql = "SELECT SUM(ROUND(f.protein*d.count/100, 1)) as sumprotein, 
        SUM(ROUND(f.fat*d.count/100, 1)) as sumfat,
        SUM(ROUND(f.carbohydrates*d.count/100, 1)) as sumcarbohydrates,
        SUM(ROUND(f.calories*d.count/100, 0)) as sumcalories
        FROM `diet_temp` as d, `foods` as f 
        WHERE d.foods_id = f.id AND guestsessionid='{$guestsessionid}'";
    }
    return getAssocResult($sql)[0];

}

function addFoodToDiet()
{
    if (!empty($_POST)) {
        if (isset($_SESSION['auth']['login'])) {
            $userid = $_SESSION['auth']['id'];
            $foodid = (int)($_POST['foodid']);
            $foodcount = (int)($_POST['foodcount']);
            if (!findFoodToDiet($foodid)) {
                $sql = "INSERT INTO diets (user_diets_id, foods_id, count) VALUES ('{$userid}', '{$foodid}', '{$foodcount}')";
                $message = 'ok';
            } else {
                $sql = "UPDATE diets SET `count` = `count` +'{$foodcount}', `updated_at` = NOW() WHERE `diets`.`foods_id` = '{$foodid}' AND user_diets_id = '{$userid}'";
                $message = 'edit';
            }
        } else {
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

        }
    }
    executeSql($sql);
    return $message;
}

function deleteFoodDiet($id)
{
    if (isset($_SESSION['auth']['login'])) {
        if (isset($id)) {
            $userid = $_SESSION['auth']['id'];
            $iddel = (int)$id;
            $sql = "DELETE FROM diets WHERE id = '{$iddel}' AND user_diets_id = '{$userid}'";
            executeSql($sql);
        }
    } else {
        if (isset($id)) {
            $guestsessionid = getGuestSessionId();
            $iddel = (int)$id;
            $sql = "DELETE FROM diet_temp WHERE id = '{$iddel}' AND guestsessionid = '{$guestsessionid}'";
            executeSql($sql);
        }
    }


}

function editFoodInDiet(&$params, $id)
{
    $idfood = (int)$id;
    if (isset($_SESSION['auth']['login'])) {
        $userid = $_SESSION['auth']['id'];
        $sql = "SELECT d.id,
                d.foods_id,
                f.name,
                ROUND(d.count,0) as count 
                FROM `diets` as d, `foods` as f 
                WHERE d.foods_id = f.id 
                AND d.id = '{$idfood}' AND user_diets_id='{$userid}'";
    } else {
        $guestsessionid = getGuestSessionId();
        $sql = "SELECT d.id,
                d.foods_id,
                f.name,
                ROUND(d.count,0) as count 
                FROM `diet_temp` as d, `foods` as f 
                WHERE d.foods_id = f.id 
                AND d.id = '{$idfood}' AND guestsessionid = '{$guestsessionid}'";
    }

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
        $idfoodtodiet = (int)($_POST['idfoodtodiet']);
        $foodcount = (int)($_POST['foodcount']);
        if (isset($_SESSION['auth']['login'])) {
            $userid = $_SESSION['auth']['id'];
            $sql = "UPDATE diets SET `count` = '{$foodcount}', `updated_at` = NOW() WHERE `diets`.`id` = '{$idfoodtodiet}' AND user_diets_id='{$userid}'";

        } else {
            $guestsessionid = getGuestSessionId();
            $sql = "UPDATE diet_temp SET `count` = '{$foodcount}', `updated_at` = NOW() WHERE `diet_temp`.`id` = '{$idfoodtodiet}' AND guestsessionid = '{$guestsessionid}'";
        }
    }
    echo executeSql($sql);

}
/*
function doDietAction(&$params, $action, $id)
{
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
        if ($_GET['message'] == 'ok') $params['message'] = "Продукт добавлен в диету!";
        if ($_GET['message'] == 'edit') $params['message'] = "Продукт изменен в диете!";
        if ($_GET['message'] == 'delete') $params['message'] = "Продукт удален из диеты!";
        if ($_GET['message'] == 'edit') $params['message'] = "Продукт отредактирован в диете!";
    }
}*/