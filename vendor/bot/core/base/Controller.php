<?php

namespace bot\base;

use bot\App;
use bot\base\Model;

class Controller{

    public $user;
    public $route;

    public function __construct($route){
        $this->route = $route;
        $this->user = App::$app->get('mess_info');
        $user_name = '@' . $this->user["message"]["from"]["username"];
        $user_db_info = Model::checkUser($user_name);
        if (!$user_db_info){
            throw new \Exception('У вас нет прав для работы со мной', 500);
        }
        if (!$user_db_info['tg_chat_id']){
            Model::update_chat_id($user_name);
        }
        foreach ($user_db_info as $key => $value){
            $this->user['db_' . $key] = $user_db_info[$key];
        }
        if ($this->route['prefix'] == 'admin\\' && $this->user['db_job_id'] == 1){
            throw new \Exception('У вас нет прав для использования этой команды', 500);
        }
    }
}