<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_desenv_individual/assets/css/plano.css'); ?>">

<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-6">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Desenvolvimento Individual / Mentoria
                </a>
            </div>
            <div class="col-md-6" style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
            </div>
        </div>
        </br>

        <?php require 'modules/gestao_desenv_individual/views/mentoria/cards.php'; ?>

        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold"><i class="fa fa-address-card-o"
                                        aria-hidden="true"></i>Mentoria
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Nova Mentoria
                                </a>
                                <a href="<?php echo admin_url('gestao_desenv_individual/mentoria_analise_grafica') ?>" class="btn"
                                    style="background-color: #991b1b; border-color: #991b1b; color: white;">
                                    <i class="fa-regular "></i>
                                    Análise Gráfica
                                </a>
                            </div>
                        </div>
                        </br>
                        <div class="row">
                            <div class=" col-md-6">
                            </div>
                            <div class="col-md-3">
                                <select name="funcionario" id="funcionario" class="selectpicker" data-live-search="true"
                                    data-width="100%" data-none-selected-text="<?php echo _l('Mentor'); ?>">
                                    <option value=""></option>
                                    <?php foreach ($staff as $dado): ?>
                                        <option value="<?= $dado['staffid'] ?>">
                                            <?= $dado['firstname'] . " " . $dado['lastname'] ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <select name="status" id="status" class="selectpicker" data-live-search="true"
                                    data-width="100%" data-none-selected-text="<?php echo _l('Estado'); ?>">
                                    <option value=""></option>
                                    <?php foreach ($status as $dado): ?>
                                        <option value="<?= $dado['id'] ?>"><?= $dado['status'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                        </div>
                        <br><br>
                        <table class="table dt-table">
                            <thead class="thead-custom">
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Data de Secção</th>
                                <th>Mentor</th>
                                <th>Feedback</th>
                                <th>Status</th>
                                <th>Aprovadores</th>
                                <th></th>
                            </thead>
                            <tbody>
                                    <?php foreach ($mentoria as $mentorias): ?>
                                        <tr>
                                            <td> <a href="#"><?= htmlspecialchars($mentorias['nome']); ?></a> </td>
                                            <td> <a
                                                    href="#"><?= htmlspecialchars($mentorias['descricao'] ?? 'Sem descrição'); ?></a>
                                            </td>
                                            <td> <a href="#"><?= date('d/m/Y', strtotime($mentorias['data_seccao'])); ?></a>
                                            </td>
                                            <td> <a
                                                    href="#"><?= htmlspecialchars($mentorias['primeiro_nome'] . " " . $mentorias['segundo_nome']); ?></a>
                                            </td>
                                            <td> <a href="#"><?= htmlspecialchars($mentorias['feedback']); ?></a> </td>
                                            <td> <a href="#"><?= htmlspecialchars($mentorias['status_nome']); ?></a> </td>
                                            <td> <a
                                                    href="#"><?= htmlspecialchars($mentorias['aprovadores_nomes'] ?? 'Nenhum'); ?></a>
                                            </td>
                                            <td>
                                            <?php if ($mentorias['status_id'] == 1): ?>
                                                    <a href="<?php echo admin_url('gestao_desenv_individual/aprovar_mentoria/' . $mentorias['id']); ?>"
                                                        class="btn btn-success" style="color: white;">
                                                        Aprovar
                                                    </a>
                                                    <a onclick="return confirm('Tens certeza que desejas rejeitar?');"
                                                        href="<?php echo admin_url('gestao_desenv_individual/mentoria_rejeitar/' . $mentorias['id']); ?>"
                                                        class="text-white btn btn-danger"
                                                        style="background-color:#FFA500; border-color:#FFA500; color:#fff;">
                                                        Rejeitar
                                                    </a>
                                                <?php endif ?>
                                                <a class="btn btn-success btn-icon" href="<?php echo admin_url('gestao_desenv_individual/visualizar_mentoria_one/'. $mentorias['id']) ?>">
                                                    <i style="color: white;" class="fa fa-eye"></i>
                                                </a>
                                                <a href="#" class="btn btn-default btn-edit-mentoria"
                                                    data-id="<?= $mentorias['id']; ?>" data-nome="<?= $mentorias['nome']; ?>"
                                                    data-descricao="<?= $mentorias['descricao']; ?>"
                                                    data-data_seccao="<?= $mentorias['data_seccao']; ?>"
                                                    data-feedback="<?= $mentorias['feedback']; ?>"
                                                    data-aprovadores="<?= implode(',', json_decode($mentorias['aprovadores'], true)); ?>"
                                                    data-staff_id="<?= $mentorias['staff_id']; ?>" data-toggle="modal"
                                                    data-target="#editar">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                <a onclick="return confirm('Tem certeza que deseja excluir?');"
                                                    href="<?= base_url('gestao_desenv_individual/delete_mentoria/' . $mentorias['id']); ?>"
                                                    class="btn btn-danger btn-icon _delete">
                                                    <i style="color: white;" class="fa fa-trash"></i>
                                                </a>

                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                
                                   <!--  <tr>
                                        <td colspan="10" class="text-center">Nenhuma mentoria encontrada.</td>
                                    </tr> -->
                                
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="clearfix"></div>
</div>
<?php echo form_close(); ?>
<div class="btn-bottom-pusher"></div>
</div>
</div>
<div id="new_version"></div>

<div class="modal" id="modal_add" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <?= form_open(admin_url('gestao_desenv_individual/add_mentoria'), array('method' => 'post')) ?>
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Nova Mentoria
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group" app-field-wrapper="destino">
                            <label for="destino" class="control-label">
                                Nome <small class="req text-danger">*</small>
                            </label>
                            <input type="text" id="nome" name="nome" class="form-control" value="">
                        </div>
                        <div class="form-group" app-field-wrapper="objetivo">
                            <label for="objetivo" class="control-label">
                                Descrição<small class="req text-danger">*</small>
                            </label>
                            <textarea name="descricao" class="form-control" style="min-height: 100px;"></textarea>
                        </div>
                        <div class="form-group" app-field-wrapper="destino">
                            <label for="data_seccao" class="control-label">
                                Data de Secção<small class="req text-danger">*</small>
                            </label>
                            <input type="date" id="data_seccao" name="data_seccao" class="form-control">
                        </div>

                        <div class="form-group">
                            <?php
                            $selectedStaff = '';
                            echo render_select('funcionário', $staff, ['staffid', ['firstname', 'lastname']], 'Mentor<span class="text-danger">*</span>', $selectedStaff, [], [], '', '', true);
                            ?>
                        </div>
                        <div class="form-group" app-field-wrapper="objetivo">
                            <label for="objetivo" class="control-label">
                                Feedback<small class="req text-danger">*</small>
                            </label>
                            <!--  <textarea name="feedback" class="form-control" style="min-height: 100px;"></textarea> -->
                            <input type="text" id="feedback" name="feedback" class="form-control">
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
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo _l('Cancelar'); ?></button>
                <button type="submit" class="btn btn-success"><?php echo _l('Salvar'); ?></button>
            </div>
        </div>
        <?= form_close() ?>
    </div>
</div>

<?= form_open(admin_url('gestao_desenv_individual/editar_mentoria'), array('method' => 'post', 'id' => 'form_edit_mentoria')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Editar Mentoria</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <input type="hidden" name="id" id="id" value="">

                        <div class="form-group" app-field-wrapper="destino">
                            <label for="destino" class="control-label">
                                Nome <small class="req text-danger">*</small>
                            </label>
                            <input type="text" id="nome" name="nome" class="form-control" value="">
                        </div>
                        <div class="form-group" app-field-wrapper="objetivo">
                            <label for="objetivo" class="control-label">
                                Descrição<small class="req text-danger">*</small>
                            </label>
                            <textarea name="descricao" class="form-control" style="min-height: 100px;"></textarea>
                        </div>
                        <div class="form-group" app-field-wrapper="destino">
                            <label for="data_fim" class="control-label">
                                Data de Secção<small class="req text-danger">*</small>
                            </label>
                            <input type="date" id="data_seccao" name="data_seccao" class="form-control">
                        </div>
                        <div class="form-group">
                            <?php
                            echo render_select(
                                'funcionario',
                                $staff,
                                ['staffid', ['firstname', 'lastname']],
                                'Mentor <span class="text-danger">*</span>',
                                '',
                                [],
                                [],
                                '',
                                '',
                                true
                            );
                            ?>
                        </div>
                        <div class="form-group" app-field-wrapper="objetivo">
                            <label for="objetivo" class="control-label">
                                Feedback<small class="req text-danger">*</small>
                            </label>
                            <!--  <textarea name="feedback" class="form-control" style="min-height: 100px;"></textarea> -->
                            <input type="text" id="feedback" name="feedback" class="form-control">
                        </div>
                        <div class="form-group">
                            <?php
                            echo render_select(
                                'aprovadores[]',
                                $staff_list,
                                ['staffid', ['firstname', 'lastname']],
                                'Aprovadores <span class="text-danger">*</span>',
                                '',
                                ['multiple' => true],
                                [],
                                '',
                                '',
                                false
                            );
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
<?= form_close() ?>
<?php init_tail(); ?>
<script>

    $(document).ready(function () {
        $(document).on('click', '.btn-edit-mentoria', function () {
            console.log("dsfdfdf");
            let id = $(this).data('id');
            let nome = $(this).data('nome');
            let descricao = $(this).data('descricao');
            let data_seccao = $(this).data('data_seccao');
            let feedback = $(this).data('feedback');
            let aprovadores = $(this).data('aprovadores') ? $(this).data('aprovadores').toString().split(',') : [];
            let funcionario = $(this).data('staff_id');

            $('#editar #id').val(id);
            $('#editar #nome').val(nome);
            $('#editar textarea[name="descricao"]').val(descricao);
            $('#editar #data_seccao').val(data_seccao);
            $('#editar #feedback').val(feedback);
            $('#editar select[name="aprovadores[]"]').val(aprovadores).trigger('change');
            $('#editar select[name="funcionario"]').val(funcionario).trigger('change');

        });
    });

    $(document).ready(function () {
        // Quando os filtros forem alterados
        $('#funcionario, #status').on('change', function () {
            atualizarTabela();
        });

        function atualizarTabela() {
            let funcionario = $('#funcionario').val();
            let status = $('#status').val();

            console.log(funcionario, status);

            $.ajax({
                url: '<?= base_url("gestao_desenv_individual/filtrar_mentoria"); ?>',
                type: 'POST',
                data: {
                    funcionario: funcionario,
                    status: status
                },
                success: function (response) {
                    $('table.dt-table tbody').html(response);
                },
                error: function (xhr, status, error) {
                    console.error("Erro na requisição AJAX:", error);
                }
            });

        }
    });

</script>