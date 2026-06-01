<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-6">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Viagens / Orçamento Viagens
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
            <div class="col-md-3">
                <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column"
                    style="border-bottom: 1px solid #336; border-left: 4px solid #8B0000;">
                    <a class="text-center text-warning mbot15">
                        <p class="text-uppercase mtop5 minheight35"
                            style="font-size: 14px; font-weight: bold; color:#DAA520;;">
                            Total Orçamento
                        </p>
                        <div class="d-flex align-items-center justify-content-center">
                            <p style="font-size:16px; color:#DAA520;">
                                <i class="fa fa-hashtag"></i>
                                <?= $total_orcamento ?? 0; ?>
                            </p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column"
                    style="border-bottom: 1px solid #336; border-left: 4px solid #8B0000;">
                    <a class="text-center text-warning mbot15">
                        <p class="text-uppercase mtop5 minheight35"
                            style="font-size: 14px; font-weight: bold; color:#DAA520;;">
                            Orçamento Pendentes
                        </p>
                        <div class="d-flex align-items-center justify-content-center">
                            <p style="font-size:16px; color:#DAA520;">
                                <i class="fa fa-tasks"></i>
                                <?= $total_orcamento_penedntes ?? 0; ?>
                            </p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column"
                    style="border-bottom: 1px solid #336; border-left: 4px solid #8B0000;">
                    <a class="text-center text-warning mbot15">
                        <p class="text-uppercase mtop5 minheight35"
                            style="font-size: 14px; font-weight: bold; color:#DAA520;;">
                            Orçamento Aprovados
                        </p>
                        <div class="d-flex align-items-center justify-content-center">
                            <p style="font-size:16px; color:#DAA520;">
                                <i class="fa fa-check-circle"></i>
                                <?= $total_orcamento_aprovados ?? 0; ?>
                            </p>
                        </div>
                    </a>
                </div>
            </div>


            <div class="col-md-3">
                <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column"
                    style="border-bottom: 1px solid #336; border-left: 4px solid #8B0000;">
                    <a class="text-center text-warning mbot15">
                        <p class="text-uppercase mtop5 minheight35"
                            style="font-size: 14px; font-weight: bold; color:#DAA520;;">
                            Orçamentos Rejeitados
                        </p>
                        <div class="d-flex align-items-center justify-content-center">
                            <p style="font-size:16px; color:#DAA520;">
                                <i class="fa fa-plane"></i>
                                <?= $total_orcamento_rejeitados ?? 0; ?>
                            </p>
                        </div>
                    </a>
                </div>
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
                                    Orçamento
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white; ">
                                    <i class="fa-regular "></i>
                                    Novo Orçamento
                                </a>
                                <a href="<?php echo admin_url('gestao_viagens/orcamentos/analise_grafica')?>"
                                    class="btn" style="background-color: #daa520; border-color: #daa520; color: white;">
                                    <i class="fa-regular "></i>
                                    Análise Gráfica
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
                                    <?php foreach ($status as $h) : ?>
                                    <option value="<?= $h['status'] ?>"><?= $h['status'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <br><br>
                        <table class="table table-hover table-bordered table-responsive dt-table">
                            <thead class="thead-custom">
                                <th>Objetivo</th>
                                <th>Tipo de Viagem</th>
                                <th>Destino</th>
                                <th>Data de Inicio</th>
                                <th>Data de Final</th>
                                <th>Total Reserva</th>
                                <th>Estado</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($orcamentos as $c) {
                                    ?>
                                <tr>
                                    <td><?php echo $c['objetivo']; ?></td>
                                    <td class="text-capitalize"><?php echo $c['tipo_viagem']; ?></td>
                                    <td><?php echo $c['destino']; ?></td>
                                    <td><?php echo $c['data_inicio']; ?></td>
                                    <td><?php echo $c['data_fim']; ?></td>
                                    <td>
                                        <a
                                            style="background-color:#e3b62c; color:#333; padding: 5px; border-radius:10px;">
                                            <?php echo number_format(total_reserva($c), 2, ',','.'); ?>
                                        </a>
                                    </td>
                                    <td>  
                                        <?php
                                            $cor = "#ccc"; // Cor padrão (cinza para pendente)
                                            if ($c['status'] == "Activo") {
                                                $cor = "#3CB371";
                                            } elseif ($c['status'] == "Rejeitado") {
                                                $cor = "#e70000";
                                            }
                                        ?>
                                        <a style="background-color: <?= $cor ?>; color:#fff; padding: 5px; border-radius:10px;">
                                            <?= htmlspecialchars($c['status']); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php if ($c['status_id'] == 1) : ?>
                                        <a href="javascript:;" data-id="<?= $c['id'] ?>"
                                            data-reserva="<?php echo $c['objetivo']; ?> (<?php echo $c['destino']; ?>)"
                                            data-total="<?= number_format(total_reserva($c), 2, ',','.') ?>"
                                            data-total_s="<?= total_reserva($c) ?>"
                                            class="text-white btn btn-success btn_aprovar_orcamento"
                                            style="color:#fff;">
                                            Aprovar
                                        </a>
                                        <a onclick="return confirm('Tens certeza que desejas rejeitar este Orçamento?');"
                                            href="<?php echo admin_url('gestao_viagens/orcamentos/status_orcamento_rejeitar/'.$c['id']); ?>"
                                            class="text-white btn btn-danger"
                                            style="background-color:#FFA500; border-color:#FFA500; color:#fff;">
                                            Rejeitar
                                        </a>
                                        <a href="javascript:;" data-id="<?= $c['id'] ?>"
                                            data-reserva="<?= html_entity_decode($c['reserva_id']) ?>"
                                            data-aprovadores='<?= html_entity_decode(($c["aprovadores"] ?? "")) ?>'
                                            class="btn btn-default btn-icon btn_edit_orcamento"
                                            style="background-color: #007bff; border-color: #007bff; color: white;">
                                            <i style="color:#fff;" class="fa fa-edit"></i>
                                        </a>
                                        <?php endif ?>
                                        <a onclick="return confirm('Tens certteza que desejas eliminar este Orcamento?');"
                                            href="<?php echo admin_url('gestao_viagens/orcamentos/delete_orcamento/'.$c['id']); ?>"
                                            class="btn btn-danger btn-icon _delete">
                                            <i style="color:#fff;" class="fa fa-trash"></i>
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

<div class="modal" id="modal_add" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <?= form_open(admin_url('gestao_viagens/orcamentos/add_orcamento'), array('method' => 'post')) ?>
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Adicionar Orçamento
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="company" class="control-label">Reserva de Viagem<small
                                    class="req text-danger">*</small></label>
                            <select class="form-control" name="reserva">
                                <option value=""></option>
                                <?php foreach ($reservas as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['objetivo'] ?> (<?= $t['destino'] ?>)
                                </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <?php
                            $selectedStaff = '';
                            echo render_select('aprovadores[]', $staff_list, ['staffid', ['firstname', 'lastname']], 'Aprovadores<span class="text-danger">*</span>', $selectedStaff, ['multiple' => true], [], '', '', false);
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
        <?= form_close()  ?>
    </div>
</div>

<?= form_open(admin_url('gestao_viagens/pedidos/editar_pedido'), array('method' => 'post', 'id' => 'form_edit_orcamento')) ?>
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
                            <label for="company" class="control-label">Reserva de Viagem<small
                                    class="req text-danger">*</small></label>
                            <select class="form-control" name="reserva_e">
                                <option value=""></option>
                                <?php foreach ($reservas as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['objetivo'] ?> (<?= $t['destino'] ?>)
                                </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <?php
                            $selectedStaff = '';
                            echo render_select('aprovadores_e[]', $staff_list, ['staffid', ['firstname', 'lastname']], 'Aprovadores<span class="text-danger">*</span>', $selectedStaff, ['multiple' => true], [], '', '', false);
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

<?= form_open(admin_url('gestao_viagens/orcamentos/'), array('method' => 'post', 'id' => 'form_aprovar_orcamento')) ?>
<div class="modal" id="aprovar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Aprovar Orçamento </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="company" class="control-label">Reserva de Viagem<small
                                    class="req text-danger">*</small></label>
                            <select class="form-control" name="reserva_a" disabled>
                            </select>
                        </div>
                        <div class="form-group">
                            <div style="background: #006400; color:#fff; padding: 10px; text-align: center;">
                                <span>Total</span> <br>
                                <h3 class="total_reserva_a">0,00</h3>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="company" class="control-label">Estimativa<small
                                    class="req text-danger">*</small></label>
                            <select class="form-control reserva_o" name="estimativa" data-total_reserva>
                                <option value="" data-estimativa="0"></option>
                                <?php foreach ($estimativa_viagem as $t) : ?>
                                <option value="<?= $t['id'] ?>" data-estimativa="<?= $t['valor'] ?>">
                                    <?= $t['tipo_viagem'] ?> (<?= $t['valor'] ?>) </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <div style="text-align: center;">
                                <h3 class="text-danger sms_orcamento"></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                    data-dismiss="modal"><?php echo _l('pl_close'); ?></button>
                <button type="submit" class="btn btn-info btn_aprovar" disabled><?php echo _l('Aprovar'); ?></button>
            </div>
        </div>
    </div>
</div>
<?= form_close()  ?>
<?php init_tail(); ?>

<script>
$('.btn_edit_orcamento').click(function() {
    let reserva = $(this).attr('data-reserva');
    let aprovadores = $(this).attr('data-aprovadores');

    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_viagens/orcamentos/editar_orcamento') ?>/" + id;
    $('#form_edit_orcamento').attr('action', url);

    $('select[name="reserva_e"]').val(reserva);
    $('select[name="aprovadores_e[]"]').val(JSON.parse(aprovadores));

    $('#editar').modal('show');
})

$('.btn_aprovar_orcamento').click(function() {
    let reserva = $(this).attr('data-reserva');
    let total = $(this).attr('data-total');
    let total_s = $(this).attr('data-total_s');

    $('.btn_aprovar').attr('disabled', 'disabled');

    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_viagens/orcamentos/aprovar_orcamento') ?>/" + id;
    $('#form_aprovar_orcamento').attr('action', url);
    $('select[name="reserva_a"]').html('<option>' + reserva + '</option>');
    $('.total_reserva_a').text(total);
    $('.reserva_o').val('')
    $('.reserva_o').attr('data-total_reserva', total_s);

    $('#aprovar').modal('show');
})
$('.reserva_o').change(function() {
    let total = $(this).attr('data-total_reserva');
    let estimativa = $(this).find(":selected").data('estimativa');

    if (parseFloat(total) <= parseFloat(estimativa)) {
        $('.sms_orcamento').text('');
        $('.btn_aprovar').removeAttr('disabled');
    } else {
        $('.sms_orcamento').text('Selecionaste uma Estimatica menor.');
        $('.btn_aprovar').attr('disabled', 'disabled');
    }
})
$('#estado_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(6).search(this.value).draw();
})
</script>
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

<?php require('modules/recruitment/assets/js/company_js.php'); ?>