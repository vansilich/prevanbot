<?php

namespace app\models\admin;

use bot\base\Model;
use bot\App;

class GetComplsModel extends Model{

    public static function getAllComplaints($id){
        $query = "SELECT empl.last_name, empl.first_name, compl.message, compl.complaint_type, compl.reg_date 
        FROM complaints compl 
        JOIN employees empl ON (compl.operator_id = empl.id) 
        WHERE compl.manager_id = ${id};";
        $allComplaints = pg_fetch_all(pg_query($query));
        $text = '';
        if (!$allComplaints){
            return 'В твоей группе сейчас нет жалоб';
        }
        foreach ($allComplaints as $key => $value){
            $text .= "Оформил: ${value['last_name']} ${value['first_name']}\nДата обработки: ${value['reg_date']}\n${value['complaint_type']}\n${value['message']}\n\n================\n\n";
        }
        return $text;
    }

    public static function searchComplaints($id){
        $query = "SELECT * FROM complaints WHERE operator_id = '$id';";
        $result = pg_fetch_all(pg_query($query));
        if (!$result){
            throw new \Exception('Не удалось выполнить запрос', 500);
        }
        if ($result == ''){
            return 'У оператора нет жалоб';
        }
        $text = '';
        foreach ($result as $key => $value) {
            $text .=  'Дата обработки: '.$value['reg_date']."\n".$value['complaint_type']."\n".$value['message']."\n\n================\n\n";
        }
        return $text;
    }


}