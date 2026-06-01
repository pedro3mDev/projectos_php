<?php
include_once("conexao.php");
session_start();

$id = $_SESSION['id_usuario'];
$selecao = "SELECT * FROM admin_usuarios WHERE id='$id'";
$acessar = mysqli_query($conexao, $selecao);
$percorre = mysqli_fetch_array($acessar);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu de Consultas</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --bg-dark: #0d1b2a;
            --panel-dark: #1b263b;
            --accent: #f1c40f;
            --muted: #bfc7d6;
            --input-bg: #2e3440;
        }

        body {
            margin: 0;
            font-family: "Segoe UI", Arial, sans-serif;
            background: linear-gradient(180deg, #0f1724 0%, #0b1220 60%);
            color: #e6eef8;
        }

        /* Top welcome bar */
        .welcome {
            background: var(--bg-dark);
            padding: 10px 20px;
            border-bottom: 3px solid var(--accent);
            color: #fff;
        }
        .welcome h3 {
            margin: 0;
            font-weight: 600;
            font-size: 16px;
            color: var(--accent);
        }
        .welcome a {
            color: #fff;
            text-decoration: none;
            float: right;
        }
        .welcome a:hover {
            color: var(--accent);
        }

        /* Menu horizontal */
        .div_menu {
            background: var(--panel-dark);
            box-shadow: 0 6px 18px rgba(0,0,0,0.45);
        }
        .div_menu ul {
            margin: 0;
            padding: 6px 14px;
            list-style: none;
            display: flex;
            flex-wrap: wrap;
        }
        .div_menu ul li {
            position: relative;
        }
        .div_menu ul li a, .dropbtn {
            display: inline-block;
            color: var(--muted);
            padding: 10px 14px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s;
        }
        .div_menu ul li a:hover, .div_menu ul li:hover > a {
            color: #fff;
            background: rgba(255,255,255,0.05);
            border-radius: 6px;
        }

        /* Dropdown content */
        .dropdown_menu-content {
            display: none;
            position: absolute;
            background: var(--bg-dark);
            min-width: 220px;
            z-index: 200;
            border-radius: 6px;
            top: 42px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.6);
        }
        .dropdown_menu-content a {
            color: var(--muted);
            padding: 10px 14px;
            display: block;
            text-decoration: none;
        }
        .dropdown_menu-content a:hover {
            background: rgba(255,255,255,0.03);
            color: #fff;
        }
        .dropdown_menu:hover .dropdown_menu-content {
            display: block;
        }

        /* Search box in menu */
        .pesquisar input {
            background: var(--input-bg);
            border: 1px solid #444;
            color: #fff;
            padding: 6px 8px;
            border-radius: 4px;
        }
        .pesquisar .button {
            background: var(--accent);
            color: #000;
            border: none;
            padding: 6px 10px;
            border-radius: 4px;
            font-weight: 700;
        }

        /* Form panels */
        fieldset {
            background: linear-gradient(180deg, rgba(255,255,255,0.03), rgba(255,255,255,0.02));
            border-radius: 12px;
            padding: 20px;
            margin: 20px;
            box-shadow: 0 14px 40px rgba(0,0,0,0.6);
            border: 1px solid rgba(255,255,255,0.03);
        }
        legend h3 {
            color: var(--accent);
            margin: 0;
            font-weight: 700;
        }
        .form-control {
            background: var(--input-bg);
            color: #fff;
            border: 1px solid #3b3f45;
            border-radius: 4px;
            box-shadow: none;
        }
        .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 8px rgba(241,196,15,0.12);
        }
        .btn {
            border-radius: 6px;
            font-weight: 700;
            padding: 8px 14px;
        }
        .btn-success {
            background: #16a085;
            color: #fff;
            border: none;
        }
        .btn-success:hover {
            background: #13806c;
        }
        .btn-warning {
            background: #f39c12;
            border: none;
            color: #000;
        }
        .btn-warning:hover {
            background: #d48806;
        }

        /* Snackbar */
        #snackbar {
            visibility: hidden;
            min-width: 250px;
            background: rgba(23, 23, 23, 0.95);
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 12px 18px;
            position: fixed;
            left: 50%;
            transform: translateX(-50%);
            bottom: 30px;
            z-index: 9999;
            border-left: 6px solid var(--accent);
        }
        #snackbar.show {
            visibility: visible;
            animation: fadein 0.2s, fadeout 0.2s 2.8s;
        }
        @keyframes fadein { from {bottom:0;opacity:0;} to {bottom:30px;opacity:1;} }
        @keyframes fadeout { from {bottom:30px;opacity:1;} to {bottom:0;opacity:0;} }

        /* Responsive tweaks */
        @media (max-width: 992px){
            .div_menu ul { justify-content: center; }
            .dropdown_menu-content { position: relative; top: 0; }
        }
        @media (max-width:768px){
            .div_menu ul { flex-direction: column; align-items: stretch; }
            .pesquisar { order: 999; margin-top: 8px; }
        }

        .form-inline { display:flex; flex-wrap:wrap; align-items:center; margin-bottom:10px; gap:10px; }
    </style>
</head>
<body onload="get_client_list()">
    <?php
        include_once("st_menu.php");
    ?>

    
<!-- Adiciona o Font Awesome no <head> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<!-- Formulários de consulta -->
<fieldset class="p-3 border rounded">
    <legend><h3 class="text-light">Consultas Rápidas</h3></legend>

    <div class="row g-3">
        
        <div class="col-md-4 col-lg-3">
            <form action="Consulta_Nome_Pax.php" method="POST" class="d-flex align-items-center">
                <label>Nome</label>
                <input name="Primeiro" placeholder="Nome" class="form-control" required>
                <button class="btn btn-success" title="Procurar"><i class="fa fa-search"></i></button>
            </form>
        </div>

        
        <div class="col-md-4 col-lg-3">
            <form action="Consulta_Apelido_Pax.php" method="POST" class="d-flex align-items-center">
                <label>Sobrenome</label>
                <input name="Lastname" placeholder="Apelido" class="form-control" required>
                <button class="btn btn-success" title="Procurar"><i class="fa fa-search"></i></button>
            </form>
        </div>

        <!-- Data Chegada -->
        <div class="col-md-4 col-lg-3">
            <form action="Consulta_Data_Chegada.php" method="POST" class="d-flex align-items-center">
                <label>Data Chegada</label>
                <input name="Chegadas" type="date" class="form-control" required>
                <button class="btn btn-success" title="Procurar"><i class="fa fa-search"></i></button>
            </form>
        </div>

        <!-- Data Hoje -->
        <div class="col-md-4 col-lg-3">
            <form action="Consulta_Data_Hoje.php" method="POST" class="d-flex align-items-center">
                <label>Data Hoje</label>
                <input name="DataHoje" type="date" class="form-control" required>
                <button class="btn btn-success" title="Procurar"><i class="fa fa-search"></i></button>
            </form>
        </div>

        <!-- Data Partida -->
        <div class="col-md-4 col-lg-3">
            <form action="Consulta_Data_Partida.php" method="POST" class="d-flex align-items-center">
                <label>Data Partida</label>
                <input name="Partidas" type="date" class="form-control" required>
                <button class="btn btn-success" title="Procurar"><i class="fa fa-search"></i></button>
            </form>
        </div>

        
        <div class="col-md-4 col-lg-3">
            <form action="Consulta_Terceiro.php" method="POST" class="d-flex align-items-center">
                <label>Terceiro</label>
                <input name="Terceiro" placeholder="Terceiro" class="form-control" required>
                <button class="btn btn-success" title="Procurar"><i class="fa fa-search"></i></button>
            </form>
        </div>

         
        <div class="col-md-4 col-lg-3">
            <form action="Consulta_terceiro_data.php" method="POST" class="d-flex align-items-center">
                <label>Data Hoje</label>
                <input name="DataHoje" type="date" class="form-control" required>
                <button class="btn btn-success" title="Procurar"><i class="fa fa-search"></i></button>
            </form>
        </div>
    </div>

    <!-- Botões adicionais -->
    <div class="row mt-4">
        <div class="col-md-4 col-lg-9">
        </div>
        <div class="col-md-4 col-lg-3">
            <a href="altera_chegada.php" class="btn btn-warning btn-sm">Editar Chegadas</a>
        
            <a href="altera_partida.php" class="btn btn-danger btn-sm">Editar Partidas</a>
        
            <a href="./gerar_excel/listar_contato.php" class="btn btn-success btn-sm">Gerar Excel</a>
        </div>
    </div>
</fieldset>

    <script>
        function get_client_list() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if(this.readyState === 4 && this.status === 200){
                    document.getElementById("Terceiro").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "lista_terceiros.php", true);
            xhttp.send();
        }
    </script>

</body>
</html>
