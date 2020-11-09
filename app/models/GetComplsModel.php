<?php

namespace app\models;

use bot\base\Model;

class GetComplsModel extends Model{

    public static function getAllComplaints($id){
        $query = "SELECT * FROM complaints WHERE operator_id = ${id}";
        $result = pg_fetch_all(pg_query($query));
        if (!$result){
            return 'У вас нет жалоб)';
        }
        $text = '';
        foreach ($result as $key => $value) {
            $text .=  'Дата обработки: '. $value['reg_date']."\n".$value['complaint_type']."\n".$value['message']."\n================\n";
        }
        return $text;
    }
}