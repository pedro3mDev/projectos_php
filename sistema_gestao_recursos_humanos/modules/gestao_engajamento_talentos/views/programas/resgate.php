<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_remuneracao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Engajamento de Talentos / Programas / Resgate de Prêmio
                </a>
            </div>
            <div class="col-md-2" style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
            </div>
        </div>

        </br>

        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="font-bold no-margin">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Resgate de Prêmio
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Novo Resgate
                                </a>
                                <a href="<?php echo admin_url('gestao_engajamento_talentos/programas')?>" class="btn"
                                    style="background-color: #3CB371; border-color: #3CB371; color: white;">
                                    <i class="fa-regular "></i>
                                    Reconhecimento
                                </a>
                                <a href="<?php echo admin_url('gestao_engajamento_talentos/programas_premio')?>"
                                    class="btn" style="background-color: #DAA520; border-color: #DAA520; color: white;">
                                    <i class="fa-regular "></i>
                                    Prêmio
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
                                <th>Colaborador</th>
                                <th>Prêmio</th>
                                <th>Data de Resgate</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach($resgate_premio as $item) : ?>
                                <tr>
                                    <td><?= html_entity_decode($item['firstname'].' '.$item['lastname'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['p_nome'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['data_resgate'] ?? '') ?></td>
                                    <td>
                                        <a href="<?php echo admin_url('gestao_engajamento_talentos/programas_visualizar_resgate/'.$item['id'])?>"
                                            data-id="" class="btn btn-sucess btn-icon"
                                            style="background-color: #3CB371; border-color: #3CB371; color: white;">
                                            <i style="color:#fff;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?= html_entity_decode($item['id'] ?? '') ?>"
                                            data-colaborador="<?= html_entity_decode($item['staff_id'] ?? '') ?>"
                                            data-premio="<?= html_entity_decode($item['premio_id'] ?? '') ?>"
                                            data-data_resgate="<?= html_entity_decode($item['data_resgate'] ?? '') ?>"
                                            class="btn btn-default btn-icon btn_edit_resgate_premio"
                                            style="background-color: #007bff; border-color: #007bff; color: white;">
                                            <i style="color:#fff;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certeza que desejas eliminar este Resgate de Prêmio?');"
                                            href="<?php echo admin_url('gestao_engajamento_talentos/delete_resgate_premio/'.$item['id'])?>"
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
        <?php echo form_open(admin_url('gestao_engajamento_talentos/add_resgate_premio'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Novo Resgate</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="colaborador"><small class="req text-danger">*</small> Colaborador</label>
                    <select name="colaborador" id="colaborador" class="selectpicker" data-live-search="true"
                        data-width="100%" data-none-selected-text="<?php echo _l('Colaborador'); ?>">
                        <option value=""></option>
                        <?php foreach($colaboradores as $item) : ?>
                        <option value="<?= $item['staffid'] ?>"><?= $item['firstname'] .' '. $item['lastname'] ?>
                        </option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="premio"><small class="req text-danger">*</small> Prêmio</label>
                    <select name="premio" id="premio" class="selectpicker" data-live-search="true" data-width="100%"
                        data-none-selected-text="<?php echo _l('Prêmio'); ?>">
                        <option value=""></option>
                        <?php foreach($premio as $item) : ?>
                        <option value="<?= $item['id'] ?>"><?= $item['nome'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="data_resgate"><small class="req text-danger">*</small> Data de Resgate</label>
                    <input type="date" id="data_resgate" name="data_resgate" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success">Salvar</button>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>

</div>
</div>

<?= form_open_multipart(admin_url('gestao_engajamento_talentos/editar_resgate_premio/0'), array('method' => 'post', 'id' => 'form_edit_resgate_premio')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar Resgate de Prêmio</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="e_colaborador"><small class="req text-danger">*</small> Colaborador</label>
                    <select name="e_colaborador" id="e_colaborador" class="selectpicker" data-live-search="true"
                        data-width="100%" data-none-selected-text="<?php echo _l('Colaborador'); ?>">
                        <option value=""></option>
                        <?php foreach($colaboradores as $item) : ?>
                        <option value="<?= $item['staffid'] ?>"><?= $item['firstname'] .' '. $item['lastname'] ?>
                            <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="e_premio"><small class="req text-danger">*</small> Prêmio</label>
                    <select name="e_premio" id="e_premio" class="selectpicker" data-live-search="true" data-width="100%"
                        data-none-selected-text="<?php echo _l('Prêmio'); ?>">
                        <option value=""></option>
                        <?php foreach($premio as $item) : ?>
                        <option value="<?= $item['id'] ?>"><?= $item['nome'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="e_data_resgate"><small class="req text-danger">*</small> Data de Resgate</label>
                    <input type="date" id="e_data_resgate" name="e_data_resgate" class="form-control" required>
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
<script>
$('.btn_edit_resgate_premio').click(function() {
    let colaborador = $(this).attr('data-colaborador');
    let premio = $(this).attr('data-premio');
    let data_resgate = $(this).attr('data-data_resgate');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_engajamento_talentos/editar_resgate_premio') ?>/" + id;
    $('#form_edit_resgate_premio').attr('action', url);

    $('select[name="e_colaborador').selectpicker('val', colaborador);
    $('select[name="e_premio').selectpicker('val', premio);
    $('input[name="e_data_resgate"]').val(data_resgate);

    $('#editar').modal('show');
})
</script>