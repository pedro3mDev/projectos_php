<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_remuneracao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Remuneração / Relatório / Análise de Custo
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
                                    Análise de Custo
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Nova Análise
                                </a>
                                <a href="<?php echo admin_url('gestao_remuneracao/relatorios') ?>" class="btn"
                                    style="background-color: #FFD700; border-color: #FFD700; color: white;">
                                    <i class="fa-regular "></i>
                                    Relatório de Salário
                                </a>
                                <a href="<?php echo admin_url('gestao_remuneracao/relatorios_relatorio_equidade') ?>"
                                    class="btn" style="background-color: #db2777; border-color: #db2777; color: white;">
                                    <i class="fa-regular "></i>
                                    Relatório de Equidade Salarial
                                </a>
                                <a href="<?php echo admin_url('gestao_remuneracao/relatorios_relatorio_previsao') ?>"
                                    class="btn" style="background-color: #ea580c; border-color: #ea580c; color: white;">
                                    <i class="fa-regular "></i>
                                    Relatório de Previsão
                                </a>
                                <a href="<?php echo admin_url('gestao_remuneracao/relatorios_mapa_inss') ?>" class="btn"
                                    style="background-color: #57534e; border-color: #57534e; color: white;">
                                    <i class="fa-regular "></i>
                                    Mapa INSS
                                </a>
                                <a href="<?php echo admin_url('gestao_remuneracao/relatorios_mapa_irt') ?>" class="btn"
                                    style="background-color: #b91c1c; border-color: #b91c1c; color: white;">
                                    <i class="fa-regular "></i>
                                    Mapa IRT
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
                                <th>Departamento</th>
                                <th>Custo Total</th>
                                <th>Data de Referência</th>
                                <th></th>
                            </thead>
                            <tbody>

                                <?php foreach ($analise_custo as $analise_custos): ?>
                                    <tr>
                                        <td> <a href="#"><?= htmlspecialchars($analise_custos['departamento']); ?></a>
                                        </td>
                                        <td> <a href="#"><?= htmlspecialchars($analise_custos['custo_total']); ?></a>
                                        </td>
                                        <td> <a
                                                href="#"><?= date('d/m/Y', strtotime($analise_custos['data_referencia'])); ?></a>
                                        </td>
                                        <td>
                                            <a href="<?php echo admin_url('gestao_remuneracao/relatorios_visualizar_analise_custo/'. $analise_custos['id']) ?>"
                                                class="btn btn-success btn-icon">
                                                <i style="color: white;" class="fa fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-default btn-edit-analise_custo"
                                                data-id="<?= $analise_custos['id']; ?>"
                                                data-data_referencia="<?= $analise_custos['data_referencia']; ?>"
                                                data-custo_total="<?= $analise_custos['custo_total']; ?>"
                                                data-departamento_id="<?= $analise_custos['departamento_id']; ?>"
                                                data-toggle="modal" data-target="#editar">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a onclick="return confirm('Tem certeza que deseja excluir?');"
                                                href="<?= base_url('gestao_remuneracao/delete_analise_custo/' . $analise_custos['id']); ?>"
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
        <?php echo form_open(admin_url('gestao_remuneracao/add_analise_custo'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Nova Análise</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="departamento_id"><small class="req text-danger">*</small> Departamento</label>
                    <select id="departamento_id" name="departamento_id" class="form-control" required>
                        <option value="">Selecione um departamento</option>
                        <?php foreach ($departamentos as $departamento): ?>
                            <option value="<?php echo $departamento['departmentid']; ?>">
                                <?php echo $departamento['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="custo_total"><small class="req text-danger">*</small> Custo Total</label>
                    <input type="number" id="custo_total" name="custo_total" class="form-control" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="data_referencia"><small class="req text-danger">*</small> Data de Referência</label>
                    <input type="date" id="data_referencia" name="data_referencia" class="form-control" required>
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



<?= form_open(admin_url('gestao_remuneracao/editar_analise_custo'), array('method' => 'post', 'id' => 'form_edit_analise_custo')) ?>
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
                            <label for="departamento_id"><small class="req text-danger">*</small> Departamento</label>
                            <select id="departamento_id" name="departamento_id" class="form-control" required>
                                <option value="">Selecione um departamento</option>
                                <?php foreach ($departamentos as $departamento): ?>
                                    <option value="<?php echo $departamento['departmentid']; ?>">
                                        <?php echo $departamento['name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="custo_total"><small class="req text-danger">*</small> Custo Total</label>
                            <input type="number" id="custo_total" name="custo_total" class="form-control" step="0.01"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="data_referencia"><small class="req text-danger">*</small> Data de
                                Referência</label>
                            <input type="date" id="data_referencia" name="data_referencia" class="form-control"
                                required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger"
                        data-dismiss="modal"><?php echo _l('Cancelar'); ?></button>
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
            $(document).on('click', '.btn-edit-analise_custo', function () {
                let id = $(this).data('id');
                let data_referencia = $(this).data('data_referencia');
                let custo_total = $(this).data('custo_total');
                let departamento_id = $(this).data('departamento_id');

                $('#editar #id').val(id);
                $('#editar #data_referencia').val(data_referencia);
                $('#editar #custo_total').val(custo_total);
                $('#editar select[name="departamento_id"]').val(departamento_id).trigger('change');

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