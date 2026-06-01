<?php init_head(); ?>
<div id="wrapper">
    <div class="content">

        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Plano de Sucessão e Liderança / Impacto de Perda de Talento
                </a>
            </div>
            <div class="col-md-2" style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
            </div>
        </div>

        </br>
        <!--?php require 'modules/plan_sucess_lideranca/views/identificacao/cards.php'; ? -->


        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Impacto de Perda de Talento
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">

                            <div class=" col-md-12">
                                <a href="<?php echo admin_url('plan_sucess_lideranca/analise_risco_resultado')?>"
                                    class="btn" style="background-color: #2E8B57; border-color: #2E8B57; color: white;">
                                    <i class="fa-regular "></i>
                                    Resultado
                                </a>
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white; ">
                                    <i class="fa-regular "></i>
                                    Novo Impacto
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/analise_risco')?>" class="btn"
                                    style="background-color: #4B0082; border-color: #4B0082; color: white;">
                                    <i class="fa-regular "></i>
                                    Risco
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/matriz_risco')?>"
                                    class="btn" style="background-color: #800000; border-color: #800000; color: white;">
                                    <i class="fa-regular "></i>
                                    Matriz de Risco 
                                </a>
                            </div>

                        </div>
                        <div class="row">
                            <div class=" col-md-6">
                            </div>
                            <div class=" col-md-3">
                                <select name="estado_f" id="estado_f" class="selectpicker" multiple="true"
                                    data-live-search="true" data-width="100%"
                                    data-none-selected-text="<?php echo _l('Estado'); ?>">
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class=" col-md-3">
                                <select name="estado_f" id="estado_f" class="selectpicker" multiple="true"
                                    data-live-search="true" data-width="100%"
                                    data-none-selected-text="<?php echo _l('Competencia'); ?>">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <br><br>
                        <table class="table table-hover table-bordered table-responsive dt-table">
                            <thead class="thead-custom">
                                <th>Funcionário</th>
                                <th>Impacto</th>
                                <th>Sugestão de Mitigação</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach($impacto_perda_talento as $item) : ?>
                                <tr>
                                    <td class="text-capitalize">
                                        <?= htmlspecialchars($item['firstname'] .' '.$item['lastname']); ?> </td>
                                    <td class="text-capitalize"> <?= htmlspecialchars($item['impacto']); ?> </td>
                                    <td class="text-capitalize"> <?= htmlspecialchars($item['sugestao_mitigacao']); ?>
                                    </td>
                                    <td>
                                    <a href="<?php echo admin_url('plan_sucess_lideranca/analise_visualizar_impacto/'.$item['id'])?>"
                                            data-id="" class="btn btn-sucess btn-icon btn_edit_orcamento"
                                            style="background-color: #3CB371; border-color: #3CB371; color: white;">
                                            <i style="color:#fff;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?= $item['id'] ?>"
                                            data-funcionario="<?= html_entity_decode($item['staff_id']) ?>"
                                            data-impacto="<?= html_entity_decode($item['impacto_id']) ?>"
                                            data-sugestao_mitigacao='<?= html_entity_decode($item["sugestao_mitigacao"]) ?>'
                                            class="btn btn-default btn-icon btn_edit_impacto_perda_talento"
                                            style="background-color: #007bff; border-color: #007bff; color: white;">
                                            <i style="color:#fff;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certeza que desejas eliminar?');"
                                            href="<?php echo admin_url('plan_sucess_lideranca/impacto_perda_talento_delete/'.$item['id'])?>"
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
    <div class="btn-bottom-pusher"></div>
</div>
</div>
<div id="new_version"></div>

<div class="modal" id="modal_add" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <?= form_open(admin_url('plan_sucess_lideranca/adicionar_impacto_perda_talento'), array('method' => 'post')) ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Novo Impacto</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <?php
                            $selectedStaff = '';
                            echo render_select('funcionario', $staffs, ['staffid', ['firstname', 'lastname']], 'Funcionário<span class="text-danger">*</span>', $selectedStaff, [], [], '', '', true);
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="impacto" class="control-label">
                                Impacto Organizacional <small class="req text-danger">*</small>
                            </label>
                            <select class="form-control" name="impacto">
                                <option value=""></option>
                                <?php foreach ($impacto as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['nome'] ?>
                                </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="sugestao_mitigacao" class="control-label">
                                Sugestão de Mitigação
                                <small class="req text-danger">*</small>
                            </label>
                            <textarea class="form-control" name="sugestao_mitigacao" id="sugestao_mitigacao" rows="4"
                                placeholder="Descreva a sugestão de mitigação"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <?php echo _l('Cancelar'); ?>
                </button>
                <button type="submit" class="btn btn-success">
                    <?php echo _l('submit'); ?>
                </button>
            </div>
        </div>
        <?= form_close() ?>
    </div>
</div>

<?= form_open(admin_url('plan_sucess_lideranca/editar_impacto_perda_talento'), array('method' => 'post', 'id' => 'form_edit_impacto_perda_talento')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Editar </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <?php
                            $selectedStaff = '';
                            echo render_select('e_funcionario', $staffs, ['staffid', ['firstname', 'lastname']], 'Funcionário<span class="text-danger">*</span>', $selectedStaff, [], [], '', '', true);
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="impacto" class="control-label">
                                Impacto Organizacional <small class="req text-danger">*</small>
                            </label>
                            <select class="form-control" name="e_impacto">
                                <option value=""></option>
                                <?php foreach ($impacto as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['nome'] ?>
                                </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="sugestao_mitigacao" class="control-label">
                                Sugestão de Mitigação
                                <small class="req text-danger">*</small>
                            </label>
                            <textarea class="form-control" name="e_sugestao_mitigacao" id="sugestao_mitigacao" rows="4"
                                placeholder="Descreva a sugestão de mitigação"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                    data-dismiss="modal"><?php echo _l('pl_close'); ?></button>
                <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
            </div>
        </div>
    </div>
</div>
<?= form_close()  ?>

<?php init_tail(); ?>
<script>
$('.btn_edit_impacto_perda_talento').click(function() {
    let funcionario = $(this).attr('data-funcionario');
    let impacto = $(this).attr('data-impacto');
    let sugestao_mitigacao = $(this).attr('data-sugestao_mitigacao');

    let id = $(this).attr('data-id');

    let url = "<?= admin_url('plan_sucess_lideranca/editar_impacto_perda_talento') ?>/" + id;
    $('#form_edit_impacto_perda_talento').attr('action', url);

    $('select[name="e_funcionario"]').selectpicker('val', funcionario);
    $('select[name="e_impacto"]').selectpicker('val', impacto);
    $('textarea[name="e_sugestao_mitigacao"]').text(sugestao_mitigacao);

    $('#editar').modal('show');
})
$('#estado_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(3).search(this.value).draw();
})
$('#competencia_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(1).search(this.value).draw();
})
</script>