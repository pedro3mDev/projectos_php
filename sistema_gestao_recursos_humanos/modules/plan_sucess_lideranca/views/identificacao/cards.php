<div class="row">
    <div class="col-md-3">
        <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column"
            style="border-bottom: 1px solid #336; border-left: 4px solid #8B0000; ">
            <a class="text-warning text-center mbot15">
                <p class="text-uppercase mtop5 minheight35" style="font-size: 14px; font-weight: bold; color:#DAA520;">
                    Total
                </p>
                <div class="d-flex align-items-center justify-content-center">
                    <p style="font-size:16px; color:#DAA520;">
                        <i class="fa fa-hashtag"></i>
                        <?= $avaliacao_competencias_total ?? 0 ?>
                    </p>
                </div>
            </a>
        </div>
    </div>

    <div class="col-md-3">
        <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column"
            style="border-bottom: 1px solid #336; border-left: 4px solid #8B0000; ">
            <a class="text-warning text-center mbot15">
                <p class="text-uppercase mtop5 minheight35" style="font-size: 14px; font-weight: bold; color:#DAA520;">
                    Potencial Talento
                </p>
                <div class="d-flex align-items-center justify-content-center">
                    <p style="font-size:16px; color:#DAA520;">
                        <i class="fa fa-hourglass-half"></i>
                        <?= $avaliacao_competencias_total_potencial ?? 0 ?>
                    </p>
                </div>
            </a>
        </div>
    </div>

    <div class="col-md-3">
        <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column"
            style="border-bottom: 1px solid #336; border-left: 4px solid #8B0000; ">
            <a class="text-warning text-center mbot15">
                <p class="text-uppercase mtop5 minheight35" style="font-size: 14px; font-weight: bold; color:#DAA520;">
                    Classificado
                </p>
                <div class="d-flex align-items-center justify-content-center">
                    <p style="font-size:16px; color:#DAA520;">
                        <i class="fa fa-cogs"></i>
                        <?= $avaliacao_competencias_total_classificado ?? 0 ?>
                    </p>
                </div>
            </a>
        </div>
    </div>

    <div class="col-md-3">
        <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column"
            style="border-bottom: 1px solid #336; border-left: 4px solid #8B0000; ">
            <a class="text-warning text-center mbot15">
                <p class="text-uppercase mtop5 minheight35" style="font-size: 14px; font-weight: bold; color:#DAA520;">
                    Não Classificado
                </p>
                <div class="d-flex align-items-center justify-content-center">
                    <p style="font-size:16px; color:#DAA520;">
                        <i class="fa fa-times-circle"></i>
                        <?= $avaliacao_competencias_total_n_classificado ?? 0 ?>
                    </p>
                </div>
            </a>
        </div>
    </div>
</div>