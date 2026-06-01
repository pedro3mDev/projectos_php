<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Plano de Sucessão e Liderança / Avaliação de Liderança
                </a>
            </div>
            <div class="col-md-2" style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
            </div>
        </div>
        </br>
        <!--?php require 'modules/plan_sucess_lideranca/views/identificacao/cards.php'; ?-->
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Avaliação de Liderança
                                </h4>
                                <hr />
                            </div>
                        </div>

                        <div class="row">
                            <div class=" col-md-12">
                                <a href="<?php echo admin_url('plan_sucess_lideranca/desenvolvimento_resultado')?>"
                                    class="btn" style="background-color: #2E8B57; border-color: #2E8B57; color: white;">
                                    <i class="fa-regular "></i>
                                    Resultado
                                </a>
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white; ">
                                    <i class="fa-regular "></i>
                                    Nova Avaliação
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/desenvolvimento')?>" class="btn"
                                    style="background-color: #86198f; border-color: #86198f; color: white;">
                                    <i class="fa-regular "></i>
                                    Programa de Liderança
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/desenvolvimento_treinamento')?>"
                                    class="btn" style="background-color: #DAA520; border-color: #DAA520; color: white;">
                                    <i class="fa-regular "></i>
                                    Treinamento de Liderança
                                </a>
                            </div>
                        </div>

                        <div class="row">
                            <div class=" col-md-6">
                            </div>
                            <div class=" col-md-3">
                                <select name="feedback_f" id="feedback_f" class="selectpicker" multiple="true"
                                    data-live-search="true" data-width="100%"
                                    data-none-selected-text="<?php echo _l('Feedback'); ?>">
                                    <option value=""></option>
                                    <?php foreach ($feedback as $t) : ?>
                                    <option value="<?= $t['nome'] ?>"><?= $t['nome'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class=" col-md-3">
                                <select name="estado_f" id="estado_f" class="selectpicker" multiple="true"
                                    data-live-search="true" data-width="100%"
                                    data-none-selected-text="<?php echo _l('Estado'); ?>">
                                    <?php foreach($status as $s) { ?>
                                    <option value="<?php echo new_html_entity_decode($s['status']); ?>">
                                        <?php echo new_html_entity_decode($s['status']); ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <br><br>

                        <table class="table table-hover table-bordered table-responsive dt-table">
                            <thead class="thead-custom">
                                <th>Funcionário(Talento)</th>
                                <th>Programa</th>
                                <th>Carga Horária</th>
                                <th>Nota</th>
                                <th>Descrição</th>
                                <th>Feedback</th>
                                <th>Estado</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach($avaliacao_lideranca as $item) : ?>
                                <tr>
                                    <td class="text-capitalize">
                                        <?= htmlspecialchars($item['firstname'] .' '.$item['lastname']); ?> </td>
                                    <td class="text-capitalize"> <?= htmlspecialchars($item['programa']); ?> </td>
                                    <td class="text-capitalize"> <?= htmlspecialchars($item['carga_horaria']); ?> </td>
                                    <td class="text-capitalize"> <?= htmlspecialchars($item['nota']); ?> </td>
                                    <td class="text-capitalize"> <?= htmlspecialchars($item['descricao']); ?> </td>
                                    <td class="text-capitalize"> <?= htmlspecialchars($item['feedback']); ?> </td>
                                    <td>
                                        <?php
                                            $cor = "#999"; // Cor padrão (cinza para pendente)
                                            if ($item['status'] == "Aprovado") {
                                                $cor = "green";
                                            } elseif ($item['status'] == "Rejeitado") {
                                                $cor = "red";
                                            }
                                        ?>
                                        <a
                                            style="background-color: <?= $cor ?>; color:#fff; padding: 5px; border-radius:10px;">
                                            <?= htmlspecialchars($item['status']); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php if ($item['status_id'] == 1) : ?>
                                        <a href="<?php echo admin_url('plan_sucess_lideranca/avaliacao_lideranca_aprovar/'. $item['id']); ?>"
                                            class="btn btn-success" style="color: white;">
                                            Aprovar
                                        </a>
                                        <a onclick="return confirm('Tens certeza que desejas rejeitar?');"
                                            href="<?php echo admin_url('plan_sucess_lideranca/avaliacao_lideranca_rejeitar/'. $item['id']); ?>"
                                            class="text-white btn btn-danger"
                                            style="background-color:#FFA500; border-color:#FFA500; color:#fff;">
                                            Rejeitar
                                        </a>
                                        <?php endif ?>
                                        <a href="<?php echo admin_url('plan_sucess_lideranca/desenvolvimento_visualizar_avaliacao/'. $item['id'])?>"
                                            data-id="" class="btn btn-sucess btn-icon btn_edit_orcamento"
                                            style="background-color: #3CB371; border-color: #3CB371; color: white;">
                                            <i style="color:#fff;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?= $item['id'] ?>"
                                            data-talento="<?= html_entity_decode($item['talento_id']) ?>"
                                            data-treinamento_lideranca="<?= html_entity_decode($item['treinamento_lideranca_id']) ?>"
                                            data-feedback="<?= html_entity_decode($item['feedback_id']) ?>"
                                            data-nota="<?= html_entity_decode($item['nota']) ?>"
                                            data-descricao="<?= html_entity_decode($item['descricao']) ?>"
                                            class="btn btn-default btn-icon btn_edit_avaliacao_lideranca"
                                            style="background-color: #007bff; border-color: #007bff; color: white;">
                                            <i style="color:#fff;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certeza que desejas eliminar este Avaliação de Liderança?');"
                                            href="<?php echo admin_url('plan_sucess_lideranca/avaliacao_lideranca_delete/'.$item['id'])?>"
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
        <?= form_open(admin_url('plan_sucess_lideranca/adicionar_avaliacao_lideranca'), array('method' => 'post')) ?>
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Nova Avaliação
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
                                <?php echo _l('Talento'); ?> <small class="req text-danger">*</small>
                            </label>
                            <select name="talento" id="talento" class="selectpicker" data-live-search="true"
                                data-width="100%" data-none-selected-text="<?php echo _l('talento'); ?>">
                                <option value=""></option>
                                <?php foreach ($talentos as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['firstname'] .' '. $t['lastname'] ?> - Potencial:
                                    <?= $t['potencial'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="company" class="control-label">
                                <?php echo _l('treinamento_lideranca'); ?> <small class="req text-danger">*</small>
                            </label>
                            <select name="treinamento_lideranca" id="treinamento_lideranca" class="selectpicker"
                                data-live-search="true" data-width="100%"
                                data-none-selected-text="<?php echo _l('treinamento_lideranca'); ?>">
                                <option value=""></option>
                                <?php foreach ($treinamento_lideranca as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['programa'] ?> - Carga Horária:
                                    <?= $t['carga_horaria'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="company" class="control-label">
                                Feedback <small class="req text-danger">*</small>
                            </label>
                            <select class="form-control" name="feedback">
                                <option value=""></option>
                                <?php foreach ($feedback as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['nome'] ?>
                                </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nota" class="control-label">
                                Nota
                                <small class="req text-danger">*</small>
                            </label>
                            <input type="number" class="form-control" name="nota" id="nota" placeholder="Digite a nota"
                                min="0" max="20">
                        </div>
                        <div class="form-group">
                            <label for="descricao" class="control-label">
                                Descrição
                                <small class="req text-danger">*</small>
                            </label>
                            <textarea class="form-control" name="descricao" id="descricao" rows="4"
                                placeholder="Digite a descrição"></textarea>
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
            <?= form_close()  ?>
        </div>
    </div>
</div>

<?= form_open(admin_url('plan_sucess_lideranca/editar_avaliacao_lideranca'), array('method' => 'post', 'id' => 'form_edit_avaliacao_lideranca')) ?>
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
                                <?php echo _l('Talento'); ?> <small class="req text-danger">*</small>
                            </label>
                            <select name="e_talento" id="e_talento" class="selectpicker" data-live-search="true"
                                data-width="100%" data-none-selected-text="<?php echo _l('talento'); ?>">
                                <option value=""></option>
                                <?php foreach ($talentos as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['firstname'] .' '. $t['lastname'] ?> - Potencial:
                                    <?= $t['potencial'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="company" class="control-label">
                                <?php echo _l('treinamento_lideranca'); ?> <small class="req text-danger">*</small>
                            </label>
                            <select name="e_treinamento_lideranca" id="treinamento_lideranca" class="selectpicker"
                                data-live-search="true" data-width="100%"
                                data-none-selected-text="<?php echo _l('treinamento_lideranca'); ?>">
                                <option value=""></option>
                                <?php foreach ($treinamento_lideranca as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['programa'] ?> - Carga Horária:
                                    <?= $t['carga_horaria'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="company" class="control-label">
                                Feedback <small class="req text-danger">*</small>
                            </label>
                            <select class="form-control" name="e_feedback">
                                <option value=""></option>
                                <?php foreach ($feedback as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['nome'] ?>
                                </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="e_nota" class="control-label">
                                Nota
                                <small class="req text-danger">*</small>
                            </label>
                            <input type="number" class="form-control" name="e_nota" id="e_nota"
                                placeholder="Digite a nota" min="0" max="20">
                        </div>
                        <div class="form-group">
                            <label for="descricao" class="control-label">
                                Descrição
                                <small class="req text-danger">*</small>
                            </label>
                            <textarea class="form-control" name="e_descricao" id="descricao" rows="4"
                                placeholder="Digite a descrição"></textarea>
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
// programa_lideranca
$('.btn_edit_avaliacao_lideranca').click(function() {
    let talento = $(this).attr('data-talento');
    let treinamento_lideranca = $(this).attr('data-treinamento_lideranca');
    let feedback = $(this).attr('data-feedback');
    let nota = $(this).attr('data-nota');
    let descricao = $(this).attr('data-descricao');

    let id = $(this).attr('data-id');

    let url = "<?= admin_url('plan_sucess_lideranca/editar_avaliacao_lideranca') ?>/" + id;
    $('#form_edit_avaliacao_lideranca').attr('action', url);

    $('select[name="e_talento"]').selectpicker('val', talento);
    $('select[name="e_treinamento_lideranca"]').selectpicker('val', treinamento_lideranca);
    $('select[name="e_feedback"]').val(feedback);
    $('input[name="e_nota"]').val(nota);
    $('textarea[name="e_descricao"]').text(descricao);

    $('#editar').modal('show');
})
$('#feedback_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(5).search(this.value).draw();
})
$('#estado_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(6).search(this.value).draw();
})
</script>