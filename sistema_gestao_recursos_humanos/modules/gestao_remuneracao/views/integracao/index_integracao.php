<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_remuneracao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Remuneração / Integração / Processamento de Pagamento
                </a>
            </div>
            <div class="col-md-2" style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
            </div>
        </div>
        </br>
        <?php require 'modules/gestao_remuneracao/views/integracao/cards.php'; ?>
        </br>

        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Processamento de Pagamento
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Novo Processamento
                                </a>
                                <a href="<?php echo admin_url('gestao_remuneracao/integracao_arquivo') ?>" class="btn"
                                    style="background-color: #DAA520; border-color: #DAA520; color: white;">
                                    <i class="fa-regular "></i>
                                    Arquivo de Pagamento
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
                                <th>Banco</th>
                                <th>Valor</th>
                                <th>Data de Pagamento</th>
                                <th>Aprovadores</th>
                                <th>Status</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php if (!empty($processamento_pagamento)): ?>
                                    <?php foreach ($processamento_pagamento as $processamento_pagamentos): ?>
                                        <tr>
                                            <td> <a  href="#"><?= htmlspecialchars($processamento_pagamentos['primeiro_nome'] . " " . $processamento_pagamentos['segundo_nome']); ?></a>
                                            </td>
                                            <td> <a  href="#"><?= htmlspecialchars($processamento_pagamentos['banco']); ?></a>
                                            </td>
                                            <td> <a href="#"><?= htmlspecialchars($processamento_pagamentos['valor']); ?></a>
                                            </td>
                                            <td> <a href="#"><?= date('d/m/Y', strtotime($processamento_pagamentos['data_pagamento'])); ?></a>
                                            </td>
                                            <td> <a href="#"><?= htmlspecialchars($processamento_pagamentos['aprovadores_nomes'] ?? 'Nenhum'); ?></a>
                                            </td>
                                            <td> <a href="#"><?= htmlspecialchars($processamento_pagamentos['status_nome']); ?></a>
                                            </td>
                                            <td>
                                                <?php if ($processamento_pagamentos['status_id'] == 1): ?>
                                                    <a href="<?php echo admin_url('gestao_remuneracao/aprovar_processamento_pagamento/' . $processamento_pagamentos['id']); ?>"
                                                        class="btn btn-success" style="color: white;">
                                                        Aprovar
                                                    </a>
                                                    <a onclick="return confirm('Tens certeza que desejas rejeitar?');"
                                                        href="<?php echo admin_url('gestao_remuneracao/rejeitar_processamento_pagamento/' . $processamento_pagamentos['id']); ?>"
                                                        class="text-white btn btn-danger"
                                                        style="background-color:#FFA500; border-color:#FFA500; color:#fff;">
                                                        Rejeitar
                                                    </a>
                                                <?php endif ?>
                                                <a href="<?php echo admin_url('gestao_remuneracao/integracao_arquivo_visualizar_processamento/' . $processamento_pagamentos['id'])?>" class="btn btn-success btn-icon">
                                                    <i style="color: white;" class="fa fa-eye"></i>
                                                </a>
                                                <a href="#" class="btn btn-default btn-edit-processamento_pagamento"
                                                    data-id="<?= $processamento_pagamentos['id']; ?>"
                                                    data-valor="<?= $processamento_pagamentos['valor']; ?>"
                                                    data-data_pagamento="<?= $processamento_pagamentos['data_pagamento']; ?>"
                                                    data-aprovadores="<?= implode(',', json_decode($processamento_pagamentos['aprovadores'], true)); ?>"
                                                    data-staff_id="<?= $processamento_pagamentos['staff_id']; ?>"
                                                    data-banco_id="<?= $processamento_pagamentos['banco_id']; ?>"
                                                    data-toggle="modal" data-target="#editar">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                <a onclick="return confirm('Tem certeza que deseja excluir?');"
                                                    href="<?= base_url('gestao_remuneracao/delete_processamento_pagamento/' . $processamento_pagamentos['id']); ?>"
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
        <?php echo form_open(admin_url('gestao_remuneracao/add_processamento_pagamento'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Novo Processamento</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <?php
                    $selectedStaff = '';
                    echo render_select('funcionario', $staff, ['staffid', ['firstname', 'lastname']], 'Usuarios<span class="text-danger">*</span>', $selectedStaff, [], [], '', '', true);
                    ?>
                </div>
                <div class="form-group">
                    <label for="banco_id"><small class="req text-danger">*</small> Banco</label>
                    <select id="banco_id" name="banco_id" class="form-control" required>
                        <option value="">Selecione um banco</option>
                        <?php foreach ($bancos as $banco): ?>
                            <option value="<?php echo $banco['id']; ?>"><?php echo $banco['nome']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="valor"><small class="req text-danger">*</small> Valor</label>
                    <input type="number" id="valor" name="valor" class="form-control" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="data_pagamento"><small class="req text-danger">*</small> Data de Pagamento</label>
                    <input type="date" id="data_pagamento" name="data_pagamento" class="form-control" required>
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


<?= form_open(admin_url('gestao_remuneracao/editar_processamento_pagamento'), array('method' => 'post', 'id' => 'form_edit_processamento_pagamento')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Editar Benchmark Salarial</h4>
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
                            $selectedStaff = '';
                            echo render_select('funcionario', $staff, ['staffid', ['firstname', 'lastname']], 'Usuarios<span class="text-danger">*</span>', $selectedStaff, [], [], '', '', true);
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="banco_id"><small class="req text-danger">*</small> Banco</label>
                            <select id="banco_id" name="banco_id" class="form-control" required>
                                <option value="">Selecione um banco</option>
                                <?php foreach ($bancos as $banco): ?>
                                    <option value="<?php echo $banco['id']; ?>"><?php echo $banco['nome']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="valor"><small class="req text-danger">*</small> Valor</label>
                            <input type="number" id="valor" name="valor" class="form-control" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="data_pagamento"><small class="req text-danger">*</small> Data de
                                Pagamento</label>
                            <input type="date" id="data_pagamento" name="data_pagamento" class="form-control" required>
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
    </div>
</div>
<?php init_tail(); ?>
</body>

</html>

<script>

    $(document).ready(function () {
        $(document).on('click', '.btn-edit-processamento_pagamento', function () {
            let id = $(this).data('id');
            let valor = $(this).data('valor');
            let data_pagamento = $(this).data('data_pagamento');
            let aprovadores = $(this).data('aprovadores') ? $(this).data('aprovadores').toString().split(',') : [];
            let banco_id = $(this).data('banco_id');
            let funcionario = $(this).data('staff_id');

            $('#editar #id').val(id);
            $('#editar #valor').val(valor);
            $('#editar #data_pagamento').val(data_pagamento);
            $('#editar select[name="aprovadores[]"]').val(aprovadores).trigger('change');
            $('#editar select[name="banco_id"]').val(banco_id).trigger('change');
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