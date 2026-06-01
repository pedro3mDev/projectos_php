<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_remuneracao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Engajamento de Talentos / Conflitos e Resoluções /
                    Mediação de Conflito
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
                                <h4 class="no-margin font-bold">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Mediação de Conflito
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Nova Mediação
                                </a>
                                <a href="<?php echo admin_url('gestao_engajamento_talentos/conflitos')?>" class="btn"
                                    style="background-color: #DAA520; border-color: #DAA520; color: white;">
                                    <i class="fa-regular "></i>
                                    Conflito
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-9">
                            </div>
                            <div class=" col-md-3">
                                <select name="estado_f" id="estado_f" class="selectpicker" data-live-search="true"
                                    data-width="100%" data-none-selected-text="<?php echo _l('Estado'); ?>">
                                    <option value=""></option>
                                    <option value="Em Andamento">Em Andamento</option>
                                    <option value="Não Resolvido">Não Resolvido</option>
                                    <option value="Resolvido">Resolvido</option>
                                </select>
                            </div>
                        </div>
                        <br><br>
                        <table class="table table-hover table-bordered table-responsive dt-table">
                            <thead class="thead-custom">
                                <th>Conflito</th>
                                <th>Mediador</th>
                                <th>Descrição</th>
                                <th>Data da Mediação</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach($medicao_conflito as $item) : ?>
                                <tr>
                                    <td><?= html_entity_decode($item['c_descricao'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['firstname'].' '.$item['lastname'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['descricao'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['data_mediacao'] ?? '') ?></td>
                                    <td>
                                        <?php
                                            $texto_status = 'Em Andamento';
                                            $cor = "#999"; // Cor padrão (cinza para pendente)
                                            if ($item['status'] == 'resolvido') {
                                                $texto_status = 'Resolvido';
                                                $cor = "green";
                                            } elseif ($item['status'] == 'nao_resolvido') {
                                                $texto_status = 'Não Resolvido';
                                                $cor = "red";
                                            }
                                            $texto_cor = ($item['status'] == 'em_andamento') ? 'color:#000;' : 'color:#fff;';
                                        ?>
                                        <a
                                            style="background-color: <?= $cor ?>; <?= $texto_cor ?> padding: 5px 10px; border-radius:8px;">
                                            <?= $texto_status ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?php echo admin_url('gestao_engajamento_talentos/conflitos_visualizar_mediacao/'.$item['id'])?>"
                                            class="btn btn-sucess btn-icon"
                                            style="background-color: #3CB371; border-color: #3CB371; color: white;">
                                            <i style="color:#fff;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?= html_entity_decode($item['id'] ?? '') ?>"
                                            data-descricao="<?= html_entity_decode($item['descricao'] ?? '') ?>"
                                            data-status="<?= html_entity_decode($item['status'] ?? '') ?>"
                                            data-data_mediacao="<?= html_entity_decode($item['data_mediacao'] ?? '') ?>"
                                            data-mediador="<?= html_entity_decode($item['mediador_id'] ?? '') ?>"
                                            data-conflito="<?= html_entity_decode($item['conflito_id'] ?? '') ?>"
                                            class="btn btn-default btn-icon btn_edit_medicao_conflito"
                                            style="background-color: #007bff; border-color: #007bff; color: white;">
                                            <i style="color:#fff;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas eliminar este Medição Conflito?');"
                                            href="<?php echo admin_url('gestao_engajamento_talentos/delete_medicao_conflito/'.$item['id']) ?>"
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
        <?php echo form_open(admin_url('gestao_engajamento_talentos/add_medicao_conflito'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Nova Mediação</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="conflito"><small class="req text-danger">*</small> Conflito</label>
                    <select name="conflito" id="conflito" class="selectpicker" data-live-search="true" data-width="100%"
                        data-none-selected-text="<?php echo _l('Conflito'); ?>">
                        <option value=""></option>
                        <?php foreach($conflito as $item) : ?>
                        <option value="<?= $item['id'] ?>"><?= $item['descricao'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="mediador"><small class="req text-danger">*</small> Mediador</label>
                    <select name="mediador" id="mediador" class="selectpicker" data-live-search="true" data-width="100%"
                        data-none-selected-text="<?php echo _l('Mediador'); ?>">
                        <option value=""></option>
                        <?php foreach($staffs as $item) : ?>
                        <option value="<?= $item['staffid'] ?>"><?= $item['firstname'].' '.$item['lastname'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="descricao"><small class="req text-danger">*</small> Descrição</label>
                    <textarea id="descricao" name="descricao" class="form-control" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="data_mediacao"><small class="req text-danger">*</small> Data da Mediação</label>
                    <input type="date" id="data_mediacao" name="data_mediacao" class="form-control" required>
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

<?= form_open_multipart(admin_url('gestao_engajamento_talentos/editar_medicao_conflito'), array('method' => 'post', 'id' => 'form_edit_medicao_conflito')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar Mediação de Conflito</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="e_conflito"><small class="req text-danger">*</small> Conflito</label>
                    <select name="e_conflito" id="e_conflito" class="selectpicker" data-live-search="true"
                        data-width="100%" data-none-selected-text="<?php echo _l('Conflito'); ?>">
                        <option value=""></option>
                        <?php foreach($conflito as $item) : ?>
                        <option value="<?= $item['id'] ?>"><?= $item['descricao'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="e_mediador"><small class="req text-danger">*</small> Mediador</label>
                    <select name="e_mediador" id="e_mediador" class="selectpicker" data-live-search="true"
                        data-width="100%" data-none-selected-text="<?php echo _l('Mediador'); ?>">
                        <option value=""></option>
                        <?php foreach($staffs as $item) : ?>
                        <option value="<?= $item['staffid'] ?>"><?= $item['firstname'].' '.$item['lastname'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="e_descricao"><small class="req text-danger">*</small> Descrição</label>
                    <textarea id="e_descricao" name="e_descricao" class="form-control" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="e_data_mediacao"><small class="req text-danger">*</small> Data da Mediação</label>
                    <input type="date" id="e_data_mediacao" name="e_data_mediacao" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="e_estado"><small class="req text-danger">*</small> Estado</label>
                    <select name="e_estado" id="e_estado" class="form-control">
                        <option value="em_andamento">Em Andamento</option>
                        <option value="nao_resolvido">Não Resolvido</option>
                        <option value="resolvido">Resolvido</option>
                    </select>
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
$('.btn_edit_medicao_conflito').click(function() {
    let conflito = $(this).attr('data-conflito');
    let mediador = $(this).attr('data-mediador');
    let descricao = $(this).attr('data-descricao');
    let data_mediacao = $(this).attr('data-data_mediacao');
    let status = $(this).attr('data-status');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_engajamento_talentos/editar_medicao_conflito') ?>/" + id;
    $('#form_edit_medicao_conflito').attr('action', url);

    $('select[name="e_conflito').selectpicker('val', conflito);
    $('select[name="e_mediador').selectpicker('val', mediador);
    $('textarea[name="e_descricao"]').text(descricao);
    $('input[name="e_data_mediacao"]').val(data_mediacao);
    $('select[name="e_estado"]').val(status);

    $('#editar').modal('show');
})
$('#estado_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(4).search(this.value).draw();
})
</script>