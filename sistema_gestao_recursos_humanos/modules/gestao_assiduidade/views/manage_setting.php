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
                    Gestão de Assiduidade / Configurações
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
    		<?php
					$i = 0;
					foreach($tab as $group_item){ 
						?>
						<li<?php if($group_item == $group){echo " class='active'"; } ?>>
						<a href="<?php echo admin_url('gestao_assiduidade/configuracoes?group='.$group_item); ?>" data-group="<?php echo new_html_entity_decode($group_item); ?>">

							<?php
							if($group_item == 'periodo_laboral'){
							 echo '<i class="fa fa-clock"></i>' ._l(' Período Laboral');
							}elseif($group_item == 'feriados'){
							 echo '<i class="fa fa-plane"></i>' ._l(' Feríados');
							}elseif($group_item == 'biometricos'){
							 echo '<i class="fa fa-list"></i>' ._l(' Biometricos');
							}elseif($group_item == 'conf_ferias'){
								echo '<i class="fa fa-cog"></i>' ._l(' Configurações de Férias');
						    }elseif($group_item == 'geral'){
								echo '<i class="fa fa-cogs"></i>' ._l(' Geral');
						    }else{ 
							 echo _l($group_item);
							}
							  ?>
						</a>
					</li>
			<?php } ?>
      	</ul>
  	</div>
  	<div class="col-md-9">
    	<div class="panel_s" style="border-left: 3px solid #8B0000;">
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
<?php require('modules/gestao_assiduidade/assets/js/setting_js.php'); ?>


<script>
  if($('select[name="criteria_type"]').val() == 'criteria'){
        $('select[name="group_criteria"]').attr('required','');
        $('#select_group_criteria').removeClass('hide');
    }else{
        $('select[name="group_criteria"]').removeAttr('required');
        $('#select_group_criteria').addClass('hide');
    }
</script>
</body>
</html>
