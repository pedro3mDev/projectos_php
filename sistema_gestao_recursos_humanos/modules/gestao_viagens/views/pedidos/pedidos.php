<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">

        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-6">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Viagens / Planeamento de Viagens
                </a>
            </div>
            <div class="col-md-6" style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
            </div>
        </div>

        </br>
        <?php require 'modules/gestao_viagens/views/planejamento/cards.php'; ?> 

        </br>
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold"><i class="fa fa-address-card-o"
                                        aria-hidden="true"></i>Planejar Viagem
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Novo Plano
                                </a>
                            </div>
                        </div>
                        </br>
                        <div class="row">
                            <div class=" col-md-6">
                            </div>
                            <div class=" col-md-3">

                                <select name="tipo_viagem_f" id="tipo_viagem_f" class="selectpicker" multiple="true"
                                    data-live-search="true" data-width="100%"
                                    data-none-selected-text="<?php echo _l('Tipo de Viagem'); ?>">
                                    <?php foreach($tipos as $s) { ?>
                                    <option value="<?php echo new_html_entity_decode($s['tipo_viagem']); ?>">
                                        <?php echo new_html_entity_decode($s['tipo_viagem']); ?>
                                    </option>
                                    <?php } ?>
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
                        <table class="table dt-table">
                            <thead class="thead-custom">
                                <th>Objetivo</th>
                                <th>Tipo de Viagem</th>
                                <th>Destino</th>
                                <th>Data de Inicio</th>
                                <th>Data de Final</th>
                                <th>Estado</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($plenejadas as $pedido) {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $pedido['objetivo']; ?>
                                    </td>
                                    <td class="text-capitalize">
                                        <?php echo $pedido['tipo_viagem']; ?>
                                    </td> 
                                    <td>
                                        <a style="background-color:#999; color:#fff; padding: 5px; border-radius:10px;"><?php echo $pedido['destino']; ?> </a>
                                    </td>
                                    <td><?php echo $pedido['data_inicio']; ?></td>
                                    <td><?php echo $pedido['data_fim']; ?></td>
                                    <td>   
                                        <?php
                                            $cor = "#ccc"; // Cor padrão (cinza para pendente)
                                            if ($pedido['status'] == "Activo") {
                                                $cor = "#3CB371";
                                            } elseif ($pedido['status'] == "Rejeitado") {
                                                $cor = "#e70000";
                                            }
                                        ?>
                                        <a style="background-color: <?= $cor ?>; color:#fff; padding: 5px; border-radius:10px;">
                                            <?= htmlspecialchars($pedido['status']); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?php echo admin_url('gestao_viagens/pedidos/pedido/'.$pedido['id']); ?>"
                                            class="btn btn-success btn-icon">
                                            <i style="color: white;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?= $pedido['id'] ?>"
                                            data-funcionarios='<?= multi_staff($pedido["id"]) ?>'
                                            data-tipo_viagem="<?= html_entity_decode($pedido['tipo_viagem_id']) ?>"
                                            data-categoria="<?= html_entity_decode($pedido['categoria_id']) ?>"
                                            data-objectivo="<?= html_entity_decode($pedido['objetivo']) ?>"
                                            data-destino="<?= html_entity_decode($pedido['destino']) ?>"
                                            data-data_inicio="<?= html_entity_decode($pedido['data_inicio']) ?>"
                                            data-data_fim="<?= html_entity_decode($pedido['data_fim']) ?>"
                                            data-aprovadores='<?= html_entity_decode(($pedido["aprovadores"] ?? "")) ?>'
                                            class="btn btn-default btn-icon btn_edit_pedido"
                                            style="background-color: #007bff; border-color: #007bff;">
                                            <i style="color: white;" class="fa fa-edit"></i>
                                        </a>

                                        <a onclick="return confirm('Tens certteza que desejas eliminar esta Pedido?');"
                                            href="<?php echo admin_url('gestao_viagens/pedidos/delete/'.$pedido['id']); ?>"
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

<div class="modal" id="modal_add" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <?= form_open(admin_url('gestao_viagens/pedidos/adicionar'), array('method' => 'post')) ?>
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Adicionar Planejamento
                </h4>
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
                            echo render_select('funcionarios[]', $staffs, ['staffid', ['firstname', 'lastname']], 'Funcionários<span class="text-danger">*</span>', $selectedStaff, ['multiple' => true], [], '', '', false);
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="company" class="control-label">
                                Tipo de Viagem <small class="req text-danger">*</small>
                            </label>
                            <select class="form-control" name="tipo_viagem">
                                <option value=""></option>
                                <?php foreach ($tipos as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['tipo_viagem'] ?>
                                </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="company" class="control-label">
                                Categoria <small class="req text-danger">*</small>
                            </label>
                            <select class="form-control" name="categoria">
                                <option value=""></option>
                                <?php foreach ($categorias as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['categoria'] ?>
                                </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group" app-field-wrapper="objetivo">
                            <label for="objetivo" class="control-label">
                                Objectivo <small class="req text-danger">*</small>
                            </label>
                            <textarea name="objetivo" class="form-control" style="min-height: 100px;"></textarea>
                        </div>
                        <div class="form-group" app-field-wrapper="destino">
                            <label for="destino" class="control-label">
                                Destino <small class="req text-danger">*</small>
                            </label>
                            <input type="text" id="destino" name="destino" class="form-control" value="">
                        </div>

                        <div class="form-group" app-field-wrapper="data_inicio">
                            <label for="data_inicio" class="control-label">
                                Data Início <small class="req text-danger">*</small>
                            </label>
                            <input type="date" id="data_inicio" name="data_inicio" class="form-control" value="">
                        </div>
                        <div class="form-group" app-field-wrapper="data_fim">
                            <label for="data_fim" class="control-label">
                                Data Fim <small class="req text-danger">*</small>
                            </label>
                            <input type="date" id="data_fim" name="data_fim" class="form-control" value="">
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
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo _l('Cancelar'); ?></button>
                <button type="submit" class="btn btn-success"><?php echo _l('Salvar'); ?></button>
            </div>
        </div>
        <?= form_close()  ?>
    </div>
</div>

<?= form_open(admin_url('gestao_viagens/pedidos/editar_pedido'), array('method' => 'post', 'id' => 'form_edit_pedido')) ?>
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
                            $selectedStaffFunc = '';
                            echo render_select('funcionarios_e[]', $staffs, ['staffid', ['firstname', 'lastname']], 'Funcionários<span class="text-danger">*</span>', $selectedStaffFunc, ['multiple' => true], [], '', '', false);
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="tipo_viagem_e" class="control-label">Tipo de
                                Viagem<small class="req text-danger">*
                                </small></label>
                            <select class="form-control" name="tipo_viagem_e">
                                <option value=""></option>
                                <?php foreach ($tipos as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['tipo_viagem'] ?>
                                </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="categoria_e" class="control-label">Categorias<small class="req text-danger">*
                                </small></label>
                            <select class="form-control" name="categoria_e">
                                <option value=""></option>
                                <?php foreach ($categorias as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['categoria'] ?>
                                </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group" app-field-wrapper="objetivo_e">
                            <label for="objetivo_e" class="control-label">
                                Objectivo<small class="req text-danger">*</small>
                            </label>
                            <textarea name="objetivo_e" class="form-control" style="min-height: 100px;"></textarea>
                        </div>
                        <div class="form-group" app-field-wrapper="destino_e">
                            <label for="destino_e" class="control-label">
                                Destino <small class="req text-danger">*</small>
                            </label>
                            <input type="text" id="destino_e" name="destino_e" class="form-control" value="">
                        </div>

                        <div class="form-group" app-field-wrapper="data_inicio_e">
                            <label for="data_inicio_e" class="control-label">
                                Data Início <small class="req text-danger">*</small>
                            </label>
                            <input type="date" id="data_inicio_e" name="data_inicio_e" class="form-control" value="">
                        </div>
                        <div class="form-group" app-field-wrapper="data_fim_e">
                            <label for="data_fim_e" class="control-label">
                                Data Fim <small class="req text-danger">*</small>
                            </label>
                            <input type="date" id="data_fim_e" name="data_fim_e" class="form-control" value="">
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
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo _l('Cancelar'); ?></button>
                <button type="submit" class="btn btn-success"><?php echo _l('Enviar'); ?></button>
            </div>
        </div>
    </div>
</div>
<?= form_close()  ?>
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

<?php require('modules/recruitment/assets/js/company_js.php'); ?>
<script>
$('.btn_edit_pedido').click(function() {
    let funcionarios = $(this).attr('data-funcionarios');
    let tipo_viagem = $(this).attr('data-tipo_viagem');
    let categoria = $(this).attr('data-categoria');
    let objectivo = $(this).attr('data-objectivo');
    let destino = $(this).attr('data-destino');
    let data_inicio = $(this).attr('data-data_inicio');
    let data_fim = $(this).attr('data-data_fim');
    let aprovadores = $(this).attr('data-aprovadores');

    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_viagens/pedidos/editar_pedido') ?>/" + id;
    $('#form_edit_pedido').attr('action', url);

    $('select[name="funcionarios_e[]"]').val(JSON.parse(funcionarios));
    $('select[name="tipo_viagem_e"]').val(tipo_viagem);
    $('select[name="categoria_e"]').val(categoria);
    $('textarea[name="objetivo_e"]').text(objectivo);
    $('input[name="destino_e"]').val(destino);
    $('input[name="data_inicio_e"]').val(data_inicio);
    $('input[name="data_fim_e"]').val(data_fim);
    $('select[name="aprovadores_e[]"]').val(JSON.parse(aprovadores));

    $('#editar').modal('show');
})

$('#estado_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(5).search(this.value).draw();
})
$('#tipo_viagem_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(1).search(this.value).draw();
})
</script>