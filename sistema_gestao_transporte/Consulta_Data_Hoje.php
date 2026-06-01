<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta charset="UTF-8"/>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>Consulta pela data de hoje</title>

            <script src="https://code.jquery.com/jquery-1.11.2.js"></script>
            <script type="text/javascript">
    jQuery(window).load(function ($) {
        atualizaRelogio();
    });
            </script>

            <script type="text/javascript">
                function recarrega() {
                    var p = document.getElementsByTagName('p')[0];
                    p.innerHTML = new Date().toString();
                    //em JS, setar timezone é complicado, mas existem bibliotecas como timezone-js:  https://github.com/mde/timezone-js
                }
                function inicializaRecarga() {
                    recarrega(); //chamando recarrega para preencher o <p> da primeira vez
                    setInterval(recarrega, 5000);
                }
            </script>

        </head>

        <style>
            table {
                table-layout: fixed;
                border: 1px;
                border-collapse: collapse;
                height: 9px;
                text-align: center;
                width: auto;
            } 

            td {
                border: 1px;
                height: 9px;
                text-align: center;
                width: 1px;white-space: nowrap;
            }


            th {
                border: 1px solid black;
                border-collapse: collapse;
                padding: 0;
                height: 9px;
                text-align: center;
                padding: 0;
                width: auto;
            }


            table.TableRows {
                table-layout: auto;
            }


            table.TableRows2 {
                table-layout: auto;
            }   

            nav {
                /* Usado inline block para que o nav tenha a mesma altura sem necessidade ajustar o height */
                display:inline-block;
                width:25%;
            }
            .logo {
                height:50px;
                width:100px;
                float:left;
                margin:0;
                position:relative;
                top:-20px;
                padding-top: 0px;

            }

        </style>

        <body onload="inicializaRecarga()">
            <div id="print" class="conteudo">

                <nav>
                    <div class="logo">
                        <img src="png.png" width=100 height=50>
                    </div>
                </nav>

                <h5 style="color:green">CHEGADAS</h5>
                
                <?php
                echo "<table border='1px' cellpaddind='3px' cellspacing='0';>";
                echo "<tr><th>Data</th><th>Nome</th><th>Apelido</th><th>Hora</th><th>Voo</th><th>Proveniencia</th><th>Destino</th><th>Descricao</th><th>Terceiro</th><th>Motorista</th></tr>";

                class TableRows extends RecursiveIteratorIterator {

                    function __construct($it) {
                        parent::__construct($it, self::LEAVES_ONLY);
                    }

                    function current() {
                        return "<td style='width:100px;border:1px solid black;'>" . parent::current() . "</td>";
                    }

                    function beginChildren() {
                        echo "<tr>";
                    }

                    function endChildren() {
                        echo "</tr>" . "\n";
                    }

                }

                if ($_SERVER["REQUEST_METHOD"] == "POST")
                //collect value of input field
                    $DataHoje = $_POST["DataHoje"];

//fim da recolha do front in


                    $servername = "p3nlmysql183plsk.secureserver.net:3306";
                    $username = "ugeral";
                    $password = "meualmir1";
                    $dbname = "geral";

                try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt = $conn->prepare("SELECT Data, Nome, Apelido, Hora, Voo, Proveniencia,  Destino, Descricao, Terceiro, Motorista FROM meetchegadas WHERE  Data>= '$DataHoje'ORDER BY Data, Hora, Terceiro ASC");

                    $stmt->execute();

                    // set the resulting array to associative
                    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    foreach (new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k => $v) {
                        echo $v;
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                $conn = null;
                echo "</table>";
                ?>

                <h5 style="color: red">PARTIDAS</h5>


                <?php
                echo "<table border='1px' cellpaddind='3px' cellspacing='0'>";
                echo "<tr><th>Data</th><th>Nome</th><th>Apelido</th><th>Hora</th><th>Voo</th><th>Proveniencia</th><th>Destino</th><th>Descricao</th><th>Terceiro</th><th>Motorista</th></tr>";

                class TableRows2 extends RecursiveIteratorIterator {

                    function __construct($it) {
                        parent::__construct($it, self::LEAVES_ONLY);
                    }

                    function current() {
                        return "<td style='width:100px;border:1px solid black;'>" . parent::current() . "</td>";
                    }

                    function beginChildren() {
                        echo "<tr>";
                    }

                    function endChildren() {
                        echo "</tr>" . "\n";
                    }

                }

                if ($_SERVER["REQUEST_METHOD"] == "POST")
                //collect value of input field
                    $DataHoje = $_POST["DataHoje"];
//fim da recolha do front in


$servername = "p3nlmysql183plsk.secureserver.net:3306";
$username = "ugeral";
$password = "meualmir1";
$dbname = "geral";

                try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt = $conn->prepare("SELECT Data, Nome, Apelido, Hora, Voo, Proveniencia,  Destino, Descricao, Terceiro, Motorista FROM meetpartida WHERE  Data>= '$DataHoje'ORDER BY Data, Hora, Terceiro ASC");
                    $stmt->execute();

                    // set the resulting array to associative
                    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    foreach (new TableRows2(new RecursiveArrayIterator($stmt->fetchAll())) as $k => $v) {
                        echo $v;
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                $conn = null;
                echo "</table>";
                ?>
                
            </div>

            <br><br>

            <script>
                function cont() {
                    var conteudo = document.getElementById('print').innerHTML;
                    tela_impressao = window.open('DSP');
                    tela_impressao.document.write(conteudo);
                    tela_impressao.window.print();
                    tela_impressao.window.close();
                }
            </script>

            <input type="button" onclick="cont();" value="Imprimir">

            <script>
                function atualizaRelogio() {
                    var momentoAtual = new Date();

                    var vhora = momentoAtual.getHours();
                    var vminuto = momentoAtual.getMinutes();
                    var vsegundo = momentoAtual.getSeconds();

                    var vdia = momentoAtual.getDate();
                    var vmes = momentoAtual.getMonth() + 1;
                    var vano = momentoAtual.getFullYear();

                    if (vdia < 10) {
                        vdia = "0" + vdia;
                    }
                    if (vmes < 10) {
                        vmes = "0" + vmes;
                    }
                    if (vhora < 10) {
                        vhora = "0" + vhora;
                    }
                    if (vminuto < 10) {
                        vminuto = "0" + vminuto;
                    }
                    if (vsegundo < 10) {
                        vsegundo = "0" + vsegundo;
                    }

                    dataFormat = vdia + " / " + vmes + " / " + vano;
                    horaFormat = vhora + " : " + vminuto + " : " + vsegundo;

                    document.getElementById("data").innerHTML = dataFormat;
                    document.getElementById("hora").innerHTML = horaFormat;

                    setTimeout("atualizaRelogio()", 1000);
                }
            </script>	

        </body>
    </html> 

