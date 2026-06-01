<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_remuneracao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Engajamento de Talentos / Clima / Resposta de Clima
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
                                    Resposta de Clima
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Nova Resposta
                                </a>
                                <a href="<?php echo admin_url('gestao_engajamento_talentos/clima')?>" class="btn"
                                    style="background-color: #E67E22; border-color: #E67E22; color: white;">
                                    <i class="fa-regular "></i>
                                    Pesquisa de Clima
                                </a>
                                <a href="<?php echo admin_url('gestao_engajamento_talentos/clima_pergunta_clima')?>"
                                    class="btn" style="background-color: #DAA520; border-color: #DAA520; color: white;">
                                    <i class="fa-regular "></i>
                                    Pergunta de Clima
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
                                <th>Pesquisa</th>
                                <th>Pergunta</th>
                                <th>Colaborador</th>
                                <th>Resposta</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach($resposta_clima as $item) : ?>
                                <tr>
                                    <td><?= html_entity_decode($item['titulo'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['texto'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['firstname'].' '.$item['lastname'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['resposta'] ?? '') ?></td>
                                    <td>
                                        <a href="<?php echo admin_url('gestao_engajamento_talentos/clima_visualizar_resposta/'.$item['id']) ?>"
                                            data-id="" class="btn btn-sucess btn-icon btn_edit_orcamento"
                                            style="background-color: #3CB371; border-color: #3CB371; color: white;">
                                            <i style="color:#fff;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?= html_entity_decode($item['id'] ?? '') ?>"
                                            data-colaborador="<?= html_entity_decode($item['staff_id'] ?? '') ?>"
                                            data-pergunta="<?= html_entity_decode($item['pergunta_clima_id'] ?? '') ?>"
                                            data-resposta="<?= html_entity_decode($item['resposta'] ?? '') ?>"
                                            class="btn btn-default btn-icon btn_edit_resposta_clima"
                                            class="btn btn-default btn-icon btn_edit_resposta_clima"
                                            style="background-color: #007bff; border-color: #007bff; color: white;">
                                            <i style="color:#fff;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas eliminar esta Resposta?');"
                                            href="<?php echo admin_url('gestao_engajamento_talentos/delete_resposta_clima/'.$item['id']) ?>"
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
        <?php echo form_open(admin_url('gestao_engajamento_talentos/add_resposta_clima'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Nova</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="colaborador"><small class="req text-danger">*</small> Colaborador</label>
                    <select name="colaborador" id="colaborador" class="selectpicker" data-live-search="true"
                        data-width="100%" data-none-selected-text="<?php echo _l('Colaborador'); ?>">
                        <option value=""></option>
                        <?php foreach($colaboradores as $item) : ?>
                        <option value="<?= $item['staffid'] ?>"><?= $item['firstname'].' '.$item['lastname'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="pergunta"><small class="req text-danger">*</small> Pergunta</label>
                    <select name="pergunta" id="pergunta" class="selectpicker" data-live-search="true" data-width="100%"
                        data-none-selected-text="<?php echo _l('Pergunta'); ?>">
                        <option value=""></option>
                        <?php foreach($pergunta_clima as $item) : ?>
                        <option value="<?= $item['id'] ?>"><?= $item['texto'] ?> (Pesquisa: <?= $item['titulo'] ?>)
                        </option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="resposta"><small class="req text-danger">*</small> Resposta</label>
                    <input type="text" id="resposta" name="resposta" class="form-control" required>
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

<?= form_open_multipart(admin_url('gestao_engajamento_talentos/editar_resposta_clima'), array('method' => 'post', 'id' => 'form_edit_resposta_clima')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="e_colaborador"><small class="req text-danger">*</small> Colaborador</label>
                    <select name="e_colaborador" id="e_colaborador" class="selectpicker" data-live-search="true"
                        data-width="100%" data-none-selected-text="<?php echo _l('Colaborador'); ?>">
                        <option value=""></option>
                        <?php foreach($colaboradores as $item) : ?>
                        <option value="<?= $item['staffid'] ?>"><?= $item['firstname'].' '.$item['lastname'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="e_pergunta"><small class="req text-danger">*</small> Pergunta</label>
                    <select name="e_pergunta" id="e_pergunta" class="selectpicker" data-live-search="true"
                        data-width="100%" data-none-selected-text="<?php echo _l('Pergunta'); ?>">
                        <option value=""></option>
                        <?php foreach($pergunta_clima as $item) : ?>
                        <option value="<?= $item['id'] ?>"><?= $item['texto'] ?> (Pesquisa: <?= $item['titulo'] ?>)
                        </option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="e_resposta"><small class="req text-danger">*</small> Resposta</label>
                    <input type="text" id="e_resposta" name="e_resposta" class="form-control" required>
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
$('.btn_edit_resposta_clima').click(function() {
    let colaborador = $(this).attr('data-colaborador');
    let pergunta = $(this).attr('data-pergunta');
    let resposta = $(this).attr('data-resposta');

    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_engajamento_talentos/editar_resposta_clima') ?>/" + id;
    $('#form_edit_resposta_clima').attr('action', url);

    $('select[name="e_colaborador"]').selectpicker('val', colaborador);
    $('select[name="e_pergunta"]').selectpicker('val', pergunta);
    $('input[name="e_resposta"]').val(resposta);

    $('#editar').modal('show');
})
$('#f_pesquisa').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(0).search(this.value).draw();
})
</script>