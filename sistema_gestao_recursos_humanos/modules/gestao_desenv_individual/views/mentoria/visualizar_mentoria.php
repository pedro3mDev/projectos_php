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
                    Gestão de Desenvolvimento Individual / Mentoria
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
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i> Visualizar mentoria
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
                                            <td class="bold" width="40%">Nome</td>
                                            <td><?php echo $mentoria['nome'] ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Descrição</td>
                                            <td><?php echo $mentoria['descricao'] ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Data de Secção</td>
                                            <td><?php echo $mentoria['data_seccao'] ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Mentor</td>
                                            <td><?php echo $mentoria['primeiro_nome'].' '.$mentoria['segundo_nome'] ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Feedback</td>
                                            <td><?php echo $mentoria['feedback'] ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Status</td>
                                            <td><?php echo $mentoria['status_nome'] ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Aprovadores</td>
                                            <td><?php echo $mentoria['aprovadores_nomes'] ?></td>
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