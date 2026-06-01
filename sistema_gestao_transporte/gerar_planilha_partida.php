
 <?php
	session_start();
	include_once('../conexao.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Contato</title>
	<head>
	<body>
		<?php
		// Definimos o nome do arquivo que será exportado
		$arquivo = 'msgcontatos.xls';
		
		// Criamos uma tabela HTML com o formato da planilha
		$html = '';
		$html .= '<table border="1">';
		$html .= '<tr>';
		$html .= '<td colspan="5">Documento para faturação Partidas</tr>';
		$html .= '</tr>';
		
		
		$html .= '<tr>';
		$html .= '<td><b>Data</b></td>';
		$html .= '<td><b>Nome</b></td>';
		$html .= '<td><b>Apelido</b></td>';
		$html .= '<td><b>Hora</b></td>';
		$html .= '<td><b>Terceiro</b></td>';
		$html .= '<td><b>Proveniencia</b></td>';
		$html .= '<td><b>Destino</b></td>';
		$html .= '<td><b>Transporte</b></td>';
		$html .= '<td><b>Capitania</b></td>';
		$html .= '<td><b>SME-Emb</b></td>';
		$html .= '<td><b>SME-Des</b></td>';
		$html .= '<td><b>Sonils-Emb</b></td>';
		$html .= '<td><b>Sonils-Des</b></td>';
		$html .= '</tr>';
		
		//Selecionar todos os itens da tabela 
		$result_msg_contatos = "SELECT * FROM meetpartida";
		$resultado_msg_contatos = mysqli_query($conexao , $result_msg_contatos);
		
		while($row_msg_contatos = mysqli_fetch_assoc($resultado_msg_contatos)){
			$html .= '<tr>';
			$html .= '<td>'.$row_msg_contatos["Data"].'</td>';
			$html .= '<td>'.$row_msg_contatos["Nome"].'</td>';
			$html .= '<td>'.$row_msg_contatos["Apelido"].'</td>';
			$html .= '<td>'.$row_msg_contatos["Hora"].'</td>';
			$html .= '<td>'.$row_msg_contatos["Terceiro"].'</td>';
			$html .= '<td>'.$row_msg_contatos["Proveniencia"].'</td>';
			$html .= '<td>'.$row_msg_contatos["Destino"].'</td>';
			$html .= '<td>'.$row_msg_contatos["ValorTransporte"].'</td>';
			$html .= '<td>'.$row_msg_contatos["ValorCapitania"].'</td>';
			$html .= '<td>'.$row_msg_contatos["ValorEmbarque"].'</td>';
			$html .= '<td>'.$row_msg_contatos["ValorDesembarque"].'</td>';
			$html .= '<td>'.$row_msg_contatos["ValorAcesso"].'</td>';
			$html .= '<td>'.$row_msg_contatos["ValorAssistencia"].'</td>';
			//$data = date('d/m/Y H:i:s',strtotime($row_msg_contatos["created"]));
			//$html .= '<td>'.$data.'</td>';
			$html .= '</tr>';
			;
		}
		// Configurações header para forçar o download
		header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
		header ("Cache-Control: no-cache, must-revalidate");
		header ("Pragma: no-cache");
		header ("Content-type: application/x-msexcel");
		header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
		header ("Content-Description: PHP Generated Data" );
		// Envia o conteúdo do arquivo
		echo $html;
		exit; ?>
	</body>
</html>