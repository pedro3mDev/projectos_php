<div class="row">

    <!-- 1º Card - Total Planejadas -->
    <div class="col-md-3">
        <div style="height: 20px;">
        </div>
        <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column card" style="border-bottom: 1px solid #336; border-left: 4px solid #8B0000;">
            <a class="text-warning text-center mbot15">
                <p class="text-uppercase mtop5 minheight35 paragrafo"> 
                    Planejadas
                </p>
                <div class="d-flex align-items-center justify-content-center">
                    <p class="paragrafo2"> 
                        <i class="fa fa-calendar-check"></i>
                        <?= $total_planejamento ?? 0; ?>
                    </p>
                </div>
            </a>
        </div>
    </div>

    <!-- 2º Card - Pedidos Pendentes -->
    <div class="col-md-3">
        <div style="height: 20px;">
        </div>
        <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column card" style="border-bottom: 1px solid #336; border-left: 4px solid #8B0000;">
            <a class="text-warning text-center mbot15">
                <p class="text-uppercase mtop5 minheight35 paragrafo"> 
                    Pendentes
                </p>
                <div class="d-flex align-items-center justify-content-center">
                    <p class="paragrafo2"> 
                    <i class="fa fa-hourglass-half"></i>
                    <?= $total_planejamento_penedntes ?? 0; ?>
                    </p>
                </div>
            </a>
        </div>
    </div>

    <!-- 3º Card - Planejamentos Rejeitados -->
    <div class="col-md-3">
        <div style="height: 20px;">
        </div>
        <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column card" style="border-bottom: 1px solid #336; border-left: 4px solid #8B0000;">
            <a class="text-warning text-center mbot15">
                <p class="text-uppercase mtop5 minheight35 paragrafo"> 
                    Rejeitadas
                </p>
                <div class="d-flex align-items-center justify-content-center">
                    <p class="paragrafo2"> 
                        <i class="fa fa-times-circle"></i>
                        <?= $total_planejamento_rejeitados ?? 0; ?>
                    </p>
                </div>
            </a>
        </div>
    </div>

    <!-- 4º Card - Planejamentos Aprovados -->
    <div class="col-md-3">
        <div style="height: 20px;">
        </div>
        <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column card" style="border-bottom: 1px solid #336; border-left: 4px solid #8B0000;">
            <a class="text-warning text-center mbot15">
                <p class="text-uppercase mtop5 minheight35 paragrafo"> 
                    Aprovadas
                </p>
                <div class="d-flex align-items-center justify-content-center">
                    <p class="paragrafo2"> 
                        <i class="fa fa-check-circle"></i>
                        <?= $total_planejamento_aprovados ?? 0; ?>
                    </p>
                </div>
            </a>
        </div>
    </div>


</div>