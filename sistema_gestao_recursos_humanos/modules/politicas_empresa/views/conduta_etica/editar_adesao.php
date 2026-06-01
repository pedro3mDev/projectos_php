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
                <?php echo form_open_multipart(admin_url('politicas_empresa/conduta_etica/actualizar_adesao/'.$adesao['id']), array('method' => 'post')); ?>
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
                                                        <?php echo validation_errors(); ?> <br>
                                                        <?php echo isset($error) ? $error : ''; ?> <br>
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
                                                                    <?php if ($adesao['conduta_id'] == $conduta['id']) { echo 'selected'; } ?>>
                                                                    <?= $conduta['nome'] ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group" app-field-wrapper="staff">
                                                            <label for="staff" class="control-label">
                                                                Usuário <small class="req text-danger">*</small>
                                                            </label>
                                                            <select class="form-control" name="staff" id="staff">
                                                                <option value=""></option>
                                                                <?php foreach ($staffs as $staff) : ?>
                                                                <option value="<?= $staff['staffid'] ?>"
                                                                    <?php if ($adesao['staff_id'] == $staff['staffid']) { echo 'selected'; } ?>>
                                                                    <?= $staff['lastname'] .' '.$staff['firstname'] ?>
                                                                </option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group" app-field-wrapper="metodo_adesao">
                                                            <label for="metodo_adesao" class="control-label">
                                                                Metodo Adesão <small class="req text-danger">*</small>
                                                            </label>
                                                            <select class="form-control" name="metodo_adesao"
                                                                id="metodo_adesao">
                                                                <option value=""></option>
                                                                <option value="assinatura_digital"
                                                                    <?php if ($adesao['metodo_aceite'] == 'assinatura_digital') { echo 'selected'; } ?>>
                                                                    Assinatura Digital</option>
                                                                <option value="assinatura_fisica"
                                                                    <?php if ($adesao['metodo_aceite'] == 'assinatura_fisica') { echo 'selected'; } ?>>
                                                                    Assinatura Fisica</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group" app-field-wrapper="arquivo">
                                                            <label for="arquivo" class="control-label">
                                                                Arquivo
                                                            </label>
                                                            <input type="file" id="arquivo" name="arquivo"
                                                                class="form-control">
                                                            <p><?= empty($adessao['arquivo']) ? 'Sem Anexo':'Com Anexo' ?>
                                                            </p>
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