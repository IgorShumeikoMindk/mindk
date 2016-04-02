<?php

namespace Framework\Renderer;

use Framework\DI\Service;
/**
 * Class Renderer
 * @package Framework\Renderer
 */
class Renderer {

	/**
	 * @var string  Main wrapper template file location
	 */
	protected $main_template = '';

	/**
	 * Class instance constructor
	 *
	 * @param $main_template_file
	 */
	public function __construct($main_template_file){

		$this->main_template = $main_template_file;
	}

	/**
	 * Render main template with specified content
	 *
	 * @param $content
	 *
	 * @return html/text
	 */
	public function renderMain($content){
		$flush = array();
		$user = null;
		if (Service::get('security')->isAuthenticated()) {
				$user = (object) array('email' => 'admin@gmail.com');
		}
		//TODO: Implement site sounds
		//$flush = array('error'=>array("Error message show!"),'msgs'=>array("Simple message show!"));

		return $this->render($this->main_template, compact('content', 'user', 'flush'), false);
	}

	/**
	 * Render specified template file with data provided
	 *
	 * @param   string  Template file path (full)
	 * @param   mixed   Data array
	 * @param   bool    To be wrapped with main template if true
	 *
	 * @return  text/html
	 */
	public function render($template_path, $data = array(), $wrap = true){
		extract($data);
		ob_start();
		$include = function($controller, $action, $data = array())
		{
				$controller = new $controller;
				$method = $action.'Action';
				extract($data);
			return $result = $controller->$method($id);
		};
		$generateToken = function(){};
		$getRoute = function($key)
		{
				$controller = Service::get('route_controller')['controller'];
				$controller = new $controller;
				return $controller->generateRoute($key);
		};
		include($template_path);
	 	$content = ob_get_contents();
		ob_end_clean();

		if($wrap){
			$content = $this->renderMain($content);
		}

		return $content;
	}
}
