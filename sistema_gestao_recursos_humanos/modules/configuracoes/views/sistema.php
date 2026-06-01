<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<link rel="stylesheet" href="<?php echo base_url('assets/css/configuracoes/politicas.css'); ?>">

<div id="wrapper">

    <div class="content">

        <?php
            $data_view = [];
            $this->load->view('/admin/menu_modulo/menu', $data_view);
        ?>
        <div class="row">
            <div class="col-md-6">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Configurações do Sistema
                </a>
            </div>
            <div class="col-md-6" style=" display: flex; justify-content: flex-end; align-items: center;">
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
                        <a href="<?php echo admin_url('configuracoes/sistema?group='.$g); ?>"
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
<?php
$viewuri = $_SERVER['REQUEST_URI'];
$config_mod = 1;

require('modules/hr_profile/assets/js/setting/manage_setting_js.php');
require('modules/hr_profile/assets/js/setting/hr_profile_permissions_js.php');
require 'modules/hr_profile/assets/js/setting/reset_data_js.php';?>
<script>
$('.btn_edit_conselho').click(function() {
    let conselho = $(this).attr('data-conselho');
    let responsavel = $(this).attr('data-responsavel');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('configuracoes/editar_conselho') ?>/" + id;
    $('#form_edit_conselho').attr('action', url);
    $('select[name="e_staff"]').selectpicker('val', responsavel);
    $('input[name="e_conselho"]').val(conselho);

    $('#editar').modal('show');
})

$('.btn_edit_pelorio').click(function() {
    let pelorio = $(this).attr('data-pelorio');
    let conselho = $(this).attr('data-conselho');
    let id = $(this).attr('data-id');
    let responsavel = $(this).attr('data-responsavel');

    let url = "<?= admin_url('configuracoes/editar_pelorio') ?>/" + id;
    $('#form_edit_pelorio').attr('action', url);
    $('select[name="e_conselho"]').val(conselho);
    $('input[name="e_pelorio"]').val(pelorio);
    $('select[name="e_staff"]').selectpicker('val', responsavel);

    $('#editar').modal('show');
})

$('.btn_edit_direcao').click(function() {
    let direcao = $(this).attr('data-direcao');
    let pelorio = $(this).attr('data-pelorio');
    let id = $(this).attr('data-id');
    let responsavel = $(this).attr('data-responsavel');

    let url = "<?= admin_url('configuracoes/editar_direcao') ?>/" + id;
    $('#form_edit_direcao').attr('action', url);
    $('select[name="e_pelorio"]').val(pelorio);
    $('input[name="e_direcao"]').val(direcao);
    $('select[name="e_staff"]').selectpicker('val', responsavel);

    $('#editar').modal('show');
})

$('.btn_edit_departamento').click(function() {
    let departamento = $(this).attr('data-departamento');
    let direcao = $(this).attr('data-direcao');
    let id = $(this).attr('data-id');
    let responsavel = $(this).attr('data-responsavel');

    let url = "<?= admin_url('configuracoes/editar_departamento') ?>/" + id;
    $('#form_edit_departamento').attr('action', url);
    $('select[name="e_direcao"]').val(direcao);
    $('input[name="e_departamento"]').val(departamento);
    $('select[name="e_staff"]').selectpicker('val', responsavel);

    $('#editar').modal('show');
})

$('.btn_edit_seccao').click(function() {
    let departamento = $(this).attr('data-departamento');
    let seccao = $(this).attr('data-seccao');
    let id = $(this).attr('data-id');
    let responsavel = $(this).attr('data-responsavel');

    let url = "<?= admin_url('configuracoes/editar_seccao') ?>/" + id;
    $('#form_edit_seccao').attr('action', url);
    $('select[name="e_departamento"]').val(departamento);
    $('input[name="e_seccao"]').val(seccao);
    $('select[name="e_staff"]').selectpicker('val', responsavel);

    $('#editar').modal('show');
})
</script>
</body>

</html>