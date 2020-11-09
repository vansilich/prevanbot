<?php

namespace api\yandex\tracker;

use Telegram\Bot\Api;

class Exec{

    public static $manager_id = '';
    public static $org_id = '';
    //now()-89h..now()
    //AND ("Тип": "Прослушка и оценка")
    public static function run($token, $org_id, $id){
        self::$manager_id = $id;
        self::$org_id = $org_id;

//        $data = ["query" => '("Resolved": 15.10.2020..30.10.2020 Login: i-p-kulikov@drvrc.com Resolution: ocenen Queue: AUDKON Status: closed) AND "Комментарий к диалогу": notEmpty()'];
//        $data_string = json_encode($data, JSON_UNESCAPED_UNICODE);
//
//        $ch = curl_init('https://api.tracker.yandex.net/v2/issues/_search?');
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//            'Authorization: OAuth ' . $token,
//            'X-Org-Id: ' . $org_id,
//            'Content-Type: application/json'
//        ));
//        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
//
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($ch, CURLOPT_HEADER, false);
//        $res = curl_exec($ch);
//        $res = json_decode($res, true);
//
//        curl_close($ch);
//
//        if (empty($res)){
//            file_put_contents(ROOT . '/tmp/api/yandex.log',
//                "[" . date('U-m-d H:i:s') . "] в группе руководителя с id=${id} нет диалогов с ошибками\n",
//                FILE_APPEND);
//            die();
//        }
        $res = require_once TMP . '/data.php';
        $contacts = self::searchContacts($res);
        self::sendCallQuality($res, $contacts);
//        self::saveCallQuality($res, $contacts);
//        file_put_contents(ROOT . '/tmp/api/yandex.log', print_r($res, true), FILE_APPEND);
    }

    public static function searchContacts($res){
        $logins = '';
        foreach ($res as $key => $value) {
            $logins .= "'" . $value['login'] . "', ";
        }
        $logins = rtrim($logins, ', ');
        $query = "SELECT DISTINCT id, yandex_login, tg_chat_id FROM employees WHERE yandex_login IN (${logins});";
        $result = pg_fetch_all(pg_query($query));
        $new_result = [];
        foreach ($result as $key => $value){
            $new_result[$value['yandex_login']]['tg_chat_id'] = $value['tg_chat_id'];
            $new_result[$value['yandex_login']]['id'] = $value['id'];
        }
        return $new_result;
    }

    public static function sendCallQuality($res, $contacts){
        $telegram = new Api($_ENV['TG_API_KEY']);
        foreach ($res as $key => $value){
            if (array_key_exists($value['login'], $contacts)){
                $telegram->sendMessage(['chat_id'=>$contacts[$value['login']]['tg_chat_id'], 'text'=>$value['kommentarijKDialogu']."\n=========="]);
            }
        }
    }

//    public static function saveCallQuality($res, $contacts){
//        $query = "INSERT INTO call_quality (tracker_id, tracker_url, manager_id, operator_id, message) VALUES ";
//        foreach ($res as $key => $value){
//            $query .= "('" .$value["id"] . "', '" . $value['self'] . "', " . self::$manager_id . ", " . $contacts[$value['login']]['id'] . ", '" . $value['kommentarijKDialogu'] . "'), ";
//        }
//        echo $query = rtrim($query, ', ');
//        pg_query($query);
//    }

}