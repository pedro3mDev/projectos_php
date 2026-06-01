<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_remuneracao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Planeamento de Força de Trabalho / Planeamento
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
        <?php require 'modules/plan_forca_trabalho/views/planeamento/cards.php'; ?>
        </br>

        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold"><i class="fa fa-address-card-o"
                                        aria-hidden="true"></i>Planeamento de Recursos
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Novo Planeamento
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
                                <th>Tipo</th>
                                <th>Previsão de Demanda</th>
                                <th>Data de Criação</th>
                                <th></th>
                            </thead>
                            <tbody>

                                <?php foreach ($planeamento as $plano): ?>
                                    <tr>
                                        <td> <a href="#"><?= htmlspecialchars($plano['tipo_nome']); ?></a> </td>
                                        <td> <a href="#"><?= htmlspecialchars($plano['previsao_demanda']); ?></a> </td>
                                        <td> <a href="#"><?= date('d/m/Y', strtotime($plano['data_criacao'])); ?></a> </td>
                                        <td>
                                            <a href="#" class="btn btn-default btn-edit-planeamento"
                                                data-id="<?= $plano['id']; ?>"
                                                data-previsao_demanda="<?= $plano['previsao_demanda']; ?>"
                                                data-data_criacao="<?= $plano['data_criacao']; ?>"
                                                data-tipo_planeamento="<?= $plano['tipo_planeamento_id']; ?>"
                                                data-toggle="modal" data-target="#editar">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a onclick="return confirm('Tem certeza que deseja excluir?');"
                                                href="<?= base_url('plan_forca_trabalho/delete_planeamento/' . $plano['id']); ?>"
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
        <?php echo form_open(admin_url('plan_forca_trabalho/add_planeamento'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Novo Planeamento</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="tipo"><small class="req text-danger">*</small> Tipo</label>
                    <select id="tipo" name="tipo_planeamento_id" class="form-control" required>
                        <option value="">Selecione o tipo</option>
                        <?php foreach ($tipo_planeamento as $plano) { ?>
                            <option value="<?php echo $plano['id'] ?>"><?php echo $plano['nome'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="previsao_demanda"><small class="req text-danger">*</small> Previsão de Demanda</label>
                    <input type="text" id="previsao_demanda" name="previsao_demanda" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="data_criacao"><small class="req text-danger">*</small> Data de Criação</label>
                    <input type="date" id="data_criacao" name="data_criacao" class="form-control" required>
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



<?= form_open(admin_url('plan_forca_trabalho/editar_planeamento'), array('method' => 'post', 'id' => 'form_edit_planeamento')) ?>

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
                            <label class="control-label">Tipo de Planeamento <small
                                    class="req text-danger">*</small></label>
                            <select class="form-control" name="tipo_planeamento_id" id="tipo_planeamento_id">
                                <option value=""></option>
                                <?php foreach ($tipo_planeamento as $dado): ?>
                                    <option value="<?= $dado['id'] ?>"><?= $dado['nome'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="previsao_demanda"><small class="req text-danger">*</small> Previsão de
                                Demanda</label>
                            <input type="text" id="previsao_demanda" name="previsao_demanda" class="form-control"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="data_criacao"><small class="req text-danger">*</small> Data de Criação</label>
                            <input type="date" id="data_criacao" name="data_criacao" class="form-control" required>
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
        $(document).on('click', '.btn-edit-planeamento', function () {
            console.log("dsfdfdf");

            let id = $(this).data('id');
            let previsao_demanda = $(this).data('previsao_demanda');
            let data_criacao = $(this).data('data_criacao');
            let tipo_planeamento = $(this).data('tipo_planeamento');


            $('#editar #id').val(id);
            $('#editar #previsao_demanda').val(previsao_demanda);
            $('#editar #data_criacao').val(data_criacao);
            $('#editar select[name="tipo_planeamento_id"]').val(tipo_planeamento).trigger('change');

        });
    });
</script>