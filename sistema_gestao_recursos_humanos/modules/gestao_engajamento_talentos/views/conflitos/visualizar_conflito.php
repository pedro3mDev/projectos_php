<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <?php
            $data_view = [];
            $this->load->view('/admin/menu_modulo/menu', $data_view);
        ?>
        <div class="row">
            <div class="col-md-6">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Engajamento de Talentos / Conflitos e Resoluções / Conflito / Visualizar
                </a>
            </div>
            <div class="col-md-6" style=" display: flex; justify-content: flex-end; align-conflitos: center;">
                <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
            </div>
        </div>

        </br>
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i> Visualizar Conflito
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="bold">Informação Geral</h4>
                                <table class="table border table-striped">
                                    <tbody>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Colaborador</td>
                                            <td><?= html_entity_decode($conflito['firstname'].' '.$conflito['lastname'] ?? '') ?>
                                            </td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Descrição</td>
                                            <td><?= html_entity_decode($conflito['descricao'] ?? '') ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Data de Registro</td>
                                            <td><?= html_entity_decode($conflito['data_registro'] ?? '') ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Estado</td>
                                            <td>
                                                <?php
                                                $texto_status = 'Em Andamento';
                                                $cor = "#999"; // Cor padrão (cinza para pendente)
                                                if ($conflito['status'] == 'resolvido') {
                                                    $texto_status = 'Resolvido';
                                                    $cor = "green";
                                                } elseif ($conflito['status'] == 'nao_resolvido') {
                                                    $texto_status = 'Não Resolvido';
                                                    $cor = "red";
                                                }
                                                $texto_cor = ($conflito['status'] == 'em_andamento') ? 'color:#000;' : 'color:#fff;';
                                            ?>
                                                <a
                                                    style="background-color: <?= $cor ?>; <?= $texto_cor ?> padding: 5px 10px; border-radius:8px;">
                                                    <?= $texto_status ?>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="new_version"></div>
        <?php init_tail(); ?>