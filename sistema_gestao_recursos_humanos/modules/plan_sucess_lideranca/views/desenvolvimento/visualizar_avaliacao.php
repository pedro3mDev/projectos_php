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
                Plano de Sucessão e Liderança / Avaliação de Liderança / Visualizar
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
                            <i class="fa fa-address-card-o" aria-hidden="true"></i> Visualizar Avaliação de Liderança
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
                                    <td class="bold" width="40%">Funcionário(Talento)</td>
                                    <td><?= $lideranca['firstname'].' '.$lideranca['lastname']?></td>
                                </tr>
                                <tr class="project-overview">
                                    <td class="bold" width="40%">Programa</td>
                                    <td><?= $lideranca['programa']?></td>
                                </tr>
                                <tr class="project-overview">
                                    <td class="bold" width="40%">Carga Horária</td>
                                    <td><?= $lideranca['carga_horaria']?></td>
                                </tr>
                                <tr class="project-overview">
                                    <td class="bold" width="40%">Nota</td>
                                    <td><?= $lideranca['nota']?></td>
                                </tr>
                                <tr class="project-overview">
                                    <td class="bold" width="40%">Descrição</td>
                                    <td><?= $lideranca['descricao']?></td>
                                </tr>
                                <tr class="project-overview">
                                    <td class="bold" width="40%">Feedback</td>
                                    <td><?= $lideranca['feedback']?></td>
                                </tr>
                                <tr class="project-overview">
                                    <td class="bold" width="40%">Estado</td>
                                    <td><?= $lideranca['status']?></td>
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
