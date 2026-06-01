<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/configuracoes/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">

        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Configurações / Dashboard
                </a>
            </div>
        </div>

        </br>
        <?php require 'modules/configuracoes/views/dashboard/cards.php'; ?>

        <?php require 'modules/configuracoes/views/dashboard/tabelas.php'; ?>

        <div class="row">

        </div>

        <div class="btn-bottom-pusher"></div>
    </div>
</div>
<div id="new_version"></div>

<?php init_tail(); ?>
</body>

</html>