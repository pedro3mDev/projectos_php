<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div>
	<div class="_buttons">
	</div>
	<div class="clearfix"></div>
	<br>
	<div class="row" style="margin-left: 8px;">
		<div class="col-12" >
			<a href="<?php echo admin_url('gestao_assiduidade/horario_turno?group=atribuir_turnos_periodo_dpt'); ?>"><button class="btn btn-primary" style="background-color: #007bff; border-color: #007bff; color: white;">Voltar</button> </a>
		</div>
	</div>
	<br>
	<h4><strong>Departamento de: </strong><?php echo $department->name ?></h4>
	<br>
	<form method="post" action="<?php echo admin_url('gestao_assiduidade/atr_horario_turno'); ?>">
     <?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
	 <input name="departmentid" type="hidden" value="<?php echo $department->departmentid ?>">
	<div class="row">
			<div class="col-md-6" style="margin-top: 22px; margin-bottom: 22px">
												<label for=""><?php echo _l('Turnos'); ?></label>
												<select name="turnos_id" class="selectpicker"  id="" data-width="100%" data-actions-box="true" data-live-search="true" data-none-selected-text=""> 
													<option value="0">Nada selecionado</option>
													<?php 
														foreach ($opt_turnos as $value) { ?>
															<option value="<?php echo new_html_entity_decode($value['id']); ?>"><?php echo new_html_entity_decode($value['nome']); ?></option>
														<?php }
													?>              
												</select>	
		</div>
		<div class="col-md-4">
				<button type="submit" style="margin-top: 50px; background-color: #007bff; border-color: #007bff; color: white;" class="btn btn-primary">Atribuir aos selecionados</button>
		</div>
   </div>
	<br>
	<table class="table dt-table">
		<thead>
			<th width="30%"><?php echo _l('Funcionário'); ?></th>
			<th><?php echo _l('Turno'); ?></th>
            <th><?php echo _l('Período Laboral'); ?></th>
            <th><?php echo _l('Frequência'); ?></th>
			<th><?php echo _l('Marcar para alterar'); ?></th>  
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
				$turno_nome      = '';
				$periodo_nome    = '';
				$frequencia_nome = '';
				
				$turno = get_turnos_by_id($value['turnos_id']);

				if(isset($turno)){ 
					$turno_nome       = $turno->nome; 
					$frequencia_nome  = $frequencia[$turno->freq_id]; 
					$periodo = get_periodo_laboral_by_id($turno->periodo_id); 
					if(isset($periodo)){ $periodo_nome = $periodo->nome; }
				}
		?>
			<tr>

				<td><?php echo html_entity_decode($value['firstname'].' '.$value['lastname']); ?></td>
				<td><?php echo $turno_nome;?></td>
				<td><?php echo  $periodo_nome; ?></td>
				<td><?php echo $frequencia_nome; ?></td>
					<td>
						<div class="form-check">
							<input type="checkbox" class="form-check-input check_ids" name="ids[]" value="<?php echo $value['staffid']; ?>" >
						</div>

					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>       

	</form>
	
</div>
</body> 
 
 <script>
 
     
   
 </script>

</html> 
