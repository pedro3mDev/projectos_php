<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_desenv_individual/assets/css/plano.css'); ?>">

<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-6">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Desenvolvimento Individual / Avaliações de Desempenho
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
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold"><i class="fa fa-address-card-o"
                                        aria-hidden="true"></i>Avaliações
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Nova Avaliação
                                </a>
                                <a href="<?php echo admin_url('gestao_desenv_individual/analise') ?>" class="btn"
                                    style="background-color: #2F4F4F; border-color: #2F4F4F; color: white;">
                                    <i class="fa-regular "></i>
                                    Análise
                                </a>
                                <a href="<?php echo admin_url('gestao_desenv_individual/recomendar_planos') ?>"
                                    class="btn" style="background-color: #DC143C; border-color: #DC143C; color: white;">
                                    <i class="fa-regular "></i>
                                    Recomendar Planos
                                </a>
                            </div>
                        </div>
                        </br>
                        <div class="row">
                            <div class=" col-md-6">
                            </div>
                            <div class="col-md-3">
                                <select name="tipo_avaliacaoo" id="tipo_avaliacaoo" class="selectpicker"
                                    data-live-search="true" data-width="100%"
                                    data-none-selected-text="<?php echo _l('Tipo Avaliacao'); ?>">
                                    <option value=""></option>
                                    <?php foreach ($tipo_avaliacao as $dado): ?>
                                        <option value="<?= $dado['id'] ?>"> <?= $dado['nome'] ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <select name="status" id="status" class="selectpicker" data-live-search="true"
                                    data-width="100%" data-none-selected-text="<?php echo _l('Estado'); ?>">
                                    <option value=""></option>
                                    <?php foreach ($status as $dado): ?>
                                        <option value="<?= $dado['id'] ?>"><?= $dado['status'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>


                        </div>
                        <br><br>
                        <table class="table dt-table">
                            <thead class="thead-custom">
                                <tr>
                                    <th>Nome</th>
                                    <th>Meta</th>
                                    <th>Descrição</th>
                                    <th>Data de Fim</th>
                                    <th>Funcionário</th>
                                    <th>Aprovadores</th>
                                    <th>Tipo Avaliação</th>
                                    <th>Estado</th>
                                    <th>Prazo</th>
                                    <th>Pontuação</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($avaliacoes as $avaliacao): ?>
                                    <tr>
                                        <td> <a href="#"><?= htmlspecialchars($avaliacao['nome']); ?></a> </td>
                                        <td> <a href="#"><?= htmlspecialchars($avaliacao['meta']); ?></a> </td>
                                        <td> <a
                                                href="#"><?= htmlspecialchars($avaliacao['descricao'] ?? 'Sem descrição'); ?></a>
                                        </td>
                                        <td> <a href="#"><?= date('d/m/Y', strtotime($avaliacao['data_fim'])); ?></a> </td>
                                        <td> <a
                                                href="#"><?= htmlspecialchars($avaliacao['primeiro_nome'] . " " . $avaliacao['segundo_nome']); ?></a>
                                        </td>
                                        <td><a
                                                href="#"><?= htmlspecialchars($avaliacao['aprovadores_nomes'] ?? 'Nenhum'); ?></a>
                                        </td>
                                        <td> <a href="#"><?= htmlspecialchars($avaliacao['tipo_nome']); ?></a> </td>
                                        <td> <a href="#"><?= htmlspecialchars($avaliacao['status_nome']); ?></a> </td>
                                        <td> <a href="#"><?= date('d/m/Y', strtotime($avaliacao['prazo'])); ?></a> </td>
                                        <td> <a href="#"><?= htmlspecialchars($avaliacao['pontuacao']); ?></a> </td>
                                        <td>
                                            <?php if ($avaliacao['status_id'] == 1): ?>
                                                <a href="<?php echo admin_url('gestao_desenv_individual/avaliacao_aprovar/' . $avaliacao['id']); ?>"
                                                    class="btn btn-success" style="color: white;">
                                                    Aprovar
                                                </a>
                                                <a onclick="return confirm('Tens certeza que desejas rejeitar?');"
                                                    href="<?php echo admin_url('gestao_desenv_individual/avaliacao_rejeitar/' . $avaliacao['id']); ?>"
                                                    class="text-white btn btn-danger"
                                                    style="background-color:#FFA500; border-color:#FFA500; color:#fff;">
                                                    Rejeitar
                                                </a>
                                            <?php endif ?>
                                            <a class="btn btn-success btn-icon"
                                                href="<?php echo admin_url('gestao_desenv_individual/visualizar_avaliacao_one/' . $avaliacao['id']) ?>">
                                                <i style="color: white;" class="fa fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-default btn-edit-avaliacao"
                                                data-id="<?= $avaliacao['id']; ?>" data-nome="<?= $avaliacao['nome']; ?>"
                                                data-meta="<?= $avaliacao['meta']; ?>"
                                                data-descricao="<?= $avaliacao['descricao']; ?>"
                                                data-data_fim="<?= $avaliacao['data_fim']; ?>"
                                                data-prazo="<?= $avaliacao['prazo']; ?>"
                                                data-pontuacao="<?= $avaliacao['pontuacao']; ?>"
                                                data-aprovadores="<?= implode(',', json_decode($avaliacao['aprovadores'], true)); ?>"
                                                data-tipo_avaliacao="<?= $avaliacao['tipo_avaliacao_id']; ?>"
                                                data-staf_id="<?= $avaliacao['staf_id']; ?>" data-toggle="modal"
                                                data-target="#editar">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a onclick="return confirm('Tem certeza que deseja excluir?');"
                                                href="<?= base_url('gestao_desenv_individual/delete_avaliacao/' . $avaliacao['id']); ?>"
                                                class="btn btn-danger btn-icon _delete">
                                                <i style="color: white;" class="fa fa-trash"></i>
                                            </a>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                <!--  <tr>
                                        <td colspan="10" class="text-center">Nenhuma avaliação encontrada.</td>
                                    </tr> -->

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="clearfix"></div>
</div>
<?php echo form_close(); ?>
<div class="btn-bottom-pusher"></div>
</div>
</div>
<div id="new_version"></div>

<div class="modal" id="modal_add" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <?= form_open(admin_url('gestao_desenv_individual/add_avaliacao'), array('method' => 'post')) ?>

        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Nova Avaliação
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group" app-field-wrapper="destino">
                            <label for="destino" class="control-label">
                                Nome <small class="req text-danger">*</small>
                            </label>
                            <input type="text" id="nome" name="nome" class="form-control" value="">
                        </div>
                        <div class="form-group" app-field-wrapper="destino">
                            <label for="destino" class="control-label">
                                Meta <small class="req text-danger">*</small>
                            </label>
                            <input type="text" id="meta" name="meta" class="form-control" value="">
                        </div>
                        <div class="form-group" app-field-wrapper="objetivo">
                            <label for="objetivo" class="control-label">
                                Descrição<small class="req text-danger">*</small>
                            </label>
                            <textarea name="descricao" class="form-control" style="min-height: 100px;"></textarea>
                        </div>
                        <div class="form-group" app-field-wrapper="destino">
                            <label for="data_fim" class="control-label">
                                Data de Fim<small class="req text-danger">*</small>
                            </label>
                            <input type="date" id="data_fim" name="data_fim" class="form-control">
                        </div>

                        <div class="form-group">
                            <?php
                            $selectedStaff = '';
                            echo render_select('funcionário', $staff, ['staffid', ['firstname', 'lastname']], 'Funcionário<span class="text-danger">*</span>', $selectedStaff, [], [], '', '', true);
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="company" class="control-label">
                                Tipo de Avaliação <small class="req text-danger">*</small>
                            </label>
                            <select class="form-control" name="tipo_avaliacao_id">
                                <option value=""></option>
                                <?php foreach ($tipo_avaliacao as $dado): ?>
                                    <option value="<?= $dado['id'] ?>"><?= $dado['nome'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="form-group" app-field-wrapper="destino">
                            <label for="prazo" class="control-label">
                                Prazo<small class="req text-danger">*</small>
                            </label>
                            <input type="date" id="prazo" name="prazo" class="form-control">
                        </div>
                        <div class="form-group" app-field-wrapper="objetivo">
                            <label for="pontuacao" class="control-label">
                                Pontuação<small class="req text-danger">*</small>
                            </label>
                            <input type="text" id="pontuacao" name="pontuacao" class="form-control">
                        </div>
                        <div class="form-group">
                            <?php
                            $selectedStaff = '';
                            echo render_select('aprovadores[]', $staff_list, ['staffid', ['firstname', 'lastname']], 'Aprovadores<span class="text-danger">*</span>', $selectedStaff, ['multiple' => true], [], '', '', false);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo _l('Cancelar'); ?></button>
                <button type="submit" class="btn btn-success"><?php echo _l('Salvar'); ?></button>
            </div>
        </div>
        <?= form_close() ?>
    </div>
</div>

<?= form_open(admin_url('gestao_desenv_individual/editar_avaliacao'), array('method' => 'post', 'id' => 'form_edit_avaliacao')) ?>

<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Editar Avaliação</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <!-- ID da Avaliação -->
                        <input type="hidden" name="id" id="id" value="">

                        <div class="form-group">
                            <label class="control-label">Nome <small class="req text-danger">*</small></label>
                            <input type="text" id="nome" name="nome" class="form-control" value="">
                        </div>

                        <div class="form-group">
                            <label class="control-label">Meta <small class="req text-danger">*</small></label>
                            <input type="text" id="meta" name="meta" class="form-control" value="">
                        </div>

                        <div class="form-group">
                            <label class="control-label">Descrição <small class="req text-danger">*</small></label>
                            <textarea name="descricao" id="descricao" class="form-control"
                                style="min-height: 100px;"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Data de Fim <small class="req text-danger">*</small></label>
                            <input type="date" id="data_fim" name="data_fim" class="form-control">
                        </div>

                        <div class="form-group">
                            <?php
                            echo render_select(
                                'funcionario',
                                $staff,
                                ['staffid', ['firstname', 'lastname']],
                                'Funcionário <span class="text-danger">*</span>',
                                '',
                                [],
                                [],
                                '',
                                '',
                                true
                            );
                            ?>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Tipo de Avaliação <small
                                    class="req text-danger">*</small></label>
                            <select class="form-control" name="tipo_avaliacao_id" id="tipo_avaliacao_id">
                                <option value=""></option>
                                <?php foreach ($tipo_avaliacao as $dado): ?>
                                    <option value="<?= $dado['id'] ?>"><?= $dado['nome'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Prazo <small class="req text-danger">*</small></label>
                            <input type="date" id="prazo" name="prazo" class="form-control">
                        </div>

                        <div class="form-group">
                            <label class="control-label">Pontuação <small class="req text-danger">*</small></label>
                            <input type="number" id="pontuacao" name="pontuacao" class="form-control">
                        </div>

                        <div class="form-group">
                            <?php
                            echo render_select(
                                'aprovadores[]',
                                $staff_list,
                                ['staffid', ['firstname', 'lastname']],
                                'Aprovadores <span class="text-danger">*</span>',
                                '',
                                ['multiple' => true],
                                [],
                                '',
                                '',
                                false
                            );
                            ?>
                        </div>

                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo _l('Cancelar'); ?></button>
                <button type="submit" class="btn btn-success"><?php echo _l('Salvar'); ?></button>
            </div>

        </div>
    </div>
</div>

<?= form_close() ?>
<?php init_tail(); ?>

<script>
    $(document).ready(function () {
        $(document).on('click', '.btn-edit-avaliacao', function () {
            console.log("dsfdfdf");

            let id = $(this).data('id');
            let nome = $(this).data('nome');
            let meta = $(this).data('meta');
            let descricao = $(this).data('descricao');
            let data_fim = $(this).data('data_fim');
            let prazo = $(this).data('prazo');
            let pontuacao = $(this).data('pontuacao');
            let aprovadores = $(this).data('aprovadores') ? $(this).data('aprovadores').toString().split(',') : [];
            let tipo_avaliacao = $(this).data('tipo_avaliacao');
            let funcionario = $(this).data('staf_id');


            $('#editar #id').val(id);
            $('#editar #nome').val(nome);
            $('#editar #meta').val(meta);
            $('#editar textarea[name="descricao"]').val(descricao);
            $('#editar #data_fim').val(data_fim);
            $('#editar #prazo').val(prazo);
            $('#editar #pontuacao').val(pontuacao);
            $('#editar select[name="aprovadores[]"]').val(aprovadores).trigger('change');
            $('#editar select[name="tipo_avaliacao_id"]').val(tipo_avaliacao).trigger('change');
            $('#editar select[name="funcionario"]').val(funcionario).trigger('change');

        });
    });



    $(document).ready(function () {
        // Quando os filtros forem alterados
        $('#tipo_avaliacaoo, #status').on('change', function () {
            atualizarTabela();
        });

        function atualizarTabela() {
            let tipo_avaliacaoo = $('#tipo_avaliacaoo').val();
            let status = $('#status').val();

            console.log(tipo_avaliacaoo, status);

            $.ajax({
                url: '<?= base_url("gestao_desenv_individual/filtrar_avaliacao"); ?>',
                type: 'POST',
                data: {
                    tipo_avaliacaoo: tipo_avaliacaoo,
                    status: status
                },
                success: function (response) {
                    $('table.dt-table tbody').html(response);
                },
                error: function (xhr, status, error) {
                    console.error("Erro na requisição AJAX:", error);
                }
            });

        }
    });

    var base_url = "<?= base_url(); ?>"; // Define a URL base do CodeIgniter

    $(document).ready(function () {
        $('.btn-aprovar').click(function (e) {
            e.preventDefault();
            let id = $(this).data('id');
            console.log(id)
            $.ajax({
                url: base_url + 'gestao_desenv_individual/aprovar_avaliacao',
                type: 'POST',
                data: { id: id }, // Corrigido: enviar ID pelo corpo da requisição
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        alert(response.success);
                        location.reload(); // Atualiza a página
                    } else {
                        alert(response.error);
                    }
                },
                error: function () {
                    alert("Erro ao processar a solicitação.");
                }
            });
        });

        $('.btn-rejeitar').click(function (e) {
            e.preventDefault();
            let id = $(this).data('id');

            $.ajax({
                url: base_url + 'gestao_desenv_individual/rejeitar_avaliacao',
                type: 'POST',
                data: { id: id }, // Enviar ID corretamente
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        alert(response.success);
                        location.reload();
                    } else {
                        alert(response.error);
                    }
                },
                error: function () {
                    alert("Erro ao processar a solicitação.");
                }
            });
        });
    });
</script>