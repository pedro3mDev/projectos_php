<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_remuneracao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Remuneração / Definição e Actualização / Faixa
                    Salarial
                </a>
            </div>
            <div class="col-md-2" style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
            </div>
        </div>

        </br>
        <?php require 'modules/gestao_remuneracao/views/definicao_actualizacao/cards.php'; ?>
        </br>

        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Faixa Salarial
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Nova Faixa
                                </a>
                                <a href="<?php echo admin_url('gestao_remuneracao/definicao_benchmark_salarial') ?>"
                                    class="btn" style="background-color: #DAA520; border-color: #DAA520; color: white;">
                                    <i class="fa-regular "></i>
                                    Benchmark Salarial
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
                                <th>Cargo</th>
                                <th>Tipo de Categoria</th>
                                <th>Salário Mínimo</th>
                                <th>Salário Máximo</th>
                                <th>Data de Atualização</th>
                                <th></th>
                            </thead>
                            <tbody>

                                <?php foreach ($faixa_salarial as $faixa_salarials): ?>
                                    <tr>

                                        <td> <a href="#"><?= htmlspecialchars($faixa_salarials['position_name']); ?></a>
                                        </td>
                                        <td> <a href="#"><?= htmlspecialchars($faixa_salarials['categoria_nome']); ?></a>
                                        </td>
                                        <td> <a href="#"><?= htmlspecialchars($faixa_salarials['salario_min']); ?></a>
                                        </td>
                                        <td> <a href="#"><?= htmlspecialchars($faixa_salarials['salario_max']); ?></a>
                                        </td>
                                        <td> <a href="#"><?= date('d/m/Y', strtotime($faixa_salarials['data_atualizacao'])); ?></a>
                                        </td>
                                        <td>
                                            <a href="<?php echo admin_url('gestao_remuneracao/definicao_visualizar_faixa/'. $faixa_salarials['id']) ?>"
                                                class="btn btn-success btn-icon">
                                                <i style="color: white;" class="fa fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-default btn-edit-faixa_salarial"
                                                data-id="<?= $faixa_salarials['id']; ?>"
                                                data-salario_max="<?= $faixa_salarials['salario_max']; ?>"
                                                data-salario_min="<?= $faixa_salarials['salario_min']; ?>"
                                                data-data_atualizacao="<?= $faixa_salarials['data_atualizacao']; ?>"
                                                data-tipo_categoria_id="<?= $faixa_salarials['tipo_categoria_id']; ?>"
                                                data-cargo_id="<?= $faixa_salarials['cargo_id']; ?>" data-toggle="modal"
                                                data-target="#editar">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a onclick="return confirm('Tem certeza que deseja excluir?');"
                                                href="<?= base_url('gestao_remuneracao/delete_faixa_salarial/' . $faixa_salarials['id']); ?>"
                                                class="btn btn-danger btn-icon _delete">
                                                <i style="color: white;" class="fa fa-trash"></i>
                                            </a>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                <!-- <tr>
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
        <?php echo form_open(admin_url('gestao_remuneracao/add_faixa_salarial'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Nova Faixa</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="cargo_id"><small class="req text-danger">*</small> Cargo</label>
                    <select id="cargo_id" name="cargo_id" class="form-control" required>
                        <option value="">Selecione o cargo</option>
                        <?php foreach ($cargos as $cargo) { ?>
                            <option value="<?php echo $cargo['position_id']; ?>">
                                <?php echo $cargo['position_name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tipo_categoria_id"><small class="req text-danger">*</small> Tipo Categoria</label>
                    <select id="tipo_categoria_id" name="tipo_categoria_id" class="form-control" required>
                        <option value="">Selecione o cargo</option>
                        <?php foreach ($tipo_categorias as $categoria) { ?>
                            <option value="<?php echo $categoria['id']; ?>">
                                <?php echo $categoria['nome']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="salario_min"><small class="req text-danger">*</small> Salário
                        Mínimo</label>
                    <input type="number" id="salario_min" name="salario_min" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="salario_max"><small class="req text-danger">*</small> Salário
                        Máximo</label>
                    <input type="number" id="salario_max" name="salario_max" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="data_atualizacao"><small class="req text-danger">*</small> Data de
                        Atualização</label>
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


<?= form_open(admin_url('gestao_remuneracao/editar_faixa_salarial'), array('method' => 'post', 'id' => 'form_edit_faixa_salarial')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Editar Faixa Salarial</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <input type="hidden" name="id" id="id" value="">

                        <div class="form-group">
                            <label for="cargo_id"><small class="req text-danger">*</small> Cargo</label>
                            <select id="cargo_id" name="cargo_id" class="form-control" required>
                                <option value="">Selecione o cargo</option>
                                <?php foreach ($cargos as $cargo) { ?>
                                    <option value="<?php echo $cargo['position_id']; ?>">
                                        <?php echo $cargo['position_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tipo_categoria_id"><small class="req text-danger">*</small> Tipo
                                Categoria</label>
                            <select id="tipo_categoria_id" name="tipo_categoria_id" class="form-control" required>
                                <option value="">Selecione o tipo categoria</option>
                                <?php foreach ($tipo_categorias as $categoria) { ?>
                                    <option value="<?php echo $categoria['id']; ?>">
                                        <?php echo $categoria['nome']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="salario_min"><small class="req text-danger">*</small> Salário
                                Mínimo</label>
                            <input type="number" id="salario_min" name="salario_min" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="salario_max"><small class="req text-danger">*</small> Salário
                                Máximo</label>
                            <input type="number" id="salario_max" name="salario_max" class="form-control" required>
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
<?php init_tail(); ?>
</body>

</html>

<script>

    $(document).ready(function () {
        $(document).on('click', '.btn-edit-faixa_salarial', function () {
            let id = $(this).data('id');
            let setor = $(this).data('setor');
            let salario_min = $(this).data('salario_min');
            let salario_max = $(this).data('salario_max');
            let data_atualizacao = $(this).data('data_atualizacao');
            let cargo_id = $(this).data('cargo_id');
            let tipo_categoria_id = $(this).data('tipo_categoria_id');

            $('#editar #id').val(id);
            $('#editar #salario_min').val(salario_min);
            $('#editar #salario_max').val(salario_max);
            $('#editar #data_atualizacao').val(data_atualizacao);
            $('#editar select[name="tipo_categoria_id"]').val(tipo_categoria_id).trigger('change');
            $('#editar select[name="cargo_id"]').val(cargo_id).trigger('change');

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