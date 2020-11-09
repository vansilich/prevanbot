<?php

use bot\Router;

Router::add("^/start$", ['controller' => 'Start']);

Router::add("^Мои жалобы$", ['controller' => 'GetCompls']);
Router::add("^Моя прослушка$", ['controller' => 'GetCallQuality']);

Router::add('^Жалобы моей группы$', ['controller' => 'GetCompls', 'prefix' => 'admin', 'action' => 'getAll']);
Router::add('^Жалобы оператора\s?((?<last_name>[а-яё]+) (?<first_name>[а-яё]+))?$', ['controller' => 'GetCompls', 'prefix' => 'admin', 'action' => 'search']);
Router::add('^Прослушка оператора\s?((?<last_name>[а-яё]+) (?<first_name>[а-яё]+))?$', ['controller' => 'GetCallQuality', 'prefix' => 'admin', 'action' => 'index']);
