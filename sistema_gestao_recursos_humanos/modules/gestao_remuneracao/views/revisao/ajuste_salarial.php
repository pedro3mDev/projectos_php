<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_remuneracao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Remuneração / Revisão / Ajuste Salarial
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
                                    Ajuste Salarial
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Novo Ajuste
                                </a>
                                <a href="<?php echo admin_url('gestao_remuneracao/revisao') ?>" class="btn"
                                    style="background-color: #DAA520; border-color: #DAA520; color: white;">
                                    <i class="fa-regular "></i>
                                    Ciclo de Revisão Salarial
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
                                <th>Percentual de Aumento</th>
                                <th>Motivo</th>
                                <th>Status</th>
                                <th>Aprovadores</th>
                                <th></th>
                            </thead>
                            <tbody>

                                <?php foreach ($ajuste_salarial as $ajuste_salarials): ?>
                                    <tr>
                                        <td> <a href="#"><?= htmlspecialchars($ajuste_salarials['primeiro_nome'] . " " . $ajuste_salarials['segundo_nome']); ?></a>
                                        </td>
                                        <td> <a href="#"><?= htmlspecialchars($ajuste_salarials['percentual_aumento']); ?></a>
                                        </td>
                                        <td> <a href="#"><?= htmlspecialchars($ajuste_salarials['motivo']); ?></a> </td>
                                        <td> <a href="#"><?= htmlspecialchars($ajuste_salarials['status_nome']); ?></a>
                                        </td>
                                        <td> <a href="#"><?= htmlspecialchars($ajuste_salarials['aprovadores_nomes'] ?? 'Nenhum'); ?></a>
                                        </td>
                                        <td>
                                            <?php if ($ajuste_salarials['status_id'] == 1): ?>
                                                <a href="<?php echo admin_url('gestao_remuneracao/aprovar_ajuste_salarial/' . $ajuste_salarials['id']); ?>"
                                                    class="btn btn-success" style="color: white;">
                                                    Aprovar
                                                </a>
                                                <a onclick="return confirm('Tens certeza que desejas rejeitar?');"
                                                    href="<?php echo admin_url('gestao_remuneracao/rejeitar_ajuste_salarial/' . $ajuste_salarials['id']); ?>"
                                                    class="text-white btn btn-danger"
                                                    style="background-color:#FFA500; border-color:#FFA500; color:#fff;">
                                                    Rejeitar
                                                </a>
                                            <?php endif ?>
                                            <a href="<?php echo admin_url('gestao_remuneracao/revisao_visualizar_ajuste/'. $ajuste_salarials['id']) ?>"
                                                class="btn btn-success btn-icon">
                                                <i style="color: white;" class="fa fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-default btn-edit-ajuste_salarial"
                                                data-id="<?= $ajuste_salarials['id']; ?>"
                                                data-percentual_aumento="<?= $ajuste_salarials['percentual_aumento']; ?>"
                                                data-motivo="<?= $ajuste_salarials['motivo']; ?>"
                                                data-aprovadores="<?= implode(',', json_decode($ajuste_salarials['aprovadores'], true)); ?>"
                                                data-staff_id="<?= $ajuste_salarials['staff_id']; ?>" data-toggle="modal"
                                                data-target="#editar">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a onclick="return confirm('Tem certeza que deseja excluir?');"
                                                href="<?= base_url('gestao_remuneracao/delete_ajuste_salarial/' . $ajuste_salarials['id']); ?>"
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
        <?php echo form_open(admin_url('gestao_remuneracao/add_ajuste_salarial'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Novo Ajuste</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <?php
                    $selectedStaff = '';
                    echo render_select('funcionario', $staff, ['staffid', ['firstname', 'lastname']], 'Usuarios<span class="text-danger">*</span>', $selectedStaff, [], [], '', '', true);
                    ?>
                </div>
                <div class="form-group">
                    <label for="percentual_aumento"><small class="req text-danger">*</small> Percentual de
                        Aumento</label>
                    <input type="number" id="percentual_aumento" name="percentual_aumento" class="form-control"
                        step="0.01" min="0" required>
                </div>
                <div class="form-group">
                    <label for="motivo"><small class="req text-danger">*</small> Motivo</label>
                    <textarea id="motivo" name="motivo" class="form-control" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <?php
                    $selectedStaff = '';
                    echo render_select('aprovadores[]', $staff_list, ['staffid', ['firstname', 'lastname']], 'Aprovadores<span class="text-danger">*</span>', $selectedStaff, ['multiple' => true], [], '', '', false);
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

<?= form_open(admin_url('gestao_remuneracao/editar_ajuste_salarial'), array('method' => 'post', 'id' => 'form_edit_ajuste_salarial')) ?>
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
                            <label for="percentual_aumento"><small class="req text-danger">*</small> Percentual de
                                Aumento</label>
                            <input type="number" id="percentual_aumento" name="percentual_aumento" class="form-control"
                                step="0.01" min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="motivo"><small class="req text-danger">*</small> Motivo</label>
                            <textarea id="motivo" name="motivo" class="form-control" rows="3" required></textarea>
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
        $(document).on('click', '.btn-edit-ajuste_salarial', function () {
            let id = $(this).data('id');
            let percentual_aumento = $(this).data('percentual_aumento');
            let motivo = $(this).data('motivo');
            let aprovadores = $(this).data('aprovadores') ? $(this).data('aprovadores').toString().split(',') : [];
            let funcionario = $(this).data('staff_id');

            $('#editar #id').val(id);
            $('#editar #percentual_aumento').val(percentual_aumento);
            $('#editar #motivo').val(motivo);
            $('#editar select[name="aprovadores[]"]').val(aprovadores).trigger('change');
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