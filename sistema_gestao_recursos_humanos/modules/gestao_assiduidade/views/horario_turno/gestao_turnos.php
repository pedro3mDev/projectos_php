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
			<th width="30%"><?php echo _l('Nome Biométrico'); ?></th>
			<th><?php echo _l('Código'); ?></th>
			<th><?php echo _l('IP'); ?></th>
            <th><?php echo _l('Porta'); ?></th>
            <th><?php echo _l('Local'); ?></th>
			<th><?php echo _l('options'); ?></th>
		</thead>
		<tbody>
			<?php $tabela=[];  foreach($tabela as $value){ ?>
				<tr>

					<td><?php echo html_entity_decode($value['nome']); ?></td>
					<td><?php echo $value['codigo']; ?></td>
					<td><?php echo $value['ip']; ?></td>
					<td><?php echo $value['porta']; ?></td>
                    <td><?php echo $value['local']; ?></td>
					<td>
						<?php if(is_admin() || has_permission('hrm_setting','','edit')){ ?>
							<a data-id="<?php echo $value['id'];?>" data-nome="<?php echo $value['nome'];?>" data-codigo="<?php echo  $value['codigo'];?>"  data-ip="<?php echo  $value['ip'];?>"  data-porta="<?php echo  $value['porta'];?>"  data-local="<?php echo  $value['local'];?>"    href="#"  class="btn btn-default btn-icon btn_edit_biometricos"><i class="fa fa-edit"></i></a>
						<?php } ?>

						<?php if(is_admin() || has_permission('hrm_setting','','delete')){ ?>
							<a href="<?php echo admin_url('gestao_assiduidade/delete_biometricos/'.$value['id']); ?>" class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>
						<?php } ?>

					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>       
	<div class="modal" id="modal_add" tabindex="-1" role="dialog">
		<div class="modal-dialog w-25">
		    <form method="post" action="<?php echo admin_url('gestao_assiduidade/add_biometricos'); ?>">
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
									<label for="">Código</label>
									<input name="codigo" type="text" class="form-control" required>
								</div>
								<div class="col-md-12">
									 <label for="">IP</label>
									 <input name="ip" type="text" class="form-control" required>
								</div>
                                <div class="col-md-12">
									 <label for="">Porta</label>
									 <input name="porta" type="text" class="form-control" required>
								</div>
                                <div class="col-md-12">
									 <label for="">Local</label>
									 <input name="local" type="text" class="form-control" required>
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


	<form method="post" action="<?php echo admin_url('gestao_assiduidade/edit_biometricos'); ?>">
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
									<label for="">Código</label>
									<input name="codigo" id="codigo" type="text" class="form-control" required>
								</div>
								<div class="col-md-12">
									 <label for="">IP</label>
									 <input name="ip" id="ip" type="text" class="form-control" required>
								</div>
                                <div class="col-md-12">
									 <label for="">Porta</label>
									 <input name="porta" id="porta" type="text" class="form-control" required>
								</div>
                                <div class="col-md-12">
									 <label for="">Local</label>
									 <input name="local" id="local" type="text" class="form-control" required>
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
