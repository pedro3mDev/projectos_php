<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_desenv_individual/assets/css/plano.css'); ?>">

<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-6">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Desenvolvimento Individual / Carreira
                </a>
            </div>
            <div class="col-md-6" style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
            </div>
        </div>
        </br>

        <?php require 'modules/gestao_desenv_individual/views/carreira/cards.php'; ?>

        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold"><i class="fa fa-address-card-o"
                                        aria-hidden="true"></i>Carreira
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Nova Carreira
                                </a>
                                <a href="<?php echo admin_url('gestao_desenv_individual/carreira_analise_grafica')?>"
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
                                <select name="plano" id="plano" class="selectpicker" data-live-search="true"
                                    data-width="100%" data-none-selected-text="<?php echo _l('Plano Desenv.'); ?>">
                                    <option value=""></option>
                                    <?php foreach ($plano as $dado): ?>
                                        <option value="<?= $dado['id'] ?>"><?= $dado['meta'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <select name="habilidade_id[]" id="habilidade_select" class="selectpicker"
                                    multiple="true" data-live-search="true" data-width="100%"
                                    data-none-selected-text="Habilidades">

                                    <?php foreach ($habilidade as $dado): ?>
                                        <option value="<?= $dado['id'] ?>"><?= $dado['nome'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                        </div>
                        <br><br>
                        <table class="table dt-table">
                            <thead class="thead-custom">
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Data de Secção</th>
                                <th>Habilidade</th>
                                <th>Plano de Desenvolvimento</th>
                                <th></th>
                            </thead>
                            <tbody>
                                
                                    <?php foreach ($carreira as $carreiras): ?>
                                        <tr>
                                            <td> <a href="#"><?= htmlspecialchars($carreiras['nome']); ?></a> </td>
                                            <td> <a
                                                    href="#"><?= htmlspecialchars($carreiras['descricao'] ?? 'Sem descrição'); ?></a>
                                            </td>
                                            <td> <a href="#"><?= date('d/m/Y', strtotime($carreiras['data_seccao'])); ?></a>
                                            </td>
                                            <td> <a href="#"><?= htmlspecialchars($carreiras['habilidade_nomes'] ?? 'Nenhuma'); ?></a>
                                            </td>
                                            <td> <a href="#"><?= htmlspecialchars($carreiras['plano_meta']); ?></a></td>
                                            <td> <a class="btn btn-success btn-icon" href="<?php echo admin_url('gestao_desenv_individual/visualizar_carreira_one/'. $carreiras['id']) ?>"> 
                                                <i style="color: white;" class="fa fa-eye"></i></a>
                                                <a href="#" class="btn btn-default btn-edit-carreira"
                                                    data-id="<?= $carreiras['id']; ?>" data-nome="<?= $carreiras['nome']; ?>"
                                                    data-descricao="<?= $carreiras['descricao']; ?>"
                                                    data-data_seccao="<?= $carreiras['data_seccao']; ?>"
                                                    data-programa_roducao="<?= $carreiras['programa_rotacao']; ?>"
                                                    data-plano_id="<?= $carreiras['plano_id']; ?>"
                                                    data-habilidade_id="<?= implode(',', json_decode($carreiras['habilidade_id'], true)); ?>"
                                                    data-toggle="modal" data-target="#editar">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                <a onclick="return confirm('Tem certeza que deseja excluir?');"
                                                    href="<?= base_url('gestao_desenv_individual/delete_carreira/' . $carreiras['id']); ?>"
                                                    class="btn btn-danger btn-icon _delete">
                                                    <i style="color: white;" class="fa fa-trash"></i>
                                                </a>

                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                               
                                 <!--    <tr>
                                        <td colspan="10" class="text-center">Nenhuma carreira encontrado.</td>
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
        <?= form_open(admin_url('gestao_desenv_individual/add_carreira'), array('method' => 'post')) ?>
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    Nova Carreira
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
                        <div class="form-group" app-field-wrapper="objetivo">
                            <label for="objetivo" class="control-label">
                                Descrição<small class="req text-danger">*</small>
                            </label>
                            <textarea name="descricao" class="form-control" style="min-height: 100px;"></textarea>
                        </div>
                        <div class="form-group" app-field-wrapper="destino">
                            <label for="data_fim" class="control-label">
                                Data de Secção<small class="req text-danger">*</small>
                            </label>
                            <input type="date" id="data_seccao" name="data_seccao" class="form-control">
                        </div>
                        <div class="form-group">
                            <?php
                            $selectedHabilidades = '';
                            echo render_select('habilidade_id[]', $habilidade, ['id', 'nome'], 'Habilidades <span class="text-danger">*</span>', $selectedHabilidades, ['multiple' => true], [], '', '', false);
                            ?>
                        </div>

                        <div class="form-group">
                            <label for="company" class="control-label">
                                Plano de Desenv.<small class="req text-danger">*</small>
                            </label>
                            <select class="form-control" name="plano_id">
                                <option value=""></option>
                                <?php foreach ($plano as $dado): ?>
                                    <option value="<?= $dado['id'] ?>"><?= $dado['meta'] ?></option>
                                <?php endforeach ?>
                            </select>
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

<?= form_open(admin_url('gestao_desenv_individual/editar_carreira'), array('method' => 'post', 'id' => 'form_edit_carreira')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Editar Carreira</h4>
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
                                Nome <small class="req text-danger">*</small>
                            </label>
                            <input type="text" id="nome" name="nome" class="form-control" value="">
                        </div>
                        <div class="form-group" app-field-wrapper="objetivo">
                            <label for="objetivo" class="control-label">
                                Descrição<small class="req text-danger">*</small>
                            </label>
                            <textarea name="descricao" class="form-control" style="min-height: 100px;"></textarea>
                        </div>
                        <div class="form-group" app-field-wrapper="destino">
                            <label for="data_fim" class="control-label">
                                Data de Secção<small class="req text-danger">*</small>
                            </label>
                            <input type="date" id="data_seccao" name="data_seccao" class="form-control">
                        </div>
                        <div class="form-group">
                            <?php
                            $selectedHabilidades = '';
                            echo render_select('habilidade_id[]', $habilidade, ['id', 'nome'], 'Habilidades <span class="text-danger">*</span>', $selectedHabilidades, ['multiple' => true], [], '', '', false);
                            ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Plano Desenvolvimento <small
                                    class="req text-danger">*</small></label>
                            <select class="form-control" name="plano_id" id="plano_id">
                                <option value=""></option>
                                <?php foreach ($plano as $dado): ?>
                                    <option value="<?= $dado['id'] ?>"><?= $dado['meta'] ?></option>
                                <?php endforeach ?>
                            </select>
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
        $(document).on('click', '.btn-edit-carreira', function () {

            console.log("Botão de edição clicado!");

            let id = $(this).data('id');
            let nome = $(this).data('nome');
            let descricao = $(this).data('descricao');
            let data_seccao = $(this).data('data_seccao');
            let habilidade_id = $(this).data('habilidade_id') ? $(this).data('habilidade_id').toString().split(',') : [];
            let plano_id = $(this).data('plano_id');

            // Verificando os valores capturados


            // Preenchendo o formulário do modal
            $('#editar #id').val(id);
            $('#editar #nome').val(nome);
            $('#editar textarea[name="descricao"]').val(descricao);
            $('#editar #data_seccao').val(data_seccao);
            $('#editar select[name="habilidade_id[]"]').val(habilidade_id).trigger('change');
            $('#editar select[name="plano_id"]').val(plano_id).trigger('change');

            console.log("Formulário preenchido com sucesso!");
        });
    });



    $(document).ready(function () {
        $('#plano, #habilidade_select').on('change', function () {
            atualizarTabela();
        });

        function atualizarTabela() {
            let planosSelecionados = $('#plano').val(); // Pega os planos selecionados
            let habilidadesSelecionadas = $('#habilidade_select').val(); // Pega as habilidades selecionadas
            $.ajax({
                url: '<?= base_url("gestao_desenv_individual/filtrar_carreira"); ?>', // Ajuste para a URL correta
                type: 'POST',
                data: {
                    plano: planosSelecionados,
                    habilidade: habilidadesSelecionadas
                },
                success: function (response) {
                    $('table.dt-table tbody').html(response); // Substitui os dados da tabela
                }
            });
        }
    });

</script>
<!--?php require 'modules/gestao_desenv_individual/assets/js/planos.php'; ?-->