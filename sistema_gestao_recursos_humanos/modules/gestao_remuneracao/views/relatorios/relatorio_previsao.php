<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_remuneracao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Remuneração / Relatório / Relatório de Previsão
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
                                    Relatório de Previsão
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Novo Relatório
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
                                <th>Descrição</th>
                                <th>Impacto Financeiro</th>
                                <th>Data de Geração</th>
                                <th></th>
                            </thead>
                            <tbody>

                                <?php foreach ($relatorio_previsao as $relatorio_previsaos): ?>
                                    <tr>
                                        <td> <a href="#"><?= htmlspecialchars($relatorio_previsaos['descricao']); ?></a>
                                        </td>
                                        <td> <a
                                                href="#"><?= htmlspecialchars($relatorio_previsaos['impacto_financeiro']); ?></a>
                                        </td>
                                        <td> <a
                                                href="#"><?= date('d/m/Y', strtotime($relatorio_previsaos['data_geracao'])); ?></a>
                                        </td>
                                        <td>
                                            <a href="<?php echo admin_url('gestao_remuneracao/relatorios_visualizar_relatorio_previsao/'. $relatorio_previsaos['id']) ?>"
                                                class="btn btn-success btn-icon">
                                                <i style="color: white;" class="fa fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-default btn-edit-relatorio_previsao"
                                                data-id="<?= $relatorio_previsaos['id']; ?>"
                                                data-descricao="<?= $relatorio_previsaos['descricao']; ?>"
                                                data-impacto_financeiro="<?= $relatorio_previsaos['impacto_financeiro']; ?>"
                                                data-data_geracao="<?= $relatorio_previsaos['data_geracao']; ?>"
                                                data-toggle="modal" data-target="#editar">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a onclick="return confirm('Tem certeza que deseja excluir?');"
                                                href="<?= base_url('gestao_remuneracao/delete_relatorio_previsao/' . $relatorio_previsaos['id']); ?>"
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
        <?php echo form_open(admin_url('gestao_remuneracao/add_relatorio_previsao'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Novo Relatório</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="descricao"><small class="req text-danger">*</small> Descrição</label>
                    <input type="text" id="descricao" name="descricao" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="impacto_financeiro"><small class="req text-danger">*</small> Impacto Financeiro</label>
                    <input type="number" id="impacto_financeiro" name="impacto_financeiro" class="form-control" required
                        step="0.01">
                </div>
                <div class="form-group">
                    <label for="data_geracao"><small class="req text-danger">*</small> Data de Geração</label>
                    <input type="date" id="data_geracao" name="data_geracao" class="form-control" required>
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


<?= form_open(admin_url('gestao_remuneracao/editar_relatorio_previsao'), array('method' => 'post', 'id' => 'form_edit_subsidio_natal')) ?>
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
                            <input type="text" id="descricao" name="descricao" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="impacto_financeiro"><small class="req text-danger">*</small> Impacto
                                Financeiro</label>
                            <input type="number" id="impacto_financeiro" name="impacto_financeiro" class="form-control"
                                required step="0.01">
                        </div>
                        <div class="form-group">
                            <label for="data_geracao"><small class="req text-danger">*</small> Data de Geração</label>
                            <input type="date" id="data_geracao" name="data_geracao" class="form-control" required>
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
        $(document).on('click', '.btn-edit-relatorio_previsao', function () {
            let id = $(this).data('id');
            let descricao = $(this).data('descricao');
            let impacto_financeiro = $(this).data('impacto_financeiro');
            let data_geracao = $(this).data('data_geracao');

            $('#editar #id').val(id);
            $('#editar #descricao').val(descricao);
            $('#editar #impacto_financeiro').val(impacto_financeiro);
            $('#editar #data_geracao').val(data_geracao);

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