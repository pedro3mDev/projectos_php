<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">

    <div class="content">
    </br></br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-6">
                <a class="dashboard-link" href=""
                    style="font-size: 16px; color: #333;">
                    Politicas de Empresa / Processos / Visualizar 
                </a>
            </div>
            <div class="col-md-6"
                style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;"
                    class="btn ms-2" onclick="window.history.back()">
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
                                <?php if ($processo['status'] == 'pendente') : ?>
                                <a href="<?php echo admin_url('politicas_empresa/processos/status_aprovar/'.$processo['id']); ?>"
                                    class="btn btn-success">Aprovar</a>
                                <a href="<?php echo admin_url('politicas_empresa/processos/status_rejeitar/'.$processo['id']); ?>"
                                    class="btn btn-danger">Rejeitar</a>
                                <?php else : ?>
                                <?php
                                    if($processo['status'] == 'aprovado') {
                                        echo '<b class="text-success">Aprovado</b>';
                                    }
                                    else if ($processo['status'] == 'rejeitado') {
                                        echo '<b class="text-danger">Rejeitar</b>';
                                    }
                                    else {
                                        echo '<b class="text-dark">'.$processo['status'].'</b>';
                                    }
                                ?>
                                <?php endif ?>
                                <table class="table border table-striped ">
                                    <tbody>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%"><?php echo _l('staff'); ?></td>
                                            <td><?php echo $processo['firstname_c'] .' '. $processo['lastname_c']; ?>
                                            </td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%"><?php echo _l('title'); ?></td>
                                            <td><?php echo $processo['titulo']; ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%"><?php echo _l('pe_politica'); ?></td>
                                            <td><?php echo $processo['politica']; ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%"><?php echo _l('decription'); ?></td>
                                            <td><?php echo $processo['descricao']; ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%"><?php echo _l('pe_data_verificacao'); ?> </td>
                                            <td><?php echo $processo['data_verificacao']; ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%"><?php echo _l('status'); ?></td>
                                            <td><?php echo $processo['status']; ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%"><?php echo _l('Anexo'); ?></td>
                                            <td>
                                                <?php if (!empty($processo['arquivo'])) : ?>
                                                <a target="_blank"
                                                    href="<?= base_url('modules/politicas_empresa/uploads/'.$processo['arquivo']); ?>"><?= $processo['arquivo']; ?></a>
                                                <?php else : ?>
                                                <span class="text-danger">Sem upload</span>
                                                <?php endif ?>
                                            </td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Aprovadores</td>
                                            <td>
                                                <?php
                                                    $aprovadores = json_decode($processo['aprovadores'] ?? '');
                                                    foreach (($aprovadores ?? []) as $a) {
                                                        echo get_pl_staff_fullname($a);
                                                        echo '<br>';
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Criado Por</td>
                                            <td><?php echo $processo['firstname'] .' '. $processo['lastname']; ?>
                                            </td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Criado em</td>
                                            <td><?php echo $processo['created_at']; ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Ultima actualização em</td>
                                            <td><?php echo $processo['updated_at']; ?></td>
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