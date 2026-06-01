<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_remuneracao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href=""
                    style="font-size: 16px; color: #333;">
                    Gestão de Remunerações / Dashboard
                </a>
            </div> 
        </div>
        </br>
        <!-- Não mexe  nessa extrutura-->
        
        <!-- Aqui vais por os Cards-->
        <?php require 'modules/gestao_remuneracao/views/dashboard/cards.php'; ?>
        </br>
        <!-- Aqui vais por os Graficos-->
        <?php require 'modules/gestao_remuneracao/views/dashboard/graficos.php'; ?>
        </br>
        <!-- Aqui vais por os Scripts dos Graficos-->
        <?php require 'modules/gestao_remuneracao/assets/js/graficos.php'; ?>
        </br>

    </div>
</div>    
<?php init_tail(); ?>
</body>
</html>
        