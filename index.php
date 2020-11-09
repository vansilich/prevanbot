<?php

use bot\App;
use bot\base\Model;

require_once 'config/init.php';

new App();

//$result = App::$app->get('user');
//
//$text = $result["message"]["text"];
//$chat_id = $result["message"]["chat"]["id"];
//$name = $result["message"]["from"]["username"];
//$first_name = $result["message"]["from"]["first_name"];
//$last_name = $result["message"]["from"]["last_name"];

//if($text == "/start"){
//    $reply = 'Menu: ';
//    $reply_markup = App::$app->get('telegram')->replyKeyBoardMarkup(['keyboard'=>$menu, 'resize_keyboard'=>true, 'one_time_keyboard'=>false]);
//    App::$app->get('telegram')->sendMessage(['chat_id'=>$chat_id, 'text'=>$reply, 'reply_markup'=>$reply_markup]);
//}elseif($text == 'Привет'){
//    $reply = 'Привет ' . $first_name . ' ' . $last_name;
//    $reply_markup = App::$app->get('telegram')->replyKeyBoardMarkup(['keyboard'=>$menu, 'resize_keyboard'=>true, 'one_time_keyboard'=>false]);
//    App::$app->get('telegram')->sendMessage(['chat_id'=>$chat_id, 'text'=>$reply, 'reply_markup'=>$reply_markup]);
//}elseif($text == 'Кнопка 2'){
//    $reply = 'Привет ' . $first_name . ' ' . $last_name . " это Кнопка 2";
//    $reply_markup = App::$app->get('telegram')->replyKeyBoardMarkup(['keyboard'=>$menu2, 'resize_keyboard'=>true, 'one_time_keyboard'=>false]);
//    App::$app->get('telegram')->sendMessage(['chat_id'=>$chat_id, 'text'=>$reply, 'reply_markup'=>$reply_markup]);
//}
//elseif($text == 'Кнопка 1'){
//    $reply_markup = App::$app->get('telegram')->replyKeyBoardMarkup(['keyboard'=>$menu2, 'resize_keyboard'=>true, 'one_time_keyboard'=>false]);
//    App::$app->get('telegram')->sendMessage(['chat_id'=>$chat_id, 'text'=>$name, 'reply_markup'=>$reply_markup]);
//}

//$model = new Model();
//$connection = App::$app->get('db_connect');
//$query = "SELECT tg_login FROM employee WHERE tg_login = '@kulikovIvan007'";
//$result = pg_query($query);
//var_dump(pg_fetch_assoc($result));