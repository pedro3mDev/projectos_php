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
            <th>#</th>
            <th width="30%"><?php echo _l('classificacao'); ?></th>
            <th width="30%"><?php echo _l('description'); ?></th>
            <th><?php echo _l('options'); ?></th>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach($classificacoes as $c){
                $i++;
            ?>
            <tr>
                <td><?= $i ?></td>
                <td><?php echo html_entity_decode($c['nome']); ?></td>
                <td><?php echo html_entity_decode($c['descricao']); ?></td>
                <td>
                    <?php if(is_admin() || has_permission('mgv_configuracoes','','edit')){ ?>
                    <a href="javascript:;" data-id="<?= $c['id'] ?>"
                        data-classificacao="<?= html_entity_decode($c['nome']) ?>"
                        data-descricao="<?= html_entity_decode($c['descricao']) ?>"
                        class="btn btn-default btn-icon btn_edit_classificacao">
                        <i class="fa fa-edit"></i>
                    </a>
                    <?php } ?>

                    <?php if(is_admin() || has_permission('mgv_configuracoes','','delete')){ ?>
                    <a onclick="return confirm('Tens certteza que desejas eliminar esta classificacao?');"
                        href="<?php echo admin_url('gestao_viagens/delete_classificacao/'.$c['id']); ?>"
                        class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="modal" id="modal_add" tabindex="-1" role="dialog">
        <div class="modal-dialog w-25">
            <?= form_open(admin_url('gestao_viagens/add_classificacao'), array('method' => 'post')) ?>
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
                                    <?php echo render_input('classificacao','classificacao'); ?>
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

    <?= form_open(admin_url('politicas_empresa/editar_classificacao'), array('method' => 'post', 'id' => 'form_edit_classificacao')) ?>
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
                                    <?php echo render_input('e_classificacao','classificacao'); ?>
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