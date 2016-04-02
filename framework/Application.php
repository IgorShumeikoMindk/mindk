<?php
/**
 * Application.php
 *
 * PHP version 5
 *
 * @category   Category Name
 * @package    Package Name
 * @subpackage Subpackage name
 * @author     dimmask <ddavidov@mindk.com>
 * @copyright  2011-2013 mindk (http://mindk.com). All rights reserved.
 * @license    http://mindk.com Commercial
 * @link       http://mindk.com
 */

namespace Framework;

use Framework\Router\Router;
use Framework\Exception\HttpNotFoundException;
use Framework\Exception\BadControllerTypeException;
use Framework\Exception\AuthRequredException;
use Framework\Response\Response;
use Framework\DI\Service;

//Main variables SDI implementation
use Framework\Security\Security;
use Framework\Session\Session;

class Application {
	private $config;
	private $router;

	public function __construct($config_path)
	{
			$this->config = include_once $config_path;
			$this->router = new Router($this->config["routes"]);
			Service::set('config', $this->config);

			// Setup database connetion...
			$db = new \PDO($this->config['pdo']['dns'],$this->config['pdo']['user'],$this->config['pdo']['password']);
			Service::set('pdo', $db);

			//Main variables
			Service::set('security', new Security());
			Service::set('session', new Session());

	}

	public function run(){
		$route = $this->router->parseRoute();

		try{
	  if(!empty($route))
		{
			if(empty($route['security']) || in_array(Service::get('security')->getUserRole(), @$route['security']))
			{
					$controllerReflection = new \ReflectionClass($route['controller']);
					$action = $route['action'] . 'Action';
		  		if($controllerReflection->hasMethod($action))
					{
			  			$controller = $controllerReflection->newInstance();
			  			$actionReflection = $controllerReflection->getMethod($action);
			  			$response = $actionReflection->invokeArgs($controller, $route['params']);

								// sending
								$response->send();
		 				}
			} else throw new AuthRequredException('Login required');
	 	} else {
		 	throw new HttpNotFoundException('Route not found!');
		}
 		}
		catch(HttpNotFoundException $e)
		{
			// Render 404 or just show msg
			echo $e->getMessage();
 		}
 		catch(AuthRequredException $e)
		{
			echo $e->getMessage();
 		}
 		catch(\Exception $e)
		{
	 		// Do 500 layout...
	 		echo $e->getMessage();
 		}

	}
}
