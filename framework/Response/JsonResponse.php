<?php
/* JsonResponse */
namespace Framework\Response;

class JsonResponse {

	public $data = '';

	public function __construct($data)
	{
		$this->data = $data;
		return json_encode($data);
	}
	public function send()
	{
		echo json_encode($this->data);
	}
}

?>
