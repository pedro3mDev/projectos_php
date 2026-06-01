<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div>
    <div class="_buttons">
        <?php if(is_admin() || has_permission('hrm_setting','','create')){ ?>
        <a href="#" data-toggle="modal" data-target="#dpt" class="btn btn-info pull-left display-block">
            <?php echo _l('hr_hr_add'); ?>
        </a>
        <?php } ?>
    </div>
    <div class="clearfix"></div>
    <br>
    <table class="table dt-table">
        <thead>
            <th width="30%"><?php echo _l('Departamento Nome'); ?></th>
            <th><?php echo _l('Departamento Email'); ?></th>
            <th><?php echo _l('Direções'); ?></th>
            <th><?php echo _l('options'); ?></th>
        </thead>
        <tbody>
            <?php foreach($dpt as $c){ ?>
            <tr>

                <td><?php echo html_entity_decode($c['name']); ?></td>
                <td><?php echo $c['email']; ?></td>
                <td><span
                        class="label label-tag "><?php echo get_direcao_by_id($c['direcoes_id'])->nome ?? ''; ?></span>
                </td>
                <td>
                    <?php if(is_admin() || has_permission('hrm_setting','','edit')){ ?>
                    <a data-id="<?php echo $c['departmentid'];?>" data-nome="<?php echo $c['name'];?>"
                        data-email="<?php echo $c['email'];?>" data-direcoes_id="<?php echo $c['direcoes_id'];?>"
                        href="#" class="btn btn-default btn-icon btn_edit"><i class="fa fa-edit"></i></a>
                    <?php } ?>

                    <?php if(is_admin() || has_permission('hrm_setting','','delete')){ ?>
                    <a href="<?php echo admin_url('hr_profile/delete_departments/'.$c['departmentid']); ?>"
                        class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>
                    <?php } ?>

                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="modal" id="dpt" tabindex="-1" role="dialog">
        <div class="modal-dialog w-25">
            <form method="get" action="<?php echo admin_url('hr_profile/add_departments'); ?>">

                <div class="modal-content ">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">
                            Adicionar departamento
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="form">
                                    <div class="col-md-12">
                                        <?php 
									echo render_input('name_dpt','Nome<span class="text-danger">*</span>'); ?>
                                    </div>
                                    <div class="col-md-12">
                                        <?php 
									echo render_input('email_dpt','Email'); ?>
                                    </div>
                                    <div class="col-md-12">
                                        <select name="direcao_id" class="selectpicker" id="" data-width="100%"
                                            data-actions-box="true" data-live-search="true"
                                            data-none-selected-text="<?php echo _l('Direções'); ?>">
                                            <?php 
												foreach ($opt_direcoes as $value) { ?>
                                            <option value="<?php echo new_html_entity_decode($value['id']); ?>">
                                                <?php echo new_html_entity_decode($value['nome']) ?></option>
                                            <?php }
											?>
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default"
                            data-dismiss="modal"><?php echo _l('hr_close'); ?></button>
                        <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
                    </div>
                </div><!-- /.modal-content -->
            </form>
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal" id="editar_dpt" tabindex="-1" role="dialog">
        <div class="modal-dialog w-25">

            <div class="modal-content ">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">
                        Editar departamento
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="form">
                                <div class="col-md-12">
                                    <?php 
									echo render_input('name','name'); ?>
                                </div>
                                <div class="col-md-12">
                                    <?php 
									echo render_input('email','Email'); ?>
                                </div>
                                <div class="col-md-12">
                                    <select name="direcao_id" class="selectpicker" id="e_direcao_id" data-width="100%"
                                        data-actions-box="true" data-live-search="true"
                                        data-none-selected-text="<?php echo _l('Direções'); ?>">
                                        <?php 
												foreach ($opt_direcoes as $value) { ?>
                                        <option value="<?php echo new_html_entity_decode($value['id']); ?>">
                                            <?php echo new_html_entity_decode($value['nome']) ?></option>
                                        <?php }
											?>
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                        data-dismiss="modal"><?php echo _l('hr_close'); ?></button>
                    <button id='btn_conf_edit' type="button" class="btn btn-info"><?php echo _l('submit'); ?></button>
                </div>
            </div><!-- /.modal-content -->

        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


</div>
</body>

<script>



</script>

</html>