<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php hooks()->do_action('app_customers_portal_head'); ?>
</br>
</br>
</br>
</br>
</br>
</br>
</br>

<body class="login_admin">
    <div class="row">
        <div class="col-md-6">
            <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                Perfil
            </a>
        </div>
        <div class="col-md-6" style=" display: flex; justify-content: flex-end; align-items: center;">
            <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                <i class="fas fa-reply"></i> Retroceder
            </button>
        </div>
    </div>
    </br>
    <div class="panel_s" style="background-color: rgba(255, 255, 255, 0.8); ; border-radius: 5px;">
        <div class="panel-body">
            <div class="row">

                <div class="col-md-12">
                    <div class="panel_s" style=" height: 600px; overflow-y: auto;">
                        <div class="panel-body">
                            <h4 class="no-margin font-bold">
                                Perfil
                            </h4>
                            <hr />
                            <div>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th id="titulo1" class="text-center">Nome</th>
                                            <th id="titulo1" class="text-center">Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">
                                                <?= $perfil['candidate_name'] ?>
                                            </td>
                                            <td class="text-center">
                                                <?= $perfil['email']?>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                            <style>
                            #titulo1 {
                                background-color: #336;
                                color: #fff;
                                text-align: center;
                            }

                            .titulo2 {
                                background-color: #800000;
                                color: #fff;
                                text-align: center;
                            }
                            </style>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </br>



    </div>
    </div>



    <?php hooks()->do_action('app_customers_portal_footer'); ?>
    <?php require 'modules/recruitment/assets/js/job_detail_portal_js.php';?>

</body>