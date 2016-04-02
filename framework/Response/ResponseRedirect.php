<?php
namespace Framework\Response;

class ResponseRedirect extends Response{

  public function __construct($path)
  {
		parent::setHeader('Location', $path);
		return parent::sendHeaders();
  }

}

?>
