<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">

        </br></br></br></br></br></br>
        <div class="row">
            <div class="col-md-6">
                <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                    Gestão de Viagens / Reservas de Viagens
                </a>
            </div>
            <div class="col-md-6" style=" display: flex; justify-content: flex-end; align-items: center;">
                <button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
                    <i class="fas fa-reply"></i> Retroceder
                </button>
            </div>
        </div>

        
        </br>
        <?php require 'modules/gestao_viagens/views/reservas/cards.php'; ?>

        
        <div class="col-12">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav navbar-pills navbar-pills-flat nav-tabs">
                        <?php
                            $i = 0;
                            foreach($tab as $group_item) {
                        ?>
                        <li <?php if($group_item == $group){echo " class='active'"; } ?>>
                            <a href="<?php echo admin_url('gestao_viagens/pedidos/reservas/?group='.$group_item); ?>"
                                style="text-decoration:none; text-transform:capitalize;">
                                <?php
                                    if($group_item == 'solicitar_ferias'){
                                        echo '<i class="fa fa-plus"></i>' . _l(' Solicitar Férias');
                                    }elseif($group_item == 'funcionarios_em_ferias'){
                                        echo '<i class="fa fa-users"></i>' ._l(' Funcionários em Férias');
                                        }elseif($group_item == 'criacao_turnos'){
                                        echo '<i class="fa fa-plus"></i>' ._l(' Solicitar Férias');
                                    }else{
                                        echo _l($group_item);
                                    }
                                ?>
                                </button>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                    <style>
                    .nav-tabs {
                        display: flex;
                        justify-content: flex-start;
                        /* Alinha à esquerda, ajuste para 'center' ou 'space-between' se necessário */
                        list-style: none;
                        padding: 0;
                        margin: 0;
                    }

                    .nav-tabs li {
                        margin-right: 10px;
                        /* Espaçamento entre os itens */
                    }

                    .nav-tabs li a {
                        display: block;
                        padding: 10px 15px;
                        text-decoration: none;
                        color: #333;
                        /* Cor do link */
                    }

                    .nav-tabs li a:hover {
                        display: block;
                        padding: 10px 15px;
                        text-decoration: none;
                        background-color: #336;
                        color: #fff;
                        /* Cor do link */
                    }

                    .nav-tabs li.active a {
                        color: #fff;
                        background-color: #8B0000;
                        border-radius: 4px;
                    }
                    </style>
                </div>
                <br><br><br>
            </div>
        </div>

        <?php $this->load->view($tabs['view']); ?>

    </div>
</div>
<div class="clearfix"></div>
</div>
<?php echo form_close(); ?>
<div class="btn-bottom-pusher"></div>
</div>
</div>
<div id="new_version"></div>
<?php init_tail(); ?>

<style>
/* Estilo do cabeçalho da tabela */
.thead-custom {
    background-color: #f4f4f4;
    /* Fundo cinza claro */
    color: rgba(51, 51, 51, 0.8);
    /* Texto com transparência */
    font-weight: bold;
    text-align: left;
    border-bottom: 1px solid #ccc;
    /* Linha separadora */
}
</style>

<?php require('modules/recruitment/assets/js/company_js.php'); ?>
<script>
$('.btn_edit_pedido').click(function() {
    let funcionarios = $(this).attr('data-funcionarios');
    let tipo_viagem = $(this).attr('data-tipo_viagem');
    let categoria = $(this).attr('data-categoria');
    let objectivo = $(this).attr('data-objectivo');
    let destino = $(this).attr('data-destino');
    let data_inicio = $(this).attr('data-data_inicio');
    let data_fim = $(this).attr('data-data_fim');
    let aprovadores = $(this).attr('data-aprovadores');

    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_viagens/pedidos/editar_pedido') ?>/" + id;
    $('#form_edit_pedido').attr('action', url);

    $('select[name="funcionarios_e[]"]').val(JSON.parse(funcionarios));
    $('select[name="tipo_viagem_e"]').val(1);
    $('select[name="categoria_e"]').val(categoria);
    $('textarea[name="objetivo_e"]').text(objectivo);
    $('input[name="destino_e"]').val(destino);
    $('input[name="data_inicio_e"]').val(data_inicio);
    $('input[name="data_fim_e"]').val(data_fim);
    $('select[name="aprovadores_e[]"]').val(JSON.parse(aprovadores));

    $('#editar').modal('show');
})

$('.btn_edit_voo').click(function() {
    let nome = $(this).attr('data-nome');
    let descricao = $(this).attr('data-descricao');
    let local_partida = $(this).attr('data-local_partida');
    let local_destino = $(this).attr('data-local_destino');
    let data_partida = $(this).attr('data-data_partida');
    let preco = $(this).attr('data-preco');
    let aprovadores = $(this).attr('data-aprovadores');

    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_viagens/pedidos/editar_voo') ?>/" + id;
    $('#form_edit_voo').attr('action', url);

    $('input[name="nome_e"]').val(nome);
    $('textarea[name="descricao_e"]').text(descricao);
    $('input[name="local_partida_e"]').val(local_partida);
    $('input[name="local_destino_e"]').val(local_destino);
    $('input[name="data_partida_e"]').val(data_partida);
    $('input[name="preco_e"]').val(preco);
    $('select[name="aprovadores_e[]"]').val(JSON.parse(aprovadores));

    $('#editar').modal('show');
})

$('.btn_edit_hotel').click(function() {
    let nome = $(this).attr('data-nome');
    let descricao = $(this).attr('data-descricao');
    let endereco = $(this).attr('data-endereco');
    let data_checkin = $(this).attr('data-data_checkin');
    let data_checkout = $(this).attr('data-data_checkout');
    let preco = $(this).attr('data-preco');
    let aprovadores = $(this).attr('data-aprovadores');

    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_viagens/pedidos/editar_hotel') ?>/" + id;
    $('#form_edit_hotel').attr('action', url);

    $('input[name="nome_e"]').val(nome);
    $('textarea[name="descricao_e"]').text(descricao);
    $('textarea[name="endereco_e"]').text(endereco);
    $('input[name="data_checkin_e"]').val(data_checkin);
    $('input[name="data_checkout_e"]').val(data_checkout);
    $('input[name="preco_e"]').val(preco);
    $('select[name="aprovadores_e[]"]').val(JSON.parse(aprovadores));

    $('#editar').modal('show');
})
$('.btn_edit_transporte').click(function() {
    let nome = $(this).attr('data-nome');
    let descricao = $(this).attr('data-descricao');
    let preco = $(this).attr('data-preco');
    let aprovadores = $(this).attr('data-aprovadores');

    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_viagens/pedidos/editar_transporte') ?>/" + id;
    $('#form_edit_transporte').attr('action', url);

    $('input[name="nome_e"]').val(nome);
    $('textarea[name="descricao_e"]').text(descricao);
    $('input[name="preco_e"]').val(preco);
    $('select[name="aprovadores_e[]"]').val(JSON.parse(aprovadores));

    $('#editar').modal('show');
})

$('.btn_edit_reserva').click(function() {
    let pedido = $(this).attr('data-pedido');
    let voo = $(this).attr('data-voo');
    let hotel = $(this).attr('data-hotel');
    let transporte = $(this).attr('data-transporte');
    let aprovadores = $(this).attr('data-aprovadores');

    let id = $(this).attr('data-id');

    let url = "<?= admin_url('gestao_viagens/pedidos/editar_reserva') ?>/" + id;
    $('#form_edit_reserva').attr('action', url);

    $('select[name="pedido_e"]').val(pedido);
    $('select[name="voo_e"]').val(voo);
    $('select[name="hotel_e"]').val(hotel);
    $('select[name="transporte_e"]').val(transporte);
    $('select[name="aprovadores_e[]"]').val(JSON.parse(aprovadores));

    $('#editar').modal('show');
})
$('#estado_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(5).search(this.value).draw();
})
$('#hotel_f').change(function() {
    var tabela = $('.dt-table').DataTable();
    tabela.column(1).search(this.value).draw();
})
</script>