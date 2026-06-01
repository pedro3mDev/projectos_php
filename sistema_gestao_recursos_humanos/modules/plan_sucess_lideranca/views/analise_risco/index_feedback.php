<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href=""
                    style="font-size: 16px; color: #333;">
                    Plano de Sucessão e Liderança / Feedback de Liderança
                </a>
            </div>
            <div class="col-md-2"
                style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;"
                    class="btn ms-2" onclick="window.history.back()">
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
                                    <i class="fa fa-address-card-o"
                                        aria-hidden="true"></i>
                                        Feedback de Liderança
                                </h4>
                                <hr />
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal"
                                    data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white; ">
                                    <i class="fa-regular "></i>
                                    Novo Feedback
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/mentoria_coaching')?>"
                                    class="btn"
                                    style="background-color: #FFD700; border-color: #FFD700; color: white;">
                                    <i class="fa-regular "></i>
                                    Mentoria
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/mentoria_coaching_coaching')?>"
                                    class="btn"
                                    style="background-color: #FFD700; border-color: #FFD700; color: white;">
                                    <i class="fa-regular "></i>
                                    Coaching
                                </a>
                            </div>
                        </div>

                        <div class="row">
                            <div class=" col-md-6">
                            </div>
                            <div class=" col-md-3">
                                <select name="estado_f" id="estado_f"
                                    class="selectpicker" multiple="true"
                                    data-live-search="true" data-width="100%"
                                    data-none-selected-text="<?php echo _l('Estado'); ?>">
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class=" col-md-3">
                                <select name="estado_f" id="estado_f"
                                    class="selectpicker" multiple="true"
                                    data-live-search="true" data-width="100%"
                                    data-none-selected-text="<?php echo _l('Competencia'); ?>">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>

                        <br><br>

                        <table
                            class="table table-hover table-bordered table-responsive dt-table">
                            <thead class="thead-custom">
                                <th>Usuário</th>
                                <th>Competencia</th>
                                <th>Nota</th>
                                <th>Data Avaliação</th>
                                <th>Estado</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Teste</td>
                                    <td class="text-capitalize"></td>
                                    <td>Teste</td>
                                    <td>Teste</td>
                                    <td>
                                        <?php
                                            $cor = "#999"; // Cor padrão (cinza para pendente)
                                            /*if ($c['status'] == "Activo") {
                                                $cor = "green";
                                            } elseif ($c['status'] == "Rejeitado") {
                                                $cor = "red";
                                            }*/
                                        ?>
                                        <a
                                            style="background-color: <?= $cor ?>; color:#fff; padding: 5px; border-radius:10px;">
                                            Pendente
                                        </a>
                                    </td>
                                    <td>
                                        <a href="javascript:;" data-id=""
                                            data-reserva="" data-total=""
                                            data-total_s=""
                                            class="text-white btn btn-success btn_aprovar_orcamento"
                                            style="color:#fff;">
                                            Aprovar
                                        </a>
                                        <a onclick="return confirm('Tens certeza que desejas rejeitar este Orçamento?');"
                                            href=""
                                            class="text-white btn btn-danger"
                                            style="background-color:#FFA500; border-color:#FFA500; color:#fff;">
                                            Rejeitar
                                        </a>
                                        <a href="javascript:;" data-id=""
                                            class="btn btn-sucess btn-icon btn_edit_orcamento"
                                            style="background-color: #007bff; border-color: #007bff; color: white;">
                                            <i style="color:#fff;"
                                                class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id=""
                                            class="btn btn-default btn-icon btn_edit_orcamento"
                                            style="background-color: #007bff; border-color: #007bff; color: white;">
                                            <i style="color:#fff;"
                                                class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas eliminar este Orcamento?');"
                                            href=""
                                            class="btn btn-danger btn-icon _delete">
                                            <i style="color:#fff;"
                                                class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
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
        <?= form_open(admin_url(''), array('method' => 'post')) ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Novo Feedback</h4>
            </div>
            
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="usuario_id" class="control-label">
                                Usuário
                                <small class="req text-danger">*</small>
                            </label>
                            <select class="form-control" name="usuario_id" id="usuario_id">
                                <option value=""></option>
                                <option value=""></option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="mentor_id" class="control-label">
                                Mentor
                                <small class="req text-danger">*</small>
                            </label>
                            <select class="form-control" name="mentor_id" id="mentor_id">
                                <option value=""></option>
                                <option value=""></option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="comentario" class="control-label">
                                Comentário
                                <small class="req text-danger">*</small>
                            </label>
                            <textarea class="form-control" name="comentario" id="comentario" rows="4" placeholder="Digite o comentário"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="data_feedback" class="control-label">
                                Data do Feedback
                                <small class="req text-danger">*</small>
                            </label>
                            <input type="date" class="form-control" name="data_feedback" id="data_feedback">
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
            <?= form_close()  ?>
        </div>
    </div>

    <?= form_open(admin_url('gestao_viagens/pedidos/editar_pedido'), array('method' => 'post', 'id' => 'form_edit_orcamento')) ?>
    <div class="modal" id="editar" tabindex="-1" role="dialog">
        <div class="modal-dialog w-25">
            <div class="modal-content ">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close"><span
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
                                <label for="company"
                                    class="control-label">Reserva de
                                    Viagem<small
                                        class="req text-danger">*</small></label>
                                <select class="form-control" name="reserva_e">
                                    <option value=""></option>
                                    <?php foreach ($reservas as $t) : ?>
                                    <option value="<?= $t['id'] ?>">
                                        <?= $t['objetivo'] ?>
                                        (<?= $t['destino'] ?>)
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
                    <button type="submit"
                        class="btn btn-info"><?php echo _l('submit'); ?></button>
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
                    <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close"><span
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
                                <label for="company"
                                    class="control-label">Reserva de
                                    Viagem<small
                                        class="req text-danger">*</small></label>
                                <select class="form-control" name="reserva_a"
                                    disabled>
                                </select>
                            </div>
                            <div class="form-group">
                                <div
                                    style="background: #006400; color:#fff; padding: 10px; text-align: center;">
                                    <span>Total</span> <br>
                                    <h3 class="total_reserva_a">0,00</h3>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="company"
                                    class="control-label">Estimativa<small
                                        class="req text-danger">*</small></label>
                                <select class="form-control reserva_o"
                                    name="estimativa" data-total_reserva>
                                    <option value="" data-estimativa="0">
                                    </option>
                                    <?php foreach ($estimativa_viagem as $t) : ?>
                                    <option value="<?= $t['id'] ?>"
                                        data-estimativa="<?= $t['valor'] ?>">
                                        <?= $t['tipo_viagem'] ?>
                                        (<?= $t['valor'] ?>) </option>
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
                    <button type="submit" class="btn btn-info btn_aprovar"
                        disabled><?php echo _l('Aprovar'); ?></button>
                </div>
            </div>
        </div>
    </div>
    <?= form_close()  ?>
    <?php init_tail(); ?>
    </body>
    </html>