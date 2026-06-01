<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_formacao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão da Formação / Suporte
                </a>
            </div>
            <div class="col-md-2" style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
            </div>
        </div>

        </br>
        <?php require 'modules/gestao_formacao/views/suporte/cards.php'; ?>
        </br>

        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Suporte
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">

                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Novo Suporte
                                </a>
                                <a href="<?php echo admin_url('gestao_formacao/suporte_recurso')?>" class="btn"
                                    style="background-color: #FFD700; border-color: #FFD700; color: white;">
                                    <i class="fa-regular "></i>
                                    Recurso
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
                                    <?php foreach($status as $item) : ?>
                                    <option value="<?= $item['status'] ?>"><?= $item['status'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <br><br>
                        <table class="table table-hover table-bordered table-responsive dt-table">
                            <thead class="thead-custom">
                                <th>Usuário</th>
                                <th>Tipo de Suporte</th>
                                <th>Descrição</th>
                                <th>Data de Registro</th>
                                <th>Estado</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach($suporte as $item) : ?>
                                <tr>
                                    <td><?= html_entity_decode($item['firstname'] .' '.$item['lastname'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['tipo_suporte'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['descricao'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['data_registro'] ?? '') ?></td>
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
                                            <?= html_entity_decode($item['status'] ?? '') ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php if ($item['status_id'] == 1) : ?>
                                        <a href="<?php echo admin_url('gestao_formacao/suporte_aprovar/'.$item['id']); ?>"
                                            class="btn btn-success" style="color: white;">
                                            Aprovar
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas rejeitar?');"
                                            href="<?php echo admin_url('gestao_formacao/suporte_rejeitar/'.$item['id']); ?>"
                                            class="btn btn-danger" style="color: white;">
                                            Rejeitar
                                        </a>
                                        <?php endif ?>
                                        <a href="<?php echo admin_url('gestao_formacao/suporte_visualizar_suporte')?>"
                                            class="btn btn-sucess btn-icon"
                                            style="background-color: #28a745; border-color: #28a745; color: white;">
                                            <i style="color:#fff;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?= html_entity_decode($item['id'] ?? '') ?>"
                                            data-staff="<?= html_entity_decode($item['staff_id'] ?? '') ?>"
                                            data-tipo_suporte="<?= html_entity_decode($item['tipo_suporte'] ?? '') ?>"
                                            data-descricao="<?= html_entity_decode($item['descricao'] ?? '') ?>"
                                            data-data_registro="<?= html_entity_decode($item['data_registro'] ?? '') ?>"
                                            data-aprovadores='<?= html_entity_decode(($item["aprovadores"] ?? "")) ?>'
                                            class="btn btn-default btn-icon btn_edit_suporte"
                                            style="background-color: #007bff; border-color: #007bff; color: white;">
                                            <i style="color:#fff;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas eliminar este Suporte?');"
                                            href="<?php echo admin_url('gestao_formacao/delete_suporte/'.$item['id']); ?>"
                                            class="btn btn-danger btn-icon _delete">
                                            <i style="color:#fff;" class="fa fa-trash"></i>
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

<div class="modal" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-describedby="modalBody">
    <div class="modal-dialog modal-md">
        <?php echo form_open(admin_url('gestao_formacao/add_suporte'), array('method' => 'post', 'novalidate' => true)); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modalTitle">Novo Suporte</h4>
            </div>
            <div class="modal-body" id="modalBody">
                <div class="row">
                    <div class="col-md-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <?php
                            $selectedStaff = '';
                            echo render_select('staff', $staffs, ['staffid', ['firstname', 'lastname']], 'Funcionário<span class="text-danger">*</span>', $selectedStaff, [], [], '', '', true);
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="tipo_suporte" class="control-label">
                                <small class="req text-danger">*</small> Tipo de Suporte
                            </label>
                            <input type="text" id="tipo_suporte" name="tipo_suporte" class="form-control" required
                                placeholder="Digite o tipo de suporte">
                        </div>
                        <div class="form-group">
                            <label for="descricao" class="control-label">
                                <small class="req text-danger">*</small> Descrição
                            </label>
                            <textarea id="descricao" name="descricao" class="form-control" required
                                placeholder="Digite a descrição"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="data_registro" class="control-label">
                                <small class="req text-danger">*</small> Data de Registro
                            </label>
                            <input type="date" id="data_registro" name="data_registro" class="form-control" required>
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
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success">Salvar</button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>


<?= form_open(admin_url('gestao_formacao/editar_suporte'), array('method' => 'post', 'id' => 'form_edit_suporte')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Editar Curso </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <?php
                            $selectedStaff = '';
                            echo render_select('e_staff', $staffs, ['staffid', ['firstname', 'lastname']], 'Funcionário<span class="text-danger">*</span>', $selectedStaff, [], [], '', '', true);
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="e_tipo_suporte" class="control-label">
                                <small class="req text-danger">*</small> Tipo de Suporte
                            </label>
                            <input type="text" id="e_tipo_suporte" name="e_tipo_suporte" class="form-control" required
                                placeholder="Digite o tipo de suporte">
                        </div>
                        <div class="form-group">
                            <label for="e_descricao" class="control-label">
                                <small class="req text-danger">*</small> Descrição
                            </label>
                            <textarea id="e_descricao" name="e_descricao" class="form-control" required
                                placeholder="Digite a descrição"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="e_data_registro" class="control-label">
                                <small class="req text-danger">*</small> Data de Registro
                            </label>
                            <input type="date" id="e_data_registro" name="e_data_registro" class="form-control"
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
$('.btn_edit_suporte').click(function() {
    let staff = $(this).attr('data-staff');
    let tipo_suporte = $(this).attr('data-tipo_suporte');
    let descricao = $(this).attr('data-descricao');
    let data_registro = $(this).attr('data-data_registro');
    let aprovadores = $(this).attr('data-aprovadores');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_formacao/editar_suporte') ?>/" + id;
    $('#form_edit_suporte').attr('action', url);

    $('select[name="e_staff"]').selectpicker('val', staff);
    $('input[name="e_tipo_suporte"]').val(tipo_suporte);
    $('textarea[name="e_descricao"]').text(descricao);
    $('input[name="e_data_registro"]').val(data_registro);
    $('select[name="e_aprovadores[]"]').selectpicker('val', JSON.parse(aprovadores));

    $('#editar').modal('show');
})
$('#estado_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(4).search(this.value).draw();
})
</script>