<?php

$action_post = htmlspecialchars($_GET['action'], ENT_QUOTES);

define('DB_HOST', 'mysql');
define('DB_USER', 'root');
define('DB_PWD', 'example');
define('DB_BASE', 'work5');

spl_autoload_register(function ($name) {
    require('../app/class/' . $name . '.php');
});

$action = new Action($action_post);