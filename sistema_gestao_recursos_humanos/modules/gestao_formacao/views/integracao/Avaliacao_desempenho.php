<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_formacao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão da Formação / Integração / Avaliação de Desempenho
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
                                    Avaliação de Desempenho
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
                                <a href="<?php echo admin_url('gestao_formacao/integracao')?>" class="btn"
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
                                <select name="competencia_f" id="competencia_f" class="selectpicker"
                                    data-live-search="true" data-width="100%"
                                    data-none-selected-text="<?php echo _l('competencia'); ?>">
                                    <option value=""></option>
                                    <?php foreach ($competencia as $item) { ?>
                                    <option value="<?php echo $item['nome']; ?>">
                                        <?php echo $item['nome']; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <br><br>
                        <table class="table table-hover table-bordered table-responsive dt-table">
                            <thead class="thead-custom">
                                <th>Nome (Recruta)</th>
                                <th>Curso(carga Horária)</th>
                                <th>Competência</th>
                                <th>Nota</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach($aval_desempenho as $item) : ?>
                                <tr>
                                    <td><?= $item['firstname'] .' '.$item['lastname'] ?></td>
                                    <td><?php echo $item['curso']; ?> (Carga Horária:
                                        <?php echo $item['carga_horaria']; ?>)</td>
                                    <td><?= $item['competencia'] ?></td>
                                    <td><?= $item['nota'] ?></td>
                                    <td>
                                        <a href="<?php echo admin_url('gestao_formacao/integracao_visualizar_avaliacao')?>"
                                            class="btn btn-sucess btn-icon"
                                            style="background-color: #28a745; border-color: #28a745; color: white;">
                                            <i style="color:#fff;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?= $item['id'] ?>"
                                            data-recrutamento="<?= $item['recrutamento_id'] ?>"
                                            data-competencia="<?= $item['competencia_id'] ?>"
                                            data-nota="<?= $item['nota'] ?>"
                                            class="btn btn-default btn-icon btn_edit_aval_desempenho"
                                            style="background-color: #007bff; border-color: #007bff; color: white;">
                                            <i style="color:#fff;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas eliminar este Avaliação?');"
                                            href="<?php echo admin_url('gestao_formacao/delete_aval_desempenho/'.$item['id']) ?>"
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
        <?php echo form_open(admin_url('gestao_formacao/add_aval_desempenho'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Nova Avaliação</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="recrutamento" class="control-label"><small class="req text-danger">*</small>
                                Recruta</label>
                            <select name="recrutamento" id="recrutamento" class="selectpicker" data-live-search="true"
                                data-width="100%" data-none-selected-text="<?php echo _l('Curso'); ?>">
                                <option value="">Selecione um Recruta</option>
                                <?php foreach ($recrutamento as $item) { ?>
                                <option value="<?php echo $item['id']; ?>">
                                    <?= $item['firstname'] .' '.$item['lastname'] ?> - <?php echo $item['curso']; ?> -
                                    Carga Horária: <?php echo $item['carga_horaria']; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="competencia" class="control-label"><small class="req text-danger">*</small>
                                Competência</label>
                            <select name="competencia" id="competencia" class="selectpicker" data-live-search="true"
                                data-width="100%" data-none-selected-text="<?php echo _l('competencia'); ?>">
                                <option value="">Selecione uma Competência</option>
                                <?php foreach ($competencia as $item) { ?>
                                <option value="<?php echo $item['id']; ?>">
                                    <?php echo $item['nome']; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nota" class="control-label">
                                <small class="req text-danger">*</small> Nota
                            </label>
                            <input type="number" id="nota" name="nota" class="form-control" required min="0" max="20"
                                step="0.1">
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

<?= form_open(admin_url('gestao_formacao/editar_aval_desempenho'), array('method' => 'post', 'id' => 'form_edit_aval_desempenho')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Editar Avaliação </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="e_recrutamento" class="control-label"><small class="req text-danger">*</small>
                                Recruta</label>
                            <select name="e_recrutamento" id="e_recrutamento" class="selectpicker"
                                data-live-search="true" data-width="100%"
                                data-none-selected-text="<?php echo _l('Curso'); ?>">
                                <option value="">Selecione um Recruta</option>
                                <?php foreach ($recrutamento as $item) { ?>
                                <option value="<?php echo $item['id']; ?>">
                                    <?= $item['firstname'] .' '.$item['lastname'] ?> - <?php echo $item['curso']; ?> -
                                    Carga Horária: <?php echo $item['carga_horaria']; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="e_competencia" class="control-label"><small class="req text-danger">*</small>
                                Competência</label>
                            <select name="e_competencia" id="e_competencia" class="selectpicker" data-live-search="true"
                                data-width="100%" data-none-selected-text="<?php echo _l('competencia'); ?>">
                                <option value="">Selecione uma Competência</option>
                                <?php foreach ($competencia as $item) { ?>
                                <option value="<?php echo $item['id']; ?>">
                                    <?php echo $item['nome']; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="e_nota" class="control-label">
                                <small class="req text-danger">*</small> Nota
                            </label>
                            <input type="number" id="e_nota" name="e_nota" class="form-control" required min="0"
                                max="20" step="0.1">
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
$('.btn_edit_aval_desempenho').click(function() {
    let recrutamento = $(this).attr('data-recrutamento');
    let competencia = $(this).attr('data-competencia');
    let nota = $(this).attr('data-nota');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_formacao/editar_aval_desempenho') ?>/" + id;
    $('#form_edit_aval_desempenho').attr('action', url);

    $('select[name="e_recrutamento"]').selectpicker('val', recrutamento);
    $('select[name="e_competencia"]').selectpicker('val', competencia);
    $('input[name="e_nota"]').val(nota);

    $('#editar').modal('show');
})

$('#competencia_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(2).search(this.value).draw();
})
</script>