<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div>
	<div class="clearfix"></div>
	<br>
 

    
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
                        <div class="_buttons col-md-12">
                        

                        </div> 
                  </div>
                  <br><br>
                  
                  <div class="row">

          
                    <div class="">
                            <!--filtros-->
                            <?php
                            if (!isset($filtros['departmentid'])) {
                              $filtros['departmentid'] = 0;
                            }
                            if (!isset($filtros['funcao_id'])) {
                              $filtros['funcao_id'] = 0;
                            }

                            if (!isset($filtros['estado'])) {
                              $filtros['estado'] = 0;
                            }

                            ?>
                            <form action="<?php echo admin_url('gestao_assiduidade/gestao_de_ferias_geral?group=funcionarios_em_ferias'); ?>" id="filtros_select">
                              <div class="col-md-3" style="margin-top: 22px; margin-bottom: 22px">
                                       <label for=""><?php echo _l('Departamentos'); ?></label>
                                       <select name="departmentid" class="selectpicker"  id="departmentid" data-width="100%" data-actions-box="true" data-live-search="true" data-none-selected-text=""> 
                                          <option value="0">Nada selecionado</option>
                                          <?php 
                                             foreach ($opt_departments as $value) { ?>
                                                <option value="<?php echo new_html_entity_decode($value['departmentid']); ?>"  <?php if($filtros['departmentid']==$value['departmentid']){ echo "selected";} ?>><?php echo new_html_entity_decode($value['name']); ?></option>
                                             <?php }
                                          ?>              
                                       </select>	  
                              </div>
                              <input type="hidden" name="group" value="funcionarios_em_ferias">
                                                
                              <div class="col-md-3" style="margin-top: 22px; margin-top: 42px">
                                  <button id="btn_pesquisar" class="btn btn-primary"> Pesquisar </button>	
                              </div>
                         </form>
                             <!--end filtros-->
                    </div> 
                    
                    </div>
                    <br>
                     
                    <br>
                     <!--Tabela--> 
                        <div id="tabela">
                           <?php   echo $tabela; ?>
                        </div>

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
</body> 
 
 <script>
 
     
   
 </script>

</html> 
