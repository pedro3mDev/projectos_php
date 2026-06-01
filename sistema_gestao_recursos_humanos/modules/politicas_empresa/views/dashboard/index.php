<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<link rel="stylesheet"
    href="<?php echo base_url('assets/css/politicas_empresa/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        <?php
        $data_view = [];
        $this->load->view('/admin/menu_modulo/menu', $data_view);
        ?>
        <div class="row">
            <div class="col-md-12">
                <a class="dashboard-link" href="" id="titulo">
                    Politicas de Empresa / Dashboard
                </a>
            </div>
        </div>
        </br>
        <div class="row">
            <div class="col-md-3">
                <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column"
                    style="border-bottom: 1px solid #336; border-left: 4px solid #8B0000;">
                    <a class="text-warning text-center mbot15">
                        <p class="text-uppercase mtop5 minheight35"
                            style="font-size: 14px; font-weight: bold; color:#DAA520;;">
                            Politicas de Segurança
                        </p>
                        <div
                            class="d-flex align-items-center justify-content-center">
                            <p style="font-size:16px; color:#DAA520;">
                                <i class="fas fa-cog"></i>
                                <?= $TotalPoliticas ?? 0; ?>
                            </p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column"
                    style="border-bottom: 1px solid #336; border-left: 4px solid #8B0000;">
                    <a class="text-warning text-center mbot15">
                        <p class="text-uppercase mtop5 minheight35"
                            style="font-size: 14px; font-weight: bold; color:#DAA520;;">
                            Total Conformidades
                        </p>
                        <div
                            class="d-flex align-items-center justify-content-center">
                            <p style="font-size:16px; color:#DAA520;">
                                <i class="fas fa-cog"></i>
                                <?= $TotalConformidades ?? 0; ?>
                            </p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column"
                    style="border-bottom: 1px solid #336; border-left: 4px solid #8B0000;">
                    <a class="text-warning text-center mbot15">
                        <p class="text-uppercase mtop5 minheight35"
                            style="font-size: 14px; font-weight: bold; color:#DAA520;;">
                            Total Procedimentos
                        </p>
                        <div
                            class="d-flex align-items-center justify-content-center">
                            <p style="font-size:16px; color:#DAA520;">
                                <i class="fas fa-cog"></i>
                                <?= $TotalProcedimentos ?? 0; ?>
                            </p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column"
                    style="border-bottom: 1px solid #336; border-left: 4px solid #8B0000;">
                    <a class="text-warning text-center mbot15">
                        <p class="text-uppercase mtop5 minheight35"
                            style="font-size: 14px; font-weight: bold; color:#DAA520;;">
                            Total Riscos
                        </p>
                        <div
                            class="d-flex align-items-center justify-content-center">
                            <p style="font-size:16px; color:#DAA520;">
                                <i class="fas fa-cog"></i>
                                <?= $TotalRiscos ?? 0; ?>
                            </p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        </br>
        <div class="row">
            <!-- 1º Gráfico -->
            <div class="col-md-6">
                <div class="panel_s" style="height: 410px;">
                    <div class="panel-body">
                        <h4 class="no-margin font-bold">
                            <i class="fa fa-address-card-o"
                                aria-hidden="true"></i> Segurança no Escritório
                        </h4>
                        <hr />
                        <div class="col-md-12 justify-content-center">
                            <div class="chart-container"
                                style="position: relative; width: 100%; height: 300px;">
                                <canvas id="pedidorecebido"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Script -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                var ctx = document.getElementById('pedidorecebido').getContext(
                    '2d');
                var pedidorecebido = new Chart(ctx, {
                    type: 'bar', // Usando o tipo 'bar' para gráficos de barras horizontais
                    data: {
                        labels: ['Item 1', 'Item 2', 'Item 3',
                            'Item 4'
                        ], // Labels (nome dos itens)
                        datasets: [{
                            label: 'Percentual',
                            data: [70, 50, 90,
                                60
                            ], // Dados das porcentagens
                            backgroundColor: 'rgba(128,0,0)', // Cor de fundo das barras
                            borderColor: 'rgba(255,255,255)', // Cor da borda das barras
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        indexAxis: 'y', // Faz as barras ficarem horizontais
                        scales: {
                            x: {
                                ticks: {
                                    beginAtZero: true,
                                    callback: function(value) {
                                        return value + '%'
                                    } // Adiciona o símbolo de porcentagem
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
                                        return tooltipItem.raw +
                                            '%'; // Exibe a porcentagem no tooltip
                                    }
                                }
                            }
                        }
                    }
                });
            </script>
            <!-- 2º Gráfico -->
            <div class="col-md-6">
                <div class="panel_s" style="height: 410px;">
                    <div class="panel-body">
                        <h4 class="no-margin font-bold">
                            <i class="fa fa-address-card-o"
                                aria-hidden="true"></i> Codigo de Conduta
                        </h4>
                        <hr />
                        <div class="col-md-12 justify-content-center">
                            <div class="chart-container"
                                style="position: relative; width: 100%; height: 300px;">
                                <canvas id="codigo"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Script -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                var ctx = document.getElementById('codigo').getContext('2d');
                var codigo = new Chart(ctx, {
                    type: 'bar', // Usando o tipo 'bar' para gráficos de barras horizontais
                    data: {
                        labels: ['Item 1', 'Item 2', 'Item 3',
                            'Item 4'
                        ], // Labels (nome dos itens)
                        datasets: [{
                            label: 'Percentual',
                            data: [70, 50, 100,
                                60
                            ], // Dados das porcentagens
                            backgroundColor: 'rgba(128,0,0)', // Cor de fundo das barras
                            borderColor: 'rgba(255,255,255)', // Cor da borda das barras
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        indexAxis: 'y', // Faz as barras ficarem horizontais
                        scales: {
                            x: {
                                ticks: {
                                    beginAtZero: true,
                                    callback: function(value) {
                                        return value + '%'
                                    } // Adiciona o símbolo de porcentagem
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
                                        return tooltipItem.raw +
                                            '%'; // Exibe a porcentagem no tooltip
                                    }
                                }
                            }
                        }
                    }
                });
            </script>
            <!-- 3º Gráfico -->
            <div class="col-md-4">
                <div class="panel_s" style="min-height: 410px; width: 100%;">
                    <!-- Usando min-height -->
                    <div class="panel-body">
                        <h4 class="no-margin font-bold">
                            <i class="fa fa-address-card-o"
                                aria-hidden="true"></i> Conformidades
                        </h4>
                        <hr />
                        <div class="chart-container justify-content-center"
                            style="position: relative; width: 100%; height: 250px;">
                            <canvas id="tipo_contrato_emprego"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel_s" style="min-height: 410px; width: 100%;">
                    <div class="panel-body">
                        <h4 class="no-margin font-bold">
                            <i class="fa fa-address-card-o"
                                aria-hidden="true"></i> Politicas
                        </h4>
                        <hr />
                        <div>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th id="titulo1" class="text-center">
                                            Tipo de Politica</th>
                                        <th class="titulo2" class="text-center">
                                            Total de Politica</th>
                                        <!-- <th class="titulo2" class="text-center">0</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($listaTotalPoliticaPorTipo as $key => $listaTotalPolitica) {
                                    ?>
                                    <tr>
                                        <td class="text-center">
                                            <?php echo $listaTotalPolitica["tipo_politica"] ?? 0  ?>
                                        </td>
                                        <td class="text-center">
                                            <?php echo $listaTotalPolitica["total_politicas"] ?? 0  ?>
                                        </td>
                                        <!-- <td class="text-center">0</td> -->
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                    <!-- <tr>
                                        <td class="text-center">Etica</td>
                                        <td class="text-center">0</td>
                                        <td class="text-center">0</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">Confidencialidades</td>
                                        <td class="text-center">0</td>
                                        <td class="text-center">0</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">Assets da Empresa</td>
                                        <td class="text-center">0</td>
                                        <td class="text-center">0</td>
                                    </tr> -->
                                </tbody>
                            </table>
                        </div>
                        <style>
                            #titulo1 {
                                background-color: #336;
                                color: #fff;
                                text-align: center;
                            }
                            .titulo2 {
                                background-color: #800000;
                                color: #fff;
                                text-align: center;
                            }
                        </style>
                    </div>
                </div>
            </div>
            <!-- 4º Gráfico --
            <div class="col-md-4">
                <div class="panel_s" style="height: 410px;">
                    <div class="panel-body">
                        <h4 class="no-margin font-bold">
                            <i class="fa fa-address-card-o" aria-hidden="true"></i> Teste
                        </h4>
                        <hr />
                        <div class="col-md-12 justify-content-center">
                        </div>
                    </div>
                </div>
                <!-- Script ->
            </div-->
            <!-- 5º Gráfico -->
            <div class="col-md-4">
                <div class="panel_s" style="min-height: 410px; width: 100%;">
                    <!-- Usando min-height -->
                    <div class="panel-body">
                        <h4 class="no-margin font-bold">
                            <i class="fa fa-address-card-o"
                                aria-hidden="true"></i> Procedimentos
                        </h4>
                        <hr />
                        <div class="col-md-12 justify-content-center">
                            <div class="chart-container"
                                style="position: relative; width: 100%; height: 250px;">
                                <canvas id="website"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            window.onload = function() {
                let ProctotalPedente =
                    '<?php echo intval(html_entity_decode($totalProcByStatusPedente ?? 0)); ?>';
                let ProctotalAprovado =
                    '<?php echo intval(html_entity_decode($totalProcByStatusAprovado ?? 0)); ?>';
                let ProctotalRejeitado =
                    '<?php echo intval(html_entity_decode($totalProcByStatusRejeitado ?? 0)); ?>';

                // Inicializar o gráfico "website"
                var ctx2 = document.getElementById('website').getContext(
                    '2d');
                var websiteChart = new Chart(ctx2, {
                    type: 'doughnut',
                    data: {
                        labels: ['Pendente', 'Aprovado',
                            'Rejeitado'],
                        datasets: [{
                            label: 'Tipo de Contrato Adicional',
                            data: [ProctotalPedente,
                                ProctotalAprovado,
                                ProctotalRejeitado
                            ],
                            backgroundColor: ['#DAA520',
                                ' #336', '#800000'
                            ], // Laranja, Verde, Vermelho
                            hoverBackgroundColor: [
                                '#FF8C00', '#006400',
                                '#B22222'
                            ] // Tons mais escuros no hover
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutoutPercentage: 60,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    fontSize: 14,
                                    boxWidth: 15,
                                    color: '#333' // Cor da legenda
                                }
                            },
                            tooltip: {
                                enabled: true
                            }
                        }
                    }
                });
                let conftotalPedente =
                    '<?php echo intval(html_entity_decode($totalConfByStatusPedente ?? 0)); ?>';
                let conftotalAprovado =
                    '<?php echo intval(html_entity_decode($totalConfByStatusAprovado ?? 0)); ?>';
                let conftotalRejeitado =
                    '<?php echo intval(html_entity_decode($totalConfByStatusRejeitado ?? 0)); ?>';

                // console.log(conftotalPedente);
                // console.log(conftotalAprovado);
                // console.log(conftotalRejeitado);
                // Inicializar o gráfico "tipo_contrato_emprego"

                var ctx3 = document.getElementById('tipo_contrato_emprego')
                    .getContext('2d');
                var tipoContratoEmpregoChart = new Chart(ctx3, {
                    type: 'doughnut',
                    data: {
                        labels: ['Pendente', 'Aprovado',
                            'Rejeitado'
                        ],
                        datasets: [{
                            label: 'Tipo de Contrato',
                            data: [conftotalPedente,
                                conftotalAprovado,
                                conftotalRejeitado
                            ],
                            backgroundColor: ['#DAA520',
                                '#336', '#800000'
                            ], // Azul, Verde, Vermelho
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutoutPercentage: 60,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    fontSize: 14,
                                    boxWidth: 15,
                                    color: '#333' // Cor da legenda
                                }
                            },
                            tooltip: {
                                enabled: true
                            }
                        },
                        rotation: Math.PI
                    }
                });
                
                // Inicializar o gráfico "tipo_contrato_adicional"
                var ctx4 = document.getElementById(
                    'tipo_contrato_adicional').getContext('2d');
                var tipoContratoAdicionalChart = new Chart(ctx4, {
                    type: 'doughnut',
                    data: {
                        labels: ['Meio Periodo',
                            'Periodo Completo'
                        ],
                        datasets: [{
                            label: 'Tipo de Contrato Adicional',
                            data: [10, 90],
                            backgroundColor: ['#DAA520',
                                '#336', '#800000'
                            ],
                            hoverBackgroundColor: [
                                '#FFCD56', '#36A2EB'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutoutPercentage: 60,
                        legend: {
                            position: 'top',
                            labels: {
                                fontSize: 14,
                                boxWidth: 15
                            }
                        },
                        tooltips: {
                            enabled: true
                        },
                        rotation: Math.PI
                    }
                });
            };
        </script>
    </div>
</div>
<div class="clearfix"></div>
<?php init_tail();
require('modules/hr_profile/assets/js/hr_profile_dashboard_js.php');
?>