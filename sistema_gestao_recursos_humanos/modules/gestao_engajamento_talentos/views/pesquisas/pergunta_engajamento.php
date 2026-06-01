<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_remuneracao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Engajamento de Talentos / Pesquisas / Pergunta de
                    Engajamento
                </a>
            </div>
            <div class="col-md-2" style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
            </div>
        </div>

        </br>
        </br>

        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Pergunta de Engajamento
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Nova Pergunta
                                </a>
                                <a href="<?php echo admin_url('gestao_engajamento_talentos/pesquisas')?>" class="btn"
                                    style="background-color: #E67E22; border-color: #E67E22; color: white;">
                                    <i class="fa-regular "></i>
                                    Pesquisa de Engajamento
                                </a>
                                <a href="<?php echo admin_url('gestao_engajamento_talentos/pesquisas_resposta_engajamento')?>"
                                    class="btn" style="background-color: #2C3E50; border-color: #2C3E50; color: white;">
                                    <i class="fa-regular "></i>
                                    Resposta de Engajamento
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
                            <div class=" col-md-3">
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
                                <th>Titulo(Pesquisa)</th>
                                <th>Descrição(Pesquisa)</th>
                                <th>Texto</th>
                                <th>Tipo de Resposta</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach($pergunta_engajamento as $item) : ?>
                                <tr>
                                    <td><?= html_entity_decode($item['titulo'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['descricao'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['texto'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['tipo_resposta'] ?? '') ?></td>
                                    <td>
                                        <a href="<?php echo admin_url('gestao_engajamento_talentos/pesquisas_visualizar_pergunta/'.$item['id'])?>"
                                            class="btn btn-sucess btn-icon"
                                            style="background-color: #3CB371; border-color: #3CB371; color: white;">
                                            <i style="color:#fff;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?= html_entity_decode($item['id'] ?? '') ?>"
                                            data-pesquisa="<?= html_entity_decode($item['pesquisa_engajamento_id'] ?? '') ?>"
                                            data-texto="<?= html_entity_decode($item['texto'] ?? '') ?>"
                                            data-tipo_resposta="<?= html_entity_decode($item['tipo_resposta'] ?? '') ?>"
                                            class="btn btn-default btn-icon btn_edit_pergunta_engajamento"
                                            style="background-color: #007bff; border-color: #007bff; color: white;">
                                            <i style="color:#fff;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas eliminar esta Pergunta  de Engajamento?');"
                                            href="<?php echo admin_url('gestao_engajamento_talentos/delete_pergunta_engajamento/'.$item['id']); ?>"
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
        <?php echo form_open(admin_url('gestao_engajamento_talentos/add_pergunta_engajamento'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Nova Pergunta</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="pesquisa"><small class="req text-danger">*</small> Pesquisa</label>
                    <select name="pesquisa" id="pesquisa" class="selectpicker" data-live-search="true" data-width="100%"
                        data-none-selected-text="<?php echo _l('Pesquisa'); ?>">
                        <option value=""></option>
                        <?php foreach($pesquisa_engajamento as $item) : ?>
                        <option value="<?= $item['id'] ?>"><?= $item['titulo'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="texto"><small class="req text-danger">*</small>
                        Texto</label>
                    <input type="text" id="texto" name="texto" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="tipo_resposta"><small class="req text-danger">*</small> Tipo de
                        Resposta</label>
                    <input type="text" id="tipo_resposta" name="tipo_resposta" class="form-control" required>
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

<?= form_open(admin_url('gestao_engajamento_talentos/editar_pergunta_engajamento'), array('method' => 'post', 'id' => 'form_edit_pergunta_engajamento')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar Pergunta de Engajamento</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="e_pesquisa"><small class="req text-danger">*</small> Pesquisa</label>
                    <select name="e_pesquisa" id="e_pesquisa" class="selectpicker" data-live-search="true"
                        data-width="100%" data-none-selected-text="<?php echo _l('Pesquisa'); ?>">
                        <option value=""></option>
                        <?php foreach($pesquisa_engajamento as $item) : ?>
                        <option value="<?= $item['id'] ?>"><?= $item['titulo'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="e_texto"><small class="req text-danger">*</small>
                        Texto</label>
                    <input type="text" id="e_texto" name="e_texto" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="e_tipo_resposta"><small class="req text-danger">*</small> Tipo de
                        Resposta</label>
                    <input type="text" id="e_tipo_resposta" name="e_tipo_resposta" class="form-control" required>
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
$('.btn_edit_pergunta_engajamento').click(function() {
    let pesquisa = $(this).attr('data-pesquisa');
    let texto = $(this).attr('data-texto');
    let tipo_resposta = $(this).attr('data-tipo_resposta');

    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_engajamento_talentos/editar_pergunta_engajamento') ?>/" + id;
    $('#form_edit_pergunta_engajamento').attr('action', url);

    $('select[name="e_pesquisa"]').selectpicker('val', pesquisa);
    $('input[name="e_texto"]').val(texto);
    $('input[name="e_tipo_resposta"]').val(tipo_resposta);

    $('#editar').modal('show');
})
$('#f_pesquisa').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(0).search(this.value).draw();
})
</script>