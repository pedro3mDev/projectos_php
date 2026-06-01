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
                        <li class="breadcrumb-item"><a style="color:#333; font-size:16px;"
                                href="<?php echo admin_url('politicas_empresa/conformidades'); ?>"><?php echo _l('pe_conformidades'); ?></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <a style="color:#333; font-size:16px;" href="">
                                <?= $title ?>
                                (<?php echo $conformidade['firstname_c'] .' '. $conformidade['lastname_c']; ?>)
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
            <div class="col-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="bold">Informação Geral</h4>
                                <?php if ($conformidade['status'] == 'pendente') : ?>
                                <a href="<?php echo admin_url('politicas_empresa/conformidades/status_aprovar/'.$conformidade['id']); ?>"
                                    class="btn btn-success">Aprovar</a>
                                <a href="<?php echo admin_url('politicas_empresa/conformidades/status_rejeitar/'.$conformidade['id']); ?>"
                                    class="btn btn-danger">Rejeitar</a>
                                <?php else : ?>
                                <?php
                                    if($conformidade['status'] == 'aprovado') {
                                        echo '<b class="text-success">Aprovado</b>';
                                    }
                                    else if ($conformidade['status'] == 'rejeitado') {
                                        echo '<b class="text-danger">Rejeitar</b>';
                                    }
                                    else {
                                        echo '<b class="text-dark">'.$conformidade['status'].'</b>';
                                    }
                                ?>
                                <?php endif ?>
                                <table class="table border table-striped ">
                                    <tbody>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%"><?php echo _l('staff'); ?></td>
                                            <td><?php echo $conformidade['firstname_c'] .' '. $conformidade['lastname_c']; ?>
                                            </td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%"><?php echo _l('pe_politica'); ?></td>
                                            <td><?php echo $conformidade['titulo']; ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%"><?php echo _l('pe_observacao'); ?></td>
                                            <td><?php echo $conformidade['observacao']; ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%"><?php echo _l('pe_data_verificacao'); ?> </td>
                                            <td><?php echo $conformidade['data_verificacao']; ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%"><?php echo _l('status'); ?></td>
                                            <td><?php echo $conformidade['status']; ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%"><?php echo _l('Anexo'); ?></td>
                                            <td>
                                                <?php if (!empty($conformidade['arquivo'])) : ?>
                                                <a target="_blank"
                                                    href="<?= base_url('modules/politicas_empresa/uploads/'.$conformidade['arquivo']); ?>"><?= $conformidade['arquivo']; ?></a>
                                                <?php else : ?>
                                                <span class="text-danger">Sem upload</span>
                                                <?php endif ?>
                                            </td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Aprovadores</td>
                                            <td>
                                                <?php
                                                    $aprovadores = json_decode($conformidade['aprovadores'] ?? '');
                                                    foreach (($aprovadores ?? []) as $a) {
                                                        echo get_pl_staff_fullname($a);
                                                        echo '<br>';
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Criado Por</td>
                                            <td><?php echo $conformidade['firstname'] .' '. $conformidade['lastname']; ?>
                                            </td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Criado em</td>
                                            <td><?php echo $conformidade['created_at']; ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Ultima actualização em</td>
                                            <td><?php echo $conformidade['updated_at']; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="btn-bottom-pusher"></div>
    </div>
</div>
<div id="new_version"></div>

<?php init_tail(); ?>
<?php require('modules/politicas_empresa/assets/js/company_js.php'); ?>
</body>

</html>