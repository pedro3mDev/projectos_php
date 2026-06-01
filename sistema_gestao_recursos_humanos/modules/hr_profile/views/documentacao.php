<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
$this->load->model('hr_profile/hr_profile_model');
$data_dash = $this->hr_profile_model->get_hr_profile_dashboard_data();

$staff_chart_by_age = json_encode($this->hr_profile_model->staff_chart_by_age());
$contract_type_chart = json_encode($this->hr_profile_model->contract_type_chart());
$staff_departments_chart = json_encode($this->hr_profile_model->staff_chart_by_departments());
$staff_chart_by_job_positions = json_encode($this->hr_profile_model->staff_chart_by_job_positions());
?>

<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
	<?php
            $data_view = [];
            $this->load->view('/admin/menu_modulo/menu', $data_view);
      	?>

		<div class="row">
			<div class="col-md-12" >
				<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" >
				<ol class="breadcrumb">
					<li class="breadcrumb-item">
						<a  style="color:#333; font-size:16px;" href="">
							Gestão de Integração
						</a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">
						<a  style="color:#333; font-size:16px;" href="<?= admin_url('clients/all_contacts'); ?>">
						Documentação
						</a>
					</li>
				</ol>
				</nav>
			</div>
		</div>
		<div class="clearfix"></div>
		
		<div class="row">
         
			<div class="quick-stats-invoices col-md-6" >
				<div class="top_stats_wrapper minheight85" >
					<a class="text-warning mbot15">
						<p class="text-uppercase mtop5 minheight35" style="font-size: 14px; font-weight: bold;">
							<i class="hidden-sm glyphicon glyphicon-edit"></i> 
							fdcx
						</p>
						<span class="pull-right bold no-mtop fontsize24">
							0
						</span>
					</a>
					<div class="clearfix"></div>
					<div class="progress no-margin progress-bar-mini">
						<div class="progress-bar progress-bar-warning no-percent-text not-dynamic" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="" data-percent="100%">
						</div>
					</div>
				</div>
			</div>

			<div class="quick-stats-invoices col-md-6">
				<div class="top_stats_wrapper minheight85">
				<a class="text-warning mbot15">
					<p class="text-uppercase mtop5 minheight35" style="font-size: 14px; font-weight: bold;">
						<i class="hidden-sm glyphicon glyphicon-edit"></i> 
						lf.dçsc
					</p>
					<span class="pull-right bold no-mtop fontsize24">
						0
					</span>
				</a>
				<div class="clearfix"></div>
				<div class="progress no-margin progress-bar-mini">
					<div class="progress-bar progress-bar-warning no-percent-text not-dynamic" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="" style="" data-percent="">
					</div>
				</div>
				</div>
			</div>

		</div>

		</br>

		<div class="row">
			<div class="col-md-12 p-0">
				<div class="panel_s">
					<div class="panel-body">
						<div class="widget" id="widget-<?php echo basename(__FILE__,".php"); ?>" data-name="<?php echo _l('hr_hr_profile'); ?>">
							<div class="row">
								<div class="col-md-12">
									<div class="col-md-6">
										<p class="text-dark text-uppercase bold"><?php echo _l('hr_hr_profile_dashboard');?></p>
									</div>
									<div class="col-md-3 pull-right">

									</div>
									<br>
									<hr class="mtop15" />




								</div>
								<div class="col-md-6">
									<div id="staff_departments_chart">
									</div>
								</div>
								<div class="col-md-6">
									<div id="staff_chart_by_job_positions">
									</div>
								</div>

								<div class="col-md-6">
									<div id="staff_chart_by_age">
									</div>
								</div>
								<div class="col-md-6">
									<div id="staff_chart_by_fluctuate_according_to_seniority">
									</div>
								</div>
								<div class="col-md-12">
									<div id="report_by_staffs">
									</div>
								</div>

								<hr class="hr-panel-heading-dashboard">

								

						
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>
<div class="clearfix"></div>
<?php init_tail();
require('modules/hr_profile/assets/js/hr_profile_dashboard_js.php');
?>



