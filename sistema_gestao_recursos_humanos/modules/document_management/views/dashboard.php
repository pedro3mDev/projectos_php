<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
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
                Gestão Documental / Dashboard
            </a>
            </div>
        </div>
        
        </br> 

        <div class="row">
            <div class="col-md-3">
                <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column" style="border-bottom: 1px solid #336; border-left: 4px solid #8B0000;">
                    <a class="text-warning text-center mbot15">
                        <p class="text-uppercase mtop5 minheight35" style="font-size: 14px; font-weight: bold; color:#DAA520;;">
                            Categorias
                        </p>
                        <div class="d-flex align-items-center justify-content-center">
                            <p style="font-size:16px; color:#DAA520;"> 
                                <i class="fas fa-list"></i> 
                                2
                            </p>                             
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column" style="border-bottom: 1px solid #336; border-left: 4px solid #8B0000;">
                    <a class="text-warning text-center mbot15">
                        <p class="text-uppercase mtop5 minheight35" style="font-size: 14px; font-weight: bold; color:#DAA520;;">
                            Concluidas
                        </p>
                        <div class="d-flex align-items-center justify-content-center">
                            <p style="font-size:16px; color:#DAA520;">  
                                <i class="fas fa-check-circle"></i>
                                3
                            </p>                             
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column" style="border-bottom: 1px solid #336; border-left: 4px solid #8B0000;">
                    <a class="text-warning text-center mbot15">
                        <p class="text-uppercase mtop5 minheight35" style="font-size: 14px; font-weight: bold; color:#DAA520;;">
                            Total
                        </p>
                        <div class="d-flex align-items-center justify-content-center">
                            <p style="font-size:16px; color:#DAA520;">  
                                <i class="fas fa-folder"></i> 
                                0

                            </p>                             
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column" style="border-bottom: 1px solid #336; border-left: 4px solid #8B0000;">
                    <a class="text-warning text-center mbot15">
                        <p class="text-uppercase mtop5 minheight35" style="font-size: 14px; font-weight: bold; color:#DAA520;;">
                            Em Revisão 
                        </p>
                        <div class="d-flex align-items-center justify-content-center">
                            <p style="font-size:16px; color:#DAA520;">  
                                <i class="fas fa-edit"></i> 0
                            </p>                             
                        </div>
                    </a>
                </div>

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
                            Total de Itens
                        </p>
                        <div class="d-flex align-items-center justify-content-center">
                            <p style="font-size:16px; color:#DAA520;">
                                <i class="fas fa-list"></i>
                                <?= number_format($dashoboard_total, 0, ' ', '.') ?>
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
                            Total de Secções
                        </p>
                        <div class="d-flex align-items-center justify-content-center">
                            <p style="font-size:16px; color:#DAA520;">
                                <i class="fas fa-folder"></i>
                                <?= number_format($dashboard_total_seccoes, 0, ' ', '.') ?>
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
                            Total de Pastas
                        </p>
                        <div class="d-flex align-items-center justify-content-center">
                            <p style="font-size:16px; color:#DAA520;">
                                <i class="fas fa-folder"></i>
                                <?= number_format($dashboard_total_pastas, 0, ' ', '.') ?>
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
                            Total de Arquivos
                        </p>
                        <div class="d-flex align-items-center justify-content-center">
                            <p style="font-size:16px; color:#DAA520;">
                                <i class="fas fa-file"></i> <?= number_format($dashboard_total_arquivos, 0, ' ', '.') ?>
                            </p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        </br>

        <div class="row">

            <div class="col-md-8">
                <div class="panel_s" style=" height: 410px; overflow-y: auto;">
                    <div class="panel-body">
                        <h4 class="no-margin font-bold">
                            <i class="fa fa-address-card-o" aria-hidden="true"></i> Secções Recentes
                        </h4>
                        <hr />
                        <div>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th id="titulo1" class="text-center">Nome</th>
                                        <th class="titulo2" class="text-center">Data</th>
                                        <th class="titulo2" class="text-center">Criado por</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($dashboard_seccoes == null) : ?>
                                    <tr>
                                        <td colspan="4" class="text-danger">Sem Dados</td>
                                    </tr>
                                    <?php else : ?>
                                    <?php foreach ($dashboard_seccoes as $seccao) : ?>
                                    <tr>
                                        <td class="text-center"><?= $seccao['name'] ?> </td>
                                        <td class="text-center"><?= $seccao['dateadded'] ?> </td>
                                        <td class="text-center"><?= $seccao['firstname'] .' '.$seccao['lastname'] ?>
                                        </td>
                                    </tr>
                                    <?php endforeach ?>
                                    <?php endif ?>
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
            <div class="col-md-4">
                <div class="panel_s" style="height: 410px;">
                    <div class="panel-body">
                        <h4 class="no-margin font-bold">
                            <i class="fa fa-address-card-o" aria-hidden="true"></i>Análise
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

                    // Dados do gráfico
                    const labels = ['Geral', 'Secções', 'Pastas', 'Arquivos'];

                    const data = {
                        labels: labels,
                        datasets: [{
                                label: 'Aprovado (%)',
                                data: [
                                    <?= $dashoboard_total_aprovados ?>,
                                    <?= $dashoboard_total_aprovados_seccao ?>,
                                    <?= $dashoboard_total_aprovados_pasta ?>,
                                    <?= $dashoboard_total_aprovados_ficheiro ?>
                                ],
                                backgroundColor: 'rgba(218,165,32)',
                                borderColor: 'rgba(255, 255, 255, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Pendentes (%)',
                                data: [
                                    <?= $dashoboard_total_pendentes ?>,
                                    <?= $dashoboard_total_pendentes_seccao ?>,
                                    <?= $dashoboard_total_pendentes_pasta ?>,
                                    <?= $dashoboard_total_pendentes_ficheiro ?>
                                ],
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
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="panel_s" style=" height: 410px; overflow-y: auto;">
                    <div class="panel-body">
                        <h4 class="no-margin font-bold">
                            <i class="fa fa-address-card-o" aria-hidden="true"></i> Histórico de Documentos
                        </h4>
                        <hr />

                        <div>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th id="titulo1" class="text-center"></th>
                                        <th class="titulo2" class="text-center">Nome</th>
                                        <th class="titulo2" class="text-center">Tamanho</th>
                                        <th class="titulo2" class="text-center">Data</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($dashboard_documentos_all as $doc) : ?>
                                    <?php
                                        if ($doc['filetype'] == 'folder') {
                                            $item = FCPATH .('modules/document_management/uploads/files/'.$doc['parent_id']) ;
                                            $tamanho = tamanho_pasta($item);
                                        }
                                        else {
                                            $item = FCPATH . ('modules/document_management/uploads/files/'.$doc['parent_id'].'/'.$doc['name']);
                                            $tamanho = tamanho_arquivo($item);
                                        }
                                    ?>
                                    <tr>
                                        <td class="text-center">
                                            <i class="fas fa-folder-open"></i>
                                        </td>
                                        <td class="text-center"><?= $doc['name'] ?></td>
                                        <td class="text-center"><?= $tamanho ?></td>
                                        <td class="text-center"><?= $doc['dateadded'] ?></td>
                                    </tr>
                                    <?php endforeach ?>
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
            <div class="col-md-4">
                <div class="panel_s" style=" height: 410px; overflow-y: auto;">
                    <div class="panel-body">
                        <h4 class="no-margin font-bold">
                            <i class="fa fa-address-card-o" aria-hidden="true"></i> Aprovados Recentes
                        </h4>
                        <hr />

                        <div>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th id="titulo1" class="text-center"></th>
                                        <th class="titulo2" class="text-center">Nome</th>
                                        <th class="titulo2" class="text-center">Criado por</th>
                                        <th class="titulo2" class="text-center">Data</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($dashboard_documentos_aprovados as $doc) : ?>
                                    <tr>
                                        <td class="text-center">
                                            <i class="fas fa-folder-open"></i>
                                        </td>
                                        <td class="text-center"><?= $doc['name'] ?></td>
                                        <td class="text-center"><?= $doc['firstname'] .' '. $doc['lastname'] ?></td>
                                        <td class="text-center"><?= $doc['dateadded'] ?></td>
                                    </tr>
                                    <?php endforeach ?>
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

            <!-- Terceiro Gráfico -->
            <div class="col-md-4">
                <div class="panel_s" style="height: 410px; width: 100%;">
                    <div class="panel-body">
                        <h4 class="no-margin font-bold">
                            <i class="fa fa-address-card-o" aria-hidden="true"></i> Resumo
                        </h4>
                        <hr />
                        <div class="chart-container justify-content-center"
                            style="position: relative; width: 100%; height: 190px;">
                            <canvas id="funcionario_genero"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Script -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
            window.onload = function() {
                // Inicializar o gráfico "funcionario_genero"
                var ctx3 = document.getElementById('funcionario_genero').getContext('2d');
                var tipoContratoEmpregoChart = new Chart(ctx3, {
                    type: 'doughnut',
                    data: {
                        labels: ['Pendente', 'Aprovado'], // Rótulos das seções
                        datasets: [{
                            label: 'Resumo',
                            data: [<?= $dashoboard_total_pendentes ?>,
                                <?= $dashoboard_total_aprovados ?>
                            ], // Valores correspondentes aos rótulos
                            backgroundColor: ['#DAA520', '#28a745'], // Cores de fundo
                            hoverBackgroundColor: ['#FFCD56', '#7FFF00']
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    fontSize: 14,
                                    boxWidth: 15
                                }
                            },
                            tooltip: {
                                enabled: true
                            }
                        },
                        cutout: '60%', // Propriedade atualizada para Chart.js 3+
                        rotation: Math.PI
                    }
                });
            };
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
<div class="clearfix"></div>
<?php init_tail();
?>