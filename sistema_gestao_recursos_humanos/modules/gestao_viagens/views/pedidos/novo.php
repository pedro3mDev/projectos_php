<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <?php
            $data_view = [];
            $this->load->view('/admin/menu_modulo/menu', $data_view);
        ?>

        <div class="row">
            <div class="col-md-12">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a style="color:#333; font-size:16px;"
                                href="<?php echo admin_url('gestao_viagens'); ?>">Gestão de Viagens</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <a style="color:#333; font-size:16px;"
                                href="<?php echo admin_url('gestao_viagens/pedidos'); ?>">
                                Planeamento de Viagens
                            </a>
                        </li>
                        <li class="breadcrumb-item"><a style="color:#333; font-size:16px;" href="">Novo Pedido</a></li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="md:tw-flex md:tw-gap-6">
            <div class="tw-mt-12 md:tw-mt-0 tw-w-full tw-mx-auto tw-max-w-4xl">
                <?php echo form_open(admin_url('gestao_viagens/pedidos/adicionar'), array('method' => 'post')); ?>
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
                                                            data-toggle="tab"> Detalhes do Pedido </a>
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
                                                        <div class="form-group">
                                                            <?php
                                                            $selectedStaff = '';
                                                            echo render_select('funcionarios[]', $staffs, ['staffid', ['firstname', 'lastname']], 'Funcionários<span class="text-danger">*</span>', $selectedStaff, ['multiple' => true], [], '', '', false);
                                                            ?>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="company" class="control-label">Tipo de
                                                                Viagem<small class="req text-danger">*
                                                                </small></label>
                                                            <select class="form-control" name="tipo_viagem">
                                                                <option value=""></option>
                                                                <?php foreach ($tipos as $t) : ?>
                                                                <option value="<?= $t['id'] ?>"><?= $t['tipo_viagem'] ?>
                                                                </option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="company" class="control-label">Categorias<small
                                                                    class="req text-danger">*
                                                                </small></label>
                                                            <select class="form-control" name="categoria">
                                                                <option value=""></option>
                                                                <?php foreach ($categorias as $t) : ?>
                                                                <option value="<?= $t['id'] ?>"><?= $t['categoria'] ?>
                                                                </option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="company" class="control-label">Estado<small
                                                                    class="req text-danger">*
                                                                </small></label>
                                                            <select class="form-control" name="status">
                                                                <option value=""></option>
                                                                <?php foreach ($status as $t) : ?>
                                                                <option value="<?= $t['id'] ?>"><?= $t['status'] ?>
                                                                </option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group" app-field-wrapper="objetivo">
                                                            <label for="objetivo" class="control-label">
                                                                Objectivo<small class="req text-danger">*</small>
                                                            </label>
                                                            <textarea name="objetivo" class="form-control"
                                                                style="min-height: 100px;"></textarea>
                                                        </div>
                                                        <div class="form-group" app-field-wrapper="destino">
                                                            <label for="destino" class="control-label">
                                                                Destino <small class="req text-danger">*</small>
                                                            </label>
                                                            <input type="text" id="destino" name="destino"
                                                                class="form-control" value="">
                                                        </div>

                                                        <div class="form-group" app-field-wrapper="data_inicio">
                                                            <label for="data_inicio" class="control-label">
                                                                Data Início <small class="req text-danger">*</small>
                                                            </label>
                                                            <input type="date" id="data_inicio" name="data_inicio"
                                                                class="form-control" value="">
                                                        </div>
                                                        <div class="form-group" app-field-wrapper="data_fim">
                                                            <label for="data_fim" class="control-label">
                                                                Data Fim <small class="req text-danger">*</small>
                                                            </label>
                                                            <input type="date" id="data_fim" name="data_fim"
                                                                class="form-control" value="">
                                                        </div>
                                                        <div class="form-group">
                                                            <?php
                                                            $selectedStaff = '';
                                                            echo render_select('aprovadores[]', $staff_list, ['staffid', ['firstname', 'lastname']], 'Aprovadores<span class="text-danger">*</span>', $selectedStaff, ['multiple' => true], [], '', '', false);
                                                            ?>
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
                        <button class="btn btn-primary"
                            style="background-color: #007bff; border-color: #007bff; color: white;"> Guardar </button>
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