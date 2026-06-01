<?php init_head(); ?>
<div id="wrapper">
    <div class="content">

        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Plano de Sucessão e Liderança / Programa de Retenção
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
                                    Programa de Retenção
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">

                            <div class=" col-md-12">
                                <a href="<?php echo admin_url('plan_sucess_lideranca/engajamento_resultado')?>"
                                    class="btn" style="background-color: #2E8B57; border-color: #2E8B57; color: white;">
                                    <i class="fa-regular "></i>
                                    Resultado
                                </a>
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white; ">
                                    <i class="fa-regular "></i>
                                    Novo Programa
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/engajamento')?>" class="btn"
                                    style="background-color: #DAA520; border-color: #DAA520; color: white;">
                                    <i class="fa-regular "></i>
                                    Estrategia de Engajamento
                                </a>
                            </div>
                        </div>
                        <br><br>
                        <table class="table table-hover table-bordered table-responsive dt-table">
                            <thead class="thead-custom">
                                <th>Funcionário</th>
                                <th>Benefícios</th>
                                <th>Feedback</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach($programa_retencao as $item) : ?>
                                <tr>
                                    <td class="text-capitalize">
                                        <?= htmlspecialchars($item['firstname'] .' '.$item['lastname']); ?> </td>
                                    <td class="text-capitalize"> <?= htmlspecialchars($item['beneficio']); ?> </td>
                                    <td class="text-capitalize"> <?= htmlspecialchars($item['feedback']); ?>
                                    </td>
                                    <td>
                                    <a href="<?php echo admin_url('plan_sucess_lideranca/engajamento_visualizar_programa/'.$item['id'])?>"
                                            class="btn btn-sucess btn-icon"
                                            style="background-color: #3CB371; border-color: #3CB371; color: white;">
                                            <i style="color:#fff;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?= $item['id'] ?>"
                                            data-estrategia_engajamento="<?= html_entity_decode($item['estrategia_engajamento_id']) ?>"
                                            data-beneficio="<?= html_entity_decode($item['beneficio']) ?>"
                                            data-feedback='<?= html_entity_decode($item["feedback"]) ?>'
                                            class="btn btn-default btn-icon btn_edit_programa_retencao"
                                            style="background-color: #007bff; border-color: #007bff; color: white;">
                                            <i style="color:#fff;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certeza que desejas eliminar?');"
                                            href="<?php echo admin_url('plan_sucess_lideranca/programa_retencao_delete/'.$item['id'])?>"
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
        <?= form_open(admin_url('plan_sucess_lideranca/adicionar_programa_retencao'), array('method' => 'post')) ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Novo Programa</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="company" class="control-label">
                                <?php echo _l('Engajamento de Talentos'); ?> <small class="req text-danger">*</small>
                            </label>
                            <select name="estrategia_engajamento" id="estrategia_engajamento" class="selectpicker"
                                data-live-search="true" data-width="100%"
                                data-none-selected-text="<?php echo _l('estrategia_engajamento'); ?>">
                                <option value=""></option>
                                <?php foreach ($estrategia_engajamento as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['firstname'] .' '. $t['lastname'] ?> -
                                    Estrategia: <?= $t['estrategia'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="beneficios_oferecidos" class="control-label">
                                Benefícios Oferecidos
                                <small class="req text-danger">*</small>
                            </label>
                            <textarea class="form-control" name="beneficio" id="beneficios_oferecidos" rows="4"
                                placeholder="Descreva os benefícios oferecidos"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="feedback" class="control-label">
                                Feedback
                                <small class="req text-danger">*</small>
                            </label>
                            <textarea class="form-control" name="feedback" id="feedback" rows="4"
                                placeholder="Digite o feedback"></textarea>
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

<?= form_open(admin_url('plan_sucess_lideranca/editar_programa_retencao'), array('method' => 'post', 'id' => 'form_edit_programa_retencao')) ?>
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
                            <label for="company" class="control-label">
                                <?php echo _l('Engajamento de Talentos'); ?> <small class="req text-danger">*</small>
                            </label>
                            <select name="e_estrategia_engajamento" id="e_estrategia_engajamento" class="selectpicker"
                                data-live-search="true" data-width="100%"
                                data-none-selected-text="<?php echo _l('estrategia_engajamento'); ?>">
                                <option value=""></option>
                                <?php foreach ($estrategia_engajamento as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['firstname'] .' '. $t['lastname'] ?> -
                                    Estrategia: <?= $t['estrategia'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="beneficios_oferecidos" class="control-label">
                                Benefícios Oferecidos
                                <small class="req text-danger">*</small>
                            </label>
                            <textarea class="form-control" name="e_beneficio" id="beneficios_oferecidos" rows="4"
                                placeholder="Descreva os benefícios oferecidos"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="feedback" class="control-label">
                                Feedback
                                <small class="req text-danger">*</small>
                            </label>
                            <textarea class="form-control" name="e_feedback" id="feedback" rows="4"
                                placeholder="Digite o feedback"></textarea>
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
$('.btn_edit_programa_retencao').click(function() {
    let estrategia_engajamento = $(this).attr('data-estrategia_engajamento');
    let beneficio = $(this).attr('data-beneficio');
    let feedback = $(this).attr('data-feedback');

    let id = $(this).attr('data-id');

    let url = "<?= admin_url('plan_sucess_lideranca/editar_programa_retencao') ?>/" + id;
    $('#form_edit_programa_retencao').attr('action', url);

    $('select[name="e_estrategia_engajamento"]').selectpicker('val', estrategia_engajamento);
    $('textarea[name="e_beneficio"]').text(beneficio);
    $('textarea[name="e_feedback"]').text(feedback);

    $('#editar').modal('show');
})
</script>