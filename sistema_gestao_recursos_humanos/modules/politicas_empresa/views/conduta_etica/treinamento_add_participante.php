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
                <?php echo form_open(admin_url('politicas_empresa/conduta_etica/adicionar_participante_treinamento/'.$treinamento['id']), array('method' => 'post')); ?>
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
                                                        <div class="form-group" app-field-wrapper="staff">
                                                            <label for="staff" class="control-label">
                                                                Participante <small class="req text-danger">*</small>
                                                            </label>
                                                            <select class="form-control" name="staff" id="staff">
                                                                <option value=""></option>
                                                                <?php foreach ($staffs as $staff) : ?>
                                                                <option value="<?= $staff['staffid'] ?>"
                                                                    <?php if (set_value('staff') == $staff['staffid']) { echo 'selected'; } ?>>
                                                                    <?= $staff['lastname'] .' '.$staff['firstname'] ?>
                                                                </option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group" app-field-wrapper="resultado">
                                                            <label for="resultado" class="control-label">
                                                                Resultado <small class="req text-danger">*</small>
                                                            </label>
                                                            <select class="form-control" name="resultado"
                                                                id="resultado">
                                                                <option value=""></option>
                                                                <option value="pendente"
                                                                    <?php if (set_value('resultado') == 'pendente') { echo 'selected'; } ?>>
                                                                    Pendente</option>
                                                                <option value="aprovado"
                                                                    <?php if (set_value('resultado') == 'aprovado') { echo 'selected'; } ?>>
                                                                    Aprovado</option>
                                                                <option value="reprovado"
                                                                    <?php if (set_value('resultado') == 'reprovado') { echo 'selected'; } ?>>
                                                                    Reprovado</option>
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