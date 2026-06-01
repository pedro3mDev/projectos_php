<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_remuneracao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Planeamento de Força de Trabalho / Análise
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
        <?php require 'modules/plan_forca_trabalho/views/analise/cards.php'; ?>
        </br>

        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold"><i class="fa fa-address-card-o"
                                        aria-hidden="true"></i>Análise de
                                    Necessidade
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
                                <th>Departamento</th>
                                <th>Descrição</th>
                                <th>Quantidade</th>
                                <th>Prazo</th>
                                <th>Provedores</th>
                                <th>Status</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach ($analise as $dado): ?>
                                    <tr>
                                        <td><a href="#"><?= htmlspecialchars($dado['tipo_nome']); ?></a> </td>
                                        <td><a href="#"><?= htmlspecialchars($dado['descricao'] ?? 'Sem descrição'); ?></a>
                                        </td>
                                        <td><a href="#"><?= htmlspecialchars($dado['quantidade']); ?></a> </td>
                                        <td><a href="#"><?= date('d/m/Y', strtotime($dado['prazo'])); ?></a> </td>
                                        <td><a href="#"><?= htmlspecialchars($dado['aprovadores_nomes'] ?? 'Nenhum'); ?></a>
                                        </td>
                                        <td><a href="#"><?= htmlspecialchars($dado['status_nome']); ?></a> </td>
                                        <td>
                                            <?php if ($dado['status_id'] == 1): ?>
                                                <a href="<?php echo admin_url('plan_forca_trabalho/analise_aprovar/' . $dado['id']); ?>"
                                                    class="btn btn-success" style="color: white;">
                                                    Aprovar
                                                </a>
                                                <a onclick="return confirm('Tens certeza que desejas rejeitar?');"
                                                    href="<?php echo admin_url('plan_forca_trabalho/analise_rejeitar/' . $dado['id']); ?>"
                                                    class="text-white btn btn-danger"
                                                    style="background-color:#FFA500; border-color:#FFA500; color:#fff;">
                                                    Rejeitar
                                                </a>
                                            <?php endif ?>
                                            <a class="btn btn-success btn-icon"
                                                href="<?php echo admin_url('plan_forca_trabalho/visualizar_analise_one/' . $dado['id']) ?>">
                                                <i style="color: white;" class="fa fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-default btn-edit-analise"
                                                data-id="<?= $dado['id']; ?>" 
                                                data-descricao="<?= $dado['descricao']; ?>"
                                                data-prazo="<?= $dado['prazo']; ?>"
                                                data-quantidade="<?= $dado['quantidade']; ?>"
                                                data-aprovadores="<?= implode(',', json_decode($dado['aprovadores'], true)); ?>"
                                                data-departamento="<?= $dado['departamento_id']; ?>" 
                                                data-toggle="modal"
                                                data-target="#editar">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a onclick="return confirm('Tem certeza que deseja excluir?');"
                                                href="<?= base_url('plan_forca_trabalho/delete_analise_necessidade/' . $dado['id']); ?>"
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
        <?php echo form_open(admin_url('plan_forca_trabalho/add_Analise_necessidade'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Nova Análise</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="departamento_id">
                        <small class="req text-danger">*</small> Departamento
                    </label>
                    <select id="departamento_id" name="departamento_id" class="form-control" required>
                        <option value="">Selecione o departamento</option>
                        <?php foreach ($departamento as $dado): ?>
                            <option value="<?= $dado['departmentid'] ?>"><?= $dado['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="descricao">
                        <small class="req text-danger">*</small> Descrição
                    </label>
                    <input type="text" id="descricao" name="descricao" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="quantidade">
                        <small class="req text-danger">*</small> Quantidade
                    </label>
                    <input type="number" id="quantidade" name="quantidade" class="form-control" required min="1">
                </div>

                <div class="form-group">
                    <label for="prazo">
                        <small class="req text-danger">*</small> Prazo
                    </label>
                    <input type="date" id="prazo" name="prazo" class="form-control" required>
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

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success">Salvar</button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<?= form_open(admin_url('plan_forca_trabalho/editar_analise_necessidade'), array('method' => 'post', 'id' => 'form_edit_analise_necessidade')) ?>

<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Editar Avaliação</h4>
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
                            <label for="departamento_id">
                                <small class="req text-danger">*</small> Departamento
                            </label>
                            <select id="departamento_id" name="departamento_id" class="form-control" required>
                                <option value="">Selecione o departamento</option>
                                <?php foreach ($departamento as $dado): ?>
                                    <option value="<?= $dado['departmentid'] ?>"><?= $dado['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="descricao">
                                <small class="req text-danger">*</small> Descrição
                            </label>
                            <input type="text" id="descricao" name="descricao" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="quantidade">
                                <small class="req text-danger">*</small> Quantidade
                            </label>
                            <input type="number" id="quantidade" name="quantidade" class="form-control" required
                                min="1">
                        </div>

                        <div class="form-group">
                            <label for="prazo">
                                <small class="req text-danger">*</small> Prazo
                            </label>
                            <input type="date" id="prazo" name="prazo" class="form-control" required>
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
        $(document).on('click', '.btn-edit-analise', function () {
            console.log("dsfdfdf");

            let id = $(this).data('id');
            let descricao = $(this).data('descricao');
            let prazo = $(this).data('prazo');
            let quantidade = $(this).data('quantidade');
            let aprovadores = $(this).data('aprovadores') ? $(this).data('aprovadores').toString().split(',') : [];
            let departamento = $(this).data('departamento');


            $('#editar #id').val(id);
            //$('#editar textarea[name="descricao"]').val(descricao);
            $('#editar #descricao').val(descricao);
            $('#editar #prazo').val(prazo);
            $('#editar #quantidade').val(quantidade);
            $('#editar select[name="aprovadores[]"]').val(aprovadores).trigger('change');
            $('#editar select[name="departamento_id"]').val(departamento).trigger('change');

        });
    });
</script>