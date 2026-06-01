<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_formacao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão da Formação / Impacto / Avaliação
                </a>
            </div>
            <div class="col-md-2" style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
            </div>
        </div>

        </br>
        <?php require 'modules/gestao_formacao/views/impacto/cards.php'; ?>
        </br>

        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Avaliação
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
                                <a href="<?php echo admin_url('gestao_formacao/impacto_relatorio')?>" class="btn"
                                    style="background-color: #FFD700; border-color: #FFD700; color: white;">
                                    <i class="fa-regular "></i>
                                    Relatório de Impacto
                                </a>
                            </div>

                        </div>
                        <div class="row">
                            <div class=" col-md-9">
                            </div>

                            <div class=" col-md-3">
                                <select name="curso_f" id="curso_f" class="selectpicker" data-live-search="true"
                                    data-width="100%" data-none-selected-text="<?php echo _l('Curso'); ?>">
                                    <option value=""></option>
                                    <?php foreach ($cursos as $item) : ?>
                                    <option value="<?= $item['nome'] ?>"><?= $item['nome'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <br><br>
                        <table class="table table-hover table-bordered table-responsive dt-table">
                            <thead class="thead-custom">
                                <th>Curso</th>
                                <th>Usuário</th>
                                <th>Nota</th>
                                <th>Comentário</th>
                                <th>Data da Avaliação</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach($avaliacao as $item) : ?>
                                <tr>
                                    <td><?= $item['curso'] ?></td>
                                    <td><?= $item['firstname'] .' '.$item['lastname'] ?></td>
                                    <td><?= $item['nota'] ?></td>
                                    <td><?= $item['comentario'] ?></td>
                                    <td><?= $item['data_avaliacao'] ?></td>
                                    <td>
                                        <a href="<?php echo admin_url('gestao_formacao/impacto_visualizar_avaliacao')?>"
                                            class="btn btn-sucess btn-icon"
                                            style="background-color: #28a745; border-color: #28a745; color: white;">
                                            <i style="color:#fff;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-curso="<?= $item['vaga_id'] ?>"
                                            data-staff="<?= $item['inscricao_id'] ?>" data-nota="<?= $item['nota'] ?>"
                                            data-comentario="<?= $item['comentario'] ?>"
                                            data-data_avaliacao="<?= $item['data_avaliacao'] ?>"
                                            data-id="<?= $item['id'] ?>"
                                            class="btn btn-default btn-icon btn_edit_avaliacao"
                                            style="background-color: #007bff; border-color: #007bff; color: white;">
                                            <i style="color:#fff;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas eliminar esta Avaliação?');"
                                            href="<?php echo admin_url('gestao_formacao/delete_avaliacao/'.$item['id'])?>"
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
        <?php echo form_open(admin_url('gestao_formacao/add_avaliacao'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"> Nova Avaliação</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="vaga" class="control-label"><small class="req text-danger">*</small>
                        Curso</label>
                    <select name="vaga" id="vaga" class="selectpicker" data-live-search="true" data-width="100%"
                        data-none-selected-text="<?php echo _l('Curso'); ?>">
                        <option value="">Selecione um Curso</option>
                        <?php foreach ($vagas as $item) { ?>
                        <option value="<?php echo $item['id']; ?>">
                            <?php echo $item['curso']; ?> -
                            Carga Horária: <?php echo $item['carga_horaria']; ?>
                            (De: <?php echo $item['data_inicio']; ?> à <?php echo $item['data_fim']; ?>)
                        </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="staff"><small class="req text-danger">*</small> Funcionário</label>
                    <select id="staff" name="staff" class="form-control" required>
                        <option value="">Selecione o Funcionário</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nota"><small class="req text-danger">*</small> Nota</label>
                    <input type="number" id="nota" name="nota" class="form-control" min="0" max="20" required>
                </div>
                <div class="form-group">
                    <label for="comentario"><small class="req text-danger">*</small> Comentário</label>
                    <textarea id="comentario" name="comentario" class="form-control" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="data_avaliacao"><small class="req text-danger">*</small> Data da Avaliação</label>
                    <input type="date" id="data_avaliacao" name="data_avaliacao" class="form-control" required>
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

<?= form_open(admin_url('gestao_formacao/editar_avaliacao'), array('method' => 'post', 'id' => 'form_edit_avaliacao')) ?>
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
                    <label for="e_vaga" class="control-label"><small class="req text-danger">*</small>
                        Curso</label>
                    <select name="e_vaga" id="e_vaga" class="selectpicker" data-live-search="true" data-width="100%"
                        data-none-selected-text="<?php echo _l('Curso'); ?>">
                        <option value="">Selecione um Curso</option>
                        <?php foreach ($vagas as $item) { ?>
                        <option value="<?php echo $item['id']; ?>">
                            <?php echo $item['curso']; ?> -
                            Carga Horária: <?php echo $item['carga_horaria']; ?>
                            (De: <?php echo $item['data_inicio']; ?> à <?php echo $item['data_fim']; ?>)
                        </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="e_staff"><small class="req text-danger">*</small> Funcionário</label>
                    <select id="e_staff" name="e_staff" class="form-control" required>
                        <option value="">Selecione o Funcionário</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="e_nota"><small class="req text-danger">*</small> Nota</label>
                    <input type="number" id="e_nota" name="e_nota" class="form-control" min="0" max="20" required>
                </div>
                <div class="form-group">
                    <label for="e_comentario"><small class="req text-danger">*</small> Comentário</label>
                    <textarea id="e_comentario" name="e_comentario" class="form-control" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="e_data_avaliacao"><small class="req text-danger">*</small> Data da Avaliação</label>
                    <input type="date" id="e_data_avaliacao" name="e_data_avaliacao" class="form-control" required>
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
function inscritos(vaga) {
    requestGetJSON('gestao_formacao/listar_inscritos/' + vaga).done(function(response) {
        // Verifica se o status retornado é 'true'
        if (response.status) {
            var dados = response.data;
            var select = $('#staff');
            $('#staff').empty();

            // Limpa as opções existentes antes de adicionar novas
            select.empty();

            // Adiciona a opção padrão
            select.append('<option value=""></option>');

            // Adiciona as opções dos pelórios
            dados.forEach(function(dado) {
                select.append('<option value="' + dado.id +
                    '">' + dado.firstname + ' ' + dado.lastname + '</option>');
            });
        } else {
            alert('Erro ao carregar os Inscritos.');
        }
    });
}

function e_inscritos(vaga, staff = false) {
    requestGetJSON('gestao_formacao/listar_inscritos/' + vaga).done(function(response) {
        // Verifica se o status retornado é 'true'
        if (response.status) {
            var dados = response.data;
            var select = $('#e_staff');
            $('#e_staff').empty();

            // Limpa as opções existentes antes de adicionar novas
            select.empty();

            // Adiciona a opção padrão
            select.append('<option value=""></option>');

            // Adiciona as opções dos pelórios
            dados.forEach(function(dado) {
                select.append('<option value="' + dado.id +
                    '">' + dado.firstname + ' ' + dado.lastname + '</option>');
            });
            if (staff) {
                $('#e_staff').val(staff);
            }
        } else {
            alert('Erro ao carregar os Inscritos.');
        }
    });
}

$('#vaga').change(function() {
    let vaga = $(this).val(); // Obtém o valor selecionado
    inscritos(vaga)
});

$('#e_vaga').change(function() {
    let vaga = $(this).val(); // Obtém o valor selecionado
    e_inscritos(vaga)
});

$('.btn_edit_avaliacao').click(function() {
    let curso = $(this).attr('data-curso');
    let staff = $(this).attr('data-staff');
    let nota = $(this).attr('data-nota');
    let comentario = $(this).attr('data-comentario');
    let data_avaliacao = $(this).attr('data-data_avaliacao');
    let id = $(this).attr('data-id');

    e_inscritos(curso, staff)

    let url = "<?= admin_url('gestao_formacao/editar_avaliacao') ?>/" + id;
    $('#form_edit_avaliacao').attr('action', url);

    $('select[name="e_vaga"]').selectpicker('val', curso);
    $('select[name="e_staff"]').val(staff);
    $('input[name="e_nota"]').val(nota);
    $('textarea[name="e_comentario"]').text(comentario);
    $('input[name="e_data_avaliacao"]').val(data_avaliacao);

    $('#editar').modal('show');
})

$('#curso_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(0).search(this.value).draw();
})
</script>