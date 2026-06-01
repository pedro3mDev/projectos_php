<?php init_head(); ?>
<div id="wrapper">
    <div class="content">

        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Plano de Sucessão e Liderança / Identificação / Resultados
                </a>
            </div>
            <div class="col-md-2" style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
            </div>
        </div>
        </br>
        <?php require 'modules/plan_sucess_lideranca/views/identificacao/cards.php'; ?>
        </br>

        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Resultado (Algoritmo)
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="<?php echo admin_url('plan_sucess_lideranca/potencial_desenvolvimento')?>"
                                    class="btn" style="background-color: #DAA520; border-color: #DAA520; color: white;">
                                    <i class="fa-regular "></i>
                                    Potencial Desenvolvimento
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/identificacao')?>" class="btn"
                                    style="background-color: #b91c1c; border-color: #b91c1c; color: white;">
                                    <i class="fa-regular "></i>
                                    Talentos
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/avaliacao_competencias')?>"
                                    class="btn" style="background-color: #86198f; border-color: #86198f; color: white;">
                                    <i class="fa-regular "></i>
                                    Avaliação de Competências
                                </a>
                            </div>

                        </div>
                        <div class="row">
                            <div class=" col-md-9">
                            </div>
                            <div class=" col-md-3">
                                <select name="estado_f" id="estado_f" class="selectpicker" data-live-search="true"
                                    data-width="100%" data-none-selected-text="<?php echo _l('Estado'); ?>">
                                    <option value=""></option>
                                    <option value="Não Classificado">Não Classificado</option>
                                    <option value="Classificado">Classificado</option>
                                    <option value="Potencial Talento">Potencial Talento</option>
                                </select>
                            </div>
                        </div>
                        <br><br>
                        <table class="table table-hover table-bordered table-responsive dt-table">
                            <thead class="thead-custom">
                                <th>Nome</th>
                                <th>Media Competencia</th>
                                <th>Nota Potencial</th>
                                <th>Estado</th>
                            </thead>
                            <tbody>
                                <?php foreach ($avaliacoes_competencia as $item) : ?>
                                <tr>
                                    <td><?= $item['firstname'] .' '.$item['lastname']; ?></td>
                                    <td class="text-capitalize"><?= $item['competencia']; ?></td>
                                    <td><?= $item['nota']; ?></td>
                                    <td>
                                        <?php
                                            $cor = "#999"; // Cor padrão (cinza para pendente)
                                            $estado = ""; // Cor padrão (cinza para pendente)
                                            if ($item['nota'] <= 9) {
                                                $cor = "red";
                                                $estado = "Não Classificado";
                                            } elseif ($item['nota'] <= 14) {
                                                $cor = "blue";
                                                $estado = "Classificado";
                                            } elseif ($item['nota'] >= 15) {
                                                $cor = "green";
                                                $estado = "Potencial Talento";
                                            }
                                        ?>
                                        <a
                                            style="background-color: <?= $cor ?>; color:#fff; padding: 5px; border-radius:10px;">
                                            <?= $estado ?>
                                        </a>
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
$('#estado_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(3).search(this.value).draw();
})
</script>