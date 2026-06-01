<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_remuneracao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Engajamento de Talentos / Programas / Prêmio
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
                                    Prêmio
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Novo Prêmio
                                </a>
                                <a href="<?php echo admin_url('gestao_engajamento_talentos/programas')?>" class="btn"
                                    style="background-color: #3CB371; border-color: #3CB371; color: white;">
                                    <i class="fa-regular "></i>
                                    Reconhecimento
                                </a>
                                <a href="<?php echo admin_url('gestao_engajamento_talentos/programas_resgate')?>"
                                    class="btn" style="background-color: #C0392B; border-color: #C0392B; color: white;">
                                    <i class="fa-regular "></i>
                                    Resgate de Prêmio
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
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Pontos Necessários</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach($premio as $item) : ?>
                                <tr>
                                    <td><?= html_entity_decode($item['nome'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['descricao'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['pontos_necessario'] ?? '') ?></td>
                                    <td>
                                        <a href="<?php echo admin_url('gestao_engajamento_talentos/programas_visualizar_premio/'.$item['id']) ?>"
                                            class="btn btn-sucess btn-icon"
                                            style="background-color: #3CB371; border-color: #3CB371; color: white;">
                                            <i style="color:#fff;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?= html_entity_decode($item['id'] ?? '') ?>"
                                            data-nome="<?= html_entity_decode($item['nome'] ?? '') ?>"
                                            data-descricao="<?= html_entity_decode($item['descricao'] ?? '') ?>"
                                            data-pontos_necessario="<?= html_entity_decode($item['pontos_necessario'] ?? '') ?>"
                                            class="btn btn-default btn-icon btn_edit_premio"
                                            style="background-color: #007bff; border-color: #007bff; color: white;">
                                            <i style="color:#fff;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas eliminar este Prêmio?');"
                                            href="<?php echo admin_url('gestao_engajamento_talentos/delete_premio/'.$item['id']) ?>"
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
        <?php echo form_open(admin_url('gestao_engajamento_talentos/add_premio'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Novo Prêmio</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="nome"><small class="req text-danger">*</small> Nome</label>
                    <input type="text" id="nome" name="nome" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="descricao"><small class="req text-danger">*</small> Descrição</label>
                    <textarea id="descricao" name="descricao" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="pontos_necessario"><small class="req text-danger">*</small> Pontos Necessários</label>
                    <input type="number" id="pontos_necessario" name="pontos_necessario" class="form-control" step="1"
                        required>
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

<?= form_open_multipart(admin_url('gestao_engajamento_talentos/editar_premio/0'), array('method' => 'post', 'id' => 'form_edit_premio')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Editar Prêmio</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="e_nome"><small class="req text-danger">*</small> Nome</label>
                    <input type="text" id="e_nome" name="e_nome" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="e_descricao"><small class="req text-danger">*</small> Descrição</label>
                    <textarea id="e_descricao" name="e_descricao" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="e_pontos_necessario"><small class="req text-danger">*</small> Pontos Necessários</label>
                    <input type="number" id="e_pontos_necessario" name="e_pontos_necessario" class="form-control"
                        step="1" required>
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
$('.btn_edit_premio').click(function() {
    let nome = $(this).attr('data-nome');
    let descricao = $(this).attr('data-descricao');
    let pontos_necessario = $(this).attr('data-pontos_necessario');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_engajamento_talentos/editar_premio') ?>/" + id;
    $('#form_edit_premio').attr('action', url);

    $('input[name="e_nome"]').val(nome);
    $('textarea[name="e_descricao"]').text(descricao);
    $('input[name="e_pontos_necessario"]').val(pontos_necessario);

    $('#editar').modal('show');
})
$('#estado_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(4).search(this.value).draw();
})
</script>