<div class="row">
    <div class="col-md-12">
        <div class="panel_s">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="no-margin font-bold"><i class="fa fa-address-card-o" aria-hidden="true"></i>Posição
                            Chave
                        </h4>
                        <hr />
                    </div>
                </div>
                </br>
                <div class="row">
                    <div class="col-12 mb-2">
                        <a href="#" data-toggle="modal" data-target="#modal_add_programa_lideranca" class="btn"
                            style="background-color: #007bff; border-color: #007bff; color: white;">
                            <i class="fa-regular "></i>
                            Adicionar Programa de Liderança
                        </a>
                    </div>
                    <div class="col-md-3 tw-mt-2">
                        <select name="nivel_critico_pc_f" id="nivel_critico_pc_f" class="selectpicker" multiple="true"
                            data-live-search="true" data-width="100%"
                            data-none-selected-text="<?php echo _l('nivel_critico'); ?>">
                            <?php foreach($nivel_critico as $s) { ?>
                            <option value="<?php echo new_html_entity_decode($s['nome']); ?>">
                                <?php echo new_html_entity_decode($s['nome']); ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>

                </div>
                <br><br>
                <table class="table dt-table">
                    <thead class="thead-custom">
                        <th>Nome LOPES</th>
                        <th>Descrição</th>
                        <th>Data Início</th>
                        <th>Data Fim</th>
                        <th>Estado</th>
                        <th></th>
                    </thead>
                    <tbody>
                        <?php
                            foreach($programa_lideranca as $item) {
                        ?>
                        <tr>
                            <td class="text-capitalize"> <?= htmlspecialchars($item['nome']); ?> </td>
                            <td class="text-capitalize"> <?= htmlspecialchars($item['descricao']); ?> </td>
                            <td class="text-capitalize"> <?= htmlspecialchars($item['data_inicio']); ?> </td>
                            <td class="text-capitalize"> <?= htmlspecialchars($item['data_fim']); ?> </td>
                            <td>
                                <?php
                                    $cor = "#999"; // Cor padrão (cinza para pendente)
                                    if ($item['status'] == "Aprovado") {
                                        $cor = "green";
                                    } elseif ($item['status'] == "Rejeitado") {
                                        $cor = "red";
                                    }
                                ?>
                                <a style="background-color: <?= $cor ?>; color:#fff; padding: 5px; border-radius:10px;">
                                    <?= htmlspecialchars($item['status']); ?>
                                </a>
                            </td>
                            <td>
                                <?php if ($item['status_id'] == 1) : ?>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/mapa_sucessao_aprovar/'.$item['id']); ?>"
                                    class="btn btn-success" style="color: white;">
                                    Aprovar
                                </a>
                                <a onclick="return confirm('Tens certteza que desejas rejeitar?');"
                                    href="<?php echo admin_url('plan_sucess_lideranca/mapa_sucessao_rejeitar/'.$item['id']); ?>"
                                    class="btn btn-danger" style="color: white;">
                                    Rejeitar
                                </a>
                                <?php endif ?>
                                <a href="javascript:;" data-id="<?= $item['id'] ?>"
                                    data-nome="<?= html_entity_decode($item['nome']) ?>"
                                    data-descricao="<?= html_entity_decode($item['descricao']) ?>"
                                    data-data_inicio="<?= html_entity_decode($item['data_inicio']) ?>"
                                    data-data_fim="<?= html_entity_decode($item['data_fim']) ?>"
                                    data-aprovadores='<?= html_entity_decode(($item["aprovadores"] ?? "")) ?>'
                                    class="btn btn-default btn-icon btn_edit_programa_lideranca"
                                    style="background-color: #007bff; border-color: #007bff;">
                                    <i style="color: white;" class="fa fa-edit"></i>
                                </a>
                                <a onclick="return confirm('Tens certteza que desejas eliminar este programa_lideranca?');"
                                    href="<?php echo admin_url('plan_sucess_lideranca/programa_lideranca_delete/'.$item['id']); ?>"
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
<div class="modal" id="modal_add_programa_lideranca" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <?= form_open(admin_url('plan_sucess_lideranca/adicionar_programa_lideranca'), array('method' => 'post')) ?>
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Adicionar Posicão Chave
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <?php echo render_input('nome','Nome<small class="req text-danger">*</small>'); ?>
                        </div>
                        <div class="form-group">
                            <?php echo render_textarea('descricao','Descrição<small class="req text-danger">*</small>'); ?>
                        </div>
                        <div class="form-group" app-field-wrapper="data_inicio">
                            <label for="data_inicio" class="control-label">
                                Data de Início <small class="req text-danger">*</small>
                            </label>
                            <input type="date" id="data_inicio" name="data_inicio" class="form-control">
                        </div>
                        <div class="form-group" app-field-wrapper="data_fim">
                            <label for="data_fim" class="control-label">
                                Data Fim <small class="req text-danger">*</small>
                            </label>
                            <input type="date" id="data_fim" name="data_fim" class="form-control">
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
<?= form_open(admin_url('plan_sucess_lideranca/editar_programa_lideranca'), array('method' => 'post', 'id' => 'form_edit_programa_lideranca')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Editar Posicão Chave </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <?php echo render_input('e_nome','Nome<small class="req text-danger">*</small>'); ?>
                        </div>
                        <div class="form-group">
                            <?php echo render_textarea('e_descricao','Descrição<small class="req text-danger">*</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="company" class="control-label">
                                Nivel Crítico <small class="req text-danger">*</small>
                            </label>
                            <select class="form-control" name="e_nivel_critico">
                                <option value=""></option>
                                <?php foreach ($nivel_critico as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['nome'] ?>
                                </option>
                                <?php endforeach ?>
                            </select>
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