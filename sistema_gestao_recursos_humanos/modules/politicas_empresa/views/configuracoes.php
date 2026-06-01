<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">

    <div class="content">
        <?php
      $data_view = [];
      $this->load->view('/admin/menu_modulo/menu', $data_view);
    ?>
        <div class="row">
            <div class="col-md-10">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a style="color:#333; font-size:16px;"
                                href="<?php echo admin_url('politicas_empresa/'); ?>"><?php echo _l('pe_politica_empresa'); ?></a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            <a style="color:#333; font-size:16px;" href="">
                                <?php echo _l('pe_configuracoes'); ?>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <a style="color:#333; font-size:16px;" href="">
                                <?= $title ?>
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-2" style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
            </div>
        </div>

        </br>

        <div class="row">
            <div class="col-md-3">
                <ul class="nav navbar-pills navbar-pills-flat nav-tabs nav-stacked"
                    style="border-left: 3px solid #8B0000;">
                    <?php
                      $i = 0;
                      foreach($tab as $g){
                    ?>
                    <li<?php if($g == $group){echo " class='active'"; } ?>>
                        <a href="<?php echo admin_url('politicas_empresa/configuracoes?group='.$g); ?>"
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
        <div class="btn-bottom-pusher"></div>
    </div>
</div>
<div id="new_version"></div>
<?php init_tail(); ?>
<?php require('modules/politicas_empresa/assets/js/company_js.php'); ?>


<script>
if ($('select[name="criteria_type"]').val() == 'criteria') {
    $('select[name="group_criteria"]').attr('required', '');
    $('#select_group_criteria').removeClass('hide');
} else {
    $('select[name="group_criteria"]').removeAttr('required');
    $('#select_group_criteria').addClass('hide');
}


$('.btn_edit_politica').click(function() {
    let tipo_politica = $(this).attr('data-tipo_politica');
    let descricao = $(this).attr('data-descricao');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('politicas_empresa/editar_tipo_politica') ?>/" + id;
    $('#form_edit_tipo_politica').attr('action', url);
    $('input[name="e_tipo_politica"]').val(tipo_politica);
    $('textarea[name="e_descricao"]').html(descricao);

    $('#editar').modal('show');
})
$('.btn_edit_categoria').click(function() {
    let categoria = $(this).attr('data-categoria');
    let descricao = $(this).attr('data-descricao');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('politicas_empresa/editar_categoria') ?>/" + id;
    $('#form_edit_categoria').attr('action', url);
    $('input[name="e_categoria"]').val(categoria);
    $('textarea[name="e_descricao"]').html(descricao);

    $('#editar').modal('show');
})
$('.btn_edit_area').click(function() {
    let area = $(this).attr('data-area');
    let descricao = $(this).attr('data-descricao');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('politicas_empresa/editar_area') ?>/" + id;
    $('#form_edit_area').attr('action', url);
    $('input[name="e_area"]').val(area);
    $('textarea[name="e_descricao"]').html(descricao);

    $('#editar').modal('show');
})
$('.btn_edit_status').click(function() {
    let status = $(this).attr('data-status');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('politicas_empresa/editar_status') ?>/" + id;
    $('#form_edit_status').attr('action', url);
    $('input[name="e_status"]').val(status);

    $('#editar').modal('show');
})
$('.btn_edit_nivel_hierarquico').click(function() {
    let nivel_hierarquico = $(this).attr('data-nivel_hierarquico');
    let descricao = $(this).attr('data-descricao');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('politicas_empresa/editar_nivel_hierarquico') ?>/" + id;
    $('#form_edit_nivel_hierarquico').attr('action', url);
    $('input[name="e_nivel_hierarquico"]').val(nivel_hierarquico);
    $('textarea[name="e_descricao"]').html(descricao);

    $('#editar').modal('show');
})
$('.btn_edit_impacto').click(function() {
    let impacto = $(this).attr('data-impacto');
    let descricao = $(this).attr('data-descricao');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('politicas_empresa/editar_impacto') ?>/" + id;
    $('#form_edit_impacto').attr('action', url);
    $('input[name="e_impacto"]').val(impacto);
    $('textarea[name="e_descricao"]').html(descricao);

    $('#editar').modal('show');
})
$('.btn_edit_tipo_procedimento').click(function() {
    let tipo_procedimento = $(this).attr('data-tipo_procedimento');
    let descricao = $(this).attr('data-descricao');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('politicas_empresa/editar_tipo_procedimento') ?>/" + id;
    $('#form_edit_tipo_procedimento').attr('action', url);
    $('input[name="e_tipo_procedimento"]').val(tipo_procedimento);
    $('textarea[name="e_descricao"]').html(descricao);

    $('#editar').modal('show');
})

$('.btn_edit_conselho').click(function() {
    let conselho = $(this).attr('data-conselho');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('politicas_empresa/editar_conselho') ?>/" + id;
    $('#form_edit_conselho').attr('action', url);
    $('input[name="e_conselho"]').val(conselho);

    $('#editar').modal('show');
})

$('.btn_edit_pelorio').click(function() {
    let pelorio = $(this).attr('data-pelorio');
    let conselho = $(this).attr('data-conselho');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('politicas_empresa/editar_pelorio') ?>/" + id;
    $('#form_edit_pelorio').attr('action', url);
    $('select[name="e_conselho"]').val(conselho);
    $('input[name="e_pelorio"]').val(pelorio);

    $('#editar').modal('show');
})

$('.btn_edit_direcao').click(function() {
    let direcao = $(this).attr('data-direcao');
    let pelorio = $(this).attr('data-pelorio');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('politicas_empresa/editar_direcao') ?>/" + id;
    $('#form_edit_direcao').attr('action', url);
    $('select[name="e_pelorio"]').val(pelorio);
    $('input[name="e_direcao"]').val(direcao);

    $('#editar').modal('show');
})

$('.btn_edit_departamento').click(function() {
    let departamento = $(this).attr('data-departamento');
    let direcao = $(this).attr('data-direcao');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('politicas_empresa/editar_departamento') ?>/" + id;
    $('#form_edit_departamento').attr('action', url);
    $('select[name="e_direcao"]').val(direcao);
    $('input[name="e_departamento"]').val(departamento);

    $('#editar').modal('show');
})

$('.btn_edit_seccao').click(function() {
    let departamento = $(this).attr('data-departamento');
    let seccao = $(this).attr('data-seccao');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('politicas_empresa/editar_seccao') ?>/" + id;
    $('#form_edit_seccao').attr('action', url);
    $('select[name="e_departamento"]').val(departamento);
    $('input[name="e_seccao"]').val(seccao);

    $('#editar').modal('show');
})
</script>
</body>

</html>