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
                <?php echo form_open(admin_url('politicas_empresa/politicas_assets/assets_adicionar_localizacao/'.$assets['id']), array('method' => 'post')); ?>
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
                                                            <h1><?= $assets['nome'] ?></h1>
                                                        </div>
                                                        <div class="form-group" app-field-wrapper="localizacao_origem">
                                                            <label for="localizacao_origem" class="control-label">
                                                                Localização Origem<small
                                                                    class="req text-danger">*</small>
                                                            </label>
                                                            <?php if ($ultimo_movimento) : ?>
                                                            <select class="form-control" name="localizacao_origem"
                                                                id="categoria" disabled>
                                                                <option value=""></option>
                                                                <?php foreach ($localizacoes as $localizacao) : ?>
                                                                <option value="<?= $localizacao['id'] ?>"
                                                                    <?php if ($ultimo_movimento['localizacao_assets_destino_id'] == $localizacao['id']) { echo 'selected'; } ?>>
                                                                    <?= $localizacao['localizacao'] ?> -
                                                                    <?= limitarPalavra($localizacao['descricao'], 10) ?>
                                                                </option>
                                                                <?php endforeach ?>
                                                            </select>
                                                            <?php else : ?>
                                                            <select class="form-control" name="localizacao_origem"
                                                                id="categoria">
                                                                <option value=""></option>
                                                                <?php foreach ($localizacoes as $localizacao) : ?>
                                                                <option value="<?= $localizacao['id'] ?>"
                                                                    <?php if (set_value('localizacao_origem')== $localizacao['id']) { echo 'selected'; } ?>>
                                                                    <?= $localizacao['localizacao'] ?> -
                                                                    <?= limitarPalavra($localizacao['descricao'], 10) ?>
                                                                </option>
                                                                <?php endforeach ?>
                                                            </select>
                                                            <?php endif ?>
                                                        </div>
                                                        <div class="form-group" app-field-wrapper="localizacao_destino">
                                                            <label for="localizacao_destino" class="control-label">
                                                                Localização Destino <small
                                                                    class="req text-danger">*</small>
                                                            </label>
                                                            <select class="form-control" name="localizacao_destino"
                                                                id="categoria">
                                                                <option value=""></option>
                                                                <?php foreach ($localizacoes as $localizacao) : ?>
                                                                <?php if ($ultimo_movimento) : ?>
                                                                <?php if($ultimo_movimento['localizacao_assets_destino_id'] != $localizacao['id']) : ?>
                                                                <option value="<?= $localizacao['id'] ?>"
                                                                    <?php if (set_value('localizacao_destino')== $localizacao['id']) { echo 'selected'; } ?>>
                                                                    <?= $localizacao['localizacao'] ?> -
                                                                    <?= limitarPalavra($localizacao['descricao'], 10) ?>
                                                                </option>
                                                                <?php endif ?>
                                                                <?php else : ?>
                                                                <option value="<?= $localizacao['id'] ?>"
                                                                    <?php if (set_value('localizacao_destino')== $localizacao['id']) { echo 'selected'; } ?>>
                                                                    <?= $localizacao['localizacao'] ?> -
                                                                    <?= limitarPalavra($localizacao['descricao'], 10) ?>
                                                                </option>
                                                                <?php endif ?>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group" app-field-wrapper="data_movimento">
                                                            <label for="data_movimento" class="control-label">
                                                                Data Movimento
                                                            </label>
                                                            <input type="date" id="data_movimento" name="data_movimento"
                                                                class="form-control"
                                                                value="<?= set_value('data_movimento') ?>">
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