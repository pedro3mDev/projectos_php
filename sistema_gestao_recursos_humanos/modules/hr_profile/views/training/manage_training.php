<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
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
					Gestão de Integração / Treinamento
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
			<?php if($this->session->flashdata('debug')){ ?>
				<div class="col-lg-12">
					<div class="alert alert-warning">
						<?php echo new_html_entity_decode($this->session->flashdata('debug')); ?>
					</div>
				</div>
			<?php } ?>

			<div class="col-md-12">		
				<ul class="nav navbar-pills navbar-pills-flat nav-tabs">
					<?php
					$i = 0;
					foreach($tab as $group_item){
						?>
						<li<?php if($group_item == $group){echo " class='active'"; } ?>>
							<a href="<?php echo admin_url('hr_profile/training?group='.$group_item); ?>" data-group="<?php echo new_html_entity_decode($group_item); ?>">

								<?php
								if($group_item == 'training_library'){
									echo _l('hr__training_library');
								}elseif($group_item == 'training_program'){
									echo _l('hr__training_program');
								}elseif($group_item == 'training_result'){
									echo _l('hr_training_result');
								}
								?>
							</a>
						</li>
					<?php } ?>
				</ul>
				<style>
					.nav-tabs {
						display: flex;
						justify-content: flex-start; /* Alinha à esquerda, ajuste para 'center' ou 'space-between' se necessário */
						list-style: none;
						padding: 0;
						margin: 0;
					}

					.nav-tabs li {
						margin-right: 10px; /* Espaçamento entre os itens */
					}

					.nav-tabs li a {
						display: block;
						padding: 10px 15px;
						text-decoration: none;
						color: #333; /* Cor do link */
					}
					.nav-tabs li a:hover {
						display: block;
						padding: 10px 15px;
						text-decoration: none;
						background-color: #336;
						color: #fff; /* Cor do link */
					}
					.nav-tabs li.active a {
						color: #fff;
						background-color: #8B0000;
						border-radius: 4px;
					}
				</style>
			</div>
		</div>
		</br>
		<div class="row">
			<div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">

						<?php $this->load->view($tabs['view']); ?>

					</div>
				</div>
			</div>

		<div class="clearfix"></div>
	</div>
	<?php echo form_close(); ?>
</div>
</div>
<?php init_tail(); ?>

<?php hooks()->do_action('settings_tab_footer', $tab); ?>

<?php 
$viewuri = $_SERVER['REQUEST_URI'];
if(!(strpos($viewuri,'admin/hr_profile/training?group=training_program') === false) ){
	require('modules/hr_profile/assets/js/training/training_program_js.php');
}elseif(!(strpos($viewuri,'admin/hr_profile/training?group=training_result') === false)){
	require('modules/hr_profile/assets/js/training/training_result_js.php');

}else{
	require('modules/hr_profile/assets/js/training/training_program_js.php');
}

?>
</body>
</html>
