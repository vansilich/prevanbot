<?php

namespace app\controllers\admin;

use bot\App;
use bot\base\Controller;
use app\models\admin\GetComplsModel;

class GetComplsController extends Controller{

    public function getAllAction(){
        $telegram = App::$app->get('telegram');
        $chat_id = $this->user["message"]["chat"]["id"];

        $id = $this->user['db_id'];
        $result = GetComplsModel::getAllComplaints($id);

        $telegram->sendMessage(['chat_id'=>$chat_id, 'text'=>$result]);
    }

    public function searchAction(){
        $telegram = App::$app->get('telegram');
        $chat_id = $this->user["message"]["chat"]["id"];

        if (!($this->route['first_name'] && $this->route['last_name'])){
            $reply = 'Введите сначала фамилию, а затем имя оператора:';
            GetComplsModel::saveLastCommand($this->user["message"]["text"]);
        }else{
            $last_name = mb_strtolower($this->route['last_name'], 'utf-8');
            $first_name = mb_strtolower($this->route['first_name'],'utf-8' );
            $user = GetComplsModel::searchUserByName($last_name, $first_name);
            $reply = GetComplsModel::searchComplaints($user['id']);
            GetComplsModel::saveLastCommand('');
        }
        $telegram->sendMessage(['chat_id'=>$chat_id, 'text'=>$reply]);
    }

}