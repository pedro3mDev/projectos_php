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
                        <li class="breadcrumb-item"><a  style="color:#333; font-size:16px;" href="<?php echo admin_url('gestao_viagens'); ?>">Gestão de Viagens</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <a  style="color:#333; font-size:16px;" href="<?php echo admin_url('gestao_viagens/orcamentos'); ?>">
                                Orçamento e Aprovação
                            </a>
                        </li>
                        <li class="breadcrumb-item"><a  style="color:#333; font-size:16px;" href="">Definir Orçamento</a></li>
                    </ol>
                </nav>
            </div>
        </div>

        <?php //var_dump($planeamento); ?>
        <?php //var_dump($orcamentos); 
        ?>
        <div class="md:tw-flex md:tw-gap-6">
            <div class="tw-mt-12 md:tw-mt-0 tw-w-full tw-mx-auto tw-max-w-4xl">
                <?php echo form_open(admin_url('gestao_viagens/orcamentos/store'), array('method' => 'post')); ?>
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
                                                            data-toggle="tab"> Detalhes do Orcamento </a>
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
                                                            <label for="pedido_viagem_id" class="control-label">Selecione o Pedidos<small class="req text-danger">*
                                                                </small></label>
                                                            <select class="form-control" name="pedido_viagem_id">
                                                                <?php if (!empty($pedido) && is_array($pedido)): ?>
                                                                    <?php foreach ($pedido as $item): ?>
                                                                        <option value="<?= htmlspecialchars($item['id'], ENT_QUOTES, 'UTF-8') ?>">
                                                                            <?= htmlspecialchars($item['tipo_viagem'], ENT_QUOTES, 'UTF-8') ?> -
                                                                            <?= htmlspecialchars($item['destino'], ENT_QUOTES, 'UTF-8') ?>
                                                                            -
                                                                            <?= htmlspecialchars($item['objetivo'], ENT_QUOTES, 'UTF-8') ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                <?php else: ?>
                                                                    <option value="">Nenhum planeamento disponível</option>
                                                                <?php endif; ?>
                                                            </select>

                                                        </div>

                                                        <div class="form-group" app-field-wrapper="orcamento">
                                                            <label for="orcamento" class="control-label">
                                                                Orcamento <small class="req text-danger">*</small>
                                                            </label>
                                                            <input type="text" id="orcamento" name="orcamento"
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
                        <button class="btn btn-primary" style="background-color: #007bff; border-color: #007bff; color: white;"> Guardar </button>
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