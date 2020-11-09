<?php

namespace api\yandex;

use api\yandex\tracker\Exec;

class Tracker{

    public $tokens = [];
    public $org_id = '69598';

    public function __construct(){
        $this->tokens = self::get_api_tokens();
    }

    public function getCallQuality(){
        foreach ($this->tokens as $key => $value){
            Exec::run($value['api_key'], $this->org_id, $value['manager_id']);
        }
    }

    private static function get_api_tokens(){
        return pg_fetch_all(pg_query("SELECT * FROM api_yandex"));
    }

}