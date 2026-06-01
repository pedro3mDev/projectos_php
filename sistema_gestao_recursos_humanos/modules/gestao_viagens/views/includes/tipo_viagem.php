<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div>
    <div class="_buttons">
        <?php if(is_admin() || has_permission('mgv_configuracoes','','create')){ ?>
        <a href="#" data-toggle="modal" data-target="#modal_add" class="btn btn-info pull-left display-block">
            <?php echo _l('pl_add'); ?>
        </a>
        <?php } ?>
    </div>
    <div class="clearfix"></div>
    <br>
    <table class="table dt-table">
        <thead>
            <th width="30%"><?php echo _l('tipo_viagem'); ?></th>
            <th width="30%"><?php echo _l('description'); ?></th>
            <th><?php echo _l('options'); ?></th>
        </thead>
        <tbody>
            <?php foreach($tipo_viagens as $c){ ?>
            <tr>
                <td><?php echo html_entity_decode($c['tipo_viagem']); ?></td>
                <td><?php echo html_entity_decode($c['descricao'] ?? ''); ?></td>
                <td>
                    <?php if ($c['id'] != 1) : ?>
                    <?php if(is_admin() || has_permission('mgv_configuracoes','','edit')){ ?>
                    <a href="javascript:;" data-id="<?= $c['id'] ?>"
                        data-tipo_viagem="<?= html_entity_decode($c['tipo_viagem']) ?>"
                        data-descricao="<?= html_entity_decode($c['descricao'] ?? '') ?>"
                        class="btn btn-default btn-icon btn_edit_tipo_viagem">
                        <i class="fa fa-edit"></i>
                    </a>
                    <?php } ?>

                    <?php if(is_admin() || has_permission('mgv_configuracoes','','delete')){ ?>
                    <a onclick="return confirm('Tens certteza que desejas eliminar esta tipo_viagem?');"
                        href="<?php echo admin_url('gestao_viagens/delete_tipo_viagem/'.$c['id']); ?>"
                        class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>
                    <?php } ?>
                    <?php endif ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="modal" id="modal_add" tabindex="-1" role="dialog">
        <div class="modal-dialog w-25">
            <?= form_open(admin_url('gestao_viagens/add_tipo_viagem'), array('method' => 'post')) ?>
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
                                    <?php echo render_input('tipo_viagem','tipo_viagem'); ?>
                                </div>
                                <div class="col-md-12">
                                    <?php echo render_textarea('descricao','Descrição'); ?>
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

    <?= form_open(admin_url('politicas_empresa/editar_tipo_viagem'), array('method' => 'post', 'id' => 'form_edit_tipo_viagem')) ?>
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
                                    <?php echo render_input('e_tipo_viagem','Tipo de Viagem'); ?>
                                </div>
                                <div class="col-md-12">
                                    <?php echo render_textarea('e_descricao','Descrição'); ?>
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