<?php

	include_once("conexao.php");
	session_start();
	if($_SESSION['acesso_sistema'] == 1 ){
		header("Location: dashboard.php");            
    }
	else if($_SESSION['acesso_sistema'] == 2){
		header("Location: home.html");
	}
	else if($_SESSION['acesso_sistema'] == 3){
		header("Location: sistem_gerente/home.php");
    }
	else if($_SESSION['acesso_sistema'] == 4){
		header("Location: sistema_operador/Meet&Great.php");
    }
	else if($_SESSION['acesso_sistema'] == 5){
		header("Location: sistema_cliente/home.php");
    }else{
		session_destroy();
		header("Location: index.php");
	}

?>
