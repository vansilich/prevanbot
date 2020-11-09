<?php

namespace app\controllers;

use bot\App;
use bot\base\Controller;
use app\models\GetCallQualityModel;

class GetCallQualityController extends Controller{

    public function indexAction(){
        $telegram = App::$app->get('telegram');
        $chat_id = $this->user["message"]["chat"]["id"];

        $id = $this->user['db_id'];
        $result = GetCallQualityModel::getCallQuality($id);

        $telegram->sendMessage(['chat_id'=>$chat_id, 'text'=>$result]);
    }

}