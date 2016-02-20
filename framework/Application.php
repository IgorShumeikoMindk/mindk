<?php 

namespace Framework;


 
 
use Framework\Router\Router;

 class Application {
 
	public function run(){

		$router = new Router(include('../app/config/routes.php'));
		$route =  $router->parseRoute($_SERVER['REQUEST_URI']);

		if(!empty($route)){

		} else {

		}
	}
 } 




?>
