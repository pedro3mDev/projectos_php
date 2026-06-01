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
                                <?php echo _l('pe_codigo_conduta_entica'); ?>
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

                <div class="panel_s tw-mx-4">
                <div class="panel-body">
                <div class="h4" style="font-size:24px; font-weight: 300; margin-bottom: 20px;">Código de Conduta e Ética</div>
                <hr style="border-top: 1,5px solid #ccc; margin-bottom: 30px;">
                <table class="table table-hover table-bordered table-responsive tw-mt-4 tw-shadow-md tw-rounded-lg">

                            
                            <thead class="thead-custom">
                            <tr>
            <th>Nome</th>
            <th>NIF</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        
    <div class="row mb-3">
    <!-- Botão Nova Conduta -->
    <div class="col-md-3">
        <div class="tw-flex tw-justify-start tw-items-center tw-gap-x-6 tw-mb-4">
            <a href="<?php echo admin_url('politicas_empresa/conduta_etica/nova_conduta'); ?>" class="btn" style="background-color: #007bff; border-color: #007bff; color: white;">
                <i class="fa-regular "></i> Nova Conduta
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

<?php foreach ($condutas as $conduta): ?>
    <tr>
        <td>
            <a href="<?php echo admin_url('politicas_empresa/conduta_etica/conduta/'); ?>">
                <?php echo $conduta['nome']; ?>
            </a>
        </td>
        <td><?= limitarPalavra($conduta['descricao'], 10) ?></td>
        <td class="tw-flex tw-justify-between">
            <a href="<?php echo admin_url('politicas_empresa/conduta_etica/conduta_editar/' . $conduta['id']); ?>">
                <i class="fas fa-edit"></i>
            </a>
            <a class="text-danger" 
               onclick="return confirm('Tens certeza que desejas eliminar esta Conduta?');" 
               href="<?php echo admin_url('politicas_empresa/conduta_etica/conduta_eliminar/' . $conduta['id']); ?>">
                <i class="fas fa-trash"></i>
            </a>
        </td>
    </tr>
<?php endforeach; ?>

        
    </tbody>
    
</table>
<h1 style="font-size: 15px; font-weight: 300;">
    Nenhum registro encontrado
</h1>

                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="h4">Treinamentos</div>
                        <table class="table table-hover table-bordered table-responsive">
                            <thead>
                                <th>Conduta</th>
                                <th>Data</th>
                                <th>Estado</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($treinamentos as $treinamentos) {
                                ?>
                                <tr>
                                    <td><a
                                            href="<?php echo admin_url('politicas_empresa/conduta_etica/treinamento/'.$treinamentos['id']); ?>"><?php echo $treinamentos['nome']; ?></a>
                                    </td>
                                    <td><?= $treinamentos['data_treinamento'] ?></td>
                                    <td><?= $treinamentos['status'] ?></td>
                                    <td class="tw-flex tw-justify-between">
                                        <a
                                            href="<?php echo admin_url('politicas_empresa/conduta_etica/treinamentos_editar/'.$treinamentos['id']); ?>"><i
                                                class="fas fa-edit"></i></a>
                                        <a class="text-danger"
                                            onclick="return confirm('Tens certeza que desejas eliminar este Treinamento?'); "
                                            href="<?php echo admin_url('politicas_empresa/conduta_etica/treinamentos_eliminar/'.$treinamentos['id']); ?>"><i
                                                class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="h4">Adessões em Condutas</div>
                        <table class="table table-hover table-bordered table-responsive">
                            <thead>
                                <th>Conduta</th>
                                <th>Staff</th>
                                <th>Metodo Adesão</th>
                                <th>Arquivo</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($adessoes as $adessao) {
                                ?>
                                <tr>
                                    <td><a
                                            href="<?php echo admin_url('politicas_empresa/conduta_etica/treinamento/'); ?>"><?php echo $adessao['nome']; ?></a>
                                    </td>
                                    <td><?= $adessao['lastname'] .' '.$adessao['firstname'] ?></td>
                                    <td><?= $adessao['metodo_aceite'] ?></td>
                                    <td><?= empty($adessao['arquivo']) ? 'Sem Anexo':'Com Anexo' ?></td>
                                    <td class="tw-flex tw-justify-between">
                                        <a
                                            href="<?php echo admin_url('politicas_empresa/conduta_etica/adesao_editar/'.$adessao['id']); ?>"><i
                                                class="fas fa-edit"></i></a>
                                        <a class="text-danger"
                                            onclick="return confirm('Tens certeza que desejas eliminar esta Adesão?'); "
                                            href="<?php echo admin_url('politicas_empresa/conduta_etica/adesao_eliminar/'.$adessao['id']); ?>"><i
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
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="h4">Violações</div>
                        <table class="table table-hover table-bordered table-responsive">
                            <thead>
                                <th>Conduta</th>
                                <th>Staff</th>
                                <th>Ação Tomada</th>
                                <th>Estado</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($violacoes as $violacao) {
                                ?>
                                <tr>
                                    <td><a
                                            href="<?php echo admin_url('politicas_empresa/conduta_etica/treinamento/'); ?>"><?php echo $violacao['nome']; ?></a>
                                    </td>
                                    <td><?= $violacao['lastname'] .' '.$violacao['firstname'] ?></td>
                                    <td><?= $violacao['acao_tomada'] ?></td>
                                    <td><?= $violacao['status'] ?></td>
                                    <td class="tw-flex tw-justify-between">
                                        <a
                                            href="<?php echo admin_url('politicas_empresa/conduta_etica/violacao_editar/'.$violacao['id']); ?>"><i
                                                class="fas fa-edit"></i></a>
                                        <a class="text-danger"
                                            onclick="return confirm('Tens certeza que desejas eliminar esta Violação?'); "
                                            href="<?php echo admin_url('politicas_empresa/conduta_etica/violacao_eliminar/'.$violacao['id']); ?>"><i
                                                class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
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
        color: #333; /* Texto escuro */
        font-weight: bold;
        text-align: left;
        border-bottom: 1px solid #ccc; /* Linha separadora */
    }

</style>
