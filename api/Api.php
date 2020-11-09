<?php

namespace api;

use api\google\Sheets;
use api\yandex\Tracker;
use bot\Db;

class Api{

    public function __construct(){
        // Set DB connection
        Db::getInstance();
        $sheets = new Sheets();
        $sheets->check_complaints();
        $tracker = new Tracker();
        $tracker->getCallQuality();
    }

}