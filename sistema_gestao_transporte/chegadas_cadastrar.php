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
<body onload="get_client_list()">

    <?php 
        include_once("st_cabecalho.php");
    ?>

    <div class="form-wrapper">
        <form id="chegadasForm" class="form-horizontal" onsubmit="norefresh_form(); return false;">
            <fieldset>
                <legend><h3 class="text-success">Formulário de Chegadas</h3></legend>

                <div class="panel-body">

                    <!-- Linha 1: Nome / Apelido / Serviços -->
                    <div class="row g-2 align-items-center">
                        <div class="col-md-3">
                            <label for="Nome" class="form-label mb-0">Nome <span style="color:var(--accent)">*</span></label>
                            <input id="Nome" name="Nome" class="form-control form-control-sm" required type="text">
                        </div>
                        <div class="col-md-3">
                            <label for="Apelido" class="form-label mb-0">Apelido <span style="color:var(--accent)">*</span></label>
                            <input id="Apelido" name="Apelido" class="form-control form-control-sm" required type="text">
                        </div>
                    </div>


                    <!-- Linha 2: Motorista / Data / Transporte valor / Capitania valor / Assistencia -->
                    <div class="row g-2">
                        <div class="col-md-3">
                            <label>Motorista <span style="color:var(--accent)">*</span></label>
                            <input id="Motorista" name="Motorista" class="form-control" required type="text" maxlength="20" placeholder="Driver">
                        </div>
                        <div class="col-md-3">
                            <label>Data <span style="color:var(--accent)">*</span></label>
                            <input id="Data" name="Data" class="form-control" required type="date">
                        </div>
                        <div class="col-md-3">
                            <label>Transporte</label>
                            <select id="ValorTransporte" name="ValorTransporte" class="form-control">
                                <option value="0">Valor</option>
                                <option value="9000">Gate (9.000)</option>
                                <option value="12000">GH Centro (12.000)</option>
                                <option value="12000">Aeroporto (12.000)</option>
                                <option value="14000">GH ABS Ilha (14.000)</option>
                                <option value="25000">Casa/Talatona/Centralidade (25.000)</option>
                                <option value="95000">Hiace (95.000)</option>
                                <option value="145000">BUS (145.000)</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Capitania</label>
                            <select id="ValorCapitania" name="ValorCapitania" class="form-control">
                                <option value="0">Valor</option>
                                <option value="12000">Capitania (12.000)</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Linha 3: Proveniencia / Destino / Sonils Des / SME Embarque -->
                    <div class="row g-2">
                        <div class="col-md-3">
                            <label>Assistência</label>
                            <select id="assisgate" name="assisgate" class="form-control">
                                <option value="0">Valor</option>
                                <option value="3000">Assistência (3.000)</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Proveniência <span style="color:var(--accent)">*</span></label>
                            <input id="Proveniencia" name="Proveniencia" class="form-control" placeholder="From..." required type="text">
                        </div>
                        <div class="col-md-3">
                            <label>Destino <span style="color:var(--accent)">*</span></label>
                            <input id="Destino" name="Destino" class="form-control" placeholder="To..." required type="text">
                        </div>
                        <div class="col-md-3">
                            <label>Sonils Des</label>
                            <select id="ValorAssistencia" name="ValorAssistencia" class="form-control">
                                <option value="0">Valor</option>
                                <option value="17000">Acesso Des (17.000)</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Linha 4: Descrição / SME Desemb / Sonils Emb -->
                    <div class="row g-2">
                        <div class="col-md-3">
                            <label>SME Embarque</label>
                            <select id="ValorEmbarque" name="ValorEmbarque" class="form-control">
                                <option value="0">Valor</option>
                                <option value="12000">SME Embarque (12.000)</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Descrição</label>
                            <input id="Descricao" name="Descricao" class="form-control" placeholder="Remark" type="text">                            
                        </div>
                        <div class="col-md-3">
                            <label >SME Desemb</label>
                            <select id="ValorDesembarque" name="ValorDesembarque" class="form-control">
                                <option value="0">Valor</option>
                                <option value="12000">SME Des (12.000)</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Sonils Emb</label>
                            <select id="ValorAcesso" name="ValorAcesso" class="form-control">
                                <option value="0">Valor</option>
                                <option value="17000">Sonils Emb (17.000)</option>
                            </select>
                        </div>
                    </div>
                        
                    <!-- Linha 5: Hora / Voo / Navio -->
                    <div class="row g-2">
                        <div class="col-md-3">
                            <label>Hora <span style="color:var(--accent)">*</span></label>
                            <input id="Hora" name="Hora" class="form-control" required type="time">
                        </div>
                        <div class="col-md-3">
                            <label>Voo <span style="color:var(--accent)">*</span></label>
                            <select id="Voo" name="Voo" class="form-control" required>
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
                            <label>Navio</label>
                            <input id="Navio" name="Navio" class="form-control" placeholder="Navio..." type="text">
                        </div>
                        <div class="col-md-3">
                            <label>Terceiro <span style="color:var(--accent)">*</span></label>
                            <select id="Terceiro" name="Terceiro" class="form-control">
                                <!--preenchido por AJAX get_client_list() -->
                            </select>
                        </div>
                    </div>

                    <!-- Linha 6: Terceiro / Tracking -->
                    <div class="row g-2">
                        <div class="col-md-3">
                            <label>Tracking</label>
                            <input id="Trackingnumber" name="Trackingnumber" class="form-control" type="text" placeholder="">
                        </div>
                        <div class="col-md-5">
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-md-9">
                        </div>
                        <div class="col-md-3 d-flex gap-2">
                            <!--button id="Cancelar" name="Cancelar" class="btn btn-danger" type="reset" title="Cancelar">
                                <i class="fa fa-times-circle"></i>
                            </button>
                            <a class="btn" href="altera_chegada.php" title="Editar" style="background-color:#007bff; color:white;">
                                <i class="fa fa-edit"></i>
                            </a-->
                            <button id="Listar" name="Listar" class="btn btn-success" type="submit" title="Enviar">
                                <i class="fa fa-paper-plane"></i> Enviar
                            </button>
                        </div>
                    </div>

                    <!-- ====================== LISTA TOP 10 CHEGADAS (TEMA ESCURO) ====================== -->
                    <div class="container" style="margin-top:40px; max-width:1100px;">
                        <div class="card shadow-sm border-0" style="border-radius:12px; background:#1e1e2f; color:#eaeaea;">
                            <div class="card-header text-white" style="background:linear-gradient(90deg, #1ed760, #1ed760); border-radius:0px;">
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
                                                    FROM meetchegadas 
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
                        color: #1ed760 !important;
                    }
                    </style>


                </div>
            </fieldset>
        </form>
    </div>
    
    <div id="snackbar">Adicionado as CHEGADAS</div>

    <?php
        include_once("chegadas_cadastrar_script.php");
    ?>

    

</body>
</html>
