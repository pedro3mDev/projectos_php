<div class="row">
    <div class="col-md-4">
        <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column card">
            <a class="text-warning text-center mbot15">
                <p class="text-uppercase mtop5 minheight35 paragrafo">
                    Reconhecimento
                </p>
                <div class="d-flex align-items-center justify-content-center">
                    <p style="font-size:16px; color:#DAA520;">
                        <i class="fa fa-users"></i> <?= $total_reconhecimento ?? 0 ?>
                    </p>
                </div>
            </a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column card">
            <a class="text-warning text-center mbot15">
                <p class="text-uppercase mtop5 minheight35 paragrafo">
                    Prêmios
                </p>
                <div class="d-flex align-items-center justify-content-center">
                    <p style="font-size:16px; color:#DAA520;">
                        <i class="fa fa-bullhorn"></i> <?= $total_premio ?? 0 ?>
                    </p>
                </div>
            </a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column card">
            <a class="text-warning text-center mbot15">
                <p class="text-uppercase mtop5 minheight35 paragrafo">
                    Resgate Prêmio
                </p>
                <div class="d-flex align-items-center justify-content-center">
                    <p style="font-size:16px; color:#DAA520;">
                        <i class="fa fa-file-alt"></i> <?= $total_resgate_premio ?? 0 ?>
                    </p>
                </div>
            </a>
        </div>
    </div>

</div>