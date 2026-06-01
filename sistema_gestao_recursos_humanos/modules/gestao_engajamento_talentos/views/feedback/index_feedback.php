<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_remuneracao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Engajamento de Talentos / Feedback
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

        <!-- Aqui vais por os Cards-->
        <?php require 'modules/gestao_engajamento_talentos/views/feedback/cards.php'; ?>
        </br>

        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="font-bold no-margin">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Feedback Contínuo
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Novo Feedback
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
                                <th>Remetente</th>
                                <th>Destinatário</th>
                                <th>Mensagem</th>
                                <th>Data de Envio</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach($feedback_continuo as $item) : ?>
                                <tr>
                                    <td><?= html_entity_decode($item['r_firstname'].' '.$item['r_lastname'] ?? '') ?>
                                    </td>
                                    <td><?= html_entity_decode($item['d_firstname'].' '.$item['d_lastname'] ?? '') ?>
                                    </td>
                                    <td><?= html_entity_decode($item['mensagem'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['data_criacao'] ?? '') ?></td>
                                    <td>
                                        <a href="<?php echo admin_url('gestao_engajamento_talentos/feedback_visualizar_feedback/'.$item['id']) ?>"
                                            class="btn btn-sucess btn-icon btn_edit_orcamento"
                                            style="background-color: #3CB371; border-color: #3CB371; color: white;">
                                            <i style="color:#fff;" class="fa fa-eye"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas eliminar este Feedback?');"
                                            href="<?php echo admin_url('gestao_engajamento_talentos/delete_feedback_continuo/'.$item['id']) ?>"
                                            class="btn btn-danger btn-icon _delete">
                                            <i style="color:#fff;" class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach ?>
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
        <?php echo form_open(admin_url('gestao_engajamento_talentos/add_feedback_continuo'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Novo Feedback</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="destinatario"><small class="req text-danger">*</small> Destinatário</label>
                    <select name="destinatario" id="destinatario" class="selectpicker" data-live-search="true"
                        data-width="100%" data-none-selected-text="<?php echo _l('Destinatário'); ?>">
                        <option value=""></option>
                        <?php foreach($staffs as $item) : ?>
                        <option value="<?= $item['staffid'] ?>"><?= $item['firstname'].' '.$item['lastname'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="mensagem"><small class="req text-danger">*</small> Mensagem</label>
                    <textarea id="mensagem" name="mensagem" class="form-control" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success">Enviar</button>
            </div>
        </div>
        <?php echo form_close(); ?>

    </div>
</div>

<?= form_open_multipart(admin_url('gestao_engajamento_talentos/feedback/editar'), array('method' => 'post', 'id' => 'form_edit_pesquisa')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar Feedback</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <input type="hidden" name="e_id" id="e_id">
                        <!-- Campo oculto para armazenar o ID da pesquisa -->
                        <div class="form-group">
                            <label for="remetente_id"><small class="req text-danger">*</small> Remetente</label>
                            <select id="remetente_id" name="remetente_id" class="form-control" required>
                                <option value="">Selecione o remetente</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="destinatario_id"><small class="req text-danger">*</small> Destinatário</label>
                            <select id="destinatario_id" name="destinatario_id" class="form-control" required>
                                <option value="">Selecione o destinatário</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="mensagem"><small class="req text-danger">*</small> Mensagem</label>
                            <textarea id="mensagem" name="mensagem" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="data_envio"><small class="req text-danger">*</small> Data de Envio</label>
                            <input type="datetime-local" id="data_envio" name="data_envio" class="form-control"
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
<?= form_close() ?>
<?php init_tail(); ?>
</body>

</html>