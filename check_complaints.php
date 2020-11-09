<?php

use api\Api;

require_once __DIR__ . '/config/init.php';

if (php_sapi_name() != 'cli') {
    throw new \Exception('This application must be run on the command line.');
}

new Api();