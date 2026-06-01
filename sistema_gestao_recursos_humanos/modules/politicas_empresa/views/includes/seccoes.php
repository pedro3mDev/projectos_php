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
            <th width="30%"><?php echo _l('Secção'); ?></th>
            <th width="30%"><?php echo _l('Departamento'); ?></th>
            <th><?php echo _l('options'); ?></th>
        </thead>
        <tbody>
            <?php foreach($seccoes as $c){ ?>
            <tr>
                <td><?php echo html_entity_decode($c['nome']); ?></td>
                <td><?php echo html_entity_decode($c['departamento']); ?></td>
                <td>
                    <?php if(is_admin() || has_permission('plp_configuracoes','','edit')){ ?>
                    <a href="javascript:;" data-id="<?= $c['id'] ?>" data-seccao="<?= html_entity_decode($c['nome']) ?>"
                        data-departamento="<?= html_entity_decode($c['departments_id']) ?>"
                        class="btn btn-default btn-icon btn_edit_seccao">
                        <i class="fa fa-edit"></i>
                    </a>
                    <?php } ?>

                    <?php if(is_admin() || has_permission('plp_configuracoes','','delete')){ ?>
                    <a onclick="return confirm('Tens certteza que desejas eliminar esta seccao?');"
                        href="<?php echo admin_url('politicas_empresa/delete_seccao/'.$c['id']); ?>"
                        class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="modal" id="modal_add" tabindex="-1" role="dialog">
        <div class="modal-dialog w-25">
            <?= form_open(admin_url('politicas_empresa/add_seccao'), array('method' => 'post')) ?>
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
                                    <label for="departamento">Departamento</label>
                                    <select name="departamento" id="departamento" class="form-control">
                                        <option value=""></option>
                                        <?php foreach ($departamentos as $c) : ?>
                                        <option value="<?= $c['departmentid'] ?>"><?= $c['name'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <?php echo render_input('seccao','Secção'); ?>
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

    <?= form_open(admin_url('politicas_empresa/editar_seccao'), array('method' => 'post', 'id' => 'form_edit_seccao')) ?>
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
                                    <label for="e_departamento">Departamento</label>
                                    <select name="e_departamento" id="e_departamento" class="form-control">
                                        <?php foreach ($departamentos as $c) : ?>
                                        <option value="<?= $c['departmentid'] ?>"><?= $c['name'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <?php echo render_input('e_seccao','Secção'); ?>
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