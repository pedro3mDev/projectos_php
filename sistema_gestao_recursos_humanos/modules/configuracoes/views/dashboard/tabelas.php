<div class="row">

    <div class="col-md-6">
        <div class="panel_s" style=" height: 410px; overflow-y: auto;">
            <div class="panel-body">
                <h4 class="no-margin font-bold">
                    <i class="fa fa-address-card-o" aria-hidden="true"></i> Logs do Sistema
                </h4>
                <hr />
                <div>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th id="titulo1" class="text-center">Nome</th>
                                <th class="titulo2" class="text-center">Data/Hora</th>
                                <th class="titulo2" class="text-center">Descrição</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($logs_sistema as $t) : ?>
                            <tr>
                                <td class="text-danger"><?= $t['staffid'] ?></td>
                                <td class="text-danger"><?= $t['date'] ?></td>
                                <td class="text-danger"><?= $t['description'] ?></td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel_s" style=" height: 410px; overflow-y: auto;">
            <div class="panel-body">
                <h4 class="no-margin font-bold">
                    <i class="fa fa-address-card-o" aria-hidden="true"></i> Checkin/Checkout
                </h4>
                <hr />
                <div>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th id="titulo1" class="text-center">Nome</th>
                                <th class="titulo2" class="text-center">Data</th>
                                <th class="titulo2" class="text-center">Horas Trabalhadas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($marcacoes as $m) : ?>
                            <tr>
                                <td class="text-danger"><?= $m['firstname'] .' '. $m['lastname'] ?></td>
                                <td class="text-danger"><?= $m['data'] ?></td>
                                <td class="text-danger"><?= $m['horas_trabalhadas'] ?></td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>