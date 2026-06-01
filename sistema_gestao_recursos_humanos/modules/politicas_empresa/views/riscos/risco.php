<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">

    <div class="content">
    </br></br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-6">
                <a class="dashboard-link" href=""
                    style="font-size: 16px; color: #333;">
                    Politicas de Empresa / Riscos / Visualizar 
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
            <div class="panel_s">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="bold">Informação Geral</h4>
                            <?php if ($risco['status'] == 'pendente') : ?>
                            <a href="<?php echo admin_url('politicas_empresa/riscos/status_aprovar/'.$risco['id']); ?>"
                                class="btn btn-success">Aprovar</a>
                            <a href="<?php echo admin_url('politicas_empresa/riscos/status_rejeitar/'.$risco['id']); ?>"
                                class="btn btn-danger">Rejeitar</a>
                            <?php else : ?>
                            <?php
                                if($risco['status'] == 'aprovado') {
                                    echo '<b class="text-success">Aprovado</b>';
                                }
                                else if ($risco['status'] == 'rejeitado') {
                                    echo '<b class="text-danger">Rejeitar</b>';
                                }
                                else {
                                    echo '<b class="text-dark">'.$risco['status'].'</b>';
                                }
                            ?>
                            <?php endif ?>
                            <table class="table border table-striped ">
                                <tbody>
                                    <tr class="project-overview">
                                        <td class="bold" width="40%"><?php echo _l('pe_politica'); ?></td>
                                        <td><?php echo $risco['titulo']; ?></td>
                                    </tr>
                                    <tr class="project-overview">
                                        <td class="bold" width="40%"><?php echo _l('impacto'); ?></td>
                                        <td><?php echo $risco['impacto']; ?></td>
                                    </tr>
                                    <tr class="project-overview">
                                        <td class="bold" width="40%"><?php echo _l('Probabilidade'); ?></td>
                                        <td><?php echo $risco['descricao_p']; ?></td>
                                    </tr>
                                    <tr class="project-overview">
                                        <td class="bold" width="40%"><?php echo _l('nivel_risco'); ?></td>
                                        <td><?php echo $risco['nivel_risco']; ?></td>
                                    </tr>
                                    <tr class="project-overview">
                                        <td class="bold" width="40%"><?php echo _l('Medidas de Metigação'); ?></td>
                                        <td><?php echo $risco['medidas_metigacao']; ?></td>
                                    </tr>
                                    <tr class="project-overview">
                                        <td class="bold" width="40%"><?php echo _l('description'); ?></td>
                                        <td><?php echo $risco['descricao']; ?></td>
                                    </tr>
                                    <tr class="project-overview">
                                        <td class="bold" width="40%"><?php echo _l('Anexo'); ?></td>
                                        <td>
                                            <?php if (!empty($risco['arquivo'])) : ?>
                                            <a target="_blank"
                                                href="<?= base_url('modules/politicas_empresa/uploads/'.$risco['arquivo']); ?>"><?= $risco['arquivo']; ?></a>
                                            <?php else : ?>
                                            <span class="text-danger">Sem upload</span>
                                            <?php endif ?>
                                        </td>
                                    </tr>
                                    <tr class="project-overview">
                                        <td class="bold" width="40%">Aprovadores</td>
                                        <td>
                                            <?php
                                                $aprovadores = json_decode($risco['aprovadores'] ?? '');
                                                foreach (($aprovadores ?? []) as $a) {
                                                    echo get_pl_staff_fullname($a);
                                                    echo '<br>';
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr class="project-overview">
                                        <td class="bold" width="40%">Criado Por</td>
                                        <td><?php echo $risco['firstname'] .' '. $risco['lastname']; ?></td>
                                    </tr>
                                    <tr class="project-overview">
                                        <td class="bold" width="40%">Criado em</td>
                                        <td><?php echo $risco['created_at']; ?></td>
                                    </tr>
                                    <tr class="project-overview">
                                        <td class="bold" width="40%">Ultima actualização em</td>
                                        <td><?php echo $risco['updated_at']; ?></td>
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