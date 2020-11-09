<?php

namespace bot;

class Registry{

    use TMultiton;

    public function set(string $key, $val){
        $this->registry[$key] = $val;
    }

    public function get(string $key, $default = false){
        if (isset($this->registry[$key]))
            return $this->registry[$key];
        else
            return $default;
    }

    public function getAll(){
        return $this->registry;
    }

    public function unset(string $key){
        if (isset($this->registry[$key]))
            unset($this->registry[$key]);
    }
}