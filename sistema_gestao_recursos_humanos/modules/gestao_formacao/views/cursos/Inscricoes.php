<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_formacao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão da Formação / Cursos / Inscrições
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
                                    Inscrições
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">

                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Nova Inscrição
                                </a>
                                <a href="<?php echo admin_url('gestao_formacao/cursos')?>" class="btn"
                                    style="background-color: #3CB371; border-color: #3CB371; color: white;">
                                    <i class="fa-regular "></i>
                                    Cursos
                                </a>
                                <a href="<?php echo admin_url('gestao_formacao/cursos_categoria')?>" class="btn"
                                    style="background-color: #336; border-color: #336; color: white;">
                                    <i class="fa-regular "></i>
                                    Categoria
                                </a>
                                <a href="<?php echo admin_url('gestao_formacao/cursos_vagas')?>" class="btn"
                                    style="background-color: #DAA520; border-color: #DAA520; color: white;">
                                    <i class="fa-regular "></i>
                                    Vagas
                                </a>
                            </div>

                        </div>
                        <div class="row">
                            <div class=" col-md-9">
                            </div>

                            <div class=" col-md-3">
                                <select name="estado_f" id="estado_f" class="selectpicker" data-live-search="true"
                                    data-width="100%" data-none-selected-text="<?php echo _l('Estado'); ?>">
                                    <option value=""></option>
                                    <?php foreach($status as $item) : ?>
                                    <option value="<?= $item['status'] ?>"><?= $item['status'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <br><br>
                        <table class="table table-hover table-bordered table-responsive dt-table">
                            <thead class="thead-custom">
                                <th>Funcionário</th>
                                <th>Curso (Carga Horária)</th>
                                <th>Data Inicio</th>
                                <th>Data Fim</th>
                                <th>Data de Inscrição</th>
                                <th>Estado</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach($inscricoes as $item) : ?>
                                <tr>
                                    <td><?= $item['firstname'] .' '.$item['lastname'] ?></td>
                                    <td><?php echo $item['curso']; ?> (Carga Horária:
                                        <?php echo $item['carga_horaria']; ?>)</td>
                                    <td><?= $item['data_inicio'] ?></td>
                                    <td><?= $item['data_fim'] ?></td>
                                    <td><?= $item['data_inscricao'] ?></td>
                                    <td>
                                        <?php
                                            $cor = "#999"; // Cor padrão (cinza para pendente)
                                            if ($item['status'] == "Aprovado") {
                                                $cor = "green";
                                            } elseif ($item['status'] == "Rejeitado") {
                                                $cor = "red";
                                            }
                                        ?>
                                        <a
                                            style="background-color: <?= $cor ?>; color:#fff; padding: 5px; border-radius:10px;">
                                            <?= $item['status'] ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php if ($item['status_id'] == 1) : ?>
                                        <a href="<?php echo admin_url('gestao_formacao/inscricao_aprovar/'.$item['id']); ?>"
                                            class="btn btn-success" style="color: white;">
                                            Aprovar
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas rejeitar?');"
                                            href="<?php echo admin_url('gestao_formacao/inscricao_rejeitar/'.$item['id']); ?>"
                                            class="btn btn-danger" style="color: white;">
                                            Rejeitar
                                        </a>
                                        <?php endif ?>
                                        <a href="<?php echo admin_url('gestao_formacao/cursos_visualizar_inscricoes')?>"
                                            class="btn btn-sucess btn-icon btn_edit_orcamento"
                                            style="background-color: #28a745; border-color: #28a745; color: white;">
                                            <i style="color:#fff;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?= $item['id'] ?>"
                                            data-vaga="<?= $item['vaga_id'] ?>" data-staff="<?= $item['staff_id'] ?>"
                                            data-data_inscricao="<?= $item['data_inscricao'] ?>"
                                            data-aprovadores='<?= html_entity_decode(($item["aprovadores"] ?? "")) ?>'
                                            class="btn btn-default btn-icon btn_edit_inscricao"
                                            style="background-color: #007bff; border-color: #007bff; color: white;">
                                            <i style="color:#fff;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certeza que desejas eliminar esta inscrição?');"
                                            href="<?php echo admin_url('gestao_formacao/delete_inscricao/'.$item['id']); ?>"
                                            class="btn btn-danger btn-icon _delete">
                                            <i style="color:#fff;" class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="btn-bottom-pusher"></div>
</div>
</div>
<div id="new_version"></div>

<div class="modal" id="modal_add" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <?php echo form_open(admin_url('gestao_formacao/add_inscricao'), array('method' => 'post')); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Nova Inscrição</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <?php
                            $selectedStaff = '';
                            echo render_select('staff', $staffs, ['staffid', ['firstname', 'lastname']], 'Funcionário<span class="text-danger">*</span>', $selectedStaff, [], [], '', '', true);
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="nome" class="control-label"><small class="req text-danger">*</small>
                                Curso</label>
                            <select name="vaga" id="vaga_add" class="selectpicker" data-live-search="true"
                                data-width="100%" data-none-selected-text="<?php echo _l('Curso'); ?>">
                                <option data-disponivel="" value="">Selecione um Curso</option>
                                <?php foreach ($vagas as $item) { ?>
                                <option data-disponivel="<?= gf_vagas_dosponiveis($item['id'], $item['total_vagas']) ?>"
                                    value="<?php echo $item['id']; ?>">
                                    <?php echo $item['curso']; ?> -
                                    Carga Horária: <?php echo $item['carga_horaria']; ?>
                                    (De: <?php echo $item['data_inicio']; ?> à <?php echo $item['data_fim']; ?>)
                                </option>
                                <?php } ?>
                            </select>
                            <h5>Vaga Disponivel: <span class="vaga_disponivel"></span></h5>
                        </div>
                        <div class="form-group">
                            <label for="data_inscricao" class="control-label"><small class="req text-danger">*</small>
                                Data de Inscrição
                            </label>
                            <input type="date" id="data_inscricao" name="data_inscricao" class="form-control" required
                                min="<?= date('Y-m-d'); ?>">
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
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success">Salvar</button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<?= form_open(admin_url('gestao_formacao/editar_inscricao'), array('method' => 'post', 'id' => 'form_edit_inscricao')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Editar Inscrição </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <?php
                            $selectedStaff = '';
                            echo render_select('e_staff', $staffs, ['staffid', ['firstname', 'lastname']], 'Funcionário<span class="text-danger">*</span>', $selectedStaff, [], [], '', '', true);
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="nome" class="control-label"><small class="req text-danger">*</small>
                                Curso</label>
                            <select name="e_vaga" id="e_vaga" class="selectpicker" data-live-search="true"
                                data-width="100%" data-none-selected-text="<?php echo _l('Curso'); ?>">
                                <option data-disponivel="" value="">Selecione um Curso</option>
                                <?php foreach ($vagas as $item) { ?>
                                <option data-disponivel="<?= gf_vagas_dosponiveis($item['id'], $item['total_vagas']) ?>"
                                    value="<?php echo $item['id']; ?>">
                                    <?php echo $item['curso']; ?> -
                                    Carga Horária: <?php echo $item['carga_horaria']; ?>
                                    (De: <?php echo $item['data_inicio']; ?> à <?php echo $item['data_fim']; ?>)
                                </option>
                                <?php } ?>
                            </select>
                            <h5>Vaga Disponivel: <span class="e_vaga_disponivel"></span></h5>
                        </div>
                        <div class="form-group">
                            <label for="e_data_inscricao" class="control-label"><small class="req text-danger">*</small>
                                Data de Inscrição
                            </label>
                            <input type="date" id="e_data_inscricao" name="e_data_inscricao" class="form-control"
                                required>
                        </div>
                        <div class="form-group">
                            <?php
                            $selectedStaff = '';
                            echo render_select('e_aprovadores[]', $staff_list, ['staffid', ['firstname', 'lastname']], 'Aprovadores<span class="text-danger">*</span>', $selectedStaff, ['multiple' => true], [], '', '', false);
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
<?= form_close()  ?>

<?php init_tail(); ?>
<script>
$('.btn_edit_inscricao').click(function() {
    let staff = $(this).attr('data-staff');
    let vaga = $(this).attr('data-vaga');
    let data_inscricao = $(this).attr('data-data_inscricao');
    let aprovadores = $(this).attr('data-aprovadores');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_formacao/editar_inscricao') ?>/" + id;
    $('#form_edit_inscricao').attr('action', url);

    $('select[name="e_staff"]').selectpicker('val', staff);
    $('select[name="e_vaga"]').selectpicker('val', vaga);
    $('input[name="e_data_inscricao"]').val(data_inscricao);
    $('select[name="e_aprovadores[]"]').selectpicker('val', JSON.parse(aprovadores));

    let vagas = $('select[name="e_vaga"]').find(':selected').data('disponivel');
    $('.e_vaga_disponivel').text(vagas)

    $('#editar').modal('show');
})
$('#estado_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(5).search(this.value).draw();
})

$('#vaga_add').change(function() {
    let vagas = $(this).find(':selected').data('disponivel');
    $('.vaga_disponivel').text(vagas)
})

$('#e_vaga').change(function() {
    let vagas = $(this).find(':selected').data('disponivel');
    $('.e_vaga_disponivel').text(vagas)
})
</script>