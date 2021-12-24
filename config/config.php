<?php
define('TEMPLATES_DIR', '../templates/');
define('LAYOUTS_DIR', 'layouts/');

/* DB config */
define('HOST', '192.168.11.3:3306');
define('USER', 'dietcalc');
define('PASS', '0,ybycr');
define('DB', 'dietcalc');

include "../engine/db.php";
include "../engine/auth.php";
include "../engine/controller.php";
include "../engine/functions.php";
include "../engine/log.php";
include "../engine/model/diets.php";
include "../engine/model/foods.php";
include "../engine/session.php";