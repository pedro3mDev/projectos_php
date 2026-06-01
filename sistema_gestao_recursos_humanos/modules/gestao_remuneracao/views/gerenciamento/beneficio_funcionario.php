<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_remuneracao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Remuneração / Gerenciamento / Benefício do Funcionário
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
                                    Benefício do Funcionário
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Novo Benefício
                                </a>
                                <a href="<?php echo admin_url('gestao_remuneracao/gerenciamento') ?>" class="btn"
                                    style="background-color: #DAA520; border-color: #DAA520; color: white;">
                                    <i class="fa-regular "></i>
                                    Pacote de Benefício 
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
                                <th>Benefício</th>
                                <th>Data de Início</th>
                                <th>Data de Fim</th>
                                <th></th>
                            </thead>
                            <tbody>

                                <?php foreach ($beneficio_funcionario as $beneficio_funcionarios): ?>
                                    <tr>

                                        <td> <a
                                                href="#"><?= htmlspecialchars($beneficio_funcionarios['primeiro_nome'] . " " . $beneficio_funcionarios['segundo_nome']); ?></a>
                                        </td>
                                        <td> <a
                                                href="#"><?= htmlspecialchars($beneficio_funcionarios['elegibilidade']); ?></a>
                                        </td>
                                        <td> <a
                                                href="#"><?= date('d/m/Y', strtotime($beneficio_funcionarios['data_inicio'])); ?></a>
                                        </td>
                                        <td> <a
                                                href="#"><?= date('d/m/Y', strtotime($beneficio_funcionarios['data_fim'])); ?></a>
                                        </td>
                                        <td>
                                            <a href="<?php echo admin_url('gestao_remuneracao/gerenciamento_visualizar_beneficio_funcionario/'. $beneficio_funcionarios['id']) ?>"
                                                class="btn btn-success btn-icon">
                                                <i style="color: white;" class="fa fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-default btn-edit-beneficio_funcionario"
                                                data-id="<?= $beneficio_funcionarios['id']; ?>"
                                                data-data_inicio="<?= $beneficio_funcionarios['data_inicio']; ?>"
                                                data-data_fim="<?= $beneficio_funcionarios['data_fim']; ?>"
                                                data-beneficio_id="<?= $beneficio_funcionarios['beneficio_id']; ?>"
                                                data-staff_id="<?= $beneficio_funcionarios['staff_id']; ?>"
                                                data-toggle="modal" data-target="#editar">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a onclick="return confirm('Tem certeza que deseja excluir?');"
                                                href="<?= base_url('gestao_remuneracao/delete_beneficio_funcionario/' . $beneficio_funcionarios['id']); ?>"
                                                class="btn btn-danger btn-icon _delete">
                                                <i style="color: white;" class="fa fa-trash"></i>
                                            </a>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                               <!--  <tr>
                                    <td colspan="10" class="text-center">Nenhuma Beneficio Funciionario encontrada.</td>
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
        <?php echo form_open(admin_url('gestao_remuneracao/add_beneficio_funcionario'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Novo Benefício</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <?php
                    $selectedStaff = '';
                    echo render_select('funcionario', $staff, ['staffid', ['firstname', 'lastname']], 'Usuario<span class="text-danger">*</span>', $selectedStaff, [], [], '', '', true);
                    ?>
                </div>
                <div class="form-group">
                    <label for="beneficio_id"><small class="req text-danger">*</small> Benefício</label>
                    <select id="beneficio_id" name="beneficio_id" class="form-control" required>
                        <option value="">Selecione um benefício</option>
                        <?php
                        foreach ($pacote_beneficio as $value):
                            ?>
                            <option value="<?php echo $value['id'] ?>"><?php echo $value['elegibilidade'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="data_inicio"><small class="req text-danger">*</small> Data de Início</label>
                    <input type="date" id="data_inicio" name="data_inicio" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="data_fim"><small class="req text-danger">*</small> Data de Fim</label>
                    <input type="date" id="data_fim" name="data_fim" class="form-control" required>
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


<?= form_open(admin_url('gestao_remuneracao/editar_beneficio_funcionario'), array('method' => 'post', 'id' => 'form_edit_beneficio_funcionario')) ?>
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
                                'Usuario <span class="text-danger">*</span>',
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
                            <label for="beneficio_id"><small class="req text-danger">*</small> Benefício</label>
                            <select id="beneficio_id" name="beneficio_id" class="form-control" required>
                                <option value="">Selecione um benefício</option>
                                <?php
                                foreach ($pacote_beneficio as $value):
                                    ?>
                                    <option value="<?php echo $value['id'] ?>"><?php echo $value['elegibilidade'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="data_inicio"><small class="req text-danger">*</small> Data de Início</label>
                            <input type="date" id="data_inicio" name="data_inicio" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="data_fim"><small class="req text-danger">*</small> Data de Fim</label>
                            <input type="date" id="data_fim" name="data_fim" class="form-control" required>
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
        $(document).on('click', '.btn-edit-beneficio_funcionario', function () {
            let id = $(this).data('id');
            let data_inicio = $(this).data('data_inicio');
            let data_fim = $(this).data('data_fim');
            let beneficio_id = $(this).data('beneficio_id');
            let funcionario = $(this).data('staff_id');

            $('#editar #id').val(id);
            $('#editar #data_inicio').val(data_inicio);
            $('#editar #data_fim').val(data_fim);
            $('#editar select[name="beneficio_id"]').val(beneficio_id).trigger('change');
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