<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Plano de Sucessão e Liderança / Dashboard
                </a>
            </div>
        </div>
        <br />
        <?php require 'modules/plan_sucess_lideranca/views/dashboard/cards.php'; ?>
        </br>
        <div class="row">
            <!-- Coluna para o Gráfico de Anel e Funil -->
            <div class="col-lg-6 col-md-12 d-flex flex-column align-items-center">
                <!-- Gráfico de Anel -->
                <div class="panel w-100">
                    <div class="panel-header">
                        <h4 class="panel-title text-center">Desenvolvimento de Liderança</h4>
                    </div>
                    <div id="donutChart" style="width: 100%; height: 300px;"></div>
                </div>
                <!-- Gráfico de Funil -->
                <div class="panel w-100 mt-3">
                    <div class="panel-header">
                        <h4 class="panel-title text-center">Funnel Chart -
                            Contratação</h4>
                    </div>
                    <div id="funnelChart" style="width: 100%; height: 300px;"></div>
                </div>
            </div>
            <!-- Coluna para o Gráfico de Barras Empilhadas e Gráfico de Barras -->
            <div class="col-lg-6 col-md-12 d-flex flex-column align-items-center">
                <!-- Gráfico de Barras Empilhadas -->
                <div class="panel w-100">
                    <div class="panel-header">
                        <h4 class="panel-title text-center">Plano de Sucessão e Liderança</h4>
                    </div>
                    <div id="stackedBarChart" style="width: 100%; height: 300px;"></div>
                </div>
                <!-- Gráfico de Barras -->
                <div class="panel w-100 mt-3">
                    <div class="panel-header">
                        <h4 class="panel-title text-center">Gráfico de Identiifcação de Talentos</h4>
                    </div>
                    <div id="barChart" style="width: 100%; height: 300px;">
                    </div>
                </div>
            </div>

        </div>
        <!-- Importando ECharts -->
        <script src="https://cdn.jsdelivr.net/npm/echarts@5/dist/echarts.min.js"></script>

        <script>
        function renderCharts() {
            let donutChart = echarts.init(document.getElementById("donutChart"));
            let funnelChart = echarts.init(document.getElementById("funnelChart"));
            let stackedBarChart = echarts.init(document.getElementById("stackedBarChart"));
            let barChart = echarts.init(document.getElementById("barChart"));

            let resizeCharts = () => {
                donutChart.resize();
                funnelChart.resize();
                stackedBarChart.resize();
                barChart.resize();
            };

            donutChart.setOption({
                tooltip: {
                    trigger: "item"
                },
                legend: {
                    top: "0%",
                    bottom: "15%",
                    left: "center"
                },
                series: [{
                    name: "Desenvolvimento de Liderança",
                    type: "pie",
                    radius: ["40%", "70%"],
                    label: {
                        formatter: '{b}\n{c}',
                        fontSize: 14
                    },
                    data: [{
                            value: <?= $total_pendentes_grafico_desenvolvimento ?>,
                            name: "Pendente",
                            itemStyle: {
                                color: "#DAA520"
                            }
                        },
                        {
                            value: <?= $total_aprovados_grafico_desenvolvimento ?>,
                            name: "Aprovados",
                            itemStyle: {
                                color: "#336"
                            }
                        },
                        {
                            value: <?= $total_rejeitado_grafico_desenvolvimento ?>,
                            name: "Rejeitados",
                            itemStyle: {
                                color: "#800000"
                            }
                        }
                    ]
                }]
            });

            funnelChart.setOption({
            tooltip: {
            trigger: 'item',
            formatter: '{a} <br/>{b} : {c}%'
            },
            series: [{
            name: 'Funnel',
            type: 'funnel',
            left: '10%',
            top: 60,
            bottom: 60,
            width: '80%',
            data: [
            {
                value: 60,
                name: 'Visit',
                itemStyle: { color: '#e70000' } 
            },
            {
                value: 40,
                name: 'Inquiry',
                itemStyle: { color: '#915a17' } 
            },
            {
                value: 20,
                name: 'Order',
                itemStyle: { color: '#336' } 
            },
            {
                value: 80,
                name: 'Click',
                itemStyle: { color: '#DAA520' } 
            },
            {
                value: 100,
                name: 'Show',
                itemStyle: { color: '#800000' }
            }
           ]
         }]
       });


            stackedBarChart.setOption({
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data: ['Pendentes', 'Rejeitados', 'Aprovados']
                },
                xAxis: {
                    type: 'category',
                    data: ['Des. de Liderança', 'Aval. Competências', 'Prog. Lid. Sucessão',
                        'Plan. Aqui. Competência', 'Mentória e Coaching',
                        'Potencial Desenvolvimento', 'Talentos'
                    ]
                },
                yAxis: {
                    type: 'value'
                },
                series: [{
                        name: 'Pendentes',
                        type: 'bar',
                        stack: 'total',
                        data: [<?= $total_pendentes_grafico_desenvolvimento ?>,
                            <?= $total_pendentes_avaliacao_competencias_total ?>,
                            <?= $total_pendentes_programa_lideranca ?>,
                            <?= $total_pendentes_plano_aquisicao_competencia ?>,
                            <?= $total_pendente_mentoria_total ?>,
                            <?= $total_pendente_potencial_desenvolvimento ?>,
                            <?= $total_pendente_talentos ?>
                        ],
                        itemStyle: {
                            color: '#DAA520'
                        }
                    },
                    {
                        name: 'Rejeitados',
                        type: 'bar',
                        stack: 'total',
                        data: [<?= $total_rejeitado_grafico_desenvolvimento ?>,
                            <?= $total_rejeitado_avaliacao_competencias_total ?>,
                            <?= $total_rejeitado_programa_lideranca ?>,
                            <?= $total_rejeitado_plano_aquisicao_competencia ?>,
                            <?= $total_rejeitado_mentoria_total ?>,
                            <?= $total_rejeitado_potencial_desenvolvimento ?>,
                            <?= $total_rejeitado_talentos ?>
                        ],
                        itemStyle: {
                            color: '#800000'
                        }
                    },
                    {
                        name: 'Aprovados',
                        type: 'bar',
                        stack: 'total',
                        data: [<?= $total_aprovados_grafico_desenvolvimento ?>,
                            <?= $total_aprovados_avaliacao_competencias_total ?>,
                            <?= $total_aprovados_programa_lideranca ?>,
                            <?= $total_aprovados_plano_aquisicao_competencia ?>,
                            <?= $total_aprovados_mentoria_total ?>,
                            <?= $total_aprovados_potencial_desenvolvimento ?>,
                            <?= $total_aprovados_talentos ?>
                        ],
                        itemStyle: {
                            color: '#336'
                        }
                    }
                ]
            });

            barChart.setOption({
                tooltip: {
                    trigger: 'axis'
                },
                xAxis: {
                    type: 'category',
                    data: ['Não Classificados', 'Classificados', 'Potencial Talento']
                },
                yAxis: {
                    type: 'value'
                },
                series: [{
                    type: 'bar',
                    data: [<?= $avaliacao_competencias_total_n_classificado ?>,
                        <?= $avaliacao_competencias_total_classificado ?>,
                        <?= $avaliacao_competencias_total_potencial ?>
                    ]
                }]
            });

            // Redimensionar gráficos quando a tela mudar de tamanho
            window.addEventListener("resize", resizeCharts);
        }

        renderCharts();
        </script>

        <style>
        .panel {
            background: #fff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .panel .panel-header h4 {
            text-align: center;
        }

        @media (max-width: 768px) {

            .col-md-12,
            .col-md-6 {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                width: 100%;
            }

            .panel {
                width: 100% !important;
                max-width: 400px;
                /* Define um limite de largura para não ficar muito grande */
            }
        }
        </style>
        <?php init_tail(); ?>