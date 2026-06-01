


<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div>
	<div class="_buttons">
		<?php if(is_admin() || has_permission('hrm_setting','','create')){ ?>
			<a href="#"  data-toggle="modal" data-target="#modal_add" class="btn btn-info pull-left display-block">
				<?php echo _l('hr_hr_add'); ?>
			</a>
		<?php } ?>
	</div>
	<div class="clearfix"></div>
	<br>
	<table class="table dt-table">
		<thead>
			<th ><?php echo _l('Nome Turnos'); ?></th>
			<th><?php echo _l('Período Laboral'); ?></th>
			<th width="30%"><?php echo _l('Dias de Trabalho'); ?></th>
            <th><?php echo _l('Frequência de Trabalho'); ?></th>
			<th><?php echo _l('options'); ?></th>
		</thead>
		<tbody>
			<?php  
            
               $frequencia[0] = 'Normal';
               $frequencia[1] = '1 Vez por semana';
               $frequencia[2] = '2 Vezes por semana';
               $frequencia[3] = '3 Vezes por semana';
               $frequencia[3] = '3 Vezes por semana';
               $frequencia[4] = '4 Vezes por semana';
               $frequencia[5] = '5 Vezes por semana';
               $frequencia[6] = '6 Vezes por semana';
               $frequencia[7] = '7 Vezes por semana';

               foreach($tabela as $value){ 
               $periodo = get_periodo_laboral_by_id($value['periodo_id']);
             ?>
				<tr>

					<td><?php echo html_entity_decode($value['nome']); ?></td>
					<td><?php echo $periodo->nome.' '.$periodo->data_inicial.' - '.$periodo->data_final; ?></td>
					<td><?php echo organiza_dias_trabalho($value['dias_trabalho']); ?></td>
					<td><?php echo $frequencia[$value['freq_id']]; ?></td>
					<td>
						<?php if(is_admin() || has_permission('hrm_setting','','edit')){ ?>
							<a data-id="<?php echo $value['id'];?>" data-nome="<?php echo $value['nome'];?>" data-periodo_id="<?php echo  $value['periodo_id'];?>"  data-dias_trabalho="<?php echo  $value['dias_trabalho'];?>"  data-freq_id="<?php echo  $value['freq_id'];?>"    href="#"  class="btn btn-default btn-icon btn_edit_turnos"><i class="fa fa-edit"></i></a>
						<?php } ?>

						<?php if(is_admin() || has_permission('hrm_setting','','delete')){ ?>
							<a href="<?php echo admin_url('gestao_assiduidade/delete_horario_turno/'.$value['id']); ?>" class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>
						<?php } ?>

					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>       
	<div class="modal" id="modal_add" tabindex="-1" role="dialog">
		<div class="modal-dialog w-25">
		    <form method="post" action="<?php echo admin_url('gestao_assiduidade/add_horario_turno'); ?>">
		    <?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
			<div class="modal-content ">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">
					Adicionar Período
					</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
						
							<div class="form">
								<div class="col-md-12 mb-4">
									<label for="">Nome Turno</label>
									<input name="nome" type="text" class="form-control" required>
								</div>
                                <div class="col-md-12" style="margin-top: 22px; margin-bottom: 22px">
                                        <label for=""><?php echo _l('Período Laboral'); ?></label>
										<select name="periodo_id" class="selectpicker"  id="" data-width="100%" data-actions-box="true" data-live-search="true" data-none-selected-text=""> 
											<?php 
												foreach ($opt_periodos as $value) { ?>
													<option value="<?php echo new_html_entity_decode($value['id']); ?>"><?php echo new_html_entity_decode($value['nome'].' '.$value['data_inicial'].' - '.$value['data_final']) ?></option>
												<?php }
											?>              
										</select>	
								</div>
								<div class="col-md-12" style="margin-top: 12px; margin-bottom: 12px">
									 <label for="">Dias de Trabalho</label>
									<?php 
                                    			$days_array = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
                                                $days_array_tra = ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'];
                                                 $j = 0;
                                    ?>
                                    <div class="form-check">
                                        <?php  foreach($days_array as $days){ ?>
                                                        <input name="dias_trabalho[]" type="checkbox" class="form-check-input" value="<?php echo $days_array[$j]?>" id="<?php echo "checkbox_".$j;?>">
                                                        <label for="<?php echo "checkbox_".$j;?>" class="form-check-label"><?php echo  $days_array_tra[$j];?></label>    
                                        <?php
                                        $j++;
                                        } 
                                        ?>
                                  </div>
								</div>
                                <div class="col-md-12 ">
									 <label for="">Frequência de Trabalho(N vezes por semana)</label>
									 <select name="freq_id" id="freq_id" class="form-control">
                                        <option value="0">Normal</option>
                                        <option value="1">1 Vez</option>
                                        <option value="2">2 Vezes</option>
                                        <option value="3">3 Vezes</option>
                                        <option value="4">4 Vezes</option>
                                        <option value="5">5 Vezes</option>
                                        <option value="6">6 Vezes</option>
                                        <option value="7">7 Vezes</option>
                                     </select>
								</div>
								
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('hr_close'); ?></button>
					<button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
				</div>
			</div><!-- /.modal-content -->
			</form>
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->


	<form method="post" action="<?php echo admin_url('gestao_assiduidade/edit_horario_turno'); ?>">
     <?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
		<div class="modal" id="modal_editar" tabindex="-1" role="dialog">
		<div class="modal-dialog w-25">
		
			<div class="modal-content ">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">
					Editar Período
					</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						 <div class="form col-12">
								<div class="col-md-12 mb-4">
									<label for="">Nome Turno</label>
									<input name="nome" id="nome" type="text" class="form-control" required>
                                    <input name="id"   id="id" type="hidden" class="form-control">
								</div>
                                <div class="col-md-12" style="margin-top: 22px; margin-bottom: 22px">
                                        <label for=""><?php echo _l('Período Laboral'); ?></label>
										<select name="periodo_id" class="selectpicker"  id="periodo_id" data-width="100%" data-actions-box="true" data-live-search="true" data-none-selected-text=""> 
											<?php 
												foreach ($opt_periodos as $value) { ?>
													<option value="<?php echo new_html_entity_decode($value['id']); ?>"><?php echo new_html_entity_decode($value['nome'].' '.$value['data_inicial'].' - '.$value['data_final']) ?></option>
												<?php }
											?>              
										</select>	
								</div>
								<div class="col-md-12" style="margin-top: 12px; margin-bottom: 12px">
									 <label for="">Dias de Trabalho</label>
									<?php 
                                    			$days_array = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
                                                $days_array_tra = ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'];
                                                 $j = 0;
                                    ?>
                                    <div class="form-check">
                                        <?php  foreach($days_array as $days){ ?>
                                                        <input name="dias_trabalho[]" type="checkbox" class="form-check-input" value="<?php echo $days_array[$j]?>" id="<?php echo "e_checkbox_".$j;?>">
                                                        <label for="<?php echo "checkbox_".$j;?>" class="form-check-label"><?php echo  $days_array_tra[$j];?></label>    
                                        <?php
                                        $j++;
                                        } 
                                        ?>
                                  </div>
								</div>
                                <div class="col-md-12 ">
									 <label for="">Frequência de Trabalho(N vezes por semana)</label>
									 <select name="freq_id" id="e_freq_id" class="form-control">
                                        <option value="0">Normal</option>
                                        <option value="1">1 Vez</option>
                                        <option value="2">2 Vezes</option> 
                                        <option value="3">3 Vezes</option>
                                        <option value="4">4 Vezes</option>
                                        <option value="5">5 Vezes</option>
                                        <option value="6">6 Vezes</option>
                                        <option value="7">7 Vezes</option>
                                     </select>
								</div>
								
							</div>
						
						
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('hr_close'); ?></button>
					<button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
				</div>
			</div><!-- /.modal-content -->
		
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	</form>
	
	
</div>
</body> 
 
 <script>
 
     
   
 </script>

</html> 
