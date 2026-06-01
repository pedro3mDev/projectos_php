<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_desenv_individual/assets/css/plano.css'); ?>">

<div id="wrapper">
    <div class="content">
        <br><br><br><br><br><br>
        <div class="row">
            <div class="col-md-6">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Desenvolvimento Individual / Mentoria / Análise Gráfica
                </a>
            </div>
            <div class="col-md-6" style="display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
            </div>
        </div>
        <br>

        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i> Análise Gráfica
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <select name="tipo_viagem_f" id="tipo_viagem_f" class="selectpicker" multiple="true"
                                    data-live-search="true" data-width="100%"
                                    data-none-selected-text="<?php echo _l('Desenvolvimento'); ?>">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <?php require 'modules/gestao_desenv_individual/assets/js/analise_grafica.php'; ?>

                                 <!-- Novo gráfico com ECharts -->
                                <div style="margin-top: 20px;">
                                    <h5 style="text-align: center; font-weight: bold; color: #333;">Mentoria</h5>
                                    <div id="graficoEcharts" style="width: 100%; height: 400px; margin: 0; padding: 0;"></div>
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
<?php echo form_close(); ?>
<div class="btn-bottom-pusher"></div>
<div id="new_version"></div>
<?php init_tail(); ?>

<!-- ECharts -->
<script src="https://cdn.jsdelivr.net/npm/echarts@5"></script>
<script>
    var chartDom = document.getElementById('graficoEcharts');
    var myChart = echarts.init(chartDom);
    var option = {
        title: {
            text: '',
            left: 'center',
            top: 0,
            textStyle: {
                fontSize: 18,
                fontWeight: 'normal'
            }
        },
        xAxis: {
            type: 'category',
            data: ['Mon', 'Tue', 'Wed', 'Thu'],
            boundaryGap: true, // Mantendo o espaço nas extremidades
        },
        yAxis: {
            type: 'value',
        },
        series: [
            {
                data: [120, 200, 150, 80],
                type: 'bar', // Mantendo o gráfico de barras
                itemStyle: {
                    color: '#336'
                },
                barWidth: '40%' // Reduzindo a largura das barras (valor percentual)
            }
        ],
        grid: {
            left: '5%', // Reduzindo a margem esquerda
            right: '5%', // Reduzindo a margem direita
            top: '10%', // Ajustando a margem superior
            bottom: '10%', // Ajustando a margem inferior
        }
    };
    myChart.setOption(option);

    window.addEventListener('resize', function() {
        myChart.resize();
    });
</script>
