<?php
namespace Framework\Router;
/**
 * Router.php
 */
class Router{
	/**
	 * @var array
	 */
	protected static $map = array(); // создание пустого масива для карты роута
	/**
	 * Class construct
	 */
	public function __construct($routing_map = array()){
		self::$map = $routing_map; // обращение к статическому свойству
	}
	/**
	 * Parse URL
	 *
	 * @param $url
	 */
	public function parseRoute($url){
		$route_found = null;
		foreach(self::$map as $route){ //проганяем через цикл
			$pattern = $this->prepare($route); // TODO
			if(preg_match($pattern, $url, $params)){  //  Выполняет проверку на соответствие регулярному выражению
				// Get assoc array of params:
                preg_match($pattern, str_replace(array('{','}'), '', $route['pattern']), $param_names);
				$params = array_map('urldecode', $params); //Декодирование URL-кодированной строки
				$params = array_combine($param_names, $params);
				array_shift($params); // Get rid of 0 element
				$route_found = $route;
				$route_found['params'] = $params;
				break;
			}
		}
		return $route_found;

	}
	public function buildRoute($route_name, $params = array()){
		// @TODO: Your code...
	}
	private function prepare($route){
		$pattern = preg_replace('~\{[\w\d_]+\}~Ui','([\w\d_]+)', $route['pattern']);
		$pattern = '~^'. $pattern.'$~';
		return $pattern;
		
	}
}









  ?>