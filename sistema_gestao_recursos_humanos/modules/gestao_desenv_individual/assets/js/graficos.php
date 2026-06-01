<!-- Script do ECharts -->
<script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js">
</script>
<?php
    $labels = [];
    $valores = [];

    foreach ($plano_sugerido_dados as $plano) {
        $labels[] = $plano['meta']; // Nome da meta
        $valores[] = (int) $plano['pontuacao_recomendado'];
    }

?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Gráfico de Barras Empilhadas
        var chartDom = document.getElementById('chart');
        var myChart = echarts.init(chartDom);
        var barOption = {
            color: ['#336', '#DAA520'],
            xAxis: {
                //data: ['A', 'B', 'C', 'D', 'E']
                data: <?= json_encode($labels); ?>
            },
            yAxis: {},
            series: [{
                //data: [10, 22, 28, 43, 49],
                data: <?= json_encode($valores); ?>,
                type: 'bar',
                stack: 'x'
            }
            ]
        };
        myChart.setOption(barOption);

        // Segundo Gráfico de Pizza
        var pieChartDom = document.getElementById('gaugeChart');
        var pieChart = echarts.init(pieChartDom);
        var pieOption = {
            color: ['#336', '#DAA520', '#800000', '#555bbb',
                '#be0000'
            ], // Cores personalizadas
            tooltip: {
                trigger: 'item'
            },
            legend: {
                top: '10%', // Aumentando a margem superior
                left: 'center'
            },
            series: [{
                name: 'Access From',
                type: 'pie',
                radius: ['30%',
                    '60%'], // Aumentando o espaço interno para afastar os rótulos
                center: ['50%',
                    '60%'], // Movendo o gráfico mais para baixo
                avoidLabelOverlap: false,
                label: {
                    show: false,
                    position: 'center'
                },
                emphasis: {
                    label: {
                        show: true,
                        fontSize: 40,
                        fontWeight: 'bold'
                    }
                },
                labelLine: {
                    show: false
                },
                data: [{
                    value: <?php echo $contar_planos['pendentes'] ?>,
                    name: 'Pendente'
                },
                {
                    value: <?php echo $contar_planos['aprovados'] ?>,
                    name: 'Aprovado'
                },
                {
                    value: <?php echo $contar_planos['rejeitados'] ?>,
                    name: 'Rejeitado'
                }
                ]
            }]
        };
        pieChart.setOption(pieOption);


        // Primeiro Gráfico de Pizza
        var pieChartDom = document.getElementById('pieChart');
        var pieChart = echarts.init(pieChartDom);
        var pieOption = {
            color: ['#336', '#DAA520', '#800000', '#555bbb',
                '#be0000'
            ], // Cores personalizadas
            tooltip: {
                trigger: 'item'
            },
            legend: {
                top: '10%', // Aumentando a margem superior
                left: 'center'
            },
            series: [{
                name: 'Access From',
                type: 'pie',
                radius: ['30%',
                    '60%'], // Aumentando o espaço interno para afastar os rótulos
                center: ['50%',
                    '60%'], // Movendo o gráfico mais para baixo
                avoidLabelOverlap: false,
                label: {
                    show: false,
                    position: 'center'
                },
                emphasis: {
                    label: {
                        show: true,
                        fontSize: 40,
                        fontWeight: 'bold'
                    }
                },
                labelLine: {
                    show: false
                },
                data: [{
                    value: <?php echo $contar_mentoria['pendentes'] ?>,
                    name: 'Pendentes'
                },
                {
                    value: <?php echo $contar_mentoria['aprovados'] ?>,
                    name: 'Aprovados'
                },
                {
                    value: <?php echo $contar_mentoria['rejeitados'] ?>,
                    name: 'Rejeitados'
                }
                ]
            }]
        };
        pieChart.setOption(pieOption);
    });
</script>