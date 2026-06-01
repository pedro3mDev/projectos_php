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
                                href="<?php echo admin_url('politicas_empresa/listagem'); ?>"><?php echo _l('pe_politica'); ?></a>
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
            <div class="col-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="bold">Informação Geral</h4>
                                <?php if ($politica['status'] == 'pendente') : ?>
                                <a href="<?php echo admin_url('politicas_empresa/status_aprovar/'.$politica['id']); ?>"
                                    class="btn btn-success">Aprovar</a>
                                <a href="<?php echo admin_url('politicas_empresa/status_rejeitar/'.$politica['id']); ?>"
                                    class="btn btn-danger">Rejeitar</a>
                                <?php else : ?>
                                <?php
                                    if($politica['status'] == 'aprovado') {
                                        echo '<b class="text-success">Aprovado</b>';
                                    }
                                    else if ($politica['status'] == 'rejeitado') {
                                        echo '<b class="text-danger">Rejeitar</b>';
                                    }
                                    else {
                                        echo '<b class="text-dark">'.$politica['status'].'</b>';
                                    }
                                ?>
                                <?php endif ?>
                                <table class="table border table-striped ">
                                    <tbody>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%"><?php echo _l('title'); ?></td>
                                            <td><?php echo $politica['titulo']; ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%"><?php echo _l('tipo_politica'); ?></td>
                                            <td><?php echo $politica['tipo_politica']; ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%"><?php echo _l('categoria'); ?></td>
                                            <td><?php echo $politica['categoria']; ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%"><?php echo _l('conselho'); ?> </td>
                                            <td><?php echo $politica['conselho'] ?? ''; ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%"><?php echo _l('Pedorio'); ?> </td>
                                            <td><?php echo $politica['pelorio'] ?? ''; ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%"><?php echo _l('Direção'); ?> </td>
                                            <td><?php echo $politica['direcao'] ?? ''; ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%"><?php echo _l('Departamento'); ?> </td>
                                            <td><?php echo $politica['departamento'] ?? ''; ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%"><?php echo _l('Secção'); ?> </td>
                                            <td><?php echo $politica['seccao'] ?? ''; ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%"><?php echo _l('status'); ?></td>
                                            <td><?php echo $politica['status']; ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%"><?php echo _l('description'); ?></td>
                                            <td><?php echo $politica['descricao']; ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%"><?php echo _l('Anexo'); ?></td>
                                            <td>
                                                <?php if (!empty($politica['arquivo'])) : ?>
                                                <a target="_blank"
                                                    href="<?= base_url('modules/politicas_empresa/uploads/'.$politica['arquivo']); ?>"><?= $politica['arquivo']; ?></a>
                                                <?php else : ?>
                                                <span class="text-danger">Sem upload</span>
                                                <?php endif ?>
                                            </td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Aprovadores</td>
                                            <td>
                                                <?php
                                                    $aprovadores = json_decode($politica['aprovadores'] ?? '');
                                                    foreach (($aprovadores ?? []) as $a) {
                                                        echo get_pl_staff_fullname($a);
                                                        echo '<br>';
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Criado Por</td>
                                            <td><?php echo $politica['firstname'] .' '. $politica['lastname']; ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Criado em</td>
                                            <td><?php echo $politica['created_at']; ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Ultima actualização em</td>
                                            <td><?php echo $politica['updated_at']; ?></td>
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