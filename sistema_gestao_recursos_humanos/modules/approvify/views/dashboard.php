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
                    Gestão de Requisições / Dashboard
                </a>
            </div>
        </div>
        </br>

        <div class="row">
            </br>
            <div class="row">

                <div class="col-md-3">
                    <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column"
                        style="border-bottom: 1px solid #336; border-left: 4px solid #8B0000;">
                        <a class="text-warning text-center mbot15">
                            <p class="text-uppercase mtop5 minheight35"
                                style="font-size: 14px; font-weight: bold; color:#DAA520;;">
                                Categorias
                            </p>
                            <div class="d-flex align-items-center justify-content-center">
                                <p style="font-size:16px; color:#DAA520;">
                                    <i class="fas fa-list"></i>
                                    <?= $totalCategories; ?>
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
                                Aprovadas
                            </p>
                            <div class="d-flex align-items-center justify-content-center">
                                <p style="font-size:16px; color:#DAA520;">
                                    <i class="fas fa-check-circle"></i>
                                    <?= $totalRequestsByStatusAprovado; ?>
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
                                Total
                            </p>
                            <div class="d-flex align-items-center justify-content-center">
                                <p style="font-size:16px; color:#DAA520;">
                                    <i class="fas fa-calculator"></i>
                                    <?= $totalRequests; ?>
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
                                Em Revisão
                            </p>
                            <div class="d-flex align-items-center justify-content-center">
                                <p style="font-size:16px; color:#DAA520;">
                                    <i class="fas fa-edit"></i>
                                    <?= $totalRequestsByStatusRevisao; ?>
                                </p>
                            </div>
                        </a>
                    </div>
                </div>


            </div>

            </br>

            <div class="row">

                <!-- 1º Gráfico -->
                <div class="col-md-8">
                    <div class="panel_s" style=" height: 410px; overflow-y: auto;">
                        <div class="panel-body">
                            <h4 class="no-margin font-bold">
                                <i class="fa fa-address-card-o" aria-hidden="true"></i> Categorias com o Maior Número de
                                Requisições
                            </h4>
                            <hr />

                            <div>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th id="titulo1" class="text-center">Categorias</th>
                                            <th class="titulo2" class="text-center">Total de Requisição</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($topCategories as $topCategorie) {
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $topCategorie["category_name"]; ?></td>
                                            <td class="text-center"><?= $topCategorie["total_requests"]; ?></td>
                                        </tr>
                                        <?php     # code...
                                        } ?>
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
                <!-- 2º -->
                <div class="col-md-4">
                    <div class="panel_s" style=" height: 410px; overflow-y: auto; width: 100%;">
                        <div class="panel-body">
                            <h4 class="no-margin font-bold">
                                <i class="fa fa-address-card-o" aria-hidden="true"></i> Status Requições
                            </h4>
                            <hr />
                            <canvas id="satisfactionChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                    <!-- Adicione o script do Chart.js -->
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                    let totalAprovado =
                        '<?php echo intval(html_entity_decode($totalRequestsByStatusAprovado ?? 0)); ?>';
                    let totalRecusado =
                        '<?php echo intval(html_entity_decode($totalRequestsByStatusRecusado ?? 0)); ?>';
                    let totalCancelado =
                        '<?php echo intval(html_entity_decode($totalRequestsByStatusCancelado ?? 0)); ?>';
                    let totalRevisao = '<?php echo intval(html_entity_decode($totalRequestsByStatusRevisao ?? 0)); ?>';

                    const ctx = document.getElementById('satisfactionChart').getContext('2d');
                    const satisfactionChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Aprovado', 'Recusado', 'Cancelado', 'Revisao'],
                            datasets: [{
                                label: 'Nível de Satisfação',
                                data: [totalAprovado, totalRecusado, totalCancelado,
                                    totalRevisao
                                ], // Substitua pelos dados reais
                                backgroundColor: [
                                    '#272645', // Aprovado
                                    '#333366', // Recusado
                                    '#4a4aab', // Cancelado
                                    '#6874c9', // Revisao
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

                <!-- 3º Gráfico -->
                <div class="col-md-12">
                    <div class="panel_s" style=" height: 410px; overflow-y: auto; width: 100%;">
                        <div class="panel-body">
                            <h4 class="no-margin font-bold">
                                <i class="fa fa-address-card-o" aria-hidden="true"></i> Requisições por Aprovar
                            </h4>
                            <hr />

                            <div>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th id="titulo1" class="text-center">Titulo</th>
                                            <th class="titulo2" class="text-center">Estado</th>
                                            <th class="titulo2" class="text-center">Data</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($requisicao_pendentes as $r) : ?>
                                        <tr>
                                            <td class="text-center"><?= html_entity_decode($r['request_title']) ?></td>
                                            <td class="text-center">Revisão</td>
                                            <td class="text-center"><?= html_entity_decode($r['created_at']) ?></td>
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



            </div>



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