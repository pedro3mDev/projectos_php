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
                Plano de Sucessão e Liderança / Planejamento / Plano de Desenvolvimento / Visualizar
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
                            <i class="fa fa-address-card-o" aria-hidden="true"></i> Visualizar Plano de Desenvolvimento
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
                                    <td class="bold" width="40%">Funcionário</td>
                                    <td><?= $plano['firstname'].' '.$plano['lastname']?></td>
                                </tr>
                                <tr class="project-overview">
                                    <td class="bold" width="40%">Cargo</td>
                                    <td><?= $plano['cargo']?></td>
                                </tr>
                                <tr class="project-overview">
                                    <td class="bold" width="40%">Competência em Falta</td>
                                    <td><?= $plano['competencia']?></td>
                                </tr>
                                <tr class="project-overview">
                                    <td class="bold" width="40%">Posição Chave</td>
                                    <td><?= $plano['posicao_chave']?></td>
                                </tr>
                                <tr class="project-overview">
                                    <td class="bold" width="40%">Nivel Critico</td>
                                    <td><?= $plano['nivel_critico']?></td>
                                </tr>
                                <tr class="project-overview">
                                    <td class="bold" width="40%">Treinamento Sugerido</td>
                                    <td><?= $plano['treinamento_sugerido']?></td>
                                </tr>
                                <tr class="project-overview">
                                    <td class="bold" width="40%">Estado</td>
                                    <td><?= $plano['status']?></td>
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
