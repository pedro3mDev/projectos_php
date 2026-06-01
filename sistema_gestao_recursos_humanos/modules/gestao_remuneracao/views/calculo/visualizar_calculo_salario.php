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
                Gestão de Remuneração / Cálculo / Cálculo do salário / Visualizar
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
                            <i class="fa fa-address-card-o" aria-hidden="true"></i> Visualizar Cálculo do salário
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
                                    <td class="bold" width="40%">Usuário</td>
                                    <td><?php echo $calculo_salario['primeiro_nome']. ' '.$calculo_salario['segundo_nome']?></td>
                                </tr>
                                <tr class="project-overview">
                                    <td class="bold" width="40%">Faixa Salarial Min</td>
                                    <td><?php echo $calculo_salario['salario_min']?></td>
                                </tr>
                                <tr class="project-overview">
                                    <td class="bold" width="40%">Faixa Salarial Max</td>
                                    <td><?php echo $calculo_salario['salario_max']?></td>
                                </tr>
                                <tr class="project-overview">
                                    <td class="bold" width="40%">Bônus</td>
                                    <td><?php echo $calculo_salario['bonus']?></td>
                                </tr>
                                <tr class="project-overview">
                                    <td class="bold" width="40%">Descontos</td>
                                    <td><?php echo $calculo_salario['descontos']?></td>
                                </tr>
                                <tr class="project-overview">
                                    <td class="bold" width="40%">Salário Final</td>
                                    <td><?php echo $calculo_salario['salario_final']?></td>
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
