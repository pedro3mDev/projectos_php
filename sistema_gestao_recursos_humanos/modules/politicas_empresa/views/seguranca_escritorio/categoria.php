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
                        <span class="text-dark"><?php echo $title; ?></span> →
                        <span class="text-dark"><?php echo $categoria['categoria']; ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="bold">Informação Geral</h4>
                    <table class="table border table-striped ">
                        <tbody>
                            <tr class="project-overview">
                                <td class="bold" width="40%">Categoria</td>
                                <td><?php echo $categoria['categoria']; ?></td>
                            </tr>
                            <tr class="project-overview">
                                <td class="bold" width="40%">Criado Por</td>
                                <td><?php echo $categoria['firstname'] .' '. $categoria['lastname']; ?></td>
                            </tr>
                            <tr class="project-overview">
                                <td class="bold" width="40%">Criado em</td>
                                <td><?php echo $categoria['created_at']; ?></td>
                            </tr>
                            <tr class="project-overview">
                                <td class="bold" width="40%">Ultima actualização em</td>
                                <td><?php echo $categoria['updated_at']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-12">
                    <?php echo form_open(admin_url('politicas_empresa/seguranca_escritorio/editar_categoria/'.$categoria['id']), array('method' => 'post')); ?>
                    <div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row tw-justify-center">
                                    <div class="col-12 mleft30">
                                        <h4>
                                            Editar <?php echo $title ?>:
                                            <?php echo $categoria['categoria']; ?>
                                        </h4>
                                    </div>
                                    <div class="col-12 text-danger">
                                        <?php echo validation_errors(); ?>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group" app-field-wrapper="categoria">
                                            <label for="categoria" class="control-label">
                                                Categoria <small class="req text-danger">*</small>
                                            </label>
                                            <input type="text" id="categoria" name="categoria" class="form-control"
                                                value="<?= $categoria['categoria'] ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary"> Actualizar </button>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="new_version"></div>
<?php init_tail(); ?>
<?php require('modules/recruitment/assets/js/company_js.php'); ?>