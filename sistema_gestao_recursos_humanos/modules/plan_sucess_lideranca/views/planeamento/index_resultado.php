<?php init_head(); ?>
<div id="wrapper">
    <div class="content">

        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Plano de Sucessão e Liderança / Planeamento / Resultados
                </a>
            </div>
            <div class="col-md-2" style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
            </div>
        </div>

        </br>
        <?php require 'modules/plan_sucess_lideranca/views/planeamento/cards_planeamento.php'; ?>
        </br>

        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Planeamento Resultado
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="<?php echo admin_url('plan_sucess_lideranca/planeamento')?>" class="btn"
                                    style="background-color: #DAA520; border-color: #DAA520; color: white;">
                                    <i class="fa-regular "></i>
                                    Mapa Sucessão
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/plano_desenvolvimento')?>"
                                    class="btn" style="background-color: #b45309; border-color: #b45309; color: white;">
                                    <i class="fa-regular "></i>
                                    Plano Desenvolvimento
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/posicao_chave')?>" class="btn"
                                    style="background-color: #44403c; border-color: #44403c; color: white;">
                                    <i class="fa-regular "></i>
                                    Posição Chave
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
                                    <option value="Não Sucessor">Não Sucessor</option>
                                    <option value="Sucessor">Sucessor</option>
                                    <option value="Potêncial Sucessor">Potêncial Sucessor</option>
                                </select>
                            </div>
                        </div>
                        <br><br>
                        <table class="table table-hover table-bordered table-responsive dt-table">
                            <thead class="thead-custom">
                                <th>Nome Candidato</th>
                                <th>Competências Atendidadas</th>
                                <th>Lacunas</th>
                                <th>Posição Chave</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach($plano_desenvolvimento as $item) : ?>
                                <tr>
                                    <td><?= $item['firstname'] .' '.$item['lastname']; ?></td>
                                    <td class="text-capitalize">???</td>
                                    <td class="text-capitalize"> <?= $item['competencia']; ?> </td>
                                    <td class="text-capitalize"> <?= $item['posicao_chave']; ?> </td>
                                    <td>
                                        <?php
                                            $cor = "#999"; // Cor padrão (cinza para pendente)
                                            $estado = ""; // Cor padrão (cinza para pendente)
                                            if ($item['nivel_critico'] == 'Pequeno') {
                                                $cor = "red";
                                                $estado = "Não Sucessor";
                                            } elseif ($item['nivel_critico'] == 'Medio') {
                                                $cor = "blue";
                                                $estado = "Sucessor";
                                            } elseif ($item['nivel_critico'] == 'Alto') {
                                                $cor = "green";
                                                $estado = "Potêncial Sucessor";
                                            }
                                            else {
                                                $estado = $item['nivel_critico'];
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
    tabela.column(4).search(this.value).draw();
})
</script>