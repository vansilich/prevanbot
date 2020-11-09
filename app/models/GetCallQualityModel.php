<?php

namespace app\models;

use bot\base\Model;

class GetCallQualityModel extends Model{

    public static function getCallQuality($id){
        $query = "SELECT message FROM call_quality WHERE operator_id = ${id}";
        $result = pg_fetch_all(pg_query($query));
        if (empty($result)){
            return 'Нет плохих результатов прослушки';
        }
        $text = '';
        foreach ($result as $key => $value) {
            $text .=  "${value['message']}\n================\n";
        }
        return $text;
    }

}