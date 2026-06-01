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
					Gestão de Requisições / Aprovações
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
            <div class="panel_s">
                <div class="panel-body">
                    <div class="col-md-12">
                        <h4><?php echo _l('Aprovações'); ?></h4>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">                        
                            </div>
                            <div class="col-md-3">
                                <?php echo render_select('approvify_request_status', [
                                    [
                                        'id' => 'sub',
                                        'name' => _l('approvify_submitted_status')
                                    ],
                                    [
                                        'id' => '1',
                                        'name' => _l('approvify_approved_status')
                                    ],
                                    [
                                        'id' => '2',
                                        'name' => _l('approvify_refused_status')
                                    ],
                                    [
                                        'id' => '3',
                                        'name' => _l('approvify_canceled_status')
                                    ]
                                ], array('id', 'name'), 'approvify_request_status', '', array('multiple' => true, 'data-actions-box' => true), array(), '', '', false); ?>
                            </div>
                            <div class="col-md-3">
                                <?php echo render_select('approvify_request_staff', $staff, array('staffid', array('firstname', 'lastname')), 'Membro da Equipa', '', array('multiple' => true, 'data-actions-box' => true), array(), '', '', false); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php render_datatable([
                            _l('id'),
                            _l('approvify_request_title'),
                            _l('approvify_request_category'),
                            _l('approvify_requested_by'),
                            _l('approvify_request_status'),
                            _l('approvify_request_reviewers'),
                            _l('approvify_table_created_at'),
                            _l('options'),
                        ], 'manage-review-requests'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
    "use strict";

    var fnServerParams;

    $(function () {

        generate_table();

        fnServerParams = {
            "approvify_request_status": '[name="approvify_request_status"]',
            "approvify_request_staff": '[name="approvify_request_staff"]'
        }

        $('select[name="approvify_request_status"]').on('change', function () {
            generate_table();
        });

        $('select[name="approvify_request_staff"]').on('change', function () {
            generate_table();
        });

    });

    function generate_table() {

        const tableClass = $('.table-manage-review-requests');

        if ($.fn.DataTable.isDataTable(tableClass)) {
            tableClass.DataTable().destroy();
        }
        initDataTable(tableClass, window.location.href, [0], [0], fnServerParams, [0, 'desc']);
    }

</script>