<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">

        </br></br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-6">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Viagens / Feedback e Avaliação
                </a>
            </div>
            <div class="col-md-6" style=" display: flex; justify-content: flex-end; align-items: center;">
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
                                    Feedback
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white; ">
                                    <i class="fa-regular "></i>
                                    Novo Feedback
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-6">
                            </div>
                            <div class=" col-md-3">
                                <select name="classificacao_f" id="classificacao_f" class="selectpicker" multiple="true"
                                    data-live-search="true" data-width="100%"
                                    data-none-selected-text="<?php echo _l('Classificação'); ?>">
                                    <option value=""> </option>
                                    <?php foreach ($classificacoes as $h) : ?>
                                    <option value="<?= $h['nome'] ?>"><?= $h['nome'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class=" col-md-3">
                                <select name="estado_f" id="estado_f" class="selectpicker" multiple="true"
                                    data-live-search="true" data-width="100%"
                                    data-none-selected-text="<?php echo _l('Estado'); ?>">
                                    <option value=""> </option>
                                </select>
                            </div>
                        </div>
                        <br><br>
                        <table class="table dt-table">
                            <thead class="thead-custom">
                                <tr>
                                    <th>Feedback</th>
                                    <th>Clasificacão</th>
                                    <th>Viagem</th>
                                    <th>Orçamento</th>
                                    <th>Data</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($feedbacks as $linha): ?>
                                <tr>
                                    <td><?= htmlspecialchars($linha['feedback'] ?? '') ?></td>
                                    <td>
                                        <a style="background-color:#e3b62c; color:#333; padding: 5px; border-radius:10px;">
                                            <?= htmlspecialchars($linha['classificacao'] ?? '') ?>
                                        </a>
                                    </td>
                                    <td><?= htmlspecialchars($linha['objetivo'] ?? '') ?></td>
                                    <td>
                                        <?php echo number_format(total_reserva($linha), 2, ',','.'); ?>
                                    </td>
                                    <td><?= htmlspecialchars($linha['data_feedback'] ?? '') ?></td>
                                    <td class="actions">
                                        <a href="javascript:;" data-id="<?= $linha['id'] ?>"
                                            data-feedback="<?= html_entity_decode($linha['feedback']) ?>"
                                            data-classificacao="<?= html_entity_decode($linha['classificacao_id']) ?>"
                                            data-orcamento="<?= html_entity_decode($linha['orcamento_viagem_id']) ?>"
                                            class="btn btn-default btn-icon btn_edit_feedback">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas eliminar este Feedback?');"
                                            href="<?php echo admin_url('gestao_viagens/feedback/delete/'.$linha['id']); ?>"
                                            class="btn btn-danger btn-icon"><i class="fa fa-remove"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<?php echo form_close(); ?>
<div class="btn-bottom-pusher"></div>
</div>
</div>
<div id="new_version"></div>
<?php init_tail(); ?>
<style>
/* Estilo do cabeçalho da tabela */
.thead-custom {
    background-color: #f4f4f4;
    /* Fundo cinza claro */
    color: rgba(51, 51, 51, 0.8);
    /* Texto com transparência */
    font-weight: bold;
    text-align: left;
    border-bottom: 1px solid #ccc;
    /* Linha separadora */
}
</style>

<div class="modal" id="modal_add" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <?= form_open(admin_url('gestao_viagens/feedback/adicionar'), array('method' => 'post')) ?>
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Novo Feedback
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="orcamento" class="control-label">
                                        Viagem<small class="req text-danger">*
                                        </small></label>
                                    <select class="form-control" name="orcamento">
                                        <option value=""></option>
                                        <?php foreach ($orcamentos as $t) : ?>
                                        <option value="<?= $t['id'] ?>"><?= $t['objetivo'] ?>(<?= $t['destino'] ?>)
                                        </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="classificacao" class="control-label">Classificação<small
                                            class="req text-danger">*
                                        </small></label>
                                    <select class="form-control" name="classificacao">
                                        <option value=""></option>
                                        <?php foreach ($classificacoes as $t) : ?>
                                        <option value="<?= $t['id'] ?>"><?= $t['nome'] ?>
                                        </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <?php echo render_textarea('feedback','Feedback<small class="req text-danger">*</small>'); ?>
                            </div>
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
        <?= form_close()  ?>
    </div>
</div>

<?= form_open(admin_url('gestao_viagens/feedback/editar'), array('method' => 'post', 'id' => 'form_edit_feedback')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Editar Feedback </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="e_orcamento" class="control-label">Orçamento de
                                        Viagem<small class="req text-danger">*
                                        </small></label>
                                    <select class="form-control" name="e_orcamento">
                                        <?php foreach ($orcamentos as $t) : ?>
                                        <option value="<?= $t['id'] ?>"><?= $t['objetivo'] ?>(<?= $t['destino'] ?>)
                                        </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="e_classificacao" class="control-label">Classificação<small
                                            class="req text-danger">*
                                        </small></label>
                                    <select class="form-control" name="e_classificacao">
                                        <?php foreach ($classificacoes as $t) : ?>
                                        <option value="<?= $t['id'] ?>"><?= $t['nome'] ?>
                                        </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <?php echo render_textarea('e_feedback','Feedback<small class="req text-danger">*</small>'); ?>
                            </div>
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
<?php require('modules/recruitment/assets/js/company_js.php'); ?>
<?php init_tail(); ?>

<script>
$('.btn_edit_feedback').click(function() {
    let classificacao = $(this).attr('data-classificacao');
    let orcamento = $(this).attr('data-orcamento');
    let feedback = $(this).attr('data-feedback');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_viagens/feedback/editar') ?>/" + id;
    $('#form_edit_feedback').attr('action', url);
    $('select[name="e_classificacao"]').val(classificacao);
    $('select[name="e_orcamento"]').val(orcamento);
    $('textarea[name="e_feedback"]').html(feedback);

    $('#editar').modal('show');
})
$('#classificacao_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(1).search(this.value).draw();
})
</script>