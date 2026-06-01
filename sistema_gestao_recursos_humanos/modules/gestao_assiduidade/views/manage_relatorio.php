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
	                    <a href="<?php echo admin_url('gestao_assiduidade/relatorios?group='.$group_item); ?>" style="text-decoration: none; ">

							<?php 
								  if($group_item == 'minha_assiduidade'){
									echo '<i class="fa fa-chart-bar"></i>' . _l(' Minha Assiduidade');
								   }elseif($group_item == 'assiduidade_por_departamento'){
									   echo '<i class="fa fa-list"></i>' ._l(' Assiduidade por Departamento');
								   }elseif($group_item == 'assiduidade_diaria'){
									   echo '<i class="fa fa-clock"></i>' ._l(' Assiduidade Diária');
									  }elseif($group_item == 'criacao_turnos'){
									echo '<i class="fa fa-clock"></i>' ._l(' Criação de Turnos');
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
        </div>
    
        <div class="clearfix"></div>
        <?php echo form_close(); ?>
        <div class="btn-bottom-pusher"></div>
    </div>

</div>
<div id="new_version"></div>
<?php init_tail(); ?>
<?php require('modules/gestao_assiduidade/assets/js/manage_relatorios_js.php'); ?>

<?php if($group == 'assiduidade_por_departamento'){ ?>
    <script>
        $(window).ready(function(){
		  // refresh_tabela_assiduidade_dpt_simples ();
		});
    </script>
<?php } ?>

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
