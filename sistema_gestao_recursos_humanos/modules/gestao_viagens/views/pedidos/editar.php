<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="tw-mb-6">
                    <div class="tw-mb-3">
                        <h4 class="tw-my-0 tw-font-bold tw-text-xl"> <?php echo $title ?> </h4>
                        <a href="<?php echo admin_url('gestao_viagens'); ?>"> <?php echo _l('gestao_viagens'); ?> → </a>
                        <a href="<?php echo admin_url('gestao_viagens/pedidos'); ?>"> <?php echo _l('gv_pedidos'); ?> →
                        </a>
                        <span class="text-dark"><?php echo $title ?> → </span>
                        <a
                            href="<?php echo admin_url('gestao_viagens/pedidos/pedido/'.$pedido['id']); ?>"><?php echo $pedido['objetivo']; ?></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="md:tw-flex md:tw-gap-6">
            <div class="tw-mt-12 md:tw-mt-0 tw-w-full tw-mx-auto tw-max-w-4xl">
                <?php echo form_open(admin_url('gestao_viagens/pedidos/actualizar/'.$pedido['id']), array('method' => 'post')); ?>
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
                                                            <label for="company" class="control-label">Tipo de
                                                                Viagem<small class="req text-danger">*
                                                                </small></label>
                                                            <select class="form-control" name="tipo_viagem">
                                                                <option value="nacional"
                                                                    <?php echo $pedido['tipo_viagem'] == 'nacional' ? 'selected':''; ?>>
                                                                    Nacional</option>
                                                                <option value="internacional"
                                                                    <?php echo $pedido['tipo_viagem'] == 'internacional' ? 'selected':''; ?>>
                                                                    Internacional</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group" app-field-wrapper="objetivo">
                                                            <label for="objetivo" class="control-label">
                                                                Objectivo<small class="req text-danger">*</small>
                                                            </label>
                                                            <textarea name="objetivo" class="form-control"
                                                                style="min-height: 100px;"> <?php echo set_value('objetivo', $pedido['objetivo']); ?> </textarea>
                                                        </div>
                                                        <div class="form-group" app-field-wrapper="destino">
                                                            <label for="destino" class="control-label">
                                                                Destino <small class="req text-danger">*</small>
                                                            </label>
                                                            <input type="text" id="destino" name="destino"
                                                                class="form-control"
                                                                value="<?php echo set_value('destino', $pedido['destino']); ?>">
                                                        </div>

                                                        <div class="form-group" app-field-wrapper="data_inicio">
                                                            <label for="data_inicio" class="control-label">
                                                                Data Início <small class="req text-danger">*</small>
                                                            </label>
                                                            <input type="date" id="data_inicio" name="data_inicio"
                                                                class="form-control"
                                                                value="<?php set_value('data_inicio', $pedido['data_inicio']); ?>">
                                                        </div>
                                                        <div class="form-group" app-field-wrapper="data_fim">
                                                            <label for="data_fim" class="control-label">
                                                                Data Fim <small class="req text-danger">*</small>
                                                            </label>
                                                            <input type="date" id="data_fim" name="data_fim"
                                                                class="form-control"
                                                                value="<?php set_value('data_fim', $pedido['data_fim']); ?>">
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
                        <button class="btn btn-primary"> Guardar </button>
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