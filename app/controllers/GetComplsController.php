<?php

namespace app\controllers;

use app\models\GetComplsModel;
use bot\base\Controller;
use bot\App;

class getComplsController extends Controller{

    public function indexAction(){
        $telegram = App::$app->get('telegram');
        $chat_id = $this->user["message"]["chat"]["id"];

        $id = $this->user['db_id'];
        $result = GetComplsModel::getAllComplaints($id);

        $telegram->sendMessage(['chat_id'=>$chat_id, 'text'=>$result]);
    }

}