<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href=""
                    style="font-size: 16px; color: #333;">
                    Plano de Sucessão e Liderança / Plano de Aquisição de Competência
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
                                        Plano de Aquisição de Competência
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
                                    Novo Plano
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/competencias')?>"
                                    class="btn"
                                    style="background-color: #DAA520; border-color: #DAA520; color: white;">
                                    <i class="fa-regular "></i>
                                    Gestão de Competências
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/competencias_avaliacao2')?>"
                                    class="btn"
                                    style="background-color: #65a30d; border-color: #65a30d; color: white;">
                                    <i class="fa-regular "></i>
                                    Avaliação de Competênciasa
                                </a>
                            </div>
                        </div>

                        <div class="row">
                            <div class=" col-md-6">
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
                            <div class=" col-md-3">
                                <select name="competencia_f" id="competencia_f"
                                    class="selectpicker" multiple="true"
                                    data-live-search="true" data-width="100%"
                                    data-none-selected-text="<?php echo _l('Competencia'); ?>">
                                    <option value=""></option>
                                    <?php foreach($competencia as $s) { ?>
                                    <option value="<?php echo new_html_entity_decode($s['nome']); ?>">
                                        <?php echo new_html_entity_decode($s['nome']); ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <br><br>

                        <table class="table table-hover table-bordered table-responsive dt-table">
                            <thead class="thead-custom">
                                <th>Funcionário</th>
                                <th>Competencia</th>
                                <th>Data Prevista</th>
                                <th>Estado</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach($plano_aquisicao_competencia as $item) : ?>
                                <tr>
                                    <td class="text-capitalize"> <?= htmlspecialchars($item['firstname'] .' '.$item['lastname']); ?> </td>
                                    <td class="text-capitalize"> <?= htmlspecialchars($item['competencia']); ?> </td>
                                    <td class="text-capitalize"> <?= htmlspecialchars($item['data_prevista']); ?> </td>
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
                                        <a href="<?php echo admin_url('plan_sucess_lideranca/plano_aquisicao_competencia_aprovar/'. $item['id']); ?>"
                                            class="btn btn-success" style="color: white;">
                                            Aprovar
                                        </a>
                                        <a onclick="return confirm('Tens certeza que desejas rejeitar?');"
                                            href="<?php echo admin_url('plan_sucess_lideranca/plano_aquisicao_competencia_rejeitar/'. $item['id']); ?>"
                                            class="text-white btn btn-danger"
                                            style="background-color:#FFA500; border-color:#FFA500; color:#fff;">
                                            Rejeitar
                                        </a>
                                        <?php endif ?>
                                        <a href="<?php echo admin_url('plan_sucess_lideranca/competencias_visualizar_aquisicao/'. $item['id'])?>" data-id="" class="btn btn-sucess btn-icon btn_edit_orcamento"
                                            style="background-color: #3CB371; border-color: #3CB371; color: white;">
                                            <i style="color:#fff;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?= $item['id'] ?>"
                                            data-funcionario="<?= html_entity_decode($item['staff_id']) ?>"
                                            data-competencia="<?= html_entity_decode($item['competencia_id']) ?>"
                                            data-data_prevista="<?= html_entity_decode($item['data_prevista']) ?>"
                                            data-aprovadores='<?= html_entity_decode($item["aprovadores"]) ?>'
                                            class="btn btn-default btn-icon btn_edit_plano_aquisicao_competencia"
                                            style="background-color: #007bff; border-color: #007bff; color: white;">
                                            <i style="color:#fff;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certeza que desejas eliminar?');"
                                            href="<?php echo admin_url('plan_sucess_lideranca/plano_aquisicao_competencia_delete/'.$item['id'])?>"
                                            class="btn btn-danger btn-icon _delete">
                                            <i style="color:#fff;" class="fa fa-trash"></i>
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
        <div class="clearfix"></div>
    </div>
    <div class="btn-bottom-pusher"></div>
</div>
</div>

<div id="new_version"></div> 
<div class="modal" id="modal_add" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <?= form_open(admin_url('plan_sucess_lideranca/adicionar_plano_aquisicao_competencia'), array('method' => 'post')) ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Novo Plano</h4>
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
                            <?php
                            $selectedCompetencias = '';
                            echo render_select('competencia', $competencia, ['id', ['nome']], 'Competência<span class="text-danger">*</span>', $selectedCompetencias, [], [], '', '', true);
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="data_prevista" class="control-label">
                                Data Prevista
                                <small class="req text-danger">*</small>
                            </label>
                            <input type="date" class="form-control" name="data_prevista" id="data_prevista">
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

<?= form_open(admin_url('plan_sucess_lideranca/editar_plano_aquisicao_competencia'), array('method' => 'post', 'id' => 'form_edit_plano_aquisicao_competencia')) ?>
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
                            <?php
                            $selectedStaff = '';
                            echo render_select('e_funcionario', $staffs, ['staffid', ['firstname', 'lastname']], 'Funcionário<span class="text-danger">*</span>', $selectedStaff, [], [], '', '', true);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php
                            $selectedCompetencias = '';
                            echo render_select('e_competencia', $competencia, ['id', ['nome']], 'Competência<span class="text-danger">*</span>', $selectedCompetencias, [], [], '', '', true);
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="data_prevista" class="control-label">
                                Data Prevista
                                <small class="req text-danger">*</small>
                            </label>
                            <input type="date" class="form-control" name="e_data_prevista" id="data_prevista">
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
                <button type="button" class="btn btn-default"
                    data-dismiss="modal"><?php echo _l('pl_close'); ?></button>
                <button type="submit"
                    class="btn btn-info"><?php echo _l('submit'); ?></button>
            </div>
        </div>
    </div>
</div>
<?= form_close()  ?>

<?php init_tail(); ?>
<script>
$('.btn_edit_plano_aquisicao_competencia').click(function() {
    let funcionario = $(this).attr('data-funcionario');
    let data_prevista = $(this).attr('data-data_prevista');
    let competencia = $(this).attr('data-competencia');
    let aprovadores = $(this).attr('data-aprovadores');

    let id = $(this).attr('data-id');

    let url = "<?= admin_url('plan_sucess_lideranca/editar_plano_aquisicao_competencia') ?>/" + id;
    $('#form_edit_plano_aquisicao_competencia').attr('action', url);

    $('select[name="e_funcionario"]').selectpicker('val', funcionario);
    $('input[name="e_data_prevista"]').val(data_prevista);
    $('select[name="e_competencia"]').selectpicker('val', competencia);
    $('select[name="e_aprovadores[]"]').selectpicker('val', JSON.parse(aprovadores));

    $('#editar').modal('show');
})
$('#estado_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(3).search(this.value).draw();
})
$('#competencia_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(1).search(this.value).draw();
})
</script>