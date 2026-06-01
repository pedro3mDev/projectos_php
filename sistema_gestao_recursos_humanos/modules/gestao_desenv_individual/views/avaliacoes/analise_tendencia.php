<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_desenv_individual/assets/css/plano.css'); ?>">

<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-6">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Desenvolvimento Individual / Avaliações de Desempenho / Análise
                </a>
            </div>
            <div class="col-md-6" style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
            </div>
        </div>
        </br>

        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold"><i class="fa fa-address-card-o"
                                        aria-hidden="true"></i>Análise de Desempenho
                                </h4>
                                <hr />
                            </div>
                        </div>

                        <div class="row">
                            <div class=" col-md-12">
                                <a href="<?php echo admin_url('gestao_desenv_individual/avaliacoes')?>"
                                    class="btn" style="background-color: #DAA520; border-color: #DAA520; color: white;">
                                    <i class="fa-regular "></i>
                                    Avaliações de Desempenho
                                </a>
                                <a href="<?php echo admin_url('gestao_desenv_individual/recomendar_planos')?>"
                                    class="btn" style="background-color: #DC143C; border-color: #DC143C; color: white;">
                                    <i class="fa-regular "></i>
                                    Recomendar Planos
                                </a>
                            </div>
                            </br>
                            </br>
                            </br>
                            <div class=" col-md-12">
                                <div class="form-group">
                                    <?php
                                    $selectedStaff = '';
                                    echo render_select('funcionário', $staff, ['staffid', ['firstname', 'lastname']], 'Funcionário<span class="text-danger">*</span>', $selectedStaff, [], [], '', '', true);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                                <canvas id="graficoAvaliacao"></canvas>
                                <?php require 'modules/gestao_desenv_individual/assets/js/avaliacoes.php'; ?>

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
</div>
<?php echo form_close(); ?>
<div class="btn-bottom-pusher"></div>
</div>
</div>
<div id="new_version"></div>
<?php init_tail(); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script>
    $(document).ready(function () {
        let ctx = document.getElementById('graficoAvaliacao').getContext('2d');
        let graficoAvaliacao = null;

        function carregarGrafico(funcionario_id = null) {
            let url = '<?= base_url("gestao_desenv_individual/get_avaliacoes_grafico"); ?>';

            if (funcionario_id) {
                url += '/' + funcionario_id;
            }

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    let nomes = [];
                    let pontuacoes = [];

                    // Verifica se há dados
                    if (!data || data.length === 0) {
                        $('#graficoAvaliacao').hide();
                        $('.grafico-mensagem').remove();
                        $('#graficoAvaliacao').after('<p class="grafico-mensagem" style="text-align: center; color: red;">Nenhum dado disponível.</p>');
                        return;
                    }

                    // Remove qualquer mensagem anterior
                    $('.grafico-mensagem').remove();
                    $('#graficoAvaliacao').show();

                    // Preenche os dados do gráfico
                    data.forEach(avaliacao => {
                        nomes.push(avaliacao.nome);
                        pontuacoes.push(avaliacao.pontuacao);
                    });

                    // Se o gráfico já existir, destrói antes de recriar
                    if (graficoAvaliacao) {
                        graficoAvaliacao.destroy();
                    }

                    // Criando um novo gráfico
                    graficoAvaliacao = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: nomes,
                            datasets: [{
                                label: 'Pontuação (%)',
                                data: pontuacoes,
                                backgroundColor: 'rgba(0, 0, 255, 0.5)',
                                borderColor: 'blue',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
                                tooltip: { enabled: true },
                                datalabels: {
                                    anchor: 'end',
                                    align: 'top',
                                    formatter: function (value) {
                                        return value + "%";
                                    },
                                    font: { weight: 'bold' }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    max: 100,
                                    title: { display: true, text: "Pontuação (%)" }
                                }
                            }
                        },
                        plugins: [ChartDataLabels]
                    });
                },
                error: function () {
                    console.error("Erro ao buscar dados das avaliações.");
                    $('.grafico-mensagem').remove();
                    $('#graficoAvaliacao').after('<p class="grafico-mensagem" style="text-align: center; color: red;">Erro ao carregar os dados.</p>');
                }
            });
        }

        // Carregar gráfico inicial com as 12 maiores pontuações
        carregarGrafico();

        // Atualiza ao selecionar um funcionário
        $('select[name="funcionário"]').on('change', function () {
            let funcionario_id = $(this).val();
            carregarGrafico(funcionario_id);
        });
    });
</script>