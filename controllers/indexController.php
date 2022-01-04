<?php

function indexController(&$params, $action) {

    $templateName = 'index';

    return render($templateName, $params);
}