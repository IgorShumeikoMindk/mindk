<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 08.03.16
 * Time: 19:00
 */
namespace Framework\DI;

class Service {
    protected static $services = array();
    public static function set($service_name, $obj){
        self::$services[$service_name] = $obj;
    }
    public static function get($service_name){
        return empty(self::$services[$service_name]) ? null : self::$services[$service_name];
    }
}