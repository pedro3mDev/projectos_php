<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Plano de Sucessão e Liderança / Feedback de Liderança
                </a>
            </div>
            <div class="col-md-2" style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
            </div>
        </div>
        </br>
        <!--?php require 'modules/plan_sucess_lideranca/views/identificacao/cards.php'; ?-->
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Feedback de Liderança
                                </h4>
                                <hr />
                            </div>
                        </div>

                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white; ">
                                    <i class="fa-regular "></i>
                                    Novo Feedback
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/mentoria_coaching')?>" class="btn"
                                    style="background-color: #DAA520; border-color: #DAA520; color: white;">
                                    <i class="fa-regular "></i>
                                    Mentoria
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/mentoria_coaching_coaching')?>"
                                    class="btn" style="background-color: #b91c1c; border-color: #b91c1c; color: white;">
                                    <i class="fa-regular "></i>
                                    Coaching
                                </a>
                            </div>
                        </div>

                        <div class="row">
                            <div class=" col-md-9">
                            </div>
                            <div class=" col-md-3">
                                <select name="mentor_f" id="mentor_f" class="selectpicker" multiple="true"
                                    data-live-search="true" data-width="100%"
                                    data-none-selected-text="<?php echo _l('Mentor'); ?>">
                                    <?php foreach($staffs as $s) { ?>
                                    <option
                                        value="<?php echo new_html_entity_decode($s['firstname'].' '.$s['lastname']); ?>">
                                        <?php echo new_html_entity_decode($s['firstname'].' '.$s['lastname']); ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <br><br>
                        <table class="table table-hover table-bordered table-responsive dt-table">
                            <thead class="thead-custom">
                                <th>Mentor</th>
                                <th>Funcionário</th>
                                <th>Comentário</th>
                                <th>Data de Feedback</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach($feedback_lideranca as $item) : ?>
                                <tr>
                                    <td class="text-capitalize">
                                        <?= htmlspecialchars($item['p_nome_mentor'] .' '.$item['s_nome_mentor']); ?>
                                    </td>
                                    <td class="text-capitalize">
                                        <?= htmlspecialchars($item['p_nome_funcionario'] .' '.$item['s_nome_funcionario']); ?>
                                    </td>
                                    <td class="text-capitalize"> <?= htmlspecialchars($item['comentario']); ?> </td>
                                    <td class="text-capitalize"> <?= htmlspecialchars($item['data_feedback']); ?> </td>
                                    <td>
                                    <a href="<?php echo admin_url('plan_sucess_lideranca/mentoria_visualizar_feedback/'.$item['id'])?>"
                                            data-id="" class="btn btn-sucess btn-icon btn_edit_orcamento"
                                            style="background-color: #3CB371; border-color: #3CB371; color: white;">
                                            <i style="color:#fff;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?= $item['id'] ?>"
                                            data-mentor="<?= html_entity_decode($item['mentor_id']) ?>"
                                            data-funcionario="<?= html_entity_decode($item['staff_id']) ?>"
                                            data-comentario="<?= html_entity_decode($item['comentario']) ?>"
                                            data-data_feedback='<?= html_entity_decode(($item["data_feedback"] ?? "")) ?>'
                                            class="btn btn-default btn-icon btn_edit_feedback_lideranca"
                                            style="background-color: #007bff; border-color: #007bff; color: white;">
                                            <i style="color:#fff;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certeza que desejas eliminar este Mentória?');"
                                            href="<?php echo admin_url('plan_sucess_lideranca/feedback_lideranca_delete/'.$item['id'])?>"
                                            class="btn btn-danger btn-icon _delete">
                                            <i style="color:#fff;" class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                    <?php endforeach ?>
                                </tr>
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
        <?= form_open(admin_url('plan_sucess_lideranca/adicionar_feedback_lideranca'), array('method' => 'post')) ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">
                    Novo Feedback
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
                            echo render_select('mentor', $staffs, ['staffid', ['firstname', 'lastname']], 'Mentor<span class="text-danger">*</span>', $selectedStaff, [], [], '', '', true);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php
                            $selectedStaff = '';
                            echo render_select('funcionario', $staffs, ['staffid', ['firstname', 'lastname']], 'Funcionário<span class="text-danger">*</span>', $selectedStaff, [], [], '', '', true);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php echo render_textarea('comentario','Comentário<small class="req text-danger">*</small>'); ?>
                        </div>
                        <div class="form-group" app-field-wrapper="data_feedback">
                            <label for="data_feedback" class="control-label">
                                Data de Feedback <small class="req text-danger">*</small>
                            </label>
                            <input type="date" id="data_feedback" name="data_feedback" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <?php echo _l('Cancelar'); ?>
                </button>
                <button type="submit" class="btn btn-success">
                    <?php echo _l('submit'); ?>
                </button>
            </div>
        </div>
        <?= form_close() ?>
    </div>
</div>

<?= form_open(admin_url('plan_sucess_lideranca/editar_feedback_lideranca'), array('method' => 'post', 'id' => 'form_edit_feedback_lideranca')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Editar </h4>
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
                            echo render_select('e_mentor', $staffs, ['staffid', ['firstname', 'lastname']], 'Mentor<span class="text-danger">*</span>', $selectedStaff, [], [], '', '', true);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php
                            $selectedStaff = '';
                            echo render_select('e_funcionario', $staffs, ['staffid', ['firstname', 'lastname']], 'Funcionário<span class="text-danger">*</span>', $selectedStaff, [], [], '', '', true);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php echo render_textarea('e_comentario','Comentário<small class="req text-danger">*</small>'); ?>
                        </div>
                        <div class="form-group" app-field-wrapper="data_feedback">
                            <label for="data_feedback" class="control-label">
                                Data de Feedback <small class="req text-danger">*</small>
                            </label>
                            <input type="date" id="data_feedback" name="e_data_feedback" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                    data-dismiss="modal"><?php echo _l('pl_close'); ?></button>
                <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
            </div>
        </div>
    </div>
</div>
<?= form_close()  ?>

<?php init_tail(); ?>
<script>
// feedback_lideranca
$('.btn_edit_feedback_lideranca').click(function() {
    let mentor = $(this).attr('data-mentor');
    let funcionario = $(this).attr('data-funcionario');
    let comentario = $(this).attr('data-comentario');
    let data_feedback = $(this).attr('data-data_feedback');

    let id = $(this).attr('data-id');

    let url = "<?= admin_url('plan_sucess_lideranca/editar_feedback_lideranca') ?>/" + id;
    $('#form_edit_feedback_lideranca').attr('action', url);

    $('select[name="e_mentor"]').selectpicker('val', mentor);
    $('select[name="e_funcionario"]').selectpicker('val', funcionario);
    $('textarea[name="e_comentario"]').text(comentario);
    $('input[name="e_data_feedback"]').val(data_feedback);

    $('#editar').modal('show');
})

$('#mentor_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(0).search(this.value).draw();
})
</script>