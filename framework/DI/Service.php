<?php
/* Simple Dependency Injection */

namespace Framework\DI;

use Framework\Application;

class Service {
  private static $services = array();

  public static function get($serviceName)
  {
      return array_key_exists($serviceName, self::$services) ? self::$services[$serviceName] : null;
  }

  public static function set($serviceName, $serviceClass)
  {
      self::$services[$serviceName] = $serviceClass;
  }

}
?>
