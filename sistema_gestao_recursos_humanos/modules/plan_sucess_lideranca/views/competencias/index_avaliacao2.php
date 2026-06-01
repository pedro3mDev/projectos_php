<?php init_head(); ?>
<div id="wrapper">
    <div class="content">

        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Plano de Sucessão e Liderança / Avaliação de Competências
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
                                <h4 class="font-bold no-margin">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Avaliação de Competências
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">

                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white; ">
                                    <i class="fa-regular "></i>
                                    Nova Avaliação
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/competencias')?>" class="btn"
                                    style="background-color: #DAA520; border-color: #DAA520; color: white;">
                                    <i class="fa-regular "></i>
                                    Gestão de Competências
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/competencias_aquisicao')?>"
                                    class="btn" style="background-color: #b91c1c; border-color: #b91c1c; color: white;">
                                    <i class="fa-regular "></i>
                                    Plano de Aquisição de Competência
                                </a>
                            </div>

                        </div>
                        <div class="row">
                            <div class=" col-md-9">
                            </div>
                            <div class=" col-md-3">
                                <select name="potencial_f" id="potencial_f" class="selectpicker" multiple="true"
                                    data-live-search="true" data-width="100%"
                                    data-none-selected-text="<?php echo _l('Potencial'); ?>">
                                    <option value=""></option>
                                    <?php foreach($potencial as $p) : ?>
                                    <option value="<?= $p['nome'] ?>"><?= $p['nome'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <br><br>
                        <table class="table table-hover table-bordered table-responsive dt-table">
                            <thead class="thead-custom">
                                <th>Funcionário</th>
                                <th>Nota</th>
                                <th>Competencia</th>
                                <th>Potencial</th>
                                <th>Data de Avaliação</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach($avaliacao_nivel as $item) : ?>
                                <tr>
                                    <td class="text-capitalize">
                                        <?= htmlspecialchars($item['firstname'] .' '.$item['lastname']); ?> </td>
                                    <td class="text-capitalize"> <?= htmlspecialchars($item['nota']); ?> </td>
                                    <td class="text-capitalize"> <?= htmlspecialchars($item['competencia']); ?> </td>
                                    <td class="text-capitalize"> <?= htmlspecialchars($item['potencial']); ?> </td>
                                    <td class="text-capitalize"> <?= htmlspecialchars($item['data_avaliacao']); ?> </td>
                                    <td>
                                    <a href="<?php echo admin_url('plan_sucess_lideranca/competencias_visualizar_avaliacao/'.$item['id'])?>" data-id="" class="btn btn-sucess btn-icon btn_edit_orcamento"
                                            style="background-color: #3CB371; border-color: #3CB371; color: white;">
                                            <i style="color:#fff;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?= $item['id'] ?>"
                                            data-avaliacao_competencia="<?= html_entity_decode($item['avaliacao_competencia_id']) ?>"
                                            data-potencial="<?= html_entity_decode($item['potencial_id']) ?>"
                                            class="btn btn-default btn-icon btn_edit_avaliacao_nivel"
                                            style="background-color: #007bff; border-color: #007bff; color: white;">
                                            <i style="color:#fff;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certeza que desejas eliminar?');"
                                            href="<?php echo admin_url('plan_sucess_lideranca/avaliacao_nivel_delete/'.$item['id'])?>"
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
        <?= form_open(admin_url('plan_sucess_lideranca/adicionar_avaliacao_nivel'), array('method' => 'post')) ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Nova Avaliação</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="avaliacao_competencias" class="control-label">
                                <?php echo _l('avaliacao_competencias'); ?> <small class="req text-danger">*</small>
                            </label>
                            <select name="avaliacao_competencias" id="avaliacao_competencias" class="selectpicker"
                                data-live-search="true" data-width="100%"
                                data-none-selected-text="<?php echo _l('avaliacao_competencias'); ?>">
                                <option value=""></option>
                                <?php foreach ($avaliacao_competencias as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['firstname'] .' '.$t['lastname'] ?> - Nota:
                                    <?= $t['nota'] ?> - Data:
                                    <?= $t['data_avaliacao'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <?php
                            echo render_select('potencial', $potencial, ['id', ['nome']], 'Potencial<span class="text-danger">*</span>', '', [], [], '', '', true);
                            ?>
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

<?= form_open(admin_url('plan_sucess_lideranca/editar_avaliacao_nivel'), array('method' => 'post', 'id' => 'form_edit_avaliacao_nivel')) ?>
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
                            <label for="e_avaliacao_competencias" class="control-label">
                                <?php echo _l('avaliacao_competencias'); ?> <small class="req text-danger">*</small>
                            </label>
                            <select name="e_avaliacao_competencias" id="e_avaliacao_competencias" class="selectpicker"
                                data-live-search="true" data-width="100%"
                                data-none-selected-text="<?php echo _l('avaliacao_competencias'); ?>">
                                <option value=""></option>
                                <?php foreach ($avaliacao_competencias as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['firstname'] .' '.$t['lastname'] ?> - Nota:
                                    <?= $t['nota'] ?> - Data:
                                    <?= $t['data_avaliacao'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <?php
                            echo render_select('e_potencial', $potencial, ['id', ['nome']], 'Potencial<span class="text-danger">*</span>', '', [], [], '', '', true);
                            ?>
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
$('.btn_edit_avaliacao_nivel').click(function() {
    let avaliacao_competencias = $(this).attr('data-avaliacao_competencia');
    let potencial = $(this).attr('data-potencial');

    let id = $(this).attr('data-id');

    let url = "<?= admin_url('plan_sucess_lideranca/editar_avaliacao_nivel') ?>/" + id;
    $('#form_edit_avaliacao_nivel').attr('action', url);

    $('select[name="e_avaliacao_competencias"]').selectpicker('val', avaliacao_competencias);
    $('select[name="e_potencial"]').selectpicker('val', potencial);

    $('#editar').modal('show');
})
$('#potencial_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(3).search(this.value).draw();
})
</script>