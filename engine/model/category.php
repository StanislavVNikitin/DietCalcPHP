<?php

function getCategoryfood($id){

    $id = (int)$id;
    $sql = "SELECT id, name, special_foods, image FROM foods WHERE  category_id = {$id}";
    return getAssocResult($sql);

}

function getCategoryName($id){
    var_dump(session_id());
    $id = (int)$id;
    $sql = "SELECT name FROM category WHERE  id = {$id}";
    return getAssocResult($sql)[0]['name'];
}


function doCategoryAction(&$params, $action, $id)
{
    $params['count'] = '10';
    $params['button'] = 'Добавить';
    $params['namecategory'] = '';

    if ($action == "item") {

        $params['categoryfood'] = getCategoryfood($id);
        $params['namecategory'] = getCategoryName($id);

    }

}
