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
                            <?php echo _l('pe_assets'); ?> →
                        </a>
                        <span class="text-dark"><?php echo $title; ?></span> →
                        <span class="text-dark"><?php echo $assets['nome']; ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="bold">Informação Geral</h4>
                    <a href="<?php echo admin_url('politicas_empresa/politicas_assets/assets_editar/'.$assets['id']); ?>"
                        class="btn btn-primary">Editar</a>

                    <a href="<?php echo admin_url('politicas_empresa/politicas_assets/assets_add_localizacao/'.$assets['id']); ?>"
                        class="btn btn-primary">Nova Localização</a>
                    <a href="<?php echo admin_url('politicas_empresa/politicas_assets/assets_add_manutencao/'.$assets['id']); ?>"
                        class="btn btn-primary">Adiicionar Manutenção</a>
                    <table class="table border table-striped ">
                        <tbody>
                            <tr class="project-overview">
                                <td class="bold" width="40%">Nome</td>
                                <td><?php echo $assets['nome']; ?></td>
                            </tr>
                            <tr class="project-overview">
                                <td class="bold" width="40%">Fornecedor</td>
                                <td><?php echo $assets['fornecedor']; ?></td>
                            </tr>
                            <tr class="project-overview">
                                <td class="bold" width="40%">Categoria</td>
                                <td><?php echo $assets['categoria']; ?></td>
                            </tr>
                            <tr class="project-overview">
                                <td class="bold" width="40%">Data Aquisição</td>
                                <td><?php echo $assets['data_aquisicao']; ?></td>
                            </tr>
                            <tr class="project-overview">
                                <td class="bold" width="40%">Valor Aquisição</td>
                                <td><?php echo $assets['valor_aquisicao']; ?></td>
                            </tr>
                            <tr class="project-overview">
                                <td class="bold" width="40%">Estado Assets</td>
                                <td><?php echo $assets['status']; ?></td>
                            </tr>
                            <tr class="project-overview">
                                <td class="bold" width="40%">Vida Util</td>
                                <td><?php echo $assets['vida_util']; ?></td>
                            </tr>
                            <tr class="project-overview">
                                <td class="bold" width="40%">Data Inicial de Uso</td>
                                <td><?php echo $assets['data_inicial_uso']; ?></td>
                            </tr>
                            <tr class="project-overview">
                                <td class="bold" width="40%">Criado Por</td>
                                <td><?php echo $assets['firstname'] .' '. $assets['lastname']; ?></td>
                            </tr>
                            <tr class="project-overview">
                                <td class="bold" width="40%">Criado em</td>
                                <td><?php echo $assets['created_at']; ?></td>
                            </tr>
                            <tr class="project-overview">
                                <td class="bold" width="40%">Ultima actualização em</td>
                                <td><?php echo $assets['updated_at']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-12">
            <h4>Ciclo de Vida do Assets</h4>
            <table class="table table-hover table-bordered table-responsive">
                <thead>
                    <th>Por</th>
                    <th>Fase</th>
                    <th></th>
                    <th>Data Inicio</th>
                    <th>Data Fim</th>
                </thead>
                <tbody>
                    <?php
                        foreach($ciclo_vida as $ciclo) {
                    ?>
                    <tr>
                        <td><?php echo $ciclo['firstname'] .' '.$ciclo['lastname']; ?></td>
                        <td><?php echo $ciclo['fase']; ?></td>
                        <td>
                            <?php if ($ciclo['localizacao_assets_origem_id']) : ?>
                            <span>Operação: Movimentação</span> <br>
                            <span>Origem: <b><?= $ciclo['localizacao_origem'] ?></b></span> <br>
                            <span>Destino: <b><?= $ciclo['localizacao_destino'] ?></b></span> <br>
                            <!-- <span>Por: <b><?php //echo $ciclo['m_firstname'] .' '.$ciclo['m_lastname']; ?></b></span> -->
                            <br>
                            <span>Data Movimento: <b><?= $ciclo['data_movimento'] ?></b></span> <br>
                            <?php elseif ($ciclo['manutencao_id']) : ?>
                            <span>Tipo e Menutencao: <b><?= $ciclo['tipo'] ?></b></span> <br>
                            <span>Descricao: <b><?= $ciclo['m_descricao'] ?></b></span> <br>
                            <span>Data Manuntencao: <b><?= $ciclo['data_manutencao'] ?></b></span> <br>
                            <?php else : ?>
                            <?php echo $ciclo['fase']; ?>
                            <?php endif ?>
                        </td>
                        <td><?php echo $ciclo['data_inicio']; ?></td>
                        <td><?php echo $ciclo['data_fim']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="new_version"></div>
<?php init_tail(); ?>
<?php require('modules/recruitment/assets/js/company_js.php'); ?>