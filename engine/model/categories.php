<?php

function getCategories(){
    $sql = "SELECT * FROM category WHERE 1";
    return getAssocResult($sql);
}
