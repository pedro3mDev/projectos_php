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
					Gestão de Requisições / Configurações
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
                <ul class="nav navbar-pills navbar-pills-flat nav-tabs nav-stacked">
                    <?php
                    $i = 0;
                    foreach($tab as $group_item){ 
                    ?>
                    <li<?php if($group_item == $group){echo " class='active'"; } ?>>
                        <a href="<?php echo admin_url('approvify/configuracoes?group='.$group_item); ?>" data-group="<?php echo new_html_entity_decode($group_item); ?>">

                            <?php
                            if($group_item == 'categorias'){
                            echo _l('req_categorias');
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
			<div class="panel_s">
				<div class="panel-body">
					<?php $this->load->view($tabs['view']); ?>
				</div>
			</div>
		</div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<?php init_tail();
?>
<script>
    "use strict";
    $(function() {
        initDataTable('.table-manage-types', window.location.href, [0], [0], [], [0, 'desc']);
    });
</script>