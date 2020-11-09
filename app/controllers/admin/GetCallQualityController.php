<?php

namespace app\controllers\admin;

use bot\App;
use bot\base\Controller;
use app\models\GetCallQualityModel;

class GetCallQualityController extends Controller{

    public function indexAction(){
        $telegram = App::$app->get('telegram');
        $chat_id = $this->user["message"]["chat"]["id"];

        if (!($this->route['first_name'] && $this->route['last_name'])){
            $reply = 'Введите сначала фамилию, затем имя оператора через пробел:';
            GetCallQualityModel::saveLastCommand($this->user["message"]["text"]);
        }else{
            $last_name = mb_strtolower($this->route['last_name'], 'utf-8');
            $first_name = mb_strtolower($this->route['first_name'],'utf-8' );
            $user = GetCallQualityModel::searchUserByName($last_name, $first_name);
            $reply = GetCallQualityModel::getCallQuality($user['id']);
            GetCallQualityModel::saveLastCommand('');
        }
        $telegram->sendMessage(['chat_id'=>$chat_id, 'text'=>$reply]);
    }

}