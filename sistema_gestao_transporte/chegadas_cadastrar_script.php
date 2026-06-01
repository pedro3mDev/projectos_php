<script>
    /* Preenche select Terceiro via AJAX GET lista_terceiros.php */
    function get_client_list() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById("Terceiro").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "lista_terceiros.php", true);
        xhttp.send();
    }

    /* Envia formulário via AJAX para Processador_Chegada.php e limpa campos */
    function norefresh_form() {
        // Lê valores
        var dados = {
            Nome: document.getElementById("Nome").value,
            Apelido: document.getElementById("Apelido").value,
            Motorista: document.getElementById("Motorista").value,
            Data: document.getElementById("Data").value,
            Transporte: document.getElementById("Transporte").checked ? document.getElementById("Transporte").value : '',
            Embarque: document.getElementById("Embarque").checked ? document.getElementById("Embarque").value : '',
            SonilsAcesso: document.getElementById("SonilsAcesso").checked ? document.getElementById("SonilsAcesso").value : '',
            Capitania: document.getElementById("Capitania").checked ? document.getElementById("Capitania").value : '',
            Desembarque: document.getElementById("Desembarque").checked ? document.getElementById("Desembarque").value : '',
            Proveniencia: document.getElementById("Proveniencia").value,
            Destino: document.getElementById("Destino").value,
            Navio: document.getElementById("Navio").value,
            Descricao: document.getElementById("Descricao").value,
            Hora: document.getElementById("Hora").value,
            Voo: document.getElementById("Voo").value,
            ValorTransporte: document.getElementById("ValorTransporte").value,
            Terceiro: document.getElementById("Terceiro").value,
            Trackingnumber: document.getElementById("Trackingnumber").value,
            ValorCapitania: document.getElementById("ValorCapitania").value,
            ValorEmbarque: document.getElementById("ValorEmbarque").value,
            ValorDesembarque: document.getElementById("ValorDesembarque").value,
            ValorAcesso: document.getElementById("ValorAcesso").value,
            ValorAssistencia: document.getElementById("ValorAssistencia").value,
            assisgate: document.getElementById("assisgate").value
        };

        // Limpa campos (reset visual)
        document.getElementById("chegadasForm").reset();

        // Preparar parâmetros urlencoded
        var params = Object.keys(dados).map(
            function(k){ return encodeURIComponent(k) + '=' + encodeURIComponent(dados[k]); }
        ).join('&');

        // AJAX POST 
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4) {
                var x = document.getElementById("snackbar");
                if (this.status === 200) {
                    // podes mostrar resposta se quiseres: this.responseText
                    x.innerText = "Adicionado as CHEGADAS";
                } else {
                    x.innerText = "Erro ao gravar (verifica o servidor)";
                }
                x.className = "show";
                setTimeout(function () { x.className = x.className.replace("show", ""); }, 3000);
            }
        };
        xhttp.open("POST", "Processador_Chegada.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(params);
    }
</script>