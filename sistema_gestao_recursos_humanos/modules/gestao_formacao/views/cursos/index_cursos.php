<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_formacao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão da Formação / Cursos
                </a>
            </div>
            <div class="col-md-2" style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
            </div>
        </div>

        </br>
        <?php require 'modules/gestao_formacao/views/cursos/cards.php'; ?>
        </br>

        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Cursos
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">

                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Novo Curso
                                </a>
                                <a href="<?php echo admin_url('gestao_formacao/cursos_categoria')?>" class="btn"
                                    style="background-color: #336; border-color: #336; color: white;">
                                    <i class="fa-regular "></i>
                                    Categoria
                                </a>
                                <a href="<?php echo admin_url('gestao_formacao/cursos_vagas')?>" class="btn"
                                    style="background-color: #DAA520; border-color: #DAA520; color: white;">
                                    <i class="fa-regular "></i>
                                    Vagas
                                </a>
                                <a href="<?php echo admin_url('gestao_formacao/cursos_Inscricoes')?>" class="btn"
                                    style="background-color: #800000; border-color: #800000; color: white;">
                                    <i class="fa-regular "></i>
                                    Inscrições
                                </a>
                            </div>

                        </div>
                        <div class="row">
                            <div class=" col-md-6">
                            </div>
                            <div class=" col-md-3">
                                <select name="estado_f" id="estado_f" class="selectpicker" multiple="true"
                                    data-live-search="true" data-width="100%"
                                    data-none-selected-text="<?php echo _l('Estado'); ?>">
                                    <option value=""></option>
                                    <?php foreach($status as $item) : ?>
                                    <option value="<?= $item['status'] ?>"><?= $item['status'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class=" col-md-3">
                                <select name="categoria_f" id="categoria_f" class="selectpicker" multiple="true"
                                    data-live-search="true" data-width="100%"
                                    data-none-selected-text="<?php echo _l('Categoria'); ?>">
                                    <option value=""></option>
                                    <?php foreach($categorias as $item) : ?>
                                    <option value="<?= $item['nome'] ?>"><?= $item['nome'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <br><br>
                        <table class="table table-hover table-bordered table-responsive dt-table">
                            <thead class="thead-custom">
                                <th>Nome</th>
                                <th>Categoria</th>
                                <th>Descrição</th>
                                <th>Carga Horária</th>
                                <th>Público Alvo</th>
                                <th>Requisitos</th>
                                <th>Estado</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach($cursos as $item) : ?>
                                <tr>
                                    <td><?= html_entity_decode($item['nome'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['categoria'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['descricao'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['carga_horaria'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['publico_alvo'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['requisitos'] ?? '') ?></td>
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
                                        <a href="<?php echo admin_url('gestao_formacao/curso_aprovar/'.$item['id']); ?>"
                                            class="btn btn-success" style="color: white;">
                                            Aprovar
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas rejeitar?');"
                                            href="<?php echo admin_url('gestao_formacao/curso_rejeitar/'.$item['id']); ?>"
                                            class="btn btn-danger" style="color: white;">
                                            Rejeitar
                                        </a>
                                        <?php endif ?>
                                        <a href="<?php echo admin_url('gestao_formacao/cursos_visualizar_curso')?>"
                                            class="btn btn-sucess btn-icon"
                                            style="background-color: #28a745; border-color: #28a745; color: white;">
                                            <i style="color:#fff;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?= $item['id'] ?>"
                                            data-nome="<?= html_entity_decode($item['nome'] ?? '') ?>"
                                            data-categoria="<?= html_entity_decode($item['categoria_id'] ?? '') ?>"
                                            data-descricao="<?= html_entity_decode($item['descricao'] ?? '') ?>"
                                            data-carga_horaria="<?= html_entity_decode($item['carga_horaria'] ?? '') ?>"
                                            data-publico_alvo="<?= html_entity_decode($item['publico_alvo'] ?? '') ?>"
                                            data-requisitos="<?= html_entity_decode($item['requisitos'] ?? '') ?>"
                                            data-aprovadores='<?= html_entity_decode(($item["aprovadores"] ?? "")) ?>'
                                            class="btn btn-default btn-icon btn_edit_curso"
                                            style="background-color: #007bff; border-color: #007bff; color: white;">
                                            <i style="color:#fff;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas eliminar este Curso?');"
                                            href="<?php echo admin_url('gestao_formacao/delete_curso/'.$item['id']); ?>"
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
        <?php echo form_open(admin_url('gestao_formacao/add_curso'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Novo Curso</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nome" class="control-label"><small class="req text-danger">*</small>
                                Categoria</label>
                            <select name="categoria" id="categoria" class="selectpicker" data-live-search="true"
                                data-width="100%" data-none-selected-text="<?php echo _l('Categoria'); ?>">
                                <option value="">Selecione uma categoria</option>
                                <?php foreach ($categorias as $categoria) { ?>
                                <option value="<?php echo $categoria['id']; ?>"><?php echo $categoria['nome']; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nome" class="control-label"><small class="req text-danger">*</small>
                                Nome</label>
                            <input type="text" id="nome" name="nome" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="descricao" class="control-label"><small class="req text-danger">*</small>
                                Descrição</label>
                            <textarea id="descricao" name="descricao" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="carga_horaria" class="control-label"><small class="req text-danger">*</small>
                                Carga Horária</label>
                            <input type="number" id="carga_horaria" name="carga_horaria" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="publico_alvo" class="control-label"><small class="req text-danger">*</small>
                                Público Alvo</label>
                            <textarea id="publico_alvo" name="publico_alvo" class="form-control" rows="2"
                                required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="requisitos" class="control-label"><small class="req text-danger">*</small>
                                Requisitos</label>
                            <textarea id="requisitos" name="requisitos" class="form-control" rows="2"
                                required></textarea>
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
        <?php echo form_close(); ?>
    </div>
</div>

<?= form_open(admin_url('gestao_formacao/editar_curso'), array('method' => 'post', 'id' => 'form_edit_curso')) ?>
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
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="e_categoria" class="control-label"><small class="req text-danger">*</small>
                                Categoria</label>
                            <select name="e_categoria" id="e_categoria" class="selectpicker" data-live-search="true"
                                data-width="100%" data-none-selected-text="<?php echo _l('Categoria'); ?>">
                                <option value="">Selecione uma categoria</option>
                                <?php foreach ($categorias as $categoria) { ?>
                                <option value="<?php echo $categoria['id']; ?>"><?php echo $categoria['nome']; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="e_nome" class="control-label"><small class="req text-danger">*</small>
                                Nome</label>
                            <input type="text" id="e_nome" name="e_nome" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="e_descricao" class="control-label"><small class="req text-danger">*</small>
                                Descrição</label>
                            <textarea id="e_descricao" name="e_descricao" class="form-control" rows="3"
                                required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="e_carga_horaria" class="control-label"><small class="req text-danger">*</small>
                                Carga Horária</label>
                            <input type="number" id="e_carga_horaria" name="e_carga_horaria" class="form-control"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="e_publico_alvo" class="control-label"><small class="req text-danger">*</small>
                                Público Alvo</label>
                            <textarea id="e_publico_alvo" name="e_publico_alvo" class="form-control" rows="2"
                                required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="e_requisitos" class="control-label"><small class="req text-danger">*</small>
                                Requisitos</label>
                            <textarea id="e_requisitos" name="e_requisitos" class="form-control" rows="2"
                                required></textarea>
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
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo _l('Cancelar'); ?></button>
                <button type="submit" class="btn btn-success"><?php echo _l('Salvar'); ?></button>
            </div>
        </div>
    </div>
</div>
<?= form_close()  ?>

<?php init_tail(); ?>
<script>
$('.btn_edit_curso').click(function() {
    let categoria = $(this).attr('data-categoria');
    let nome = $(this).attr('data-nome');
    let descricao = $(this).attr('data-descricao');
    let carga_horaria = $(this).attr('data-carga_horaria');
    let publico_alvo = $(this).attr('data-publico_alvo');
    let requisitos = $(this).attr('data-requisitos');
    let aprovadores = $(this).attr('data-aprovadores');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_formacao/editar_curso') ?>/" + id;
    $('#form_edit_curso').attr('action', url);

    $('select[name="e_categoria"]').selectpicker('val', categoria);
    $('input[name="e_nome"]').val(nome);
    $('textarea[name="e_descricao"]').text(descricao);
    $('input[name="e_carga_horaria"]').val(carga_horaria);
    $('textarea[name="e_publico_alvo"]').text(publico_alvo);
    $('textarea[name="e_requisitos"]').text(requisitos);
    $('select[name="e_aprovadores[]"]').selectpicker('val', JSON.parse(aprovadores));

    $('#editar').modal('show');
})
$('#estado_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(6).search(this.value).draw();
})
$('#categoria_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(1).search(this.value).draw();
})
</script>