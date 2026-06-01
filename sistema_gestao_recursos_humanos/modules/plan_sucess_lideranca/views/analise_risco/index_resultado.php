<?php init_head(); ?>
<div id="wrapper">
    <div class="content">

        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Plano de Sucessão e Liderança / Analise Risco / Resultados
                </a>
            </div>
            <div class="col-md-2" style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
            </div>
        </div>

        </br>
        <?php require 'modules/plan_sucess_lideranca/views/analise_risco/cards.php'; ?>

        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Analise de Risco Resultado
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">

                            <div class=" col-md-12">
                                <a href="<?php echo admin_url('plan_sucess_lideranca/analise_risco')?>" class="btn"
                                    style="background-color: #4B0082; border-color: #4B0082; color: white;">
                                    <i class="fa-regular "></i>
                                    Risco
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/analise_risco_impacto')?>"
                                    class="btn" style="background-color: #FFD700; border-color: #FFD700; color: white;">
                                    <i class="fa-regular "></i>
                                    Impacto
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/matriz_risco')?>" class="btn"
                                    style="background-color: #800000; border-color: #800000; color: white;">
                                    <i class="fa-regular "></i>
                                    Matriz de Risco
                                </a>
                            </div>

                        </div>
                        <div class="row">
                            <div class=" col-md-9">
                            </div>

                            <div class=" col-md-3">
                                <select name="nivel_risco_f" id="nivel_risco_f" class="selectpicker" multiple="true"
                                    data-live-search="true" data-width="100%"
                                    data-none-selected-text="<?php echo _l('Nivel de Risco'); ?>">
                                    <option value=""></option>
                                    <option value="Baixa">Baixa</option>
                                    <option value="Moderada">Moderada</option>
                                    <option value="Alta">Alta</option>
                                    <option value="Muito Alta">Muito Alta</option>
                                </select>
                            </div>
                        </div>
                        <br><br>
                        <table class="table table-hover table-bordered table-responsive dt-table">
                            <thead class="thead-custom">
                                <th>Cargo</th>
                                <th>Plano de Contingência</th>
                                <th>Risco</th>
                                <th>Impacto</th>
                                <th>Nivel de Risco</th>
                            </thead>
                            <tbody>
                                <?php foreach($risco_sucessao as $item) : ?>
                                <?php
                                    switch ($item['nivel_risco']) {
                                        case 'Pequeno': $valor_nivel_risco = 1; break;
                                        case 'Medio': $valor_nivel_risco = 2; break;
                                        case 'Alto': $valor_nivel_risco = 3; break;
                                        default: $valor_nivel_risco = 0; break;
                                    }
                                    switch ($item['impacto']) {
                                        case 'Pequeno': $valor_empacto = 1; break;
                                        case 'Medio': $valor_empacto = 2; break;
                                        case 'Grande': $valor_empacto = 3; break;
                                        default: $valor_empacto = 0; break;
                                    }
                                ?>
                                <tr>
                                    <td class="text-capitalize"> <?= htmlspecialchars($item['cargo']); ?> </td>
                                    <td class="text-capitalize"> <?= htmlspecialchars($item['plano_contingencia']); ?>
                                    </td>
                                    <td
                                        style='background: <?= psl_cor_risco($valor_nivel_risco) ?>; color: black; font-weight: bold;'>
                                        <?= $item['nivel_risco'] ?></td>
                                    <td
                                        style='background: <?= psl_cor_risco($valor_empacto) ?>; color: black; font-weight: bold;'>
                                        <?= $item['impacto'] ?></td>
                                    <td
                                        style='background: <?= psl_cor_matriz_risco($valor_nivel_risco * $valor_empacto) ?>; color: black; font-weight: bold;'>
                                        <?= psl_estado_matriz_risco($valor_nivel_risco * $valor_empacto) ?>
                                        (<?= ($valor_nivel_risco * $valor_empacto) ?>)
                                    </td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="btn-bottom-pusher"></div>
</div>
</div>
<div id="new_version"></div>


<?= form_close()  ?>
<?php init_tail(); ?>
<script>
$('#nivel_risco_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(4).search(this.value).draw();
})
</script>