<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_remuneracao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Engajamento de Talentos / Comunidade / Evento
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
                                <h4 class="no-margin font-bold">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Evento
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Novo Evento
                                </a>
                                <a href="<?php echo admin_url('gestao_engajamento_talentos/comunidade')?>" class="btn"
                                    style="background-color: #DAA520; border-color: #DAA520; color: white;">
                                    <i class="fa-regular "></i>
                                    Grupo de Colaboraçãoo
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
                                <th>Título</th>
                                <th>Descrição</th>
                                <th>Local</th>
                                <th>Organizador</th>
                                <th>Data do Evento</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach($evento as $item) : ?>
                                <tr>
                                    <td><?= html_entity_decode($item['titulo'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['descricao'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['local'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['firstname'].' '.$item['lastname'] ?? '') ?>
                                    <td><?= html_entity_decode($item['data_evento'] ?? '') ?></td>
                                    <td>
                                        <a href="<?php echo admin_url('gestao_engajamento_talentos/comunidade_visualizar_evento/'.$item['id']) ?>"
                                            class="btn btn-sucess btn-icon"
                                            style="background-color: #3CB371; border-color: #3CB371; color: white;">
                                            <i style="color:#fff;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?= html_entity_decode($item['id'] ?? '') ?>"
                                            data-titulo="<?= html_entity_decode($item['titulo'] ?? '') ?>"
                                            data-descricao="<?= html_entity_decode($item['descricao'] ?? '') ?>"
                                            data-local="<?= html_entity_decode($item['local'] ?? '') ?>"
                                            data-organizador="<?= html_entity_decode($item['organizador_id'] ?? '') ?>"
                                            data-data_evento="<?= html_entity_decode($item['data_evento'] ?? '') ?>"
                                            class="btn btn-default btn-icon btn_edit_evento"
                                            style="background-color: #007bff; border-color: #007bff; color: white;">
                                            <i style="color:#fff;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas eliminar este Evento?');"
                                            href="<?php echo admin_url('gestao_engajamento_talentos/delete_evento/'.$item['id']) ?>"
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
        <?php echo form_open(admin_url('gestao_engajamento_talentos/add_evento'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Novo Evento</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="titulo"><small class="req text-danger">*</small> Título</label>
                    <input type="text" id="titulo" name="titulo" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="descricao"><small class="req text-danger">*</small> Descrição</label>
                    <textarea id="descricao" name="descricao" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="data_evento"><small class="req text-danger">*</small> Data do Evento</label>
                    <input type="date" id="data_evento" name="data_evento" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="local"><small class="req text-danger">*</small> Local</label>
                    <input type="text" id="local" name="local" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="organizador"><small class="req text-danger">*</small> Organizador</label>
                    <select name="organizador" id="organizador" class="selectpicker" data-live-search="true"
                        data-width="100%" data-none-selected-text="<?php echo _l('Organizador'); ?>">
                        <option value=""></option>
                        <?php foreach($staffs as $item) : ?>
                        <option value="<?= $item['staffid'] ?>"><?= $item['firstname'].' '.$item['lastname'] ?></option>
                        <?php endforeach ?>
                    </select>
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

<?= form_open_multipart(admin_url('gestao_engajamento_talentos/editar_evento'), array('method' => 'post', 'id' => 'form_edit_evento')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar Evento</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="e_titulo"><small class="req text-danger">*</small> Título</label>
                    <input type="text" id="e_titulo" name="e_titulo" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="e_descricao"><small class="req text-danger">*</small> Descrição</label>
                    <textarea id="e_descricao" name="e_descricao" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="e_data_evento"><small class="req text-danger">*</small> Data do Evento</label>
                    <input type="date" id="e_data_evento" name="e_data_evento" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="e_local"><small class="req text-danger">*</small> Local</label>
                    <input type="text" id="e_local" name="e_local" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="e_organizador"><small class="req text-danger">*</small> Organizador</label>
                    <select name="e_organizador" id="e_organizador" class="selectpicker" data-live-search="true"
                        data-width="100%" data-none-selected-text="<?php echo _l('Organizador'); ?>">
                        <option value=""></option>
                        <?php foreach($staffs as $item) : ?>
                        <option value="<?= $item['staffid'] ?>"><?= $item['firstname'].' '.$item['lastname'] ?></option>
                        <?php endforeach ?>
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
$('.btn_edit_evento').click(function() {
    let titulo = $(this).attr('data-titulo');
    let descricao = $(this).attr('data-descricao');
    let local = $(this).attr('data-local');
    let data_evento = $(this).attr('data-data_evento');
    let organizador = $(this).attr('data-organizador');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_engajamento_talentos/editar_evento') ?>/" + id;
    $('#form_edit_evento').attr('action', url);

    $('input[name="e_titulo"]').val(titulo);
    $('textarea[name="e_descricao"]').text(descricao);
    $('input[name="e_local"]').val(local);
    $('input[name="e_data_evento"]').val(data_evento);
    $('select[name="e_organizador').selectpicker('val', organizador);

    $('#editar').modal('show');
})
</script>