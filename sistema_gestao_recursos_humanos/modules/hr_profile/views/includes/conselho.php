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
			<th width="30%"><?php echo _l('Conselho Nome'); ?></th>
			<th><?php echo _l('Conselho Email'); ?></th>
			<th><?php echo _l('options'); ?></th>
		</thead>
		<tbody>
			<?php
			
			// $conselho[1] = 'Conselho de Administração';
			foreach($tabela as $c){ ?>
				<tr>

					<td><?php echo html_entity_decode($c['nome']); ?></td>
					<td><?php echo $c['email']; ?></td>
					<td>
						<?php if(is_admin() || has_permission('hrm_setting','','edit')){ ?>
							<a data-id="<?php echo $c['id'];?>" data-nome="<?php echo $c['nome'];?>" data-email="<?php echo $c['email'];?>"   href="#"  class="btn btn-default btn-icon btn_edit_pelorio"><i class="fa fa-edit"></i></a>
						<?php } ?>

						<?php if(is_admin() || has_permission('hrm_setting','','delete')){ ?>
							<a href="<?php echo admin_url('hr_profile/delete_conselho/'.$c['id']); ?>" class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>
						<?php } ?>

					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>       
	<div class="modal" id="modal_add" tabindex="-1" role="dialog">
		<div class="modal-dialog w-25">
		    <form method="get" action="<?php echo admin_url('hr_profile/add_conselho'); ?>">
		
			<div class="modal-content ">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">
					Adicionar Conselho
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

    <form method="get" action="<?php echo admin_url('hr_profile/edit_conselho'); ?>">
	
		<div class="modal" id="editar" tabindex="-1" role="dialog">
		<div class="modal-dialog w-25">
		
			<div class="modal-content ">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">
					Editar Conselho
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
