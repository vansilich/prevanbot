<?php

namespace bot;

use bot\App;

class Db{

    use TMultiton;

    protected function __construct(){
        $dbconf = pg_connect("host=${_ENV['DB_HOST']} port=${_ENV['DB_PORT']} dbname=${_ENV['DB_NAME']} user=${_ENV['DB_USER']} password=${_ENV['DB_PASSWORD']}")
          or die('Не удалось соединиться: ' . pg_last_error());
    }
}