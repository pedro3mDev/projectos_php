<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">

    <div class="content">
    </br></br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-6">
                <a class="dashboard-link" href=""
                    style="font-size: 16px; color: #333;">
                    Politicas de Empresa / Comunicações / Visualizar
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

        </br>

        <div class="row">
            <div class="col-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="bold">Informação Geral</h4>
                                <?php if ($comunicacao['status'] == 'pendente') : ?>
                                <a href="<?php echo admin_url('politicas_empresa/comunicacoes/status_aprovar/'.$comunicacao['id']); ?>"
                                    class="btn btn-success">Aprovar</a>
                                <a href="<?php echo admin_url('politicas_empresa/comunicacoes/status_rejeitar/'.$comunicacao['id']); ?>"
                                    class="btn btn-danger">Rejeitar</a>
                                <?php else : ?>
                                <?php
                                    if($comunicacao['status'] == 'aprovado') {
                                        echo '<b class="text-success">Aprovado</b>';
                                    }
                                    else if ($comunicacao['status'] == 'rejeitado') {
                                        echo '<b class="text-danger">Rejeitar</b>';
                                    }
                                    else {
                                        echo '<b class="text-dark">'.$comunicacao['status'].'</b>';
                                    }
                                ?>
                                <?php endif ?>
                                <table class="table border table-striped ">
                                    <tbody>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%"><?php echo _l('staff'); ?></td>
                                            <td><?php echo $comunicacao['firstname_c'] .' '. $comunicacao['lastname_c']; ?>
                                            </td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%"><?php echo _l('pe_politica'); ?></td>
                                            <td><?php echo $comunicacao['titulo']; ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%"><?php echo _l('pe_data_verificacao'); ?> </td>
                                            <td><?php echo $comunicacao['data_verificacao']; ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%"><?php echo _l('status'); ?></td>
                                            <td><?php echo $comunicacao['status']; ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%"><?php echo _l('Anexo'); ?></td>
                                            <td>
                                                <?php if (!empty($comunicacao['arquivo'])) : ?>
                                                <a target="_blank"
                                                    href="<?= base_url('modules/politicas_empresa/uploads/'.$comunicacao['arquivo']); ?>"><?= $comunicacao['arquivo']; ?></a>
                                                <?php else : ?>
                                                <span class="text-danger">Sem upload</span>
                                                <?php endif ?>
                                            </td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Aprovadores</td>
                                            <td>
                                                <?php
                                                    $aprovadores = json_decode($comunicacao['aprovadores'] ?? '');
                                                    foreach (($aprovadores ?? []) as $a) {
                                                        echo get_pl_staff_fullname($a);
                                                        echo '<br>';
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Criado Por</td>
                                            <td><?php echo $comunicacao['firstname'] .' '. $comunicacao['lastname']; ?>
                                            </td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Criado em</td>
                                            <td><?php echo $comunicacao['created_at']; ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Ultima actualização em</td>
                                            <td><?php echo $comunicacao['updated_at']; ?></td>
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