<div class="row">

    <div class="col-md-4">
        <div class="panel_s" style=" height: 410px; overflow-y: auto;">
            <div class="panel-body">
                <h4 class="no-margin font-bold">
                    <i class="fa fa-address-card-o" aria-hidden="true"></i> Avaliações
                </h4>
                <hr />
                <div class="panel-content">
                    <div class="panel-info">
                        <p class="panel-info-text">Total de Avaliações:
                            <?php echo $contar_avaliacao['total_registros'] ?>
                        </p>
                    </div>
                    <div>
                        <span class="status-value estados"><?php echo $contar_avaliacao['pendentes'] ?></span>
                        <span class="status-label estados">Pendentes</span>
                    </div>
                    <div class="estados" style="color: #FF66B2;">
                        <span class="status-value" style="color: #FF66B2;">
                            <?php echo $contar_avaliacao['rejeitados'] ?>
                        </span>
                        <span class="status-label">Rejeitados</span>
                    </div>
                    <!-- <div class="estados" style="color: #FF9900;">
                        <span class="status-value" style="color: #FF9900;">41</span>
                        <span class="status-label">Cancelado</span>
                    </div> -->
                    <div class="estados" style="color: #006400;">
                        <span class="status-value"
                            style="color: #006400;"><?php echo $contar_avaliacao['aprovados'] ?></span>
                        <span class="status-label">Aprovados</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="panel_s" style=" height: 410px; overflow-y: auto; ">
            <div class="panel-body">
                <h4 class="no-margin font-bold">
                    <i class="fa fa-address-card-o" aria-hidden="true"></i> Mentorias
                </h4>
                <hr />
                <div id="pieChart" style="width: 100%; height:250px;">
                </div>
                <div class="panel-details-content" style="border-top: 1px solid #ddd;">
                    <p class="panel-details-text" style="padding-left: 10px;">21 total issues</p>
                    <span class="panel-details-text" style="padding-top: 10px;">Issues Count by Due
                        Date
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="panel_s" style=" height: 410px; overflow-y: auto;">
            <div class="panel-body">
                <h4 class="no-margin font-bold">
                    <i class="fa fa-address-card-o" aria-hidden="true"></i> Planos
                </h4>
                <hr />
                <div id="gaugeChart" style="width: 100%; height: 250px;"></div>
                <div class="panel-details">
                    <div class="panel-details-content" style="border-top: 1px solid #ddd;">
                        <p class="panel-details-text" style="padding-left: 10px;"> 47 total issues </p>
                        <p class="panel-details-text" style="padding-top: 10px;">Issues Count by Risk</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="panel_s" style=" height: 410px; overflow-y: auto;">
        <div class="panel-body">
            <h4 class="no-margin font-bold">
                <i class="fa fa-address-card-o" aria-hidden="true"></i> Planos
            </h4>
            <hr />
            <div id="chart" style="width:100%; height:300px;"></div>
                <div class="panel-details">
                    <div class="panel-details-content" style="border-top: 1px solid #ddd;">
                        <p class="panel-details-text" style="padding-left: 10px;">21 total issues </p>
                        <p class="panel-details-text" style="padding-top: 10px;"></p>
                        <p>
                            Issues Count by Due Date
                        </p>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

</div>