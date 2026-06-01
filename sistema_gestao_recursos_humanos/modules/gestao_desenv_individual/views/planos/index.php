<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_desenv_individual/assets/css/plano.css'); ?>">

<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-6">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Desenvolvimento Individual / Plano
                </a>
            </div>
            <div class="col-md-6" style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
            </div>
        </div>
        </br>

        <?php require 'modules/gestao_desenv_individual/views/planos/cards.php'; ?>

        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold"><i class="fa fa-address-card-o"
                                        aria-hidden="true"></i>Plano
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Novo Plano
                                </a> 
                                <a href="<?php echo admin_url('gestao_engajamento_talentos/pesquisas_pergunta_engajamento')?>"
                                    class="btn" style="background-color: #DAA520; border-color: #DAA520; color: white;">
                                    <i class="fa-regular "></i>
                                    Recomendação Mentórias
                                </a>
                                <a href="<?php echo admin_url('gestao_desenv_individual/planos_analise_grafica')?>"
                                    class="btn" style="background-color: #991b1b; border-color: #991b1b; color: white;">
                                    <i class="fa-regular "></i>
                                    Análise Gráfica
                                </a>
                            </div>
                        </div>
                        </br>
                        <div class="row">
                            <div class=" col-md-6">
                            </div>
                            <div class="col-md-3">
                                <select name="avaliacao" id="avaliacao" class="selectpicker" data-live-search="true"
                                    data-width="100%"
                                    data-none-selected-text="<?php echo _l('Avaliação de Desempenho'); ?>">
                                    <option value=""></option>
                                    <?php foreach ($avaliacoes as $dado): ?>
                                        <option value="<?= $dado['id'] ?>"><?= $dado['nome'] ?></option>
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
                                <th>Meta</th>
                                <th>Descrição</th>
                                <th>Prazo</th>
                                <th>Data de Fim</th>
                                <th>Pontuacao Recomendada</th>
                                <th>Estado</th>
                                <th>Mentoria</th>
                                <th>Avaliação</th>
                                <th>Aprovadores</th>
                                <th></th>
                            </thead>
                            <tbody>

                                <?php foreach ($plano as $planos): ?>
                                    <tr>
                                        <td> <a href="#"><?= htmlspecialchars($planos['meta']); ?></a> </td>
                                        <td> <a
                                                href="#"><?= htmlspecialchars($planos['descricao'] ?? 'Sem descrição'); ?></a>
                                        </td>
                                        <td> <a href="#"><?= date('d/m/Y', strtotime($planos['prazo'])); ?></a></td>
                                        <td> <a href="#"><?= date('d/m/Y', strtotime($planos['data_fim'])); ?></a> </td>
                                        <td> <a href="#"><?= htmlspecialchars($planos['pontuacao_recomendado']); ?></a>
                                        </td>
                                        <td> <a href="#"><?= htmlspecialchars($planos['status_nome']); ?></a> </td>
                                        <td> <a href="#"><?= htmlspecialchars($planos['mentoria_nome']); ?></a> </td>
                                        <td> <a href="#"><?= htmlspecialchars($planos['avaliacao_nome']); ?></a> </td>
                                        <td> <a
                                                href="#"><?= htmlspecialchars($planos['aprovadores_nomes'] ?? 'Nenhum'); ?></a>
                                        </td>
                                        <td>
                                            <?php if ($planos['status_id'] == 1): ?>
                                                <a href="<?php echo admin_url('gestao_desenv_individual/plano_aprovar/' . $planos['id']); ?>"
                                                    class="btn btn-success" style="color: white;">
                                                    Aprovar
                                                </a>
                                                <a onclick="return confirm('Tens certeza que desejas rejeitar?');"
                                                    href="<?php echo admin_url('gestao_desenv_individual/plano_rejeitar/' . $planos['id']); ?>"
                                                    class="text-white btn btn-danger"
                                                    style="background-color:#FFA500; border-color:#FFA500; color:#fff;">
                                                    Rejeitar
                                                </a>
                                            <?php endif ?>
                                            <a class="btn btn-success btn-icon" href="<?php echo admin_url('gestao_desenv_individual/visualizar_plano_one/'. $planos['id']) ?>"> 
                                                <i style="color: white;" class="fa fa-eye">
                                                </i>
                                            </a>
                                            <a href="#" class="btn btn-default btn-edit-plano"
                                                data-id="<?= $planos['id']; ?>" data-meta="<?= $planos['meta']; ?>"
                                                data-descricao="<?= $planos['descricao']; ?>"
                                                data-prazo="<?= $planos['prazo']; ?>"
                                                data-data_fim="<?= $planos['data_fim']; ?>"
                                                data-pontuacao_recomendado="<?= $planos['pontuacao_recomendado']; ?>"
                                                data-mentoria_id="<?= $planos['mentoria_id']; ?>"
                                                data-aprovadores="<?= implode(',', json_decode($planos['aprovadores'], true)); ?>"
                                                data-avaliacao_id="<?= $planos['avaliacao_id']; ?>" data-toggle="modal"
                                                data-target="#editar">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a onclick="return confirm('Tem certeza que deseja excluir?');"
                                                href="<?= base_url('gestao_desenv_individual/delete_plano/' . $planos['id']); ?>"
                                                class="btn btn-danger btn-icon _delete">
                                                <i style="color: white;" class="fa fa-trash"></i>
                                            </a>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                <!--  <tr>
                                        <td colspan="10" class="text-center">Nenhuma plano encontrado.</td>
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
        <?= form_open(admin_url('gestao_desenv_individual/add_plano'), array('method' => 'post')) ?>
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Adicionar Plano
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
                        <div class="form-group" app-field-wrapper="destino">
                            <label for="data_fim" class="control-label">
                                Pontuação Recomendada<small class="req text-danger">*</small>
                            </label>
                            <input type="number" id="pontuacao_recomendado" name="pontuacao_recomendado"
                                class="form-control">
                        </div>
                        <div class="form-group" app-field-wrapper="destino">
                            <label for="data_fim" class="control-label">
                                Prazo<small class="req text-danger">*</small>
                            </label>
                            <input type="date" id="prazo" name="prazo" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="company" class="control-label">
                                Mentoria <small class="req text-danger">*</small>
                            </label>
                            <select class="form-control" name="mentoria_id">
                                <option value=""></option>
                                <?php foreach ($mentoria as $dado): ?>
                                    <option value="<?= $dado['id'] ?>"><?= $dado['nome'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="company" class="control-label">
                                Avaliação <small class="req text-danger">*</small>
                            </label>
                            <select class="form-control" name="avaliacao_id">
                                <option value=""></option>
                                <?php foreach ($avaliacoes as $dado): ?>
                                    <option value="<?= $dado['id'] ?>"><?= $dado['nome'] ?></option>
                                <?php endforeach ?>
                            </select>
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

<?= form_open(admin_url('gestao_desenv_individual/editar_plano'), array('method' => 'post', 'id' => 'form_edit_pedido')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Editar </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">

                        <input type="hidden" name="id" id="id" value="">

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
                        <div class="form-group" app-field-wrapper="destino">
                            <label for="recomendado" class="control-label">
                                Pontuacao Recomendada<small class="req text-danger">*</small>
                            </label>
                            <input type="number" id="pontuacao_recomendado" name="pontuacao_recomendado"
                                class="form-control">
                        </div>
                        <div class="form-group" app-field-wrapper="destino">
                            <label for="prazo" class="control-label">
                                Prazo<small class="req text-danger">*</small>
                            </label>
                            <input type="date" id="prazo" name="prazo" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Mentoria <small class="req text-danger">*</small></label>
                            <select class="form-control" name="mentoria_id" id="mentoria_id">
                                <option value=""></option>
                                <?php foreach ($mentoria as $dado): ?>
                                    <option value="<?= $dado['id'] ?>"><?= $dado['nome'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Avaliação <small class="req text-danger">*</small></label>
                            <select class="form-control" name="avaliacao_id" id="avaliacao_id">
                                <option value=""></option>
                                <?php foreach ($avaliacoes as $dado): ?>
                                    <option value="<?= $dado['id'] ?>"><?= $dado['nome'] ?></option>
                                <?php endforeach ?>
                            </select>
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
        $(document).on('click', '.btn-edit-plano', function () {
            let id = $(this).data('id');
            let meta = $(this).data('meta');
            let descricao = $(this).data('descricao');
            let prazo = $(this).data('prazo');
            let data_fim = $(this).data('data_fim');
            let pontuacao_recomendado = $(this).data('pontuacao_recomendado');
            let mentoria_id = $(this).data('mentoria_id');
            let aprovadores = $(this).data('aprovadores') ? $(this).data('aprovadores').toString().split(',') : [];
            let avaliacao_id = $(this).data('avaliacao_id');

            $('#editar #id').val(id);
            $('#editar #meta').val(meta);
            $('#editar textarea[name="descricao"]').val(descricao);
            $('#editar #prazo').val(prazo);
            $('#editar #data_fim').val(data_fim);
            $('#editar #pontuacao_recomendado').val(pontuacao_recomendado);
            $('#editar select[name="aprovadores[]"]').val(aprovadores).trigger('change');
            $('#editar select[name="avaliacao_id"]').val(avaliacao_id).trigger('change');
            $('#editar select[name="mentoria_id"]').val(mentoria_id).trigger('change');

        });
    });


    $(document).ready(function () {
        // Quando os filtros forem alterados
        $('#avaliacao, #status').on('change', function () {
            atualizarTabela();
        });
        function atualizarTabela() {
            let avaliacao = $('#avaliacao').val();
            let status = $('#status').val();

            console.log(avaliacao, status);

            $.ajax({
                url: '<?= base_url("gestao_desenv_individual/filtrar_planos"); ?>',
                type: 'POST',
                data: {
                    avaliacao: avaliacao,
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

</script>