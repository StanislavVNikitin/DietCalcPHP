<?php

function getCategory(){
    $sql = "SELECT * FROM category WHERE 1";
    return getAssocResult($sql);
}

function getCategoryfood($id){
    var_dump($id);
}
