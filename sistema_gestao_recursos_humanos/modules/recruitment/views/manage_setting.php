<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">

    <div class="content">
        <?php
      $data_view = [];
      $this->load->view('/admin/menu_modulo/menu', $data_view);
    ?>
        <div class="row">
            <div class="col-md-6">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Recrutamento e Selecção / Configurações
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
      foreach($tab as $group){

        ?>
                    <li<?php if($i == 0){echo " class='active'"; } ?>>
                        <a href="<?php echo admin_url('recruitment/setting?group='.$group); ?>"
                            data-group="<?php echo html_entity_decode($group); ?>">
                            <?php echo _l($group); ?></a>
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
if ($('select[name="criteria_type"]').val() == 'criteria') {
    $('select[name="group_criteria"]').attr('required', '');
    $('#select_group_criteria').removeClass('hide');
} else {
    $('select[name="group_criteria"]').removeAttr('required');
    $('#select_group_criteria').addClass('hide');
}

$('.btn_edit_motivo').click(function() {
    let motivo = $(this).attr('data-motivo');
    let descricao = $(this).attr('data-descricao');
    let id = $(this).attr('data-id');

    let url = "<?= admin_url('recruitment/editar_motivo') ?>/" + id;
    $('#form_edit_motivo').attr('action', url);
    $('input[name="e_motivo"]').val(motivo);
    $('textarea[name="e_descricao"]').html(descricao);

    $('#editar').modal('show');
})
</script>
</body>

</html>