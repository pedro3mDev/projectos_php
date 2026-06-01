<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_remuneracao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Engajamento de Talentos / Pesquisas / Resposta de Engajamento
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
                                    Resposta de Engajamento
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
                                <a href="<?php echo admin_url('gestao_engajamento_talentos/pesquisas')?>" class="btn"
                                    style="background-color: #E67E22; border-color: #E67E22; color: white;">
                                    <i class="fa-regular "></i>
                                    Pesquisa de Engajamento
                                </a>
                                <a href="<?php echo admin_url('gestao_engajamento_talentos/pesquisas_pergunta_engajamento')?>"
                                    class="btn" style="background-color: #DAA520; border-color: #DAA520; color: white;">
                                    <i class="fa-regular "></i>
                                    Pergunta de Engajamento
                                </a>
                                <a href="<?php echo admin_url('gestao_engajamento_talentos/analise_grafica')?>"
                                    class="btn" style="background-color: #8B0000; border-color: #8B0000; color: white;">
                                    <i class="fa-regular "></i>
                                    Analise Gráfica
                                </a>
                                <a href="<?php echo admin_url('gestao_engajamento_talentos/algoritmo')?>"
                                    class="btn" style="background-color: #2E8B57; border-color: #2E8B57; color: white;">
                                    <i class="fa-regular "></i> 
                                    Recomendação
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-9">
                            </div>
                            <div class="col-md-3">
                                <select name="f_pesquisa" id="f_pesquisa" class="selectpicker" data-live-search="true"
                                    data-width="100%" data-none-selected-text="<?php echo _l('Pesquisa'); ?>">
                                    <option value=""></option>
                                    <?php foreach($pesquisa_engajamento as $item) : ?>
                                    <option value="<?= $item['titulo'] ?>"><?= $item['titulo'] ?></option>
                                    <?php endforeach ?>
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
                                <?php foreach($resposta_engajamento as $item) : ?>
                                <tr>
                                    <td><?= html_entity_decode($item['titulo'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['texto'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['firstname'].' '.$item['lastname'] ?? '') ?></td>
                                    <?php
                                        switch ($item['resposta']) {
                                            case '1': $resposta = 'Pessimo';  break;
                                            case '2': $resposta = 'Mau';  break;
                                            case '3': $resposta = 'Bom';  break;
                                            case '4': $resposta = 'Muito Bom';  break;
                                            case '5': $resposta = 'Excelênte';  break;
                                            default: $resposta = html_entity_decode($item['resposta']); break;
                                        }
                                    ?>
                                    <td><?= html_entity_decode($resposta ?? '') ?></td>
                                    <td>
                                        <a href="<?php echo admin_url('gestao_engajamento_talentos/pesquisas_visualizar_resposta/'.$item['id'])?>"
                                            data-id="" class="btn btn-sucess btn-icon btn_edit_orcamento"
                                            style="background-color: #3CB371; border-color: #3CB371; color: white;">
                                            <i style="color:#fff;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?= html_entity_decode($item['id'] ?? '') ?>"
                                            data-colaborador="<?= html_entity_decode($item['staff_id'] ?? '') ?>"
                                            data-pergunta="<?= html_entity_decode($item['pergunta_engajamento_id'] ?? '') ?>"
                                            data-resposta="<?= html_entity_decode($item['resposta'] ?? '') ?>"
                                            class="btn btn-default btn-icon btn_edit_resposta_engajamento"
                                            class="btn btn-default btn-icon btn_edit_resposta_engajamento"
                                            style="background-color: #007bff; border-color: #007bff; color: white;">
                                            <i style="color:#fff;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas eliminar este Resposta Engajamento?');"
                                            href="<?php echo admin_url('gestao_engajamento_talentos/delete_resposta_engajamento/'.$item['id']); ?>"
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
        <?php echo form_open(admin_url('gestao_engajamento_talentos/add_resposta_engajamento'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Nova Pesquisa</h4>
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
                        <?php foreach($pergunta_engajamento as $item) : ?>
                        <option value="<?= $item['id'] ?>"><?= $item['texto'] ?> (Pesquisa: <?= $item['titulo'] ?>)
                        </option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="resposta"><small class="req text-danger">*</small> Resposta</label>
                    <select name="resposta" id="resposta" class="form-control" required>
                        <option value=""></option>
                        <option value="1">Pessimo</option>
                        <option value="2">Mau</option>
                        <option value="3">Bom</option>
                        <option value="4">Muito Bom</option>
                        <option value="5">Excelênte</option>
                    </select>
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

<?= form_open_multipart(admin_url('gestao_engajamento_talentos/editar_resposta_engajamento'), array('method' => 'post', 'id' => 'form_edit_resposta_engajamento')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar Resposta de Engajamento</h4>
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
                        <?php foreach($pergunta_engajamento as $item) : ?>
                        <option value="<?= $item['id'] ?>"><?= $item['texto'] ?> (Pesquisa: <?= $item['titulo'] ?>)
                        </option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="e_resposta"><small class="req text-danger">*</small> Resposta</label>
                    <select name="e_resposta" id="e_resposta" class="form-control" required>
                        <option value=""></option>
                        <option value="1">Pessimo</option>
                        <option value="2">Mau</option>
                        <option value="3">Bom</option>
                        <option value="4">Muito Bom</option>
                        <option value="5">Excelênte</option>
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
$('.btn_edit_resposta_engajamento').click(function() {
    let colaborador = $(this).attr('data-colaborador');
    let pergunta = $(this).attr('data-pergunta');
    let resposta = $(this).attr('data-resposta');

    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_engajamento_talentos/editar_resposta_engajamento') ?>/" + id;
    $('#form_edit_resposta_engajamento').attr('action', url);

    $('select[name="e_colaborador"]').selectpicker('val', colaborador);
    $('select[name="e_pergunta"]').selectpicker('val', pergunta);
    $('select[name="e_resposta"]').val(resposta);

    $('#editar').modal('show');
})
$('#f_pesquisa').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(0).search(this.value).draw();
})
</script>