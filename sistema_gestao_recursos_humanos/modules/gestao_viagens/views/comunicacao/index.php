<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_viagens/assets/css/comunicacao.css'); ?>">

<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-6">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Viagens / Comunicação
                </a>
            </div>
            <div class="col-md-6" style=" display: flex; justify-content: flex-end; align-items: center;">
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
                                <h4 class="no-margin font-bold"><i class="fa fa-address-card-o"
                                        aria-hidden="true"></i>Comunicação
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Nova Comunicação
                                </a>
                                <!--a href="<?php echo admin_url('gestao_desenv_individual/analise')?>"
                                    class="btn"
                                    style="background-color: #2F4F4F; border-color: #2F4F4F; color: white;">
                                    <i class="fa-regular "></i>
                                    Análise 
                                </a-->
                            </div>
                        </div>
                        </br>
                        <div class="row">
                            <div class=" col-md-9">
                            </div>
                            <div class=" col-md-3">
                                <select name="tipo_f" id="tipo_f" class="selectpicker" data-live-search="true"
                                    data-width="100%" data-none-selected-text="<?php echo _l('Tipo'); ?>">
                                    <option value=""></option>
                                    <?php foreach ($tipo_comunicacao as $t) : ?>
                                    <option value="<?= $t['nome'] ?>"><?= $t['nome'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <br><br>
                        <table class="table dt-table">
                            <thead class="thead-custom">
                                <th>Viagem</th>
                                <th>Tipo</th>
                                <th>Funcionários</th>
                                <th>Mensagem</th>
                                <th>Data Envio</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach($comunicacao as $c) : ?>
                                <tr>
                                    <td><?php echo html_entity_decode($c['objetivo']); ?>(<?php echo html_entity_decode($c['destino']); ?>)
                                    </td>
                                    <td><?php echo ($c['tipo_comunicacao']); ?></td>
                                    <td><?php echo nome_funcinario_comunicacao($c['id']); ?></td>
                                    <td><?php echo html_entity_decode($c['mensagem']); ?></td>
                                    <td><?php echo html_entity_decode($c['data_envio']); ?></td>
                                    <td>
                                        <a href="<?php echo admin_url('gestao_viagens/comunicacao/comunicacao/'.$c['id']); ?>"
                                            class="btn btn-success btn-icon">
                                            <i style="color: white;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?= $c['id'] ?>"
                                            data-funcionarios='<?= multi_staff_comunicacao($c["id"]) ?>'
                                            data-orcamento="<?= html_entity_decode($c['orcamento_viagem_id']) ?>"
                                            data-tipo_comunicacao="<?= html_entity_decode($c['tipo_comunicacao_id']) ?>"
                                            data-mensagem="<?= html_entity_decode($c['mensagem']) ?>"
                                            data-data_envio="<?= html_entity_decode($c['data_envio']) ?>"
                                            class="btn btn-default btn_editar_comunicacao"
                                            style="background-color: #007bff; border-color: #007bff;">
                                            <i style="color: white;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certeza que desejas eliminar esta Comunicação?');"
                                            href="<?php echo admin_url('gestao_viagens/comunicacao/delete/'.$c['id']); ?>"
                                            class="btn btn-danger btn-icon _delete">
                                            <i style="color: white;" class="fa fa-trash"></i>
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
    </div>
</div>
</div>
<div class="clearfix"></div>
</div>
<div class="btn-bottom-pusher"></div>
</div>
</div>
<div id="new_version"></div>

<div class="modal" id="modal_add" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <?= form_open(admin_url('gestao_viagens/comunicacao/adicionar'), array('method' => 'post')) ?>
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Nova Comunicação
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="company" class="control-label">
                                Viagem <small class="req text-danger">*</small>
                            </label>
                            <select class="form-control" name="orcamento">
                                <option value=""></option>
                                <?php foreach ($pedidos_viagem as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['objetivo'] ?>(<?= $t['destino'] ?>)</option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="company" class="control-label">
                                Tipo de Comunicação<small class="req text-danger">*</small>
                            </label>
                            <select class="form-control" name="tipo_comunicacao">
                                <option value=""></option>
                                <?php foreach ($tipo_comunicacao as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['nome'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <?php
                                $selectedStaff = '';
                                echo render_select('funcionarios[]', $staffs, ['staffid', ['firstname', 'lastname']], 'Funcionários<span class="text-danger">*</span>', $selectedStaff, ['multiple' => true], [], '', '', false);
                            ?>
                        </div>
                        <div class="form-group" app-field-wrapper="mensagem">
                            <label for="mensagem" class="control-label">
                                Mensagem<small class="req text-danger">*</small>
                            </label>
                            <textarea name="mensagem" class="form-control" style="min-height: 100px;"></textarea>
                        </div>
                        <div class="form-group" app-field-wrapper="data_comunicacao">
                            <label for="data_comunicacao" class="control-label">
                                Data Comunicação<small class="req text-danger">*</small>
                            </label>
                            <input type="date" id="data_comunicacao" name="data_comunicacao" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo _l('Cancelar'); ?></button>
                <button type="submit" class="btn btn-success"><?php echo _l('Salvar'); ?></button>
            </div>
        </div>
        <?= form_close()  ?>
    </div>
</div>

<?= form_open(admin_url('gestao_viagens/comunicacao/editar_pedido'), array('method' => 'post', 'id' => 'form_edit_comunicacao')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Editar Comunicação </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="company" class="control-label">
                                Viagem <small class="req text-danger">*</small>
                            </label>
                            <select class="form-control" name="e_orcamento">
                                <?php foreach ($pedidos_viagem as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['objetivo'] ?>(<?= $t['destino'] ?>)</option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="company" class="control-label">
                                Tipo de Comunicação<small class="req text-danger">*</small>
                            </label>
                            <select class="form-control" name="e_tipo_comunicacao">
                                <?php foreach ($tipo_comunicacao as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['nome'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <?php
                            $selectedStaffFunc = '';
                            echo render_select('funcionarios_e[]', $staffs, ['staffid', ['firstname', 'lastname']], 'Funcionários<span class="text-danger">*</span>', $selectedStaffFunc, ['multiple' => true], [], '', '', false);
                            ?>
                        </div>
                        <div class="form-group" app-field-wrapper="mensagem">
                            <label for="mensagem" class="control-label">
                                Mensagem<small class="req text-danger">*</small>
                            </label>
                            <textarea name="e_mensagem" class="form-control" style="min-height: 100px;"></textarea>
                        </div>
                        <div class="form-group" app-field-wrapper="data_comunicacao">
                            <label for="data_comunicacao" class="control-label">
                                Data Comunicação<small class="req text-danger">*</small>
                            </label>
                            <input type="date" id="data_comunicacao" name="e_data_comunicacao" class="form-control">
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
<?= form_close()  ?>
<?php init_tail(); ?>
<script>
$('.btn_editar_comunicacao').click(function() {
    let orcamento = $(this).attr('data-orcamento');
    let tipo_comunicacao = $(this).attr('data-tipo_comunicacao');
    let funcionarios = $(this).attr('data-funcionarios');

    let mensagem = $(this).attr('data-mensagem');
    let data_envio = $(this).attr('data-data_envio');

    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_viagens/comunicacao/editar') ?>/" + id;
    $('#form_edit_comunicacao').attr('action', url);
    $('select[name="e_orcamento"]').val(orcamento);
    $('select[name="e_tipo_comunicacao"]').val(tipo_comunicacao);
    $('select[name="funcionarios_e[]"]').val(JSON.parse(funcionarios));
    $('textarea[name="e_mensagem"]').html(mensagem);
    $('input[name="e_data_comunicacao"]').val(data_envio);

    $('#editar').modal('show');
})
$('#tipo_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(1).search(this.value).draw();
})
</script>