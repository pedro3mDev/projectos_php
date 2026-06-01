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
                    Gestão de Viagens / Despesas / Visualizar
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
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="no-margin font-bold"><i class="fa fa-address-card-o"
                                        aria-hidden="true"></i>Visualizar Despesa
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="bold">Informação geral</h4>
                                <?php if ($despesa['status_id'] == 1) : ?>
                                <a href="<?php echo admin_url('gestao_viagens/despesas/status_despesa_aprovar/'.$despesa['id']); ?>"
                                    class="btn btn-success text-white">
                                    Aprovar
                                </a>
                                <a onclick="return confirm('Tens certteza que desejas rejeitar este despesa?');"
                                    href="<?php echo admin_url('gestao_viagens/despesas/status_despesa_rejeitar/'.$despesa['id']); ?>"
                                    class="btn btn-danger text-white">
                                    Rejeitar
                                </a>
                                <?php endif ?>
                                <table class="table border table-striped ">
                                    <tbody>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Viagem</td>
                                            <td><?php echo $despesa['objetivo'] ?> (<?php echo $despesa['destino'] ?>)
                                            </td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Categoria</td>
                                            <td><?php echo $despesa['categoria'] ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Valor</td>
                                            <td><?php echo $despesa['valor'] ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Descrição</td>
                                            <td><?php echo $despesa['descricao'] ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Data Despesa</td>
                                            <td><?php echo $despesa['data_despesa'] ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%"><?php echo _l('Comprovativo'); ?></td>
                                            <td>
                                                <?php if (!empty($despesa['arquivo'])) : ?>
                                                <a target="_blank"
                                                    href="<?= base_url('modules/gestao_viagens/uploads/'.$despesa['arquivo']); ?>"><?= $despesa['arquivo']; ?></a>
                                                <?php else : ?>
                                                <span class="text-danger">Sem upload</span>
                                                <?php endif ?>
                                            </td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Estado de Aprovação</td>
                                            <td class="bold">
                                                <?php echo $despesa['status']; ?>
                                            </td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Aprovadores</td>
                                            <td>
                                                <?php
                                                    $aprovadores = json_decode($despesa['aprovadores'] ?? '');
                                                    foreach (($aprovadores ?? []) as $a) {
                                                        echo get_pl_staff_fullname($a);
                                                        echo '<br>';
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="btn-bottom-pusher"></div>
    </div>
</div>
<div id="new_version"></div>
<?php init_tail(); ?>
<?php require('modules/recruitment/assets/js/company_js.php'); ?>