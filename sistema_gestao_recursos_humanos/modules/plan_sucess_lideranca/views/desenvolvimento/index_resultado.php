<?php init_head(); ?>
<div id="wrapper">
    <div class="content">

        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Plano de Sucessão e Liderança / Desenvolvimento / Resultados
                </a>
            </div>
            <div class="col-md-2" style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
            </div>
        </div>

        </br>
        <?php require 'modules/plan_sucess_lideranca/views/desenvolvimento/cards.php'; ?>

        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Desenvolvimento Resultado
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="<?php echo admin_url('plan_sucess_lideranca/desenvolvimento')?>" class="btn"
                                    style="background-color: #86198f; border-color: #86198f; color: white;">
                                    <i class="fa-regular "></i>
                                    Liderança
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/desenvolvimento_treinamento')?>"
                                    class="btn" style="background-color: #DAA520; border-color: #DAA520; color: white;">
                                    <i class="fa-regular "></i>
                                    Treinamento
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/desenvolvimento_avaliacao1')?>"
                                    class="btn" style="background-color: #b91c1c; border-color: #b91c1c; color: white;">
                                    <i class="fa-regular "></i>
                                    Avalição
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                            </div>

                            <div class=" col-md-3">
                                <select name="estado_f" id="estado_f" class="selectpicker" data-live-search="true"
                                    data-width="100%" data-none-selected-text="<?php echo _l('Estado'); ?>">
                                    <option value=""></option>
                                    <?php foreach($feedback as $f) : ?>
                                    <option value="<?= $f['nome'] ?>"><?= $f['nome'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <br><br>
                        <table class="table table-hover table-bordered table-responsive dt-table">
                            <thead class="thead-custom">
                                <th>Funcionário(Talento)</th>
                                <th>Programa</th>
                                <th>Carga Horária</th>
                                <th>Nota</th>
                                <th>Feedback</th>
                            </thead>
                            <tbody>
                                <?php foreach($avaliacao_lideranca as $item) : ?>
                                <tr>
                                    <td class="text-capitalize">
                                        <?= htmlspecialchars($item['firstname'] .' '.$item['lastname']); ?> </td>
                                    <td class="text-capitalize"> <?= htmlspecialchars($item['programa']); ?> </td>
                                    <td class="text-capitalize"> <?= htmlspecialchars($item['carga_horaria']); ?> </td>
                                    <td class="text-capitalize"> <?= htmlspecialchars($item['nota']); ?> </td>
                                    <td>
                                        <?php
                                            $cor = "#999"; // Cor padrão (cinza para pendente)
                                            if ($item['feedback'] == "Excelente") {
                                                $cor = "green";
                                            } elseif ($item['feedback'] == "Bom") {
                                                $cor = "blue";
                                            } elseif ($item['feedback'] == "Razuavel") {
                                                $cor = "black";
                                            } elseif ($item['feedback'] == "Mau") {
                                                $cor = "orange";
                                            } elseif ($item['feedback'] == "Pessimo") {
                                                $cor = "red";
                                            }
                                        ?>
                                        <a
                                            style="background-color: <?= $cor ?>; color:#fff; padding: 5px; border-radius:10px;">
                                            <?= htmlspecialchars($item['feedback']); ?>
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
<div id="new_version"></div>
<?php init_tail(); ?>
<script>
$('#estado_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(4).search(this.value).draw();
})
</script>