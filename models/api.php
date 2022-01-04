<?php

function apiAddFoodToDiet($foodid,$foodcount )
{
        if (isset($_SESSION['auth']['login'])) {
            if (!findFoodToDiet($foodid)) {
                $sql = "INSERT INTO diets (user_diets_id, foods_id, count) VALUES ('{$userid}', '{$foodid}', '{$foodcount}')";
                $message = 'ok';
            } else {
                $sql = "UPDATE diets SET `count` = `count` +'{$foodcount}', `updated_at` = NOW() WHERE `diets`.`foods_id` = '{$foodid}' AND user_diets_id = '{$userid}'";
                $message = 'edit';
            }
        } else {
            $guestsessionid = getGuestSessionId();
            if (!findFoodToDiet($foodid)) {
                $sql = "INSERT INTO diet_temp (guestsessionid, foods_id, count) VALUES ('{$guestsessionid}', '{$foodid}', '{$foodcount}')";
                $message = 'ok';
            } else {
                $sql = "UPDATE diet_temp SET `count` = `count` +'{$foodcount}', `updated_at` = NOW() WHERE `diet_temp`.`foods_id` = '{$foodid}' AND guestsessionid = '{$guestsessionid}'";
                $message = 'edit';
            }

        }
    executeSql($sql);
    return $message;
}
