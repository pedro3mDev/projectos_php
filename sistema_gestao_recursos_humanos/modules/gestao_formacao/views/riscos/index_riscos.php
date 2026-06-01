<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_formacao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão da Formação / Riscos
                </a>
            </div>
            <div class="col-md-2" style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
            </div>
        </div>

        </br>
        <?php require 'modules/gestao_formacao/views/riscos/cards.php'; ?>
        </br>

        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Risco
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">

                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Novo Risco
                                </a>
                                <a href="<?php echo admin_url('gestao_formacao/riscos_conformidade')?>" class="btn"
                                    style="background-color: #FFD700; border-color: #FFD700; color: white;">
                                    <i class="fa-regular "></i>
                                    Conformidade
                                </a>
                            </div>

                        </div>
                        <div class="row">
                            <div class=" col-md-6">
                            </div>
                            <div class=" col-md-3">
                                <select name="nivel_risco_f" id="nivel_risco_f" class="selectpicker"
                                    data-live-search="true" data-width="100%"
                                    data-none-selected-text="<?php echo _l('Nivel de Risco'); ?>">
                                    <option value=""></option>
                                    <?php foreach ($nivel_risco as $item) : ?>
                                    <option value="<?= $item['nome'] ?>"><?= $item['nome'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class=" col-md-3">
                                <select name="estado_f" id="estado_f" class="selectpicker" data-live-search="true"
                                    data-width="100%" data-none-selected-text="<?php echo _l('Estado'); ?>">
                                    <option value=""></option>
                                    <?php foreach ($status as $item) : ?>
                                    <option value="<?= $item['status'] ?>"><?= $item['status'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <br><br>
                        <table class="table table-hover table-bordered table-responsive dt-table">
                            <thead class="thead-custom">
                                <th>Curso</th>
                                <th>Descrição</th>
                                <th>Nível de Risco</th>
                                <th>Data de Identificação</th>
                                <th>Estado</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach($risco as $item) : ?>
                                <tr>
                                    <td><?php echo html_entity_decode($item['curso']); ?></td>
                                    <td><?php echo html_entity_decode($item['descricao']); ?></td>
                                    <td><?php echo html_entity_decode($item['nivel_risco']); ?></td>
                                    <td><?php echo html_entity_decode($item['data_identificacao']); ?></td>
                                    <td>
                                        <?php
                                            $cor = "#999"; // Cor padrão (cinza para pendente)
                                            if ($item['status'] == "Aprovado") {
                                                $cor = "green";
                                            } elseif ($item['status'] == "Rejeitado") {
                                                $cor = "red";
                                            }
                                        ?>
                                        <a
                                            style="background-color: <?= $cor ?>; color:#fff; padding: 5px; border-radius:10px;">
                                            <?= html_entity_decode($item['status'] ?? '') ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php if ($item['status_id'] == 1) : ?>
                                        <a href="<?php echo admin_url('gestao_formacao/risco_aprovar/'.$item['id']); ?>"
                                            class="btn btn-success" style="color: white;">
                                            Aprovar
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas rejeitar?');"
                                            href="<?php echo admin_url('gestao_formacao/risco_rejeitar/'.$item['id']); ?>"
                                            class="btn btn-danger" style="color: white;">
                                            Rejeitar
                                        </a>
                                        <?php endif ?>
                                        <a href="<?php echo admin_url('gestao_formacao/riscos_visualizar_risco')?>"
                                            class="btn btn-sucess btn-icon"
                                            style="background-color: #28a745; border-color: #28a745; color: white;">
                                            <i style="color:#fff;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?php echo html_entity_decode($item['id']); ?>"
                                            data-curso="<?php echo html_entity_decode($item['curso_id']); ?>"
                                            data-descricao="<?php echo html_entity_decode($item['descricao']); ?>"
                                            data-nivel_risco="<?php echo html_entity_decode($item['nivel_risco_id']); ?>"
                                            data-data_identificacao="<?php echo html_entity_decode($item['data_identificacao']); ?>"
                                            data-aprovadores='<?= html_entity_decode(($item["aprovadores"] ?? "")) ?>'
                                            class="btn btn-default btn-icon btn_edit_risco"
                                            style="background-color: #007bff; border-color: #007bff; color: white;">
                                            <i style="color:#fff;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas eliminar este Risco?');"
                                            href="<?php echo admin_url('gestao_formacao/delete_risco/'.$item['id']) ?>"
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
        <?= form_open(admin_url('gestao_formacao/add_risco'), ['method' => 'post']) ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Novo Risco</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <?php if (validation_errors()): ?>
                        <div class="alert alert-danger">
                            <?= validation_errors(); ?>
                        </div>
                        <?php endif; ?>
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
                            <label for="descricao" class="control-label">
                                <small class="req text-danger">*</small> Descrição
                            </label>
                            <textarea id="descricao" name="descricao" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="nivel_risco" class="control-label">
                                <small class="req text-danger">*</small> Nível de Risco
                            </label>
                            <select id="nivel_risco" name="nivel_risco" class="form-control" required>
                                <option value="">Selecione o nível de risco</option>
                                <?php foreach ($nivel_risco as $item): ?>
                                <option value="<?= $item['id'] ?>"><?= $item['nome'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="data_identificacao" class="control-label">
                                <small class="req text-danger">*</small> Data de Identificação
                            </label>
                            <input type="date" id="data_identificacao" name="data_identificacao" class="form-control"
                                required>
                        </div>
                        <div class="form-group">
                            <?php
                            $selectedStaff = '';
                            echo render_select('aprovadores[]', $staff_list, ['staffid', ['firstname', 'lastname']], 'Aprovadores<span class="text-danger">*</span>', $selectedStaff, ['multiple' => true], [], '', '', false);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success">Salvar</button>
            </div>
        </div>
        <?= form_close(); ?>
    </div>
</div>

<?= form_open(admin_url('gestao_formacao/editar_risco'), array('method' => 'post', 'id' => 'form_edit_risco')) ?>
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
                    <div class="col-12">
                        <?php if (validation_errors()): ?>
                        <div class="alert alert-danger">
                            <?= validation_errors(); ?>
                        </div>
                        <?php endif; ?>
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
                            <label for="e_descricao" class="control-label">
                                <small class="req text-danger">*</small> Descrição
                            </label>
                            <textarea id="e_descricao" name="e_descricao" class="form-control" rows="3"
                                required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="e_nivel_risco" class="control-label">
                                <small class="req text-danger">*</small> Nível de Risco
                            </label>
                            <select id="e_nivel_risco" name="e_nivel_risco" class="form-control" required>
                                <option value="">Selecione o nível de risco</option>
                                <?php foreach ($nivel_risco as $item): ?>
                                <option value="<?= $item['id'] ?>"><?= $item['nome'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="e_data_identificacao" class="control-label">
                                <small class="req text-danger">*</small> Data de Identificação
                            </label>
                            <input type="date" id="e_data_identificacao" name="e_data_identificacao"
                                class="form-control" required>
                        </div>
                        <div class="form-group">
                            <?php
                            $selectedStaff = '';
                            echo render_select('e_aprovadores[]', $staff_list, ['staffid', ['firstname', 'lastname']], 'Aprovadores<span class="text-danger">*</span>', $selectedStaff, ['multiple' => true], [], '', '', false);
                            ?>
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
$('.btn_edit_risco').click(function() {
    let curso = $(this).attr('data-curso');
    let descricao = $(this).attr('data-descricao');
    let nivel_risco = $(this).attr('data-nivel_risco');
    let data_identificacao = $(this).attr('data-data_identificacao');
    let aprovadores = $(this).attr('data-aprovadores');

    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_formacao/editar_risco') ?>/" + id;
    $('#form_edit_risco').attr('action', url);

    $('select[name="e_curso"]').selectpicker('val', curso);
    $('textarea[name="e_descricao"]').val(descricao);
    $('select[name="e_nivel_risco"]').val(nivel_risco);
    $('input[name="e_data_identificacao"]').val(data_identificacao);
    $('select[name="e_aprovadores[]"]').selectpicker('val', JSON.parse(aprovadores));

    $('#editar').modal('show');
})
$('#estado_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(4).search(this.value).draw();
})
$('#nivel_risco_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(2).search(this.value).draw();
})
</script>