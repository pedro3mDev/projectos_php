<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="tw-mb-6">
                    <div class="tw-mb-3">
                        <h4 class="tw-my-0 tw-font-bold tw-text-xl"> <?php echo $title ?> </h4>
                        <a href="<?php echo admin_url('politicas_empresa'); ?>">
                            <?php echo _l('pe_politica_empresa'); ?> → </a>
                        <a href="<?php echo admin_url('politicas_empresa/conduta_etica'); ?>">
                            <?php echo _l('pe_nova_conduta'); ?> →
                        </a>
                        <span class="text-dark"><?php echo $title ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="md:tw-flex md:tw-gap-6">
            <div class="tw-mt-12 md:tw-mt-0 tw-w-full tw-mx-auto tw-max-w-4xl">
                <?php echo form_open(admin_url('politicas_empresa/conduta_etica/adicionar_treinamento/'), array('method' => 'post')); ?>
                <div class="panel_s">
                    <div class="panel-body">
                        <div>
                            <div class="tab-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="horizontal-scrollable-tabs panel-full-width-tabs">
                                            <div class="scroller arrow-left"><i class="fa fa-angle-left"></i></div>
                                            <div class="horizontal-tabs">
                                                <ul class="nav nav-tabs customer-profile-tabs nav-tabs-horizontal"
                                                    role="tablist">
                                                    <li role="presentation" class="active">
                                                        <a href="#contact_info" aria-controls="contact_info" role="tab"
                                                            data-toggle="tab"><?php echo $title ?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="tab-content mtop15">
                                            <div role="tabpanel" class="tab-pane active" id="contact_info">
                                                <div class="row">
                                                    <div class="col-12 text-danger">
                                                        <?php echo validation_errors(); ?>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group" app-field-wrapper="conduta">
                                                            <label for="conduta" class="control-label">
                                                                Conduta <small class="req text-danger">*</small>
                                                            </label>
                                                            <select class="form-control" name="conduta" id="conduta">
                                                                <option value=""></option>
                                                                <?php foreach ($condutas as $conduta) : ?>
                                                                <option value="<?= $conduta['id'] ?>"
                                                                    <?php if (set_value('conduta') == $conduta['id']) { echo 'selected'; } ?>>
                                                                    <?= $conduta['nome'] ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group" app-field-wrapper="data">
                                                            <label for="data" class="control-label">
                                                                Data de Treinamento
                                                            </label>
                                                            <input type="date" id="data" name="data"
                                                                class="form-control" value="<?= set_value('data') ?>">
                                                        </div>
                                                        <div class="form-group" app-field-wrapper="estado">
                                                            <label for="estado" class="control-label">
                                                                Estado <small class="req text-danger">*</small>
                                                            </label>
                                                            <select class="form-control" name="estado" id="estado">
                                                                <option value=""></option>
                                                                <option value="pendente"
                                                                    <?php if (set_value('estado') == 'pendnte') { echo 'selected'; } ?>>
                                                                    Pendente</option>
                                                                <option value="activo"
                                                                    <?php if (set_value('estado') == 'ativo') { echo 'selected'; } ?>>
                                                                    Ativo</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right panel-footer tw-space-x-1" id="profile-save-section">
                        <button class="btn btn-primary"> Adicionar </button>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>
<div id="new_version"></div>
<?php init_tail(); ?>
<?php require('modules/recruitment/assets/js/company_js.php'); ?>