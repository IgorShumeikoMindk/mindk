<?php

namespace Framework\Controller;

use Framework\Response\Response;
use Framework\Request\Request;
use Framework\Renderer\Renderer;
use Framework\DI\Service;

/**
 * Class Controller
 * Controller prototype
 *
 * @package Framework\Controller
 */
abstract class Controller {

	public function getRequest()
	{
			return new Request();
	}
	public function generateRoute($routeName)
	{
			return Service::get('config')['routes'][$routeName]['pattern'];
	}
	public function redirect($location = '/')
	{
		$response = new Response();
		$response->setHeader('Location', $location);
		return $response->sendHeaders();
	}
	protected function getViewPath()
	{
		$route_path_src = str_replace('\\\\', '/views/', str_replace('Controller', '', Service::get('route_controller')['controller']));
		$path = __DIR__."/../../src/".$route_path_src."/";
		return $path;
	}
	/**
	 * Rendering method
	 *
	 * @param   string  Layout file name
	 * @param   mixed   Data
	 *
	 * @return  Response
	 */
	public function render($layout, $data = array()){
		$fullpath = realpath($this->getViewPath() . $layout . '.php');
		$renderer = new Renderer(Service::get('config')['main_layout']);
		$content = $renderer->render($fullpath, $data);

		return new Response($content);
	}
}
