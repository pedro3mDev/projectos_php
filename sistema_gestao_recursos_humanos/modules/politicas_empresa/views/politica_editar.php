<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">

    <div class="content">
        <?php
            $data_view = [];
            $this->load->view('/admin/menu_modulo/menu', $data_view);
        ?>
        <div class="row">
            <div class="col-md-10">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a style="color:#333; font-size:16px;"
                                href="<?php echo admin_url('politicas_empresa/'); ?>"><?php echo _l('pe_politica_empresa'); ?></a>
                        </li>
                        <li class="breadcrumb-item"><a style="color:#333; font-size:16px;"
                                href="<?php echo admin_url('politicas_empresa/listagem'); ?>"><?php echo _l('pe_politica'); ?></a>
                        </li>
                        <li class="breadcrumb-item"><a style="color:#333; font-size:16px;"
                                href="<?php echo admin_url('politicas_empresa/politica/'.$politica['id']); ?>"><?= $politica['titulo'] ?></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <a style="color:#333; font-size:16px;" href="#">
                                <?= $title ?>
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-2" style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
            </div>
        </div>

        </br>

        <div class="row">

            <div class="col-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <?= form_open_multipart(admin_url('politicas_empresa/actualizar_politica/'.$politica['id']), array('method' => 'post')) ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tipo_politica"
                                        class="control-label"><?php echo _l('tipo_politica'); ?><span
                                            class="text-danger">*</span></label>
                                    <select name="tipo_politica" id="tipo_politica" data-live-search="true"
                                        class="selectpicker" data-actions-box="true" data-width="100%"
                                        data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <?php foreach($tipos_politica as $t){ ?>
                                        <option value="<?php echo html_entity_decode($t['id']); ?>"
                                            <?php if($t['id'] == $politica['tipo_politica_id']) { echo 'selected'; } ?>>
                                            <?php echo html_entity_decode($t['tipo_politica']); ?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="categoria" class="control-label"><?php echo _l('categoria'); ?><span
                                            class="text-danger">*</span></label>
                                    <select name="categoria" id="categoria" data-live-search="true" class="selectpicker"
                                        data-actions-box="true" data-width="100%"
                                        data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <?php foreach($categorias as $t){ ?>
                                        <option value="<?php echo html_entity_decode($t['id']); ?>"
                                            <?php if($t['id'] == $politica['categoria_id']) { echo 'selected'; } ?>>
                                            <?php echo html_entity_decode($t['categoria']); ?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="conselho" class="control-label"><?php echo _l('Conselho'); ?><span
                                            class="text-danger">*</span></label>
                                    <select name="conselho" id="conselho" data-live-search="true" class="selectpicker"
                                        data-actions-box="true" data-width="100%" data-none-selected-text="Conselho">
                                        <?php foreach($conselhos as $t){ ?>
                                        <option value="<?php echo html_entity_decode($t['id']); ?>"
                                            <?php if ($t['id'] == $politica['conselho_id']) { echo 'selected'; } ?>>
                                            <?php echo html_entity_decode($t['nome']); ?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pelorio" class="control-label"><?php echo _l('Pelorio'); ?></label>
                                    <select name="pelorio" id="pelorio" class="form-control">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="direcao" class="control-label"><?php echo _l('Direção'); ?></label>
                                    <select name="direcao" id="direcao" class="form-control">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department"
                                        class="control-label"><?php echo _l('Departamento'); ?></label>
                                    <select name="departamento" id="department" class="form-control">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="seccao" class="control-label"><?php echo _l('Secção'); ?></label>
                                    <select name="seccao" id="seccao" class="form-control">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <?php echo render_input('titulo','Titulo<span class="text-danger">*<span>', $politica['titulo']); ?>
                            </div>
                            <div class="col-md-12">
                                <?php echo render_textarea('descricao', 'Descrição<span class="text-danger">*<span>', $politica['descricao']) ?>
                            </div>
                            <div class="col-md-12">
                                <?php echo render_input('arquivo','Arquivo', '', 'file'); ?>
                            </div>
                            <div class="col-md-12">
                                <?php
                                echo render_select('aprovadores[]', $staff_list, ['staffid', ['firstname', 'lastname']], 'Aprovadores<span class="text-danger">*</span>', (json_decode($politica['aprovadores'] ?? '')), ['multiple' => true], [], '', '', false);
                                ?>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
                            </div>
                        </div>
                        <?= form_close()  ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="btn-bottom-pusher"></div>
    </div>
</div>
<div id="new_version"></div>

<?php init_tail(); ?>
<?php require('modules/politicas_empresa/assets/js/company_js.php'); ?>
<script>
function conselhos_f(conselhoId, pelorioId, direcoesId, departamentId, seccaoId) {
    // Verifica se o status retornado é 'true'
    if (conselhoId) {
        requestGetJSON('hr_profile/listar_pelorios/' + conselhoId).done(function(response) {
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
                select.append('<option value="">Selecione um Pelorio</option>');

                // Adiciona as opções dos pelórios
                pelorios.forEach(function(pelorio) {
                    select.append('<option value="' + pelorio.id +
                        '">' + pelorio.nome + '</option>');
                });
                $('#pelorio').val(pelorioId);
                pelorios_f(pelorioId, direcoesId, departamentId, seccaoId)
            }
        });
    }
}

function pelorios_f(pelorioId, direcoesId, departamentId, seccaoId) {
    // Verifica se o status retornado é 'true'
    if (pelorioId) {
        requestGetJSON('hr_profile/listar_direcoes/' + pelorioId).done(function(response) {
            // Verifica se o status retornado é 'true'
            if (response.status) {
                var direcoes = response.data;
                var select = $('#direcao');
                $('#departamento').empty();
                $('#seccao').empty();

                // Limpa as opções existentes antes de adicionar novas
                select.empty();
                // Adiciona a opção padrão
                select.append('<option value="">Selecione um direção</option>');

                // Adiciona as opções dos pelórios
                direcoes.forEach(function(direcao) {
                    select.append('<option value="' + direcao.id + '">' + direcao
                        .nome + '</option>');
                });
                $('#direcao').val(direcoesId);
                direcoes_f(direcoesId, departamentId, seccaoId)
            }
        });
    }
}

function direcoes_f(direcoesId, departamentId, seccaoId) {
    // Verifica se o status retornado é 'true'
    if (direcoesId) {
        requestGetJSON('hr_profile/listar_departments/' + direcoesId).done(function(response) {
            // Verifica se o status retornado é 'true'
            if (response.status) {
                var departamentos = response.data;
                var select = $('#department');
                $('#seccao').empty();

                // Limpa as opções existentes antes de adicionar novas
                select.empty();

                // Adiciona a opção padrão
                select.append('<option value="">Selecione um departamento</option>');

                // Adiciona as opções dos pelórios
                departamentos.forEach(function(departamento) {
                    select.append('<option value="' + departamento.departmentid +
                        '">' + departamento.name + '</option>');
                });
                $('#department').val(departamentId);
                departamentos_f(departamentId, seccaoId)
            }
        });
    }
}

function departamentos_f(departmentId, seccaoId) {
    if (departmentId) {
        requestGetJSON('hr_profile/listar_seccoes/' + departmentId).done(function(response) {
            // Verifica se o status retornado é 'true'
            if (response.status) {
                var seccoes = response.data;
                var select = $('#seccao');

                // Limpa as opções existentes antes de adicionar novas
                select.empty();
                // Adiciona a opção padrão
                select.append('<option value="">Selecione uma Secção</option>');

                // Adiciona as opções dos pelórios
                seccoes.forEach(function(seccao) {
                    select.append('<option value="' + seccao.id + '">' + seccao
                        .nome + '</option>');
                });
                $('#seccao').val(seccaoId);
            }
        });
    }
}
conselhos_f(
    <?= $politica['conselho_id'] ?? '""' ?>,
    <?= $politica['pelorio_id'] ?? '""' ?>,
    <?= $politica['direcao_id'] ?? '""' ?>,
    <?= $politica['departamento_id'] ?? '""' ?>,
    <?= $politica['seccao_id'] ?? '""' ?>
)

$(document).ready(function() {
    $('#conselho').change(function() {
        const conselhoId = $(this).val(); // Obtém o valor selecionado
        // alert("teste")
        if (conselhoId) {
            requestGetJSON('hr_profile/listar_pelorios/' + conselhoId).done(function(response) {
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
                    select.append('<option value="">Selecione um Pelorio</option>');

                    // Adiciona as opções dos pelórios
                    pelorios.forEach(function(pelorio) {
                        select.append('<option value="' + pelorio.id +
                            '">' + pelorio.nome + '</option>');
                    });

                }
            });
        }
    });
    $('#pelorio').change(function() {
        const pelorioId = $(this).val(); // Obtém o valor selecionado
        if (pelorioId) {
            requestGetJSON('hr_profile/listar_direcoes/' + pelorioId).done(function(response) {
                // Verifica se o status retornado é 'true'
                if (response.status) {
                    var direcoes = response.data;
                    var select = $('#direcao');
                    $('#departamento').empty();
                    $('#seccao').empty();

                    // Limpa as opções existentes antes de adicionar novas
                    select.empty();

                    // Adiciona a opção padrão
                    select.append('<option value="">Selecione um direção</option>');

                    // Adiciona as opções dos pelórios
                    direcoes.forEach(function(direcao) {
                        select.append('<option value="' + direcao.id + '">' + direcao
                            .nome + '</option>');
                    });
                }
            });
        }
    });

    $('#direcao').change(function() {
        const direcoesId = $(this).val(); // Obtém o valor selecionado
        // alert("teste")
        if (direcoesId) {
            requestGetJSON('hr_profile/listar_departments/' + direcoesId).done(function(response) {
                // Verifica se o status retornado é 'true'
                if (response.status) {
                    var departamentos = response.data;
                    var select = $('#department');
                    $('#seccao').empty();

                    // Limpa as opções existentes antes de adicionar novas
                    select.empty();

                    // Adiciona a opção padrão
                    select.append('<option value="">Selecione um departamento</option>');

                    // Adiciona as opções dos pelórios
                    departamentos.forEach(function(departamento) {
                        select.append('<option value="' + departamento.departmentid +
                            '">' + departamento.name + '</option>');
                    });
                }
            });
        }
    });

    $('#department').change(function() {
        const departmentId = $(this).val(); // Obtém o valor selecionado
        if (departmentId) {
            requestGetJSON('hr_profile/listar_seccoes/' + departmentId).done(function(response) {
                // Verifica se o status retornado é 'true'
                if (response.status) {
                    var seccoes = response.data;
                    var select = $('#seccao');

                    // Limpa as opções existentes antes de adicionar novas
                    select.empty();
                    // Adiciona a opção padrão
                    select.append('<option value="">Selecione uma Secção</option>');

                    // Adiciona as opções dos pelórios
                    seccoes.forEach(function(seccao) {
                        select.append('<option value="' + seccao.id + '">' + seccao
                            .nome + '</option>');
                    });
                }
            });
        }
    });
});
</script>
</body>

</html>