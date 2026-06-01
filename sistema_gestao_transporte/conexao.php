<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "ch4";

	$conexao=mysqli_connect($servername,$username,$password,$dbname);

	try {
	    $conn = new PDO("mysql:host=$servername;dbname=" . $dbname, $username, $password);
	} catch (PDOException $err) {
		echo "Erro: Conexão com banco de dados não foi realizada com sucesso. Erro gerado " . $err->getMessage();
	}

?>