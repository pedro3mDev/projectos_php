<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_remuneracao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Remuneração / Regulamentações / Regulação Fiscal
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
        <?php require 'modules/gestao_remuneracao/views/regulamentacoes/cards.php'; ?>
        </br>

        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Regulação Fiscal
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Nova Regulação
                                </a>
                                <a href="<?php echo admin_url('gestao_remuneracao/regulamentacoes_documento_auditoria') ?>"
                                    class="btn" style="background-color: #FFD700; border-color: #FFD700; color: white;">
                                    <i class="fa-regular "></i>
                                    Documento de Auditoria
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
                                <th>Descrição</th>
                                <th>Legislação Aplicável</th>
                                <th>Data de Atualização</th>
                                <th></th>
                            </thead>
                            <tbody>

                                <?php foreach ($regulacao_fiscal as $regulacao_fiscals): ?>
                                    <tr>
                                        <td> <a href="#"><?= htmlspecialchars($regulacao_fiscals['descricao']); ?></a>
                                        </td>
                                        <td> <a
                                                href="#"><?= htmlspecialchars($regulacao_fiscals['legislacao_aplicavel']); ?></a>
                                        </td>
                                        <td> <a
                                                href="#"><?= date('d/m/Y', strtotime($regulacao_fiscals['data_atualizacao'])); ?></a>
                                        </td>
                                        <td>
                                            <a href="<?php echo admin_url('gestao_remuneracao/regulamentacoes_visualizar_regulacao/'. $regulacao_fiscals['id']) ?>"
                                                class="btn btn-success btn-icon">
                                                <i style="color: white;" class="fa fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-default btn-edit-regulacao_fiscal"
                                                data-id="<?= $regulacao_fiscals['id']; ?>"
                                                data-descricao="<?= $regulacao_fiscals['descricao']; ?>"
                                                data-legislacao_aplicavel="<?= $regulacao_fiscals['legislacao_aplicavel']; ?>"
                                                data-data_atualizacao="<?= $regulacao_fiscals['data_atualizacao']; ?>"
                                                data-toggle="modal" data-target="#editar">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a onclick="return confirm('Tem certeza que deseja excluir?');"
                                                href="<?= base_url('gestao_remuneracao/delete_regulacao_fiscal/' . $regulacao_fiscals['id']); ?>"
                                                class="btn btn-danger btn-icon _delete">
                                                <i style="color: white;" class="fa fa-trash"></i>
                                            </a>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                <!--  <tr>
                                        <td colspan="10" class="text-center">Nenhum dado encontrado.</td>
                                    </tr> -->

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
        <?php echo form_open(admin_url('gestao_remuneracao/add_regulacao_fiscal'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Nova Regulação</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="descricao"><small class="req text-danger">*</small> Descrição</label>
                    <input type="text" id="descricao" name="descricao" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="legislacao_aplicavel"><small class="req text-danger">*</small> Legislação
                        Aplicável</label>
                    <input type="number" id="legislacao_aplicavel" name="legislacao_aplicavel" class="form-control"
                        required>
                </div>
                <div class="form-group">
                    <label for="data_atualizacao"><small class="req text-danger">*</small> Data de Atualização</label>
                    <input type="date" id="data_atualizacao" name="data_atualizacao" class="form-control" required>
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

<?php init_tail(); ?>

<?= form_open(admin_url('gestao_remuneracao/editar_regulacao_fiscal'), array('method' => 'post', 'id' => 'form_edit_regulacao_fiscal')) ?>
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
                            <label for="descricao"><small class="req text-danger">*</small> Descrição</label>
                            <input type="text" id="descricao" name="descricao" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="legislacao_aplicavel"><small class="req text-danger">*</small> Legislação
                                Aplicável</label>
                            <input type="number" id="legislacao_aplicavel" name="legislacao_aplicavel"
                                class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="data_atualizacao"><small class="req text-danger">*</small> Data de
                                Atualização</label>
                            <input type="date" id="data_atualizacao" name="data_atualizacao" class="form-control"
                                required>
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
</body>

</html>

<script>

    $(document).ready(function () {
        $(document).on('click', '.btn-edit-regulacao_fiscal', function () {
            let id = $(this).data('id');
            let descricao = $(this).data('descricao');
            let legislacao_aplicavel = $(this).data('legislacao_aplicavel');
            let data_atualizacao = $(this).data('data_atualizacao');

            $('#editar #id').val(id);
            $('#editar #descricao').val(descricao);
            $('#editar #legislacao_aplicavel').val(legislacao_aplicavel);
            $('#editar #data_atualizacao').val(data_atualizacao);

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