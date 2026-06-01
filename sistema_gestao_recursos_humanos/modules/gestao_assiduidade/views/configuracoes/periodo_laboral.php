<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div>
	<div class="_buttons">
		<?php if(is_admin() || has_permission('hrm_setting','','create')){ ?>
			<a href="#"  data-toggle="modal" data-target="#modal_add" class="btn btn-info pull-left display-block" style="background-color: #007bff; color: white;">
				<?php echo _l('hr_hr_add'); ?>
			</a>
		<?php } ?>
	</div>
	<div class="clearfix"></div>
	<br>
	<table class="table dt-table">
		<thead>
			<th width="30%"><?php echo _l('Período laboral Nome'); ?></th>
			<th><?php echo _l('Hora início'); ?></th>
			<th><?php echo _l('Hora final'); ?></th>
			<th><?php echo _l('Intervalo'); ?></th>
			<th><?php echo _l('options'); ?></th>
		</thead>
		<tbody>
			<?php  foreach($tabela as $value){ ?>
				<tr>

					<td><?php echo html_entity_decode($value['nome']); ?></td>
					<td><?php echo $value['data_inicial']; ?></td>
					<td><?php echo $value['data_final']; ?></td>
					<td><?php echo $value['intervalo']; ?></td>
					<td>
						<?php if(is_admin() || has_permission('hrm_setting','','edit')){ ?>
							<a data-id="<?php echo $value['id'];?>" data-nome="<?php echo $value['nome'];?>" 
                        data-data_inicial="<?php echo  $value['data_inicial'];?>" data-data_final="<?php echo  $value['data_final'];?>"  
                        data-intervalo="<?php echo  $value['intervalo'];?>" href="#"  
                        class="btn btn-primary btn-icon btn_edit_periodo" 
                        style="background-color: #007bff; border-color: #007bff; color: white;">
                        <i class="fa fa-edit" style="color: white;"></i>
                        </a>

						<?php } ?>

						<?php if(is_admin() || has_permission('hrm_setting','','delete')){ ?>
							<a href="<?php echo admin_url('gestao_assiduidade/delete_periodos/'.$value['id']); ?>" 
                        class="btn btn-danger btn-icon _delete" 
                        style="color: white;">
                        <i class="fa fa-remove" style="color: white;"></i>
                        </a>

						<?php } ?>

					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>       
	<div class="modal" id="modal_add" tabindex="-1" role="dialog">
		<div class="modal-dialog w-25">
		    <form method="post" action="<?php echo admin_url('gestao_assiduidade/add_periodos'); ?>">
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
								<div class="col-md-12">
									<label for="">Nome</label>
									<input name="nome" type="text" class="form-control" required>
								</div>
								<div class="col-md-12">
									 <label for="">Data inicial</label>
									 <input name="data_inicial" type="time" class="form-control" required>
								</div>
								<div class="col-md-12">
									 <label for="">Data Final</label>
									 <input name="data_final" type="time" class="form-control" required>
								</div>
								<div class="col-md-12">
									 <label for="">Intervalo  0.5 = 30 min</label>
									 <input name="intervalo" type="text" class="form-control" required>
								</div>
								
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo _l('hr_close'); ?></button>
					<button type="submit" class="btn btn-success"><?php echo _l('submit'); ?></button>
				</div>
			</div><!-- /.modal-content -->
			</form>
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->


	<form method="post" action="<?php echo admin_url('gestao_assiduidade/edit_periodos'); ?>">
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
						<div class="col-md-12">
						
						<input name="id" id="id" type="hidden" required>
						    <div class="form">
							    <div class="col-md-12">
									<label for="">Nome</label>
									<input name="nome" id="nome" type="text" class="form-control" required>
								</div>
								<div class="col-md-12">
									 <label for="">Data inicial</label>
									 <input name="data_inicial" id="data_inicial" type="time" class="form-control">
								</div>
								<div class="col-md-12">
									 <label for="">Data Final</label>
									 <input name="data_final" id="data_final" type="time" class="form-control">
								</div>
								<div class="col-md-12">
									 <label for="">Intervalo  0.5 = 30 min</label>
									 <input name="intervalo"  id="intervalo" type="text" class="form-control">
								</div>
								
							</div>
						
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo _l('hr_close'); ?></button>
					<button type="submit" class="btn btn-success"><?php echo _l('submit'); ?></button>
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
