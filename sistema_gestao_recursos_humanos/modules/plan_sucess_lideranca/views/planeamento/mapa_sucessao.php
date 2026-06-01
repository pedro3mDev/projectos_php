<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <?php
            $data_view = [];
            $this->load->view('/admin/menu_modulo/menu', $data_view);
        ?>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Plano de Sucessão e Liderança / Planejamento
                </a>
            </div>
            <div class="col-md-2" style=" display: flex; justify-content: flex-end; align-items: center;">
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
                                <h4 class="font-bold no-margin"><i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Mapa de
                                    Sucessão
                                </h4>
                                <hr />
                            </div>
                        </div>
                        </br>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="<?php echo admin_url('plan_sucess_lideranca/planeamento_resultado')?>"
                                    class="btn btn-success" style="color: white;">
                                    <i class="fa-regular "></i>
                                    Resultados
                                </a>
                                <a href="#" data-toggle="modal" data-target="#modal_add_mapa_sucessao" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Adicionar Mapa de Sucessão
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/plano_desenvolvimento')?>"
                                    class="btn" style="background-color: #b45309; border-color: #b45309; color: white;">
                                    <i class="fa-regular "></i>
                                    Plano de Desenvolvimento
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/posicao_chave')?>" class="btn"
                                    style="background-color: #44403c; border-color: #44403c; color: white;">
                                    <i class="fa-regular "></i>
                                    Posição Chave
                                </a>
                            </div>
                        </div>
                        </br>
                        <div class="row">
                            <div class=" col-md-3">
                            </div>
                            <div class=" col-md-3">
                                <select name="cargo_ms_f" id="cargo_ms_f" class="selectpicker" multiple="true"
                                    data-live-search="true" data-width="100%"
                                    data-none-selected-text="<?php echo _l('cargo'); ?>">
                                    <?php foreach ($cargos as $t) : ?>
                                    <option value="<?= $t['position_name'] ?>"><?= $t['position_name'] ?>
                                    </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class=" col-md-3">
                                <select name="competencia_ms_f" id="competencia_ms_f" class="selectpicker"
                                    multiple="true" data-live-search="true" data-width="100%"
                                    data-none-selected-text="<?php echo _l('competencia'); ?>">
                                    <?php foreach($competencia as $s) { ?>
                                    <option value="<?php echo new_html_entity_decode($s['nome']); ?>">
                                        <?php echo new_html_entity_decode($s['nome']); ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class=" col-md-3">
                                <select name="estado_ms_f" id="estado_ms_f" class="selectpicker" multiple="true"
                                    data-live-search="true" data-width="100%"
                                    data-none-selected-text="<?php echo _l('Estado'); ?>">
                                    <?php foreach($status as $s) { ?>
                                    <option value="<?php echo new_html_entity_decode($s['status']); ?>">
                                        <?php echo new_html_entity_decode($s['status']); ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>

                        </div>
                        <br><br>
                        <table class="table dt-table">
                            <thead class="thead-custom">
                                <th>Cargo</th>
                                <th>Competências</th>
                                <th>Estado</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php
                                            foreach($mapa_sucessao as $item) {
                                        ?>
                                <tr>
                                    <td class="text-capitalize"> <?= $item['cargo']; ?> </td>
                                    <td class="text-capitalize"> <?= $item['competencia']; ?> </td>
                                    <td>
                                        <?php
                                                    $cor = "#999"; // Cor padrão (cinza para pendente)
                                                    if ($item['status'] == "Aprovado") {
                                                        $cor = "green";
                                                    } elseif ($item['status'] == "Rejeitado") {
                                                        $cor = "red";
                                                    }
                                                ?>
                                        <a
                                            style="background-color: <?= $cor ?>; color:#fff; padding: 5px; border-radius:10px;">
                                            <?= htmlspecialchars($item['status']); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php if ($item['status_id'] == 1) : ?>
                                        <a href="<?php echo admin_url('plan_sucess_lideranca/mapa_sucessao_aprovar/'.$item['id']); ?>"
                                            class="btn btn-success" style="color: white;">
                                            Aprovar
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas rejeitar?');"
                                            href="<?php echo admin_url('plan_sucess_lideranca/mapa_sucessao_rejeitar/'.$item['id']); ?>"
                                            class="btn btn-danger" style="color: white;">
                                            Rejeitar
                                        </a>
                                        <?php endif ?>
                                        <a href="<?php echo admin_url('plan_sucess_lideranca/planeamento_visualizar_mapa/'.$item['id'])?>" class="btn btn-success btn-icon">
                                                    <i style="color: white;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?= $item['id'] ?>"
                                            data-cargo="<?= html_entity_decode($item['cargo_id']) ?>"
                                            data-competencia="<?= html_entity_decode($item['competencia_id']) ?>"
                                            data-aprovadores='<?= html_entity_decode(($item["aprovadores"] ?? "")) ?>'
                                            class="btn btn-default btn-icon btn_edit_mapa_sucessao"
                                            style="background-color: #007bff; border-color: #007bff;">
                                            <i style="color: white;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas eliminar este mapa_sucessao?');"
                                            href="<?php echo admin_url('plan_sucess_lideranca/mapa_sucessao_delete/'.$item['id']); ?>"
                                            class="btn btn-danger btn-icon _delete">
                                            <i style="color: white;" class="fa fa-trash"></i>
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

<div class="modal" id="modal_add_mapa_sucessao" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <?= form_open(admin_url('plan_sucess_lideranca/adicionar_mapa_sucessao'), array('method' => 'post')) ?>
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Adicionar Mapa de Sucessão
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="cargo" class="control-label">
                                Cargo <small class="req text-danger">*</small>
                            </label>
                            <select class="form-control" name="cargo">
                                <option value=""></option>
                                <?php foreach ($cargos as $t) : ?>
                                <option value="<?= $t['position_id'] ?>"><?= $t['position_name'] ?>
                                </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <?php
                            $selectedCompetencias = '';
                            echo render_select('competencia', $competencia, ['id', ['nome']], 'Competência<span class="text-danger">*</span>', $selectedCompetencias, [], [], '', '', true);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php
                            $selectedStaff = '';
                            echo render_select('aprovadores[]', $staff_list, ['staffid', ['firstname', 'lastname']], 'Aprovadores<span class="text-danger">*</span>', $selectedStaff, ['multiple' => true], [], '', '', false);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo _l('Cancelar'); ?></button>
                <button type="submit" class="btn btn-success"><?php echo _l('Salvar'); ?></button>
            </div>
        </div>
        <?= form_close()  ?>
    </div>
</div>
<?= form_open(admin_url('plan_sucess_lideranca/editar_mapa_sucessao'), array('method' => 'post', 'id' => 'form_edit_mapa_sucessao')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Editar mapa_sucessao </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="cargo" class="control-label">
                                Cargo <small class="req text-danger">*</small>
                            </label>
                            <select class="form-control" name="e_cargo">
                                <option value=""></option>
                                <?php foreach ($cargos as $t) : ?>
                                <option value="<?= $t['position_id'] ?>"><?= $t['position_name'] ?>
                                </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <?php
                            $selectedCompetencias = '';
                            echo render_select('e_competencia', $competencia, ['id', ['nome']], 'Competência<span class="text-danger">*</span>', $selectedCompetencias, [], [], '', '', true);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php
                            $selectedStaff = '';
                            echo render_select('e_aprovadores[]', $staff_list, ['staffid', ['firstname', 'lastname']], 'Aprovadores<span class="text-danger">*</span>', $selectedStaff, ['multiple' => true], [], '', '', false);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo _l('Cancelar'); ?></button>
                <button type="submit" class="btn btn-success"><?php echo _l('Salvar'); ?></button>
            </div>
        </div>
    </div>
</div>
<?= form_close()  ?>

<?php init_tail(); ?>
<script>
$('.btn_edit_mapa_sucessao').click(function() {
    let cargo = $(this).attr('data-cargo');
    let competencia = $(this).attr('data-competencia');
    let aprovadores = $(this).attr('data-aprovadores');

    let id = $(this).attr('data-id');

    let url = "<?= admin_url('plan_sucess_lideranca/editar_mapa_sucessao') ?>/" + id;
    $('#form_edit_mapa_sucessao').attr('action', url);

    $('select[name="e_cargo"]').val(cargo);
    $('select[name="e_competencia"]').selectpicker('val', competencia);
    $('select[name="e_aprovadores[]"]').selectpicker('val', JSON.parse(aprovadores));

    $('#editar').modal('show');
})
$('#cargo_ms_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(1).search(this.value).draw();
})
$('#competencia_ms_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(2).search(this.value).draw();
})
$('#estado_ms_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(3).search(this.value).draw();
})
</script>