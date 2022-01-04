<?php

function apiController(&$params, $action) {
    switch ($action) {
        case 'addtodiet':
            $data = json_decode(file_get_contents('php://input'));
            apiAddFoodToDiet($data->foodid, $data->foodcount);
                //header("Content-type: application/json");
                //echo json_encode($data);
                //addFoodToDiet();
            $sumnvpdiet = calcDiet();
            echo json_encode(['calories' => $sumnvpdiet['sumcalories'], 'protein' => $sumnvpdiet['sumprotein']]);
            die();

        case 'delete':
            echo json_encode();
            die();
    }
}