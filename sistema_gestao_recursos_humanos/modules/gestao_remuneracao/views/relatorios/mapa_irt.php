<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_remuneracao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Remuneração / Relatório / Mapa IRT
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
                                    Mapa IRT
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Novo Mapa
                                </a>
                                <a href="<?php echo admin_url('gestao_remuneracao/relatorios') ?>" class="btn"
                                    style="background-color: #DAA520; border-color: #DAA520; color: white;">
                                    <i class="fa-regular "></i>
                                    Relatório de Salário
                                </a>
                                <a href="<?php echo admin_url('gestao_remuneracao/relatorios_analise_custo') ?>"
                                    class="btn" style="background-color: #16a34a; border-color: #16a34a; color: white;">
                                    <i class="fa-regular "></i>
                                    Análise de Custo
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
                                <th>Data de Envio</th>
                                <th></th>
                            </thead>
                            <tbody>

                                <?php foreach ($mapa_irt as $mapa_irts): ?>
                                    <tr>
                                        <td> <a href="#"><?= htmlspecialchars($mapa_irts['descricao']); ?></a>
                                        </td>
                                        <td> <a href="#"><?= date('d/m/Y', strtotime($mapa_irts['data_envio'])); ?></a>
                                        </td>
                                        <td>
                                            <a href="<?php echo admin_url('gestao_remuneracao/relatorios_visualizar_mapa_irt/'. $mapa_irts['id']) ?>"
                                                class="btn btn-success btn-icon">
                                                <i style="color: white;" class="fa fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-default btn-edit-mapa_irt"
                                                data-id="<?= $mapa_irts['id']; ?>"
                                                data-descricao="<?= $mapa_irts['descricao']; ?>"
                                                data-data_envio="<?= $mapa_irts['data_envio']; ?>" data-toggle="modal"
                                                data-target="#editar">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a onclick="return confirm('Tem certeza que deseja excluir?');"
                                                href="<?= base_url('gestao_remuneracao/delete_mapa_irt/' . $mapa_irts['id']); ?>"
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
        <?php echo form_open(admin_url('gestao_remuneracao/add_mapa_irt'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Novo Mapa</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="descricao"><small class="req text-danger">*</small> Descrição</label>
                    <textarea id="descricao" name="descricao" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="data_envio"><small class="req text-danger">*</small> Data de Envio</label>
                    <input type="date" id="data_envio" name="data_envio" class="form-control" required>
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

<?= form_open(admin_url('gestao_remuneracao/editar_mapa_irt'), array('method' => 'post', 'id' => 'form_edit_mapa_irt')) ?>
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
                            <label for="descricao"><small class="req text-danger">*</small> Descrição</label>
                            <textarea id="descricao" name="descricao" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="data_envio"><small class="req text-danger">*</small> Data de Envio</label>
                            <input type="date" id="data_envio" name="data_envio" class="form-control" required>
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
        $(document).on('click', '.btn-edit-mapa_irt', function () {
            let id = $(this).data('id');
            let descricao = $(this).data('descricao');
            let data_envio = $(this).data('data_envio');

            $('#editar #id').val(id);
            $('#editar #descricao').val(descricao);
            $('#editar #data_envio').val(data_envio);

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