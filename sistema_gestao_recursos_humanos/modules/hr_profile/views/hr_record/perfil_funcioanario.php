<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
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
						<a  style="color:#333; font-size:16px;" href="">
							Funcionários
						</a>
					</li>
                    <li class="breadcrumb-item active" aria-current="page">
						<a  style="color:#333; font-size:16px;" href="">
                        Perfil de Funcionário
						</a>
					</li>
				</ol>
				</nav>
			</div>
		</div>