<?php
/**
 * Clomment
 */
class Loader{

	protected static $instance = null; // хранилище для обьекта класа

	public static $namespaces = array(); //создание пустого масива для записи

	public static function getInstance(){
		if(empty(self::$instance)){ //обращение к свойству
			self::$instance = new self(); //создание екземпляра свойства  @TODO in Dof
		}
		return self::$instance;
        //возврат свойства
	}

	public static function load($classname){
		// @Add here some registered $namespaces processing...
		$path = str_replace('Framework','',$classname); //Заменяет все вхождения строки поиска на строку замены
		$path = __DIR__ . str_replace("\\","/", $path) . '.php'; // приводим путь в правильный вид
		if(file_exists($path)){ //если файл существует то мы его подключаем
			include_once($path);
		}
		else{ // если в framework не нашло то тогда будет искать в blog
			$segments = explode('\\', $classname); //разбиваем строку с помощу разделителя
			$root = array_shift($segments) . '\\'; // Извлекает первый элемент массива
			if(array_key_exists($root, self::$namespaces)){ //Проверяет, присутствует ли в массиве указанный ключ или индекс
				$path = self::$namespaces[$root] . str_replace("\\","/", str_replace($root, '/', $classname)) . '.php'; //приводим нужному виду
				if(file_exists($path)){
					include_once($path); // проверяем наличие файла с таким именем
				} else{
                    echo 'Не удалось подключить клас!!!';
                }
			}
		}
	}
	private function __construct(){
		// Init
		spl_autoload_register(array(__CLASS__, 'load')); // __CLASS__ - имя записаное в namespace , регистрируем загружчик класиов типа __avtoload
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