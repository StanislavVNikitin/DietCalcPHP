<?php

function categoriesController(&$params, $action) {

    $params['category'] = getCategories();

    $templateName = "/categories";
    return render($templateName, $params);
}