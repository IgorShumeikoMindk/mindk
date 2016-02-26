<?php

namespace Framework\Renderer;

class Renderer{
	//выводить отрисовывать!

    //bufer запись в буферизацию
	public function render($template, $params = array()){

		extract($params); //@ Импортирует переменные из массива в текущую таблицу символов
		ob_start(); //@ Включение буферизации вывода
		include($template); //подключаем шаблон которий опредиляется в application
		$buffer = ob_get_clean(); //Получить содержимое текущего буфера и удалить его а затем вернуть
		return $buffer; //возврат
	}

}




  ?>