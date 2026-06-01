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
                        <a href="<?php echo admin_url('politicas_empresa/politicas_assets'); ?>">
                            <?php echo _l('pe_politicas_assets'); ?> →
                        </a>
                        <a
                            href="<?php echo admin_url('politicas_empresa/politicas_assets/localizacao/'.$localizacao['id']); ?>">
                            <?php echo $localizacao['localizacao']; ?> →
                        </a>
                        <span class="text-dark"><?php echo $title ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="md:tw-flex md:tw-gap-6">
            <div class="tw-mt-12 md:tw-mt-0 tw-w-full tw-mx-auto tw-max-w-4xl">
                <?php echo form_open(admin_url('politicas_empresa/politicas_assets/atualizar_localizacao/'.$localizacao['id']), array('method' => 'post')); ?>
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
                                                        <div class="form-group" app-field-wrapper="descricao">
                                                            <label for="descricao" class="control-label">
                                                                Descrição <small class="req text-danger">*</small>
                                                            </label>
                                                            <textarea id="descricao" name="descricao"
                                                                class="form-control"><?= $localizacao['descricao'] ?></textarea>
                                                        </div>
                                                        <div class="form-group" app-field-wrapper="localizacao">
                                                            <label for="localizacao" class="control-label">
                                                                Localização <small class="req text-danger">*</small>
                                                            </label>
                                                            <textarea id="localizacao" name="localizacao"
                                                                class="form-control"><?= $localizacao['localizacao'] ?></textarea>
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
                        <button class="btn btn-primary"> Actualizar </button>
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