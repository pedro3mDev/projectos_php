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
                    Plano de Sucessão e Liderança / Identificação / Avaliação
                    de Competências
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
                                    Avaliação de Competências
                                </h4>
                                <hr />
                            </div>
                        </div>
                        </br>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="<?php echo admin_url('plan_sucess_lideranca/identificacao_resultado')?>"
                                    class="btn btn-success" style="color: white;">
                                    <i class="fa-regular "></i>
                                    Resultados
                                </a>
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Adicionar Avaliação de Competência
                                </a>
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
                            </div>
                            <div class=" col-md-6">
                            </div>
                            <div class=" col-md-3">
                                <select name="competencia_ac_f" id="competencia_ac_f" class="selectpicker"
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
                                <select name="estado_ac_f" id="estado_ac_f" class="selectpicker" multiple="true"
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
                                <th>Funcionário</th>
                                <th>Competência</th>
                                <th>Nota</th>
                                <th>Data de Avaliação</th>
                                <th>Estado</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php
                                            foreach($avaliacoes_competencia as $item) {
                                        ?>
                                <tr>
                                    <td>
                                        <?= $item['firstname'] .' '.$item['lastname']; ?>
                                    </td>
                                    <td class="text-capitalize"> <?= $item['competencia']; ?> </td>
                                    <td class="text-capitalize"> <?= $item['nota']; ?> </td>
                                    <td class="text-capitalize"> <?= $item['data_avaliacao']; ?> </td>
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
                                        <a href="<?php echo admin_url('plan_sucess_lideranca/avaliacao_competencias_aprovar/'.$item['id']); ?>"
                                            class="btn btn-success" style="color: white;">
                                            Aprovar
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas rejeitar?');"
                                            href="<?php echo admin_url('plan_sucess_lideranca/avaliacao_competencias_rejeitar/'.$item['id']); ?>"
                                            class="btn btn-danger" style="color: white;">
                                            Rejeitar
                                        </a>
                                        <?php endif ?>
                                        <a href="<?php echo admin_url('plan_sucess_lideranca/identificacao_visualizar_avaliacao/'.$item['id'])?>" class="btn btn-success btn-icon">
                                                    <i style="color: white;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?= $item['id'] ?>"
                                            data-funcionario='<?= $item["staff_id"] ?>'
                                            data-competencia="<?= html_entity_decode($item['competencia_id']) ?>"
                                            data-nota="<?= html_entity_decode($item['nota']) ?>"
                                            data-data_avaliacao="<?= html_entity_decode($item['data_avaliacao']) ?>"
                                            data-aprovadores='<?= html_entity_decode(($item["aprovadores"] ?? "")) ?>'
                                            class="btn btn-default btn-icon btn_edit_avaliacao_competencias"
                                            style="background-color: #007bff; border-color: #007bff;">
                                            <i style="color: white;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas eliminar este Avalição?');"
                                            href="<?php echo admin_url('plan_sucess_lideranca/avaliacao_competencias_delete/'.$item['id']); ?>"
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

<div class="modal" id="modal_add" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <?= form_open(admin_url('plan_sucess_lideranca/adicionar_avaliacao_competencias'), array('method' => 'post')) ?>
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Adicionar Avaliação de Competência
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <?php
                            $selectedStaff = '';
                            echo render_select('funcionario', $staffs, ['staffid', ['firstname', 'lastname']], 'Funcionário<span class="text-danger">*</span>', $selectedStaff, [], [], '', '', true);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php
                            $selectedCompetencias = '';
                            echo render_select('competencia', $competencia, ['id', ['nome']], 'Competência<span class="text-danger">*</span>', $selectedCompetencias, [], [], '', '', true);
                            ?>
                        </div>
                        <div class="form-group" app-field-wrapper="nota">
                            <label for="nota" class="control-label">
                                Nota <small class="req text-danger">*</small>
                            </label>
                            <input type="number" id="nota" name="nota" min="0" max="20" class="form-control" required>
                        </div>
                        <div class="form-group" app-field-wrapper="data_avaliacao">
                            <label for="data_avaliacao" class="control-label">
                                Data de Avaliação <small class="req text-danger">*</small>
                            </label>
                            <input type="date" id="data_avaliacao" name="data_avaliacao" class="form-control" required>
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
<?= form_open(admin_url('plan_sucess_lideranca/editar_avaliacao_competencias'), array('method' => 'post', 'id' => 'form_edit_avaliacao_competencias')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Editar Talento </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <?php
                            $selectedStaff = '';
                            echo render_select('e_funcionario', $staffs, ['staffid', ['firstname', 'lastname']], 'Funcionário<span class="text-danger">*</span>', $selectedStaff, [], [], '', '', true);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php
                            $selectedCompetencias = '';
                            echo render_select('e_competencia', $competencia, ['id', ['nome']], 'Competência<span class="text-danger">*</span>', $selectedCompetencias, [], [], '', '', true);
                            ?>
                        </div>
                        <div class="form-group" app-field-wrapper="nota">
                            <label for="nota" class="control-label">
                                Nota <small class="req text-danger">*</small>
                            </label>
                            <input type="number" id="nota" name="e_nota" class="form-control" min="0" max="20" required>
                        </div>
                        <div class="form-group" app-field-wrapper="data_avaliacao">
                            <label for="data_avaliacao" class="control-label">
                                Data de Avaliação <small class="req text-danger">*</small>
                            </label>
                            <input type="date" id="data_avaliacao" name="e_data_avaliacao" class="form-control"
                                required>
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
// avaliacao_competencias
$('.btn_edit_avaliacao_competencias').click(function() {
    let funcionario = $(this).attr('data-funcionario');
    let competencia = $(this).attr('data-competencia');
    let nota = $(this).attr('data-nota');
    let data_avaliacao = $(this).attr('data-data_avaliacao');
    let aprovadores = $(this).attr('data-aprovadores');

    let id = $(this).attr('data-id');

    let url = "<?= admin_url('plan_sucess_lideranca/editar_avaliacao_competencias') ?>/" + id;
    $('#form_edit_avaliacao_competencias').attr('action', url);

    $('select[name="e_funcionario"]').selectpicker('val', funcionario);
    $('select[name="e_competencia"]').selectpicker('val', competencia);
    $('input[name="e_nota"]').val(nota);
    $('input[name="e_data_avaliacao"]').val(data_avaliacao);
    $('select[name="e_aprovadores[]"]').selectpicker('val', JSON.parse(aprovadores));

    $('#editar').modal('show');
})
$('#estado_ac_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(4).search(this.value).draw();
})
$('#competencia_ac_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(1).search(this.value).draw();
})
</script>