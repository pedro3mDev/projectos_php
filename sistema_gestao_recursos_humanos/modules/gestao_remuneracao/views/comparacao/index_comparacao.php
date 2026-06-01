<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_remuneracao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Remuneração / Comparação / Comparação Salarial
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
        <?php require 'modules/gestao_remuneracao/views/comparacao/cards.php'; ?>
        </br>

        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Comparação Salarial
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Nova Comparação
                                </a>
                                <a href="<?php echo admin_url('gestao_remuneracao/comparacao_relatorio_comparativo') ?>"
                                    class="btn" style="background-color: #DAA520; border-color: #DAA520; color: white;">
                                    <i class="fa-regular "></i>
                                    Relatório Comparativo
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
                                <th>Faixa Salarial min e max</th>
                                <th>Benchmark</th>
                                <th>Diferença Percentual</th>
                                <th></th>
                            </thead>
                            <tbody>

                                <?php foreach ($comparacao_salarial as $comparacao_salarials): ?>
                                    <tr>

                                        <td> <a
                                                href="#"><?= htmlspecialchars('salario min: ' . $comparacao_salarials['salario_min'] . ' salario max:' . $comparacao_salarials['salario_max']); ?></a>
                                        </td>
                                        <td> <a href="#"><?= htmlspecialchars($comparacao_salarials['setor']); ?></a>
                                        </td>
                                        <td> <a
                                                href="#"><?= htmlspecialchars($comparacao_salarials['diferenca_percentual']); ?></a>
                                        </td>
                                        <td>
                                            <a href="<?php echo admin_url('gestao_remuneracao/comparacao_visualizar_comparacao_salarial/'.$comparacao_salarials['id']) ?>"
                                                class="btn btn-success btn-icon">
                                                <i style="color: white;" class="fa fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-default btn-edit-comparacao_salarial"
                                                data-id="<?= $comparacao_salarials['id']; ?>"
                                                data-diferenca_percentual="<?= $comparacao_salarials['diferenca_percentual']; ?>"
                                                data-benchmark_salarial_id="<?= $comparacao_salarials['benchmark_salarial_id']; ?>"
                                                data-faixa_salarial_id="<?= $comparacao_salarials['faixa_salarial_id']; ?>"
                                                data-toggle="modal" data-target="#editar">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a onclick="return confirm('Tem certeza que deseja excluir?');"
                                                href="<?= base_url('gestao_remuneracao/delete_comparacao_salarial/' . $comparacao_salarials['id']); ?>"
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
        <?php echo form_open(admin_url('gestao_remuneracao/add_comparacao_salarial'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Nova Comparação</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="faixa_salarial_id"><small class="req text-danger">*</small> Faixa Salarial min e
                        max</label>
                    <select id="faixa_salarial_id" name="faixa_salarial_id" class="form-control" required>
                        <option value="">Selecione a faixa salarial</option>
                        <?php foreach ($faixa_salarial as $faixa) { ?>
                            <option value="<?php echo $faixa['id']; ?>">
                                <?php echo 'salario min: ' . $faixa['salario_min'] . ' salario max: ' . $faixa['salario_max']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="benchmark_salarial_id"><small class="req text-danger">*</small> Benchmark</label>
                    <select id="benchmark_salarial_id" name="benchmark_salarial_id" class="form-control" required>
                        <option value="">Selecione o benchmark</option>
                        <?php foreach ($benchmark_salarial as $benchmark) { ?>
                            <option value="<?php echo $benchmark['id']; ?>">
                                <?php echo $benchmark['setor']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="diferenca_percentual"><small class="req text-danger">*</small> Diferença
                        Percentual</label>
                    <input type="number" id="diferenca_percentual" name="diferenca_percentual" class="form-control"
                        step="0.01" required>
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

<?= form_open(admin_url('gestao_remuneracao/editar_comparacao_salarial'), array('method' => 'post', 'id' => 'form_edit_benchmark_salarial')) ?>
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
                            <label for="faixa_salarial_id"><small class="req text-danger">*</small> Faixa Salarial min e
                                max</label>
                            <select id="faixa_salarial_id" name="faixa_salarial_id" class="form-control" required>
                                <option value="">Selecione a faixa salarial</option>
                                <?php foreach ($faixa_salarial as $faixa) { ?>
                                    <option value="<?php echo $faixa['id']; ?>">
                                        <?php echo 'salario min: ' . $faixa['salario_min'] . ' salario max: ' . $faixa['salario_max']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="benchmark_salarial_id"><small class="req text-danger">*</small>
                                Benchmark</label>
                            <select id="benchmark_salarial_id" name="benchmark_salarial_id" class="form-control"
                                required>
                                <option value="">Selecione o benchmark</option>
                                <?php foreach ($benchmark_salarial as $benchmark) { ?>
                                    <option value="<?php echo $benchmark['id']; ?>">
                                        <?php echo $benchmark['setor']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="diferenca_percentual"><small class="req text-danger">*</small> Diferença
                                Percentual</label>
                            <input type="number" id="diferenca_percentual" name="diferenca_percentual"
                                class="form-control" step="0.01" required>
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
        $(document).on('click', '.btn-edit-comparacao_salarial', function () {
            let id = $(this).data('id');
            let diferenca_percentual = $(this).data('diferenca_percentual');
            let benchmark_salarial_id = $(this).data('benchmark_salarial_id');
            let faixa_salarial_id = $(this).data('faixa_salarial_id');

            $('#editar #id').val(id);
            $('#editar #diferenca_percentual').val(diferenca_percentual);
            $('#editar select[name="benchmark_salarial_id"]').val(benchmark_salarial_id).trigger('change');
            $('#editar select[name="faixa_salarial_id"]').val(faixa_salarial_id).trigger('change');

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