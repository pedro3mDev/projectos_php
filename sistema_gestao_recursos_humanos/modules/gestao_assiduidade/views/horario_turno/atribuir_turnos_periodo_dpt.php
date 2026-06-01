<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div>
	<div class="_buttons">
	</div>
	<div class="clearfix"></div>
	<br>
	<table class="table dt-table">
		<thead>
		    <th><?php echo _l('Direção'); ?></th>
			<th><?php echo _l('Deprtamento'); ?></th>
			<th><?php echo _l('options'); ?></th> 
		</thead>
		<tbody>
			<?php   foreach($tabela as $value){ ?>
				<tr>
					<td><?php echo get_direcao_by_id($value['direcoes_id'])->nome; ?></td>
					<td><?php echo html_entity_decode($value['name']); ?></td>
					<td>
						<?php if(is_admin() || has_permission('hrm_setting','','edit')){ ?>
							<a    href="<?php echo admin_url('gestao_assiduidade/horario_turno?group=atribuir_turnos_periodo_dpt&pag=atribuir_turnos_periodo&num='.$value['departmentid']); ?>"  class="btn btn-info btn-icon"><i class="fa fa-cogs" style="color: white;"></i></a>
						<?php } ?>

					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>       
	



	
	
</div>
</body> 
 
 <script>
 
     
   
 </script>

</html> 
