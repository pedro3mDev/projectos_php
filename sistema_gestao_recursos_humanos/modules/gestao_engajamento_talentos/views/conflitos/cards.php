<div class="row">
    <div class="col-md-6">
        <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column card">
            <a class="text-warning text-center mbot15">
                <p class="text-uppercase mtop5 minheight35 paragrafo">
                    Conflitos
                </p>
                <div class="d-flex align-items-center justify-content-center">
                    <p style="font-size:16px; color:#DAA520;">
                        <i class="fa fa-users"></i> <?= $conflito_total ?? 0 ?>
                    </p>
                </div>
            </a>
        </div>
    </div>

    <div class="col-md-6">
        <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column card">
            <a class="text-warning text-center mbot15">
                <p class="text-uppercase mtop5 minheight35 paragrafo">
                    Medições de Conflitos
                </p>
                <div class="d-flex align-items-center justify-content-center">
                    <p style="font-size:16px; color:#DAA520;">
                        <i class="fa fa-comments"></i> <?= $medicao_conflito_total ?? 0 ?>
                    </p>
                </div>
            </a>
        </div>
    </div>
</div>