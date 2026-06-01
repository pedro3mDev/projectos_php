<div class="row">

    <!-- 1ª Tabela -->
    <div class="col-md-6">
        <div class="panel_s" style=" height: 410px; overflow-y: auto;">
            <div class="panel-body">
                <h4 class="no-margin font-bold">
                    <i class="fa fa-address-card-o" aria-hidden="true"></i> Top Destinos
                </h4>
                <hr />
                <div>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th id="titulo1" class="text-center"></th>
                                <th class="titulo2" class="text-center">Destino</th>
                                <th class="titulo2" class="text-center">Qtd Viagens</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($top_destinos)) : ?>
                            <?php foreach ($top_destinos as $d) : ?>
                            <tr>
                                <td class="table-rank"> <i class="fa fa-map-marker" style="color:#DAA520;"></i> </td>
                                <td>
                                    <p class="destination-title"> <?= htmlspecialchars($d['destino']); ?> </p>
                                </td>
                                <td>
                                    <p class="destination-reservations"> <?= htmlspecialchars($d['total']); ?> </p>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else : ?>
                            <tr>
                                <td colspan="3">Nenhum destino encontrado.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- 2ª Tabela -->
    <div class="col-md-6">
        <div class="panel_s" style=" height: 410px; overflow-y: auto;">
            <div class="panel-body">
                <h4 class="no-margin font-bold">
                    <i class="fa fa-address-card-o" aria-hidden="true"></i> Viagens dentro do Orçamento
                </h4>
                <hr />
                <div>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th id="titulo1" class="text-center"></th>
                                <th class="titulo2" class="text-center">Viagem (Orçamento)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orcamentos as $c) : ?>
                            <tr>
                                <td class="table-rank">
                                    <i class="fa fa-map-marker" style="color:#DAA520;"></i>
                                    <?php echo $c['destino']; ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $c['objetivo']; ?>
                                    (<?php echo number_format(total_reserva($c), 2, ',','.'); ?>)
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

</div>