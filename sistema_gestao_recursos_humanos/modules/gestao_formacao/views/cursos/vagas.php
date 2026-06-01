<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_formacao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão da Formação / Cursos / Vagas
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
                                    Vagas
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">

                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Nova Vaga
                                </a>
                                <a href="<?php echo admin_url('gestao_formacao/cursos')?>" class="btn"
                                    style="background-color: #3CB371; border-color: #3CB371; color: white;">
                                    <i class="fa-regular "></i>
                                    Curso
                                </a>
                                <a href="<?php echo admin_url('gestao_formacao/cursos_categoria')?>" class="btn"
                                    style="background-color: #336; border-color: #336; color: white;">
                                    <i class="fa-regular "></i>
                                    Categoria
                                </a>
                                <a href="<?php echo admin_url('gestao_formacao/cursos_Inscricoes')?>" class="btn"
                                    style="background-color: #800000; border-color: #800000; color: white;">
                                    <i class="fa-regular "></i>
                                    Inscrições
                                </a>
                            </div>

                        </div>
                        <div class="row">
                            <div class=" col-md-9">
                            </div>
                            <div class=" col-md-3">
                                <select name="curso_f" id="curso_f" class="selectpicker" multiple="true"
                                    data-live-search="true" data-width="100%"
                                    data-none-selected-text="<?php echo _l('Curso'); ?>">
                                    <option value=""></option>
                                    <?php foreach ($cursos as $item) { ?>
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
                                <th>Curso (Carga Horária)</th>
                                <th>Total de Vagas</th>
                                <th>Vagas Disponivel</th>
                                <th>Data de Início</th>
                                <th>Data de Fim</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach($vagas as $item) : ?>
                                <tr>
                                    <td><?= $item['curso'] ?> (<?= $item['carga_horaria'] ?>)</td>
                                    <td><?= $item['total_vagas'] ?></td>
                                    <td><?= gf_vagas_dosponiveis($item['id'], $item['total_vagas']) ?></td>
                                    <td><?= $item['data_inicio'] ?></td>
                                    <td><?= $item['data_fim'] ?></td>
                                    <td>
                                        <a href="<?php echo admin_url('gestao_formacao/cursos_visualizar_vaga')?>"
                                            class="btn btn-sucess btn-icon"
                                            style="background-color: #28a745; border-color: #28a745; color: white;">
                                            <i style="color:#fff;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-curso="<?= $item['curso_id'] ?>"
                                            data-total_vagas="<?= $item['total_vagas'] ?>"
                                            data-data_inicio="<?= $item['data_inicio'] ?>"
                                            data-data_fim="<?= $item['data_fim'] ?>" data-id="<?= $item['id'] ?>"
                                            class="btn btn-default btn-icon btn_edit_vaga"
                                            style="background-color: #007bff; border-color: #007bff; color: white;">
                                            <i style="color:#fff;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas eliminar este Registros de Vaga?');"
                                            href="<?php echo admin_url('gestao_formacao/delete_vaga/'.$item['id'])?>"
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
        <?php echo form_open(admin_url('gestao_formacao/add_vaga'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Nova vaga</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nome" class="control-label"><small class="req text-danger">*</small>
                                Curso</label>
                            <select name="curso" id="curso" class="selectpicker" data-live-search="true"
                                data-width="100%" data-none-selected-text="<?php echo _l('Curso'); ?>">
                                <option value="">Selecione um Curso</option>
                                <?php foreach ($cursos as $item) { ?>
                                <option value="<?php echo $item['id']; ?>">
                                    <?php echo $item['nome']; ?> - Carga Horária: <?php echo $item['carga_horaria']; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="total_vagas" class="control-label"><small class="req text-danger">*</small>
                                Total de Vagas</label>
                            <input type="number" id="total_vagas" name="total_vagas" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="data_inicio" class="control-label"><small class="req text-danger">*</small> Data
                                de Início</label>
                            <input type="date" id="data_inicio" name="data_inicio" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="data_fim" class="control-label"><small class="req text-danger">*</small> Data de
                                Fim</label>
                            <input type="date" id="data_fim" name="data_fim" class="form-control" required>
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

<?= form_open(admin_url('gestao_formacao/editar_vaga'), array('method' => 'post', 'id' => 'form_edit_vaga')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Editar Curso </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nome" class="control-label"><small class="req text-danger">*</small>
                                Curso</label>
                            <select name="e_curso" id="e_curso" class="selectpicker" data-live-search="true"
                                data-width="100%" data-none-selected-text="<?php echo _l('Curso'); ?>">
                                <option value="">Selecione um Curso</option>
                                <?php foreach ($cursos as $item) { ?>
                                <option value="<?php echo $item['id']; ?>">
                                    <?php echo $item['nome']; ?> - Carga Horária: <?php echo $item['carga_horaria']; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="e_total_vagas" class="control-label"><small class="req text-danger">*</small>
                                Total de Vagas</label>
                            <input type="number" id="e_total_vagas" name="e_total_vagas" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="e_data_inicio" class="control-label"><small class="req text-danger">*</small>
                                Data
                                de Início</label>
                            <input type="date" id="e_data_inicio" name="e_data_inicio" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="e_data_fim" class="control-label"><small class="req text-danger">*</small> Data
                                de
                                Fim</label>
                            <input type="date" id="e_data_fim" name="e_data_fim" class="form-control" required>
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
$('.btn_edit_vaga').click(function() {
    let curso = $(this).attr('data-curso');
    let total_vagas = $(this).attr('data-total_vagas');
    let data_inicio = $(this).attr('data-data_inicio');
    let data_fim = $(this).attr('data-data_fim');

    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_formacao/editar_vaga') ?>/" + id;
    $('#form_edit_vaga').attr('action', url);

    $('select[name="e_curso"]').selectpicker('val', curso);
    $('input[name="e_total_vagas"]').val(total_vagas);
    $('input[name="e_data_inicio"]').val(data_inicio);
    $('input[name="e_data_fim"]').val(data_fim);

    $('#editar').modal('show');
})

$('#curso_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(0).search(this.value).draw();
})
</script>