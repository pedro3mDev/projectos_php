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
                Gestão de Remuneração / Definição e Actualização / Benchmark Salarial / Visualizar
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
                            <i class="fa fa-address-card-o" aria-hidden="true"></i> Visualizar Benchmark Salarial
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
                                    <td class="bold" width="40%">Setor</td>
                                    <td><?php echo $benchmark_salarial['setor'] ?></td>
                                </tr>
                                <tr class="project-overview">
                                    <td class="bold" width="40%">Nível de Experiência</td>
                                    <td><?php echo $benchmark_salarial['nivel_experiencia'] ?></td>
                                </tr>
                                <tr class="project-overview">
                                    <td class="bold" width="40%">Média Salaria</td>
                                    <td><?php echo $benchmark_salarial['media_salarial'] ?></td>
                                </tr>
                                <tr class="project-overview">
                                    <td class="bold" width="40%">Data de Referência</td>
                                    <td><?php echo $benchmark_salarial['data_referencia'] ?></td>
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
