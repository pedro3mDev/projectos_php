<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Consulta pela data de hoje</title>

    <script src="https://code.jquery.com/jquery-1.11.2.js"></script>
    <script type="text/javascript">
        jQuery(window).load(function ($) {
            atualizaRelogio();
        });

        function recarrega() {
            var p = document.getElementsByTagName('p')[0];
            p.innerHTML = new Date().toString();
        }

        function inicializaRecarga() {
            recarrega(); // preencher <p> da primeira vez
            setInterval(recarrega, 5000);
        }
    </script>

    <style>
        table {
            border-collapse: collapse;
            width: auto;
            text-align: center;
        }

        td, th {
            border: 1px solid black;
            padding: 4px;
        }

        nav {
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
        }
    </style>
</head>
<body onload="inicializaRecarga()">

<div id="print" class="conteudo">
    <nav>
        <div class="logo">
            <img src="png.png" width="100" height="50">
        </div>
    </nav>

    <h5 style="color:green">CHEGADAS</h5>

    <?php
    echo "<table>";
    echo "<tr><th>id_cliente</th><th>mes_cliente</th><th>quantidade</th></tr>";

    class TableRows extends RecursiveIteratorIterator {

        public function __construct($it) {
            parent::__construct($it, self::LEAVES_ONLY);
        }

        #[\ReturnTypeWillChange]
        public function current() {
            return "<td style='width:100px;border:1px solid black;'>" . parent::current() . "</td>";
        }

        #[\ReturnTypeWillChange]
        public function beginChildren() {
            echo "<tr>";
        }

        #[\ReturnTypeWillChange]
        public function endChildren() {
            echo "</tr>\n";
        }
    }

    $servername = "p3nlmysql183plsk.secureserver.net:3306";
    $username = "ugeral";
    $password = "meualmir1";
    $dbname = "geral";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT id_cliente, mes_cliente, quantidade FROM clientes WHERE id_cliente = '2'");
        $stmt->execute();

        foreach (new TableRows(new RecursiveArrayIterator($stmt->fetchAll(PDO::FETCH_ASSOC))) as $v) {
            echo $v;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
    echo "</table>";
    ?>
</div>

</body>
</html>
