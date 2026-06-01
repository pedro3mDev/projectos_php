<div class="row">
    <!-- 1º Gráfico - Pedidos de Viagens -->
    <div class="col-md-6">
        <div class="panel_s" style="height: 410px;">
            <div class="panel-body">
                <h4 class="no-margin font-bold">
                    <i class="fa fa-address-card-o" aria-hidden="true"></i> Pedidos de Viagens
                </h4>
                <hr />
                <div class="col-md-12 justify-content-center">
                    <div class="chart-container" style="position: relative; width: 100%; height: 300px;">
                        <canvas id="pedidorecebido"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('pedidorecebido').getContext('2d');
        var pedidorecebido = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Total', 'Pendentes', 'Aprovados', 'Rejeitados'],
                datasets: [{
                    label: 'Planejamentos',
                    data: [
                        <?php echo $dados['total_registros'] ?>,
                        <?php echo $dados['pendentes'] ?>,
                        <?php echo $dados['aprovados'] ?>,
                        <?php echo $dados['rejeitados'] ?>
                    ],
                    backgroundColor: 'rgba(128,0,0)',
                    borderColor: 'rgba(255,255,255)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <!-- 2º Gráfico - Status Requisições -->
    <div class="col-md-6">
        <div class="panel_s" style="height: 410px; width: 100%;">
            <div class="panel-body">
                <h4 class="no-margin font-bold">
                    <i class="fa fa-address-card-o" aria-hidden="true"></i> Status Requisições
                </h4>
                <hr />
                <canvas id="satisfactionChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <script>
        const ctx2 = document.getElementById('satisfactionChart').getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['Total','Pendente','Aprovado','Rejeitado'],
                datasets: [{
                    label: 'Nível de Satisfação',
                    data: [
                        <?php echo $dados['total_registros'] ?>,
                        <?php echo $dados['pendentes'] ?>,
                        <?php echo $dados['aprovados'] ?>,
                        <?php echo $dados['rejeitados'] ?>
                    ],
                    backgroundColor: ['#28a745', '#ffc107', '#ff5722', '#8bc34a']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>

    <!-- 3º Gráfico - Diversidade de Gênero --
    <div class="col-md-6">
        <div class="panel_s" style="height: 410px; width: 100%;">
            <div class="panel-body">
                <h4 class="no-margin font-bold">
                    <i class="fa fa-address-card-o" aria-hidden="true"></i> Proporção de diversidade de gênero
                </h4>
                <hr />
                <canvas id="genderDiversityChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
    
    <script>
        const ctx3 = document.getElementById('genderDiversityChart').getContext('2d');
        new Chart(ctx3, {
            type: 'doughnut',
            data: {
                labels: ['Feminino', 'Masculino'],
                datasets: [{
                    data: [55, 45],
                    backgroundColor: ['#800000', '#336']
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    }
                }
            }
        });
    </script-->

    <!-- 4º Gráfico - Estatísticas --
    <div class="col-md-6">
        <div class="panel_s" style="height: 410px; width: 100%;">
            <div class="panel-body">
                <h4 class="no-margin font-bold">
                    <i class="fa fa-address-card-o" aria-hidden="true"></i> Estatísticas
                </h4>
                <hr />
                <div class="chart-container" style="position: relative; width: 100%; height: 190px;">
                    <canvas id="funcionario_genero"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        const ctx4 = document.getElementById('funcionario_genero').getContext('2d');
        new Chart(ctx4, {
            type: 'doughnut',
            data: {
                labels: ['Check In', 'Horas Extras'],
                datasets: [{
                    data: [70, 30],
                    backgroundColor: ['#336', '#DAA520']
                }]
            },
            options: {
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        });
    </script-->
</div>