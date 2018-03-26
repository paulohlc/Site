<?php
require_once("Sql.php");

class User{

	private $login;
	private $password;

	public function getLogin(){
		return $this->login;
	}
	public function getPassword(){
		return $this->password;
	}

	public function setLogin($login){
		$this->login = $login;
	}
	public function setPassword($password){
		$this->password = $password;	
	}			

	public function validarUsuario(){
		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN AND despassword = :PASSWORD", $params = array(
			":LOGIN" => $this->login,
			":PASSWORD" => $this->password
		));
		
		if(count($results) > 0){
			header("Location: ../index.php");
			exit();
		}else{
			header("Location: ../admin.php");
			exit();
		}
}
}
