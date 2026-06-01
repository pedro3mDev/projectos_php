<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel_s">
            <div class="panel-body">
                <div class="row"> 
                    <div class="col-md-12">
                        <h4 class="no-margin font-bold">
                            <i class="fa fa-address-card-o" aria-hidden="true"></i>
                            Reservar Voo
                        </h4>
                        <hr />
                    </div>
                </div>
                <div class="tw-flex tw-justify-between tw-items-center tw-gap-x-6">
                    <div class="tw-flex tw-justify-between tw-items-center tw-gap-x-1">
                        <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                            style="background-color: #007bff; border-color: #007bff; color: white;">
                            <i class="fa-regular "></i> Novo Registro </a>
                    </div>
                </div>
                <br><br>
                <table class="table dt-table">
                    <thead class="thead-custom">
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Local de Partida</th>
                        <th>Local de Destino</th>
                        <th>Data de Partida</th>
                        <th>Preço</th>
                        <th>Estado</th>
                        <th></th>
                    </thead>
                    <tbody>
                        <?php
                            foreach($voos as $c) {
                        ?>
                        <tr>
                            <td class="text-capitalize"><?php echo $c['nome']; ?></td>
                            <td><?php echo $c['descricao']; ?></td>
                            <td><?php echo $c['local_partida']; ?></td>
                            <td><?php echo $c['local_destino']; ?></td>
                            <td><?php echo $c['data_partida']; ?></td>
                            <td><?php echo $c['preco']; ?></td>
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
                                <a href="<?php echo admin_url('gestao_viagens/pedidos/status_voo_aprovar/'.$c['id']); ?>"
                                    class="btn btn-success text-white" 
                                    style="color:#fff;">
                                    Aprovar
                                </a>
                                <a onclick="return confirm('Tens certteza que desejas rejeitar este Voo?');"
                                    href="<?php echo admin_url('gestao_viagens/pedidos/status_voo_rejeitar/'.$c['id']); ?>"
                                    class="btn btn-default text-white"
                                    style="color:#fff; background-color:#FFA500; border-color:#FFA500;">
                                    Rejeitar
                                </a>
                                <?php endif ?>
                                <a href="javascript:;" data-id="<?= $c['id'] ?>"
                                    data-nome='<?= html_entity_decode($c['nome']) ?>'
                                    data-descricao='<?= html_entity_decode($c['descricao']) ?>'
                                    data-local_partida="<?= html_entity_decode($c['local_partida']) ?>"
                                    data-local_destino="<?= html_entity_decode($c['local_destino']) ?>"
                                    data-data_partida="<?= html_entity_decode($c['data_partida']) ?>"
                                    data-preco="<?= html_entity_decode($c['preco']) ?>"
                                    data-aprovadores='<?= html_entity_decode(($c["aprovadores"] ?? "")) ?>'
                                    class="btn btn-default btn-icon btn_edit_voo"
                                    style="background-color: #007bff; border-color:#007bff;">
                                    <i style="color:#fff;" class="fa fa-edit"></i>
                                </a>
                                <a onclick="return confirm('Tens certteza que desejas eliminar esta Voo?');"
                                    href="<?php echo admin_url('gestao_viagens/pedidos/delete_voo/'.$c['id']); ?>"
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

<div class="modal" id="modal_add" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <?= form_open(admin_url('gestao_viagens/pedidos/add_voo'), array('method' => 'post')) ?>
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Adicionar Voo </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group" app-field-wrapper="nome">
                            <label for="nome" class="control-label">
                                Nome <small class="req text-danger">*</small>
                            </label>
                            <input type="text" id="nome" name="nome" class="form-control" value="">
                        </div>
                        <div class="form-group" app-field-wrapper="descricao">
                            <label for="descricao" class="control-label">
                                Descrição<small class="req text-danger">*</small>
                            </label>
                            <textarea name="descricao" class="form-control" style="min-height: 100px;"></textarea>
                        </div>
                        <div class="form-group" app-field-wrapper="local_partida">
                            <label for="local_partida" class="control-label">
                                Local de Partida <small class="req text-danger">*</small>
                            </label>
                            <input type="text" id="local_partida" name="local_partida" class="form-control" value="">
                        </div>
                        <div class="form-group" app-field-wrapper="local_destino">
                            <label for="local_destino" class="control-label">
                                Local de Destino <small class="req text-danger">*</small>
                            </label>
                            <input type="text" id="local_destino" name="local_destino" class="form-control" value="">
                        </div>
                        <div class="form-group" app-field-wrapper="data_partida">
                            <label for="data_partida" class="control-label">
                                Data de Partida <small class="req text-danger">*</small>
                            </label>
                            <input type="date" id="data_partida" name="data_partida" class="form-control" value="">
                        </div>
                        <div class="form-group" app-field-wrapper="preco">
                            <label for="preco" class="control-label">
                                Preço <small class="req text-danger">*</small>
                            </label>
                            <input type="number" id="preco" name="preco" class="form-control" value="">
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
                <button type="button" 
                        class="btn btn-danger"
                        data-dismiss="modal">
                    <?php echo _l('Cancelar'); ?>
                </button>
                <button type="submit" class="btn btn-success">
                    <?php echo _l('Salvar'); ?>
                </button>
            </div>
        </div>
        <?= form_close()  ?>
    </div>
</div>

<?= form_open(admin_url('gestao_viagens/pedidos/editar_voo'), array('method' => 'post', 'id' => 'form_edit_voo')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Editar Voo </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group" app-field-wrapper="nome_e">
                            <label for="nome_e" class="control-label">
                                Nome <small class="req text-danger">*</small>
                            </label>
                            <input type="text" id="nome_e" name="nome_e" class="form-control" value="">
                        </div>
                        <div class="form-group" app-field-wrapper="descricao_e">
                            <label for="descricao_e" class="control-label">
                                Descrição<small class="req text-danger">*</small>
                            </label>
                            <textarea name="descricao_e" class="form-control" style="min-height: 100px;"></textarea>
                        </div>
                        <div class="form-group" app-field-wrapper="local_partida_e">
                            <label for="local_partida_e" class="control-label">
                                Local de Partida <small class="req text-danger">*</small>
                            </label>
                            <input type="text" id="local_partida_e" name="local_partida_e" class="form-control"
                                value="">
                        </div>
                        <div class="form-group" app-field-wrapper="local_destino_e">
                            <label for="local_destino_e" class="control-label">
                                Local de Destino <small class="req text-danger">*</small>
                            </label>
                            <input type="text" id="local_destino_e" name="local_destino_e" class="form-control"
                                value="">
                        </div>
                        <div class="form-group" app-field-wrapper="data_partida_e">
                            <label for="data_partida_e" class="control-label">
                                Data de Partida <small class="req text-danger">*</small>
                            </label>
                            <input type="date" id="data_partida_e" name="data_partida_e" class="form-control" value="">
                        </div>
                        <div class="form-group" app-field-wrapper="preco_e">
                            <label for="preco_e" class="control-label">
                                Preço <small class="req text-danger">*</small>
                            </label>
                            <input type="number" id="preco_e" name="preco_e" class="form-control" value="">
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
                <button type="button" 
                        class="btn btn-danger"
                        data-dismiss="modal">
                    <?php echo _l('Cancelar'); ?>
                </button>
                <button type="submit" class="btn btn-success">
                    <?php echo _l('Salvar'); ?>
                </button>
            </div>
        </div>
    </div>
</div>
<?= form_close()  ?>