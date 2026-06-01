<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_formacao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão da Formação / Compliance / Certificado de Acreditação
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
                                    Certificado de Acreditação
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">

                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Nova Avaliação
                                </a>
                                <a href="<?php echo admin_url('gestao_formacao/compliance')?>" class="btn"
                                    style="background-color: #FFD700; border-color: #FFD700; color: white;">
                                    <i class="fa-regular "></i>
                                    Recrutamento
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
                                <th>Entidade Acreditadora</th>
                                <th>Validade</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach($certificado_acreditacao as $item) : ?>
                                <tr>
                                    <td><?= html_entity_decode($item['curso'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['entidade_acreditadora'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['validade'] ?? '') ?></td>
                                    <td>
                                        <a href="<?php echo admin_url('gestao_formacao/compliance_visualizar_avaliacao')?>"
                                            data-id="" class="btn btn-sucess btn-icon"
                                            style="background-color: #28a745; border-color: #28a745; color: white;">
                                            <i style="color:#fff;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?= html_entity_decode($item['id'] ?? '') ?>"
                                            data-curso="<?= html_entity_decode($item['curso_id'] ?? '') ?>"
                                            data-entidade_acreditadora="<?= html_entity_decode($item['entidade_acreditadora'] ?? '') ?>"
                                            data-validade="<?= html_entity_decode($item['validade'] ?? '') ?>"
                                            class="btn btn-default btn-icon btn_edit_certificado_acreditacao"
                                            style="background-color: #007bff; border-color: #007bff; color: white;">
                                            <i style="color:#fff;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas eliminar este Certificado de Acreditaçãoo?');"
                                            href="<?php echo admin_url('gestao_formacao/delete_certificado_acreditacao/'.$item['id']) ?>"
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
    <div class="modal-dialog">
        <?php echo form_open(admin_url('gestao_formacao/add_certificado_acreditacao'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Novo Registro</h4>
            </div>
            <div class="modal-body">
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
                            <label for="entidade_acreditadora" class="control-label">
                                <small class="req text-danger">*</small> Entidade Acreditadora
                            </label>
                            <input type="text" id="entidade_acreditadora" name="entidade_acreditadora"
                                class="form-control" required placeholder="Digite a entidade acreditadora">
                        </div>
                        <div class="form-group">
                            <label for="validade" class="control-label">
                                <small class="req text-danger">*</small> Validade
                            </label>
                            <input type="date" id="validade" name="validade" class="form-control" required>
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

<?= form_open(admin_url('gestao_formacao/editar_certificado_acreditacao'), array('method' => 'post', 'id' => 'form_edit_certificado_acreditacao')) ?>
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
                            <label for="e_entidade_acreditadora" class="control-label">
                                <small class="req text-danger">*</small> Entidade Acreditadora
                            </label>
                            <input type="text" id="e_entidade_acreditadora" name="e_entidade_acreditadora"
                                class="form-control" required placeholder="Digite a entidade acreditadora">
                        </div>
                        <div class="form-group">
                            <label for="e_validade" class="control-label">
                                <small class="req text-danger">*</small> Validade
                            </label>
                            <input type="date" id="e_validade" name="e_validade" class="form-control" required>
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
$('.btn_edit_certificado_acreditacao').click(function() {
    let curso = $(this).attr('data-curso');
    let entidade_acreditadora = $(this).attr('data-entidade_acreditadora');
    let validade = $(this).attr('data-validade');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_formacao/editar_certificado_acreditacao') ?>/" + id;
    $('#form_edit_certificado_acreditacao').attr('action', url);

    $('select[name="e_curso"]').selectpicker('val', curso);
    $('input[name="e_entidade_acreditadora"]').val(entidade_acreditadora);
    $('input[name="e_validade"]').val(validade);

    $('#editar').modal('show');
})
$('#estado_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(2).search(this.value).draw();
})
</script>