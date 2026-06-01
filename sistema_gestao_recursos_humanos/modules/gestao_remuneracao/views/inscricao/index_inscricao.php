<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_remuneracao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Remuneração / Inscrição / Solicitação de Benefício
                </a>
            </div>
            <div class="col-md-2" style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
            </div>
        </div>
        <!-- Comece Aqui! -->
        </br>
        <?php require 'modules/gestao_remuneracao/views/inscricao/cards.php'; ?>
        </br>

        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Solicitação de Benefício
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Nova Solicitação
                                </a>
                                <a href="<?php echo admin_url('gestao_remuneracao/inscricao_alteracao_beneficio') ?>"
                                    class="btn" style="background-color: #DAA520; border-color: #DAA520; color: white;">
                                    <i class="fa-regular "></i>
                                    Alteração de Benefício
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
                                <th>Usuário</th>
                                <th>Benefício</th>
                                <th>Data de Solicitação</th>
                                <th>Status</th>
                                <th>Aprovadores</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php if (!empty($solicitacao_beneficio)): ?>
                                    <?php foreach ($solicitacao_beneficio as $solicitacao_beneficios): ?>
                                        <tr>
                                            <td> <a
                                                    href="#"><?= htmlspecialchars($solicitacao_beneficios['primeiro_nome'] . " " . $solicitacao_beneficios['segundo_nome']); ?></a>
                                            </td>
                                            <td> <a
                                                    href="#"><?= htmlspecialchars($solicitacao_beneficios['elegibilidade']); ?></a>
                                            </td>
                                            <td> <a
                                                    href="#"><?= date('d/m/Y', strtotime($solicitacao_beneficios['data_solicitacao'])); ?></a>
                                            </td>
                                            <td> <a
                                                    href="#"><?= htmlspecialchars($solicitacao_beneficios['status_nome']); ?></a>
                                            </td>
                                            <td> <a
                                                    href="#"><?= htmlspecialchars($solicitacao_beneficios['aprovadores_nomes'] ?? 'Nenhum'); ?></a>
                                            </td>
                                            <td>
                                                <?php if ($solicitacao_beneficios['status_id'] == 1): ?>
                                                    <a href="<?php echo admin_url('gestao_remuneracao/aprovar_solicitacao_beneficio/' . $solicitacao_beneficios['id']); ?>"
                                                        class="btn btn-success" style="color: white;">
                                                        Aprovar
                                                    </a>
                                                    <a onclick="return confirm('Tens certeza que desejas rejeitar?');"
                                                        href="<?php echo admin_url('gestao_remuneracao/rejeitar_solicitacao_beneficio/' . $solicitacao_beneficios['id']); ?>"
                                                        class="text-white btn btn-danger"
                                                        style="background-color:#FFA500; border-color:#FFA500; color:#fff;">
                                                        Rejeitar
                                                    </a>
                                                <?php endif ?>
                                                <a href="<?php echo admin_url('gestao_remuneracao/inscricao_visualizar_solicitacao/'. $solicitacao_beneficios['id'])?>" class="btn btn-success btn-icon">
                                                    <i style="color: white;" class="fa fa-eye"></i>
                                                </a>
                                                <a href="#" class="btn btn-default btn-edit-solicitaca_beneficio"
                                                    data-id="<?= $solicitacao_beneficios['id']; ?>"
                                                    data-data_solicitacao="<?= $solicitacao_beneficios['data_solicitacao']; ?>"
                                                    data-aprovadores="<?= implode(',', json_decode($solicitacao_beneficios['aprovadores'], true)); ?>"
                                                    data-beneficio_id="<?= $solicitacao_beneficios['beneficio_id']; ?>"
                                                    data-staff_id="<?= $solicitacao_beneficios['staff_id']; ?>"
                                                    data-toggle="modal" data-target="#editar">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                <a onclick="return confirm('Tem certeza que deseja excluir?');"
                                                    href="<?= base_url('gestao_remuneracao/delete_solicitacao_beneficio/' . $solicitacao_beneficios['id']); ?>"
                                                    class="btn btn-danger btn-icon _delete">
                                                    <i style="color: white;" class="fa fa-trash"></i>
                                                </a>

                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="10" class="text-center">Nenhuma mentoria encontrada.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="btn-bottom-pusher"></div>
</div>
</div>
<div id="new_version"></div>

<div class="modal" id="modal_add" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <?php echo form_open(admin_url('gestao_remuneracao/add_solicitacao_beneficio'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Nova Solicitação</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <?php
                    $selectedStaff = '';
                    echo render_select('funcionario', $staff, ['staffid', ['firstname', 'lastname']], 'Mentor<span class="text-danger">*</span>', $selectedStaff, [], [], '', '', true);
                    ?>
                </div>
                <div class="form-group">
                    <label for="beneficio_id"><small class="req text-danger">*</small> Benefício</label>
                    <select id="beneficio_id" name="beneficio_id" class="form-control" required>
                        <option value="">Selecione um benefício</option>
                        <?php foreach ($pacote_beneficio as $valor): ?>
                            <option value="<?php echo $valor['id'] ?>"><?php echo $valor['elegibilidade'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="data_solicitacao"><small class="req text-danger">*</small> Data de Solicitação</label>
                    <input type="date" id="data_solicitacao" name="data_solicitacao" class="form-control" required>
                </div>
                <div class="form-group">
                    <?php
                    $selectedStaff = '';
                    echo render_select('aprovadores[]', $staff_list, ['staffid', ['firstname', 'lastname']], 'Aprovadores<span class="text-danger">*</span>', $selectedStaff, ['multiple' => true], [], '', '', false);
                    ?>
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

<?= form_open(admin_url('gestao_remuneracao/editar_solicitacao_beneficio'), array('method' => 'post', 'id' => 'form_edit_solicitacao_beneficio')) ?>
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
                        <div class="form-group">
                            <label for="beneficio_id"><small class="req text-danger">*</small> Benefício</label>
                            <select id="beneficio_id" name="beneficio_id" class="form-control" required>
                                <option value="">Selecione um benefício</option>
                                <?php foreach ($pacote_beneficio as $valor): ?>
                                    <option value="<?php echo $valor['id'] ?>"><?php echo $valor['elegibilidade'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="data_solicitacao"><small class="req text-danger">*</small> Data de
                                Solicitação</label>
                            <input type="date" id="data_solicitacao" name="data_solicitacao" class="form-control"
                                required>
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
<?php init_tail(); ?>
</body>

</html>
<script>

    $(document).ready(function () {
        $(document).on('click', '.btn-edit-solicitaca_beneficio', function () {
            console.log("dsfdfdf");
            let id = $(this).data('id');
            let data_solicitacao = $(this).data('data_solicitacao');
            let aprovadores = $(this).data('aprovadores') ? $(this).data('aprovadores').toString().split(',') : [];
            let beneficio_id = $(this).data('beneficio_id');
            let funcionario = $(this).data('staff_id');

            $('#editar #id').val(id);
            $('#editar #data_solicitacao').val(data_solicitacao);
            $('#editar select[name="aprovadores[]"]').val(aprovadores).trigger('change');
            $('#editar select[name="beneficio_id"]').val(beneficio_id).trigger('change');
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