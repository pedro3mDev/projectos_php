<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_remuneracao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Planeamento de Força de Trabalho / Previsação
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
        <?php require 'modules/plan_forca_trabalho/views/previsao/cards.php'; ?>
        </br>
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold"><i class="fa fa-address-card-o"
                                        aria-hidden="true"></i>Previsão de Necessidade
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Nova Previsão
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
                                <th>Tipo de Previsão</th>
                                <th>Dados de Entrada</th>
                                <th>Resultado da Previsão</th>
                                <th>Data</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach ($previsao as $dado): ?>
                                    <tr>
                                        <td><a href="#"><?= htmlspecialchars($dado['departamento']); ?></a> </td>
                                        <td><a href="#"><?= htmlspecialchars($dado['previsao']); ?></a>
                                        </td>
                                        <td><a href="#"><?= htmlspecialchars($dado['dado_entrada']); ?></a> </td>
                                        <td><a href="#"><?= htmlspecialchars($dado['resultado_previsao']); ?></a> </td>
                                        <td><a href="#"><?= date('d/m/Y', strtotime($dado['data'])); ?></a> </td>
                                        <td>
                                            <a class="btn btn-success btn-icon"
                                                href="<?php echo admin_url('plan_forca_trabalho/visualizar_previsao_one/' . $dado['id']) ?>">
                                                <i style="color: white;" class="fa fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-default btn-edit-previsao"
                                                data-id="<?= $dado['id']; ?>"
                                                data-resultado_previsao="<?= $dado['resultado_previsao']; ?>"
                                                data-dado_entrada="<?= $dado['dado_entrada']; ?>"
                                                data-data="<?= $dado['data']; ?>"
                                                data-tipo_previsao="<?= $dado['tipo_previsao_id']; ?>"
                                                data-departamento="<?= $dado['departamento_id']; ?>" data-toggle="modal"
                                                data-target="#editar">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a onclick="return confirm('Tem certeza que deseja excluir?');"
                                                href="<?= base_url('plan_forca_trabalho/delete_previsaos/' . $dado['id']); ?>"
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
        <?php echo form_open(admin_url('plan_forca_trabalho/add_previsaos'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Nova Previsão</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="departamento_id"><small class="req text-danger">*</small> Departamento</label>
                    <select id="departamento_id" name="departamento_id" class="form-control" required>
                        <option value="">Selecione o Departamento</option>
                        <?php foreach ($departamento as $dado): ?>
                            <option value="<?= $dado['departmentid'] ?>"><?= $dado['name'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tipo_previsao_id"><small class="req text-danger">*</small> Tipo de Previsão</label>
                    <select id="tipo_previsao_id" name="tipo_previsao_id" class="form-control" required>
                        <option value="">Selecione o Tipo de Previsão</option>
                        <?php foreach ($tipo_previsao as $dado): ?>
                            <option value="<?= $dado['id'] ?>"><?= $dado['nome'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="dado_entrada"><small class="req text-danger">*</small> Dados de Entrada</label>
                    <input type="text" id="dado_entrada" name="dado_entrada" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="resultado_previsao"><small class="req text-danger">*</small> Resultado da
                        Previsão</label>
                    <input type="text" id="resultado_previsao" name="resultado_previsao" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="data"><small class="req text-danger">*</small> Data</label>
                    <input type="date" id="data" name="data" class="form-control" required>
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


<?= form_open(admin_url('plan_forca_trabalho/editar_previsaos'), array('method' => 'post', 'id' => 'form_edit_previsaos')) ?>

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
                            <label for="departamento_id"><small class="req text-danger">*</small> Departamento</label>
                            <select id="departamento_id" name="departamento_id" class="form-control" required>
                                <option value="">Selecione o Departamento</option>
                                <?php foreach ($departamento as $dado): ?>
                                    <option value="<?= $dado['departmentid'] ?>"><?= $dado['name'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tipo_previsao_id"><small class="req text-danger">*</small> Tipo de
                                Previsão</label>
                            <select id="tipo_previsao_id" name="tipo_previsao_id" class="form-control" required>
                                <option value="">Selecione o Tipo de Previsão</option>
                                <?php foreach ($tipo_previsao as $dado): ?>
                                    <option value="<?= $dado['id'] ?>"><?= $dado['nome'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="dados_entrada"><small class="req text-danger">*</small> Dados de Entrada</label>
                            <input type="text" id="dado_entrada" name="dado_entrada" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="resultado_previsao"><small class="req text-danger">*</small> Resultado da
                                Previsão</label>
                            <input type="text" id="resultado_previsao" name="resultado_previsao" class="form-control"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="data"><small class="req text-danger">*</small> Data</label>
                            <input type="date" id="data" name="data" class="form-control" required>
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
        $(document).on('click', '.btn-edit-previsao', function () {

            let id = $(this).data('id');
            let dado_entrada = $(this).data('dado_entrada');
            let resultado_previsao = $(this).data('resultado_previsao');
            let data = $(this).data('data');
            let tipo_previsao = $(this).data('tipo_previsao');
            let departamento = $(this).data('departamento');


            $('#editar #id').val(id);
            //$('#editar textarea[name="descricao"]').val(descricao);
            $('#editar #dado_entrada').val(dado_entrada);
            $('#editar #data').val(data);
            $('#editar #resultado_previsao').val(resultado_previsao);
            $('#editar select[name="tipo_previsao_id"]').val(tipo_previsao).trigger('change');
            $('#editar select[name="departamento_id"]').val(departamento).trigger('change');

        });
    });
</script>