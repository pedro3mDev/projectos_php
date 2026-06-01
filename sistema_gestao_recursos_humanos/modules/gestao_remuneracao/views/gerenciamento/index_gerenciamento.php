<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_remuneracao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Remuneração / Gerenciamento / Pacote de Benefício
                </a>
            </div>
            <div class="col-md-2" style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
            </div>
        </div>
        <!-- Comece Aqui! -->
        </br>
        <?php require 'modules/gestao_remuneracao/views/gerenciamento/cards.php'; ?>
        </br>

        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Pacote de Benefício 
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Novo Pacote
                                </a>
                                <a href="<?php echo admin_url('gestao_remuneracao/gerenciamento_beneficio_funcionario') ?>"
                                    class="btn" style="background-color: #DAA520; border-color: #DAA520; color: white;">
                                    <i class="fa-regular "></i>
                                    Benefício do Funcionário 
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-9">
                            </div>
                            <div class=" col-md-3">
                                <select name="estado_f" id="estado_f" class="selectpicker" multiple="true"
                                    data-live-search="true" data-width="100%"
                                    data-none-selected-text="<?php echo _l('Estado'); ?>">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <br><br>
                        <table class="table table-hover table-bordered table-responsive dt-table">
                            <thead class="thead-custom">
                                <th>Descrição</th>
                                <th>Elegibilidade</th>
                                <th>Satus</th>
                                <th>Aprovadores</th>
                                <th></th>
                            </thead>
                            <tbody>
                               
                                    <?php foreach ($pacote_beneficio as $pacote_beneficios): ?>
                                        <tr>
                                            <td> <a
                                                    href="#"><?= htmlspecialchars($pacote_beneficios['descricao'] ?? 'Sem descrição'); ?></a>
                                            </td>
                                            <td> <a href="#"><?= htmlspecialchars($pacote_beneficios['elegibilidade']); ?></a>
                                            </td>
                                            <td> <a href="#"><?= htmlspecialchars($pacote_beneficios['status_nome']); ?></a>
                                            </td>
                                            <td> <a
                                                    href="#"><?= htmlspecialchars($pacote_beneficios['aprovadores_nomes'] ?? 'Nenhum'); ?></a>
                                            </td>
                                            <td>
                                                <?php if ($pacote_beneficios['status_id'] == 1): ?>
                                                    <a href="<?php echo admin_url('gestao_remuneracao/aprovar_pacote_beneficio/' . $pacote_beneficios['id']); ?>"
                                                        class="btn btn-success" style="color: white;">
                                                        Aprovar
                                                    </a>
                                                    <a onclick="return confirm('Tens certeza que desejas rejeitar?');"
                                                        href="<?php echo admin_url('gestao_remuneracao/rejeitar_pacote_beneficio/' . $pacote_beneficios['id']); ?>"
                                                        class="text-white btn btn-danger"
                                                        style="background-color:#FFA500; border-color:#FFA500; color:#fff;">
                                                        Rejeitar
                                                    </a>
                                                <?php endif ?>
                                                <a href="<?php echo admin_url('gestao_remuneracao/gerenciamento_visualizar_pacote/'. $pacote_beneficios['id'])?>" class="btn btn-success btn-icon">
                                                    <i style="color: white;" class="fa fa-eye"></i>
                                                </a>
                                                <a href="#" class="btn btn-default btn-edit-pacote_beneficio"
                                                    data-id="<?= $pacote_beneficios['id']; ?>"
                                                    data-descricao="<?= $pacote_beneficios['descricao']; ?>"
                                                    data-elegibilidade="<?= $pacote_beneficios['elegibilidade']; ?>"
                                                    data-aprovadores="<?= implode(',', json_decode($pacote_beneficios['aprovadores'], true)); ?>"
                                                    data-toggle="modal" data-target="#editar">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                <a onclick="return confirm('Tem certeza que deseja excluir?');"
                                                    href="<?= base_url('gestao_remuneracao/delete_pacote_beneficio/' . $pacote_beneficios['id']); ?>"
                                                    class="btn btn-danger btn-icon _delete">
                                                    <i style="color: white;" class="fa fa-trash"></i>
                                                </a>

                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                               
                                   <!--  <tr>
                                        <td colspan="10" class="text-center">Nenhuma mentoria encontrada.</td>
                                    </tr> -->
                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="btn-bottom-pusher"></div>
</div>
</div>
<div id="new_version"></div>

<div class="modal" id="modal_add" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <?php echo form_open(admin_url('gestao_remuneracao/add_pacote_beneficio'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Novo Pacote</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="descricao"><small class="req text-danger">*</small> Descrição</label>
                    <input type="text" id="descricao" name="descricao" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="elegibilidade"><small class="req text-danger">*</small> Elegibilidade</label>
                    <input type="text" id="elegibilidade" name="elegibilidade" class="form-control" required>
                </div>
                <div class="form-group">
                    <?php
                    $selectedStaff = '';
                    echo render_select('aprovadores[]', $staff_list, ['staffid', ['firstname', 'lastname']], 'Aprovadores<span class="text-danger">*</span>', $selectedStaff, ['multiple' => true], [], '', '', false);
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success">Salvar</button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<?= form_open(admin_url('gestao_remuneracao/editar_pacote_beneficio'), array('method' => 'post', 'id' => 'form_edit_pacote_beneficio')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Editar Mentoria</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <input type="hidden" name="id" id="id" value="">
                        <div class="form-group">
                            <label for="descricao"><small class="req text-danger">*</small> Descrição</label>
                            <input type="text" id="descricao" name="descricao" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="elegibilidade"><small class="req text-danger">*</small> Elegibilidade</label>
                            <input type="text" id="elegibilidade" name="elegibilidade" class="form-control" required>
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
<?php init_tail(); ?>
</body>

</html>

<script>

    $(document).ready(function () {
        $(document).on('click', '.btn-edit-pacote_beneficio', function () {
            console.log("dsfdfdf");
            let id = $(this).data('id');
            let descricao = $(this).data('descricao');
            let elegibilidade = $(this).data('elegibilidade');
            let aprovadores = $(this).data('aprovadores') ? $(this).data('aprovadores').toString().split(',') : [];

            $('#editar #id').val(id);
            //$('#editar textarea[name="descricao"]').val(descricao);
            $('#editar #descricao').val(descricao);
            $('#editar #elegibilidade').val(elegibilidade);
            $('#editar select[name="aprovadores[]"]').val(aprovadores).trigger('change');

        });
    });

    $(document).ready(function () {
        $('#funcionario, #status').on('change', function () {
            atualizarTabela();
        });

        function atualizarTabela() {
            let funcionario = $('#funcionario').val();
            let status = $('#status').val();

            console.log(funcionario, status);

            $.ajax({
                url: '<?= base_url("gestao_desenv_individual/filtrar_mentoria"); ?>',
                type: 'POST',
                data: {
                    funcionario: funcionario,
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