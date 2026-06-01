<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_formacao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão da Formação / Impacto / Relatório de Impacto
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
                                    Relatório de Impacto
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">

                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Novo Relatório
                                </a>
                                <a href="<?php echo admin_url('gestao_formacao/impacto')?>" class="btn"
                                    style="background-color: #FFD700; border-color: #FFD700; color: white;">
                                    <i class="fa-regular "></i>
                                    Avaliação
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
                                <th>Impacto Qualitativo</th>
                                <th>Impacto Quantitativo</th>
                                <th>Data do Relatório</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach($relatorio_impacto as $item) : ?>
                                <tr>
                                    <td><?php echo html_entity_decode($item['curso']); ?></td>
                                    <td><?php echo html_entity_decode($item['nome_iql']); ?></td>
                                    <td><?php echo html_entity_decode($item['nome_iqn']); ?></td>
                                    <td><?php echo html_entity_decode($item['data_relatorio']); ?></td>
                                    <td>
                                        <a href="<?php echo admin_url('gestao_formacao/impacto_visualizar_relatorio') ?>"
                                            class="btn btn-sucess btn-icon"
                                            style="background-color: #28a745; border-color: #28a745; color: white;">
                                            <i style="color:#fff;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?php echo html_entity_decode($item['id']); ?>"
                                            data-curso="<?php echo html_entity_decode($item['curso_id']); ?>"
                                            data-impacto_qualitativo="<?php echo html_entity_decode($item['impacto_qualitativo_id']); ?>"
                                            data-impacto_quantitativo="<?php echo html_entity_decode($item['impacto_quantitativo_id']); ?>"
                                            data-data_relatorio="<?php echo html_entity_decode($item['data_relatorio']); ?>"
                                            class="btn btn-default btn-icon btn_edit_impacto_relatorio"
                                            style="background-color: #007bff; border-color: #007bff; color: white;">
                                            <i style="color:#fff;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas eliminar este Relatório de Impacto?');"
                                            href="<?php echo admin_url('gestao_formacao/delete_relatorio_impacto/'. $item['id']) ?>"
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
        <?php echo form_open(admin_url('gestao_formacao/add_relatorio_impacto'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Novo Relatório</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="curso"><small class="req text-danger">*</small> Curso</label>
                    <select id="curso" name="curso" class="form-control" required>
                        <option value="">Selecione o curso</option>
                        <?php foreach ($cursos as $item) { ?>
                        <option value="<?php echo $item['id']; ?>">
                            <?php echo $item['nome']; ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="impacto_qualitativo"><small class="req text-danger">*</small> Impacto
                        Qualitativo</label>
                    <select id="impacto_qualitativo" name="impacto_qualitativo" class="form-control" required>
                        <option value="">Selecione o Impacto Qualitativo</option>
                        <?php foreach ($impacto_qualitativo as $item) { ?>
                        <option value="<?php echo $item['id']; ?>">
                            <?php echo $item['nome']; ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="impacto_quantitativo"><small class="req text-danger">*</small> Impacto
                        Quantitativo</label>
                    <select id="impacto_quantitativo" name="impacto_quantitativo" class="form-control" required>
                        <option value="">Selecione o Impacto Quantitativo</option>
                        <?php foreach ($impacto_quantitativo as $item) { ?>
                        <option value="<?php echo $item['id']; ?>">
                            <?php echo $item['nome']; ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="data_relatorio"><small class="req text-danger">*</small> Data do Relatório</label>
                    <input type="date" id="data_relatorio" name="data_relatorio" class="form-control" required>
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

<?= form_open(admin_url('gestao_formacao/editar_relatorio_impacto'), array('method' => 'post', 'id' => 'form_edit_relatorio_impacto')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Editar Avaliação </h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="e_curso"><small class="req text-danger">*</small> Curso</label>
                    <select id="e_curso" name="e_curso" class="form-control" required>
                        <option value="">Selecione o curso</option>
                        <?php foreach ($cursos as $item) { ?>
                        <option value="<?php echo $item['id']; ?>">
                            <?php echo $item['nome']; ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="e_impacto_qualitativo"><small class="req text-danger">*</small> Impacto
                        Qualitativo</label>
                    <select id="e_impacto_qualitativo" name="e_impacto_qualitativo" class="form-control" required>
                        <option value="">Selecione o Impacto Qualitativo</option>
                        <?php foreach ($impacto_qualitativo as $item) { ?>
                        <option value="<?php echo $item['id']; ?>">
                            <?php echo $item['nome']; ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="e_impacto_quantitativo"><small class="req text-danger">*</small> Impacto
                        Quantitativo</label>
                    <select id="e_impacto_quantitativo" name="e_impacto_quantitativo" class="form-control" required>
                        <option value="">Selecione o Impacto Quantitativo</option>
                        <?php foreach ($impacto_quantitativo as $item) { ?>
                        <option value="<?php echo $item['id']; ?>">
                            <?php echo $item['nome']; ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="e_data_relatorio"><small class="req text-danger">*</small> Data do Relatório</label>
                    <input type="date" id="e_data_relatorio" name="e_data_relatorio" class="form-control" required>
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
$('.btn_edit_impacto_relatorio').click(function() {
    let curso = $(this).attr('data-curso');
    let impacto_qualitativo = $(this).attr('data-impacto_qualitativo');
    let impacto_quantitativo = $(this).attr('data-impacto_quantitativo');
    let data_relatorio = $(this).attr('data-data_relatorio');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_formacao/editar_relatorio_impacto') ?>/" + id;
    $('#form_edit_relatorio_impacto').attr('action', url);

    $('select[name="e_curso"]').selectpicker('val', curso);
    $('select[name="e_impacto_qualitativo"]').val(impacto_qualitativo);
    $('select[name="e_impacto_quantitativo"]').val(impacto_quantitativo);
    $('input[name="e_data_relatorio"]').val(data_relatorio);

    $('#editar').modal('show');
})
</script>