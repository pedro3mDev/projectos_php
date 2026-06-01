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
      </br>


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
                   
                    <div class="">
                            <!--filtros-->
                            <form action="" id="filtros_select">
                              <div class="col-md-4" style="margin-top: 22px; margin-bottom: 22px">
                                       <label for=""><?php echo _l('Departamentos'); ?></label>
                                       <select name="departmentid" class="selectpicker"  id="departmentid" data-width="100%" data-actions-box="true" data-live-search="true" data-none-selected-text=""> 
                                          <option value="0">Nada selecionado</option>
                                          <?php 
                                             foreach ($opt_departments as $value) { ?>
                                                <option value="<?php echo new_html_entity_decode($value['departmentid']); ?>"><?php echo new_html_entity_decode($value['name']); ?></option>
                                             <?php }
                                          ?>              
                                       </select>	  
                              </div>

                              <div class="col-md-4" style="margin-top: 22px; margin-bottom: 22px">
                                       <label for=""><?php echo _l('Funcionários'); ?></label>
                                       <select name="funcionarios_id" class="selectpicker"  id="funcionarios_id" data-width="100%" data-actions-box="true" data-live-search="true" data-none-selected-text=""> 
                                          <option value="0">Nada selecionado</option>          
                                       </select>	
                              </div>

                              <div class="col-md-4" style="margin-top: 22px; margin-bottom: 22px">
                                       <label for=""><?php echo _l('Mês'); ?></label>
                                       <select name="meses_id" class="selectpicker"  id="meses_id" data-width="100%" data-actions-box="true" data-live-search="true" data-none-selected-text=""> 
                                          <option value="0">Nada selecionado</option>
                                          <?php 
                                             foreach ($opt_meses as $key => $value) { ?>
                                                <option value="<?php echo new_html_entity_decode( $key+1); ?>"><?php echo new_html_entity_decode($value); ?></option>
                                                  
                                             <?php
                                             if (( $key+1) >= date('m')) {
                                                break;
                                             }

                                             }
                                              ?>              
                                       </select>	
                              </div>
                         </form>
                             <!--end filtros-->
                    </div> 
                    
                    </div>
                    <br><br>
                     <!--Tabela-->
                     <form id="" action="" method="get">
                        <div id="tabela">
                           <?php 
                                 $html = '';
                                 $html .= '<table class="table table-bordered table-hover">';
                                 $html .= '	<thead class="thead-dark">';
                                 $html .= '		 <tr>';
                                 $html .= '			<th>Data</th>';
                                 $html .= '			<th>Entrada - Saida</th>';
                                 $html .= '			<th>Tipo</th>';
                                 $html .= '			<th>Assiduidade</th>';
                                 $html .= '			<th>Opções</th>';
                                 $html .= '		</tr>';
                                 $html .= '	</thead>';
                                 $html .= ' <tbody>';
                                 $html .= ' </tbody>';
                                 $html .= '		 <tr class="text-center" style="font-size: 1.2rem">';
                                 $html .= '		    <td colspan="5">por favor, seleciona os filtros para apresentar a informação</td>';
                                 $html .= '		</tr>';
                                 $html .= '</table>';
                                 echo $html;
                              
                              ?>
                        </div>
                     </form>

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



<!-- Modal -->
<div class="modal fade" id="modalAddMark" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">
					Adicionar Marcações
					</h4>
		</div>
      <div class="modal-body">
            
           
         <form action="" id="form_add">
            <input type="hidden" id="id_mark" name="id">
            <div class="row">
               <div class="col-md-5">
                  <label for="" class="form-label">Entrada</label>
                  <input id="d_entrada" type="time" class="form-control">
               </div>
               <div class="col-md-5">
                  <label for="" class="form-label">Saída</label>
                  <input id="d_saida" type="time" class="form-control">
               </div>
               <div class="col-md-2">
                  <button id="itemSelect" type="button" class="btn btn-primary" style="margin-top: 22px"><i class="fa fa-check"></i></button>
               </div>
            </div>
            <div id="item_marks"></div>
            
         </form>      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
<!--End Modal -->


<?php init_tail(); ?>
<?php require('modules/gestao_assiduidade/assets/js/registros_de_assiduidade_js.php'); ?>
</body>
</html>