<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_remuneracao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Remuneração / Processamentos / Vencimento do Funcionário
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
        <?php require 'modules/gestao_remuneracao/views/processamentos/cards.php'; ?>
        </br>

        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Vencimento do funcionário
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Novo Vencimento
                                </a>
                                <a href="<?php echo admin_url('gestao_remuneracao/processamentos_subsidio_ferias') ?>"
                                    class="btn" style="background-color: #86198f; border-color: #86198f; color: white;">
                                    <i class="fa-regular "></i>
                                    Subsídio de Férias
                                </a>
                                <a href="<?php echo admin_url('gestao_remuneracao/processamentos_subsidio_natal') ?>"
                                    class="btn" style="background-color: #991b1b; border-color: #991b1b; color: white;">
                                    <i class="fa-regular "></i>
                                    Subsídio de Natal
                                </a>
                                <a href="<?php echo admin_url('gestao_remuneracao/processamentos_rescisao_contrato') ?>"
                                    class="btn" style="background-color: #27272a; border-color: #27272a; color: white;">
                                    <i class="fa-regular "></i>
                                    Rescisão de Contrato
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
                                <th>Salário Base</th>
                                <th>Bônus</th>
                                <th>Benefícios</th>
                                <th>Salário Líquido</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach ($vencimento_funcionario as $vencimento_funcionarios): ?>
                                    <tr>
                                        <td> <a
                                                href="#"><?= htmlspecialchars($vencimento_funcionarios['primeiro_nome'] . " " . $vencimento_funcionarios['segundo_nome']); ?></a>
                                        </td>
                                        <td> <a
                                                href="#"><?= htmlspecialchars($vencimento_funcionarios['salario_base']); ?></a>
                                        </td>
                                        <td> <a href="#"><?= htmlspecialchars($vencimento_funcionarios['bonus']); ?></a>
                                        </td>
                                        <td> <a
                                                href="#"><?= htmlspecialchars($vencimento_funcionarios['beneficios']); ?></a>
                                        </td>
                                        <td> <a
                                                href="#"><?= htmlspecialchars($vencimento_funcionarios['salario_liquido']); ?></a>
                                        </td>
                                        <td>
                                            <a href="<?php echo admin_url('gestao_remuneracao/processamentos_visualizar_vencimento/'. $vencimento_funcionarios['id']) ?>"
                                                class="btn btn-success btn-icon">
                                                <i style="color: white;" class="fa fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-default btn-edit-vencimento_funcionario"
                                                data-id="<?= $vencimento_funcionarios['id']; ?>"
                                                data-salario_base="<?= $vencimento_funcionarios['salario_base']; ?>"
                                                data-bonus="<?= $vencimento_funcionarios['bonus']; ?>"
                                                data-salario_liquido="<?= $vencimento_funcionarios['salario_liquido']; ?>"
                                                data-beneficios="<?= $vencimento_funcionarios['beneficios']; ?>"
                                                data-staff_id="<?= $vencimento_funcionarios['staff_id']; ?>"
                                                data-toggle="modal" data-target="#editar">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a onclick="return confirm('Tem certeza que deseja excluir?');"
                                                href="<?= base_url('gestao_remuneracao/delete_vencimento_funcionario/' . $vencimento_funcionarios['id']); ?>"
                                                class="btn btn-danger btn-icon _delete">
                                                <i style="color: white;" class="fa fa-trash"></i>
                                            </a>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                <!-- <tr>
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
        <?php echo form_open(admin_url('gestao_remuneracao/add_vencimento_funcionario'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Novo Vencimento</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <?php
                    $selectedStaff = '';
                    echo render_select('funcionario', $staff, ['staffid', ['firstname', 'lastname']], 'Usuarios<span class="text-danger">*</span>', $selectedStaff, [], [], '', '', true);
                    ?>
                </div>
                <div class="form-group">
                    <label for="salario_base"><small class="req text-danger">*</small> Salário Base</label>
                    <input type="number" id="salario_base" name="salario_base" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="bonus"><small class="req text-danger">*</small> Bônus</label>
                    <input type="number" id="bonus" name="bonus" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="beneficios"><small class="req text-danger">*</small> Benefícios</label>
                    <input type="number" id="beneficios" name="beneficios" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="salario_liquido"><small class="req text-danger">*</small> Salário Líquido</label>
                    <input type="number" id="salario_liquido" name="salario_liquido" class="form-control" required>
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



<?= form_open(admin_url('gestao_remuneracao/editar_vencimento_funcionario'), array('method' => 'post', 'id' => 'form_edit_vencimento_funcionario')) ?>
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
                            $selectedStaff = '';
                            echo render_select('funcionario', $staff, ['staffid', ['firstname', 'lastname']], 'Usuarios<span class="text-danger">*</span>', $selectedStaff, [], [], '', '', true);
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="salario_base"><small class="req text-danger">*</small> Salário Base</label>
                            <input type="number" id="salario_base" name="salario_base" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="bonus"><small class="req text-danger">*</small> Bônus</label>
                            <input type="number" id="bonus" name="bonus" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="beneficios"><small class="req text-danger">*</small> Benefícios</label>
                            <input type="number" id="beneficios" name="beneficios" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="salario_liquido"><small class="req text-danger">*</small> Salário
                                Líquido</label>
                            <input type="number" id="salario_liquido" name="salario_liquido" class="form-control"
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
        $(document).on('click', '.btn-edit-vencimento_funcionario', function () {
            let id = $(this).data('id');
            let salario_base = $(this).data('salario_base');
            let bonus = $(this).data('bonus');
            let beneficios = $(this).data('beneficios');
            let salario_liquido = $(this).data('salario_liquido');
            let funcionario = $(this).data('staff_id');

            $('#editar #id').val(id);
            $('#editar #salario_base').val(salario_base);
            $('#editar #bonus').val(bonus);
            $('#editar #beneficios').val(beneficios);
            $('#editar #salario_liquido').val(salario_liquido);
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