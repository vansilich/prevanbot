<?php

namespace app\controllers;

use bot\App;
use bot\base\Controller;

class StartController extends Controller{

    public function indexAction(){

        if ($this->user['db_job_id'] == 1){
            $menu = [["Мои жалобы"], ["Моя прослушка"]];
        }else{
            $menu = [["Жалобы моей группы"], ["Жалобы оператора"], ["Прослушка оператора"]];
//            $menu = [["Жалобы оператора"]];
        }

        $chat_id = $this->user["message"]["chat"]["id"];
        $reply = "Привет, " . $this->user["message"]["from"]["first_name"] . ", это все доступные команды для тебя:";
        $reply_markup = App::$app->get('telegram')->replyKeyBoardMarkup(['keyboard'=>$menu, 'resize_keyboard'=>true, 'one_time_keyboard'=>false]);
        App::$app->get('telegram')->sendMessage(['chat_id'=>$chat_id, 'text'=>$reply, 'reply_markup'=>$reply_markup]);
    }
}