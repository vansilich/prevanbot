<?php

namespace bot;

use bot\App;
use bot\base\Model;

class ErrorHandler{
    public function __construct(){
        if (DEBUG){
            error_reporting(-1);
        }else{
            error_reporting(0);
        }
        set_exception_handler([$this, 'exceptionHandler']);
    }

    public function exceptionHandler($e){
        error_log("[" . date('U-m-d H:i:s') . "] Текст ошибки {$e->getMessage()} | Файл: {$e->getFile()} | Строка: {$e->getLine()}\n===============\n", 3, ROOT . "/tmp/bot_error.log");
        $chat_id = App::$app->get('mess_info')["message"]["chat"]["id"];
        Model::saveLastCommand('');
        App::$app->get('telegram')->sendMessage(['chat_id'=>$chat_id, 'text'=>$e->getMessage()]);
    }
}