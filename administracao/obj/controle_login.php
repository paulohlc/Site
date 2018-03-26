<?php  
require_once("../classes/User.php");

$login = new User();

$login->setLogin($_POST['login']);
$login->setPassword($_POST['password']);

$login->validarUsuario();

?>