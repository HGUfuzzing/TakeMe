<?php

class App
{
    protected static $registry = [];

    public static function bind($key, $value) 
    {
        static::$registry[$key] = $value;
    }

    public static function get($key) 
    {
        if(! array_key_exists($key, static::$registry)) {
            throw new Exception("container(class) App에 {$key}가 없습니다.");
        }
        
        return static::$registry[$key];
    }

}