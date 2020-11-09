<?php

define("DEBUG", 1);
define("ROOT", dirname(__DIR__));
define("API", ROOT . '/api');
define("TMP", ROOT . '/tmp');
define("CORE", ROOT . '/vendor/bot/core');
define("LIBS", CORE . '/libs');
define("CONF", ROOT . '/config');
define("LAYOUT", 'default');

date_default_timezone_set('Europe/Moscow');

require_once ROOT . "/vendor/autoload.php";
require_once CONF . "/routes.php";
require_once LIBS . '/functions.php';

//getting environment variables of the APP (db config, API keys and etc.)
$dotenv = \Dotenv\Dotenv::createImmutable(ROOT);
$dotenv->load();