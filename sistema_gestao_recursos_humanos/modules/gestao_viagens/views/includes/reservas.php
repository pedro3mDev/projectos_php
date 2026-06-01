<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel_s">
            <div class="panel-body">

                <div class="row">

                    <div class="col-md-12">
                        <h4 class="no-margin font-bold">
                            <i class="fa fa-address-card-o" aria-hidden="true"></i>
                            Reservar Viagem
                        </h4>
                        <hr />
                    </div>
                </div>

                <div class="row">
                    <div class=" col-md-12">
                        <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                            style="background-color: #007bff; border-color: #007bff; color: white;">
                            <i class="fa-regular "></i>
                            Nova Reserva
                        </a>
                    </div>
                </div>
                </br>
                <div class="row">
                    <div class=" col-md-6">
                    </div>
                    <div class=" col-md-3">
                        <select name="hotel_f" id="hotel_f" class="selectpicker" multiple="true" data-live-search="true"
                            data-width="100%" data-none-selected-text="<?php echo _l('Hotel'); ?>">
                            <option value=""> </option>
                            <?php foreach ($hotel as $h) : ?>
                            <option value="<?= $h['nome'] ?>"><?= $h['nome'] ?></option>
                            <?php endforeach ?>
                        </select>
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
                <table class="table dt-table">
                    <thead class="thead-custom">
                        <th>Objetivo(Destino)</th>
                        <th>Hotel</th>
                        <th>Voo</th>
                        <th>Transporte</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th></th>
                    </thead>
                    <tbody>
                        <?php
                            foreach($reservas as $c) {
                        ?>
                        <tr>
                            <td><?php echo $c['objetivo']; ?>(<?php echo $c['destino']; ?>)</td>
                            <td class="text-capitalize"><?php echo $c['hotel']; ?></td>
                            <td><?php echo $c['voo']; ?></td>
                            <td><?php echo $c['transporte']; ?></td>
                            <td>
                                <?php
                                    $total = 0;
                                    $total += $c['preco_h'];
                                    $total += $c['preco_t'];
                                    $total += $c['preco_v'];
                                    echo $total;
                                ?>
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
                                <a href="<?php echo admin_url('gestao_viagens/pedidos/reserva/'.$c['id']); ?>"
                                    class="btn btn-success btn-icon">
                                    <i style="color:#fff;" class="fa fa-eye"></i>
                                </a>
                                <a href="javascript:;" data-id="<?= $c['id'] ?>"
                                    data-pedido='<?= html_entity_decode($c['pedido_viagem_id']) ?>'
                                    data-voo='<?= html_entity_decode($c['voo_id']) ?>'
                                    data-hotel='<?= html_entity_decode($c['hotel_id']) ?>'
                                    data-transporte='<?= html_entity_decode($c['transporte_id']) ?>'
                                    data-aprovadores='<?= html_entity_decode(($c["aprovadores"] ?? "")) ?>'
                                    class="btn btn-default btn-icon btn_edit_reserva"
                                    style="background-color: #007bff; border-color: #007bff;">
                                    <i style="color:#fff;" class="fa fa-edit"></i>
                                </a>

                                <a onclick="return confirm('Tens certteza que desejas eliminar esta reserva?');"
                                    href="<?php echo admin_url('gestao_viagens/pedidos/delete_reserva/'.$c['id']); ?>"
                                    class="btn btn-danger btn-icon _delete" style="color:#fff;">
                                    <i class="fa fa-trash"></i>
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
        <?= form_open_multipart(admin_url('gestao_viagens/pedidos/add_reserva'), array('method' => 'post')) ?>
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Adicionar Reserva </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="company" class="control-label">Pedido de Viagem<small class="req text-danger">*
                                </small></label>
                            <select class="form-control" name="pedido">
                                <option value=""></option>
                                <?php foreach ($pedidos as $t) : ?>
                                <option value="<?= $t['id'] ?>"> <?= $t['objetivo'] ?> (<?= $t['destino'] ?>) </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <?php echo render_input('arquivo','Visto', '', 'file'); ?>
                        </div>
                        <div class="form-group">
                            <label for="company" class="control-label">Voo</label>
                            <select class="form-control" name="voo">
                                <option value=""></option>
                                <?php foreach ($voo as $t) : ?>
                                <option value="<?= $t['id'] ?>"> <?= $t['nome'] ?> </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="company" class="control-label">Hotel</label>
                            <select class="form-control" name="hotel">
                                <option value=""></option>
                                <?php foreach ($hotel as $t) : ?>
                                <option value="<?= $t['id'] ?>"> <?= $t['nome'] ?> </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="company" class="control-label">Transporte</label>
                            <select class="form-control" name="transporte">
                                <option value=""></option>
                                <?php foreach ($transporte as $t) : ?>
                                <option value="<?= $t['id'] ?>"> <?= $t['nome'] ?> </option>
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
                    <?php echo _l('Salvar'); ?>
                </button>
            </div>
        </div>
        <?= form_close()  ?>
    </div>
</div>

<?= form_open_multipart(admin_url('gestao_viagens/pedidos/editar_reserva'), array('method' => 'post', 'id' => 'form_edit_reserva')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Editar Reserva</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="company" class="control-label">Pedido de Viagem<small class="req text-danger">*
                                </small></label>
                            <select class="form-control" name="pedido_e">
                                <?php foreach ($pedidos as $t) : ?>
                                <option value="<?= $t['id'] ?>"> <?= $t['objetivo'] ?> (<?= $t['destino'] ?>) </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <?php echo render_input('arquivo','Visto', '', 'file'); ?>
                        </div>
                        <div class="form-group">
                            <label for="company" class="control-label">Voo</label>
                            <select class="form-control" name="voo_e">
                                <option value=""></option>
                                <?php foreach ($voo as $t) : ?>
                                <option value="<?= $t['id'] ?>"> <?= $t['nome'] ?> </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="company" class="control-label">Hotel</label>
                            <select class="form-control" name="hotel_e">
                                <option value=""></option>
                                <?php foreach ($hotel as $t) : ?>
                                <option value="<?= $t['id'] ?>"> <?= $t['nome'] ?> </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="company" class="control-label">Transporte</label>
                            <select class="form-control" name="transporte_e">
                                <option value=""></option>
                                <?php foreach ($transporte as $t) : ?>
                                <option value="<?= $t['id'] ?>"> <?= $t['nome'] ?> </option>
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
                <button type="button" class="btn btn-danger" data-dismiss="modal">
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