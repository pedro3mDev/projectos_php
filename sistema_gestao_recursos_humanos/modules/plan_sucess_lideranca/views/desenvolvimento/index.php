<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Plano de Sucessão e Liderança / Desenvolvimento
                </a>
            </div>
            <div class="col-md-2" style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
                
            </div>
        </div>

    
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Desenvolvimento de Liderança 
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">

                            <div class=" col-md-12">
                                <a href="<?php echo admin_url('plan_sucess_lideranca/desenvolvimento_resultado')?>"
                                    class="btn" style="background-color: #2E8B57; border-color: #2E8B57; color: white;">
                                    <i class="fa-regular "></i>
                                    Resultado
                                </a>
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white; ">
                                    <i class="fa-regular "></i>
                                    Novo Programa de Liderança 
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/desenvolvimento_treinamento')?>"
                                    class="btn" style="background-color: #DAA520; border-color: #DAA520; color: white;">
                                    <i class="fa-regular "></i>
                                    Treinamento de Liderança
                                </a>
                                <a href="<?php echo admin_url('plan_sucess_lideranca/desenvolvimento_avaliacao1')?>"
                                    class="btn" style="background-color: #b91c1c; border-color: #b91c1c; color: white;">
                                    <i class="fa-regular "></i>
                                    Avaliação de Liderança
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
                                    <?php foreach($status as $s) { ?>
                                    <option value="<?php echo new_html_entity_decode($s['status']); ?>">
                                        <?php echo new_html_entity_decode($s['status']); ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <br><br>
                        <table class="table table-hover table-bordered table-responsive dt-table">
                            <thead class="thead-custom">
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Data Início</th>
                                <th>Data Fim</th>
                                <th>Estado</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($programa_lideranca as $item) {
                                ?>
                                <tr>
                                    <td class="text-capitalize"> <?= htmlspecialchars($item['nome']); ?> </td>
                                    <td class="text-capitalize"> <?= htmlspecialchars($item['descricao']); ?> </td>
                                    <td class="text-capitalize"> <?= htmlspecialchars($item['data_inicio']); ?> </td>
                                    <td class="text-capitalize"> <?= htmlspecialchars($item['data_fim']); ?> </td>
                                    <td>
                                        <?php
                                            $cor = "#999"; // Cor padrão (cinza para pendente)
                                            if ($item['status'] == "Aprovado") {
                                                $cor = "green";
                                            } elseif ($item['status'] == "Rejeitado") {
                                                $cor = "red";
                                            }
                                        ?>
                                        <a style="background-color: <?= $cor ?>; color:#fff; padding: 5px; border-radius:10px;">
                                            <?= htmlspecialchars($item['status']); ?>
                                        </a>
                                    </td>
                                    <td>
                                    <?php if ($item['status_id'] == 1) : ?>
                                    <a href="<?php echo admin_url('plan_sucess_lideranca/programa_lideranca_aprovar/'.$item['id']); ?>"
                                        class="btn btn-success" style="color: white;">
                                        Aprovar
                                    </a>
                                    <a onclick="return confirm('Tens certteza que desejas rejeitar?');"
                                        href="<?php echo admin_url('plan_sucess_lideranca/programa_lideranca_rejeitar/'.$item['id']); ?>"
                                        class="text-white btn btn-danger"
                                        style="background-color:#FFA500; border-color:#FFA500; color:#fff;">
                                        Rejeitar
                                    </a>
                                    <?php endif ?>
                                    <a href="<?php echo admin_url('plan_sucess_lideranca/desenvolvimento_visualizar_desenvolvimento/'.$item['id'])?>" 
                                        class="btn btn-sucess btn-icon"
                                        style="background-color: #3CB371; border-color: #3CB371; color: white;">
                                        <i style="color:#fff;" class="fa fa-eye"></i>
                                    </a>
                                    <a href="javascript:;" data-id="<?= $item['id'] ?>"
                                        data-nome="<?= html_entity_decode($item['nome']) ?>"
                                        data-descricao="<?= html_entity_decode($item['descricao']) ?>"
                                        data-data_inicio="<?= html_entity_decode($item['data_inicio']) ?>"
                                        data-data_fim="<?= html_entity_decode($item['data_fim']) ?>"
                                        data-aprovadores='<?= html_entity_decode(($item["aprovadores"] ?? "")) ?>'
                                        class="btn btn-default btn-icon btn_edit_programa_lideranca"
                                        style="background-color: #007bff; border-color: #007bff; color: white;">
                                        <i style="color:#fff;" class="fa fa-edit"></i>
                                    </a>
                                    <a onclick="return confirm('Tens certeza que desejas eliminar este Programa de Liderança?');"
                                        href="<?php echo admin_url('plan_sucess_lideranca/programa_lideranca_delete/'.$item['id'])?>"
                                        class="btn btn-danger btn-icon _delete">
                                        <i style="color:#fff;" class="fa fa-trash"></i>
                                    </a>
                                    </td>
                                </tr>
                                <?php } ?>
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
        <?= form_open(admin_url('plan_sucess_lideranca/adicionar_programa_lideranca'), array('method' => 'post')) ?>
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                Novo Programa de Liderança 
                </h4>
            </div>
            <div class="modal-body"> 
                <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nome" class="control-label">
                                Nome
                                <small class="req text-danger">*</small>
                            </label>
                            <input type="text" class="form-control" name="nome" id="nome" placeholder="Digite o nome">
                        </div>

                        <div class="form-group">
                            <label for="descricao" class="control-label">
                                Descrição
                                <small class="req text-danger">*</small>
                            </label>
                            <textarea class="form-control" name="descricao" id="descricao" rows="4" placeholder="Digite a descrição"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="data_inicio" class="control-label">
                                Data de Início
                                <small class="req text-danger">*</small>
                            </label>
                            <input type="date" class="form-control" name="data_inicio" id="data_inicio">
                        </div>
                        <div class="form-group">
                            <label for="data_fim" class="control-label">
                                Data de Fim
                                <small class="req text-danger">*</small>
                            </label>
                            <input type="date" class="form-control" name="data_fim" id="data_fim">
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
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <?php echo _l('Cancelar'); ?>
                </button>
                <button type="submit" class="btn btn-success">
                    <?php echo _l('submit'); ?>
                </button>
            </div>
        </div>
        <?= form_close()  ?>
    </div>
</div>

<?= form_open(admin_url('plan_sucess_lideranca/editar_programa_lideranca'), array('method' => 'post', 'id' => 'form_edit_programa_lideranca')) ?>
<div class="modal" id="editar" tabindex="-1" role="dialog">
    <div class="modal-dialog w-25">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Editar Programa de Liderança </h4>
            </div>
            <div class="modal-body">
            <div class="row">
                    <div class="col-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nome" class="control-label">
                                Nome
                                <small class="req text-danger">*</small>
                            </label>
                            <input type="text" class="form-control" name="e_nome" id="nome" placeholder="Digite o nome">
                        </div>

                        <div class="form-group">
                            <label for="descricao" class="control-label">
                                Descrição
                                <small class="req text-danger">*</small>
                            </label>
                            <textarea class="form-control" name="e_descricao" id="descricao" rows="4" placeholder="Digite a descrição"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="data_inicio" class="control-label">
                                Data de Início
                                <small class="req text-danger">*</small>
                            </label>
                            <input type="date" class="form-control" name="e_data_inicio" id="data_inicio">
                        </div>

                        <div class="form-group">
                            <label for="data_fim" class="control-label">
                                Data de Fim
                                <small class="req text-danger">*</small>
                            </label>
                            <input type="date" class="form-control" name="e_data_fim" id="data_fim">
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
    // programa_lideranca
$('.btn_edit_programa_lideranca').click(function() {
    let nome = $(this).attr('data-nome');
    let descricao = $(this).attr('data-descricao');
    let data_inicio = $(this).attr('data-data_inicio');
    let data_fim = $(this).attr('data-data_fim');
    let aprovadores = $(this).attr('data-aprovadores');

    let id = $(this).attr('data-id');

    let url = "<?= admin_url('plan_sucess_lideranca/editar_programa_lideranca') ?>/" + id;
    $('#form_edit_programa_lideranca').attr('action', url);

    $('input[name="e_nome"]').val(nome);
    $('textarea[name="e_descricao"]').text(descricao);
    $('input[name="e_data_inicio"]').val(data_inicio);
    $('input[name="e_data_fim"]').val(data_fim);
    $('select[name="e_aprovadores[]"]').selectpicker('val', JSON.parse(aprovadores));

    $('#editar').modal('show');
})
$('#estado_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(4).search(this.value).draw();
})
</script>