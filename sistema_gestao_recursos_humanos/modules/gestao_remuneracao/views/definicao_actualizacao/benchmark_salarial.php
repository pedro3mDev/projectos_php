<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_remuneracao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Remuneração / Definição e Actualização / Benchmark Salarial
                </a>
            </div>
            <div class="col-md-2" style=" display: flex; justify-content: flex-end; align-items: center;">
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
                                <h4 class="no-margin font-bold">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Benchmark Salarial
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Novo Benchmark
                                </a>
                                <a href="<?php echo admin_url('Gestao_remuneracao/definicao') ?>" class="btn"
                                    style="background-color: #DAA520; border-color: #DAA520; color: white;">
                                    <i class="fa-regular "></i>
                                    Faixa Salarial
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
                                <th>Setor</th>
                                <th>Nível de Experiência</th>
                                <th>Média Salarial</th>
                                <th>Data de Referência</th>
                                <th></th>
                            </thead>
                            <tbody>

                                <?php foreach ($benchmark_salarial as $benchmark_salarials): ?>
                                    <tr>

                                        <td> <a href="#"><?= htmlspecialchars($benchmark_salarials['setor']); ?></a>
                                        </td>
                                        <td> <a
                                                href="#"><?= htmlspecialchars($benchmark_salarials['nivel_experiencia']); ?></a>
                                        </td>
                                        <td> <a
                                                href="#"><?= htmlspecialchars($benchmark_salarials['media_salarial']); ?></a>
                                        </td>
                                        <td> <a
                                                href="#"><?= date('d/m/Y', strtotime($benchmark_salarials['data_referencia'])); ?></a>
                                        </td>
                                        <td>
                                            <a href="<?php echo admin_url('gestao_remuneracao/definicao_visualizar_benchmark/'. $benchmark_salarials['id']) ?>"
                                                class="btn btn-success btn-icon">
                                                <i style="color: white;" class="fa fa-eye"></i>
                                            </a>
                                            <a href="#" class="btn btn-default btn-edit-benchmark_salarial"
                                                data-id="<?= $benchmark_salarials['id']; ?>"
                                                data-setor="<?= $benchmark_salarials['setor']; ?>"
                                                data-nivel_experiencia="<?= $benchmark_salarials['nivel_experiencia']; ?>"
                                                data-media_salarial="<?= $benchmark_salarials['media_salarial']; ?>"
                                                data-data_referencia="<?= $benchmark_salarials['data_referencia']; ?>"
                                                data-toggle="modal" data-target="#editar">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <a onclick="return confirm('Tem certeza que deseja excluir?');"
                                                href="<?= base_url('gestao_remuneracao/delete_benchmark_salarial/' . $benchmark_salarials['id']); ?>"
                                                class="btn btn-danger btn-icon _delete">
                                                <i style="color: white;" class="fa fa-trash"></i>
                                            </a>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                <!-- <tr>
                                    <td colspan="10" class="text-center">Nenhum dado encontrado.</td>
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
        <?php echo form_open(admin_url('gestao_remuneracao/add_benchmark_salarial'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Novo Benchmark</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="setor"><small class="req text-danger">*</small>Setor</label>
                    <input type="text" id="setor" name="setor" class="form-control" required />
                </div>
                <div class="form-group">
                    <label for="nivel_experiencia"><small class="req text-danger">*</small> Média Salarial</label>
                    <input type="text" id="nivel_experiencia" name="nivel_experiencia" class="form-control" required />
                </div>
                <div class="form-group">
                    <label for="media_salarial"><small class="req text-danger">*</small> Média Salarial</label>
                    <input type="number" id="media_salarial" name="media_salarial" class="form-control" step="0.01"
                        min="0" required>
                </div>
                <div class="form-group">
                    <label for="data_referencia"><small class="req text-danger">*</small> Data de Referência</label>
                    <input type="date" id="data_referencia" name="data_referencia" class="form-control" required>
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

<?= form_open(admin_url('gestao_remuneracao/editar_benchmark_salarial'), array('method' => 'post', 'id' => 'form_edit_benchmark_salarial')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Editar Benchmark Salarial</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <input type="hidden" name="id" id="id" value="">
                        <div class="form-group">
                            <label for="setor"><small class="req text-danger">*</small> Setor</label>
                            <input type="text" id="setor" name="setor" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label for="nivel_experiencia"><small class="req text-danger">*</small> Média
                                Salarial</label>
                            <input type="text" id="nivel_experiencia" name="nivel_experiencia" class="form-control"
                                required />
                        </div>
                        <div class="form-group">
                            <label for="media_salarial"><small class="req text-danger">*</small> Média Salarial</label>
                            <input type="number" id="media_salarial" name="media_salarial" class="form-control"
                                step="0.01" min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="data_referencia"><small class="req text-danger">*</small> Data de
                                Referência</label>
                            <input type="date" id="data_referencia" name="data_referencia" class="form-control"
                                required>
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
        $(document).on('click', '.btn-edit-benchmark_salarial', function () {
            let id = $(this).data('id');
            let setor = $(this).data('setor');
            let nivel_experiencia = $(this).data('nivel_experiencia');
            let media_salarial = $(this).data('media_salarial');
            let data_referencia = $(this).data('data_referencia');

            $('#editar #id').val(id);
            $('#editar #setor').val(setor);
            $('#editar #nivel_experiencia').val(nivel_experiencia);
            $('#editar #media_salarial').val(media_salarial);
            $('#editar #data_referencia').val(data_referencia);

        });
    });

    $(document).ready(function () {
        // Quando os filtros forem alterados
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