<?php

namespace bot\base;

use bot\Db;
use bot\App;

class Model{
    
    public static function checkUser($user_name){
        $query = "SELECT * FROM employees WHERE tg_login = '$user_name'";
        $result = pg_fetch_assoc(pg_query($query));
        return $result;
    }

    public static function update_chat_id($user_name){
        $chat_id = App::$app->get('mess_info')["message"]["chat"]["id"];
        $query = "UPDATE employees SET tg_chat_id = '$chat_id' WHERE tg_login = '$user_name';";
        if (!pg_query($query)){
            throw new \Exception("не удалось изменить chat_id пользователя ${user_name}", 500);
        }
        return true;
    }

    public static function saveLastCommand($response){
        $user_name = '@' . App::$app->get('mess_info')["message"]["from"]["username"];
        $query = "UPDATE employees SET last_command = '$response' WHERE tg_login = '$user_name';";
        if (!pg_query($query)){
            throw new \Exception("Не удалось сохранить вашу последнюю команду(", 500);
        }
    }

    public static function checkLastCommand($user_name){
        $query = "SELECT last_command FROM employees WHERE tg_login = '$user_name'";
        $result = pg_fetch_assoc(pg_query($query));
        if ($result){
            return $result['last_command'];
        }
        return false;
    }

    public static function searchUserByName($last_name, $first_name){
        $query = "SELECT * FROM employees WHERE last_name = '$last_name' AND first_name = '$first_name'";
        $result = pg_fetch_assoc(pg_query($query));
        if (!$result){
            throw new \Exception('Не удалось найти пользователя', 500);
        }
        return $result;
    }

}