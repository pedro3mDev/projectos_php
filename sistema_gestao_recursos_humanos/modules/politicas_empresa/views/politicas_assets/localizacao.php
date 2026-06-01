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
                        <span class="text-dark"><?php echo $title; ?></span> →
                        <span class="text-dark"><?php echo $localizacao['localizacao']; ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="bold">Informação Geral</h4>
                    <a href="<?php echo admin_url('politicas_empresa/politicas_assets/localizacao_editar/'.$localizacao['id']); ?>"
                        class="btn btn-primary">Editar</a>
                    <table class="table border table-striped ">
                        <tbody>
                            <tr class="project-overview">
                                <td class="bold" width="40%">Localização</td>
                                <td><?php echo $localizacao['localizacao']; ?></td>
                            </tr>
                            <tr class="project-overview">
                                <td class="bold" width="40%">Descrição</td>
                                <td><?php echo $localizacao['descricao']; ?></td>
                            </tr>
                            <tr class="project-overview">
                                <td class="bold" width="40%">Criado Por</td>
                                <td><?php echo $localizacao['firstname'] .' '. $localizacao['lastname']; ?></td>
                            </tr>
                            <tr class="project-overview">
                                <td class="bold" width="40%">Criado em</td>
                                <td><?php echo $localizacao['created_at']; ?></td>
                            </tr>
                            <tr class="project-overview">
                                <td class="bold" width="40%">Ultima actualização em</td>
                                <td><?php echo $localizacao['updated_at']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    <h4 class="bold">Assets nesta Localização</h4>
                    <table class="table border table-striped ">
                        <thead>
                            <th>Nome</th>
                            <th>Categoria</th>
                            <th>Data Movimento</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="new_version"></div>
<?php init_tail(); ?>
<?php require('modules/recruitment/assets/js/company_js.php'); ?>