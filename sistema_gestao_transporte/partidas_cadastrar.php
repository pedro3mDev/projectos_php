<?php
include_once("conexao.php");
session_start();

$id = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : 0;
$percorre = array('login' => 'Visitante');
if($id){
    $selecao = "SELECT * FROM admin_usuarios WHERE id='$id'";
    $acessar = mysqli_query($conexao, $selecao);
    if($acessar) $percorre = mysqli_fetch_array($acessar);
}
?>
<!--?php
    include_once("conexao.php");
    session_start();
    $id = $_SESSION['id_usuario'];
    $selecao = "SELECT * FROM admin_usuarios WHERE id='$id'";
    $acessar = mysqli_query($conexao, $selecao);
    $percorre = mysqli_fetch_array($acessar);
?-->

<!DOCTYPE html> 
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Formulario de Chegadas</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="chegadas_cadastrar.css">
</head>
<body onload='get_client_list()'>

    <?php 
        include_once("st_cabecalho.php");
    ?>
    <div class="form-wrapper">
        <!-- Formulario de lançamentos dos serviços-->
        <form action="#" method="POST" onsubmit="norefresh_form(); return false" class="form-horizontal">

            <fieldset>
                <legend><h3 class="text-danger">Formulário de Partidas</h3></legend>
                
                <div class="panel-body">
                
                    <!-- Linha 1: Nome / Apelido / Serviços -->
                    <div class="row g-2 align-items-center">
                        <div class="col-md-3">
                            <label for="prependedtext">Nome <h11>*</h11></label>  
                            <input id="Nome" name="Nome" placeholder="" class="form-control input-md" required="" type="text">
                        </div>
                        <div class="col-md-3">
                            <label for="prependedtext">Apelido <h11>*</h11></label>  
                            <input id="Apelido" name="Apelido" placeholder="" class="form-control input-md" required="" type="text">
                        </div>
                    </div>

                    <!-- Linha 2: Motorista / Data / Transporte valor / Capitania valor / Assistencia -->
                    <div class="row g-2">
                        <div class="col-md-3">
                            <label for="Nome">Motorista <h11>*</h11></label>  
                            <input id="Motorista" name="Motorista" placeholder="Driver" class="form-control input-md" required="" type="text" maxlength="20">
                        </div>
                        <div class="col-md-3">
                            <label for="Nome">Data<h11>*</h11></label>  
                            <input id="Data" name="Data" placeholder="Data de Chegada" class="form-control input-md" required="" type="Date" maxlength="10" OnKeyPress="formatar('##/##/####', this)" onBlur="showhide()">
                        </div>
                        <div class="col-md-3">
                            <label for="prependedtext">Transporte</label>
                            <select type="number"  required id="ValorTransporte" name="ValorTransporte" class="form-control" required="">
                                <option value="0">Valor</option>
                                <option value="9.000">Gate</option>
                                <option value="12.000">GH Centro</option>
                                <option value="12.000">Aeroporto</option>
                                <option value="14.000">GH ABS Ilha</option>
                                <option value="25.000">Casa</option>
                                <option value="25.000">Talatona</option>
                                <option value="25.000">Centralidade</option>
                                <option value="95.000">Hiace</option>
                                <option value="145.000">BUS</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="prependedtext">Capitania</label>
                            <select type="number"  required id="ValorCapitania" name="ValorCapitania" class="form-control">
                                <option value="0">Valor</option>
                                <option value="12.000">Capitania</option>
                            </select>
                        </div>
                        
                    </div>
                      
                    <!-- Linha 3: Proveniencia / Destino / Sonils Des / SME Embarque -->
                    <div class="row g-2">
                        <div class="col-md-3">
                            <label for="prependedtext">Assistencia</label>
                            <select type="number"  required id="assisgate" name="assisgate" class="form-control">
                                <option value="0">Valor</option>
                                <option value="3.000">Assistencia</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="prependedtext">Proveniencia <h11>*</h11></label>
                            <input id="Proveniencia" name="Proveniencia" class="form-control" placeholder="From..." required="" type="text">
                        </div>
                         <div class="col-md-3">
                            <label for="prependedtext">Destino<h11>*</h11></label>
                            <input id="Destino" name="Destino" class="form-control" placeholder="To..." required="" type="text">
                        </div>
                        <div class="col-md-3">
                            <label for="prependedtext">Sonils Des</label>
                            <select type="number"  required id="ValorAssistencia" name="ValorAssistencia" class="form-control">
                                <option value="0">Valor</option>
                                <option value="17.000">Acesso Des</option>
                            </select>
                        </div> 
                    </div>
                    
                    <!-- Linha 4: Descrição / SME Desemb / Sonils Emb -->
                    <div class="row g-2">
                        <div class="col-md-3">
                            <label for="prependedtext">SME Embarque</label>
                            <select type="number"  required id="ValorEmbarque" name="ValorEmbarque" class="form-control">
                                <option value="0">Valor</option>
                                <option value="12.000">SME Emb</option>
                            </select>
                        </div> 
                        <div class="col-md-3">
                            <label for="prependedtext">Descrição</label>
                            <input id="Descricao" name="Descricao" class="form-control" placeholder="Remark" type="text">
                        </div> 
                        <div class="col-md-3">
                            <label for="prependedtext">SME Desemb</label>
                            <select type="number"  required id="ValorDesembarque" name="ValorDesembarque" class="form-control">
                                <option value="0">Valor</option>
                                <option value="12.000">SME Des</option>
                            </select>
                        </div> 
                        <div class="col-md-3">
                            <label for="prependedtext">Sonils Emb</label>
                            <select type="number"  required id="ValorAcesso" name="ValorAcesso" class="form-control">
                                <option value="0">Valor</option>
                                <option value="17.000">Sonils Emb</option>
                            </select>
                        </div> 
                    </div>

                     <!-- Linha 5: Hora / Voo / Navio -->
                    <div class="row g-2">
                        <div class="col-md-3">
                            <label for="Tempo">Hora <h11>*</h11></label>
                            <input id="Hora" name="Hora" placeholder="Arriva Time" class="form-control input-md" required="" value="" type="time"maxlength="8" pattern="[00H00]">
                        </div>
                        <div class="col-md-3">
                            <label for="Aviao">Voo <h11>*</h11></label>
                            <select required id="Voo" name="Voo" class="form-control">
                                <option value="AF">AF</option>
                                <option value="QR">QR</option>
                                <option value="KLM">KLM</option>
                                <option value="RAM">RAM</option>
                                <option value="LH">LH</option>
                                <option value="EK">EK</option>
                                <option value="BA">BA</option>
                                <option value="DT">DT</option>
                                <option value="ET">ET</option>
                                <option value="SA">SA</option>
                                <option value="TP">TP</option>
                                <option value="Car Hire">Car Hire</option>
                                <option value="Transporte">Transporte</option>
                                <option value="OnShore">OnShore</option>
                                <option value="OffShore">OffShore</option>
                                <option value="RT">RT</option>
                                <option value="Domesticos">Domesticos</option>
                                <option value="Internacional">Internacional</option>
                                <option value="Surfer">Surfer</option>
                                <option value="Defender">Defender</option>
                                <option value="Reliance">Reliance</option>
                                <option value="Chopper">Chopper</option>
                            </select>
                        </div> 
                        <div class="col-md-3">
                            <label class="col-md-1 control-label" for="prependedtext">Navio</label>
                            <input id="Navio" name="Navio" class="form-control" placeholder="Navio..." type="text">
                        </div> 
                        <div class="col-md-3">
                            <label class="col-md-1 control-label" for="selectbasic">Terceiro</label>
                            <select  id="Terceiro" name="Terceiro" class="form-control">
                            </select>
                        </div> 
                    </div>

                    <div class="row g-2">
                        <div class="col-md-3">
                            <label class="col-md-1 control-label" for="Referencia">Tracking</label>  
                            <input id="Trackingnumber" name="Trackingnumber" type="text" placeholder="" class="form-control input-md">
                        </div> 
                        <div class="col-md-3">
                        </div> 
                        <div class="col-md-3">
                        </div> 
                        <div class="col-md-3">
                        </div> 
                    </div>

                    <div class="row g-2">
                        <div class="col-md-9">
                        </div>
                        <div class="col-md-3 d-flex gap-2">
                            <button id="Listar" name="Listar" class="btn btn-success" type="Listar"><i class="fa fa-paper-plane"></i> Enviar</button>
                        </div>
                    </div>

                    <!-- ====================== LISTA TOP 10 CHEGADAS (TEMA ESCURO) ====================== -->
                    <div class="container" style="margin-top:40px; max-width:1100px;">
                        <div class="card shadow-sm border-0" style="border-radius:12px; background:#1e1e2f; color:#eaeaea;">
                            <div class="card-header text-white" style="background:linear-gradient(90deg, #FF4D4D, #FF4D4D); border-radius:0px;">
                                <h4 class="text-center mb-0">
                                    <i class="fa fa-plane-arrival"></i> Chegadas Recentes
                                </h4>
                            </div>
                            <div class="card-body p-4">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0" style="color:#eaeaea;">
                                        <thead style="background:#2a2a40; color:#00aaff; font-weight:600;">
                                            <tr>
                                                <th class="text-success" style="width:50px;">#</th>
                                                <th class="text-success"><i class="fa fa-user text-success"></i> Nome</th>
                                                <th class="text-success"><i class="fa fa-user-tag text-success"></i> Apelido</th>
                                                <th class="text-success"><i class="fa fa-calendar text-success"></i> Data</th>
                                                <th class="text-success"><i class="fa fa-clock text-success"></i> Hora</th>
                                                <th class="text-success"><i class="fa fa-id-card text-success"></i> Motorista</th>
                                                <th class="text-success"><i class="fa fa-map-marker-alt text-success"></i> Destino</th>
                                            </tr>
                                        </thead>
                                        <tbody style="font-size:15px;">
                                            <?php
                                            $sql = "SELECT Nome, Apelido, Data, Hora, Motorista, Destino 
                                                    FROM  meetpartida
                                                    ORDER BY id DESC 
                                                    LIMIT 10";
                                            $resultado = mysqli_query($conexao, $sql);

                                            if ($resultado && mysqli_num_rows($resultado) > 0) {
                                                $contador = 1;
                                                while ($linha = mysqli_fetch_assoc($resultado)) {
                                                    echo '<tr style="transition:background 0.2s; cursor:pointer;">';
                                                    echo '<td><span class="badge bg-primary" style="font-size:13px; padding:6px 10px; border-radius:8px;">' . $contador . '</span></td>';
                                                    echo '<td><strong>' . htmlspecialchars($linha['Nome']) . '</strong></td>';
                                                    echo '<td>' . htmlspecialchars($linha['Apelido']) . '</td>';
                                                    echo '<td><i class="fa fa-calendar-day text-secondary"></i> ' . htmlspecialchars($linha['Data']) . '</td>';
                                                    echo '<td><i class="fa fa-clock text-secondary"></i> ' . htmlspecialchars($linha['Hora']) . '</td>';
                                                    echo '<td>' . htmlspecialchars($linha['Motorista']) . '</td>';
                                                    echo '<td><i class="fa fa-location-dot text-success"></i> ' . htmlspecialchars($linha['Destino']) . '</td>';
                                                    echo '</tr>';
                                                    $contador++;
                                                }
                                            } else {
                                                echo "<tr><td colspan='7' class='text-center text-muted py-3'><i class='fa fa-info-circle'></i> Nenhuma chegada registada ainda.</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <style>
                    /* === Tema escuro elegante para lista de chegadas === */
                    body {
                        background-color: #12121c;
                        color: #eaeaea;
                        font-family: 'Segoe UI', sans-serif;
                    }

                    .card {
                        box-shadow: 0 4px 20px rgba(0,0,0,0.3);
                        transition: all 0.2s ease-in-out;
                    }
                    .card:hover {
                        box-shadow: 0 6px 25px rgba(0,0,0,0.4);
                    }

                    .table {
                        border-collapse: separate;
                        border-spacing: 0 8px;
                    }
                    .table thead tr th {
                        border: none !important;
                        text-transform: uppercase;
                        font-size: 13px;
                        letter-spacing: 0.5px;
                    }
                    .table tbody tr {
                        background: #2a2a40;
                        border-radius: 10px;
                    }
                    .table tbody tr:hover {
                        background: #343454 !important;
                        transform: scale(1.01);
                    }
                    .table td, .table th {
                        border: none !important;
                        vertical-align: middle !important;
                    }

                    .badge {
                        font-size: 13px;
                        padding: 6px 10px;
                        border-radius: 8px;
                    }

                    .text-info {
                        color: #00aaff !important;
                    }
                    .text-success {
                        color: #FF4D4D !important;
                    }
                    </style>        

                </div>
                </div>

            </fieldset>
        </form>
        </div>

        <div id="snackbar">  Adicionado as PARTIDAS</div><br>

        <script>
            function get_client_list() {

                var xhttp;
                if (window.XMLHttpRequest) {
                    // code for modern browsers
                    xhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    xhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xhttp.onreadystatechange = function () {
                    if (this.readyState === 4 && this.status === 200) {
                        document.getElementById("Terceiro").innerHTML = this.responseText;
                    }
                };
                xhttp.open("GET", "lista_terceiros.php", true);
                xhttp.send();
            }

        </script>


        <script>
            function norefresh_form() {
                //read input
                var dados_Nome = document.getElementById("Nome").value;
                var dados_Apelido = document.getElementById("Apelido").value;
                var dados_Motorista = document.getElementById("Motorista").value;
                var dados_Data = document.getElementById("Data").value;
                var dados_Transporte = document.getElementById("Transporte").value;
                var dados_Embarque = document.getElementById("Embarque").value;
                var dados_SonilsAcesso = document.getElementById("SonilsAcesso").value;
                var dados_Capitania = document.getElementById("Capitania").value;
                var dados_Desembarque = document.getElementById("Desembarque").value;
                var dados_Proveniencia = document.getElementById("Proveniencia").value;
                var dados_Destino = document.getElementById("Destino").value;
                var dados_Navio = document.getElementById("Navio").value;
                var dados_Descricao = document.getElementById("Descricao").value;
                var dados_Hora = document.getElementById("Hora").value;
                var dados_Voo = document.getElementById("Voo").value;
                var dados_ValorTransporte = document.getElementById("ValorTransporte").value;
                var dados_Terceiro = document.getElementById("Terceiro").value;
                var dados_Trackingnumber = document.getElementById("Trackingnumber").value;
                var dados_ValorCapitania = document.getElementById("ValorCapitania").value;
                var dados_ValorEmbarque = document.getElementById("ValorEmbarque").value;
                var dados_ValorDesembarque = document.getElementById("ValorDesembarque").value;
                var dados_ValorAcesso = document.getElementById("ValorAcesso").value;
                var dados_assisgate = document.getElementById("assisgate").value;
               

                //delete input
               document.getElementById("Nome").value = "";
                document.getElementById("Apelido").value = "";
                document.getElementById("Motorista").value = "";
               document.getElementById("Data").value = "";
               document.getElementById("Transporte").value = "";
               document.getElementById("Embarque").value = "";
               document.getElementById("SonilsAcesso").value = "";
               document.getElementById("Capitania").value = "";
               document.getElementById("Desembarque").value = "";
               document.getElementById("Proveniencia").value = "";
               document.getElementById("Destino").value = "";
               document.getElementById("Navio").value = "";
               document.getElementById("Descricao").value = "";
               document.getElementById("Hora").value = "";
               document.getElementById("Voo").value = "";
                document.getElementById("ValorTransporte").value = "";
               document.getElementById("Terceiro").value = "";
                document.getElementById("Trackingnumber").value = "";
                document.getElementById("ValorCapitania").value = "";
                document.getElementById("ValorEmbarque").value = "";
                document.getElementById("ValorDesembarque").value = "";
                document.getElementById("ValorAcesso").value = "";
                document.getElementById("assisgate").value = "";




                //display read input
                //document.getElementById("output").innerHTML = dados_in;
                    
                var param = "Nome=" + dados_Nome + "&Apelido=" + dados_Apelido+ "&Motorista=" + dados_Motorista + "&Data=" + dados_Data+ "&Transporte=" + dados_Transporte + "&Embarque=" + dados_Embarque + "&SonilsAcesso=" + dados_SonilsAcesso + "&Capitania=" + dados_Capitania + "&Desembarque=" + dados_Desembarque + "&Proveniencia=" + dados_Proveniencia + "&Destino=" + dados_Destino + "&Navio=" + dados_Navio + "&Descricao=" + dados_Descricao+ "&Hora=" + dados_Hora + "&Voo=" + dados_Voo + "&ValorTransporte=" + dados_ValorTransporte + "&Terceiro=" + dados_Terceiro + "&Trackingnumber=" + dados_Trackingnumber + "&ValorCapitania=" + dados_ValorCapitania + "&ValorEmbarque=" + dados_ValorEmbarque+ "&ValorDesembarque=" + dados_ValorDesembarque + "&ValorAcesso=" + dados_ValorAcesso + "&assisgate=" + dados_assisgate;



                //AJAX Operation to the database
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState === 4 && this.status === 200) {
                        //document.getElementById("output").innerHTML = this.responseText;
                        //document.getElementById("output").innerHTML = "Base de Dados Actualizada com SUCESSO !!!";

                        var x = document.getElementById("snackbar");
                        x.className = "show";
                        setTimeout(function () {
                            x.className = x.className.replace("show", "");
                        }, 3000);
                    }
                };
                xhttp.open("POST", "Processador_Partidas.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send(param);
            }
        </script>

        
    </body>
</html>

