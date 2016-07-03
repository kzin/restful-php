<?php
require_once 'Status.class.php';

class user extends status{
	
	public $id;
	
	public $name;
	private $password;
	public $email;
	
	static $REGEX_NAME = "/^([^[:punct:]\d]+)$/";
	static $REGEX_EMAIL = "^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.([a-zA-Z]{2,4})$";
	static $REGEX_PASSWORD_LIMIT = "/^.{6,20}$/";
	
	public $response = array();
	
	//setter
	public function setPassword($password){
		$this->password = $this->encryptPassword($password);
	}
	
	private function encryptPassword($password) {
		$workout = 13;
		$salt = uniqid();	
		return crypt($password,'$6$'.$workout.'$'.$salt);
	}
	
	function authenticate($password, $hash) {
		return (crypt($password, $hash) === $hash);
	}
	
	function check(){
		//verify name
		if(!preg_match(self::$REGEX_NAME,$this->name) || empty($this->name))
			return $this->_requestStatus(self::$INVALID_NAME);
		//verify email
		if (!filter_var($this->email, FILTER_VALIDATE_EMAIL) || empty($this->email))
			return $this->_requestStatus(self::$INVALID_EMAIL);
		//verify password
		if (!preg_match(self::$REGEX_PASSWORD_LIMIT, $this->password) || empty($this->password))
			return $this->_requestStatus(self::$INVALID_PASSWORD);
	
		return $this->_requestStatus(self::$SUCCESS);
	}
	
	function save() {
		
		$response['status'] = $this->check();
		
		//verify if is ok
		if($response['status']['code'] == self::$SUCCESS) {
			
			$id = "usr".uniqid(rand(1111, 9999));
			$name = ucwords($this->name);
			$email = $this->email;
					
			$sql = "INSERT INTO user_data (id, name, email, password) ";		
			$sql.= "VALUES ('{$id}', '{$this->name}','{$this->email}', '{$this->password}')";			
			
			$result = mysql_query($sql);
			$response['status'] = $this->_requestStatus(self::$SUCCESS);
				
		}
		
		return $response;
    }
	
	function get() {
		$response['status'] = $this->_requestStatus(self::$SUCCESS);
		
		if(empty($this->id))
			$response['status'] = $this->_requestStatus(self::$INVALID_USER);
		
		if($response['status']['code'] == self::$SUCCESS) {
			$sql = "SELECT count(*) as total, id, name, email FROM user_data WHERE id = '{$this->id}'";
			
			$rs = mysql_query($sql);
	
			if($row = mysql_fetch_array($rs))
			{
				if($row["total"] == 1) {
					$this->id = $row["id"];
					$this->email = $row["email"];
					$this->name = $row["name"];
					$response['status'] = $this->_requestStatus(self::$SUCCESS);
					$response['user'] = $this->toString();
				}
				else
					$response['status'] = $this->_requestStatus(self::$INVALID_USER);
			} else
					$response['status'] = $this->_requestStatus(self::$FAILED);
		}
		
		return $response;		
	}
	
	private function toString() {
		$arr = array();
		$arr['id'] = $this->id;
		$arr['name'] = ucwords($this->name);
		$arr['email'] = $this->email;
		
		return $arr;
	}
}
?>