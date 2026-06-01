<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_viagens/assets/css/despesas.css'); ?>">

<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-6">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Viagens / Despesas
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
                                <h4 class="no-margin font-bold"><i class="fa fa-address-card-o"
                                        aria-hidden="true"></i>Despesas
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Nova Despesa
                                </a>
                                <!--a href="<?php echo admin_url('gestao_desenv_individual/analise')?>"
                                    class="btn"
                                    style="background-color: #2F4F4F; border-color: #2F4F4F; color: white;">
                                    <i class="fa-regular "></i>
                                    Análise
                                </a-->
                            </div>
                        </div>
                        </br>
                        <div class="row">
                            <div class=" col-md-9">
                            </div>
                            <div class=" col-md-3">
                                <select name="categoria_f" id="categoria_f" class="selectpicker" multiple="true"
                                    data-live-search="true" data-width="100%"
                                    data-none-selected-text="<?php echo _l('Categoria'); ?>">
                                    <?php foreach ($categorias as $t) : ?>
                                    <option value="<?= $t['categoria'] ?>"><?= $t['categoria'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                        </div>
                        <br><br>
                        <table class="table dt-table">
                            <thead class="thead-custom">
                                <th>Viagem</th>
                                <th>Categoria</th>
                                <th>Comprovativo</th>
                                <th>Valor</th>
                                <th>Descrição</th>
                                <th>Data despesa</th>
                                <th>Estado</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach($despesas as $d) : ?>
                                <tr>
                                    <td> <?= $d['objetivo'] ?>(<?= $d['destino'] ?>)</td>
                                    <td>
                                        <a style="background-color:#e3b62c; color:#333; padding: 5px; border-radius:10px;">
                                            <?= $d['categoria'] ?>
                                        </a>
                                    </td>
                                    <td> <?= $d['arquivo'] ?></td> 
                                    <td> <?= $d['valor'] ?></td>
                                    <td> <?= $d['descricao'] ?></td>
                                    <td> <?= $d['data_despesa'] ?></td>
                                    <td>  
                                        <?php
                                            $cor = "#ccc"; // Cor padrão (cinza para pendente)
                                            if ($d['status'] == "Activo") {
                                                $cor = "#3CB371";
                                            } elseif ($d['status'] == "Rejeitado") {
                                                $cor = "#e70000";
                                            }
                                        ?>
                                        <a style="background-color: <?= $cor ?>; color:#fff; padding: 5px; border-radius:10px;">
                                            <?= htmlspecialchars($d['status']); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?php echo admin_url('gestao_viagens/despesas/despesa/'.$d['id']); ?>"
                                            class="btn btn-success btn-icon">
                                            <i style="color: white;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?= $d['id'] ?>"
                                            data-orcamento="<?= html_entity_decode($d['orcamento_viagem_id']) ?>"
                                            data-categoria="<?= html_entity_decode($d['categoria_despesa_id']) ?>"
                                            data-valor="<?= html_entity_decode($d['valor']) ?>"
                                            data-descricao="<?= html_entity_decode($d['descricao']) ?>"
                                            data-data_despesa="<?= html_entity_decode($d['data_despesa']) ?>"
                                            class="btn btn-default btn_editar_despesa"
                                            style="background-color: #007bff; border-color: #007bff;">
                                            <i style="color: white;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certeza que desejas eliminar esta Despesa?');"
                                            href="<?php echo admin_url('gestao_viagens/despesas/delete/'.$d['id']); ?>"
                                            class="btn btn-danger btn-icon">
                                            <i style="color: white;" class="fa fa-trash"></i>
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
        <?= form_open_multipart(admin_url('gestao_viagens/despesas/adicionar'), array('method' => 'post')) ?>
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Nova Despesa
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
                                Viagem <small class="req text-danger">*</small>
                            </label>
                            <select class="form-control" name="orcamento">
                                <option value=""></option>
                                <?php foreach ($pedidos_viagem as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['objetivo'] ?>(<?= $t['destino'] ?>)</option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="categoria" class="control-label">
                                Categoria (Despesa)<small class="req text-danger">*</small>
                            </label>
                            <select class="form-control" name="categoria">
                                <option value=""></option>
                                <?php foreach ($categorias as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['categoria'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group" app-field-wrapper="arquivo">
                            <label for="arquivo" class="control-label">
                                Comprovativo <small class="req text-danger">*</small>
                            </label>
                            <input type="file" id="arquivo" name="arquivo" class="form-control">
                        </div>
                        <div class="form-group" app-field-wrapper="valor">
                            <label for="valor" class="control-label">
                                Valor <small class="req text-danger">*</small>
                            </label>
                            <input type="number" id="valor" name="valor" class="form-control">
                        </div>
                        <div class="form-group" app-field-wrapper="descricao">
                            <label for="descricao" class="control-label">
                                Descrição<small class="req text-danger">*</small>
                            </label>
                            <textarea name="descricao" class="form-control" style="min-height: 100px;"></textarea>
                        </div>
                        <div class="form-group" app-field-wrapper="data_despesa">
                            <label for="data_despesa" class="control-label">
                                Data Despesa<small class="req text-danger">*</small>
                            </label>
                            <input type="date" id="data_despesa" name="data_despesa" class="form-control">
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

<?= form_open_multipart(admin_url('gestao_viagens/despesas/editar'), array('method' => 'post', 'id' => 'form_edit_despesa')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Editar Despesa </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="company" class="control-label">
                                Viagem <small class="req text-danger">*</small>
                            </label>
                            <select class="form-control" name="e_orcamento">
                                <?php foreach ($pedidos_viagem as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['objetivo'] ?>(<?= $t['destino'] ?>)</option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="categoria" class="control-label">
                                Categoria (Despesa)<small class="req text-danger">*</small>
                            </label>
                            <select class="form-control" name="e_categoria">
                                <?php foreach ($categorias as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['categoria'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group" app-field-wrapper="arquivo">
                            <label for="arquivo" class="control-label">
                                Comprovativo <small class="req text-danger">*</small>
                            </label>
                            <input type="file" id="arquivo" name="arquivo" class="form-control">
                        </div>
                        <div class="form-group" app-field-wrapper="valor">
                            <label for="valor" class="control-label">
                                Valor <small class="req text-danger">*</small>
                            </label>
                            <input type="number" id="valor" name="e_valor" class="form-control">
                        </div>
                        <div class="form-group" app-field-wrapper="descricao">
                            <label for="descricao" class="control-label">
                                Descrição<small class="req text-danger">*</small>
                            </label>
                            <textarea name="e_descricao" class="form-control" style="min-height: 100px;"></textarea>
                        </div>
                        <div class="form-group" app-field-wrapper="data_despesa">
                            <label for="data_despesa" class="control-label">
                                Data Despesa<small class="req text-danger">*</small>
                            </label>
                            <input type="date" id="data_despesa" name="e_data_despesa" class="form-control">
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
$('.btn_editar_despesa').click(function() {
    let orcamento = $(this).attr('data-orcamento');
    let categoria = $(this).attr('data-categoria');
    let valor = $(this).attr('data-valor');
    let descricao = $(this).attr('data-descricao');
    let data_despesa = $(this).attr('data-data_despesa');

    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_viagens/despesas/editar') ?>/" + id;
    $('#form_edit_despesa').attr('action', url);
    $('select[name="e_orcamento"]').val(orcamento);
    $('select[name="e_categoria"]').val(categoria);
    $('input[name="e_valor"]').val(valor);
    $('textarea[name="e_descricao"]').html(descricao);
    $('input[name="e_data_despesa"]').val(data_despesa);

    $('#editar').modal('show');
})
$('#categoria_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(1).search(this.value).draw();
})
</script>