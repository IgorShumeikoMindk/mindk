<?php
/**
 * Clomment
 */
class Loader{
	protected static $instance = null;
	public static $namespaces = array();
	public static function getInstance(){
		if(empty(self::$instance)){
			self::$instance = new self();
		}
		return self::$instance;
		
	}
	public static function load($classname){
		// @Add here some registered $namespaces processing...
		$path = str_replace('Framework','',$classname);
		$path = __DIR__ . str_replace("\\","/", $path) . '.php';
		if(file_exists($path)){
			include_once($path);
		}
		else{
			$segments = explode('\\', $classname);
			$root = array_shift($segments) . '\\';
			if(array_key_exists($root, self::$namespaces)){
				$path = self::$namespaces[$root] . str_replace("\\","/", str_replace($root, '/', $classname)) . '.php';
				if(file_exists($path)){
					include_once($path);
				}
			}
		}
	}
	private function __construct(){
		// Init
		spl_autoload_register(array(__CLASS__, 'load'));
	}
	private function __clone(){
		// lock
	}
	public static function addNamespacePath($namespace, $path){
		//@registration for the namespace
		self::$namespaces[$namespace] = $path;
	}
}
Loader::getInstance();


?>