<!DOCTYPE html>
	<html lang="pt">
		<head>
			<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
			<meta charset="UTF-8"/>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        // put your code here
        
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            
            
            //collect value of input field
            $name = $_POST["Nome"];
            $Apelido = $_POST["Apelido"];
            $Motorista = $_POST["Motorista"];
            $Data = $_POST["Data"];
            $Transporte = $_POST["Transporte"];
            $Embarque = $_POST["Embarque"];
            $SonilsAcesso = $_POST["SonilsAcesso"];
            $Capitania = $_POST["Capitania"];
            $Desembarque = $_POST["Desembarque"];
            $Proveniencia = $_POST["Proveniencia"];
            $Destino = $_POST["Destino"];
            $Navio = $_POST["Navio"];
            $Descricao = $_POST["Descricao"];
            $Hora = $_POST["Hora"];
            $Voo = $_POST["Voo"];
            $ValorTransporte = $_POST["ValorTransporte"];
            $Terceiro = $_POST["Terceiro"];
            $Trackingnumber = $_POST["Trackingnumber"];
            $ValorCapitania = $_POST["ValorCapitania"];
            $ValorEmbarque = $_POST["ValorEmbarque"];
            $ValorDesembarque = $_POST["ValorDesembarque"];
            $ValorAcesso = $_POST["ValorAcesso"];
            $assisgate = $_POST["assisgate"];
          
            if(empty($name)){
                   
                echo "Name is empty !!!";
            }else{
                
                //Connect to Database
                $servername = "p3nlmysql183plsk.secureserver.net:3306";
	            $username = "ugeral";
	            $password = "meualmir1";
	            $dbname = "geral";
                
                
                try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                   
                   $stmt = $conn->prepare("INSERT INTO `meetpartida`(`Nome`, `Apelido`,`Motorista`, `Data`, `Transporte`, `Embarques`, `SonilsAcesso`, `Capitania`, `Desembarques`, `Proveniencia`, `Destino`, `Navio`, `Descricao`,`Hora`,`Voo`, `ValorTransporte`, `Terceiro`, `Trackingnumber`, `ValorCapitania`, `ValorEmbarque`, `ValorDesembarque`, `ValorAcesso`, `assisgate`) VALUES ('$name', '$Apelido', '$Motorista', '$Data', '$Transporte', '$Embarque', '$SonilsAcesso', '$Capitania', '$Desembarque', '$Proveniencia','$Destino', '$Navio', '$Descricao', '$Hora', '$Voo', '$ValorTransporte', '$Terceiro', '$Trackingnumber', '$ValorCapitania', '$ValorEmbarque', '$ValorDesembarque', '$ValorAcesso', '$assisgate')"); 
                   
                  
                    $stmt->execute();

                    
                    }
                catch(PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            $conn = null;
            }
        }

        ?>
    </body>
</html>
