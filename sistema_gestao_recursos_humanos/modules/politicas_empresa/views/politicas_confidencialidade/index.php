<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <?php
        $data_view = [];
        $this->load->view('/admin/menu_modulo/menu', $data_view);
        ?>
        <div class="row">
            <div class="col-md-12">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a style="color:#333; font-size:16px;" href="<?php echo admin_url('politicas_empresa/'); ?>">
                                <?php echo _l('pe_politica_empresa'); ?>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <a style="color:#333; font-size:16px;" href="">
                                <?php echo _l('Políticas de Confidencialidade'); ?>
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-md-3">
                <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column" 
                     style="border-bottom: 1px solid #336;">
                    <a class="text-warning text-center mbot15">
                        <p class="text-uppercase mtop5 minheight35" style="font-size: 14px; font-weight: bold; color:#DAA520;">
                            Total de Políticas
                        </p>
                        <div class="d-flex align-items-center justify-content-center">
                            <p style="font-size:16px; color:#DAA520;">
                                <?= $pedido["total"] ?? 0; ?>
                            </p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column" 
                     style="border-bottom: 1px solid #336;">
                    <a class="text-warning text-center mbot15">
                        <p class="text-uppercase mtop5 minheight35" style="font-size: 14px; font-weight: bold; color:#DAA520;">
                            Total de Categorias
                        </p>
                        <div class="d-flex align-items-center justify-content-center">
                            <p style="font-size:16px; color:#DAA520;">
                                <?= $pedido["total_pendente"] ?? 0; ?>
                            </p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column" 
                     style="border-bottom: 1px solid #336;">
                    <a class="text-warning text-center mbot15">
                        <p class="text-uppercase mtop5 minheight35" style="font-size: 14px; font-weight: bold; color:#DAA520;">
                            Total de Conformidades
                        </p>
                        <div class="d-flex align-items-center justify-content-center">
                            <p style="font-size:16px; color:#DAA520;">
                                <?= $pedido["total_conformidades"] ?? 0; ?>
                            </p>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-3">
                <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column" 
                     style="border-bottom: 1px solid #336;">
                    <a class="text-warning text-center mbot15">
                        <p class="text-uppercase mtop5 minheight35" style="font-size: 14px; font-weight: bold; color:#DAA520;">
                            Total de Ações Pendentes
                        </p>
                        <div class="d-flex align-items-center justify-content-center">
                            <p style="font-size:16px; color:#DAA520;">
                                <?= $pedido["total_pendentes"] ?? 0; ?>
                            </p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-12">
                <div class="panel_s tw-mx-4"> <!-- Adicionado tw-mx-4 para afastar a tabela -->
                    <div class="panel-body">
                        <div class="h4" style="font-size:24px; font-weight: 300; margin-bottom: 30px;">Políticas de Confidencialidade</div>
                        <hr style="border-top: 1,5px solid #ccc; margin-bottom: 30px;">
                        <table class="table table-hover table-bordered table-responsive tw-mt-4 tw-shadow-md tw-rounded-lg">
                            <div class="tw-flex tw-justify-start tw-items-center tw-gap-x-6 tw-mb-4">
                                
                                
                                
                                
                            </div>
                            <thead>
                                
                            </thead>
                            <tbody>
                            
    <!-- Botão Nova Conduta -->
    <div class="col-md-3">
        <div class="tw-flex tw-justify-start tw-items-center tw-gap-x-6 tw-mb-4">
            <a href="" class="btn" style="background-color: #007bff; border-color: #007bff; color: white;">
                <i class="fa-regular "></i> Definir Política
            </a>
        </div>
    </div>

    <!-- Filtro por Departamento -->
    <div class="col-md-3">
        <select name="department_filter[]" id="department_filter" class="selectpicker form-control" multiple data-live-search="true" data-none-selected-text="Filtrar por Departamento">
            <option value="1">Departamento 1</option>
            <option value="2">Departamento 2</option>
        </select>
    </div>

    <!-- Filtro por Posição -->
    <div class="col-md-3">
        <select name="position_filter[]" id="position_filter" class="selectpicker form-control" multiple data-live-search="true" data-none-selected-text="Filtrar por Posição">
            <option value="1">Posição 1</option>
            <option value="2">Posição 2</option>
        </select>
    </div>

    <!-- Filtro por Status -->
    <div class="col-md-3" style="margin-bottom: 50px;">
        <select name="status_filter[]" id="status_filter" class="selectpicker form-control" multiple data-live-search="true" data-none-selected-text="Filtrar por Status">
            <option value="1">Planejamento</option>
            <option value="2">Atrasado</option>
            <option value="3">Em Progresso</option>
            <option value="4">Finalizado</option>
            <option value="5">Cancelado</option>
        </select>
    </div>
</div>


                                
                        </table>
                        <h1 style="font-size: 15px; font-weight: 300;">
                            Sem dados, por faor, seleciona um departamento que tenha dados!
</h1>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="tw-mb-6">
                    <div class="tw-grid tw-grid-cols-2 md:tw-grid-cols-3 lg:tw-grid-cols-6 tw-gap-2 tw-mb-6">
                        <div
                            class="text-sm tw-border-neutral-300/80 tw-shadow-sm tw-text-sm tw-border tw-border-solid tw-rounded-lg tw-px-4 tw-py-3 tw-flex-1 tw-flex tw-items-center tw-font-medium tw-bg-white">
                            <span class="tw-font-semibold tw-mr-1 rtl:tw-ml-1">
                                <?php echo number_format(90, 0,'','.') ?> </span>
                            <span class="text-dark tw-truncate sm:tw-text-clip">Total de Condutas</span>
                        </div>
                    </div>

                    <div class="tw-flex tw-justify-start tw-items-center tw-gap-x-6">
                        <div class="tw-flex tw-justify-between tw-items-center tw-gap-x-1">
                            <a href="<?php echo admin_url('politicas_empresa/politicas_confidencialidade/novo_termo'); ?>"
                                class="btn btn-primary">
                                <i class="fa-regular fa-plus tw-mr-1"></i> Novo Termo de Confidencialidade </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="h4">Conformidades</div>
                        <table class="table table-hover table-bordered table-responsive">
                            <thead>
                                <th>Colaborador</th>
                                <th>Politica</th>
                                <th>Data Assinatura</th>
                                <th></th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($confidencialidades as $confidencialidade) {
                                ?>
                                <tr>
                                    <td><?php echo $confidencialidade['firstname'].' '.$confidencialidade['lastname']; ?>
                                    </td>
                                    <td><?php echo limitarPalavra($confidencialidade['titulo'], 10); ?></td>
                                    <td><?php echo $confidencialidade['data_assinatura']; ?></td>
                                    <td><?php echo !empty($confidencialidade['arquivo']) ? 'Existe anexo':'<span class="text-danger">Sem anexo<span/>'; ?>
                                    </td>
                                    <td>
                                        <a
                                            href="<?php echo admin_url('politicas_empresa/politicas_confidencialidade/confidencialidade_editar/'.$confidencialidade['id']); ?>"><i
                                                class="fas fa-edit"></i></a>
                                        <a class="text-danger"
                                            onclick="return confirm('Tens certeza que desejas eliminar?'); "
                                            href="<?php echo admin_url('politicas_empresa/politicas_confidencialidade/confidencialidade_eliminar/'.$confidencialidade['id']); ?>"><i
                                                class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <h4>Acessos</h4>
                <table class="table border table-striped ">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Politica</th>
                            <th>Acao</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if ($acessos == NULL) {
                                echo "<tr><th colspan='3'> Sem resultado. </th></tr>";
                            }
                            else {
                            $i = 0;
                            foreach ($acessos as $acesso) {
                                $i++;
                        ?>
                        <tr class="project-overview">
                            <th> <?php echo $i; ?> </th>
                            <td><?php echo  $acesso['firstname'] .' '. $acesso['lastname'] ; ?></td>
                            <td><?php echo  $acesso['titulo']; ?></td>
                            <td><?php echo  $acesso['acao']; ?></td>
                            <td><?php echo  $acesso['created_at']; ?></td>
                        </tr>
                        <?php } } ?>
                    </tbody>
                </table>
            </div>
            <div class="clearfix"></div>

        </div>
        <div class="btn-bottom-pusher"></div>
    </div>
</div>
<div id="new_version"></div>
<?php init_tail(); ?>
<?php require('modules/politicas_empresa/assets/js/company_js.php'); ?>
