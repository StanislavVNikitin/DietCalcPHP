<?php
define("ROOT", dirname(__DIR__));
define('TEMPLATES_DIR', ROOT . '/templates/');
define('LAYOUTS_DIR', 'layouts/');
define('LIFE_TIME_COOKIE', 3600*24*7);

/* DB config */
define('HOST', '192.168.11.3:3306');
define('USER', 'dietcalc');
define('PASS', '0,ybycr');
define('DB', 'dietcalc');

include ROOT . "/engine/db.php";
include ROOT . "/engine/core.php";

autoload("controllers");
autoload("models");