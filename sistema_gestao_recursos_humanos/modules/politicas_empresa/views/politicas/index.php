<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<link rel="stylesheet"
    href="<?php echo base_url('assets/css/politicas_empresa/politicas.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-6">
                <a class="dashboard-link" href=""
                    style="font-size: 16px; color: #333;">
                    Politicas de Empresa / Politicas
                </a>
            </div>
            <div class="col-md-6"
                style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;"
                    class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
            </div>
        </div>
        </br>
        <div class="row">
            <div class="col-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="_buttons">
                            <?php if(is_admin() || has_permission('plp_configuracoes','','create')){ ?>
                            <a href="#" data-toggle="modal"
                                data-target="#modal_add"
                                class="btn btn-info pull-left display-block" style="background-color: #007bff; border-color: #007bff; color: white;">
                                <?php echo _l('Nova Política'); ?>
                            </a>
                            <?php } ?>
                        </div>
                        <div class="clearfix"></div>
                        <br>
                        <table class="table dt-table">
                            <thead>
                                <th width="30%"><?php echo _l('title'); ?></th>
                                <th><?php echo _l('description'); ?></th>
                                <th><?php echo _l('tipo_politica'); ?></th>
                                <th><?php echo _l('categoria'); ?></th>
                                <th><?php echo _l('Conselho'); ?></th>
                                <th><?php echo _l('Pelorio'); ?></th>
                                <th><?php echo _l('Direção'); ?></th>
                                <th><?php echo _l('Departamento'); ?></th>
                                <th><?php echo _l('Secção'); ?></th>
                                <th><?php echo _l('status'); ?></th>
                                <th><?php echo _l('options'); ?></th>
                            </thead>
                            <tbody>
                                <?php foreach($politicas as $c){ ?>
                                <tr>
                                    <td class="truncate"
                                        style="max-width: 100px;">
                                        <?php echo html_entity_decode($c['titulo']); ?>
                                    </td>
                                    <td class="truncate"
                                        style="max-width: 300px;">
                                        <?= limitarPalavra(html_entity_decode($c['descricao']), 30); ?>
                                    </td>
                                    <td><?php echo html_entity_decode($c['tipo_politica']); ?>
                                    </td>
                                    <td><?php echo html_entity_decode($c['categoria']); ?>
                                    </td>
                                    <td><?php echo html_entity_decode($c['conselho'] ?? '' ); ?>
                                    </td>
                                    <td><?php echo html_entity_decode($c['pelorio'] ?? ''); ?>
                                    </td>
                                    <td><?php echo html_entity_decode($c['direcao'] ?? ''); ?>
                                    </td>
                                    <td><?php echo html_entity_decode($c['departamento'] ?? ''); ?>
                                    </td>
                                    <td><?php echo html_entity_decode($c['seccao'] ?? ''); ?>
                                    </td>
                                    <td><?php echo html_entity_decode($c['status']); ?>
                                    </td>
                                    <td>
                                        <?php if(is_admin() || has_permission('plp_configuracoes','','view')){ ?>
                                        <a href="<?= admin_url('politicas_empresa/politica/'. $c['id']); ?>"
                                            class="btn btn-success btn-icon me-2">
                                            <i style="color:#fff;"
                                                class="fa fa-eye"></i>
                                        </a>
                                        <?php } ?>
                                        <?php if(is_admin() || has_permission('plp_configuracoes','','edit')){ ?>
                                        <a href="<?= admin_url('politicas_empresa/politica_editar/'. $c['id']); ?>"
                                            class="btn btn-info btn-icon">
                                            <i style="color:#fff;"
                                                class="fa fa-edit"></i>
                                        </a>
                                        <?php } ?>
                                        <?php if(is_admin() || has_permission('plp_configuracoes','','delete')){ ?>
                                        <a onclick="return confirm('Tens certeza que desejas eliminar esta política?');"
                                            href="<?= admin_url('politicas_empresa/delete_politica/'.$c['id']); ?>"
                                            class="btn btn-danger btn-icon _delete">
                                            <i style="color:#fff;"
                                                class="fa fa-trash"></i>
                                        </a>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="btn-bottom-pusher"></div>
    </div>
</div>
<div id="new_version"></div>
<div class="modal" id="modal_add" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <?= form_open_multipart(admin_url('politicas_empresa/add_politica'), array('method' => 'post')) ?>
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Cadastrar Nova Politica
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tipo_politica"
                                        class="control-label"><?php echo _l('tipo_politica'); ?><span
                                            class="text-danger">*</span></label>
                                    <select name="tipo_politica"
                                        id="tipo_politica"
                                        data-live-search="true"
                                        class="selectpicker"
                                        data-actions-box="true"
                                        data-width="100%"
                                        data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <?php foreach($tipos_politica as $t){ ?>
                                        <option
                                            value="<?php echo html_entity_decode($t['id']); ?>">
                                            <?php echo html_entity_decode($t['tipo_politica']); ?>
                                        </option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="categoria"
                                        class="control-label"><?php echo _l('categoria'); ?><span
                                            class="text-danger">*</span></label>
                                    <select name="categoria" id="categoria"
                                        data-live-search="true"
                                        class="selectpicker"
                                        data-actions-box="true"
                                        data-width="100%"
                                        data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <option value=""></option>
                                        <?php foreach($categorias as $t){ ?>
                                        <option
                                            value="<?php echo html_entity_decode($t['id']); ?>">
                                            <?php echo html_entity_decode($t['categoria']); ?>
                                        </option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="conselho"
                                        class="control-label"><?php echo _l('Conselho'); ?><span
                                            class="text-danger">*</span></label>
                                    <select name="conselho" id="conselho"
                                        data-live-search="true"
                                        class="selectpicker"
                                        data-actions-box="true"
                                        data-width="100%"
                                        data-none-selected-text="Conselho">
                                        <option value=""></option>
                                        <?php foreach($conselhos as $t){ ?>
                                        <option
                                            value="<?php echo html_entity_decode($t['id']); ?>">
                                            <?php echo html_entity_decode($t['nome']); ?>
                                        </option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pelorio"
                                        class="control-label"><?php echo _l('Pelorio'); ?></label>
                                    <select name="pelorio" id="pelorio"
                                        class="form-control">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="direcao"
                                        class="control-label"><?php echo _l('Direção'); ?></label>
                                    <select name="direcao" id="direcao"
                                        class="form-control">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department"
                                        class="control-label"><?php echo _l('Departamento'); ?></label>
                                    <select name="departamento" id="department"
                                        class="form-control">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="seccao"
                                        class="control-label"><?php echo _l('Secção'); ?></label>
                                    <select name="seccao" id="seccao"
                                        class="form-control">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <?php echo render_input('titulo','Titulo<span class="text-danger">*<span>'); ?>
                            </div>
                            <div class="col-md-12">
                                <?php echo render_textarea('descricao', 'Descrição<span class="text-danger">*<span>', '') ?>
                            </div>
                            <div class="col-md-12">
                                <?php echo render_input('arquivo','Arquivo', '', 'file'); ?>
                            </div>
                            <div class="col-md-12">
                                <?php
                                $selectedStaff = '';
                                echo render_select('aprovadores[]', $staff_list, ['staffid', ['firstname', 'lastname']], 'Aprovadores<span class="text-danger">*</span>', $selectedStaff, ['multiple' => true], [], '', '', false);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger"
                    data-dismiss="modal"><?php echo _l('Cancelar'); ?></button>
                <button type="submit"
                    class="btn btn-success"><?php echo _l('Salvar'); ?></button>
            </div>
        </div>
        <?= form_close()  ?>
    </div>
</div>
<?php init_tail(); ?>
<?php require('modules/politicas_empresa/assets/js/company_js.php'); ?>
<script>
    $(document).ready(function() {
        $('#conselho').change(function() {
            const conselhoId = $(this)
        .val(); // Obtém o valor selecionado
            // alert("teste")
            if (conselhoId) {
                requestGetJSON('hr_profile/listar_pelorios/' +
                    conselhoId).done(function(response) {
                    // Verifica se o status retornado é 'true'
                    if (response.status) {
                        var pelorios = response.data;
                        var select = $('#pelorio');
                        $('#direcao').empty();
                        $('#departamento').empty();
                        $('#seccao').empty();
                        // Limpa as opções existentes antes de adicionar novas
                        select.empty();
                        // Adiciona a opção padrão
                        select.append(
                            '<option value="">Selecione um Pelorio</option>'
                            );
                        // Adiciona as opções dos pelórios
                        pelorios.forEach(function(
                            pelorio) {
                            select.append(
                                '<option value="' +
                                pelorio.id +
                                '">' +
                                pelorio
                                .nome +
                                '</option>');
                        });
                    }
                });
            }
        });
        $('#pelorio').change(function() {
            const pelorioId = $(this)
        .val(); // Obtém o valor selecionado
            if (pelorioId) {
                requestGetJSON('hr_profile/listar_direcoes/' +
                    pelorioId).done(function(response) {
                    // Verifica se o status retornado é 'true'
                    if (response.status) {
                        var direcoes = response.data;
                        var select = $('#direcao');
                        $('#departamento').empty();
                        $('#seccao').empty();
                        // Limpa as opções existentes antes de adicionar novas
                        select.empty();
                        // Adiciona a opção padrão
                        select.append(
                            '<option value="">Selecione um direção</option>'
                            );
                        // Adiciona as opções dos pelórios
                        direcoes.forEach(function(
                            direcao) {
                            select.append(
                                '<option value="' +
                                direcao.id +
                                '">' +
                                direcao
                                .nome +
                                '</option>');
                        });
                    }
                });
            }
        });
        $('#direcao').change(function() {
            const direcoesId = $(this)
        .val(); // Obtém o valor selecionado
            // alert("teste")
            if (direcoesId) {
                requestGetJSON(
                    'hr_profile/listar_departments/' +
                    direcoesId).done(function(response) {
                    // Verifica se o status retornado é 'true'
                    if (response.status) {
                        var departamentos = response
                            .data;
                        var select = $('#department');
                        $('#seccao').empty();
                        // Limpa as opções existentes antes de adicionar novas
                        select.empty();
                        // Adiciona a opção padrão
                        select.append(
                            '<option value="">Selecione um departamento</option>'
                            );
                        // Adiciona as opções dos pelórios
                        departamentos.forEach(function(
                            departamento) {
                            select.append(
                                '<option value="' +
                                departamento
                                .departmentid +
                                '">' +
                                departamento
                                .name +
                                '</option>');
                        });
                    }
                });
            }
        });
        $('#department').change(function() {
            const departmentId = $(this)
        .val(); // Obtém o valor selecionado
            if (departmentId) {
                requestGetJSON('hr_profile/listar_seccoes/' +
                    departmentId).done(function(response) {
                    // Verifica se o status retornado é 'true'
                    if (response.status) {
                        var seccoes = response.data;
                        var select = $('#seccao');
                        // Limpa as opções existentes antes de adicionar novas
                        select.empty();
                        // Adiciona a opção padrão
                        select.append(
                            '<option value="">Selecione uma Secção</option>'
                            );
                        // Adiciona as opções dos pelórios
                        seccoes.forEach(function(
                        seccao) {
                            select.append(
                                '<option value="' +
                                seccao.id +
                                '">' +
                                seccao
                                .nome +
                                '</option>');
                        });
                    }
                });
            }
        });
    });
</script>
</body>
</html>