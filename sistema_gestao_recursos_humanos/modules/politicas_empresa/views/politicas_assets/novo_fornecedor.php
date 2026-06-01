<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <?php
            $data_view = [];
            $this->load->view('/admin/menu_modulo/menu', $data_view);
        ?>

        <div class="row">
        
            <div class="col-md-12" >
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a  style="color:#333; font-size:16px;" href="<?php echo admin_url('politicas_empresa'); ?>">Política de Empresa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <a  style="color:#333; font-size:16px;" href="<?php echo admin_url('politicas_empresa/politicas_assets'); ?>">
                            Políticas de Assets da Empresa
                            </a>
                        </li>
                        <li class="breadcrumb-item"><a  style="color:#333; font-size:16px;" href="">Novo Fornrcedor</a></li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="md:tw-flex md:tw-gap-6">
            <div class="tw-mt-12 md:tw-mt-0 tw-w-full tw-mx-auto tw-max-w-4xl">
                <?php echo form_open(admin_url('politicas_empresa/politicas_assets/adicionar_fornecedor'), array('method' => 'post')); ?>
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
                                                            data-toggle="tab"><?php $title ?>Detalhes de Fornecedor</a>
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
                                                        <div class="form-group" app-field-wrapper="nome">
                                                            <label for="nome" class="control-label">
                                                                Nome <small class="req text-danger">*</small>
                                                            </label>
                                                            <input type="text" id="nome" name="nome"
                                                                class="form-control" value="<?= set_value('nome') ?>">
                                                        </div>
                                                        <div class="form-group" app-field-wrapper="nif">
                                                            <label for="nif" class="control-label">
                                                                NIF
                                                            </label>
                                                            <input type="text" id="nif" name="nif" class="form-control"
                                                                value="<?= set_value('nif') ?>">
                                                        </div>
                                                        <div class="form-group" app-field-wrapper="localizacao">
                                                            <label for="localizacao" class="control-label">
                                                                Localização <small class="req text-danger">*</small>
                                                            </label>
                                                            <textarea id="localizacao" name="localizacao"
                                                                class="form-control"><?= set_value('localizacao') ?></textarea>
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
                        <button class="btn btn-primary" style="background-color: #007bff; border-color: #007bff; color: white;"> Adicionar </button>
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