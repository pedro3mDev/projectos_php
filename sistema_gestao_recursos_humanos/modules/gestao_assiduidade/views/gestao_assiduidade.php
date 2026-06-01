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
               Gestão de Assiduidade / <?php echo _l('Registros de Assiduidade'); ?>
            </a>
            </div>
            <div class="col-md-6" style=" display: flex; justify-content: flex-end; align-items: center;">
            <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                <i class="fas fa-reply"></i> Retroceder
            </button>
            </div>
        </div>
      

      <div class="row">
         <div class="col-md-12" id="small-table">
            <div class="panel_s">
               <div class="panel-body">
             
                  <div class="row">
                     <div class="col-md-12">
                      <h4 class="no-margin font-bold"><i class="fa fa-address-card-o" aria-hidden="true"></i> <?php echo _l($title); ?></h4>
                      <hr />
                    </div>
                  </div>
                  <div class="row">
                   
                    <div class=" col-md-2">
                            <!--filtros-->

                             <!--end filtros-->
                    </div> 
                    <div class="col-md-1 pull-right">
                        <a href="#" class="btn btn-default pull-right btn-with-tooltip toggle-small-view hidden-xs" onclick="toggle_small_view_proposal('.proposal_sm','#proposal_sm_view'); return false;" data-toggle="tooltip" title="<?php echo _l('invoices_toggle_table_tooltip'); ?>"><i class="fa fa-angle-double-left"></i></a>
                    </div>
                    </div>
                    <br><br>
                     <!--Tabela-->
					  <!--end Tabela-->
               </div>
            </div>
         </div>
         <div class="col-md-7 small-table-right-col">
            <div id="proposal_sm_view" class="hide">
            </div>
         </div>
      </div>
   </div>
   
</div>


<?php init_tail(); ?>
</body>
</html>