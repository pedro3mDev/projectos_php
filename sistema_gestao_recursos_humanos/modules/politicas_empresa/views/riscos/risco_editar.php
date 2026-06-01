<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">

    <div class="content">
    </br></br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-6">
                <a class="dashboard-link" href=""
                    style="font-size: 16px; color: #333;">
                    Politicas de Empresa / Riscos / Editar 
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
                        <?= form_open_multipart(admin_url('politicas_empresa/riscos/actualizar_risco/'.$risco['id']), array('method' => 'post')) ?>
                        <div class="row">
                            <!-- <div class="col-md-6">
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
                    </div> -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="politica" class="control-label"><?php echo _l('pe_politica'); ?><span
                                            class="text-danger">*</span></label>
                                    <select name="politica" id="politica" data-live-search="true" class="selectpicker"
                                        data-actions-box="true" data-width="100%"
                                        data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <?php foreach($politicas as $t){ ?>
                                        <option value="<?php echo html_entity_decode($t['id']); ?>"
                                            <?php if($t['id'] == $risco['politica_id']) { echo 'selected'; } ?>>
                                            <?php echo html_entity_decode($t['titulo']); ?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="impacto" class="control-label"><?php echo _l('impacto'); ?><span
                                            class="text-danger">*</span></label>
                                    <select name="impacto" id="impacto" data-live-search="true" class="selectpicker"
                                        data-actions-box="true" data-width="100%"
                                        data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <?php foreach($impactos as $t){ ?>
                                        <option value="<?php echo html_entity_decode($t['id']); ?>"
                                            <?php if($t['id'] == $risco['impacto_id']) { echo 'selected'; } ?>>
                                            <?php echo html_entity_decode($t['impacto']); ?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="probabilidade"
                                        class="control-label"><?php echo _l('probabilidade'); ?><span
                                            class="text-danger">*</span></label>
                                    <select name="probabilidade" id="probabilidade" data-live-search="true"
                                        class="selectpicker" data-actions-box="true" data-width="100%"
                                        data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <?php foreach($probabilidades as $t){ ?>
                                        <option value="<?php echo html_entity_decode($t['id']); ?>"
                                            <?php if($t['id'] == $risco['probabilidade_id']) { echo 'selected'; } ?>>
                                            <?php echo html_entity_decode($t['descricao']); ?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <?php echo render_textarea('medidas_metigacao', 'Medidas de Mitigação<span class="text-danger">*<span>', $risco['medidas_metigacao']) ?>
                            </div>
                            <div class="col-md-12">
                                <?php echo render_textarea('descricao', 'Descrição<span class="text-danger">*<span>', $risco['descricao']) ?>
                            </div>
                            <div class="col-md-12">
                                <?php echo render_input('arquivo','Arquivo', '', 'file'); ?>
                            </div>
                            <div class="col-md-12">
                                <?php
                                echo render_select('aprovadores[]', $staff_list, ['staffid', ['firstname', 'lastname']], 'Aprovadores<span class="text-danger">*</span>', (json_decode($risco['aprovadores'] ?? '')), ['multiple' => true], [], '', '', false);
                                ?>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-info btn-success"><?php echo _l('submit'); ?></button>
                            </div>
                        </div>
                        <?= form_close()  ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="btn-bottom-pusher"></div>
    </div>
</div>
<div id="new_version"></div>

<?php init_tail(); ?>
<?php require('modules/politicas_empresa/assets/js/company_js.php'); ?>
</body>

</html>