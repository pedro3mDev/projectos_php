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
                <div class="tw-mb-2">
                    <a href="<?php echo admin_url('custom_fields/field'); ?>" class="btn btn-primary">
                        <i class="fa-regular fa-plus tw-mr-1"></i>
                        <?php echo _l('new_custom_field'); ?>
                    </a>
                </div>
                <div class="panel_s">
                    <div class="panel-body panel-table-full">

                        <?php render_datatable(
    [
                            _l('id'),
                            _l('custom_field_dt_field_name'),
                            _l('custom_field_dt_field_to'),
                            _l('custom_field_dt_field_type'),
                            _l('kb_article_slug'),
                            _l('custom_field_add_edit_active'),
                            ],
    'custom-fields'
); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
$(function() {
    initDataTable('.table-custom-fields', window.location.href);
});
</script>
</body>

</html>