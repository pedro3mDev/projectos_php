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
                Minhas Candidaturas
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
                                Minhas Candidaturas
                            </h4>
                            <hr />
                            <div>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th id="titulo1" class="text-center">Nome</th>
                                            <th id="titulo1" class="text-center">Cargo</th>
                                            <th class="titulo2" class="text-center">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($candidaturas as $item) : ?>
                                        <?php
                                            switch ($item['status']) {
                                                case 1: $status = _l('application'); break;
                                                case 2: $status = _l('potential'); break;
                                                case 3: $status = _l('interview'); break;
                                                case 4: $status = _l('won_interview'); break;
                                                case 5: $status = _l('send_offer'); break;
                                                case 6: $status = _l('elect'); break;
                                                case 7: $status = _l('non_elect'); break;
                                                case 8: $status = _l('unanswer'); break;
                                                case 9: $status = _l('transferred'); break;
                                                case 10: $status = _l('freedom'); break;
                                                default:
                                                $status = $item['status'];
                                                    break;
                                            }
                                        ?>
                                        <tr>
                                            <td class="text-center">
                                                <?= $item['campaign_name'] ?>
                                            </td>
                                            <td class="text-center">
                                                <?= $item['position_name'] ?>
                                            </td>
                                            <td class="text-center">
                                                <?= $status ?>
                                            </td>
                                        </tr>
                                        <?php endforeach ?>
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