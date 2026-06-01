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
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Remoneração / configurações
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
                    foreach ($tab as $g) {
                        ?>
                        <?php if ($g == 'feedback'): ?>
                            <li <?php if ($g == $group) {
                                echo " class='active'";
                            } ?>>
                                <a href="<?php echo admin_url('gestao_remuneracao/configuracoes?group=' . $g); ?>"
                                    data-group="<?php echo html_entity_decode($g); ?>">
                                    <?php echo _l('Feedback'); ?></a>
                            </li>
                        <?php else: ?>
                            <li <?php if ($g == $group) {
                                echo " class='active'";
                            } ?>>
                                <a href="<?php echo admin_url('gestao_remuneracao/configuracoes?group=' . $g); ?>"
                                    data-group="<?php echo html_entity_decode($g); ?>">
                                    <?php echo _l($g); ?></a>
                            </li>
                        <?php endif ?>
                        <?php $i++;
                    } ?>
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
    $('.btn_edit_tipo_categoria').click(function () {
        let id = $(this).attr('data-id');
        let descricao = $(this).attr('data-descricao');
        let tipo_categoria = $(this).attr('data-tipo_categoria');
        let url = "<?= admin_url('gestao_remuneracao/editar_tipo_categoria') ?>/" + id;
        $('#form_edit_tipo_categoria').attr('action', url)
        $('input[name="e_tipo_categoria"]').val(tipo_categoria)
        $('textarea[name="e_descricao"]').text(descricao)
        $('#editar').modal('show')
    })

    $('.btn_edit_banco').click(function () {
        let id = $(this).attr('data-id');
        let descricao = $(this).attr('data-descricao');
        let banco = $(this).attr('data-banco');
        let url = "<?= admin_url('gestao_remuneracao/editar_banco') ?>/" + id;
        $('#form_edit_banco').attr('action', url)
        $('input[name="e_banco"]').val(banco)
        $('textarea[name="e_descricao"]').text(descricao)
        $('#editar').modal('show')
    })
</script>