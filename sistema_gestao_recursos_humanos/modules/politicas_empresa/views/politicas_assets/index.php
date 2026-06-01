<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <?php
            $data_view = [];
            $this->load->view('/admin/menu_modulo/menu', $data_view);
        ?>
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

                    
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="h4" style="font-size:24px; font-weight: 300; margin-bottom: 30px;">Categorias</div>
                        <hr style="border-top: 1,5px solid #ccc; margin-bottom: 30px;">
                        <table class="table table-hover table-bordered table-responsive">
                        
                            <tbody>
                                <?php
                                    foreach($categorias as $categoria) {
                                ?>
                                <tr>
                                    <td><a
                                            href="<?php echo admin_url('politicas_empresa/politicas_assets/categoria/'.$categoria['id']); ?>"><?php echo $categoria['categoria']; ?></a>
                                    </td>
                                    <td class="tw-flex tw-justify-between">
                                        <a
                                            href="<?php echo admin_url('politicas_empresa/politicas_assets/categoria/'.$categoria['id']); ?>"><i
                                                class="fas fa-edit"></i></a>
                                        <a class="text-danger"
                                            onclick="return confirm('Tens certeza que desejas eliminar esta categoria?'); "
                                            href="<?php echo admin_url('politicas_empresa/politicas_assets/categoria_eliminar/'.$categoria['id']); ?>"><i
                                                class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php } ?>
                                
                            </tbody>
                        
    <!-- Botão Nova Conduta -->
    <div class="col-md-3">
        <div class="tw-flex tw-justify-start tw-items-center tw-gap-x-6 tw-mb-4">
            <a href="<?php echo admin_url('politicas_empresa/politicas_assets/nova_categoria'); ?>" class="btn" style="background-color: #007bff; border-color: #007bff; color: white;">
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
<h1 style="font-size: 15px; font-weight: 300;">
                            Sem dados, por faor, seleciona um departamento que tenha dados!
</h1>


                        </table>
                    </div>
                </div>

                <div class="panel_s">
                    <div class="panel-body">
                        <div class="h4" style="font-size:24px; font-weight: 300; margin-bottom: 30px;">Fornecedores</div>
                        <hr style="border-top: 1,5px solid #ccc; margin-bottom: 30px;">
                        <table class="table table-hover table-bordered table-responsive">
                        
                            <thead class="thead-custom">
                                <th>Nome</th>
                                <th>NIF</th>
                                <th>Ações</th>
                            </thead>
                            <tbody>
                            <div class="row mb-3">
    <!-- Botão Nova Conduta -->
    <div class="col-md-3">
        <div class="tw-flex tw-justify-start tw-items-center tw-gap-x-6 tw-mb-4">
            <a href="<?php echo admin_url('politicas_empresa/politicas_assets/novo_fornecedor'); ?>" class="btn" style="background-color: #007bff; border-color: #007bff; color: white;">
                <i class="fa-regular "></i> Novo Fornecedor
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
                                    foreach($fornecedores as $fornecedor) {
                                ?>
                                <tr>
                                    <td><a
                                            href="<?php echo admin_url('politicas_empresa/politicas_assets/fornecedor/'.$fornecedor['id']); ?>"><?php echo $fornecedor['nome']; ?></a>
                                    </td>
                                    <td><?= $fornecedor['nif'] ?></td>
                                    <td class="tw-flex tw-justify-between">
                                        <a
                                            href="<?php echo admin_url('politicas_empresa/politicas_assets/fornecedor_editar/'.$fornecedor['id']); ?>"><i
                                                class="fas fa-edit"></i></a>
                                        <a class="text-danger"
                                            onclick="return confirm('Tens certeza que desejas eliminar esta fornecedor?'); "
                                            href="<?php echo admin_url('politicas_empresa/politicas_assets/fornecedor_eliminar/'.$fornecedor['id']); ?>"><i
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
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="h4" style="font-size:24px; font-weight: 300; margin-bottom: 30px;">Localizações de Assets</div>
                        <hr style="border-top: 1,5px solid #ccc; margin-bottom: 30px;">
                        <table class="table table-hover table-bordered table-responsive">
                        
                            <thead class="thead-custom">
                                <th>Localização</th>
                                <th>Descrição</th>
                                <th>Ações</th>
                            </thead>
                            <tbody>

                            <div class="row mb-3">
    <!-- Botão Nova Conduta -->
    <div class="col-md-3">
        <div class="tw-flex tw-justify-start tw-items-center tw-gap-x-6 tw-mb-4">
            <a href="<?php echo admin_url('politicas_empresa/politicas_assets/nova_localizacao'); ?>" class="btn" style="background-color: #007bff; border-color: #007bff; color: white;">
                <i class="fa-regular "></i> Nova Localização de Assets
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
                                    foreach($localizacoes as $localizacao) {
                                ?>
                                <tr>
                                    <td><a
                                            href="<?php echo admin_url('politicas_empresa/politicas_assets/localizacao/'.$localizacao['id']); ?>"><?php echo $localizacao['localizacao']; ?></a>
                                    </td>
                                    <td><?= $localizacao['descricao'] ?></td>
                                    <td class="tw-flex tw-justify-between">
                                        <a
                                            href="<?php echo admin_url('politicas_empresa/politicas_assets/localizacao_editar/'.$localizacao['id']); ?>"><i
                                                class="fas fa-edit"></i></a>
                                        <a class="text-danger"
                                            onclick="return confirm('Tens certeza que desejas eliminar esta localizacao?'); "
                                            href="<?php echo admin_url('politicas_empresa/politicas_assets/localizacao_eliminar/'.$localizacao['id']); ?>"><i
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
                        <div class="h4" style="font-size:24px; font-weight: 300; margin-bottom: 30px;">Assets</div>
                        <hr style="border-top: 1,5px solid #ccc; margin-bottom: 30px;">
                        <table class="table table-hover table-bordered table-responsive">
                        
                            <thead class="thead-custom">
                                <th>Nome</th>
                                <th>Categoria</th>
                                <th>Data Aquisição</th>
                            </thead>
                            <tbody>
                            <div class="row mb-3">
    <!-- Botão Nova Conduta -->
    <div class="col-md-3">
        <div class="tw-flex tw-justify-start tw-items-center tw-gap-x-6 tw-mb-4">
            <a href="<?php echo admin_url('politicas_empresa/politicas_assets/novo_assets'); ?>" class="btn" style="background-color: #007bff; border-color: #007bff; color: white;">
                <i class="fa-regular "></i> Adicionar Assets
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
                                    foreach($assets as $asset) {
                                ?>
                                <tr>
                                    <td><a
                                            href="<?php echo admin_url('politicas_empresa/politicas_assets/assets/'.$asset['id']); ?>"><?php echo $asset['nome']; ?></a>
                                    </td>
                                    <td><?php echo $asset['categoria']; ?></td>
                                    <td><?php echo $asset['data_aquisicao']; ?></td>
                                    <td>
                                        <a
                                            href="<?php echo admin_url('politicas_empresa/politicas_assets/assets_editar/'.$asset['id']); ?>"><i
                                                class="fas fa-edit"></i></a>
                                        <a class="text-danger"
                                            onclick="return confirm('Tens certeza que desejas eliminar esta Assets?'); "
                                            href="<?php echo admin_url('politicas_empresa/politicas_assets/assets_eliminar/'.$asset['id']); ?>"><i
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
        <div class="btn-bottom-pusher"></div>
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
        border-bottom: 1px solid #ccc; /* Linha separadora */
    }

</style>