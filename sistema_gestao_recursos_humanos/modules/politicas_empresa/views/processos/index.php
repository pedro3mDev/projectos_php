<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">

    <div class="content">
    </br></br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-6">
                <a class="dashboard-link" href=""
                    style="font-size: 16px; color: #333;">
                    Politicas de Empresa / Processos  
                </a>
            </div>
            <div class="col-md-6"
                style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;"
                    class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
            </div>
        </div>
        </br>

        <div class="row">
            <div class="col-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="_buttons">
                            <?php if(is_admin() || has_permission('plp_configuracoes','','create')){ ?>
                            <a href="#" data-toggle="modal" data-target="#modal_add"
                                class="btn btn-info pull-left display-block" style="background-color: #007bff; border-color: #007bff; color: white;">
                                <?php echo _l('Novo Processo'); ?>
                            </a>
                            <?php } ?>
                        </div>
                        <div class="clearfix"></div>
                        <br>
                        <table class="table dt-table">
                            <thead>
                                <th width="30%"><?php echo _l('staff'); ?></th>
                                <th><?php echo _l('title'); ?></th>
                                <th><?php echo _l('pe_politica'); ?></th>
                                <th><?php echo _l('description'); ?></th>
                                <th><?php echo _l('pe_data_verificacao'); ?></th>
                                <th><?php echo _l('status'); ?></th>
                                <th><?php echo _l('options'); ?></th>
                            </thead>
                            <tbody>
                                <?php foreach($processos as $c) { ?>
                                <tr>
                                    <td><?php echo html_entity_decode($c['firstname_c'] .' '.$c['lastname_c']); ?></td>
                                    <td><?php echo html_entity_decode($c['titulo']); ?></td>
                                    <td><?php echo html_entity_decode($c['politica']); ?></td>
                                    <td class="truncate" style="max-width: 300px;">
                                        <?= limitarPalavra(html_entity_decode($c['descricao']), 30); ?>
                                    </td>
                                    <td><?php echo html_entity_decode($c['data_verificacao']); ?></td>
                                    <td><?php echo html_entity_decode($c['status']); ?></td>
                                    <td>
                                        <?php if(is_admin() || has_permission('plp_configuracoes','','view')){ ?>
                                        <a href="<?= admin_url('politicas_empresa/processos/processo/'. $c['id']); ?>"
                                        class="btn btn-success btn-icon">
                                        <i class="fa fa-eye"
                                        style="color:#fff;"></i>
                                        </a>
                                        <?php } ?>
                                        <?php if(is_admin() || has_permission('plp_configuracoes','','edit')){ ?>
                                        <a href="<?= admin_url('politicas_empresa/processos/processo_editar/'. $c['id']); ?>"
                                        class="btn btn-info btn-icon" style="background-color: #007bff; border-color: #007bff; color: white;">
                                        <i class="fa fa-edit"
                                        style="color:#fff;"></i>
                                        </a>
                                        <?php } ?>

                                        <?php if(is_admin() || has_permission('plp_configuracoes','','delete')){ ?>
                                        <a onclick="return confirm('Tens certteza que desejas eliminar este processo?');"
                                            href="<?php echo admin_url('politicas_empresa/processos/delete_processo/'.$c['id']); ?>"
                                            class="btn btn-danger btn-icon _delete"><i class="fa fa-trash"
                                            style="color:#fff;"></i></a>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="btn-bottom-pusher"></div>
    </div>
</div>
<div id="new_version"></div>

<div class="modal" id="modal_add" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <?= form_open_multipart(admin_url('politicas_empresa/processos/add_processo'), array('method' => 'post')) ?>
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                Novo Processo
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="staff" class="control-label"><?php echo _l('staff'); ?><span
                                            class="text-danger">*</span></label>
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="politica" class="control-label"><?php echo _l('pe_politica'); ?><span
                                            class="text-danger">*</span></label>
                                    <select name="politica" id="politica" data-live-search="true" class="selectpicker"
                                        data-actions-box="true" data-width="100%"
                                        data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <option value=""></option>
                                        <?php foreach($politicas as $t){ ?>
                                        <option value="<?php echo html_entity_decode($t['id']); ?>">
                                            <?php echo html_entity_decode($t['titulo']); ?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <?php echo render_input('titulo','Titulo<span class="text-danger">*<span>'); ?>
                            </div>
                            <div class="col-md-12">
                                <?php echo render_textarea('descricao', 'Descrição<span class="text-danger">*<span>', '') ?>
                            </div>
                            <div class="col-md-12">
                                <?php echo render_input('data_verificacao','Data Verificação<span class="text-danger">*<span>', '', 'date'); ?>
                            </div>
                            <div class="col-md-12">
                                <?php echo render_input('arquivo','Arquivo', '', 'file'); ?>
                            </div>
                            <div class="col-md-12">
                                <?php
                                $selectedStaff = '';
                                echo render_select('aprovadores[]', $staff_list, ['staffid', ['firstname', 'lastname']], 'Aprovadores<span class="text-danger">*</span>', $selectedStaff, ['multiple' => true], [], '', '', false);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn btn-danger"
                    data-dismiss="modal"><?php echo _l('Cancelar'); ?></button>
                <button type="submit" class="btn btn-info btn btn-success"><?php echo _l('Salvar'); ?></button>
            </div>
        </div>
        <?= form_close()  ?>
    </div>
</div>
<?php init_tail(); ?>
<?php require('modules/politicas_empresa/assets/js/company_js.php'); ?>
</body>

</html>