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
	<br>

	<br>
	<table class="table dt-table">
		<thead>
			<th width="30%"><?php echo _l('Direções Nome'); ?></th>
			<th><?php echo _l('Direções Email'); ?></th>
			<th><?php echo _l('Pelório'); ?></th>
			<th><?php echo _l('options'); ?></th>
		</thead>
		<tbody>
			<?php foreach($tabela as $c){ ?>
				<tr>

					<td><?php echo html_entity_decode($c['nome']); ?></td>
					<td><?php echo $c['email']; ?></td>
					<td><span class="label label-tag "><?php echo get_pelorio_by_id($c['pelorios_id'])->nome; ?></span></td>
					<td>
						<?php if(is_admin() || has_permission('hrm_setting','','edit')){ ?>
							<a data-id="<?php echo $c['id'];?>" data-nome="<?php echo $c['nome'];?>" data-email="<?php echo $c['email'];?>" data-pelorios_id="<?php echo $c['pelorios_id'];?>"   href="#"  class="btn btn-default btn-icon btn_edit_direcao"><i class="fa fa-edit"></i></a>
						<?php } ?>

						<?php if(is_admin() || has_permission('hrm_setting','','delete')){ ?>
							<a href="<?php echo admin_url('hr_profile/delete_direcoes/'.$c['id']); ?>" class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>
						<?php } ?>

					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>       
	<div class="modal" id="modal_add" tabindex="-1" role="dialog">
		<div class="modal-dialog w-25">
		    <form method="get" action="<?php echo admin_url('hr_profile/add_direcoes'); ?>">
		
			<div class="modal-content ">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">
					Adicionar
					</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
						
							<div class="form">
								<div class="col-md-12">
									<?php 
									echo render_input('name','Nome<span class="text-danger">*</span>'); ?>
								</div>
								<div class="col-md-12">
									<?php 
									echo render_input('email','Email'); ?>
								</div>
								<div class="col-md-12">
										<select name="pelorio_id" class="selectpicker" data-width="100%" data-actions-box="true" data-live-search="true" data-none-selected-text="<?php echo _l('Pelorios'); ?>"> 
											<?php 
												foreach ($opt_pelorios as $value) { ?>
													<option value="<?php echo new_html_entity_decode($value['id']); ?>"><?php echo new_html_entity_decode($value['nome']) ?></option>
												<?php }
											?>              
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

    <form method="get" action="<?php echo admin_url('hr_profile/edit_direcoes'); ?>">
	
		<div class="modal" id="editar" tabindex="-1" role="dialog">
		<div class="modal-dialog w-25">
		
			<div class="modal-content ">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">
					Editar 
					</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
						
							<div class="form">
								<div class="col-md-12">
                                    <input type="hidden" id="e_id" name="id">
									<?php 
									echo render_input('e_name','nome'); ?>
								</div>
								<div class="col-md-12">
									<?php 
									echo render_input('e_email','email'); ?>
								</div>
								<div class="col-md-12">
										<select name="pelorio_id" class="selectpicker"  id="e_pelorio_id" data-width="100%" data-actions-box="true" data-live-search="true" data-none-selected-text="<?php echo _l('Pelorios'); ?>"> 
											<?php 
												foreach ($opt_pelorios as $value) { ?>
													<option value="<?php echo new_html_entity_decode($value['id']); ?>"><?php echo new_html_entity_decode($value['nome']) ?></option>
												<?php }
											?>              
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
		
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
    </form>
	
</div>
</body>
 
 <script>
 
     
   
 </script>

</html> 
