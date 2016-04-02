<?php
/*
model.php
*/
namespace Framework\Model;

//Use SDI
use Framework\DI\Service;

class ActiveRecord {

	public static function findByEmail($email)
	{
		$result = null;
		$db = Service::get('pdo');
		$sql = $db->query("SELECT * FROM users WHERE email = '".$email."'");
		if($sql->rowCount() >= 1)
		   $result = (object) $sql->fetch(\PDO::FETCH_ASSOC);

		return $result;
	}

	public static function find($id = 'all')
	{
		$db = Service::get('pdo');
		$sql = "SELECT * FROM posts";
		if(is_numeric($id))
  		 $sql .= " WHERE id = ".$id;

		$res = $db->query($sql);
		if($res->rowCount() > '0' && $id == 'all')
		{
			while($row = $res->fetch(\PDO::FETCH_ASSOC))
						$result[] = (object) $row;
		}
		else 	$result = $res->fetch(\PDO::FETCH_ASSOC);

		return (object) $result;
	}

	protected function keys()
	{
		return implode(',', array_keys(get_object_vars($this)));
	}

	protected function vars()
	{
		return implode('\',\'', array_values(get_object_vars($this)));
	}

	protected function keys_vars()
	{
		$str = null;
		foreach ($this as $keys => $values)
		{
			$str[] = "`".$keys."` = '".$values."'";
		}
		$str = implode(',', $str);
		return $str;
	}

	public function save(){
		$db = Service::get('pdo');
		if($this->id == '')
		{
			unset($this->id);
			$sql = "INSERT INTO " .$this->getTable(). " (".$this->keys().") VALUES ('".$this->vars()."')";
		} else {
			$sql = "UPDATE " .$this->getTable(). " SET ".$this->keys_vars()." WHERE id = ('".$this->id."')";
		}
		$db->query($sql);
	}
}
?>
