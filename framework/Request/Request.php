<?php
namespace Framework\Request;
class Request
{
    public function __construct(){
      return $_REQUEST;
    }

    public static function create()
    {
      return new Request();
    }

    public function isPost()
    {
        return $_SERVER["REQUEST_METHOD"] == "POST";
    }

    public function post($name)
    {
        return $_POST[$name];
    }
    public function get($name)
    {
        return $_GET[$name];
    }
}
