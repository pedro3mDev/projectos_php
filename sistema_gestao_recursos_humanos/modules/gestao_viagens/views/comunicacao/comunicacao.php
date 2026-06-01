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
                    Gestão de Viagens / Comunicação / Visualizar
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
                                        aria-hidden="true"></i>Visualizar Comunicação
                                </h4>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="bold">Informação geral</h4>
                                <a href="<?php echo admin_url('gestao_viagens/comunicacao/enviar_email/'.$comunicacao['id']); ?>"
                                    class="btn btn-success text-white">
                                    Enviar Email
                                </a>
                                <table class="table border table-striped ">
                                    <tbody>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Viagem</td>
                                            <td><?php echo $comunicacao['objetivo']; ?>
                                                (<?php echo $comunicacao['destino']; ?>)
                                            </td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Tipo de Comunicação</td>
                                            <td><?php echo $comunicacao['tipo_comunicacao']; ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Funcionários</td>
                                            <td><?php echo nome_funcinario_comunicacao($comunicacao['id']); ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Mensagem</td>
                                            <td><?php echo $comunicacao['mensagem']; ?></td>
                                        </tr>
                                        <tr class="project-overview">
                                            <td class="bold" width="40%">Data de Envio</td>
                                            <td><?php echo $comunicacao['data_envio']; ?></td>
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