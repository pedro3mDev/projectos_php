<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <?php
            $data_view = [];
            $this->load->view('/admin/menu_modulo/menu', $data_view);
        ?>

        <div class="row">
            <div class="col-md-12">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a style="color:#333; font-size:16px;"
                                href="<?php echo admin_url('gestao_viagens/'); ?>"><?php echo _l('gestao_viagens'); ?></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <a style="color:#333; font-size:16px;" href="">
                                <?php echo _l('gv_configuracoes'); ?>
                            </a>
                        </li>
                    </ol>
                </nav>
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
                    <li<?php if($g == $group){echo " class='active'"; } ?>>
                        <a href="<?php echo admin_url('gestao_viagens/configuracoes?group='.$g); ?>"
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
        <?php echo form_close(); ?>
        <div class="btn-bottom-pusher"></div>
    </div>
</div>
<div id="new_version"></div>
<?php init_tail(); ?>
<?php require('modules/recruitment/assets/js/company_js.php'); ?>
<script>
$('.btn_edit_categoria').click(function() {
    let categoria = $(this).attr('data-categoria');
    let descricao = $(this).attr('data-descricao');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_viagens/editar_categoria') ?>/" + id;
    $('#form_edit_categoria').attr('action', url);
    $('input[name="e_categoria"]').val(categoria);
    $('textarea[name="e_descricao"]').html(descricao);

    $('#editar').modal('show');
})
$('.btn_edit_tipo_viagem').click(function() {
    let tipo_viagem = $(this).attr('data-tipo_viagem');
    let descricao = $(this).attr('data-descricao');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_viagens/editar_tipo_viagem') ?>/" + id;
    $('#form_edit_tipo_viagem').attr('action', url);
    $('input[name="e_tipo_viagem"]').val(tipo_viagem);
    $('textarea[name="e_descricao"]').html(descricao);

    $('#editar').modal('show');
})
$('.btn_edit_status').click(function() {
    let status = $(this).attr('data-status');
    let descricao = $(this).attr('data-descricao');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_viagens/editar_status') ?>/" + id;
    $('#form_edit_status').attr('action', url);
    $('input[name="e_status"]').val(status);
    $('textarea[name="e_descricao"]').html(descricao);

    $('#editar').modal('show');
})
$('.btn_edit_estimativa').click(function() {
    let tipo_viagem = $(this).attr('data-tipo_viagem');
    let valor = $(this).attr('data-valor');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_viagens/editar_estimativa') ?>/" + id;
    $('#form_edit_estimativa').attr('action', url);
    $('select[name="e_tipo_viagem"]').val(tipo_viagem);
    $('input[name="e_valor"]').val(valor);

    $('#editar').modal('show');
})
$('.btn_edit_classificacao').click(function() {
    let classificacao = $(this).attr('data-classificacao');
    let descricao = $(this).attr('data-descricao');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_viagens/editar_classificacao') ?>/" + id;
    $('#form_edit_classificacao').attr('action', url);
    $('input[name="e_classificacao"]').val(classificacao);
    $('textarea[name="e_descricao"]').html(descricao);

    $('#editar').modal('show');
})
$('.btn_edit_tipo_comunicacao').click(function() {
    let tipo_comunicacao = $(this).attr('data-tipo_comunicacao');
    let descricao = $(this).attr('data-descricao');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_viagens/editar_tipo_comunicacao') ?>/" + id;
    $('#form_edit_tipo_comunicacao').attr('action', url);
    $('input[name="e_tipo_comunicacao"]').val(tipo_comunicacao);
    $('textarea[name="e_descricao"]').html(descricao);

    $('#editar').modal('show');
})
$('.btn_edit_categoria_despesa').click(function() {
    let categoria = $(this).attr('data-categoria');
    let descricao = $(this).attr('data-descricao');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_viagens/editar_categoria_despesa') ?>/" + id;
    $('#form_edit_categoria').attr('action', url);
    $('input[name="e_categoria"]').val(categoria);
    $('textarea[name="e_descricao"]').html(descricao);

    $('#editar').modal('show');
})
</script>