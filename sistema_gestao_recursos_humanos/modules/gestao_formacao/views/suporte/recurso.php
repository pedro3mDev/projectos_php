<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_formacao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão da Formação / Suporte / Recurso
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
                                    Recurso
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">

                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Novo Recurso
                                </a>
                                <a href="<?php echo admin_url('gestao_formacao/suporte')?>" class="btn"
                                    style="background-color: #FFD700; border-color: #FFD700; color: white;">
                                    <i class="fa-regular "></i>
                                    Suporte
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
                                <th>Curso</th>
                                <th>Tipo de Recurso</th>
                                <th>URL</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach($recurso as $item) : ?>
                                <tr>
                                    <td><?= html_entity_decode($item['curso'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['tipo_recurso'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['url'] ?? '') ?></td>
                                    <td>
                                        <a href="<?php echo admin_url('gestao_formacao/suporte_visualizar_recurso')?>"
                                            class="btn btn-sucess btn-icon"
                                            style="background-color: #28a745; border-color: #28a745; color: white;">
                                            <i style="color:#fff;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?= html_entity_decode($item['id'] ?? '') ?>"
                                            data-curso="<?= html_entity_decode($item['curso_id'] ?? '') ?>"
                                            data-tipo_recurso="<?= html_entity_decode($item['tipo_recurso'] ?? '') ?>"
                                            data-url="<?= html_entity_decode($item['url'] ?? '') ?>"
                                            class="btn btn-default btn-icon btn_edit_recurso"
                                            style="background-color: #007bff; border-color: #007bff; color: white;">
                                            <i style="color:#fff;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certeza que desejas eliminar este Recurso?');"
                                            href="<?php echo admin_url('gestao_formacao/delete_recurso/'.$item['id']) ?>"
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
        <?php echo form_open(admin_url('gestao_formacao/add_recurso'), array('method' => 'post', 'novalidate' => true)); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modalTitle">Novo Recurso</h4>
            </div>
            <div class="modal-body" id="modalBody">
                <div class="row">
                    <div class="col-md-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="curso" class="control-label"><small class="req text-danger">*</small>
                                Curso</label>
                            <select name="curso" id="curso" class="selectpicker" data-live-search="true"
                                data-width="100%" data-none-selected-text="<?php echo _l('Curso'); ?>">
                                <option value="">Selecione um Curso</option>
                                <?php foreach ($cursos as $item) { ?>
                                <option value="<?php echo $item['id']; ?>">
                                    <?php echo $item['nome']; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tipo_recurso" class="control-label">
                                <small class="req text-danger">*</small> Tipo de Recurso
                            </label>
                            <input type="text" id="tipo_recurso" name="tipo_recurso" class="form-control" required
                                placeholder="Digite o tipo de recurso">
                        </div>
                        <div class="form-group">
                            <label for="url" class="control-label">
                                <small class="req text-danger">*</small> URL
                            </label>
                            <input type="url" id="url" name="url" class="form-control" required
                                placeholder="Digite a URL do recurso">
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


<?= form_open(admin_url('gestao_formacao/editar_recurso'), array('method' => 'post', 'id' => 'form_edit_recurso')) ?>
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
                    <div class="col-md-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="e_curso" class="control-label"><small class="req text-danger">*</small>
                                Curso</label>
                            <select name="e_curso" id="e_curso" class="selectpicker" data-live-search="true"
                                data-width="100%" data-none-selected-text="<?php echo _l('Curso'); ?>">
                                <option value="">Selecione um Curso</option>
                                <?php foreach ($cursos as $item) { ?>
                                <option value="<?php echo $item['id']; ?>">
                                    <?php echo $item['nome']; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="e_tipo_recurso" class="control-label">
                                <small class="req text-danger">*</small> Tipo de Recurso
                            </label>
                            <input type="text" id="e_tipo_recurso" name="e_tipo_recurso" class="form-control" required
                                placeholder="Digite o tipo de recurso">
                        </div>
                        <div class="form-group">
                            <label for="e_url" class="control-label">
                                <small class="req text-danger">*</small> URL
                            </label>
                            <input type="url" id="e_url" name="e_url" class="form-control" required
                                placeholder="Digite a URL do recurso">
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
$('.btn_edit_recurso').click(function() {
    let curso = $(this).attr('data-curso');
    let tipo_recurso = $(this).attr('data-tipo_recurso');
    let url_c = $(this).attr('data-url');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_formacao/editar_recurso') ?>/" + id;
    $('#form_edit_recurso').attr('action', url);

    $('select[name="e_curso"]').selectpicker('val', curso);
    $('input[name="e_tipo_recurso"]').val(tipo_recurso);
    $('input[name="e_url"]').val(url_c);

    $('#editar').modal('show');
})
$('#estado_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(3).search(this.value).draw();
})
</script>