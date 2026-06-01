<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <?php
            $data_view = [];
            $this->load->view('/admin/menu_modulo/menu', $data_view);
        ?>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Plano de Sucessão e Liderança / Planejamento
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
                                <h4 class="font-bold no-margin"><i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Posição Chave
                                </h4>
                                <hr />
                            </div>
                        </div>
                        </br>
                        <div class="row">
                        <div class="col-md-12">
                                <a href="<?php echo admin_url('plan_sucess_lideranca/planeamento_resultado')?>"
                                    class="btn btn-success" style="color: white;">
                                    <i class="fa-regular "></i>
                                    Resultados 
                                </a>
                                <a href="#" data-toggle="modal" data-target="#modal_add_posicao_chave" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Adicionar Posição Chave
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/planeamento')?>" class="btn"
                                    style="background-color: #DAA520; border-color: #FFD700; color: white;">
                                    <i class="fa-regular "></i>
                                    Mapa de Sucessão
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/plano_desenvolvimento')?>"
                                    class="btn" style="background-color: #b45309; border-color: #b45309; color: white;">
                                    <i class="fa-regular "></i>
                                    Plano de Desenvolvimento
                                </a>
                            </div>
                            <div class=" col-md-9">
                            </div>
                            <div class=" col-md-3">
                                <select name="nivel_critico_pc_f" id="nivel_critico_pc_f" class="selectpicker"
                                    multiple="true" data-live-search="true" data-width="100%"
                                    data-none-selected-text="<?php echo _l('nivel_critico'); ?>">
                                    <?php foreach($nivel_critico as $s) { ?>
                                    <option value="<?php echo new_html_entity_decode($s['nome']); ?>">
                                        <?php echo new_html_entity_decode($s['nome']); ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <br><br>
                        <table class="table dt-table">
                            <thead class="thead-custom">
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Nivel Crítico</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($posicao_chave as $item) {
                                ?>
                                <tr>
                                    <td class="text-capitalize"> <?= htmlspecialchars($item['nome']); ?> </td>
                                    <td class="text-capitalize"> <?= htmlspecialchars($item['descricao']); ?> </td>
                                    <td class="text-capitalize"> <?= htmlspecialchars($item['nivel_critico']); ?> </td>
                                    <td>
                                    <a href="<?php echo admin_url('plan_sucess_lideranca/planeamento_visualizar_posicao/'.$item['id'])?>" class="btn btn-success btn-icon">
                                                    <i style="color: white;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?= $item['id'] ?>"
                                            data-nome="<?= html_entity_decode($item['nome']) ?>"
                                            data-nivel_critico="<?= html_entity_decode($item['nivel_critico_id']) ?>"
                                            data-descricao="<?= html_entity_decode($item['descricao']) ?>"
                                            class="btn btn-default btn-icon btn_edit_posicao_chave"
                                            style="background-color: #007bff; border-color: #007bff;">
                                            <i style="color: white;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas eliminar este Posição Chave?');"
                                            href="<?php echo admin_url('plan_sucess_lideranca/posicao_chave_delete/'.$item['id']); ?>"
                                            class="btn btn-danger btn-icon _delete">
                                            <i style="color: white;" class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
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

<div class="modal" id="modal_add_posicao_chave" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <?= form_open(admin_url('plan_sucess_lideranca/adicionar_posicao_chave'), array('method' => 'post')) ?>
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Adicionar Posicão Chave
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <?php echo render_input('nome','Nome<small class="req text-danger">*</small>'); ?>
                        </div>
                        <div class="form-group">
                            <?php echo render_textarea('descricao','Descrição<small class="req text-danger">*</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="company" class="control-label">
                                Nivel Crítico <small class="req text-danger">*</small>
                            </label>
                            <select class="form-control" name="nivel_critico">
                                <option value=""></option>
                                <?php foreach ($nivel_critico as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['nome'] ?>
                                </option>
                                <?php endforeach ?>
                            </select>
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
<?= form_open(admin_url('plan_sucess_lideranca/editar_posicao_chave'), array('method' => 'post', 'id' => 'form_edit_posicao_chave')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Editar Posicão Chave </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <?php echo render_input('e_nome','Nome<small class="req text-danger">*</small>'); ?>
                        </div>
                        <div class="form-group">
                            <?php echo render_textarea('e_descricao','Descrição<small class="req text-danger">*</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="company" class="control-label">
                                Nivel Crítico <small class="req text-danger">*</small>
                            </label>
                            <select class="form-control" name="e_nivel_critico">
                                <option value=""></option>
                                <?php foreach ($nivel_critico as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['nome'] ?>
                                </option>
                                <?php endforeach ?>
                            </select>
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
$('.btn_edit_posicao_chave').click(function() {
    let nome = $(this).attr('data-nome');
    let descricao = $(this).attr('data-descricao');
    let nivel_critico = $(this).attr('data-nivel_critico');

    let id = $(this).attr('data-id');

    let url = "<?= admin_url('plan_sucess_lideranca/editar_posicao_chave') ?>/" + id;
    $('#form_edit_posicao_chave').attr('action', url);

    $('input[name="e_nome"]').val(nome);
    $('textarea[name="e_descricao"]').text(descricao);
    $('select[name="e_nivel_critico"]').val(nivel_critico);

    $('#editar').modal('show');
})
$('#nivel_critico_pc_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(2).search(this.value).draw();
})
</script>