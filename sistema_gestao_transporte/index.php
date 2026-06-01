<?php
	session_start();
	include_once("conexao.php");	
?>
<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login | CH4</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.cox1m/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<link rel="stylesheet" href="login.css">
</head>

<body>
	<div class="box">
		<h2><i class="fas fa-lock"></i> Login</h2>
		<?php
			if(!empty($erros_do_sistema)){
				foreach($erros_do_sistema as $erro){
					echo "<div class='error'>$erro</div>";
				}
			}
		?>

		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
			<div class="inputBox">
				<input type="text" name="login" required="">
				<label><i class="fas fa-user"></i> Username</label>
			</div>
			<div class="inputBox">
				<input type="password" name="senha" required="">
				<label><i class="fas fa-key"></i> Password</label>
			</div>
			<input type="submit" name="btn-acessar" value="ACESSAR">
		</form>

		<div class="footer-text">
			<i class="fas fa-shield-alt"></i> Sistema Seguro
		</div>

		<?php
			if(isset($_POST['btn-acessar'])){
				$erros_do_sistema = array();
				$login = mysqli_escape_string($conexao, $_POST['login']);
				$senha = mysqli_escape_string($conexao, $_POST['senha']);

				if(empty($login) || empty($senha)){
					$erros_do_sistema[] = "Login ou password incorrecta";
				}else{
					$selecao = "SELECT login FROM admin_usuarios WHERE login='$login'";	
					$acessar = mysqli_query($conexao, $selecao);
					if(mysqli_num_rows($acessar) > 0){
						$senha = md5($senha);
						$selecao = "SELECT * FROM admin_usuarios WHERE login='$login' AND senha ='$senha'";
						$acessar = mysqli_query($conexao, $selecao);
						if(mysqli_num_rows($acessar) == 1){
							$percorre = mysqli_fetch_array($acessar);
							$_SESSION['id_usuario'] = $percorre['id'];
							$_SESSION['acesso_sistema'] = $percorre['acesso'];
							header("Location: acesso.php");
						}else{
							$erros_do_sistema[] = "Login ou password incorrecta";	
						}
					}else{
						$erros_do_sistema[] = "Login ou password incorrecta";
					}
				}
			}	
		?>
	</div>
</body>
</html>
