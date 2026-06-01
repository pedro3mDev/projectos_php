<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_desenv_individual/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href=""
                    style="font-size: 16px; color: #333;">
                    Gestão de Desenvolvimento Individual / Dashboard
                </a>
            </div> 
        </div>
        
        <?php require 'modules/gestao_desenv_individual/views/dashboard/cards.php'; ?>
         
        <?php require 'modules/gestao_desenv_individual/views/dashboard/graficos.php'; ?>

        <?php require 'modules/gestao_desenv_individual/assets/js/graficos.php'; ?>
        
    </div>
</div>    
<?php init_tail(); ?>
</body>
</html>
        