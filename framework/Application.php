<?php 

namespace Framework;

use Framework\Router\Router;
use Framework\Exception\HttpNotFoundException;
use Framework\Exception\AuthRequredException;
use Framework\Exception\BadResponseTypeException;
use Framework\Response\Response;
use Framework\Renderer\Renderer;

 class Application {
 
	public function run(){

		$router = new Router(include('../app/config/routes.php')); //создаем екземпляр и подключаем routers
		$route =  $router->parseRoute($_SERVER['REQUEST_URI']);
        //print_r($route); //deleate this TODO
        

	
        try{ // блок try catch робота с исключениями и ошибками
	        if(!empty($route)){ //проверка наличия route
		        $controllerReflection = new \ReflectionClass($route['controller']); //создает екземплр и сообщает информацию о классе
		        $action = $route['action'] . 'Action';  //приводим к нужному виду TODO in Dof
		        if($controllerReflection->hasMethod($action)){ //проверяет задан ли метод, если метод задан то->
			        $controller = $controllerReflection->newInstance(); //Создаёт экземпляр класса с переданными аргументами
			        $actionReflection = $controllerReflection->getMethod($action); // Возвращает экземпляр ReflectionMethod для метода класса
			        $response = $actionReflection->invokeArgs($controller, $route['params']); //Вызов функции с передачей аргументов, Возвращает результат выполнения вызванной функции.
			        if($response instanceof Response){ //используется для определения того, является ли текущий объект экземпляром указанного класса.
				    	// ...
			        } else {
				        throw new BadResponseTypeException('Ooops'); //описание исключения
			        }
		        }
			} else {
		        throw new HttpNotFoundException('Route not found'); //описание исключения
			}
        }catch(HttpNotFoundException $e){
	         // Render 404 or just show msg
        	$renderer = new Renderer(); //создание екземпляра
            //переменную content приравниваем к переменной renderer и вызываем метод render и переопределяем его указав параметры
        	$content = $renderer->render('../src/Blog/views/404.html.php', array(
        			'code'=>$e->getCode(), //задается параметры с масива
        			'message'=>$e->getMessage()
        		));
        	$response = new Response($content);

        }
        catch(AuthRequredException $e){
	    	// Reroute to login page
	        //$response = new RedirectResponse(...);
        }
        catch(\Exception $e){
	        // Do 500 layout...
	        echo $e->getMessage();
        }
		$response->send();
	}
} 



?>
