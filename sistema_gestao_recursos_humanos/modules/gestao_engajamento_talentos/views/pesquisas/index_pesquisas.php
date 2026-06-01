<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_remuneracao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Engajamento de Talentos / Pesquisas / Pesquisa de Engajamento
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
        <?php require 'modules/gestao_engajamento_talentos/views/pesquisas/cards.php'; ?>
        </br>

        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Pesquisa de Engajamento
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff ; color: white;">
                                    <i class="fa-regular "></i>
                                    Nova Pesquisa
                                </a>
                                <a href="<?php echo admin_url('gestao_engajamento_talentos/pesquisas_pergunta_engajamento')?>"
                                    class="btn" style="background-color: #DAA520; border-color: #DAA520; color: white;">
                                    <i class="fa-regular "></i>
                                    Pergunta de Engajamento
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
                            <div class="col-md-9">
                            </div>
                            <div class="col-md-3">
                                <select name="estado_f" id="estado_f" class="selectpicker" data-live-search=" true"
                                    data-width="100%" data-none-selected-text="<?php echo _l('Estado'); ?>">
                                    <option value=""></option>
                                    <?php foreach($status as $item) : ?>
                                    <option value="<?= $item['status'] ?>"><?= $item['status'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <br><br>
                        <table class="table table-hover table-bordered table-responsive dt-table">
                            <thead class="thead-custom">
                                <th>Título</th>
                                <th>Descrição</th>
                                <th>Data de Criação</th>
                                <th>Data de Fim</th>
                                <th>Estado</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach($pesquisa_engajamento as $item) : ?>
                                <tr>
                                    <td><?= html_entity_decode($item['titulo'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['descricao'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['data_criacao'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['data_fim'] ?? '') ?></td>
                                    <td>
                                        <?php
                                            $cor = "#999"; // Cor padrão (cinza para pendente)
                                            if ($item['status_id'] == 2) {
                                                $cor = "green";
                                            } elseif ($item['status_id'] == 3) {
                                                $cor = "red";
                                            }
                                        ?>
                                        <a
                                            style="background-color: <?= $cor ?>; color:#fff; padding: 5px; border-radius:10px;">
                                            <?= html_entity_decode($item['status'] ?? '') ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php if ($item['status_id'] == 1) : ?>
                                        <a href="<?php echo admin_url('gestao_engajamento_talentos/pesquisa_engajamento_aprovar/'.$item['id']); ?>"
                                            class="btn btn-success" style="color: white;">
                                            Aprovar
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas rejeitar?');"
                                            href="<?php echo admin_url('gestao_engajamento_talentos/pesquisa_engajamento_rejeitar/'.$item['id']); ?>"
                                            class="btn btn-danger" style="color: white;">
                                            Rejeitar
                                        </a>
                                        <?php endif ?>
                                        <a href="<?php echo admin_url('gestao_engajamento_talentos/pesquisas_visualizar_pesquisa/'.$item['id'])?>"
                                            class="btn btn-sucess btn-icon"
                                            style="background-color: #3CB371; border-color: #3CB371; color: white;">
                                            <i style="color:#fff;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?= $item['id'] ?>"
                                            data-titulo="<?= html_entity_decode($item['titulo'] ?? '') ?>"
                                            data-descricao="<?= html_entity_decode($item['descricao'] ?? '') ?>"
                                            data-data_criacao="<?= html_entity_decode($item['data_criacao'] ?? '') ?>"
                                            data-data_fim="<?= html_entity_decode($item['data_fim'] ?? '') ?>"
                                            data-aprovadores='<?= html_entity_decode(($item["aprovadores"] ?? "")) ?>'
                                            class="btn btn-default btn-icon btn_edit_pesquisa_engajamento"
                                            style="background-color: #007bff; border-color: #007bff; color: white;">
                                            <i style="color:#fff;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas eliminar esta Pesquisa de Engajamento?');"
                                            href="<?php echo admin_url('gestao_engajamento_talentos/delete_pesquisa_engajamento/'.$item['id']); ?>"
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
        <?php echo form_open(admin_url('gestao_engajamento_talentos/add_pesquisa_engajamento'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Nova Pesquisa</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="titulo"><small class="req text-danger">*</small> Título</label>
                    <input type="text" id="titulo" name="titulo" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="descricao"><small class="req text-danger">*</small> Descrição</label>
                    <textarea id="descricao" name="descricao" class="form-control" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="data_criacao"><small class="req text-danger">*</small> Data de Criação</label>
                    <input type="date" id="data_criacao" name="data_criacao" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="data_fim"><small class="req text-danger">*</small> Data de Fim</label>
                    <input type="date" id="data_fim" name="data_fim" class="form-control" required>
                </div>
                <div class="form-group">
                    <?php
                    $selectedStaff = '';
                    echo render_select('aprovadores[]', $staff_list, ['staffid', ['firstname', 'lastname']], 'Aprovadores<span class="text-danger">*</span>', $selectedStaff, ['multiple' => true], [], '', '', false);
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

<?= form_open(admin_url('gestao_engajamento_talentos/editar_pesquisa_engajamento'), array('method' => 'post', 'id' => 'form_edit_pesquisa_engajamento')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar Pesquisa de Engajamento</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="e_titulo"><small class="req text-danger">*</small> Título</label>
                    <input type="text" id="e_titulo" name="e_titulo" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="e_descricao"><small class="req text-danger">*</small> Descrição</label>
                    <textarea id="e_descricao" name="e_descricao" class="form-control" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="e_data_criacao"><small class="req text-danger">*</small> Data de Criação</label>
                    <input type="date" id="e_data_criacao" name="e_data_criacao" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="e_data_fim"><small class="req text-danger">*</small> Data de Fim</label>
                    <input type="date" id="e_data_fim" name="e_data_fim" class="form-control" required>
                </div>
                <div class="form-group">
                    <?php
                    $selectedStaff = '';
                    echo render_select('e_aprovadores[]', $staff_list, ['staffid', ['firstname', 'lastname']], 'Aprovadores<span class="text-danger">*</span>', $selectedStaff, ['multiple' => true], [], '', '', false);
                    ?>
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
$('.btn_edit_pesquisa_engajamento').click(function() {
    let titulo = $(this).attr('data-titulo');
    let descricao = $(this).attr('data-descricao');
    let data_criacao = $(this).attr('data-data_criacao');
    let data_fim = $(this).attr('data-data_fim');
    let aprovadores = $(this).attr('data-aprovadores');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_engajamento_talentos/editar_pesquisa_engajamento') ?>/" + id;
    $('#form_edit_pesquisa_engajamento').attr('action', url);

    $('input[name="e_titulo"]').val(titulo);
    $('textarea[name="e_descricao"]').text(descricao);
    $('input[name="e_data_criacao"]').val(data_criacao);
    $('input[name="e_data_fim"]').val(data_fim);
    $('select[name="e_aprovadores[]"]').selectpicker('val', JSON.parse(aprovadores));

    $('#editar').modal('show');
})
$('#estado_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(4).search(this.value).draw();
})
</script>