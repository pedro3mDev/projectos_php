<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_formacao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão da Formação / Orçamento / Planeamento
                </a>
            </div>
            <div class="col-md-2" style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
            </div>
        </div>

        </br>
        <?php require 'modules/gestao_formacao/views/orcamento/cards.php'; ?>
        </br>

        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Planeamento
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">

                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Novo Planeamento
                                </a>
                                <a href="<?php echo admin_url('gestao_formacao/orcamento_roi')?>" class="btn"
                                    style="background-color: #FFD700; border-color: #FFD700; color: white;">
                                    <i class="fa-regular "></i>
                                    Roi
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
                                <th>Orçamento Previsto</th>
                                <th>Orçamento Realizado</th>
                                <th>Data do Planeamento</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach($planeamento as $item) : ?>
                                <tr>
                                    <td><?php echo html_entity_decode($item['curso']); ?></td>
                                    <td><?php echo html_entity_decode($item['orcamento_previsto']); ?></td>
                                    <td><?php echo html_entity_decode($item['orcamento_realizado']); ?></td>
                                    <td><?php echo html_entity_decode($item['data_planeamento']); ?></td>
                                    <td>
                                        <a href="<?php echo admin_url('gestao_formacao/orcamento_visualizar_planeamento')?>"
                                            class="btn btn-sucess btn-icon"
                                            style="background-color: #28a745; border-color: #28a745; color: white;">
                                            <i style="color:#fff;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?php echo html_entity_decode($item['id']); ?>"
                                            data-curso="<?php echo html_entity_decode($item['curso_id']); ?>"
                                            data-orcamento_previsto="<?php echo html_entity_decode($item['orcamento_previsto']); ?>"
                                            data-orcamento_realizado="<?php echo html_entity_decode($item['orcamento_realizado']); ?>"
                                            data-data_planeamento="<?php echo html_entity_decode($item['data_planeamento']); ?>"
                                            class="btn btn-default btn-icon btn_edit_planeamento"
                                            style="background-color: #007bff; border-color: #007bff; color: white;">
                                            <i style="color:#fff;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas eliminar este Planeamento?');"
                                            href="<?php echo admin_url('gestao_formacao/delete_planeamento/'.$item['id'])?>"
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

<div class="modal" id="modal_add" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <?php echo form_open(admin_url('gestao_formacao/add_planeamento'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Novo Planeamento</h4>
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
                            <label for="orcamento_previsto" class="control-label"><small
                                    class="req text-danger">*</small> Orçamento Previsto</label>
                            <input type="number" id="orcamento_previsto" name="orcamento_previsto" class="form-control"
                                required step="0.01">
                        </div>
                        <div class="form-group">
                            <label for="orcamento_realizado" class="control-label"><small
                                    class="req text-danger">*</small> Orçamento Realizado</label>
                            <input type="number" id="orcamento_realizado" name="orcamento_realizado"
                                class="form-control" required step="0.01">
                        </div>
                        <div class="form-group">
                            <label for="data_planeamento" class="control-label"><small class="req text-danger">*</small>
                                Data do Planeamento</label>
                            <input type="date" id="data_planeamento" name="data_planeamento" class="form-control"
                                required>
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

<?= form_open(admin_url('gestao_formacao/editar_planeamento'), array('method' => 'post', 'id' => 'form_edit_planeamento')) ?>
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
                            <label for="e_orcamento_previsto" class="control-label"><small
                                    class="req text-danger">*</small> Orçamento Previsto</label>
                            <input type="number" id="e_orcamento_previsto" name="e_orcamento_previsto"
                                class="form-control" required step="0.01">
                        </div>
                        <div class="form-group">
                            <label for="e_orcamento_realizado" class="control-label"><small
                                    class="req text-danger">*</small> Orçamento Realizado</label>
                            <input type="number" id="e_orcamento_realizado" name="e_orcamento_realizado"
                                class="form-control" required step="0.01">
                        </div>
                        <div class="form-group">
                            <label for="e_data_planeamento" class="control-label"><small
                                    class="req text-danger">*</small> Data do Planejamento</label>
                            <input type="date" id="e_data_planeamento" name="e_data_planeamento" class="form-control"
                                required>
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
$('.btn_edit_planeamento').click(function() {
    let curso = $(this).attr('data-curso');
    let orcamento_previsto = $(this).attr('data-orcamento_previsto');
    let orcamento_realizado = $(this).attr('data-orcamento_realizado');
    let data_planeamento = $(this).attr('data-data_planeamento');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_formacao/editar_planeamento') ?>/" + id;
    $('#form_edit_planeamento').attr('action', url);

    $('select[name="e_curso"]').selectpicker('val', curso);
    $('input[name="e_orcamento_previsto"]').val(orcamento_previsto);
    $('input[name="e_orcamento_realizado"]').val(orcamento_realizado);
    $('input[name="e_data_planeamento"]').val(data_planeamento);

    $('#editar').modal('show');
})
</script>