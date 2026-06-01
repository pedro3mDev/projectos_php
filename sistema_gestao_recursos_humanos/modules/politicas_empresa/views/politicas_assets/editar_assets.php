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
                        <a href="<?php echo admin_url('politicas_empresa/politicas_assets/assets/'.$assets['id']); ?>">
                            <?php echo $assets['nome']; ?> →
                        </a>
                        <span class="text-dark"><?php echo $title ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="md:tw-flex md:tw-gap-6">
            <div class="tw-mt-12 md:tw-mt-0 tw-w-full tw-mx-auto tw-max-w-4xl">
                <?php echo form_open(admin_url('politicas_empresa/politicas_assets/actualizar_assets/'.$assets['id']), array('method' => 'post')); ?>
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
                                                        <div class="form-group" app-field-wrapper="nome">
                                                            <label for="nome" class="control-label">
                                                                Categoria do Assets<small
                                                                    class="req text-danger">*</small>
                                                            </label>
                                                            <select class="form-control" name="categoria"
                                                                id="categoria">
                                                                <?php foreach ($categorias as $categoria) : ?>
                                                                <option value="<?= $categoria['id'] ?>"
                                                                    <?php if ($assets['categoria_assets_id'] == $categoria['id']) { echo 'selected'; } ?>>
                                                                    <?= $categoria['categoria'] ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group" app-field-wrapper="nome">
                                                            <label for="nome" class="control-label">
                                                                Fornecedor <small class="req text-danger">*</small>
                                                            </label>
                                                            <select class="form-control" name="fornecedor"
                                                                id="fornecedor">
                                                                <?php foreach ($fornecedores as $fornecedor) : ?>
                                                                <option value="<?= $fornecedor['id'] ?>"
                                                                    <?php if ($assets['fornecedor_id'] == $fornecedor['id']) { echo 'selected'; } ?>>
                                                                    <?= $fornecedor['nome'] ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group" app-field-wrapper="nome">
                                                            <label for="nome" class="control-label">
                                                                Nome <small class="req text-danger">*</small>
                                                            </label>
                                                            <input type="text" id="nome" name="nome"
                                                                class="form-control" value="<?= $assets['nome'] ?>">
                                                        </div>
                                                        <div class="form-group" app-field-wrapper="data_aquisicao">
                                                            <label for="data_aquisicao" class="control-label">
                                                                Data Aquisição
                                                            </label>
                                                            <input type="date" id="data_aquisicao" name="data_aquisicao"
                                                                class="form-control"
                                                                value="<?= $assets['data_aquisicao'] ?>">
                                                        </div>
                                                        <div class="form-group" app-field-wrapper="valor_aquisicao">
                                                            <label for="valor_aquisicao" class="control-label">
                                                                Valor Aquisição <small class="req text-danger">*</small>
                                                            </label>
                                                            <input type="number" id="valor_aquisicao"
                                                                name="valor_aquisicao" class="form-control"
                                                                value="<?= $assets['valor_aquisicao'] ?>">
                                                        </div>
                                                        <div class="form-group" app-field-wrapper="estado">
                                                            <label for="estado" class="control-label">
                                                                Estado do Assets <small
                                                                    class="req text-danger">*</small>
                                                            </label>
                                                            <select class="form-control" name="estado" id="estado">
                                                                <option value="novo"
                                                                    <?php if ($assets['status'] == 'novo') { echo 'selected'; } ?>>
                                                                    Novo</option>
                                                                <option value="em_uso"
                                                                    <?php if ($assets['status'] == 'em_uso') { echo 'selected'; } ?>>
                                                                    Em uso</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group" app-field-wrapper="vida_util">
                                                            <label for="vida_util" class="control-label">
                                                                Vida Util <small class="req text-danger">*</small>
                                                            </label>
                                                            <input type="number" id="vida_util" name="vida_util"
                                                                class="form-control"
                                                                value="<?= $assets['vida_util'] ?>">
                                                        </div>
                                                        <div class="form-group" app-field-wrapper="data_uso">
                                                            <label for="data_uso" class="control-label">
                                                                Data Inicial de Uso
                                                            </label>
                                                            <input type="date" id="data_uso" name="data_uso"
                                                                class="form-control"
                                                                value="<?= $assets['data_inicial_uso'] ?>">
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