<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div>
    <div class="_buttons">
        <?php if(is_admin() || has_permission('plp_configuracoes','','create')){ ?>
        <a href="#" data-toggle="modal" data-target="#modal_add" class="btn btn-info pull-left display-block">
            <?php echo _l('pl_add'); ?>
        </a>
        <?php } ?>
    </div>
    <div class="clearfix"></div>
    <br>
    <table class="table dt-table">
        <thead>
            <th width="30%"><?php echo _l('conselhos'); ?></th>
            <th width="30%"><?php echo _l('Responsável'); ?></th>
            <th><?php echo _l('options'); ?></th>
        </thead>
        <tbody>
            <?php foreach($conselhos as $c){ ?>
            <tr>
                <td><?php echo html_entity_decode($c['nome']); ?></td>
                <td>
                    <?php echo html_entity_decode($c['firstname'] ?? ''); ?>
                    <?php echo html_entity_decode($c['lastname'] ?? ''); ?>
                </td>
                <td>
                    <?php if(is_admin() || has_permission('plp_configuracoes','','edit')){ ?>
                    <a data-id="<?= $c['id'] ?>" data-conselho="<?= html_entity_decode($c['nome']) ?>"
                        data-responsavel="<?= html_entity_decode($c['gerente_id'] ?? '') ?>" href="javascript:;"
                        class="btn btn-default btn-icon btn_edit_conselho">
                        <i class="fa fa-edit"></i>
                    </a>
                    <?php } ?>

                    <?php if(is_admin() || has_permission('plp_configuracoes','','delete')){ ?>
                    <a onclick="return confirm('Tens certteza que desejas eliminar esta conselho?');"
                        href="<?php echo admin_url('configuracoes/delete_conselho/'.$c['id']); ?>"
                        class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="modal" id="modal_add" tabindex="-1" role="dialog">
        <div class="modal-dialog w-25">
            <?= form_open(admin_url('configuracoes/add_conselho'), array('method' => 'post')) ?>
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
                        <div class="col-md-12">
                            <div class="form">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="staff"
                                            class="control-label"><?php echo _l('Responsável'); ?></label>
                                        <select name="staff" id="staff" data-live-search="true" class="selectpicker"
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
                                    <?php echo render_input('conselho','Conselho'); ?>
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
            <?= form_close()  ?>
        </div>
    </div>

    <?= form_open(admin_url('configuracoes/editar_conselho'), array('method' => 'post', 'id' => 'form_edit_conselho')) ?>
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
                                    <?php echo render_input('e_conselho','conselho'); ?>
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
</div>