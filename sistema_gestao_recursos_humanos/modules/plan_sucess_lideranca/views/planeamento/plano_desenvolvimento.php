<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <?php
            $data_view = [];
            $this->load->view('/admin/menu_modulo/menu', $data_view);
        ?>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Plano de Sucessão e Liderança / Planejamento
                </a>
            </div>
            <div class="col-md-2" style=" display: flex; justify-content: flex-end; align-items: center;">
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
                                <h4 class="font-bold no-margin"><i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Plano de Desenvolvimento
                                </h4>
                                <hr />
                            </div>
                        </div>
                        </br>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="<?php echo admin_url('plan_sucess_lideranca/planeamento_resultado')?>"
                                    class="btn btn-success" style="color: white;">
                                    <i class="fa-regular "></i>
                                    Resultados
                                </a>
                                <a href="#" data-toggle="modal" data-target="#modal_add_plano_desenvolvimento"
                                    class="btn" style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Adicionar Plano de Desenvolvimento
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/posicao_chave')?>" class="btn"
                                    style="background-color: #44403c; border-color: #44403c; color: white;">
                                    <i class="fa-regular "></i>
                                    Posição Chave
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/planeamento')?>" class="btn"
                                    style="background-color: #DAA520; border-color: #DAA520; color: white;">
                                    <i class="fa-regular "></i>
                                    Mapa de Sucessão
                                </a>
                            </div>
                            <div class=" col-md-6">
                            </div>
                            <div class=" col-md-3">
                                <select name="competencia_pd_f" id="competencia_pd_f" class="selectpicker"
                                    multiple="true" data-live-search="true" data-width="100%"
                                    data-none-selected-text="<?php echo _l('competencia'); ?>">
                                    <?php foreach($competencia as $s) { ?>
                                    <option value="<?php echo new_html_entity_decode($s['nome']); ?>">
                                        <?php echo new_html_entity_decode($s['nome']); ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class=" col-md-3">
                                <select name="estado_pd_f" id="estado_pd_f" class="selectpicker" multiple="true"
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
                                <th>Funcionário</th>
                                <th>Cargo</th>
                                <th>Competência em Falta</th>
                                <th>Posição Chave</th>
                                <th>Nivel Critico</th>
                                <th>Treinamento Sugerido</th>
                                <th>Estado</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($plano_desenvolvimento as $item) {
                                ?>
                                <tr>
                                    <td>
                                        <?= $item['firstname'] .' '.$item['lastname']; ?>
                                    </td>
                                    <td class="text-capitalize"> <?= $item['cargo']; ?> </td>
                                    <td class="text-capitalize"> <?= $item['competencia']; ?> </td>
                                    <td class="text-capitalize"> <?= $item['posicao_chave']; ?> </td>
                                    <td class="text-capitalize"> <?= $item['nivel_critico']; ?> </td>
                                    <td class="text-capitalize"> <?= $item['treinamento_sugerido']; ?> </td>
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
                                        <a href="<?php echo admin_url('plan_sucess_lideranca/plano_desenvolvimento_aprovar/'.$item['id']); ?>"
                                            class="btn btn-success" style="color: white;">
                                            Aprovar
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas rejeitar?');"
                                            href="<?php echo admin_url('plan_sucess_lideranca/plano_desenvolvimento_rejeitar/'.$item['id']); ?>"
                                            class="btn btn-danger" style="color: white;">
                                            Rejeitar
                                        </a>
                                        <?php endif ?>
                                        <a href="<?php echo admin_url('plan_sucess_lideranca/planeamento_visualizar_plano/'.$item['id'])?>" class="btn btn-success btn-icon">
                                                    <i style="color: white;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?= $item['id'] ?>"
                                            data-funcionario='<?= $item["staff_id"] ?>'
                                            data-posicao_chave='<?= $item["posicao_chave_id"] ?>'
                                            data-mapa_sucessao='<?= $item["mapa_sucessao_id"] ?>'
                                            data-nivel_critico='<?= $item["nivel_critico_id"] ?>'
                                            data-treinamento_sugerido="<?= html_entity_decode($item['treinamento_sugerido']) ?>"
                                            data-aprovadores='<?= html_entity_decode(($item["aprovadores"] ?? "")) ?>'
                                            class="btn btn-default btn-icon btn_edit_plano_desenvolvimento"
                                            style="background-color: #007bff; border-color: #007bff;">
                                            <i style="color: white;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas eliminar este Plano de Desenvolvimento?');"
                                            href="<?php echo admin_url('plan_sucess_lideranca/plano_desenvolvimento_delete/'.$item['id']); ?>"
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
        <div class="clearfix"></div>
    </div>
    <div class="btn-bottom-pusher"></div>
</div>
</div>
<div id="new_version"></div>

<div class="modal" id="modal_add_plano_desenvolvimento" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <?= form_open(admin_url('plan_sucess_lideranca/adicionar_plano_desenvolvimento'), array('method' => 'post')) ?>
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Adicionar Plano de Desenvolvimento
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
                            echo render_select('funcionario', $staffs, ['staffid', ['firstname', 'lastname']], 'Funcionário<span class="text-danger">*</span>', $selectedStaff, [], [], '', '', true);
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="company" class="control-label">
                                <?php echo _l('Mapa de Sucessão'); ?> <small class="req text-danger">*</small>
                            </label>
                            <select name="mapa_sucessao" id="mapa_sucessao" class="selectpicker" data-live-search="true"
                                data-width="100%" data-none-selected-text="<?php echo _l('mapa_sucessao'); ?>">
                                <option value=""></option>
                                <?php foreach ($mapa_sucessao as $t) : ?>
                                <option value="<?= $t['id'] ?>">Cargo: <?= $t['cargo'] ?> - Competência em Falta:
                                    <?= $t['competencia'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="company" class="control-label">
                                <?php echo _l('posicao_chave'); ?> <small class="req text-danger">*</small>
                            </label>
                            <select name="posicao_chave" id="posicao_chave" class="selectpicker" data-live-search="true"
                                data-width="100%" data-none-selected-text="<?php echo _l('posicao_chave'); ?>">
                                <option value=""></option>
                                <?php foreach ($posicao_chave as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['nome'] ?> - Nivel Critico:
                                    <?= $t['nivel_critico'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="company" class="control-label">
                                Sugestão de Treinamento <small class="req text-danger">*</small>
                            </label>
                            <textarea class="form-control" style="min-height: 80px;"
                                name="sugestao_treinamento"></textarea>
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
<?= form_open(admin_url('plan_sucess_lideranca/editar_plano_desenvolvimento'), array('method' => 'post', 'id' => 'form_edit_plano_desenvolvimento')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Editar Plano de Desenvolvimento </h4>
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
                            echo render_select('e_funcionario', $staffs, ['staffid', ['firstname', 'lastname']], 'Funcionário<span class="text-danger">*</span>', $selectedStaff, [], [], '', '', true);
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="company" class="control-label">
                                <?php echo _l('Mapa de Sucessão'); ?> <small class="req text-danger">*</small>
                            </label>
                            <select name="e_mapa_sucessao" id="mapa_sucessao" class="selectpicker"
                                data-live-search="true" data-width="100%"
                                data-none-selected-text="<?php echo _l('mapa_sucessao'); ?>">
                                <option value=""></option>
                                <?php foreach ($mapa_sucessao as $t) : ?>
                                <option value="<?= $t['id'] ?>">Cargo: <?= $t['cargo'] ?> - Competência em Falta:
                                    <?= $t['competencia'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="company" class="control-label">
                                <?php echo _l('posicao_chave'); ?> <small class="req text-danger">*</small>
                            </label>
                            <select name="e_posicao_chave" id="posicao_chave" class="selectpicker"
                                data-live-search="true" data-width="100%"
                                data-none-selected-text="<?php echo _l('posicao_chave'); ?>">
                                <option value=""></option>
                                <?php foreach ($posicao_chave as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['nome'] ?> - Nivel Critico:
                                    <?= $t['nivel_critico'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="company" class="control-label">
                                Sugestão de Treinamento <small class="req text-danger">*</small>
                            </label>
                            <textarea class="form-control" style="min-height: 80px;"
                                name="e_sugestao_treinamento"></textarea>
                        </div>
                        <div class="form-group">
                            <?php
                            $selectedStaff = '';
                            echo render_select('e_aprovadores[]', $staff_list, ['staffid', ['firstname', 'lastname']], 'Aprovadores<span class="text-danger">*</span>', $selectedStaff, ['multiple' => true], [], '', '', false);
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
    </div>
</div>
<?= form_close()  ?>

<?php init_tail(); ?>
<script>
$('.btn_edit_plano_desenvolvimento').click(function() {
    let funcionario = $(this).attr('data-funcionario');
    let treinamento_sugerido = $(this).attr('data-treinamento_sugerido');
    let posicao_chave = $(this).attr('data-posicao_chave');
    let mapa_sucessao = $(this).attr('data-mapa_sucessao');
    let aprovadores = $(this).attr('data-aprovadores');

    let id = $(this).attr('data-id');

    let url = "<?= admin_url('plan_sucess_lideranca/editar_plano_desenvolvimento') ?>/" + id;
    $('#form_edit_plano_desenvolvimento').attr('action', url);

    $('select[name="e_funcionario"]').selectpicker('val', funcionario);
    $('select[name="e_posicao_chave"]').selectpicker('val', posicao_chave);
    $('select[name="e_mapa_sucessao"]').selectpicker('val', mapa_sucessao);
    $('textarea[name="e_sugestao_treinamento"]').text(treinamento_sugerido);
    $('select[name="e_aprovadores[]"]').selectpicker('val', JSON.parse(aprovadores));

    $('#editar').modal('show');
})
$('#competencia_pd_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(1).search(this.value).draw();
})
$('#estado_pd_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(2).search(this.value).draw();
})
</script>