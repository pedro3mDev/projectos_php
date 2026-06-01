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
                Gestão Documental / Configurações
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
			<div class="col-md-3">
				<ul class="nav navbar-pills navbar-pills-flat nav-tabs nav-stacked" style="border-left: 3px solid #8B0000;">
					<li	<?php if($tab == 'custom_field'){echo " class='active'"; } ?>>
						<a href="<?php echo admin_url('document_management/settings?tab=custom_field'); ?>">
							<?php echo _l('dmg_custom_field'); ?>
						</a>
					</li>
					<li	<?php if($tab == 'approval_setting'){echo " class='active'"; } ?>>
						<a href="<?php echo admin_url('document_management/settings?tab=approval_setting'); ?>">
							<?php echo _l('dmg_approval_settings'); ?>
						</a>
					</li>
					<li	<?php if($tab == 'other_setting'){echo " class='active'"; } ?>>
						<a href="<?php echo admin_url('document_management/settings?tab=other_setting'); ?>">
							<?php echo _l('dmg_other_settings'); ?>
						</a>
					</li>
				</ul>
			</div>

			<div class="col-md-9">
				<div class="panel_s" style="border-left: 3px solid #8B0000;">
					<div class="panel-body">
						<?php $this->load->view('settings/includes/tabs/'.$tab); ?>  
					</div>
				</div>
			</div>


			<div class="clearfix"></div>
		</div>
		<div class="btn-bottom-pusher"></div>
	</div>
</div>
<div id="new_version"></div>
<?php init_tail(); ?>
</body>
</html>

