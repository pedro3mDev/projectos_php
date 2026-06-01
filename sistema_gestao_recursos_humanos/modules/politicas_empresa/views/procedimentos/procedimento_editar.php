<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">

    <div class="content">
    </br></br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-6">
                <a class="dashboard-link" href=""
                    style="font-size: 16px; color: #333;">
                    Politicas de Empresa / Procedimentos / Editar
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
                        <?= form_open_multipart(admin_url('politicas_empresa/procedimentos/actualizar_procedimento/'.$procedimento['id']), array('method' => 'post')) ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="staff" class="control-label"><?php echo _l('staff'); ?><span
                                            class="text-danger">*</span></label>
                                    <select name="staff" id="staff" data-live-search="true" class="selectpicker"
                                        data-actions-box="true" data-width="100%"
                                        data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <?php foreach($staffs as $t){ ?>
                                        <option value="<?php echo html_entity_decode($t['staffid']); ?>"
                                            <?php if($t['staffid'] == $procedimento['staff_id']) { echo 'selected'; } ?>>
                                            <?php echo html_entity_decode($t['firstname'] .' '.$t['lastname']); ?>
                                        </option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="politica" class="control-label"><?php echo _l('pe_politica'); ?><span
                                            class="text-danger">*</span></label>
                                    <select name="politica" id="politica" data-live-search="true" class="selectpicker"
                                        data-actions-box="true" data-width="100%"
                                        data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <?php foreach($politicas as $t){ ?>
                                        <option value="<?php echo html_entity_decode($t['id']); ?>"
                                            <?php if($t['id'] == $procedimento['politica_id']) { echo 'selected'; } ?>>
                                            <?php echo html_entity_decode($t['titulo']); ?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tipo_procedimento"
                                        class="control-label"><?php echo _l('tipo_procedimento'); ?><span
                                            class="text-danger">*</span></label>
                                    <select name="tipo_procedimento" id="tipo_procedimento" data-live-search="true"
                                        class="selectpicker" data-actions-box="true" data-width="100%"
                                        data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <?php foreach($tipos_procedimento as $t){ ?>
                                        <option value="<?php echo html_entity_decode($t['id']); ?>"
                                            <?php if($t['id'] == $procedimento['tipo_procedimento_id']) { echo 'selected'; } ?>>
                                            <?php echo html_entity_decode($t['tipo_procedimento']); ?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="processo" class="control-label"><?php echo _l('processo'); ?><span
                                            class="text-danger">*</span></label>
                                    <select name="processo" id="processo" data-live-search="true" class="selectpicker"
                                        data-actions-box="true" data-width="100%"
                                        data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                        <?php foreach($processos as $t){ ?>
                                        <option value="<?php echo html_entity_decode($t['id']); ?>"
                                            <?php if($t['id'] == $procedimento['processo_id']) { echo 'selected'; } ?>>
                                            <?php echo html_entity_decode($t['titulo']); ?>
                                            (<?= $t['firstname_c'] . ' '. $t['lastname_c'] ?>)</option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <?php echo render_input('procedimento','Procedimento<span class="text-danger">*<span>', $procedimento['procedimento']); ?>
                            </div>
                            <div class="col-md-12">
                                <?php echo render_textarea('descricao', 'Descrição<span class="text-danger">*<span>', $procedimento['descricao']) ?>
                            </div>
                            <div class="col-md-12">
                                <?php echo render_input('arquivo','Arquivo', '', 'file'); ?>
                            </div>
                            <div class="col-md-12">
                                <?php
                                echo render_select('aprovadores[]', $staff_list, ['staffid', ['firstname', 'lastname']], 'Aprovadores<span class="text-danger">*</span>', (json_decode($procedimento['aprovadores'] ?? '')), ['multiple' => true], [], '', '', false);
                                ?>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-info btn-success"><?php echo _l('submit'); ?></button>
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