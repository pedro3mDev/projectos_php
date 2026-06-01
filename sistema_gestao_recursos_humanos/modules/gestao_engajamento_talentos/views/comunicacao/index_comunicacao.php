<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_remuneracao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Engajamento de Talentos / Comunicação
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
        <?php require 'modules/gestao_engajamento_talentos/views/comunicacao/cards.php'; ?>
        </br>

        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="font-bold no-margin">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Comunicação Interna
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Nova Comunicação
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
                                <th>Mensagem</th>
                                <th>Data de Publicação</th>
                                <th>Autor</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach($comunicacao_interna as $item) : ?>
                                <tr>
                                    <td><?= html_entity_decode($item['titulo'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['mensagem'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['data_publicacao'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['firstname'].' '.$item['lastname'] ?? '') ?></td>
                                    <td>
                                        <a href="<?php echo admin_url('gestao_engajamento_talentos/comunicacao_visualizar_comunicacao/'.$item['id']) ?>"
                                            class="btn btn-sucess btn-icon btn_edit_orcamento"
                                            style="background-color: #3CB371; border-color: #3CB371; color: white;">
                                            <i style="color:#fff;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?= html_entity_decode($item['id'] ?? '') ?>"
                                            data-titulo="<?= html_entity_decode($item['titulo'] ?? '') ?>"
                                            data-mensagem="<?= html_entity_decode($item['mensagem'] ?? '') ?>"
                                            data-data_publicacao="<?= html_entity_decode($item['data_publicacao'] ?? '') ?>"
                                            data-autor="<?= html_entity_decode($item['autor_id'] ?? '') ?>"
                                            class="btn btn-default btn-icon btn_edit_comunicacao_interna"
                                            style="background-color: #007bff; border-color: #007bff; color: white;">
                                            <i style="color:#fff;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas eliminar este Comunicacao?');"
                                            href="<?php echo admin_url('gestao_engajamento_talentos/delete_comunicacao_interna/'.$item['id']) ?>"
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
        <?php echo form_open(admin_url('gestao_engajamento_talentos/add_comunicacao_interna'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Nova Comunicação</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="titulo"><small class="req text-danger">*</small> Título</label>
                    <input type="text" id="titulo" name="titulo" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="mensagem"><small class="req text-danger">*</small> Mensagem</label>
                    <textarea id="mensagem" name="mensagem" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="data_publicacao"><small class="req text-danger">*</small> Data de Publicação</label>
                    <input type="date" id="data_publicacao" name="data_publicacao" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="autor"><small class="req text-danger">*</small> Autor</label>
                    <select name="autor" id="autor" class="selectpicker" data-live-search="true" data-width="100%"
                        data-none-selected-text="<?php echo _l('Autor'); ?>">
                        <option value=""></option>
                        <?php foreach($colaboradores as $item) : ?>
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

<?= form_open_multipart(admin_url('gestao_engajamento_talentos/editar_comunicacao_interna/0'), array('method' => 'post', 'id' => 'form_edit_comunicacao_interna')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar Comunicação</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="e_titulo"><small class="req text-danger">*</small> Título</label>
                    <input type="text" id="e_titulo" name="e_titulo" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="e_mensagem"><small class="req text-danger">*</small> Mensagem</label>
                    <textarea id="e_mensagem" name="e_mensagem" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="e_data_publicacao"><small class="req text-danger">*</small> Data de Publicação</label>
                    <input type="date" id="e_data_publicacao" name="e_data_publicacao" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="e_autor"><small class="req text-danger">*</small> Autor</label>
                    <select name="e_autor" id="e_autor" class="selectpicker" data-live-search="true" data-width="100%"
                        data-none-selected-text="<?php echo _l('Autor'); ?>">
                        <option value=""></option>
                        <?php foreach($colaboradores as $item) : ?>
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
$('.btn_edit_comunicacao_interna').click(function() {
    let autor = $(this).attr('data-autor');
    let titulo = $(this).attr('data-titulo');
    let mensagem = $(this).attr('data-mensagem');
    let data_publicacao = $(this).attr('data-data_publicacao');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_engajamento_talentos/editar_comunicacao_interna') ?>/" + id;
    $('#form_edit_comunicacao_interna').attr('action', url);

    $('select[name="e_autor').selectpicker('val', autor);
    $('textarea[name="e_mensagem"]').text(mensagem);
    $('input[name="e_data_publicacao"]').val(data_publicacao);
    $('input[name="e_titulo"]').val(titulo);

    $('#editar').modal('show');
})
</script>