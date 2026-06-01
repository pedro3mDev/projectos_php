<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('modules/gestao_formacao/assets/css/dash.css'); ?>">
<div id="wrapper">
    <div class="content">
        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão da Formação / Tecnologias de Acesso / Plataforma EAD
                </a>
            </div>
            <div class="col-md-2" style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
            </div>
        </div>

        </br>
        <?php require 'modules/gestao_formacao/views/tec_acesso/cards.php'; ?>
        </br>

        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold">
                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                    Plataforma EAD
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">

                            <div class=" col-md-12">
                                <a href="#" data-toggle="modal" data-target="#modal_add" class="btn"
                                    style="background-color: #007bff; border-color: #007bff; color: white;">
                                    <i class="fa-regular "></i>
                                    Novo Plataforma EAD
                                </a>
                                <a href="<?php echo admin_url('gestao_formacao/tec_acesso_avaliacao')?>" class="btn"
                                    style="background-color: #FFD700; border-color: #FFD700; color: white;">
                                    <i class="fa-regular "></i>
                                    Avaliação de Desempenho
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
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>URL</th>
                                <th>Estado</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <?php foreach($plataforma_ead as $item) : ?>
                                <tr>
                                    <td><?= html_entity_decode($item['nome'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['descricao'] ?? '') ?></td>
                                    <td><?= html_entity_decode($item['url'] ?? '') ?></td>
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
                                            <?= html_entity_decode($item['status'] ?? '') ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php if ($item['status_id'] == 1) : ?>
                                        <a href="<?php echo admin_url('gestao_formacao/plataforma_ead_aprovar/'.$item['id']); ?>"
                                            class="btn btn-success" style="color: white;">
                                            Aprovar
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas rejeitar?');"
                                            href="<?php echo admin_url('gestao_formacao/plataforma_ead_rejeitar/'.$item['id']); ?>"
                                            class="btn btn-danger" style="color: white;">
                                            Rejeitar
                                        </a>
                                        <?php endif ?>
                                        <a href="<?php echo admin_url('gestao_formacao/tec_acesso_visualizar_recrutamento')?>"
                                            class="btn btn-sucess btn-icon btn_edit_orcamento"
                                            style="background-color: #28a745; border-color: #28a745; color: white;">
                                            <i style="color:#fff;" class="fa fa-eye"></i>
                                        </a>
                                        <a href="javascript:;" data-id="<?= html_entity_decode($item['id'] ?? '') ?>"
                                            data-nome="<?= html_entity_decode($item['nome'] ?? '') ?>"
                                            data-descricao="<?= html_entity_decode($item['descricao'] ?? '') ?>"
                                            data-url="<?= html_entity_decode($item['url'] ?? '') ?>"
                                            data-aprovadores='<?= html_entity_decode(($item["aprovadores"] ?? "")) ?>'
                                            class="btn btn-default btn-icon btn_edit_plataforma_ead"
                                            style="background-color: #007bff; border-color: #007bff; color: white;">
                                            <i style="color:#fff;" class="fa fa-edit"></i>
                                        </a>
                                        <a onclick="return confirm('Tens certteza que desejas eliminar este Plataforma EAD?');"
                                            href="<?php echo admin_url('gestao_formacao/delete_plataforma_ead/'.$item['id']) ?>"
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

<div class="modal" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-describedby="modalBody">
    <div class="modal-dialog modal-md">
        <?php echo form_open(admin_url('gestao_formacao/add_plataforma_ead'), array('method' => 'post', 'novalidate' => true)); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modalTitle">Plataforma EAD</h4>
            </div>
            <div class="modal-body" id="modalBody">
                <div class="row">
                    <div class="col-md-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nome" class="control-label">
                                <small class="req text-danger">*</small> Nome
                            </label>
                            <input type="text" id="nome" name="nome" class="form-control" required
                                placeholder="Digite o nome">
                        </div>
                        <div class="form-group">
                            <label for="descricao" class="control-label">
                                <small class="req text-danger">*</small> Descrição
                            </label>
                            <textarea id="descricao" name="descricao" class="form-control" required
                                placeholder="Digite a descrição"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="url" class="control-label">
                                <small class="req text-danger">*</small> URL
                            </label>
                            <input type="url" id="url" name="url" class="form-control" required
                                placeholder="Digite a URL">
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

<?= form_open(admin_url('gestao_formacao/editar_plataforma_ead'), array('method' => 'post', 'id' => 'form_edit_plataforma_ead')) ?>
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
                    <div class="col-md-12 text-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="e_nome" class="control-label">
                                <small class="req text-danger">*</small> Nome
                            </label>
                            <input type="text" id="e_nome" name="e_nome" class="form-control" required
                                placeholder="Digite o nome">
                        </div>
                        <div class="form-group">
                            <label for="e_descricao" class="control-label">
                                <small class="req text-danger">*</small> Descrição
                            </label>
                            <textarea id="e_descricao" name="e_descricao" class="form-control" required
                                placeholder="Digite a descrição"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="e_url" class="control-label">
                                <small class="req text-danger">*</small> URL
                            </label>
                            <input type="url" id="e_url" name="e_url" class="form-control" required
                                placeholder="Digite a URL">
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
$('.btn_edit_plataforma_ead').click(function() {
    let nome = $(this).attr('data-nome');
    let descricao = $(this).attr('data-descricao');
    let url_c = $(this).attr('data-url');
    let aprovadores = $(this).attr('data-aprovadores');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_formacao/editar_plataforma_ead') ?>/" + id;
    $('#form_edit_plataforma_ead').attr('action', url);

    $('input[name="e_nome"]').val(nome);
    $('input[name="e_url"]').val(url_c);
    $('textarea[name="e_descricao"]').val(descricao);
    $('select[name="e_aprovadores[]"]').selectpicker('val', JSON.parse(aprovadores));

    $('#editar').modal('show');
})
$('#estado_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(3).search(this.value).draw();
})
</script>