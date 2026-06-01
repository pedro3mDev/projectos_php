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
                    Gestão de Engajamento de Talentos / Pesquisas / Resposta de Engajamento / Visualizar
                </a>
            </div>
            <div class="col-md-6" style=" display: flex; justify-content: flex-end; align-items: center;">
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
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i> Visualizar Resposta de
                                    Engajamento
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
                                            <td class="bold" width="40%">Pesquisa</td>
                                            <td><?= html_entity_decode($resposta_engajamento['titulo'] ?? '') ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Pergunta</td>
                                            <td><?= html_entity_decode($resposta_engajamento['texto'] ?? '') ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Colaborador</td>
                                            <td><?= html_entity_decode($resposta_engajamento['firstname'].' '.$resposta_engajamento['lastname'] ?? '') ?>
                                            </td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Resposta</td>
                                            <?php
                                                switch ($resposta_engajamento['resposta']) {
                                                    case '1': $resposta = 'Pessimo';  break;
                                                    case '2': $resposta = 'Mau';  break;
                                                    case '3': $resposta = 'Bom';  break;
                                                    case '4': $resposta = 'Muito Bom';  break;
                                                    case '5': $resposta = 'Excelênte';  break;
                                                    default: $resposta = html_entity_decode($resposta_engajamento['resposta']); break;
                                                }
                                            ?>
                                            <td><?= html_entity_decode($resposta ?? '') ?></td>
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