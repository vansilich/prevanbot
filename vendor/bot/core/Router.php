<?php

namespace bot;

use bot\base\Model;
use bot\App;

class Router{

    protected static $routes = [];
    protected static $route = [];
    protected static $last_command = '';

    public static function Add($regExp, $route = []){
        self::$routes[$regExp] = $route;
    }

    public static function getRoutes(){
        return self::$routes;
    }

    public static function getRoute(){
        return self::$route;
    }

    public static function dispatch($response){
        if (self::checkLastCommand()){
            $response = self::$last_command . ' ' . $response;
        }
        if (self::matchRoute($response)){
            $controller = 'app\controllers\\' . self::$route['prefix'] . self::$route['controller'] . 'Controller';
            if (class_exists($controller)){
                $controllerObject = new $controller(self::$route);
                $action = self::lowerCamelCase(self::$route['action']) . 'Action';
                if (method_exists($controllerObject, $action)){
                    $controllerObject->$action();
                }else{
                    throw new \Exception("Метод $controller::$action не найден", 400);
                }
            }else{
                throw new \Exception("Эта команда сейчас не работает", 400);
            }
        }else{
            throw new \Exception("Такой команды нет!", 404);
        }
    }

    public static function matchRoute($response){
        foreach (self::$routes as $pattern => $route) {
            if (preg_match("#{$pattern}#iu", $response, $matches)) {
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $route[$key] = $value;
                    }
                }
                if (empty($route['action'])) {
                    $route['action'] = 'index';
                }
                if (!isset($route['prefix'])){
                    $route['prefix'] = '';
                }
                else{
                    $route['prefix'] .= '\\';
                }
                $route['controller'] = self::upperCamelCase($route['controller']);
                self::$route = $route;
                return true;
            }
        }
        Model::saveLastCommand('');
        return false;
    }

    public static function checkLastCommand(){
        $user_name = '@'.App::$app->get('mess_info')["message"]["from"]["username"];
        self::$last_command = Model::checkLastCommand($user_name);
        if (self::$last_command){
            return true;
        }else{
            return false;
        }
    }

    protected static function upperCamelCase($str){
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $str)));
    }

    protected static function lowerCamelCase($str){
        return lcfirst(self::upperCamelCase($str));
    }

}