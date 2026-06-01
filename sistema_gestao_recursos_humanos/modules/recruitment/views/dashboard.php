<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('assets/css/recrutamento_seleccao/dashboard.css'); ?>">

<div id="wrapper"> 
    <div class="content">
        
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-6">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Recrutamento e Selecção / Dashboard
                </a>
            </div>    
        </div>
 
        <?php require 'modules/recruitment/views/dashboard/cards.php'; ?>

        <?php require 'modules/recruitment/views/dashboard/graficos.php'; ?>

        <?php require 'modules/recruitment/views/dashboard/entrevistas.php'; ?>

    </div>
</div>

<?php init_tail(); ?>
<?php require 'modules/recruitment/assets/js/dashboard_js.php'; ?>
