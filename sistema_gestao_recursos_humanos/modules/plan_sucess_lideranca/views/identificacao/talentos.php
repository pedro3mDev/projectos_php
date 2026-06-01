<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Plano de Sucessão e Liderança / Identificação / Talentos
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
                                    Talentos
                                </h4>
                                <hr />
                            </div>
                        </div>
                        </br>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="<?php echo admin_url('plan_sucess_lideranca/identificacao_resultado')?>"
                                    class="btn btn-success" style="color: white;">
                                    <i class="fa-regular "></i>
                                    Resultados 
                                </a>
                                <a href="#" data-toggle="modal" data-target="#modal_add_talento" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Adicionar Talento
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/potencial_desenvolvimento')?>"
                                    class="btn" style="background-color: #DAA520; border-color: #DAA520; color: white;">
                                    <i class="fa-regular "></i>
                                    Potencial Desenvolvimento
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/avaliacao_competencias')?>"
                                    class="btn" style="background-color: #86198f; border-color: #86198f; color: white;">
                                    <i class="fa-regular "></i>
                                    Avaliação de Competências
                                </a>
                            </div>  
                        </div>
                        </br>
                        <div class="row">
                            <div class=" col-md-3">
                            </div>
                            <div class=" col-md-3">
                                <select name="potencial_t_f" id="potencial_t_f" class="selectpicker" multiple="true"
                                    data-live-search="true" data-width="100%"
                                    data-none-selected-text="<?php echo _l('potencial'); ?>">
                                    <?php foreach($potencial as $s) { ?>
                                    <option value="<?php echo new_html_entity_decode($s['nome']); ?>">
                                        <?php echo new_html_entity_decode($s['nome']); ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class=" col-md-3">
                                <select name="desempenho_t_f" id="desempenho_t_f" class="selectpicker" multiple="true"
                                    data-live-search="true" data-width="100%"
                                    data-none-selected-text="<?php echo _l('desempenho'); ?>">
                                    <?php foreach($desempenhos as $s) { ?>
                                    <option value="<?php echo new_html_entity_decode($s['nome']); ?>">
                                        <?php echo new_html_entity_decode($s['nome']); ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class=" col-md-3">
                                <select name="estado_t_f" id="estado_t_f" class="selectpicker" multiple="true"
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
                                <th>Potencial</th>
                                <th>Desempenho</th>
                                <th>Competências</th>
                                <th>Estado</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php
                                            foreach($talentos as $item) {
                                        ?>
                                <tr>
                                    <td>
                                        <?= $item['firstname'] .' '.$item['lastname']; ?>
                                    </td>
                                    <td class="text-capitalize"> <?= $item['potencial']; ?> </td>
                                    <td class="text-capitalize"> <?= $item['desempenho']; ?> </td>
                                    <td class="text-capitalize"> <?= psl_competencias_talentos($item['id']); ?> </td>
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
                                        <a href="<?php echo admin_url('plan_sucess_lideranca/talento_aprovar/'.$item['id']); ?>"
                                            class="btn btn-success" style="color: white;">
                                            Aprovar
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas rejeitar?');"
                                            href="<?php echo admin_url('plan_sucess_lideranca/talento_rejeitar/'.$item['id']); ?>"
                                            class="btn btn-danger" style="color: white;">
                                            Rejeitar
                                        </a>
                                        <?php endif ?>
                                        <a href="<?php echo admin_url('plan_sucess_lideranca/identificacao_visualizar_talentos/'.$item['id'])?>" class="btn btn-success btn-icon">
                                                    <i style="color: white;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?= $item['id'] ?>"
                                            data-funcionario='<?= $item["staff_id"] ?>'
                                            data-potencial="<?= html_entity_decode($item['potencial_id']) ?>"
                                            data-desempenho="<?= html_entity_decode($item['desempenho_id']) ?>"
                                            data-competencias='<?= psl_competencias_talentos_array(($item["id"] ?? "")) ?>'
                                            data-aprovadores='<?= html_entity_decode(($item["aprovadores"] ?? "")) ?>'
                                            class="btn btn-default btn-icon btn_edit_talento"
                                            style="background-color: #007bff; border-color: #007bff;">
                                            <i style="color: white;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas eliminar este Talento?');"
                                            href="<?php echo admin_url('plan_sucess_lideranca/talento_delete/'.$item['id']); ?>"
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

<div class="modal" id="modal_add_talento" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <?= form_open(admin_url('plan_sucess_lideranca/adicionar_talento'), array('method' => 'post')) ?>
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Adicionar Talento
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
                                Potencial <small class="req text-danger">*</small>
                            </label>
                            <select class="form-control" name="potencial">
                                <option value=""></option>
                                <?php foreach ($potencial as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['nome'] ?>
                                </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="company" class="control-label">
                                Desempenho <small class="req text-danger">*</small>
                            </label>
                            <select class="form-control" name="desempenho">
                                <option value=""></option>
                                <?php foreach ($desempenhos as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['nome'] ?>
                                </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <?php
                            $selectedCompetencias = '';
                            echo render_select('competencias[]', $competencia, ['id', ['nome']], 'Competencias Avaliadas<span class="text-danger">*</span>', $selectedCompetencias, ['multiple' => true], [], '', '', false);
                            ?>
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
<?= form_open(admin_url('plan_sucess_lideranca/editar_talento'), array('method' => 'post', 'id' => 'form_edit_talento')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Editar Talento </h4>
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
                                Potencial <small class="req text-danger">*</small>
                            </label>
                            <select class="form-control" name="e_potencial">
                                <option value=""></option>
                                <?php foreach ($potencial as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['nome'] ?>
                                </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="company" class="control-label">
                                Desempenho <small class="req text-danger">*</small>
                            </label>
                            <select class="form-control" name="e_desempenho">
                                <option value=""></option>
                                <?php foreach ($desempenhos as $t) : ?>
                                <option value="<?= $t['id'] ?>"><?= $t['nome'] ?>
                                </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <?php
                            $selectedCompetencias = '';
                            echo render_select('e_competencias[]', $competencia, ['id', ['nome']], 'Competencias Avaliadas<span class="text-danger">*</span>', $selectedCompetencias, ['multiple' => true], [], '', '', false);
                            ?>
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
// talento
$('.btn_edit_talento').click(function() {
    let funcionario = $(this).attr('data-funcionario');
    let potencial = $(this).attr('data-potencial');
    let desempenho = $(this).attr('data-desempenho');
    let competencias = $(this).attr('data-competencias');
    let aprovadores = $(this).attr('data-aprovadores');

    let id = $(this).attr('data-id');

    let url = "<?= admin_url('plan_sucess_lideranca/editar_talento') ?>/" + id;
    $('#form_edit_talento').attr('action', url);

    $('select[name="e_funcionario"]').selectpicker('val', funcionario);
    $('select[name="e_potencial"]').val(potencial);
    $('select[name="e_desempenho"]').val(desempenho);
    $('select[name="e_competencias[]"]').selectpicker('val', JSON.parse(competencias));
    $('select[name="e_aprovadores[]"]').selectpicker('val', JSON.parse(aprovadores));

    $('#editar').modal('show');
})
$('#potencial_t_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(1).search(this.value).draw();
})
$('#desempenho_t_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(2).search(this.value).draw();
})
$('#estado_t_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(4).search(this.value).draw();
})
</script>