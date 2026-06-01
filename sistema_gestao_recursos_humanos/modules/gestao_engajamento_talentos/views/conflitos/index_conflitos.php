<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_remuneracao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Engajamento de Talentos / Conflitos e Resoluções /
                    Conflito
                </a>
            </div>
            <div class="col-md-2" style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
            </div>
        </div>
        </br>
        <!-- Não mexe  nessa extrutura-->

        <!-- Aqui vais por os Cards-->
        <?php require 'modules/gestao_engajamento_talentos/views/conflitos/cards.php'; ?>
        </br>

        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Conflito
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Novo Conflito
                                </a>
                                <a href="<?php echo admin_url('gestao_engajamento_talentos/conflitos_mediacao')?>"
                                    class="btn" style="background-color: #DAA520; border-color: #DAA520; color: white;">
                                    <i class="fa-regular "></i>
                                    Mediação de Conflito
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
                                    <option value="Em Andamento">Em Andamento</option>
                                    <option value="Não Resolvido">Não Resolvido</option>
                                    <option value="Resolvido">Resolvido</option>
                                </select>
                            </div>
                        </div>
                        <br><br>
                        <table class="table table-hover table-bordered table-responsive dt-table">
                            <thead class="thead-custom">
                                <th>Colaborador</th>
                                <th>Descrição</th>
                                <th>Data de Registro</th>
                                <th>Estado</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach($conflito as $item) : ?>
                                <tr>
                                    <td><?= html_entity_decode($item['firstname'].' '.$item['lastname'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['descricao'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['data_registro'] ?? '') ?></td>
                                    <td>
                                        <?php
                                            $texto_status = 'Em Andamento';
                                            $cor = "#999"; // Cor padrão (cinza para pendente)
                                            if ($item['status'] == 'resolvido') {
                                                $texto_status = 'Resolvido';
                                                $cor = "green";
                                            } elseif ($item['status'] == 'nao_resolvido') {
                                                $texto_status = 'Não Resolvido';
                                                $cor = "red";
                                            }
                                            $texto_cor = ($item['status'] == 'em_andamento') ? 'color:#000;' : 'color:#fff;';
                                        ?>
                                        <a
                                            style="background-color: <?= $cor ?>; <?= $texto_cor ?> padding: 5px 10px; border-radius:8px;">
                                            <?= $texto_status ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?php echo admin_url('gestao_engajamento_talentos/conflitos_visualizar_conflito/'.$item['id']) ?>"
                                            class="btn btn-sucess btn-icon"
                                            style="background-color: #3CB371; border-color: #3CB371; color: white;">
                                            <i style="color:#fff;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?= html_entity_decode($item['id'] ?? '') ?>"
                                            data-staff="<?= html_entity_decode($item['staff_id'] ?? '') ?>"
                                            data-descricao="<?= html_entity_decode($item['descricao'] ?? '') ?>"
                                            data-data_registro="<?= html_entity_decode($item['data_registro'] ?? '') ?>"
                                            data-status="<?= html_entity_decode($item['status'] ?? '') ?>"
                                            class="btn btn-default btn-icon btn_edit_conflito"
                                            style="background-color: #007bff; border-color: #007bff; color: white;">
                                            <i style="color:#fff;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas eliminar este Conflito?');"
                                            href="<?php echo admin_url('gestao_engajamento_talentos/delete_conflito/'.$item['id']) ?>"
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
</div>
<div class="btn-bottom-pusher"></div>
</div>
</div>
<div id="new_version"></div>
<div class="modal" id="modal_add" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <?php echo form_open(admin_url('gestao_engajamento_talentos/add_conflito'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Novo Conflito</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="colaborador"><small class="req text-danger">*</small> Colaborador</label>
                    <select name="colaborador" id="colaborador" class="selectpicker" data-live-search="true"
                        data-width="100%" data-none-selected-text="<?php echo _l('Colaborador'); ?>">
                        <option value=""></option>
                        <?php foreach($staffs as $item) : ?>
                        <option value="<?= $item['staffid'] ?>"><?= $item['firstname'].' '.$item['lastname'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="descricao"><small class="req text-danger">*</small> Descrição</label>
                    <textarea id="descricao" name="descricao" class="form-control" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="data_registro"><small class="req text-danger">*</small> Data de
                        Registro</label>
                    <input type="date" id="data_registro" name="data_registro" class="form-control" required>
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

<?= form_open_multipart(admin_url('gestao_engajamento_talentos/editar_conflito/0'), array('method' => 'post', 'id' => 'form_edit_conflito')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar Conflito</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="e_colaborador"><small class="req text-danger">*</small> Colaborador</label>
                    <select name="e_colaborador" id="e_colaborador" class="selectpicker" data-live-search="true"
                        data-width="100%" data-none-selected-text="<?php echo _l('Colaborador'); ?>">
                        <option value=""></option>
                        <?php foreach($staffs as $item) : ?>
                        <option value="<?= $item['staffid'] ?>"><?= $item['firstname'].' '.$item['lastname'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="e_descricao"><small class="req text-danger">*</small> Descrição</label>
                    <textarea id="e_descricao" name="e_descricao" class="form-control" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="e_data_registro"><small class="req text-danger">*</small> Data de
                        Registro</label>
                    <input type="date" id="e_data_registro" name="e_data_registro" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="e_estado"><small class="req text-danger">*</small> Estado</label>
                    <select name="e_estado" id="e_estado" class="form-control">
                        <option value="em_andamento">Em Andamento</option>
                        <option value="nao_resolvido">Não Resolvido</option>
                        <option value="resolvido">Resolvido</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo _l('Cancelar'); ?></button>
                <button type="submit" class="btn btn-success"><?php echo _l('Salvar'); ?></button>
            </div>
        </div>
    </div>
</div>
<?= form_close() ?>
<?php init_tail(); ?>

<script>
$('.btn_edit_conflito').click(function() {
    let colaborador = $(this).attr('data-staff');
    let descricao = $(this).attr('data-descricao');
    let data_registro = $(this).attr('data-data_registro');
    let status = $(this).attr('data-status');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_engajamento_talentos/editar_conflito') ?>/" + id;
    $('#form_edit_conflito').attr('action', url);

    $('select[name="e_colaborador').selectpicker('val', colaborador);
    $('textarea[name="e_descricao"]').text(descricao);
    $('input[name="e_data_registro"]').val(data_registro);
    $('select[name="e_estado"]').val(status);

    $('#editar').modal('show');
})
$('#estado_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(3).search(this.value).draw();
})
</script>