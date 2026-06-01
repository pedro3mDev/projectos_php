<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <?php 
            $data_view = [];
            $this->load->view('/admin/menu_modulo/menu', $data_view);
        ?>
        <div class="row">
            <div class="col-md-6">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Integração / Hierarquia
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
                <?php if($email_exist_as_staff){ ?>
                <div class="alert alert-danger">
                    Some of the departments email is used as staff member email, according to the docs, the support
                    department email must be unique email in the system, you must change the staff email or the support
                    department email in order all the features to work properly.
                </div>
                <?php } ?>
                <div class="panel_s">
                    <div class="panel-body" style="height: 120vh;">

                        <div class="row">
                            <div class="col-md-12" id="dp_chart">
                                <div id="department_chart" style="overflow: scroll; position: absolute; height: 100vh;">
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <hr class="hr-panel-heading" />
                        <div class="clearfix"></div>
                        <?php
                            // render_datatable(array(
                            //     _l('hr_hr_id'),
                            //     _l('department_list_name'),
                            //     _l('hr_parent_unit'),
                            //     _l('hr_manager_unit'),
                            //     _l('hr_unit_email'),
                            //     _l('department_calendar_id'),
                            //     _l('options')
                            // ),'departments');
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= form_open(admin_url('hr_profile/editar_responsavel_conselho'), array('method' => 'post', 'id' => 'form_edit_conselho')) ?>
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
                    <div class="col-md-12">
                        <div class="form">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="e_staff" class="control-label"><?php echo _l('Responsável'); ?><span
                                            class="text-danger">*</span></label>
                                    <select name="e_staff" id="e_staff" data-live-search="true" class="selectpicker"
                                        data-actions-box="true" data-width="100%"
                                        data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <option value=""></option>
                                        <?php foreach($staffs as $t){ ?>
                                        <option value="<?php echo html_entity_decode($t['staffid']); ?>">
                                            <?php echo html_entity_decode($t['firstname'] .' '.$t['lastname']); ?>
                                        </option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="e_staff" class="control-label"><?php echo _l('conselho'); ?><span
                                        class="text-danger">*</span></label>
                                <input type="text" name="e_conselho" class="form-control" disabled>
                            </div>
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
<!-- view chart in sidebar end -->
<?php init_tail(); ?>
<?php require('modules/hr_profile/assets/js/organizational/organizational_js.php'); ?>
<script>
$(document).on('click', '.btn_edit_conselho', function() {
    // let conselho = $(this).attr('data-conselho');
    // let responsavel = $(this).attr('data-responsavel');
    // let id = $(this).attr('data-id');

    // let url = "<?= admin_url('hr_profile/editar_responsavel_conselho') ?>/" + id;
    // $('#form_edit_conselho').attr('action', url);
    // $('select[name="e_staff"]').selectpicker('val', responsavel);
    // $('input[name="e_conselho"]').val(conselho);

    $('#editar').modal('show');
})
</script>
</body>

</html>