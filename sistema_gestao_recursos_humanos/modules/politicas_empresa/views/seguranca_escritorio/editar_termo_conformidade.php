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
                        <a href="<?php echo admin_url('politicas_empresa/seguranca_escritorio'); ?>">
                            <?php echo _l('pe_seguranca_escritorio'); ?> →
                        </a>
                        <span class="text-dark"><?php echo $title ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="md:tw-flex md:tw-gap-6">
            <div class="tw-mt-12 md:tw-mt-0 tw-w-full tw-mx-auto tw-max-w-4xl">
                <?php echo form_open_multipart(admin_url('politicas_empresa/seguranca_escritorio/actualizar_termo_conformidade/'.$conformidade['id'])); ?>
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
                                                            data-toggle="tab"> Detalhes da Politica </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="tab-content mtop15">
                                            <div role="tabpanel" class="tab-pane active" id="contact_info">
                                                <div class="row">
                                                    <div class="col-12 text-danger">
                                                        <?php echo validation_errors(); ?>
                                                        <?php if(isset($error))  { echo $error; } ?>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group" app-field-wrapper="titulo">
                                                            <label for="titulo" class="control-label">
                                                                Colaborador <small class="req text-danger">*</small>
                                                            </label>
                                                            <select class="form-control" name="colaborador"
                                                                id="colaborador">
                                                                <option value=""></option>
                                                                <?php foreach ($colaboradores as $colaborador) : ?>
                                                                <option value="<?= $colaborador['staffid'] ?>"
                                                                    <?php if ($conformidade['staff_id'] == $colaborador['staffid']) { echo 'selected'; } ?>>
                                                                    <?php echo $colaborador['firstname'] .' '.$colaborador['lastname'] ?>
                                                                </option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group" app-field-wrapper="politica">
                                                            <label for="politica" class="control-label">
                                                                Politica <small class="req text-danger">*</small>
                                                            </label>
                                                            <select class="form-control" name="politica" id="politica">
                                                                <option value=""></option>
                                                                <?php foreach ($politicas as $politica) : ?>
                                                                <option value="<?= $politica['id'] ?>"
                                                                    <?php if ($conformidade['politica_id'] == $politica['id']) { echo 'selected'; } ?>>
                                                                    <?= $politica['titulo'] ?>
                                                                </option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group" app-field-wrapper="data_assinatura">
                                                            <label for="data_assinatura" class="control-label">
                                                                Data Assinatura <small class="req text-danger">*</small>
                                                            </label>
                                                            <input type="date" id="data_assinatura"
                                                                name="data_assinatura" class="form-control"
                                                                value="<?= $conformidade['data_assinatura'] ?>">
                                                        </div>
                                                        <div class="form-group" app-field-wrapper="tipo_assinatura">
                                                            <label for="tipo_assinatura" class="control-label">
                                                                Tipo de Assinatura <small
                                                                    class="req text-danger">*</small>
                                                            </label>
                                                            <select class="form-control" name="tipo_assinatura"
                                                                id="tipo_assinatura">
                                                                <option value=""></option>
                                                                <option value="fisico"
                                                                    <?php if ($conformidade['tipo_assinatura'] == 'fisico') { echo 'selected'; } ?>>
                                                                    Fisico</option>
                                                                <option value="digital"
                                                                    <?php if ($conformidade['tipo_assinatura'] == 'digital') { echo 'selected'; } ?>>
                                                                    Digital</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group" app-field-wrapper="arquivo">
                                                            <label for="arquivo" class="control-label">
                                                                Arquivo
                                                            </label>
                                                            <input type="file" id="arquivo" name="arquivo"
                                                                class="form-control" value="">

                                                            <?php if (!empty($conformidade['arquivo'])) : ?>
                                                            <h5>Anexo</h5>
                                                            <a target="_blank"
                                                                href="<?= base_url('modules/politicas_empresa/uploads/'.$conformidade['arquivo']); ?>"><?= $politica['arquivo']; ?></a>
                                                            <?php else : ?>
                                                            <?php endif ?>
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
                        <button class="btn btn-primary"> Atualizar </button>
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