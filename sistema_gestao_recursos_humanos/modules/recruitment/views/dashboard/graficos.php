<div class="row">
    <div class="col-md-4">
        <div class="panel_s">
            <div class="panel-body" style=" height: 400px; overflow-y: auto;">
                <h4 class="no-margin font-bold">
                    <i class="fa fa-address-card-o" aria-hidden="true"></i> 
                    Proporção de diversidade de gênero
                </h4>
                <hr />
                <canvas id="genderDiversityChart" width="400" height="200"></canvas>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            let proporcaoPercentual0 = <?php echo intval(html_entity_decode($proporcao_genero[0]["proporcao_percentual"])); ?>;
            let proporcaoPercentual1 = <?php echo intval(html_entity_decode($proporcao_genero[1]["proporcao_percentual"])); ?>;
            document.addEventListener("DOMContentLoaded", function() {
                const ctx = document.getElementById('genderDiversityChart').getContext('2d');
                new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Feminino', 'Masculino'],
                    datasets: [{
                        data: [proporcaoPercentual0 ?? 0, proporcaoPercentual1], 
                            backgroundColor: ['#800000', '#006400'], 
                            borderWidth: 0 // Remove borda
                        }]
                },
                options: {
                    rotation: Math.PI, // Inicia na metade (parte superior)
                    circumference: Math.PI, // Mostra apenas metade do círculo
                    cutout: '70%', // Define o tamanho do "buraco" interno
                    plugins: {
                        legend: {
                            display: true, // Exibe a legenda
                            position: 'bottom',
                            labels: {
                                font: {
                                    size: 14
                                }
                            }
                        },
                        tooltip: {
                            enabled: true // Exibe tooltips
                        }
                    }
                }
                });
            });
        </script>    
    </div>

    <div class="col-md-4">
        <div class="panel_s">
            <div class="panel-body" style=" height: 400px; overflow-y: auto;">
                <h4 class="no-margin font-bold">
                    <i class="fa fa-address-card-o" aria-hidden="true"></i> Total Candidatos Por Status
                </h4>
                <hr />
                <canvas id="satisfactionChart" width="400" height="200"></canvas>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('satisfactionChart').getContext('2d');
            const satisfactionChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [
                        '<?php echo _l('application'); ?>', 
                        '<?php echo _l('potential'); ?>', 
                        '<?php echo _l('interview'); ?>', 
                        '<?php echo _l('won_interview'); ?>', 
                        '<?php echo _l('send_offer'); ?>', 
                        '<?php echo _l('elect'); ?>', 
                        '<?php echo _l('non_elect'); ?>', 
                        '<?php echo _l('unanswer'); ?>', 
                        '<?php echo _l('transferred'); ?>', 
                        '<?php echo _l('freedom'); ?>',
                    ],
                    datasets: [{
                        label: 'Nível de Satisfação',
                        data: <?= $total_candidatos_por_status ?>, // Substitua pelos dados reais
                        backgroundColor: [
                            '#28a745', // application
                            '#8bc34a', // potential
                            '#ffc107', // interview
                            '#ff5722', // won_interview
                            '#d32f2f', // send_offer
                            '#d38f5f', // elect
                            '#d32f6f', // non_elect
                            '#d33f7f', // unanswer
                            '#d62f2f', // transferred
                            '#d16f2f', // freedom
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 5
                            }
                        }
                    }
                }
            });
        </script>
    </div>
            
    <div class="col-md-4" >
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <div class="panel_s">
                <div class="panel-body" style=" height: 400px; overflow-y: auto;">
                    <h4 class="no-margin font-bold">
                        <i class="fa fa-address-card-o" aria-hidden="true"></i> 
                        Campanhas Com Mais Candidatos
                    </h4>
                        <hr />
                        <canvas id="semiDonutChart" width="400" height="200"></canvas>
                    </div>
                </div>
                <script>
                   let percentual_candidatos0_campanha = '<?php echo $campanhas_com_mais_candidatos[0]["nome_campanha"] ?? ""; ?>';
                   let percentual_candidatos1_campanha = '<?php echo $campanhas_com_mais_candidatos[1]["nome_campanha"] ?? ""; ?>';
                   let percentual_candidatos2_campanha = '<?php echo $campanhas_com_mais_candidatos[2]["nome_campanha"] ?? ""; ?>';

                    let percentual_candidatos0 = '<?php echo $campanhas_com_mais_candidatos[0]["percentual_candidatos"] ?? 0; ?>';
                    let percentual_candidatos1 = '<?php echo $campanhas_com_mais_candidatos[1]["percentual_candidatos"] ?? 0; ?>';
                    let percentual_candidatos2 = '<?php echo $campanhas_com_mais_candidatos[2]["percentual_candidatos"] ?? 0; ?>';

                    document.addEventListener("DOMContentLoaded", function() {
                        const ctx = document.getElementById('semiDonutChart').getContext('2d');

                        new Chart(ctx, {
                            type: 'doughnut',
                            data: {
                                labels: [percentual_candidatos0_campanha, percentual_candidatos1_campanha, percentual_candidatos2_campanha],
                                datasets: [{
                                    data: [percentual_candidatos0, percentual_candidatos1, percentual_candidatos2], // Valores para cada segmento
                                    backgroundColor: ['#800000', '#DAA520', '#336'], // Cores
                                    borderWidth: 0 // Remove borda
                                }]
                            },
                            options: {
                                rotation: Math.PI, // Inicia na metade (parte superior)
                                circumference: Math.PI, // Mostra apenas metade do círculo
                                cutout: '70%', // Define o tamanho do "buraco" interno
                                plugins: {
                                    legend: {
                                        display: true, // Exibe a legenda
                                        position: 'bottom',
                                    },
                                    tooltip: {
                                        enabled: true // Exibe tooltips
                                    }
                                },
                            }
                        });
                    });
                </script>
            </div>

        </div>

        </br>
        <div class="row">

            <div class="col-md-6">
                <div class="panel_s" style=" height: 400px; overflow-y: auto;">
                    <div class="panel-body">
                        <h4 class="no-margin font-bold">
                            <i class="fa fa-address-card-o" aria-hidden="true"></i>Número Candidatos Por Campanha
                        </h4>
                        <hr />

                        <div>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <thead>
                                        <tr>
                                            <?php foreach ($numero_candidatos_por_campanha as $iten) { ?>
                                                <?php if (empty($iten['campaign_name'])) : ?>
                                                <td class="text-center titulo2"><?= _l('campanha_candidatos_nao_definida'); ?></td>
                                                <?php else : ?>
                                                <td class="text-center titulo2"><?php echo html_entity_decode($iten['campaign_name'] ?? ""); ?></td>
                                                <?php endif ?>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php foreach ($numero_candidatos_por_campanha as $iten) { ?>
                                            <td class="text-center"><?php echo html_entity_decode($iten['total_candidatos']); ?></td>
                                        <?php } ?>
                                    </tr>
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
            <div class="col-md-6">
                <div class="panel_s" style=" height: 400px; overflow-y: auto;">
                    <div class="panel-body">
                        <h4 class="no-margin font-bold">
                            <i class="fa fa-address-card-o" aria-hidden="true"></i> Total Candidatos Por Status
                        </h4>
                        <hr />

                        <div>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th id="titulo1" class="text-center">Status</th>
                                        <th class="titulo2" class="text-center">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center"><?php echo _l('application'); ?></td>
                                        <td class="text-center"><?= number_format($candidatos_status[1], 0, ' ', '.') ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"><?php echo _l('potential'); ?></td>
                                        <td class="text-center"><?= number_format($candidatos_status[2], 0, ' ', '.') ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"><?php echo _l('interview'); ?></td>
                                        <td class="text-center"><?= number_format($candidatos_status[3], 0, ' ', '.') ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"><?php echo _l('won_interview'); ?></td>
                                        <td class="text-center"><?= number_format($candidatos_status[4], 0, ' ', '.') ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"><?php echo _l('send_offer'); ?></td>
                                        <td class="text-center"><?= number_format($candidatos_status[5], 0, ' ', '.') ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"><?php echo _l('elect'); ?></td>
                                        <td class="text-center"><?= number_format($candidatos_status[6], 0, ' ', '.') ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"><?php echo _l('non_elect'); ?></td>
                                        <td class="text-center"><?= number_format($candidatos_status[7], 0, ' ', '.') ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"><?php echo _l('unanswer'); ?></td>
                                        <td class="text-center"><?= number_format($candidatos_status[8], 0, ' ', '.') ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"><?php echo _l('transferred'); ?></td>
                                        <td class="text-center"><?= number_format($candidatos_status[9], 0, ' ', '.') ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"><?php echo _l('freedom'); ?></td>
                                        <td class="text-center"><?= number_format($candidatos_status[10], 0, ' ', '.') ?></td>
                                    </tr>
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
        </div>


