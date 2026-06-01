<?php
    include_once("conexao.php"); 
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <title>Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="dashboard.css">
    <?php include_once("st_links.php"); ?>
</head>

<body>
    <?php include_once("st_sidebar.php"); ?>
    
    <div class="main--content">
        
        <nav class="breadcrumb mb-3">
            <a href="index.php">Início</a>
            <span class="separator">›</span>
            <span class="current">Dashboard</span>
        </nav>

        <h3 class="main--title">FATURAÇÃO MENSAL</h3>

        <div class="row g-4 flex-nowrap overflow-auto pb-3">

        <?php include_once("dashboard_cards.php"); ?>     

        <?php include_once("dashboard_graficos.php"); ?>  
        
        <?php include_once("dashboard_scripts.php"); ?>


    </div>

</body>
</html>
