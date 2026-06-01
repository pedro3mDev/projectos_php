<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_viagens/assets/css/dash.css'); ?>">
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>

        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Viagem / Dashboard
                </a>
            </div>
        </div>

        </br>
        <?php require 'modules/gestao_viagens/views/dashboard/cards.php'; ?>

        </br>
        <?php require 'modules/gestao_viagens/views/dashboard/graficos.php'; ?>

        <?php require 'modules/gestao_viagens/views/dashboard/tabelas.php'; ?>
    </div>

</div>

<div id="new_version"></div>
<?php init_tail(); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>