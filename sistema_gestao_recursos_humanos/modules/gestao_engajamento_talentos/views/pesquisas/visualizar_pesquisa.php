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
                    Gestão de Engajamento de Talentos / Pesquisas / Pesquisa de Engajamento / Visualizar
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
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i> Visualizar Pesquisa de
                                    Engajamento
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="bold">Informação Geral</h4>
                                <table class="table border table-striped">
                                    <tr class="project-overview">
                                        <td class="bold" width="40%">Título</td>
                                        <td>
                                            <?= html_entity_decode($pesquisa_engajamento['titulo'] ?? '') ?>
                                        </td>
                                    </tr>
                                    <tr class="project-overview">
                                        <td class="bold" width="40%">Descrição</td>
                                        <td>
                                            <?= html_entity_decode($pesquisa_engajamento['descricao'] ?? '') ?>
                                        </td>
                                    </tr>
                                    <tr class="project-overview">
                                        <td class="bold" width="40%">Data de Criação</td>
                                        <td>
                                            <?= html_entity_decode($pesquisa_engajamento['data_criacao'] ?? '') ?>
                                        </td>
                                    </tr>
                                    <tr class="project-overview">
                                        <td class="bold" width="40%">Data de Fim</td>
                                        <td>
                                            <?= html_entity_decode($pesquisa_engajamento['data_fim'] ?? '') ?>
                                        </td>
                                    </tr>

                                    <tr class="project-overview">
                                        <td class="bold" width="40%">Estado</td>
                                        <td>
                                            <?php
                                                    $cor = "#999"; // Cor padrão (cinza para pendente)
                                                    if ($pesquisa_engajamento['status_id'] == 2) {
                                                        $cor = "green";
                                                    } elseif ($pesquisa_engajamento['status_id'] == 3) {
                                                        $cor = "red";
                                                    }
                                                ?>
                                            <a
                                                style="background-color: <?= $cor ?>; color:#fff; padding: 5px; border-radius:10px;">
                                                <?= html_entity_decode($pesquisa_engajamento['status'] ?? '') ?>
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="new_version"></div>
        <?php init_tail(); ?>