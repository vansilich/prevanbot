<?php

namespace bot;

use Telegram\Bot\Api;
use bot\Registry;
use bot\ErrorHandler;
use bot\Router;
use bot\Db;

class App{

    public static $app;

    public function __construct(){
        self::$app = Registry::getInstance('App');
        new ErrorHandler();
        self::$app->set('telegram', new Api($_ENV['TG_API_KEY']));
        $result = self::$app->get('telegram')->getWebhookUpdates();
        self::$app->set('mess_info', $result);
        Db::getInstance();
        Router::dispatch($result["message"]["text"]);
    }

}