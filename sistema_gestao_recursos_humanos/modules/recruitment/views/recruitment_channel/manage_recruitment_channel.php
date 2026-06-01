<?php init_head();?>
<div id="wrapper">
   <div class="content">
      <?php
         $data_view = [];
         $this->load->view('/admin/menu_modulo/menu', $data_view);
      ?>
      <div class="row">
         <div class="col-md-6">
         <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
            Recrutamento e Selecção / Canal de Recrutamento
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
         <div class="col-md-12" id="small-table">
            <div class="panel_s">
               <div class="panel-body">
                <?php echo form_hidden('rec_channel_id', $rec_channel_id); ?>
                  <div class="row">
                     <div class="col-md-12">
                      <h4 class="no-margin font-bold"><?php echo _l($title); ?></h4>
                      <hr />
                    </div>
                  </div>
                  <a href="<?php echo admin_url('recruitment/add_edit_recruitment_channel'); ?>" class="btn btn-info pull-left display-block"><?php echo _l('new'); ?></a>

                  <div class="col-md-1 pull-right">
                      <a href="#" class="btn btn-default pull-right btn-with-tooltip toggle-small-view hidden-xs" onclick="toggle_small_view_campaign('.campaign_sm','#campaign_sm_view'); return false;" data-toggle="tooltip" title="<?php echo _l('invoices_toggle_table_tooltip'); ?>"><i class="fa fa-angle-double-left"></i></a>
                  </div>
                    <br><br><br>
                  <?php render_datatable(array(
	_l('id'),
	_l('r_form_name'),
	_l('responsible_person'),
	_l('form_type'),
	_l('status'),

), 'table_recruitment_channel');?>
               </div>
            </div>
         </div>
        <div class="col-md-7 small-table-right-col">
          <div id="campaign_sm_view" class="hide">
          </div>
        </div>

      </div>
   </div>
</div>
<?php init_tail();?>
</body>
</html>
