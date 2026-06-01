<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_formacao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão da Formação / Orçamento / Roi
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
                                    Roi
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">

                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Novo Roi
                                </a>
                                <a href="<?php echo admin_url('gestao_formacao/orcamento')?>" class="btn"
                                    style="background-color: #FFD700; border-color: #FFD700; color: white;">
                                    <i class="fa-regular "></i>
                                    Planeamento
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
                                <th>Custo</th>
                                <th>Benefício</th>
                                <th>Retorno</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach($roi as $item) : ?>
                                <tr>
                                    <td><?php echo html_entity_decode($item['curso']); ?></td>
                                    <td><?php echo html_entity_decode($item['custo']); ?></td>
                                    <td><?php echo html_entity_decode($item['beneficio']); ?></td>
                                    <td><?php echo html_entity_decode($item['retorno']); ?></td>
                                    <td>
                                        <a href="<?php echo admin_url('gestao_formacao/orcamento_visualizar_roi')?>"
                                            class="btn btn-sucess btn-icon"
                                            style="background-color: #28a745; border-color: #28a745; color: white;">
                                            <i style="color:#fff;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?php echo html_entity_decode($item['id']); ?>"
                                            data-curso="<?php echo html_entity_decode($item['curso_id']); ?>"
                                            data-custo="<?php echo html_entity_decode($item['custo']); ?>"
                                            data-beneficio="<?php echo html_entity_decode($item['beneficio']); ?>"
                                            data-retorno="<?php echo html_entity_decode($item['retorno']); ?>"
                                            class="btn btn-default btn-icon btn_edit_roi"
                                            style="background-color: #007bff; border-color: #007bff; color: white;">
                                            <i style="color:#fff;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas eliminar este ROI?');"
                                            href="<?php echo admin_url('gestao_formacao/delete_roi/'. $item['id'])?>"
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

<div class="modal" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="modal_add_label">
    <div class="modal-dialog modal-md">
        <?php echo form_open(admin_url('gestao_formacao/add_roi'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modal_add_label">Novo ROI</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
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
                            <label for="custo" class="control-label"><small class="req text-danger">*</small>
                                Custo</label>
                            <input type="number" id="custo" name="custo" class="form-control" required step="0.01"
                                autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="beneficio" class="control-label"><small class="req text-danger">*</small>
                                Benefício</label>
                            <input type="number" id="beneficio" name="beneficio" class="form-control" required
                                step="0.01" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="retorno" class="control-label"><small class="req text-danger">*</small>
                                Retorno</label>
                            <input type="number" id="retorno" name="retorno" class="form-control" required step="0.01"
                                autocomplete="off">
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

<?= form_open(admin_url('gestao_formacao/editar_roi'), array('method' => 'post', 'id' => 'form_edit_roi')) ?>
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
                            <label for="e_custo" class="control-label"><small class="req text-danger">*</small>
                                Custo</label>
                            <input type="number" id="e_custo" name="e_custo" class="form-control" required step="0.01"
                                autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="e_beneficio" class="control-label"><small class="req text-danger">*</small>
                                Benefício</label>
                            <input type="number" id="e_beneficio" name="e_beneficio" class="form-control" required
                                step="0.01" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="e_retorno" class="control-label"><small class="req text-danger">*</small>
                                Retorno</label>
                            <input type="number" id="e_retorno" name="e_retorno" class="form-control" required
                                step="0.01" autocomplete="off">
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
$('.btn_edit_roi').click(function() {
    let curso = $(this).attr('data-curso');
    let custo = $(this).attr('data-custo');
    let beneficio = $(this).attr('data-beneficio');
    let retorno = $(this).attr('data-retorno');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_formacao/editar_roi') ?>/" + id;
    $('#form_edit_roi').attr('action', url);

    $('select[name="e_curso"]').selectpicker('val', curso);
    $('input[name="e_custo"]').val(custo);
    $('input[name="e_beneficio"]').val(beneficio);
    $('input[name="e_retorno"]').val(retorno);

    $('#editar').modal('show');
})
</script>