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
                    Gestão de Assiduidade / Estatisticas
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
            <div class="col-md-12"> 
                <ul class="nav navbar-pills navbar-pills-flat nav-tabs">
                    <?php 
                        $i = 0;
                        foreach($tab as $group_item){
                    ?>
				
                    <li<?php if($group_item == $group){echo " class='active'"; } ?>>
	                    <a href="<?php echo admin_url('gestao_assiduidade/gestao_de_ferias_geral?group='.$group_item); ?>" style="text-decoration: none; ">

							<?php 
								  if($group_item == 'solicitar_ferias'){
									echo '<i class="fa fa-plus"></i>' . _l(' Solicitar Férias');
								   }elseif($group_item == 'funcionarios_em_ferias'){
									   echo '<i class="fa fa-users"></i>' ._l(' Funcionários em Férias');
									  }elseif($group_item == 'criacao_turnos'){
									echo '<i class="fa fa-plus"></i>' ._l(' Solicitar Férias');
								   }else{ 
									echo _l($group_item);
								   }
							?>

						</button>

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
						background-color: #800000;
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
        </div>
    
        <div class="clearfix"></div>
        <?php echo form_close(); ?>
        <div class="btn-bottom-pusher"></div>
    </div>

</div>
<div id="new_version"></div>
<?php init_tail(); ?>
<?php require('modules/gestao_assiduidade/assets/js/gestao_ferias_js.php'); ?>>

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
