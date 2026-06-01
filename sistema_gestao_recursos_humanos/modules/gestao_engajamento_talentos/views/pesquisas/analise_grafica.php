<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_desenv_individual/assets/css/plano.css'); ?>">

<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row"> 
            <div class="col-md-6">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Engajamento de Talentos / Analise Grafica
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
                                        aria-hidden="true"></i>Análise Grafica
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="<?php echo admin_url('gestao_engajamento_talentos/pesquisas')?>" class="btn"
                                    style="background-color: #E67E22; border-color: #E67E22; color: white;">
                                    <i class="fa-regular "></i>
                                    Pesquisa de Engajamento
                                </a>
                                <a href="<?php echo admin_url('gestao_engajamento_talentos/pesquisas_pergunta_engajamento')?>"
                                    class="btn" style="background-color: #DAA520; border-color: #DAA520; color: white;">
                                    <i class="fa-regular "></i>
                                    Pergunta de Engajamento
                                </a>
                                <a href="<?php echo admin_url('gestao_engajamento_talentos/pesquisas_resposta_engajamento')?>"
                                    class="btn" style="background-color: #2C3E50; border-color: #2C3E50; color: white;">
                                    <i class="fa-regular "></i>
                                    Resposta de Engajamento
                                </a>
                                <a href="<?php echo admin_url('gestao_engajamento_talentos/algoritmo')?>"
                                    class="btn" style="background-color: #2E8B57; border-color: #2E8B57; color: white;">
                                    <i class="fa-regular "></i> 
                                    Recomendação
                                </a>
                            </div>
                        </div>
                        </br>
                        <div class="row">
                            <div class="col-md-12">
                                <form method="get">
                                    <select name="filtro" id="filtro" class="selectpicker" data-live-search="true"
                                        data-width="100%" data-none-selected-text="Pergunta">
                                        <option value=""></option>
                                        <?php foreach($pergunta_engajamento as $item) : ?>
                                        <option value="<?= $item['id'] ?>"
                                            <?= $item['id'] == $filtro ? 'selected':'' ?>><?= $item['texto'] ?>
                                        </option>
                                        <?php endforeach ?>
                                    </select>
                                    <input type="submit" value="Filtrar" class="btn btn-primary">
                                </form>
                            </div>
                            <br><br><br>
                            <?php if($filtro) : ?>
                            <div class="col-md-6">
                                <h4 class="no-margin font-bold">
                                    Quantidade de Respostas por Colaborador para a Pergunta:
                                    <?= $total_resposta_engajamento ?? 0 ?>
                                </h4>
                                <hr />
                                <div style="height: 400px; overflow-y: auto;">
                                    <canvas id="graficoRespostasColaborador"></canvas>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4 class="no-margin font-bold">
                                    Média de Respostas para a Pergunta: <?= $media_resposta_engajamento ?? 0 ?>
                                </h4>
                                <hr />
                                <div
                                    style="height: 400px; overflow-y: auto; display: flex; justify-content: center; align-items: center;">
                                    <canvas id="graficoMediaRespostas"></canvas>
                                </div>

                            </div>
                            <?php endif ?>
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

<?php require 'modules/gestao_engajamento_talentos/assets/js/analise_grafica.php'; ?>