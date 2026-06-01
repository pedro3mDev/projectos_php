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
                    Plano de Sucessão e Liderança / Analise Risco
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
                                    Análise de Riscos de Sucessão
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
                                    Novo Risco de Sucessão
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/analise_risco_impacto')?>"
                                    class="btn" style="background-color: #FFD700; border-color: #FFD700; color: white;">
                                    <i class="fa-regular "></i>
                                    Impacto
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/matriz_risco')?>"
                                    class="btn" style="background-color: #800000; border-color: #800000; color: white;">
                                    <i class="fa-regular "></i>
                                    Matriz de Risco 
                                </a>

                            </div>

                        </div>
                        <br><br>
                        <div class="row">
                            <div class=" col-md-3">
                            </div>
                            <div class=" col-md-3">
                                <select name="cargo_f" id="cargo_f" class="selectpicker" multiple="true"
                                    data-live-search="true" data-width="100%"
                                    data-none-selected-text="<?php echo _l('Cargo'); ?>">
                                    <option value=""></option>
                                    <?php foreach ($cargos as $t) : ?>
                                    <option value="<?= $t['position_name'] ?>"><?= $t['position_name'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class=" col-md-3">
                                <select name="nivel_risco_f" id="nivel_risco_f" class="selectpicker" multiple="true"
                                    data-live-search="true" data-width="100%"
                                    data-none-selected-text="<?php echo _l('Nivel de Risco'); ?>">
                                    <option value=""></option>
                                    <?php foreach ($nivel_risco as $t) : ?>
                                    <option value="<?= $t['nome'] ?>"><?= $t['nome'] ?>
                                    </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class=" col-md-3">
                                <select name="impacto_f" id="impacto_f" class="selectpicker" multiple="true"
                                    data-live-search="true" data-width="100%"
                                    data-none-selected-text="<?php echo _l('impacto'); ?>">
                                    <option value=""></option>
                                    <?php foreach ($impacto as $t) : ?>
                                    <option value="<?= $t['nome'] ?>"><?= $t['nome'] ?>
                                    </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <br><br>
                        <table class="table table-hover table-bordered table-responsive dt-table">
                            <thead class="thead-custom">
                                <th>Cargo</th>
                                <th>Nivel de Risco</th>
                                <th>Impacto</th>
                                <th>Plano de Contingência</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach($risco_sucessao as $item) : ?>
                                <tr>
                                    <td class="text-capitalize"> <?= htmlspecialchars($item['cargo']); ?> </td>
                                    <td class="text-capitalize"> <?= htmlspecialchars($item['nivel_risco']); ?> </td>
                                    <td class="text-capitalize"> <?= htmlspecialchars($item['impacto']); ?> </td>
                                    <td class="text-capitalize"> <?= htmlspecialchars($item['plano_contingencia']); ?>
                                    </td>
                                    <td>
                                    <a href="<?php echo admin_url('plan_sucess_lideranca/analise_visualizar_analise/'.$item['id'])?>"
                                            data-id="" class="btn btn-sucess btn-icon btn_edit_orcamento"
                                            style="background-color: #3CB371; border-color: #3CB371; color: white;">
                                            <i style="color:#fff;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?= $item['id'] ?>"
                                            data-cargo="<?= html_entity_decode($item['cargo_id']) ?>"
                                            data-nivel_risco="<?= html_entity_decode($item['nivel_risco_id']) ?>"
                                            data-impacto="<?= html_entity_decode($item['impacto_id']) ?>"
                                            data-plano_contigencia='<?= html_entity_decode($item["plano_contingencia"]) ?>'
                                            class="btn btn-default btn-icon btn_edit_risco_sucessao"
                                            style="background-color: #007bff; border-color: #007bff; color: white;">
                                            <i style="color:#fff;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certeza que desejas eliminar?');"
                                            href="<?php echo admin_url('plan_sucess_lideranca/risco_sucessao_delete/'.$item['id'])?>"
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
        <?= form_open(admin_url('plan_sucess_lideranca/adicionar_risco_sucessao'), array('method' => 'post')) ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">
                    Novo Risco de Sucessão
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="cargo" class="control-label">
                                Cargo <small class="req text-danger">*</small>
                            </label>
                            <select class="form-control" name="cargo">
                                <option value=""></option>
                                <?php foreach ($cargos as $t) : ?>
                                <option value="<?= $t['position_id'] ?>"><?= $t['position_name'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nivel_risco" class="control-label">
                                Nivel de Risco <small class="req text-danger">*</small>
                            </label>
                            <select class="form-control" name="nivel_risco">
                                <option value=""></option>
                                <?php foreach ($nivel_risco as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['nome'] ?>
                                </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="impacto" class="control-label">
                                Impacto <small class="req text-danger">*</small>
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
                            <label for="plano_contingencia" class="control-label">
                                Plano de Contingência
                                <small class="req text-danger">*</small>
                            </label>
                            <textarea class="form-control" name="plano_contingencia" id="plano_contingencia" rows="4"
                                placeholder="Descreva o plano de contingência"></textarea>
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
            <?= form_close() ?>
        </div>
    </div>
</div>

<?= form_open(admin_url('plan_sucess_lideranca/editar_risco_sucessao'), array('method' => 'post', 'id' => 'form_edit_risco_sucessao')) ?>
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
                            <label for="cargo" class="control-label">
                                Cargo <small class="req text-danger">*</small>
                            </label>
                            <select class="form-control" name="e_cargo">
                                <option value=""></option>
                                <?php foreach ($cargos as $t) : ?>
                                <option value="<?= $t['position_id'] ?>"><?= $t['position_name'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nivel_risco" class="control-label">
                                Nivel de Risco <small class="req text-danger">*</small>
                            </label>
                            <select class="form-control" name="e_nivel_risco">
                                <option value=""></option>
                                <?php foreach ($nivel_risco as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['nome'] ?>
                                </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="impacto" class="control-label">
                                Impacto <small class="req text-danger">*</small>
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
                            <label for="plano_contingencia" class="control-label">
                                Plano de Contingência
                                <small class="req text-danger">*</small>
                            </label>
                            <textarea class="form-control" name="e_plano_contingencia" id="plano_contingencia" rows="4"
                                placeholder="Descreva o plano de contingência"></textarea>
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
$('.btn_edit_risco_sucessao').click(function() {
    let cargo = $(this).attr('data-cargo');
    let nivel_risco = $(this).attr('data-nivel_risco');
    let impacto = $(this).attr('data-impacto');
    let plano_contigencia = $(this).attr('data-plano_contigencia');

    let id = $(this).attr('data-id');

    let url = "<?= admin_url('plan_sucess_lideranca/editar_risco_sucessao') ?>/" + id;
    $('#form_edit_risco_sucessao').attr('action', url);

    $('select[name="e_cargo"]').selectpicker('val', cargo);
    $('select[name="e_nivel_risco"]').selectpicker('val', nivel_risco);
    $('select[name="e_impacto"]').selectpicker('val', impacto);
    $('textarea[name="e_plano_contingencia"]').text(plano_contigencia);

    $('#editar').modal('show');
})
$('#cargo_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(0).search(this.value).draw();
})
$('#nivel_risco_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(1).search(this.value).draw();
})
$('#impacto_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(2).search(this.value).draw();
})
</script>