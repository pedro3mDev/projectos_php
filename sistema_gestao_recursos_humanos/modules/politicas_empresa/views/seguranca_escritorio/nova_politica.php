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
                        <li class="breadcrumb-item"><a  style="color:#333; font-size:16px;" href="">Política de Empresa</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <a  style="color:#333; font-size:16px;" href="">
                            Política de Segurança no Escritório/Onshore
                            </a>
                        </li>
                        <li class="breadcrumb-item"><a  style="color:#333; font-size:16px;" href="">Nova Política</a></li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="md:tw-flex md:tw-gap-6">
            <div class="tw-mt-12 md:tw-mt-0 tw-w-full tw-mx-auto tw-max-w-4xl">
                <?php echo form_open_multipart(admin_url('politicas_empresa/seguranca_escritorio/adicionar_politica')); ?>
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
                                                                Titulo <small class="req text-danger">*</small>
                                                            </label>
                                                            <input type="text" id="titulo" name="titulo"
                                                                class="form-control" value="<?= set_value('titulo') ?>">
                                                        </div>
                                                        <div class="form-group" app-field-wrapper="descricao">
                                                            <label for="descricao" class="control-label">
                                                                Descrição<small class="req text-danger">*</small>
                                                            </label>
                                                            <textarea name="descricao" class="form-control"
                                                                style="min-height: 100px;"><?= set_value('descricao') ?></textarea>
                                                        </div>
                                                        <div class="form-group" app-field-wrapper="arquivo">
                                                            <label for="arquivo" class="control-label">
                                                                Arquivo
                                                            </label>
                                                            <input type="file" id="arquivo" name="arquivo"
                                                                class="form-control" value="">
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
                        <button class="btn btn-primary" style="background-color: #007bff; border-color: #007bff; color: white;"> Adiconar </button>
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