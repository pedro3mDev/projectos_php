<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_remuneracao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Engajamento de Talentos / Programas / Reconhecimento
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
        <?php require 'modules/gestao_engajamento_talentos/views/programas/cards.php'; ?>
        </br>

        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Reconhecimento
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Novo Reconhecimento
                                </a>
                                <a href="<?php echo admin_url('gestao_engajamento_talentos/programas_premio')?>"
                                    class="btn" style="background-color: #DAA520; border-color: #DAA520; color: white;">
                                    <i class="fa-regular "></i>
                                    Prêmio
                                </a>
                                <a href="<?php echo admin_url('gestao_engajamento_talentos/programas_resgate')?>"
                                    class="btn" style="background-color: #C0392B; border-color: #C0392B; color: white;">
                                    <i class="fa-regular "></i>
                                    Resgate de Prêmio
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
                                </select>
                            </div>
                        </div>
                        <br><br>
                        <table class="table table-hover table-bordered table-responsive dt-table">
                            <thead class="thead-custom">
                                <th>Colaborador</th>
                                <th>Tipo</th>
                                <th>Descrição</th>
                                <th>Data de Reconhecimento</th>
                                <th>Pontos</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach($reconhecimento as $item) : ?>
                                <tr>
                                <td><?= html_entity_decode($item['firstname'].' '.$item['lastname'] ?? '') ?>
                                    <td><?= html_entity_decode($item['tipo'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['descricao'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['data_reconhecimento'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['pontos'] ?? '') ?></td>
                                    <td>
                                        <a href="<?php echo admin_url('gestao_engajamento_talentos/programas_visualizar_reconhecimento/'.$item['id'])?>"
                                            data-id="" class="btn btn-sucess btn-icon btn_edit_orcamento"
                                            style="background-color: #3CB371; border-color: #3CB371; color: white;">
                                            <i style="color:#fff;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?= html_entity_decode($item['id'] ?? '') ?>"
                                            data-colaborador="<?= html_entity_decode($item['staff_id'] ?? '') ?>"
                                            data-tipo="<?= html_entity_decode($item['tipo'] ?? '') ?>"
                                            data-descricao="<?= html_entity_decode($item['descricao'] ?? '') ?>"
                                            data-data_reconhecimento="<?= html_entity_decode($item['data_reconhecimento'] ?? '') ?>"
                                            data-pontos="<?= html_entity_decode($item['pontos'] ?? '') ?>"
                                            class="btn btn-default btn-icon btn_edit_reconhecimento"
                                            style="background-color: #007bff; border-color: #007bff; color: white;">
                                            <i style="color:#fff;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas eliminar este Reconhecimento?');"
                                            href="<?php echo admin_url('gestao_engajamento_talentos/delete_reconhecimento/'.$item['id'])?>"
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
        <?php echo form_open(admin_url('gestao_engajamento_talentos/add_reconhecimento'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Novo Reconhecimento</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="colaborador"><small class="req text-danger">*</small> Colaborador</label>
                    <select name="colaborador" id="colaborador" class="selectpicker" data-live-search="true"
                        data-width="100%" data-none-selected-text="<?php echo _l('Colaborador'); ?>">
                        <option value=""></option>
                        <?php foreach($colaboradores as $item) : ?>
                        <option value="<?= $item['staffid'] ?>"><?= $item['firstname'].' '.$item['lastname'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tipo"><small class="req text-danger">*</small> Tipo</label>
                    <input type="text" id="tipo" name="tipo" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="descricao"><small class="req text-danger">*</small> Descrição</label>
                    <textarea id="descricao" name="descricao" class="form-control" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="data_reconhecimento"><small class="req text-danger">*</small> Data de
                        Reconhecimento</label>
                    <input type="date" id="data_reconhecimento" name="data_reconhecimento" class="form-control"
                        required>
                </div>
                <div class="form-group">
                    <label for="pontos"><small class="req text-danger">*</small> Pontos</label>
                    <input type="number" id="pontos" name="pontos" class="form-control" step="1" required>
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

<?= form_open_multipart(admin_url('gestao_engajamento_talentos/editar_reconhecimento'), array('method' => 'post', 'id' => 'form_edit_reconhecimento')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar Reconhecimento</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="e_colaborador"><small class="req text-danger">*</small> Colaborador</label>
                    <select name="e_colaborador" id="e_colaborador" class="selectpicker" data-live-search="true"
                        data-width="100%" data-none-selected-text="<?php echo _l('Colaborador'); ?>">
                        <option value=""></option>
                        <?php foreach($colaboradores as $item) : ?>
                        <option value="<?= $item['staffid'] ?>"><?= $item['firstname'].' '.$item['lastname'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="e_tipo"><small class="req text-danger">*</small> Tipo</label>
                    <input type="text" id="e_tipo" name="e_tipo" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="e_descricao"><small class="req text-danger">*</small> Descrição</label>
                    <textarea id="e_descricao" name="e_descricao" class="form-control" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="e_data_reconhecimento"><small class="req text-danger">*</small> Data de
                        Reconhecimento</label>
                    <input type="date" id="e_data_reconhecimento" name="e_data_reconhecimento" class="form-control"
                        required>
                </div>
                <div class="form-group">
                    <label for="e_pontos"><small class="req text-danger">*</small> Pontos</label>
                    <input type="number" id="e_pontos" name="e_pontos" class="form-control" step="1" required>
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
$('.btn_edit_reconhecimento').click(function() {
    let colaborador = $(this).attr('data-colaborador');
    let tipo = $(this).attr('data-tipo');
    let descricao = $(this).attr('data-descricao');
    let data_reconhecimento = $(this).attr('data-data_reconhecimento');
    let pontos = $(this).attr('data-pontos');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_engajamento_talentos/editar_reconhecimento') ?>/" + id;
    $('#form_edit_reconhecimento').attr('action', url);

    $('select[name="e_colaborador').selectpicker('val', colaborador);
    $('input[name="e_tipo"]').val(tipo);
    $('textarea[name="e_descricao"]').text(descricao);
    $('input[name="e_data_reconhecimento"]').val(data_reconhecimento);
    $('input[name="e_pontos"]').val(pontos);

    $('#editar').modal('show');
})
$('#estado_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(4).search(this.value).draw();
})
</script>