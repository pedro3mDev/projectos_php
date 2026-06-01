
<div class="sidebar">
    <ul class="menu">
        <li class="active"><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li><a href="chegadas_cadastrar.php"><i class="fas fa-plane-arrival"></i> Chegadas</a></li>
        <li><a href="partidas_cadastrar.php"><i class="fas fa-plane-departure"></i> Partidas</a></li>
        <li><a href="Menu_De_Consultas.php"><i class="fas fa-chart-line"></i> Consultas</a></li>
        <li>
            <a href="#" data-bs-toggle="modal" data-bs-target="#modalCalcular">
                <i class="fas fa-calculator"></i> Calcular
            </a>
        </li>

        <!--li><a href="painel2.php"><i class="fas fa-cog"></i> Settings</a></li-->
        <li class="logout"><a href="sair.php"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
    </ul>
</div>

<!-- ✅ Modal Bootstrap -->
<div class="modal fade" id="modalCalcular" tabindex="-1" aria-labelledby="modalCalcularLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:12px;">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title" id="modalCalcularLabel"><i class="fas fa-calculator"></i> Resultado do Cálculo</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body text-center p-4">
        <?php
          include_once("conexao.php");
          $query_total = "SELECT 
                            (SELECT SUM(ValorTransporte) FROM meetchegadas) +
                            (SELECT SUM(ValorEmbarque) FROM meetpartida) +
                            (SELECT SUM(ValorDesembarque) FROM meetchegadas) AS total_geral";
          $result_total = $conn->prepare($query_total);
          $result_total->execute();
          $row_total = $result_total->fetch(PDO::FETCH_ASSOC);
          $valor_total = number_format($row_total['total_geral'], 2, ',', '.');
        ?>

        <h4 class="text-primary fw-bold">Total Geral: <?php echo $valor_total; ?> KZ</h4>
        <p class="text-muted mt-2">Soma total dos valores de transporte, embarque e desembarque.</p>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<?php include_once("st_scripts.php"); ?>