<div class="row">
    <div class="col-md-12">
        <div class="panel_s" style=" height: 250px; overflow-y: auto;">
            <div class="panel-body">
                <h4 class="no-margin font-bold">
                    <i class="fa fa-address-card-o" aria-hidden="true"></i> Total de Treinamentos
                </h4>
                <hr />
                <div>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th id="titulo1" class="text-center">Nome</th>
                                <th class="titulo2" class="text-center">Tipo</th>
                                <th class="titulo2" class="text-center">Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($treinemento)): ?>
                                <tr>
                                    <td class="text-center" colspan="3">Sem dados</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($treinemento as $item): ?>
                                    <tr>
                                        <td class="text-center"><?= htmlspecialchars($item['descricao']); ?></td>
                                        <td class="text-center"><?= htmlspecialchars($item['programa_lideranca']); ?></td>
                                        <td class="text-center"><?= htmlspecialchars($item['created_at']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <style>
                    #titulo1 {
                        background-color: #336;
                        color: #fff;
                        text-align: center;
                    }

                    .titulo2 {
                        background-color: #800000;
                        color: #fff;
                        text-align: center;
                    }
                </style>

            </div>
        </div>
    </div>
    <!-- -->
    <div class="col-md-12">
        <div class="panel_s" style=" height: 250px; overflow-y: auto;">
            <div class="panel-body">
                <h4 class="no-margin font-bold">
                    <i class="fa fa-address-card-o" aria-hidden="true"></i> Total de Onbordings
                </h4>
                <hr />
                <div>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th id="titulo1" class="text-center">Nome</th>
                                <th class="titulo2" class="text-center">Tipo</th>
                                <th class="titulo2" class="text-center">Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                            </tr>
                            <tr>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                            </tr>
                            <tr>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <style>
                    #titulo1 {
                        background-color: #336;
                        color: #fff;
                        text-align: center;
                    }

                    .titulo2 {
                        background-color: #800000;
                        color: #fff;
                        text-align: center;
                    }
                </style>

            </div>
        </div>
    </div>

</div>