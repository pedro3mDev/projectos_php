<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel_s">
            <div class="panel-body">
                <h1 style="font-size:24px; font-weight: 300; margin-bottom: 30px;"> Planeamento de Viagens</h1>
                <hr style="border-top: 1,5px solid #ccc; margin-bottom: 30px;">
                <div class="tw-flex tw-justify-between tw-items-center tw-gap-x-6">
                    <div class="tw-flex tw-justify-between tw-items-center tw-gap-x-1">
                        <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                            style="background-color: #007bff; border-color: #007bff; color: white;">
                            <i class="fa-regular "></i> Novo Pedido </a>
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
                            <td><a href=""><?php echo $pedido['objetivo']; ?></a>
                            </td>
                            <td class="text-capitalize"><?php echo $pedido['tipo_viagem']; ?></td>
                            <td><?php echo $pedido['destino']; ?></td>
                            <td><?php echo $pedido['data_inicio']; ?></td>
                            <td><?php echo $pedido['data_fim']; ?></td>
                            <td><?php echo $pedido['status']; ?></td>
                            <td>
                                <a href="<?php echo admin_url('gestao_viagens/pedidos/pedido/'.$pedido['id']); ?>"
                                    class="btn btn-default btn-icon">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="javascript:;" data-id="<?= $pedido['id'] ?>"
                                    data-funcionarios='<?= multi_staff($pedido['id']) ?>'
                                    data-tipo_viagem="<?= html_entity_decode($pedido['tipo_viagem_id']) ?>"
                                    data-categoria="<?= html_entity_decode($pedido['categoria_id']) ?>"
                                    data-objectivo="<?= html_entity_decode($pedido['objetivo']) ?>"
                                    data-destino="<?= html_entity_decode($pedido['destino']) ?>"
                                    data-data_inicio="<?= html_entity_decode($pedido['data_inicio']) ?>"
                                    data-data_fim="<?= html_entity_decode($pedido['data_fim']) ?>"
                                    data-aprovadores='<?= html_entity_decode(($pedido["aprovadores"] ?? "")) ?>'
                                    class="btn btn-default btn-icon btn_edit_pedido">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <a onclick="return confirm('Tens certteza que desejas eliminar esta categoria?');"
                                    href="<?php echo admin_url('gestao_viagens/delete_categoria/'.$pedido['id']); ?>"
                                    class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>
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
        <?= form_open(admin_url('gestao_viagens/pedidos/adicionar'), array('method' => 'post')) ?>
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Adicionar
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
                            <label for="company" class="control-label">Tipo de
                                Viagem<small class="req text-danger">*
                                </small></label>
                            <select class="form-control" name="tipo_viagem">
                                <option value=""></option>
                                <?php foreach ($tipos as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['tipo_viagem'] ?>
                                </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="company" class="control-label">Categorias<small class="req text-danger">*
                                </small></label>
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
                                Objectivo<small class="req text-danger">*</small>
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
                <button type="button" class="btn btn-default"
                    data-dismiss="modal"><?php echo _l('pl_close'); ?></button>
                <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
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
                <button type="button" class="btn btn-default"
                    data-dismiss="modal"><?php echo _l('pl_close'); ?></button>
                <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
            </div>
        </div>
    </div>
</div>
<?= form_close()  ?>