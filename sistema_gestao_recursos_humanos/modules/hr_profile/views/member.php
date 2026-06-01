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
                Gestão de Integração / Membro
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
			<?php if($hr_profile_member_add == false){ ?>
				<div class="col-md-3">
					<ul class="nav navbar-pills navbar-pills-flat nav-tabs nav-stacked">
						<?php
						$i = 0;
						foreach($tab as $group_item){
							?>
							<li<?php if($group_item == $group){echo " class='active'"; } ?>>
							<a href="<?php echo admin_url('hr_profile/member/'.$staffid.'/'.$group_item); ?>" data-group="<?php echo new_html_entity_decode($group_item); ?>">
								<?php echo _l($group_item); ?>
							</a>
						</li>
					<?php } ?>
				</ul>
			</div>
		<?php } ?>
		<div class="<?php if($hr_profile_member_add == false){ echo 'col-md-9'; }else{ echo 'col-md-12'; } ?>">
			<div class="panel_s">
				<div class="panel-body">
					<?php $this->load->view($tabs['view']); ?>
				</div>
			</div>
		</div>

		<div class="clearfix"></div>
	</div>
	<?php echo form_close(); ?>
	<div class="btn-bottom-pusher"></div>
</div>
</div>
<div id="new_version"></div>
<?php init_tail(); ?>
<?php
require('modules/hr_profile/assets/js/setting/manage_setting_js.php');
hooks()->do_action('settings_tab_footer', $tab); ?>
</body>
</html>
