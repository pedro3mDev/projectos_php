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
            <th width="30%"><?php echo _l('Direção'); ?></th>
            <th width="30%"><?php echo _l('Pelorio'); ?></th>
            <th><?php echo _l('options'); ?></th>
        </thead>
        <tbody>
            <?php foreach($direcoes as $c){ ?>
            <tr>
                <td><?php echo html_entity_decode($c['nome']); ?></td>
                <td><?php echo html_entity_decode($c['pelorio']); ?></td>
                <td>
                    <?php if(is_admin() || has_permission('plp_configuracoes','','edit')){ ?>
                    <a href="javascript:;" data-id="<?= $c['id'] ?>"
                        data-direcao="<?= html_entity_decode($c['nome']) ?>"
                        data-pelorio="<?= html_entity_decode($c['pelorios_id']) ?>"
                        class="btn btn-default btn-icon btn_edit_direcao">
                        <i class="fa fa-edit"></i>
                    </a>
                    <?php } ?>

                    <?php if(is_admin() || has_permission('plp_configuracoes','','delete')){ ?>
                    <a onclick="return confirm('Tens certteza que desejas eliminar esta direcao?');"
                        href="<?php echo admin_url('politicas_empresa/delete_direcao/'.$c['id']); ?>"
                        class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="modal" id="modal_add" tabindex="-1" role="dialog">
        <div class="modal-dialog w-25">
            <?= form_open(admin_url('politicas_empresa/add_direcao'), array('method' => 'post')) ?>
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
                                    <label for="pelorio">Pelorio</label>
                                    <select name="pelorio" id="pelorio" class="form-control">
                                        <option value=""></option>
                                        <?php foreach ($pelorios as $c) : ?>
                                        <option value="<?= $c['id'] ?>"><?= $c['nome'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <?php echo render_input('direcao','Direção'); ?>
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

    <?= form_open(admin_url('politicas_empresa/editar_direcao'), array('method' => 'post', 'id' => 'form_edit_direcao')) ?>
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
                                    <label for="e_pelorio">Pelorio</label>
                                    <select name="e_pelorio" id="e_pelorio" class="form-control">
                                        <option value=""></option>
                                        <?php foreach ($pelorios as $c) : ?>
                                        <option value="<?= $c['id'] ?>"><?= $c['nome'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <?php echo render_input('e_direcao','direcao'); ?>
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