<?php

namespace api\google;

use Telegram\Bot\Api;

class Sheets{

    public $client;
    public $service;

    public function __construct(){
        // Get the API client and construct the service object.
        $this->client = self::getClient();
        $this->service = new \Google_Service_Sheets($this->client);
    }

    public function check_complaints(){
        $service = $this->service;
        $spreadsheetId = '1_VaDfmDbGACJ9yyl6_vN8cU8bXMHJo05H1KhS27PKhc';
        $range = 'Лист2!A2:Z';
        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        $values = $response->getValues();

        foreach ($values as $key => $value){
            if (!isset($value[24])){
                $employee_f_name = mb_strtolower(explode(" ", $value[17])[1], 'utf-8');
                $employee_l_name = mb_strtolower(explode(" ", $value[17])[0], 'utf-8');
                $text = 'Тип ошибки: ' . $value[12] . "\n\n" . $value[10];

//                self::saveComplaint($employee_f_name, $employee_l_name, $value[10], $value[12], $value[0]);
                self::send_complaint($employee_f_name, $employee_l_name, $text);

                $cell = $key + 2;
                $range = "Лист2!Y${cell}";
                $values = [['Да']];
                $body = new \Google_Service_Sheets_ValueRange(['values' => $values]);
                $params = ['valueInputOption' => 'RAW'];
                $result = $service->spreadsheets_values->update($spreadsheetId, $range, $body, $params);
            }
        }
    }

    public static function getClient(){
        $client = new \Google_Client();
        $client->setApplicationName('Google Sheets and PHP');
        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
        $client->setAccessType('offline');
        $client->setAuthConfig(__DIR__ . '/sheets/credentials.json');

        return $client;
    }

    public static function saveComplaint($employee_f_name, $employee_l_name, $message, $type, $date){
        $query = "SELECT * FROM employees WHERE first_name = '${employee_f_name}' AND last_name = '${employee_l_name}'";
        $worker_db_info = pg_fetch_assoc(pg_query($query));

        var_dump($worker_db_info);

        $query = "INSERT INTO complaints (manager_id, operator_id, message, complaint_type, reg_date) 
        VALUES (${worker_db_info['manager_id']}, ${worker_db_info['id']}, '${message}', '${type}', '${date}');";
        pg_query($query);
    }

    public static function send_complaint($employee_f_name, $employee_l_name, $text){
        $telegram = new Api($_ENV['TG_API_KEY']);
        $query = "SELECT tg_chat_id, manager_id FROM employees
        WHERE first_name = '${employee_f_name}' AND last_name = '${employee_l_name}'";
        $result = pg_fetch_assoc(pg_query($query));
        $chat_id = $result['tg_chat_id'];
        $manager_id = $result['manager_id'];
        $telegram->sendMessage(['chat_id'=>$chat_id, 'text'=>$text]);

//        $query = "SELECT tg_chat_id FROM employees WHERE id = ".$manager_id;
//        $result = pg_fetch_assoc(pg_query($query));
//        $chat_id = $result['tg_chat_id'];
//        $text = "Ваш опер ${employee_f_name} ${employee_l_name} схлопатал жалобу!:\n ${text}";
//        $telegram->sendMessage(['chat_id'=>$chat_id, 'text'=>$text]);
    }
    
}