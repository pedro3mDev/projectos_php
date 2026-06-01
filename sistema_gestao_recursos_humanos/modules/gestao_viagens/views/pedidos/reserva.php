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
                    Gestão de Viagens / Reserva de Viagens / Visualizar
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
                                        aria-hidden="true"></i>Visualizar Reserva
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">

                                <?php if ($reserva['status_id'] == 1) : ?>
                                <a href="<?php echo admin_url('gestao_viagens/pedidos/status_reserva_aprovar/'.$reserva['id']); ?>"
                                    class="text-white btn btn-success">
                                    Aprovar Reserva
                                </a>
                                <a onclick="return confirm('Tens certteza que desejas rejeitar este Pedido?');"
                                    href="<?php echo admin_url('gestao_viagens/pedidos/status_reserva_rejeitar/'.$reserva['id']); ?>"
                                    class="text-white btn btn-danger">
                                    Rejeitar Reserva
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

                                <h4 class="bold">Informação da Reserva</h4>
                                <?php $total = 0; ?>
                                <table class="table border table-striped ">
                                    <tbody>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%"><?php echo _l('Anexo de Visto'); ?></td>
                                            <td>
                                                <?php if (!empty($reserva['arquivo_visto'])) : ?>
                                                <a target="_blank"
                                                    href="<?= base_url('modules/gestao_viagens/uploads/'.$reserva['arquivo_visto']); ?>"><?= $reserva['arquivo_visto']; ?></a>
                                                <?php else : ?>
                                                <span class="text-danger">Sem upload</span>
                                                <?php endif ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table border table-striped ">
                                    <tbody>
                                        <tr style="background-color: #333; color: #fff;">
                                            <th colspan="2">Voo</th>
                                        </tr>
                                        <?php if ($voo) : ?>
                                        <?php $total += $voo['preco']; ?>
                                        <tr>
                                            <td>Nome</td>
                                            <td><?= html_entity_decode($voo['nome']) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Descrição</td>
                                            <td><?= html_entity_decode($voo['descricao']) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Local de Partida</td>
                                            <td><?= html_entity_decode($voo['local_partida']) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Local de Destino</td>
                                            <td><?= html_entity_decode($voo['local_destino']) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Data de Partida</td>
                                            <td><?= html_entity_decode($voo['data_partida']) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Preço</td>
                                            <td><?= html_entity_decode($voo['preco']) ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Aprovadores</td>
                                            <td>
                                                <?php
                                                        $aprovadores = json_decode($voo['aprovadores'] ?? '');
                                                        foreach (($aprovadores ?? []) as $a) {
                                                            echo get_pl_staff_fullname($a);
                                                            echo '<br>';
                                                        }
                                                    ?>
                                            </td>
                                        </tr>
                                        <?php else : ?>
                                        <tr>
                                            <td colspan="2" class="text-danger">Sem Voo Cadastrado</td>
                                        </tr>
                                        <?php endif ?>
                                    </tbody>
                                    <tbody>
                                        <tr style="background-color: #333; color: #fff;">
                                            <th colspan="2">Hotel</th>
                                        </tr>
                                        <?php if ($hotel) : ?>
                                        <?php $total += $hotel['preco']; ?>
                                        <tr>
                                            <td>Nome</td>
                                            <td><?= html_entity_decode($hotel['nome']) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Descrição</td>
                                            <td><?= html_entity_decode($hotel['descricao']) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Endereço</td>
                                            <td><?= html_entity_decode($hotel['endereco']) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Data Checkin</td>
                                            <td><?= html_entity_decode($hotel['data_checkin']) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Data Checkout</td>
                                            <td><?= html_entity_decode($hotel['data_checkout']) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Preço</td>
                                            <td><?= html_entity_decode($hotel['preco']) ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Aprovadores</td>
                                            <td>
                                                <?php
                                                        $aprovadores = json_decode($hotel['aprovadores'] ?? '');
                                                        foreach (($aprovadores ?? []) as $a) {
                                                            echo get_pl_staff_fullname($a);
                                                            echo '<br>';
                                                        }
                                                    ?>
                                            </td>
                                        </tr>
                                        <?php else : ?>
                                        <tr>
                                            <td colspan="2" class="text-danger">Sem Hotel Cadastrado</td>
                                        </tr>
                                        <?php endif ?>
                                    </tbody>
                                    <tbody>
                                        <tr style="background-color: #333; color: #fff;">
                                            <th colspan="2">Transporte</th>
                                        </tr>
                                        <?php if ($transporte) : ?>
                                        <?php $total += $transporte['preco']; ?>
                                        <tr>
                                            <td>Nome</td>
                                            <td><?= html_entity_decode($transporte['nome']) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Descrição</td>
                                            <td><?= html_entity_decode($transporte['descricao']) ?></td>
                                        </tr>
                                        <tr>
                                            <td>Preço</td>
                                            <td><?= html_entity_decode($transporte['preco']) ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Aprovadores</td>
                                            <td>
                                                <?php
                                                        $aprovadores = json_decode($transporte['aprovadores'] ?? '');
                                                        foreach (($aprovadores ?? []) as $a) {
                                                            echo get_pl_staff_fullname($a);
                                                            echo '<br>';
                                                        }
                                                    ?>
                                            </td>
                                        </tr>
                                        <?php else : ?>
                                        <tr>
                                            <td colspan="2" class="text-danger">Sem Transporte Cadastrado</td>
                                        </tr>
                                        <?php endif ?>
                                    </tbody>
                                    <tbody>
                                        <tr style="background-color: #333; color: #fff;">
                                            <th colspan="2">Informação da Reserva</th>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Aprovadores da Reserva</td>
                                            <td>
                                                <?php
                                                        $aprovadores = json_decode($reserva['aprovadores'] ?? '');
                                                        foreach (($aprovadores ?? []) as $a) {
                                                            echo get_pl_staff_fullname($a);
                                                            echo '<br>';
                                                        }
                                                    ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Total de Reserva</td>
                                            <td><?= html_entity_decode($total) ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Estado</td>
                                            <td><?php echo $reserva['status'] ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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