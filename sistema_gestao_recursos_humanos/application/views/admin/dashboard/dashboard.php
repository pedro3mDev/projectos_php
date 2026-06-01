<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="screen-options-area"></div>
    <div class="screen-options-btn">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="tw-w-5 tw-h-5 ltr:tw-mr-1 rtl:tw-ml-1">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>

        <?= _l('dashboard_options'); ?>
    </div>
    <div class="content">
        <?php
            $data_view = [];
            $this->load->view('/admin/menu_modulo/menu', $data_view);
        ?>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Dashboard
                </a>
            </div>
            <div class="col-md-2">
               
                <button  
                    id="actionButton"
                    class="btn" 
                    onclick="alterarBotao()" 
                    style="width: 100%; background-color:green; color:#fff; border-bottom: 1px solid yellow; padding: 15px; font-size: 12px; font-weight: bold; border-radius: 8px; text-transform: uppercase;">  
                    Fazer Check In
                </button>
                <script>
                        var btnCheckIn = "<?php echo $check_status ; ?>";
                        if (btnCheckIn == 0) {
                                    const button = document.getElementById('actionButton');  
                                    button.style.backgroundColor = 'red'; // Muda a cor do botão
                                    button.innerText = 'Fazer Check Out'; // Altera o texto do botão
                                }else{
                                    const button = document.getElementById('actionButton');  
                                    button.style.backgroundColor = 'green'; // Muda a cor do botão
                                    button.innerText = 'Fazer Check Out'; // Altera o texto do botão
                        }
                </script>
            
            </div>
        </div>
        </br>

        <div class="row">
            <div class="col-md-3">
                <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column" style="border-bottom: 1px solid #336; border-left: 4px solid #8B0000; ">
                    <a class="text-warning text-center mbot15">
                        <p class="text-uppercase mtop5 minheight35"
                            style="font-size: 14px; font-weight: bold; color:#DAA520;">
                            Funcionários
                        </p>
                        <div class="d-flex align-items-center justify-content-center">
                            <p style="font-size:16px; color:#DAA520;"> 
                                <i class="fas fa-users fontsize24 me-2"></i>
                                <?= number_format($total_funcionarios, 0, '.',' ') ?>
                            </p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column" style="border-bottom: 1px solid #336; border-left: 4px solid #8B0000; ">
                    <a class="text-warning text-center mbot15">
                        <p class="text-uppercase mtop5 minheight35"
                            style="font-size: 14px; font-weight: bold; color:#DAA520;">
                            Campanhas
                        </p>
                        <div class="d-flex align-items-center justify-content-center">
                            <p style="font-size:16px; color:#DAA520;">
                                <i class="fas fa-bullhorn fontsize24 me-2"></i>
                                <?= number_format($dashboard_campanha['total'], 0, '.',' ') ?>
                            </p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column" style="border-bottom: 1px solid #336; border-left: 4px solid #8B0000; ">
                    <a class="text-warning text-center mbot15">
                        <p class="text-uppercase mtop5 minheight35"
                            style="font-size: 14px; font-weight: bold; color:#DAA520;">
                            Candidaturas
                        </p>
                        <div class="d-flex align-items-center justify-content-center">
                            <p style="font-size:16px; color:#DAA520;">
                            <i class="fas fa-user-plus fontsize24 me-2"></i>
                            <?= number_format($dashboard_total_candidatos, 0, '.',' ') ?>
                            </p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column" style="border-bottom: 1px solid #336; border-left: 4px solid #8B0000; ">
                    <a class="text-warning text-center mbot15">
                        <p class="text-uppercase mtop5 minheight35"
                            style="font-size: 14px; font-weight: bold; color:#DAA520;">
                            Entrevistas
                        </p>
                        <div class="d-flex align-items-center justify-content-center">
                            <p style="font-size:16px; color:#DAA520;">
                                <i class="fas fa-comments fontsize24 me-2"></i>
                                <?= number_format($dashboard_candidatos_por_status[3], 0, '.',' ') ?>
                            </p>
                        </div>
                    </a>
                </div>
            </div>


            <div class="col-md-3">
                <div style="height:20px;"></div>
                <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column" style="border-bottom: 1px solid #336; border-left: 4px solid #8B0000; ">
                    <a class="text-warning text-center mbot15">
                        <p class="text-uppercase mtop5 minheight35"
                            style="font-size: 14px; font-weight: bold; color:#DAA520;">
                            Onbordings
                        </p>
                        <div class="d-flex align-items-center justify-content-center">
                            <p style="font-size:16px; color:#DAA520;">
                                <i class="fas fa-user-check fontsize24 me-2"></i>
                                <?= number_format($dashboard_total_onbording, 0, '.',' ') ?>
                            </p>
                        </div>
                    </a>
                </div> 
            </div>

            <div class="col-md-3">
                <div style="height:20px;"></div>
                <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column" style="border-bottom: 1px solid #336; border-left: 4px solid #8B0000; ">
                    <a class="text-warning text-center mbot15">
                        <p class="text-uppercase mtop5 minheight35"
                            style="font-size: 14px; font-weight: bold; color:#DAA520;">
                            Treinamentos 
                        </p>
                        <div class="d-flex align-items-center justify-content-center">
                            <p style="font-size:16px; color:#DAA520;">
                                <i class="fas fa-chalkboard-teacher fontsize24 me-2"></i>
                                <?= number_format($dashboard_total_treinamentos, 0, '.',' ') ?>
                            </p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-3">
                <div style="height:20px;"></div>
                <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column" style="border-bottom: 1px solid #336; border-left: 4px solid #8B0000; ">
                    <a class="text-warning text-center mbot15">
                        <p class="text-uppercase mtop5 minheight35"
                            style="font-size: 14px; font-weight: bold; color:#DAA520;">
                            Contratos
                        </p>
                        <div class="d-flex align-items-center justify-content-center">
                            <p style="font-size:16px; color:#DAA520;">
                                <i class="fas fa-file-signature fontsize24 me-2"></i>
                                <?= number_format($dashboard_total_contractos, 0, '.',' ') ?>
                            </p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-3">
                <div style="height:20px;"></div>
                <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column" style="border-bottom: 1px solid #336; border-left: 4px solid #8B0000; ">
                    <a class="text-warning text-center mbot15">
                        <p class="text-uppercase mtop5 minheight35"
                            style="font-size: 14px; font-weight: bold; color:#DAA520;">
                            Viagens
                        </p>
                        <div class="d-flex align-items-center justify-content-center">
                            <p style="font-size:16px; color:#DAA520;">
                                <i class="fas fa-plane-departure fontsize24 me-2"></i>
                                <?= number_format($dashboard_total_viagens, 0, '.',' ') ?>
                            </p>
                        </div>
                    </a>
                </div>
            </div>
        </div>


        </br>

        <div class="row">

            <div class="col-md-6">
                <div class="panel_s">
                    <div class="panel-body" style=" height: 400px; overflow-y: auto;">
                        <h4 class="no-margin font-bold">
                            <i class="fa fa-address-card-o" aria-hidden="true"></i> Total de Funcionários Cadastrados
                        </h4>
                        <hr />
                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
                        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-rounded-bar"></script>

                        <style>
                        .chart-container {
                            position: relative;
                            width: 100%;
                            height: 300px;
                        }
                        </style> 
                        <div class="chart-container">
                            <canvas id="graficoBarras"></canvas>
                        </div>
                        <script>
                        const ctx = document.getElementById('graficoBarras').getContext('2d');
                        const graficoBarras = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: [
                                    'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio',
                                    'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro',
                                    'Novembro', 'Dezembro'
                                ],
                                datasets: [{
                                    label: 'Total Cadastrados',
                                    data: <?= $dashboard_func_cadastro ?>,

                                    backgroundColor: 'rgba(184, 134, 11, 0.7)',
                                    borderColor: 'rgba(255, 2555, 255)',
                                    borderWidth: 1,
                                    borderRadius: 0
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: false,

                                    },
                                    tooltip: {
                                        enabled: true
                                    },
                                    datalabels: {
                                        color: '#000', // Cor do texto
                                        font: {
                                            weight: ''
                                        },
                                        align: 'end', // Alinha o texto no final da barra
                                        anchor: 'end', // Posiciona o texto sobre a barra
                                        formatter: function(value) {
                                            return `${value}`; // Formata o valor com o símbolo $
                                        }
                                    }
                                },
                                scales: {
                                    x: {
                                        grid: {
                                            display: false
                                        },
                                    },
                                    y: {
                                        grid: {
                                            display: false
                                        },
                                        ticks: {
                                            display: false
                                        }, // Oculta os rótulos
                                    }
                                }
                            },
                            plugins: [ChartDataLabels] // Ativando o plugin
                        });
                        </script>
                    </div>
                </div>
            </div>


            <!-- Canvas do gráfico -->
            <div class="col-md-6">
                <div class="panel_s" >
                    <div class="panel-body" style=" height: 400px; overflow-y: auto;">
                        <h4 class="no-margin font-bold">
                            <i class="fa fa-address-card-o" aria-hidden="true"></i> Funcionários
                        </h4>
                        <hr />
                        <style>
                        .chart-container {
                            position: relative;
                            width: 100%;
                            height: 300px;
                        }
                        </style>
                        <div class="col-md-6 justify-content-center">
                            <div class="chart-container">
                                <canvas id="tipo_contrato_emprego"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6 justify-content-center">
                            <div class="chart-container">
                                <canvas id="tipo_contrato_adicional"></canvas>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Carregar os scripts do Chart.js -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <!-- Script para inicializar os gráficos -->
            <script>
                window.onload = function() { 
                    var ctx1 = document.getElementById('tipo_contrato_emprego').getContext('2d');
                    var tipoContratoEmpregoChart = new Chart(ctx1, {
                        type: 'doughnut',
                        <?= $dashboard_roles ?>,
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutoutPercentage: 60,
                            legend: {
                                position: 'bottom', // Move a legenda para baixo
                            },
                            tooltips: {
                                enabled: true
                            }
                        }
                    });

                    var ctx2 = document.getElementById('tipo_contrato_adicional').getContext('2d');
                    var tipoContratoAdicionalChart = new Chart(ctx2, {
                        type: 'doughnut',
                        <?= $dashboard_departamento ?>,
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutoutPercentage: 60,
                            legend: {
                                position: 'bottom', // Move a legenda para baixo
                            },
                            tooltips: {
                                enabled: true
                            }
                        }
                    });
                };
                </script>


        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin font-bold">
                            <i class="fa fa-address-card-o" aria-hidden="true"></i> Funcionários Cadastrados
                        </h4>
                        <hr />
                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

                        <div class="chart-container" style="position: relative; width: 100%; height: 300px;">
                            <canvas id="graficoContratados"></canvas>
                        </div>
                        <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const ctx = document.getElementById('graficoContratados').getContext('2d');
                            new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: [
                                        'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio',
                                        'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro',
                                        'Novembro', 'Dezembro'
                                    ],
                                    datasets: [{
                                            label: '<?= (date('Y')) ?>',
                                            data: <?= $dashboard_total_func_anuais_actual ?>,
                                            backgroundColor: 'rgba(184, 134, 11, 0.7)',
                                            borderColor: 'rgba(255, 2555, 255)',
                                            borderWidth: 1,
                                            borderRadius: 15 // Barras arredondadas
                                        },
                                        {
                                            label: '<?= (date('Y')-1) ?>',
                                            data: <?= $dashboard_total_func_anuais_anterior ?>,
                                            backgroundColor: 'rgba(128, 0, 0, 0.9)',
                                            borderColor: 'rgba(255, 255, 255)',
                                            borderWidth: 1,
                                            borderRadius: 15 // Barras arredondadas
                                        }
                                    ]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: {
                                            display: true,
                                        },
                                        tooltip: {
                                            enabled: true
                                        },
                                        datalabels: {
                                            color: '#000', // Cor do texto
                                            font: {
                                                weight: 'bold'
                                            },
                                            align: 'end', // Alinha o texto no final da barra
                                            anchor: 'end', // Posiciona o texto sobre a barra
                                            formatter: function(value) {
                                                return value; // Exibe apenas o número
                                            }
                                        }
                                    },
                                    scales: {
                                        x: {
                                            grid: {
                                                display: false, // Oculta a linha de fundo do eixo X
                                            },
                                        },
                                        y: {
                                            grid: {
                                                display: false, // Oculta a linha de fundo do eixo Y
                                            },
                                            ticks: {
                                                display: false, // Oculta os rótulos do eixo Y
                                            }
                                        }
                                    }
                                },
                            });
                        });
                        </script>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12" data-container="left-8">
                <?php render_dashboard_widgets('left-8'); ?>
            </div>
            <script>
            app.calendarIDs = '<?= json_encode($google_ids_calendars); ?>';
            </script>
        </div>

    </div>
</div>

<style>
    .scrollable {
        overflow-y: auto;
        max-height: 110px; 
    }
</style>

<?php init_tail(); ?>
<?php $this->load->view('admin/utilities/calendar_template'); ?>
<?php $this->load->view('admin/dashboard/dashboard_js'); ?>
</body>

</html> 