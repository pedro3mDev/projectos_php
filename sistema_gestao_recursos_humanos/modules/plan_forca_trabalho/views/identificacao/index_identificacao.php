<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_remuneracao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Planeamento de Força de Trabalho / Indentificação
                </a>
            </div>
            <div class="col-md-2" style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
            </div>
        </div>
        </br>
        <!-- Não mexe  nessa extrutura-->
        <?php require 'modules/plan_forca_trabalho/views/identificacao/cards.php'; ?>
        </br>
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold"><i class="fa fa-address-card-o"
                                        aria-hidden="true"></i>Competência do Funcionário
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Nova Competência
                                </a>
                            </div>
                        </div>
                        </br>
                        <div class="row">
                            <div class=" col-md-6">
                            </div>
                            <div class=" col-md-3">
                                <select name="tipo_viagem_f" id="tipo_viagem_f" class="selectpicker" multiple="true"
                                    data-live-search="true" data-width="100%"
                                    data-none-selected-text="<?php echo _l('Plano Desenv.'); ?>">
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class=" col-md-3">
                                <select name="estado_f" id="estado_f" class="selectpicker" multiple="true"
                                    data-live-search="true" data-width="100%"
                                    data-none-selected-text="<?php echo _l('Habilidade'); ?>">
                                </select>
                            </div>
                        </div>
                        <br><br>
                        <table class="table dt-table">
                            <thead class="thead-custom">
                                <th>Funcionário</th>
                                <th>Competência</th>
                                <th>Nível</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach ($competencia_funcionario as $dado): ?>
                                    <tr>
                                        <td> <a href="#"><?= htmlspecialchars($dado['primeiro_nome'] . " " . $dado['segundo_nome']); ?></a>
                                        </td>
                                        <td> <a href="#"><?= htmlspecialchars($dado['tipo_nome']); ?></a> </td>
                                        <td> <a href="#"><?= htmlspecialchars($dado['nivel']); ?></a> </td>
                                        <td>
                                            <a class="btn btn-success btn-icon"
                                                href="<?php echo admin_url('plan_forca_trabalho/competencia_one/' . $dado['id']) ?>">
                                                <i style="color: white;" class="fa fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-default btn-edit-competencia_funcionario"
                                                data-id="<?= $dado['id']; ?>" 
                                                data-nivel="<?= $dado['nivel']; ?>"
                                                data-competencia="<?= $dado['competencia_id']; ?>"
                                                data-staff_id="<?= $dado['staff_id']; ?>" 
                                                data-toggle="modal"
                                                data-target="#editar">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a onclick="return confirm('Tem certeza que deseja excluir?');"
                                                href="<?= base_url('plan_forca_trabalho/delete_competencia_funcionario/' . $dado['id']); ?>"
                                                class="btn btn-danger btn-icon _delete">
                                                <i style="color: white;" class="fa fa-trash"></i>
                                            </a>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
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
        <?php echo form_open(admin_url('plan_forca_trabalho/add_competencia_funcionario'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Nova Competência</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <?php
                    echo render_select(
                        'funcionario',
                        $staff,
                        ['staffid', ['firstname', 'lastname']],
                        'Funcionário <span class="text-danger">*</span>',
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
                    <label class="control-label">Competencia<small class="req text-danger">*</small></label>
                    <select class="form-control" name="competencia_id" id="competencia_id">
                        <option value=""></option>
                        <?php foreach ($competencia as $dado): ?>
                            <option value="<?= $dado['id'] ?>"><?= $dado['nome'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="control-label">Nivel <small class="req text-danger">*</small></label>
                    <input type="number" id="nivel" name="nivel" class="form-control">
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

<?= form_open(admin_url('plan_forca_trabalho/editar_competencia_funcionario'), array('method' => 'post', 'id' => 'form_edit_competencia_funcionario')) ?>

<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Editar Competencia Funcionario</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <!-- ID da Avaliação -->
                        <input type="hidden" name="id" id="id" value="">

                        <div class="form-group">
                            <?php
                            echo render_select(
                                'funcionario',
                                $staff,
                                ['staffid', ['firstname', 'lastname']],
                                'Funcionário <span class="text-danger">*</span>',
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
                            <label class="control-label">Competencia<small class="req text-danger">*</small></label>
                            <select class="form-control" name="competencia_id" id="competencia_id">
                                <option value=""></option>
                                <?php foreach ($competencia as $dado): ?>
                                    <option value="<?= $dado['id'] ?>"><?= $dado['nome'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Nivel <small class="req text-danger">*</small></label>
                            <input type="number" id="nivel" name="nivel" class="form-control">
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
        $(document).on('click', '.btn-edit-competencia_funcionario', function () {
            console.log("dsfdfdf");

            let id = $(this).data('id');
            let nivel = $(this).data('nivel');
            let competencia = $(this).data('competencia');
            let funcionario = $(this).data('staff_id');

            $('#editar #id').val(id);
            $('#editar #nivel').val(nivel);
            $('#editar select[name="competencia_id"]').val(competencia).trigger('change');
            $('#editar select[name="funcionario"]').val(funcionario).trigger('change');

        });
    });
</script>