<?php init_head(); ?>
<div id="wrapper">
    <div class="content">

        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Plano de Sucessão e Liderança / Engajamento / Resultados
                </a>
            </div>
            <div class="col-md-2" style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
            </div>
        </div>

        </br>
        <?php require 'modules/plan_sucess_lideranca/views/engajamento/cards.php'; ?>

        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Engajamento Resultado
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">

                            <div class=" col-md-12">
                                <a href="<?php echo admin_url('plan_sucess_lideranca/engajamento')?>" class="btn"
                                    style="background-color: #DAA520; border-color: #DAA520; color: white;">
                                    <i class="fa-regular "></i>
                                    Estrategia
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/engajamento_programa')?>"
                                    class="btn" style="background-color: #b91c1c; border-color: #b91c1c; color: white;">
                                    <i class="fa-regular "></i>
                                    Programa Retenção
                                </a>
                            </div>

                        </div>
                        <div class="row">
                            <div class=" col-md-9">
                            </div>

                            <div class=" col-md-3">
                                <select name="estado_f" id="estado_f" class="selectpicker" multiple="true"
                                    data-live-search="true" data-width="100%"
                                    data-none-selected-text="<?php echo _l('Estado'); ?>">
                                    <option value=""></option>
                                    <option value="Baixo">Baixo</option>
                                    <option value="Normal">Normal</option>
                                    <option value="Alto">Alto</option>
                                </select>
                            </div>
                        </div>
                        <br><br>
                        <table class="table table-hover table-bordered table-responsive dt-table">
                            <thead class="thead-custom">
                                <th>Estratégia</th>
                                <th>Funcionário (Talento)</th>
                                <th>Nº de Feedback</th>
                                <th>Nivel de Engajamento</th>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($estrategia_engajamento as $item) {
                                ?>
                                <tr>
                                    <td class="text-capitalize"> <?= htmlspecialchars($item['estrategia']); ?> </td>
                                    <td class="text-capitalize">
                                        <?= htmlspecialchars($item['firstname'] .' '. $item['lastname']); ?> </td>
                                    <td> <?= psl_contar_engajamento($item['id']) ?> </td>
                                    <td>
                                        <?php
                                            $cor = "#999"; // Cor padrão (cinza para pendente)
                                            $estado = ""; // Cor padrão (cinza para pendente)
                                            if (psl_contar_engajamento($item['id']) <= 9) {
                                                $cor = "red";
                                                $estado = "Baixo";
                                            } elseif (psl_contar_engajamento($item['id']) <= 14) {
                                                $cor = "blue";
                                                $estado = "Normal";
                                            } elseif (psl_contar_engajamento($item['id']) >= 15) {
                                                $cor = "green";
                                                $estado = "Alto";
                                            }
                                        ?>
                                        <a
                                            style="background-color: <?= $cor ?>; color:#fff; padding: 5px; border-radius:10px;">
                                            <?= $estado ?>
                                        </a>
                                    </td>
                                </tr>
                                <?php } ?>
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
$('#estado_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(3).search(this.value).draw();
})
</script>