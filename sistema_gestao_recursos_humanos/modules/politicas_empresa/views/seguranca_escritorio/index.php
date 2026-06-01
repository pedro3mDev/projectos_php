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
                        <li class="breadcrumb-item"><a style="color:#333; font-size:16px;"
                                href="<?php echo admin_url('politicas_empresa/'); ?>"><?php echo _l('pe_politica_empresa'); ?></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <a style="color:#333; font-size:16px;" href="">
                                <?php echo _l('pe_seguranca_escritorio'); ?>
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        </br>

                  
<div class="row">

<div class="col-md-3">
    <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column" style="border-bottom: 1px solid #336;">
        <a class="text-warning text-center mbot15">
            <p class="text-uppercase mtop5 minheight35" style="font-size: 14px; font-weight: bold; color:#DAA520;;">
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
    <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column" style="border-bottom: 1px solid #336;">
        <a class="text-warning text-center mbot15">
            <p class="text-uppercase mtop5 minheight35" style="font-size: 14px; font-weight: bold; color:#DAA520;;">
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
    <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column" style="border-bottom: 1px solid #336;">
        <a class="text-warning text-center mbot15">
            <p class="text-uppercase mtop5 minheight35" style="font-size: 14px; font-weight: bold; color:#DAA520;;">
            Total de conformidade
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
    <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column" style="border-bottom: 1px solid #336;">
        <a class="text-warning text-center mbot15">
            <p class="text-uppercase mtop5 minheight35" style="font-size: 14px; font-weight: bold; color:#DAA520;;">
            Total de Ações Pendentes
            </p>
            <div class="d-flex align-items-center justify-content-center">
                <p style="font-size:16px; color:#DAA520;">  
                    <?= $pedido["total_pendente"] ?? 0; ?>
                </p>                             
            </div>
        </a>
    </div>
</div>

</br>

                    <div class="tw-flex tw-justify-start tw-items-center tw-gap-x-6">
                        

                        
                       
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="h4" style="font-size:24px; font-weight: 300; margin-bottom: 30px;" >Categorias</div>
                        <hr style="border-top: 1,5px solid #ccc; margin-bottom: 30px;">
                        <table class="table table-hover table-bordered table-responsive">
                        
                        
                            <!-- <thead>
                                <th>Categoria</th>
                                <th></th>
                            </thead> -->
                            <tbody>
                                <div class="row mb-3">
    <!-- Botão Nova Conduta -->
    <div class="col-md-3">
        <div class="tw-flex tw-justify-start tw-items-center tw-gap-x-6 tw-mb-4">
            <a href="<?php echo admin_url('politicas_empresa/seguranca_escritorio/nova_categoria'); ?>" class="btn" style="background-color: #007bff; border-color: #007bff; color: white;">
                <i class="fa-regular "></i> Nova Categoria 
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


                                
                                <?php
                                    foreach($categorias as $categoria) {
                                ?>
                                <tr>
                                    <td><a
                                            href="<?php echo admin_url('politicas_empresa/seguranca_escritorio/categoria/'.$categoria['id']); ?>"><?php echo $categoria['categoria']; ?></a>
                                    </td>
                                    <td class="tw-flex tw-justify-between">
                                        <a
                                            href="<?php echo admin_url('politicas_empresa/seguranca_escritorio/categoria/'.$categoria['id']); ?>"><i
                                                class="fas fa-edit"></i></a>
                                        <a class="text-danger"
                                            onclick="return confirm('Tens certeza que desejas eliminar esta categoria?'); "
                                            href="<?php echo admin_url('politicas_empresa/seguranca_escritorio/categoria_eliminar/'.$categoria['id']); ?>"><i
                                                class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                            <h1 style="font-size: 15px; font-weight: 300;">
                            Sem dados, por faor, seleciona um departamento que tenha dados!
</h1>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="h4" style="font-size:24px; font-weight: 300; margin-bottom: 30px;">Politicas</div>
                        <hr style="border-top: 1,5px solid #ccc; margin-bottom: 30px;">
                        <table class="table table-hover table-bordered table-responsive">
                        
                            <thead class="thead-custom">
                                <th>#</th>
                                <th>Titulo</th>
                                <th>Descrição</th>
                                <th>Arquivo</th>
                                
                            </thead>
                            <tbody>
                            <div class="row mb-3">
    <!-- Botão Nova Conduta -->
    <div class="col-md-3">
        <div class="tw-flex tw-justify-start tw-items-center tw-gap-x-6 tw-mb-4">
            <a href="<?php echo admin_url('politicas_empresa/seguranca_escritorio/nova_politica'); ?>" class="btn" style="background-color: #007bff; border-color: #007bff; color: white;">
                <i class="fa-regular "></i> Nova Política
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

<div class="row mb-3">
    <!-- Barra de Busca -->
    <div class="col-md-12 text-right">
        <div class="input-group" style="max-width: 250px; margin-left: auto; display: flex; justify-content: flex-end;">
            <button class="btn btn-outline-secondary" type="button" style="border-right: none;">
                <i class="fas fa-search"></i>
            </button>
            <input type="text" class="form-control" placeholder="Procurar..." style="border-left: none;">
        </div>
    </div>
</div>
                          
                                
                                <?php
                                    foreach($politicas as $politica) {
                                ?>
                                <tr>
                                    <td><a
                                            href="<?php echo admin_url('politicas_empresa/seguranca_escritorio/politica/'.$politica['id']); ?>"><?php echo $politica['titulo']; ?></a>
                                    </td>
                                    <td><?php echo limitarPalavra($politica['descricao'], 10); ?></td>
                                    <td><?php echo !empty($politica['arquivo']) ? 'Existe anexo':'<span class="text-danger">Sem anexo<span/>'; ?>
                                    </td>
                                    <td>
                                        <a
                                            href="<?php echo admin_url('politicas_empresa/seguranca_escritorio/politica_editar/'.$politica['id']); ?>"><i
                                                class="fas fa-edit"></i></a>
                                        <a class="text-danger"
                                            onclick="return confirm('Tens certeza que desejas eliminar esta Politica?'); "
                                            href="<?php echo admin_url('politicas_empresa/seguranca_escritorio/politica_eliminar/'.$politica['id']); ?>"><i
                                                class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        
                            
                        </table>
                        <h1 style="font-size: 15px; font-weight: 300;">
    Nenhum registro encontrado
</h1>
                    </div>
                </div>

                <div class="panel_s">
                    <div class="panel-body">
                        <div class="h4" style="font-size:24px; font-weight: 300; margin-bottom: 30px;">Conformidades</div>
                        <hr style="border-top: 1,5px solid #ccc; margin-bottom: 30px;">
                        <table class="table table-hover table-bordered table-responsive">
                        
                            <thead class="thead-custom">
                                <th>Colaborador</th>
                                <th>Politica</th>
                                <th>Data Assinatura</th>
                            </thead>
                            <tbody>
                            <div class="row mb-3">
    <!-- Botão Nova Conduta -->
    <div class="col-md-3">
        <div class="tw-flex tw-justify-start tw-items-center tw-gap-x-6 tw-mb-4">
            <a href="<?php echo admin_url('politicas_empresa/seguranca_escritorio/nova_termo_conformidade'); ?>" class="btn" style="background-color: #007bff; border-color: #007bff; color: white;">
                <i class="fa-regular "></i> Novo Registro de Conformidade
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

<div class="row mb-3">
    <!-- Barra de Busca -->
    <div class="col-md-12 text-right">
        <div class="input-group" style="max-width: 250px; margin-left: auto; display: flex; justify-content: flex-end;">
            <button class="btn btn-outline-secondary" type="button" style="border-right: none;">
                <i class="fas fa-search"></i>
            </button>
            <input type="text" class="form-control" placeholder="Procurar..." style="border-left: none;">
        </div>
    </div>
</div>
                                <?php
                                    foreach($conformidades as $comformidade) {
                                ?>
                                <tr>
                                    <td><?php echo $comformidade['firstname'].' '.$comformidade['lastname']; ?></td>
                                    <td><?php echo limitarPalavra($comformidade['titulo'], 10); ?></td>
                                    <td><?php echo $comformidade['data_assinatura']; ?></td>
                                    <td><?php echo !empty($comformidade['arquivo']) ? 'Existe anexo':'<span class="text-danger">Sem anexo<span/>'; ?>
                                    </td>
                                    <td>
                                        <a
                                            href="<?php echo admin_url('politicas_empresa/seguranca_escritorio/conformidade_editar/'.$comformidade['id']); ?>"><i
                                                class="fas fa-edit"></i></a>
                                        <a class="text-danger"
                                            onclick="return confirm('Tens certeza que desejas eliminar esta Politica?'); "
                                            href="<?php echo admin_url('politicas_empresa/seguranca_escritorio/conformidade_eliminar/'.$comformidade['id']); ?>"><i
                                                class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        
                        </table>
                        <h1 style="font-size: 15px; font-weight: 300;">
    Nenhum registro encontrado
</h1>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div id="new_version"></div>
<?php init_tail(); ?>
<?php require('modules/politicas_empresa/assets/js/company_js.php'); ?>
<style>
    /* Estilo do cabeçalho da tabela */
    .thead-custom {
        background-color: #f4f4f4; /* Fundo cinza claro */
        color: rgba(51, 51, 51, 0.8); /* Texto com transparência */
        font-weight: bold;
        text-align: left;
        border-bottom: 0px solid #ccc; /* Linha separadora */
    }

</style>