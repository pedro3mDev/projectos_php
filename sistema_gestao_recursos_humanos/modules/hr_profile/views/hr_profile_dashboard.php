<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
$this->load->model('hr_profile/hr_profile_model');
$data_dash = $this->hr_profile_model->get_hr_profile_dashboard_data();

$staff_chart_by_age = json_encode($this->hr_profile_model->staff_chart_by_age());
$contract_type_chart = json_encode($this->hr_profile_model->contract_type_chart());
$staff_departments_chart = json_encode($this->hr_profile_model->staff_chart_by_departments());
$staff_chart_by_job_positions = json_encode($this->hr_profile_model->staff_chart_by_job_positions());
?>

<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        
		<?php
            $data_view = [];
            $this->load->view('/admin/menu_modulo/menu', $data_view);
        ?>
        <div class="row">
            <div class="col-md-6">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Integração / Dashboard
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
                            Total de Funcionários
                        </p>
                        <div class="d-flex align-items-center justify-content-center">
                            <p style="font-size:16px; color:#DAA520;">
                                <i class="fas fa-handshake"></i>
                                <?= number_format($total_funcionarios, 0, '.', ' ') ?>
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
                            Status Onbording
                        </p>
                        <div class="d-flex align-items-center justify-content-center">
                            <p style="font-size:16px; color:#DAA520;">
                                <i class="fas fa-handshake"></i>
                                <?= number_format($total_onbording, 0, '.', ' ') ?>
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
                            Treinamento
                        </p>
                        <div class="d-flex align-items-center justify-content-center">
                            <p style="font-size:16px; color:#DAA520;">
                                <i class="fas fa-handshake"></i>
                                <?= number_format($total_treinamentos, 0, '.', ' ') ?>
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
                            Contratos
                        </p>
                        <div class="d-flex align-items-center justify-content-center">
                            <p style="font-size:16px; color:#DAA520;">
                                <i class="fas fa-handshake"></i> <?= number_format($total_contractos, 0, '.', ' ') ?>
                            </p>
                        </div>
                    </a>
                </div>
            </div>


        </div>

        </br>

        <div class="row">

            <div class="col-md-4">
                <div class="panel_s" style="height: 410px;">
                    <div class="panel-body">
                        <h4 class="no-margin font-bold">
                            <i class="fa fa-address-card-o" aria-hidden="true"></i>Taxa de Rotatividade - Treinamentos
                        </h4>
                        <hr />
                        <div class="col-md-12">
                            <div class="chart-container" style="position: relative; width: 100%; height: 300px;">
                                <canvas id="taxa_rotatividade"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Script -->
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const ctx = document.getElementById('taxa_rotatividade').getContext('2d');

                        var year1 = '<?php echo json_encode($year1); ?>';
                        var m1 = '<?php echo json_encode($month1); ?>';
                        var year2 = '<?php echo json_encode($year2); ?>';
                        var m2 = '<?php echo json_encode($month2); ?>';
                        // console.log(m1);

                        // Dados do gráfico
                        const labels = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho',
                            'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
                        ];

                        const data = {
                            labels: labels,
                            datasets: [{
                                    label: year1 + ' (%)',
                                    data: [m1["1"].total, m1["2"].total, m1["3"].total, m1["4"].total, m1["5"].total, m1["6"].total, m1["7"].total, m1["18"].total, m1["9"].total, m1["10"].total, m1["11"].total, m1["12"].total],
                                    backgroundColor: 'rgba(218,165,32)',
                                    borderColor: 'rgba(255, 255, 255, 1)',
                                    borderWidth: 1
                                },
                                {
                                    label: year2 + ' (%)',
                                    data: [m2["1"].total, m2["2"].total, m2["3"].total, m2["4"].total, m2["5"].total, m2["6"].total, m2["7"].total, m2["18"].total, m2["9"].total, m2["10"].total, m2["11"].total, m2["12"].total],
                                    backgroundColor: 'rgba(139,0,0)',
                                    borderColor: 'rgba(255, 255, 255, 1)',
                                    borderWidth: 1
                                }
                            ]
                        };

                        // Configuração do gráfico
                        const config = {
                            type: 'bar',
                            data: data,
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top' // Exibe a legenda na parte superior
                                    }
                                },
                                scales: {
                                    x: {
                                        grid: {
                                            display: false // Remove as linhas de grade no eixo X
                                        }
                                    },
                                    y: {
                                        grid: {
                                            display: false // Remove as linhas de grade no eixo Y
                                        },
                                        beginAtZero: true,
                                        max: 10 // Limite superior ajustável
                                    }
                                }
                            }
                        };
                        // Cria o gráfico
                        new Chart(ctx, config);
                    });
                </script>
            </div>


            <!-- Segundo Gráfico -->
            <div class="col-md-4">
                <div class="panel_s" style="height: 410px;">
                    <div class="panel-body">
                        <h4 class="no-margin font-bold">
                            <i class="fa fa-address-card-o" aria-hidden="true"></i> Total de Usuários Anuais
                        </h4>
                        <hr />
                        <div class="col-md-12 justify-content-center">
                            <div class="chart-container" style="position: relative; width: 100%; height: 300px;">
                                <canvas id="tendencias_de_pessoal"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Script -->
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const ctx = document.getElementById('tendencias_de_pessoal').getContext('2d');

                        // Dados para o gráfico
                        const labels = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho',
                            'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
                        ];
                        const data = {
                            labels: labels,
                            datasets: [{
                                    label: "<?= date('Y') ?>",
                                    data: <?= $dashboard_usuarios_anuais_actual ?>,
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderWidth: 2,
                                    tension: 0.4, // Suaviza a curva
                                },
                                {
                                    label: "<?= (date('Y') - 1) ?>",
                                    data: <?= $dashboard_usuarios_anuais_anterior ?>,
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    borderWidth: 2,
                                    tension: 0.4, // Suaviza a curva
                                },
                            ]
                        };

                        // Configuração do gráfico
                        const config = {
                            type: 'line',
                            data: data,
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top' // Legenda no topo
                                    }
                                },
                                scales: {
                                    x: {
                                        grid: {
                                            display: false // Remove as linhas de grade no eixo X
                                        }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        grid: {
                                            display: true // Mantém linhas de grade no eixo Y
                                        }
                                    }
                                }
                            }
                        };

                        // Cria o gráfico
                        new Chart(ctx, config);
                    });
                </script>

            </div>

            <!-- Terceiro Gráfico -->
            <div class="col-md-4">
                <div class="panel_s" style="min-height: 410px; width: 100%;">
                    <!-- Usando min-height -->
                    <div class="panel-body">
                        <h4 class="no-margin font-bold">
                            <i class="fa fa-address-card-o" aria-hidden="true"></i> Funcionários por Genero
                        </h4>
                        <hr />
                        <div class="chart-container justify-content-center"
                            style="position: relative; width: 100%; height: 190px;">
                            <canvas id="funcionario_genero"></canvas>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Quarto Gráfico -->
            <div class="col-md-4">
                <div class="panel_s" style="height: 410px;">
                    <div class="panel-body">
                        <h4 class="no-margin font-bold">
                            <i class="fa fa-address-card-o" aria-hidden="true"></i> Onbordings
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

            <!-- Script -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                var ctx = document.getElementById('pedidorecebido').getContext('2d');
                var pedidorecebido = new Chart(ctx, {
                    type: 'bar', // Usando o tipo 'bar' para gráficos de barras horizontais
                    data: {
                        labels: <?= $dashboard_onbording_nomes ?>, // Labels (nome dos itens)
                        datasets: [{
                            label: 'Percentual',
                            data: <?= $dashboard_onbording_persentagens ?>, // Dados das porcentagens
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
                                        return tooltipItem.raw + '%'; // Exibe a porcentagem no tooltip
                                    }
                                }
                            }
                        }
                    }
                });
            </script>



            <!-- Quinto Gráfico --->
            <div class="col-md-8">
                <div class="panel_s" style="min-height: 410px; width: 100%;">
                    <!-- Usando min-height -->
                    <div class="panel-body">
                        <h4 class="no-margin font-bold">
                            <i class="fa fa-address-card-o" aria-hidden="true"></i> Status dos Contratos:
                        </h4>
                        <hr />
                        <div class="col-md-6">
                            <div class="chart-container justify-content-center"
                                style="position: relative; width: 100%; height: 300px;">
                                <canvas id="Linked_in"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6 justify-content-center">
                            <div class="chart-container" style="position: relative; width: 100%; height: 300px;">
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

                var totalFinishContracts = '<?php echo $total_finish_contracts ?? 0; ?>';
                var totalValidContracts = '<?php echo $total_valid_contracts ?? 0; ?>';
                var totalDraftContracts = '<?php echo $total_draft_contracts ?? 0; ?>';
                var totalInvalidContracts = '<?php echo $total_invalid_contracts ?? 0; ?>';

                // Calculando o total combinado de todos os contratos
                var totalCombined = totalFinishContracts + totalValidContracts + totalDraftContracts + totalInvalidContracts;

                // Calculando a porcentagem de contratos finalizados
                var percentageFinish = 0;
                if (totalCombined > 0) {
                    percentageFinish = (totalFinishContracts / totalCombined) * 100;
                }

                // Calculando a porcentagem de contratos válidos
                var percentageValid = 0;
                if (totalCombined > 0) {
                    percentageValid = (totalValidContracts / totalCombined) * 100;
                }

                // Calculando a porcentagem de contratos em rascunho
                var percentageDraft = 0;
                if (totalCombined > 0) {
                    percentageDraft = (totalDraftContracts / totalCombined) * 100;
                }

                // Calculando a porcentagem de contratos inválidos
                var percentageInvalid = 0;
                if (totalCombined > 0) {
                    percentageInvalid = (totalInvalidContracts / totalCombined) * 100;
                }


                // Inicializar o gráfico "Linked_in"
                var ctx1 = document.getElementById('Linked_in').getContext('2d');
                var LinkedInChart = new Chart(ctx1, {
                    type: 'doughnut',
                    data: {
                        labels: ['Rascunho', 'Invalido'],
                        datasets: [{
                            label: 'Tipo de Contrato',
                            data: [percentageDraft, percentageInvalid],
                            backgroundColor: ['#336', '#FFCD56'],
                            hoverBackgroundColor: ['#36A2EB', '#FFCD56']
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutoutPercentage: 60,
                        legend: {
                            position: 'top',
                        },
                        tooltips: {
                            enabled: true
                        }
                    }
                });

                // Inicializar o gráfico "website"
                var ctx2 = document.getElementById('website').getContext('2d');
                var websiteChart = new Chart(ctx2, {
                    type: 'doughnut',
                    data: {
                        labels: ['Valido', 'Finalizado'],
                        datasets: [{
                            label: 'Tipo de Contrato Adicional',
                            data: [percentageValid, percentageFinish],
                            backgroundColor: ['#336', '#FFCD56'],
                            hoverBackgroundColor: ['#FFCD56', '#36A2EB']
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutoutPercentage: 60,
                        legend: {
                            position: 'top',
                        },
                        tooltips: {
                            enabled: true
                        }
                    }
                });

                // Inicializar o gráfico "tipo_contrato_emprego"
                var ctx3 = document.getElementById('funcionario_genero').getContext('2d');
                var tipoContratoEmpregoChart = new Chart(ctx3, {
                    type: 'doughnut',
                    data: {
                        labels: ['Homens', 'Mulher', 'Não Defenidos'],
                        datasets: [{
                            label: 'Funcionários',
                            data: <?= $dasboard_func_genero ?>,
                            backgroundColor: ['#336', '#DAA520'],
                            hoverBackgroundColor: ['#36A2EB', '#FFCD56']
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

                // Inicializar o gráfico "tipo_contrato_adicional"
                var ctx4 = document.getElementById('tipo_contrato_adicional').getContext('2d');
                var tipoContratoAdicionalChart = new Chart(ctx4, {
                    type: 'doughnut',
                    data: {
                        labels: ['Meio Periodo', 'Periodo Completo'],
                        datasets: [{
                            label: 'Tipo de Contrato Adicional',
                            data: [10, 90],
                            backgroundColor: ['#DAA520', '#336'],
                            hoverBackgroundColor: ['#FFCD56', '#36A2EB']
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



        <div class="row">
            <div class="col-md-12 p-0">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="widget" id="widget-<?php echo basename(__FILE__, ".php"); ?>"
                            data-name="<?php echo _l('hr_hr_profile'); ?>">
                            <div class="row">

                                <div class="col-md-12">
                                    <div id="report_by_staffs">
                                    </div>
                                </div>

                                <hr class="hr-panel-heading-dashboard">



                                <div class="col-md-12">

                                    <h4>
                                        <p class="padding-5 bold"><?php echo _l('hr_birthday_in_month'); ?></p>
                                    </h4>
                                    <hr class="hr-panel-heading-dashboard">
                                    <table class="table dt-table scroll-responsive">
                                        <thead>
                                            <th><?php echo _l('hr_hr_staff_name'); ?></th>
                                            <th><?php echo _l('staff_dt_email'); ?></th>
                                            <th><?php echo _l('staff_add_edit_phonenumber'); ?></th>
                                            <th><?php echo _l('hr_hr_birthday'); ?></th>
                                            <th><?php echo _l('hr_sex'); ?></th>
                                            <th><?php echo _l('departments'); ?></th>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $list_member_id = [];
                                            foreach ($data_dash['staff_birthday'] as $staff) {
                                            ?>

                                                <tr>
                                                    <td><a
                                                            href="<?php echo admin_url('hr_profile/member/' . $staff['staffid']); ?>"><?php echo staff_profile_image($staff['staffid'], ['staff-profile-image-small',]); ?></a>
                                                        <a
                                                            href="<?php echo admin_url('hr_profile/member/' . $staff['staffid']); ?>"><?php echo $staff['firstname'] . ' ' . $staff['lastname'] . ' - ' . $staff['staff_identifi']; ?></a>
                                                    </td>
                                                    <td><?php echo $staff['email']; ?></td>
                                                    <td><?php echo $staff['phonenumber']; ?></td>
                                                    <td><?php echo _d($staff['birthday']); ?></td>
                                                    <td><?php echo _l($staff['sex']); ?></td>
                                                    <td>
                                                        <?php

                                                        $departments = $this->departments_model->get_staff_departments($staff['staffid']);
                                                        if (isset($departments[0])) {
                                                            $team = $this->hr_profile_model->hr_profile_get_department_name($departments[0]['departmentid']);
                                                            $str = '';
                                                            $j = 0;
                                                            foreach ($team as $value) {
                                                                $j++;
                                                                $str .= '<span class="label label-tag tag-id-1"><span class="tag">' . $value . '</span><span class="hide">, </span></span>&nbsp';
                                                                if ($j % 2 == 0) {
                                                                    $str .= '<br><br/>';
                                                                }
                                                            }
                                                            echo $str;
                                                        } else {
                                                            echo '';
                                                        } ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>


                                    <h4>
                                        <p class="padding-5 bold"><?php echo _l('hr_unfinished_staff_received'); ?></p>
                                    </h4>
                                    <hr class="hr-panel-heading-dashboard">
                                    <?php
                                    $table_data = array(
                                        _l('staff_id'),
                                        _l('hr_hr_staff_name'),
                                        _l('hr_hr_job_position'),
                                        _l('departments'),
                                        _l('hr_hr_finish')
                                    );


                                    render_datatable($table_data, 'table_staff');
                                    ?>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<?php init_tail();
require('modules/hr_profile/assets/js/hr_profile_dashboard_js.php');
?>