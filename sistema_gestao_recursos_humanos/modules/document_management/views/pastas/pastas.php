<?php init_head(); ?>
<div id="wrapper">
   <div class="content">

   <?php
                $data_view = [];
                $this->load->view('/admin/menu_modulo/menu', $data_view);
      ?>

      <div class="row">
         <div class="col-md-12">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                     <a  style="color:#333; font-size:16px;" href="">
                        <?php echo _l('Gestão Documental'); ?>   
                     </a>
                  </li>
                  <li class="breadcrumb-item active" aria-current="page">
                     <a  style="color:#333; font-size:16px;" href="">
                          <?php echo _l('Pastas'); ?>
                     </a>
                  </li>
               </ol>
            </nav>
         </div>
      </div>

      <div class="row">
         <div class="col-md-12" id="small-table">
            <div class="panel_s">
               <div class="panel-body">
             
                  <div class="row">
                     <div class="col-md-6">
                      <h4 class="no-margin font-bold"><i class="fa fa-address-card-o" aria-hidden="true"></i> <?php echo _l($title); ?></h4>
                      <hr />
                      
                    </div>
                    <div class="col-md-6" style=" display: flex; justify-content: flex-end; align-items: center;">
                     <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                        <i class="fas fa-reply"></i> Retroceder
                     </button>
                   </div>

                  </div>
                  <div class="_buttons">
                     <?php if(is_admin() || has_permission('hrm_setting','','create')){ ?>
                        <a href="#"  data-toggle="modal" data-target="#modal_add" class="btn btn-info pull-left display-block">
                           <?php echo _l('hr_hr_add'); ?>
                        </a>
                     <?php } ?>
                  </div>
                  <div class="row">
                   
                    <div class="">
                           
                    </div> 
                    
                    </div>
                    <br><br>
                     <!--Tabela--> 
                     <form id="" action="" method="get">
                        <div id="tabela">
                           <?php 
                          
                                 $html = '';
                                 $html .= '<table class="table table-bordered table-hover dt-table">';
                                 $html .= '	<thead class="thead-dark">';
                                 $html .= '		 <tr>';
                                 $html .= '			<th>Nome</th>';
                                 $html .= '			<th>secção</th>';
                                 $html .= '			<th>Opções</th>';
                                 $html .= '		</tr>';
                                 $html .= '	</thead>'; 
                                 $html .= ' <tbody>';
                                
                                    foreach ($data as $key => $value) {
                                        $html .= ' <tr>';
                                        $html .= '		<td>'.$value['name'].'</td>';
                                        $html .= '		<td>'.get_seccoes_by_id($value['parent_id'])->name.'</td>';
                                        $html .= '    <td width="10%">';
                                        $html .= '       <a href="'.admin_url('document_management?id='.$value['id']).'"  target="_blank" ><button type="button" class="btn btn-primary"> <i class="fa fa-tag"></i></button></a>';
                                        $html .= '       <button type="button" data-id="'.$value['id'].'" data-name="'.$value['name'].'" class="btn btn-info editar"> <i class="fa fa-edit"></i></button>';
                                        $html .= '       <button data-id="'.$value['id'].'" type="button" class="btn btn-danger eliminar"> <i class="fa fa-trash"></i></button>';
                                        $html .= '    </td>';
                                        $html .= '	</tr>';
                                    }
                            
                                $html .= ' </tbody>';
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
<div class="modal fade" id="modal_add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">
					Adicionar
					</h4>
		</div>
      <div class="modal-body">
            
           
      <form method="post" action="<?php echo admin_url('document_management/add_pastas'); ?>">
      <?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
            <input type="hidden" id="id_mark" name="id">
      <div class="row">
            <div class="col-md-12"> 
                  <label for="" class="form-label">Nome</label>
                  <input name="name" id="name" type="text" class="form-control" required>
                  <input id="parent_id" name="parent_id" type="hidden" class="form-control" value="0">
            </div>
            <div class="col-md-12" style="margin-top: 22px; margin-bottom: 22px">
                                        <label for=""><?php echo _l('Secções'); ?></label>
										<select name="parent_id" class="selectpicker"  id="parent_id" data-width="100%" data-actions-box="true" data-live-search="true" data-none-selected-text=""> 
											<?php 
												foreach ($opt_seccoes as $value) { ?>
													<option value="<?php echo new_html_entity_decode($value['id']); ?>"><?php echo new_html_entity_decode($value['name']); ?></option>
												<?php }
											?>              
										</select>	
		   </div>
      </div>
      <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('hr_close'); ?></button>
					<button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
	</div>
      </form> 
    </div>
  </div>
</div>
</div>
<!--End Modal -->

 
<!-- Modal -->
<div class="modal fade" id="modal_edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">
					Editar
					</h4>
		</div>
      <div class="modal-body">
            
           
      <form method="post" action="<?php echo admin_url('document_management/add_pastas'); ?>">
      <?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
            <input type="hidden" id="id_mark" name="id">
            <div class="row">
               <div class="col-md-12">
                  <label for="" class="form-label">Nome</label>
                  <input name="name" id="e_name" type="text" class="form-control" required>
                  <input id="id" name="id" type="hidden">
                  <!--<input id="parent_id" name="parent_id" type="hidden" class="form-control" value="0"> -->
            </div>
            <div class="col-md-12" style="margin-top: 22px; margin-bottom: 22px">
                                        <label for=""><?php echo _l('Secções'); ?></label>
										<select name="parent_id" class="selectpicker"  id="e_parent_id" data-width="100%" data-actions-box="true" data-live-search="true" data-none-selected-text=""> 
											<?php 
												foreach ($opt_seccoes as $value) { ?>
													<option value="<?php echo new_html_entity_decode($value['id']); ?>"><?php echo new_html_entity_decode($value['name']); ?></option>
												<?php }
											?>              
										</select>	
		   </div>
            
        
         
         
      </div>
      <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('hr_close'); ?></button>
					<button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
		</div>
      </form> 
    </div>
  </div>
</div>
</div>
<!--End Modal -->


 
<!-- Modal -->
<div class="modal fade" id="modal_eliminar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">
					Eliminar
					</h4>
		</div>
      <div class="modal-body">
         <p class="text-danger">Tens certeza que desejas Eliminar ?</p>
      </div>
      <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('hr_close'); ?></button>
					<button id="conf_eliminar" type="button" class="btn btn-info"><?php echo _l('delete'); ?></button>
		</div>

    </div>
  </div>
</div>
</div>
<!--End Modal -->


<?php init_tail(); ?>
<?php require('modules/document_management/assets/js/pastas_js.php'); ?>
</body>
</html>