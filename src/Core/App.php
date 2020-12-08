<?php
namespace App\Core;
class App
{
    private static $container = array();

    public static function bind($key, $value)
    {
        static::$container[$key] = $value;
    }

    public static function get($key)
    {
        if (!array_key_exists($key, static::$container)) {
            throw new Exception("The $key doesn't exist in the container");
        }
        return static::$container[$key];
    }


}