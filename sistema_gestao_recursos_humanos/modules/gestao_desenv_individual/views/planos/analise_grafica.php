<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_desenv_individual/assets/css/plano.css'); ?>">

<div id="wrapper">
    <div class="content">
        <br><br><br><br><br><br>
        <div class="row">
            <div class="col-md-6">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                Gestão de Desenvolvimento Individual / Plano / Análise Gráfica
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
                        <div class="row mt-2">
                            <?php require 'modules/gestao_desenv_individual/assets/js/analise_grafica.php'; ?>
                            
                            <div class="col-md-6">
                                <div id="graficobarras" style="width: 100%; height: 400px;"></div>
                            </div>
                            <div class="col-md-6">
                                <div id="graficolinha" style="width: 100%; height: 400px;"></div>
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

<script src="https://cdn.jsdelivr.net/npm/echarts@5"></script>
<script>
    // Gráfico de Barras
    var chartDomBarra = document.getElementById('graficobarras');
    var myChartBarra = echarts.init(chartDomBarra);
    var optionBarra = {
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
            data: ['Mon', 'Tue', 'Wed', 'Thu']  
        },
        yAxis: {
            type: 'value'
        },
        series: [
            {
                data: [120, 200, 150, 80], 
                type: 'bar',
                itemStyle: {
                    color: '#336'
                }
            }
        ]
    };
    myChartBarra.setOption(optionBarra);
    window.addEventListener('resize', function() {
        myChartBarra.resize();
    });

    // Gráfico de Linha
    var chartDomLinha = document.getElementById('graficolinha');
    var myChartLinha = echarts.init(chartDomLinha);
    var optionLinha = {
        xAxis: {
            type: 'category',
            data: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez']
        },
        yAxis: {
            type: 'value'
        },
        series: [
            {
                data: [820, 932, 901, 934, 1290, 1330, 1320, 1430, 1550, 1600, 1700, 1800],
                type: 'line',
                smooth: true
            }
        ]
    };
    myChartLinha.setOption(optionLinha);
    window.addEventListener('resize', function() {
        myChartLinha.resize();
    });
</script>
