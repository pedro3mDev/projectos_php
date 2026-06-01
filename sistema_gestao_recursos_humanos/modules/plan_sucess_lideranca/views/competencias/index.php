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
                Plano de Sucessão e Liderança / Competencias
                </a>
            </div>
            <div class="col-md-2" style=" display: flex; justify-content: flex-end; align-items: center;">
				<button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
					<i class="fas fa-reply"></i> Retroceder
				</button>
            </div>
        </div>
   
        </br>
        <?php require 'modules/plan_sucess_lideranca/views/competencias/cards.php'; ?>
    
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Gestão de Competências 
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">

                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white; ">
                                    <i class="fa-regular "></i>
                                    Nova Gestão de Competências 
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/competencias_avaliacao2')?>"
                                    class="btn" style="background-color: #65a30d; border-color: #65a30d; color: white;">
                                    <i class="fa-regular "></i>
                                    Avaliação de Competências
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/competencias_aquisicao')?>"
                                    class="btn" style="background-color: #b91c1c; border-color: #b91c1c; color: white;">
                                    <i class="fa-regular "></i>
                                    Plano de Aquisição de Competência
                                </a>
                            </div>

                        </div>
                        <div class="row">
                            <div class=" col-md-9">
                            </div>
                            <div class=" col-md-3">
                                <select name="estado_f" id="estado_f" class="selectpicker" multiple="true"
                                    data-live-search="true" data-width="100%"
                                    data-none-selected-text="<?php echo _l('Estado'); ?>">
                                    <option value=""></option> 
                                </select>
                            </div>
                        </div>
                        <br><br>
                        <table class="table table-hover table-bordered table-responsive dt-table">
                            <thead class="thead-custom">
                                <th>Competência</th>
                                <th>Cargo</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach($competencia_cargo as $item) : ?>
                                <tr>
                                    <td class="text-capitalize"> <?= htmlspecialchars($item['competencia']); ?> </td>
                                    <td class="text-capitalize"> <?= htmlspecialchars($item['cargo']); ?> </td>
                                    <td>
                                    <a href="<?php echo admin_url('plan_sucess_lideranca/competencias_visualizar_competencias/'.$item['id'])?>" data-id="" class="btn btn-sucess btn-icon btn_edit_orcamento"
                                            style="background-color: #3CB371; border-color: #3CB371; color: white;">
                                            <i style="color:#fff;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?= $item['id'] ?>"
                                            data-competencia="<?= html_entity_decode($item['competencia_id']) ?>"
                                            data-cargo="<?= html_entity_decode($item['cargo_id']) ?>"
                                            class="btn btn-default btn-icon btn_edit_competencia_cargo"
                                            style="background-color: #007bff; border-color: #007bff; color: white;">
                                            <i style="color:#fff;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certeza que desejas eliminar?');"
                                            href="<?php echo admin_url('plan_sucess_lideranca/competencia_cargo_delete/'.$item['id'])?>"
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
        <?= form_open(admin_url('plan_sucess_lideranca/adicionar_competencia_cargo'), array('method' => 'post')) ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">
                    Nova Gestão de Competências
                </h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="cargo" class="control-label">
                                Cargo <small class="req text-danger">*</small>
                            </label>
                            <select class="form-control" name="cargo">
                                <option value=""></option>
                                <?php foreach ($cargos as $t) : ?>
                                <option value="<?= $t['position_id'] ?>"><?= $t['position_name'] ?>
                                </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <?php
                            $selectedCompetencias = '';
                            echo render_select('competencia', $competencia, ['id', ['nome']], 'Competência<span class="text-danger">*</span>', $selectedCompetencias, [], [], '', '', true);
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
        <?= form_close() ?>
    </div>
</div>


<?= form_open(admin_url('plan_sucess_lideranca/editar_competencia_cargo'), array('method' => 'post', 'id' => 'form_edit_competencia_cargo')) ?>
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
                            <label for="cargo" class="control-label">
                                Cargo <small class="req text-danger">*</small>
                            </label>
                            <select class="form-control" name="e_cargo">
                                <option value=""></option>
                                <?php foreach ($cargos as $t) : ?>
                                <option value="<?= $t['position_id'] ?>"><?= $t['position_name'] ?>
                                </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <?php
                            $selectedCompetencias = '';
                            echo render_select('e_competencia', $competencia, ['id', ['nome']], 'Competência<span class="text-danger">*</span>', $selectedCompetencias, [], [], '', '', true);
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

<?php init_tail(); ?>
<script>
    // programa_lideranca
$('.btn_edit_competencia_cargo').click(function() {
    let competencia = $(this).attr('data-competencia');
    let cargo = $(this).attr('data-cargo');

    let id = $(this).attr('data-id');

    let url = "<?= admin_url('plan_sucess_lideranca/editar_competencia_cargo') ?>/" + id;
    $('#form_edit_competencia_cargo').attr('action', url);

    $('select[name="e_cargo"]').selectpicker('val', cargo);
    $('select[name="e_competencia"]').selectpicker('val', competencia);

    $('#editar').modal('show');
})
$('#estado_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(4).search(this.value).draw();
})
$('#programa_lideranca_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(0).search(this.value).draw();
})
</script>