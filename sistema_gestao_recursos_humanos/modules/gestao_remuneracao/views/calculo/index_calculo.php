<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_remuneracao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Remuneração / Cálculo / Cálculo do salário
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
        <?php require 'modules/gestao_remuneracao/views/calculo/cards.php'; ?>
        </br>

        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Cálculo do salário
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Novo Cálculo
                                </a>
                                <a href="<?php echo admin_url('gestao_remuneracao/calculo_formula_calculo') ?>"
                                    class="btn" style="background-color: #DAA520; border-color: #DAA520; color: white;">
                                    <i class="fa-regular "></i>
                                    Fórmula do Cálculo
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
                                <th>Faixa Salarial Min</th>
                                <th>Faixa Salarial Max</th>
                                <th>Bônus</th>
                                <th>Descontos</th>
                                <th>Salário Final</th>
                                <th></th>
                            </thead>
                            <tbody>

                                <?php foreach ($calculo_salario as $calculo_salarios): ?>
                                    <tr>
                                        <td> <a
                                                href="#"><?= htmlspecialchars($calculo_salarios['primeiro_nome'] . " " . $calculo_salarios['segundo_nome']); ?></a>
                                        </td>
                                        <td> <a href="#"><?= htmlspecialchars($calculo_salarios['salario_min']); ?></a>
                                        </td>
                                        <td> <a href="#"><?= htmlspecialchars($calculo_salarios['salario_max']); ?></a>
                                        </td>
                                        <td> <a href="#"><?= htmlspecialchars($calculo_salarios['bonus']); ?></a>
                                        </td>
                                        <td> <a href="#"><?= htmlspecialchars($calculo_salarios['descontos']); ?></a>
                                        </td>
                                        <td> <a href="#"><?= htmlspecialchars($calculo_salarios['salario_final']); ?></a>
                                        </td>
                                        <td>
                                            <a href="<?php echo admin_url('gestao_remuneracao/calculo_visualizar_calculo_salario/'. $calculo_salarios['id']) ?>"
                                                class="btn btn-success btn-icon">
                                                <i style="color: white;" class="fa fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-default btn-edit-calculo_salario"
                                                data-id="<?= $calculo_salarios['id']; ?>"
                                                data-bonus="<?= $calculo_salarios['bonus']; ?>"
                                                data-descontos="<?= $calculo_salarios['descontos']; ?>"
                                                data-salario_final="<?= $calculo_salarios['salario_final']; ?>"
                                                data-funcionario="<?= $calculo_salarios['staff_id']; ?>"
                                                data-faixa_salarial_id="<?= $calculo_salarios['faixa_salarial_id']; ?>"
                                                data-toggle="modal" data-target="#editar">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a onclick="return confirm('Tem certeza que deseja excluir?');"
                                                href="<?= base_url('gestao_remuneracao/delete_calculo_salario/' . $calculo_salarios['id']); ?>"
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
        <?php echo form_open(admin_url('gestao_remuneracao/add_calculo_salario'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Novo Cálculo</h4>
            </div>
            <div class="modal-body">
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
                    <label for="faixa_salarial_id"><small class="req text-danger">*</small> Faixa
                        Salarial</label>
                    <select id="faixa_salarial_id" name="faixa_salarial_id" class="form-control" required>
                        <option value="">Selecione a faixa salarial</option>
                        <?php foreach ($faixa_salarial as $faixa): ?>
                            <option value="<?php echo $faixa['id'] ?>">
                                <?php echo 'salario min: ' . $faixa['salario_min'] . ' salario max: ' . $faixa['salario_max'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="bonus"><small class="req text-danger">*</small> Bônus</label>
                    <input type="number" id="bonus" name="bonus" class="form-control" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="descontos"><small class="req text-danger">*</small> Descontos</label>
                    <input type="number" id="descontos" name="descontos" class="form-control" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="salario_final"><small class="req text-danger">*</small> Salário Final</label>
                    <input type="number" id="salario_final" name="salario_final" class="form-control" step="0.01"
                        required>
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


<?= form_open(admin_url('gestao_remuneracao/editar_calculo_salario'), array('method' => 'post', 'id' => 'form_edit_calculo_salario')) ?>
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
                            <label for="faixa_salarial_id"><small class="req text-danger">*</small> Faixa
                                Salarial</label>
                            <select id="faixa_salarial_id" name="faixa_salarial_id" class="form-control" required>
                                <option value="">Selecione a faixa salarial</option>
                                <?php foreach ($faixa_salarial as $faixa): ?>
                                    <option value="<?php echo $faixa['id'] ?>">
                                        <?php echo 'salario min: ' . $faixa['salario_min'] . ' salario max: ' . $faixa['salario_max'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="bonus"><small class="req text-danger">*</small> Bônus</label>
                            <input type="number" id="bonus" name="bonus" class="form-control" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="descontos"><small class="req text-danger">*</small> Descontos</label>
                            <input type="number" id="descontos" name="descontos" class="form-control" step="0.01"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="salario_final"><small class="req text-danger">*</small> Salário Final</label>
                            <input type="number" id="salario_final" name="salario_final" class="form-control"
                                step="0.01" required>
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
        $(document).on('click', '.btn-edit-calculo_salario', function () {
            let id = $(this).data('id');
            let bonus = $(this).data('bonus');
            let descontos = $(this).data('descontos');
            let salario_final = $(this).data('salario_final');
            let faixa_salarial_id = $(this).data('faixa_salarial_id');
            let funcionario = $(this).data('funcionario');

            $('#editar #id').val(id);
            $('#editar #bonus').val(bonus);
            $('#editar #descontos').val(descontos);
            $('#editar #salario_final').val(salario_final);
            $('#editar select[name="faixa_salarial_id"]').val(faixa_salarial_id).trigger('change');
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