<?php
//include_once "conn.php";
include_once("../conn.php");
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <title>om</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="modal.css">
</head>

<style>
  </style>

<body onload='get_client_list()'>

    <div class="sidebar">
        <div class="logo"></div>
        <ul class="menu">
            <li class="active">
                <a href="home.php">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="Inicial.php">
                    <i class="fas fa-user"></i>
                    <span>Inicial</span>
                </a>
            </li>

            <li>
                <a href="formulario_Chegada.php">
                    <i class="fas fa-plane-arrival"></i>
                    <span>Chegadas</span>
                </a>
            </li>

            <li>
                <a href="formulario_Partida.php">
                    <i class="fas fa-plane-departure"></i>
                    <span>Partidas</span>
                </a>
            </li>

            <li>
                <a href="Menu_De_Consultas.php">
                    <i class="fas fa-chart-bar"></i>
                    <span>Consultas</span>
                </a>
            </li>
            <li>
                <a href="colcular.php">
                    <i class="fas fa-briefcase"></i>
                    <span>Calcular</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-question-circle"></i>
                    <span>FAQ</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-star"></i>
                    <span>Testimonials</span>
                </a>
            </li>
            <li>
                <a href="painel2.php">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </li>
            <li class="logout">
                <a href="sair.php">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Sair</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="main--content">
        <div class="header--wrapper">
            <div class="header--title">
                <span>Primary</span>
                <h2>Dashboard</h2>
            </div>
            <div class="user--info">
                <div class="search--box">
                    <i class="fa-solid fa-search"></i>
                    <input type="text" placeholder="Search">
                </div>
                <img src="png.png" alt="" />
            </div>
        </div>

        <div class="card--container">
            <h3 class="main--title">FATURAÇÃO MENSAL</h3>
            <div class="card--wrapper">
                <div class="payment--card light-red">
                    <div class="card--header">
                        <div class="amount">
                        <span class="titlle">TRANSPORTE</span><br>
                    <?php        
                        $query_produtos = "SELECT SUM(ValorTransporte) AS qnt_produtos FROM meetchegadas";
                        $result_produtos = $conn->prepare($query_produtos);
                        $result_produtos->execute();
                        $row_produtos = $result_produtos->fetch(PDO::FETCH_ASSOC);
                        echo "" . $row_produtos['qnt_produtos'] . "<br><br>";
                    ?>
                    </div>
                    <i class="fas fa-dollar-sign icon"></i>
                    </div>
                    <span class="card-detail">Viaturas</span>
                </div>

                <div class="payment--card light-purple">
                    <div class="card--header">
                    <div class="amount">
                            <span class="titlle">SME EMBARQUES</span><br>
                    <?php        
                        $query_produtos = "SELECT SUM(ValorEmbarque) AS qnt_produtos FROM meetpartida";
                        $result_produtos = $conn->prepare($query_produtos);
                        $result_produtos->execute();
                        $row_produtos = $result_produtos->fetch(PDO::FETCH_ASSOC);
                        echo "" . $row_produtos['qnt_produtos'] . "<br><br>";
                    ?>
                    </div>
                    <i class="fa-solid fa-anchor icon dark-purple"></i>
                    </div>
                    <span class="card-detail">SME EMBARQUES</span>
                </div>

                <div class="payment--card light-purple">
                    <div class="card--header">
                    <div class="amount">
                            <span class="titlle">SME DESEMBARQUES</span><br>
                    <?php        
                        $query_produtos = "SELECT SUM(ValorDesembarque) AS qnt_produtos FROM meetchegadas";
                        $result_produtos = $conn->prepare($query_produtos);
                        $result_produtos->execute();
                        $row_produtos = $result_produtos->fetch(PDO::FETCH_ASSOC);
                        echo "" . $row_produtos['qnt_produtos'] . "<br><br>";
                    ?>
                    </div>
                    <i class="fa-solid fa-anchor icon dark-purple"></i>
                    </div>
                    <span class="card-detail">SME DESEMBARQUES</span>
                </div>

                <div class="payment--card light-purple">
                    <div class="card--header">
                    <div class="amount">
                            <span class="titlle">SONILS EMBARQUES</span><br>
                    <?php        
                        $query_produtos = "SELECT SUM(ValorAcesso) AS qnt_produtos FROM meetpartida";
                        $result_produtos = $conn->prepare($query_produtos);
                        $result_produtos->execute();
                        $row_produtos = $result_produtos->fetch(PDO::FETCH_ASSOC);
                        echo "" . $row_produtos['qnt_produtos'] . "<br><br>";
                    ?>
                    </div>
                    <i class="fa-solid fa-anchor icon dark-purple"></i>
                    </div>
                    <span class="card-detail">SONINLS EMBARQUES</span>
                </div>

                <div class="payment--card light-purple">
                    <div class="card--header">
                    <div class="amount">
                            <span class="titlle">SONILS DESEMBARQUES</span><br>
                    <?php        
                        $query_produtos = "SELECT SUM(ValorAcesso) AS qnt_produtos FROM meetchegadas";
                        $result_produtos = $conn->prepare($query_produtos);
                        $result_produtos->execute();
                        $row_produtos = $result_produtos->fetch(PDO::FETCH_ASSOC);
                        echo "" . $row_produtos['qnt_produtos'] . "<br><br>";
                    ?>
                    </div>
                    <i class="fa-solid fa-anchor icon dark-purple"></i>
                    </div>
                    <span class="card-detail">SONILS DESEMBARQUES</span>
                </div>

                <div class="payment--card light-purple">
                    <div class="card--header">
                    <div class="amount">
                            <span class="titlle">CAPITANIA</span><br>
                    <?php        
                        $query_produtos = "SELECT SUM(ValorCapitania) AS qnt_produtos FROM meetpartida";
                        $result_produtos = $conn->prepare($query_produtos);
                        $result_produtos->execute();
                        $row_produtos = $result_produtos->fetch(PDO::FETCH_ASSOC);
                        echo "" . $row_produtos['qnt_produtos'] . "<br><br>";
                    ?>
                    </div>
                    <i class="fa-solid fa-anchor icon dark-purple"></i>
                    </div>
                    <span class="card-detail">Capitania IMPA</span>
                </div>

                </div>

                <div>
                <button id="myBtn">Open Modal</button>

                    <!-- The Modal -->
                    <div id="myModal" class="modal">

                    <!-- Modal content -->
                        <div class="modal-content">
                    <span class="close">&times;</span>
                    <p>Some text in the Mod .</p>
                </div>

                </div>

                </div>

               
<button onclick="document.getElementById('id01').style.display='block'">Open Modal</button>

<div id="id01" class="modal">
  <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">×</span>
  <form class="modal-content" action="/action_page.php">
    <div class="container">
      <h1>Delete Account</h1>
      <p>Are you sure you want to delete your account?</p>
    
      <div class="clearfix">
        <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
        <button type="button" onclick="document.getElementById('id01').style.display='none'" class="deletebtn">Delete</button>
      </div>
    </div>
  </form>
</div>


                <script>
                // Get the modal
                var modal = document.getElementById("myModal");

                // Get the button that opens the modal
                var btn = document.getElementById("myBtn");

                // Get the <span> element that closes the modal
                var span = document.getElementsByClassName("close")[0];

                // When the user clicks the button, open the modal 
                btn.onclick = function() {
                modal.style.display = "block";
                }

                // When the user clicks on <span> (x), close the modal
                span.onclick = function() {
                modal.style.display = "none";
                }

                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
                }
                </script>


                <script>
                // Get the modal
                var modal = document.getElementById('id01');

                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
                }
                </script>

            </body>
</html>