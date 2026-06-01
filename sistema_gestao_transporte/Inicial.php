<?php
include_once("../conexao.php");
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Painel Inicial | OM Angola</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
    :root{
        --bg-dark:#0d1b2a;
        --panel-dark:#1b263b;
        --accent:#f1c40f;
        --muted:#bfc7d6;
        --input-bg:#2e3440;
    }

    body{
        margin:0;
        font-family:"Segoe UI", Arial, sans-serif;
        background:linear-gradient(180deg,#0f1724 0%, #0b1220 60%);
        color:#e6eef8;
    }

    /* Top bar */
    .welcome{
        background:var(--bg-dark);
        padding:12px 24px;
        border-bottom:3px solid var(--accent);
        color:#fff;
    }
    .welcome h3{
        margin:0; font-weight:600; color:var(--accent); font-size:16px;
    }
    .welcome a{color:#fff;text-decoration:none;}
    .welcome a:hover{color:var(--accent);text-decoration:underline;}

    /* Navigation */
    .div_menu{
        background:var(--panel-dark);
        box-shadow:0 6px 18px rgba(0,0,0,0.45);
    }
    .div_menu ul{
        margin:0; padding:6px 14px; list-style:none; display:flex; flex-wrap:wrap;
    }
    .div_menu ul li{
        position:relative;
    }
    .div_menu ul li a, .dropbtn{
        display:inline-block;
        color:var(--muted);
        padding:10px 14px;
        text-decoration:none;
        transition:all .18s;
        font-weight:600;
    }
    .div_menu ul li a:hover, .div_menu ul li:hover > a{
        color:#fff;
        background:rgba(255,255,255,0.05);
        border-radius:6px;
    }

    /* Dropdown */
    .dropdown_menu-content{
        display:none;
        position:absolute;
        background:#0f1724;
        min-width:220px;
        z-index:200;
        border-radius:6px;
        top:42px;
        box-shadow:0 12px 30px rgba(0,0,0,0.6);
    }
    .dropdown_menu-content a{
        color:var(--muted);
        padding:10px 14px;
        display:block;
        text-decoration:none;
    }
    .dropdown_menu-content a:hover{
        background:rgba(255,255,255,0.05);
        color:#fff;
    }
    .dropdown_menu:hover .dropdown_menu-content{display:block;}

    /* Search */
    .pesquisar{margin-left:auto; display:flex; align-items:center;}
    .pesquisar input{
        background:var(--input-bg);
        border:1px solid #444;
        color:#fff;
        padding:6px 8px;
        border-radius:4px;
        margin-right:6px;
    }
    .pesquisar .button{
        background:var(--accent);
        color:#000;
        border:none;
        padding:6px 10px;
        border-radius:4px;
        font-weight:700;
    }

    /* Content area */
    .content{
        max-width:1100px;
        margin:30px auto;
        background:rgba(255,255,255,0.03);
        border-radius:12px;
        padding:24px;
        border:1px solid rgba(255,255,255,0.03);
        box-shadow:0 14px 40px rgba(0,0,0,0.6);
    }

    .content h2{
        color:var(--accent);
        font-weight:700;
        border-bottom:1px solid rgba(255,255,255,0.08);
        padding-bottom:8px;
        margin-bottom:20px;
    }

    /* Snackbar */
    #snackbar{
        visibility:hidden;
        min-width:250px;
        background:rgba(23,23,23,0.95);
        color:#fff;
        text-align:center;
        border-radius:6px;
        padding:12px 18px;
        position:fixed;
        left:50%;
        transform:translateX(-50%);
        bottom:30px;
        z-index:9999;
        border-left:6px solid var(--accent);
    }
    #snackbar.show{visibility:visible;animation:fadein .2s, fadeout .2s 2.8s;}
    @keyframes fadein{from{bottom:0;opacity:0}to{bottom:30px;opacity:1}}
    @keyframes fadeout{from{bottom:30px;opacity:1}to{bottom:0;opacity:0}}

    @media (max-width:768px){
        .div_menu ul{flex-direction:column;align-items:stretch;}
        .dropdown_menu-content{position:relative;top:0;}
        .pesquisar{margin:8px 0;}
        .welcome h3{text-align:center;}
    }
    </style>
</head>

<body onload='get_client_list()'>

    <?php
        include_once("menu.php");
    ?>
    
    <div class="content">
        <h2>Painel Inicial</h2>
        <p>Versão atual: <strong>2.1.23</strong></p>
        <p><b>30-09-25</b> — Projeto entregue ao <b>Pedro Moniz</b> para ajustes:</p>
        <ul>
            <li>🔸 Alterar login para permitir novos usuários com critérios</li>
            <li>🔸 Personalizar layout</li>
            <li>🔸 Mostrar diferença entre valor de compra e venda</li>
            <li>🔸 Criar formulário de rent-a-car</li>
        </ul>
    </div>

    <div id="snackbar">Operação realizada com sucesso</div>

    <script>
    function get_client_list() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                var el = document.getElementById("Terceiro");
                if(el) el.innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "lista_terceiros.php", true);
        xhttp.send();
    }
    </script>

</body>
</html>
