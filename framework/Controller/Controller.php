<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 24.02.16
 * Time: 11:55
 */

namespace Framework\Controller;

use Framework\Renderer\Renderer;

abstract class Controller {

	public function render($partial, $data = array()){
		$renderer = new Renderer($main);
		
		//@TODO ... make full path from partial
		
		
		$render->render($path, $data);
	}
}