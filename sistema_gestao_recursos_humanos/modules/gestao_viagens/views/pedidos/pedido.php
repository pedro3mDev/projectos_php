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
                    Gestão de Viagens / Planeamento de Viagens / Visualizar
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
                                        aria-hidden="true"></i>Visualizar Planejamento
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="bold">Informação geral</h4>
                                <?php if ($pedido['status_id'] == 1) : ?>
                                <a href="<?php echo admin_url('gestao_viagens/pedidos/status_pedido_aprovar/'.$pedido['id']); ?>"
                                    class="btn btn-success text-white">
                                    Aprovar
                                </a>
                                <a onclick="return confirm('Tens certteza que desejas rejeitar este Pedido?');"
                                    href="<?php echo admin_url('gestao_viagens/pedidos/status_pedido_rejeitar/'.$pedido['id']); ?>"
                                    class="btn btn-danger text-white">
                                    Rejeitar
                                </a>
                                <?php endif ?>
                                <table class="table border table-striped ">
                                    <tbody>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Funcionários</td>
                                            <td>
                                                <?php
                                                if ($staffs == NULL) {
                                                    echo "<span class='text-danger'>Sem resultado.</span>";
                                                } else {
                                                    foreach ($staffs as $staff) {
                                                ?>
                                                <span><?php echo  $staff['firstname'] . ' ' . $staff['lastname']; ?></span>
                                                <br>
                                                <?php }
                                                } ?>
                                            </td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Tipo de Viagem</td>
                                            <td><?php echo $pedido['tipo_viagem'] ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Objetivo</td>
                                            <td><?php echo $pedido['objetivo'] ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Destino</td>
                                            <td><?php echo $pedido['destino'] ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Data Inicial</td>
                                            <td><?php echo $pedido['data_inicio'] ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Data Final</td>
                                            <td><?php echo $pedido['data_fim'] ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Estado de Aprovação</td>
                                            <td class="bold">
                                                <?php echo $pedido['status']; ?>
                                            </td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Estado</td>
                                            <td><?php echo $pedido['status'] ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Aprovadores</td>
                                            <td>
                                                <?php
                                                    $aprovadores = json_decode($pedido['aprovadores'] ?? '');
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