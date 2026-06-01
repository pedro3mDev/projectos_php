<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <?php
            $data_view = [];
            $this->load->view('/admin/menu_modulo/menu', $data_view);
        ?>
        <div class="row">
            <div class="col-md-10">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão da Formação / Configurações
                </a>
            </div>
            <div class="col-md-2" style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <ul class="nav navbar-pills navbar-pills-flat nav-tabs nav-stacked"
                    style="border-left: 3px solid #8B0000;">
                    <?php
                      $i = 0;
                      foreach($tab as $g){
                    ?>
                    <li <?php if($g == $group) { echo " class='active'"; } ?>>
                        <a href="<?php echo admin_url('gestao_formacao/configuracoes?group='.$g); ?>"
                            data-group="<?php echo html_entity_decode($g); ?>">
                            <?php echo _l($g); ?></a>
                    </li>
                    <?php $i++; } ?>
                </ul>
            </div>
            <div class="col-md-9">
                <div class="panel_s" style="border-left: 3px solid #8B0000; ">
                    <div class="panel-body">
                        <?php $this->load->view($tabs['view']); ?>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
$('.btn_edit_impacto_qualitativo').click(function() {
    let nome = $(this).attr('data-nome');
    let descricao = $(this).attr('data-descricao');
    let valor = $(this).attr('data-valor');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_formacao/editar_impacto_qualitativo') ?>/" + id;
    $('#form_edit_impacto_qualitativo').attr('action', url);
    $('input[name="e_nome"]').val(nome);
    $('input[name="e_valor"]').val(valor);
    $('textarea[name="e_descricao"]').html(descricao);

    $('#editar').modal('show');
})

$('.btn_edit_impacto_quantitativo').click(function() {
    let nome = $(this).attr('data-nome');
    let descricao = $(this).attr('data-descricao');
    let valor = $(this).attr('data-valor');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_formacao/editar_impacto_quantitativo') ?>/" + id;
    $('#form_edit_impacto_quantitativo').attr('action', url);
    $('input[name="e_nome"]').val(nome);
    $('input[name="e_valor"]').val(valor);
    $('textarea[name="e_descricao"]').html(descricao);

    $('#editar').modal('show');
})
$('.btn_edit_competencia').click(function() {
    let competencia = $(this).attr('data-competencia');
    let descricao = $(this).attr('data-descricao');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_formacao/editar_competencia') ?>/" + id;
    $('#form_edit_competencia').attr('action', url);
    $('input[name="e_competencia"]').val(competencia);
    $('textarea[name="e_descricao"]').html(descricao);

    $('#editar').modal('show');
})
</script>