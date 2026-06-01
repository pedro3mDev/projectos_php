    <div class="div_menu">
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li class="dropdown_menu">
                <a href="#" class="dropbtn">Chegadas</a>
                <div class="dropdown_menu-content">
                    <a href="chegadas_cadastrar.php">Novo</a>
                    <a href="altera_chegada.php">Editar</a>
                </div>
            </li>
            <li class="dropdown_menu">
                <a href="#" class="dropbtn">Partidas</a>
                <div class="dropdown_menu-content">
                    <a href="partidas_cadastrar.php">Novo</a>
                    <a href="altera_partida.php">Editar</a>
                </div>
            </li>
            <li class="dropdown_menu">
                <a href="#" class="dropbtn">Vistos</a>
                <div class="dropdown_menu-content">
                    <a href="#">Embarques </a>
                    <a href="">Desembarques </a>
                    <a href="#">Capitania do Porto Lda </a>
                    <a href="#">Trabalho </a>
                    <a href="#">Curta duração </a>
                    <a href="#">Fronteiras </a>
                    <a href="#">Turismo </a>
                    <a href="#">Ordinário </a>
                </div>
            </li>
            <li class="dropdown_menu">
                <a href="#" class="dropbtn">Viaturas</a>
                <div class="dropdown_menu-content">
                    <a href="#">Controle de Viaturas </a>
                </div>
            </li>
            <li class="dropdown_menu">
                <a href="#" class="dropbtn">Terceiros</a>
                <div class="dropdown_menu-content">
                    <a href="criar_terceiros/index.php">Criar Terceiro</a>
                    <a href="#">Promaritima</a>
                    <a href="#">Tuboscope</a>
                    <a href="#">Bechtel</a>
                    <a href="#">Coca Cola</a>
                    <a href="#">Sonasurf</a>
                    <a href="#">Cliente \ Empresa </a>
                </div>
            </li>
            <li class="dropdown_menu">
                <a href="#" class="dropbtn">Exportar</a>
                <div class="dropdown_menu-content">
                    <a href="gerar_planilha.php">Chegadas</a>
                    <a href="gerar_planilha_partida.php">Partidas</a>
                </div>
            </li>
            <li><a href="Menu_De_Consultas.php">Consultas</a></li>
            <li class="pesquisar" style="margin-left:auto;">
                <form action="Consulta_Global_Pax.php" method="POST" class="form-inline">
                    <input type="text" name="Dados" class="form-control input-sm" placeholder="Pesquisar...">
                    <button class="button btn btn-xs" style="background:var(--accent); color:#000; border:none; font-weight:700;">Pesquisar</button>
                </form>
            </li>
        </ul>
    </div>