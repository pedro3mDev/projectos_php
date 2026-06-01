<div class="row">
    <!-- 1º Gráfico -->
    <div class="col-md-4">
        <div class="panel_s" style=" height: 410px; overflow-y: auto;">
            <div class="panel-body">
                <h4 class="no-margin font-bold">
                    <i class="fa fa-address-card-o" aria-hidden="true"></i> Tipo de Viagem
                </h4>
                <hr />
                <style>
                    .chart-container {
                        position: relative;
                        width: 100%;
                        height: 200px;
                    }
                </style>
                <div class="chart-container">
                    <canvas id="tipo_contrato_emprego"></canvas>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        window.onload = function() {
    var ctx = document.getElementById('tipo_contrato_emprego').getContext('2d');

    // Plugin para desenhar o texto no centro
    const centerTextPlugin = {
        id: 'centerText',
        beforeDraw(chart) {
            const { width, height, ctx } = chart;
            ctx.save();

            const fontSize = (height / 8).toFixed(2);
            ctx.font = `${fontSize}px sans-serif`;
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            const text = '<?= $total_planejamento ?? 0; ?> Total';
            const textX = width / 2;
            const textY = height / 2;

            ctx.fillText(text, textX, textY);
            ctx.restore();
        }
    };

    // Registrar o plugin
    Chart.register(centerTextPlugin);

    // Inicializar o gráfico
    const tipoContratoEmpregoChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: <?= $tipo_viagem_dashboard['label'] ?>,
            datasets: [{
                label: 'Tipo de Contrato',
                data: <?= $tipo_viagem_dashboard['count'] ?>,
                backgroundColor: <?= $tipo_viagem_dashboard['background'] ?>,
                hoverBackgroundColor: '#333366' // Nova cor de hover
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '60%',
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    enabled: true
                }
            }
        },
        plugins: [centerTextPlugin] // Adicionar o plugin no gráfico
    });
};

    </script>

    <!-- 2º Gráfico -->
    <div class="col-md-4">
        <div class="panel_s" style=" height: 410px; overflow-y: auto;">
            <div class="panel-body">
                <h4 class="no-margin font-bold">
                    <i class="fa fa-address-card-o" aria-hidden="true"></i> Estado de Pedidos Planejados
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
            labels: ['Total', 'Pendentes', 'Activos', 'Rejeitados'],
            datasets: [{
                label: 'Planejamentos',
                data: [
                    <?= $total_planejamento ?? 0; ?>,
                    <?= $total_planejamento_penedntes ?? 0; ?>,
                    <?= $total_planejamento_aprovados ?? 0; ?>,
                    <?= $total_planejamento_rejeitados ?? 0; ?>
                ],
                backgroundColor: [
                    '#333366',
                    '#e3e6f6',
                    '#e3b62c',
                    '#ff1111'
                ],
                borderColor: 'rgba(255,255,255)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            indexAxis: 'y',
            scales: {
                x: {
                    ticks: {
                        beginAtZero: true,
                        callback: function(value) {
                            return value + ' ';
                        }
                    }
                },
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.raw + ' ';
                        }
                    }
                }
            }
        }
    });
</script>


    <!-- 3º Gráfico -->
    <div class="col-md-4">
        <div class="panel_s" style=" height: 410px; overflow-y: auto;">
            <div class="panel-body">
                <h4 class="no-margin font-bold">
                    <i class="fa fa-address-card-o" aria-hidden="true"></i> Gastos em Reservas
                </h4>
                <hr />
                <div class="col-md-12 justify-content-center">
                    <div class="chart-container" style="position: relative; width: 100%; height: 300px;">
                        <canvas id="codigo"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    var ctx = document.getElementById('codigo').getContext('2d');
    var codigo = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Hotel', 'Voo', 'Transporte'],
            datasets: [{
                label: 'Total em Reservas de Viagens',
                data: [
                    <?= $dashboard_gasto_hotel ?>,
                    <?= $dashboard_gasto_voo ?>,
                    <?= $dashboard_gasto_transporte ?>
                ],
                backgroundColor: [
                    '#333366',
                    '#daa520', // Verde para Voo
                    '#800000'  // Azul para Transporte
                ],
                borderColor: 'rgba(255,255,255)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            indexAxis: 'y',
            scales: {
                x: {
                    ticks: {
                        beginAtZero: true,
                        callback: function(value) {
                            return value + ' Kz';
                        }
                    }
                },
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.raw + ' Kz';
                        }
                    }
                }
            }
        }
    });
</script>


</div>

