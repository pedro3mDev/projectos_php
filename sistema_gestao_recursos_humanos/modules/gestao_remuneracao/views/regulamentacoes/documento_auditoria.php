<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_remuneracao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Remuneração / Regulamentações / Documento de Auditoria
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

        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Documento de Auditoria
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Novo Documento
                                </a>
                                <a href="<?php echo admin_url('gestao_remuneracao/regulamentacoes') ?>" class="btn"
                                    style="background-color: #FFD700; border-color: #FFD700; color: white;">
                                    <i class="fa-regular "></i>
                                    Regulação Fiscal
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
                                <th>Tipo de Documento</th>
                                <th>Data de Geração</th>
                                <th>Status</th>
                                <th>Aprovadores</th>
                                <th></th>
                            </thead>
                            <tbody>

                                <?php foreach ($documento_auditoria as $documento_auditorias): ?>
                                    <tr>
                                        <td> <a
                                                href="#"><?= htmlspecialchars($documento_auditorias['tipo_documento']); ?></a>
                                        </td>
                                        <td> <a
                                                href="#"><?= date('d/m/Y', strtotime($documento_auditorias['data_geracao'])); ?></a>
                                        </td>
                                        <td> <a href="#"><?= htmlspecialchars($documento_auditorias['status_nome']); ?></a>
                                        </td>
                                        <td> <a
                                                href="#"><?= htmlspecialchars($documento_auditorias['aprovadores_nomes']); ?></a>
                                        </td>
                                        <td>
                                            <?php if ($documento_auditorias['status_id'] == 1): ?>
                                                <a href="<?php echo admin_url('gestao_remuneracao/aprovar_documento_auditoria/' . $documento_auditorias['id']); ?>"
                                                    class="btn btn-success" style="color: white;">
                                                    Aprovar
                                                </a>
                                                <a onclick="return confirm('Tens certeza que desejas rejeitar?');"
                                                    href="<?php echo admin_url('gestao_remuneracao/rejeitar_documento_auditoria/' . $documento_auditorias['id']); ?>"
                                                    class="text-white btn btn-danger"
                                                    style="background-color:#FFA500; border-color:#FFA500; color:#fff;">
                                                    Rejeitar
                                                </a>
                                            <?php endif ?>
                                            <a href="<?php echo admin_url('gestao_remuneracao/regulamentacoes_visualizar_ducumento/'. $documento_auditorias['id']) ?>"
                                                class="btn btn-success btn-icon">
                                                <i style="color: white;" class="fa fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-default btn-edit-documento_auditoria"
                                                data-id="<?= $documento_auditorias['id']; ?>"
                                                data-tipo_documento="<?= $documento_auditorias['tipo_documento']; ?>"
                                                data-data_geracao="<?= $documento_auditorias['data_geracao']; ?>"
                                                data-aprovadores="<?= implode(',', json_decode($documento_auditorias['aprovadores'], true)); ?>"
                                                data-toggle="modal" data-target="#editar">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a onclick="return confirm('Tem certeza que deseja excluir?');"
                                                href="<?= base_url('gestao_remuneracao/delete_documento_auditoria/' . $documento_auditorias['id']); ?>"
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
        <div class="clearfix"></div>
    </div>
</div>
<div class="btn-bottom-pusher"></div>
</div>
</div>
<div id="new_version"></div>

<div class="modal" id="modal_add" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <?php echo form_open(admin_url('gestao_remuneracao/add_documento_auditoria'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Novo Documento</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="tipo_documento"><small class="req text-danger">*</small> Tipo de Documento</label>
                    <input type="text" id="tipo_documento" name="tipo_documento" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="data_geracao"><small class="req text-danger">*</small> Data de Geração</label>
                    <input type="date" id="data_geracao" name="data_geracao" class="form-control" required>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success">Salvar</button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>



<?= form_open(admin_url('gestao_remuneracao/editar_documento_auditoria'), array('method' => 'post', 'id' => 'form_edit_ajuste_salarial')) ?>
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
                            <label for="tipo_documento"><small class="req text-danger">*</small> Tipo de
                                Documento</label>
                            <input type="text" id="tipo_documento" name="tipo_documento" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="data_geracao"><small class="req text-danger">*</small> Data de Geração</label>
                            <input type="date" id="data_geracao" name="data_geracao" class="form-control" required>
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
        $(document).on('click', '.btn-edit-documento_auditoria', function () {
            let id = $(this).data('id');
            let tipo_documento = $(this).data('tipo_documento');
            let data_geracao = $(this).data('data_geracao');
            let aprovadores = $(this).data('aprovadores') ? $(this).data('aprovadores').toString().split(',') : [];

            $('#editar #id').val(id);
            $('#editar #tipo_documento').val(tipo_documento);
            $('#editar #data_geracao').val(data_geracao);
            $('#editar select[name="aprovadores[]"]').val(aprovadores).trigger('change');

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