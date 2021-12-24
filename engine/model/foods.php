<?php

function getFoods()
{
    $sql = "SELECT  id, name, special_foods FROM `foods`;";

    return getAssocResult($sql);
}
