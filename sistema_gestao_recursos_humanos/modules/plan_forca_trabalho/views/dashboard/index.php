<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_remuneracao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href=""
                    style="font-size: 16px; color: #333;">
                    Planeamento de Força de Trabalho / Dashboard
                </a>
            </div> 
        </div>
        </br>
        <!-- Não mexe  nessa extrutura-->
        
        <!-- Aqui vais por os Cards-->
        <?php require 'modules/plan_forca_trabalho/views/dashboard/cards.php'; ?>
        </br>
        <!-- Aqui vais por os Graficos-->
        <?php require 'modules/plan_forca_trabalho/views/dashboard/graficos.php'; ?>
        </br>
        <!-- Aqui vais por os Scripts dos Graficos-->
        <?php require 'modules/plan_forca_trabalho/assets/js/graficos.php'; ?>
        </br>

    </div>
</div>    
<?php init_tail(); ?>
</body>
</html>
        