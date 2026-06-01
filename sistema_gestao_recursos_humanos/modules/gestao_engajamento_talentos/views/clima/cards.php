<div class="row">
    <div class="col-md-4">
        <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column card">
            <a class="text-warning text-center mbot15">
                <p class="text-uppercase mtop5 minheight35 paragrafo">
                    Pesquisa Clima
                </p>
                <div class="d-flex align-items-center justify-content-center">
                    <p style="font-size:16px; color:#DAA520;">
                        <i class="fa fa-users"></i> <?= $total_pesquisa_clima ?? 0 ?>
                    </p>
                </div>
            </a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column card">
            <a class="text-warning text-center mbot15">
                <p class="text-uppercase mtop5 minheight35 paragrafo">
                    Pergunta Clima
                </p>
                <div class="d-flex align-items-center justify-content-center">
                    <p style="font-size:16px; color:#DAA520;">
                        <i class="fa fa-bullhorn"></i> <?= $total_pergunta_clima ?? 0 ?>
                    </p>
                </div>
            </a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column card">
            <a class="text-warning text-center mbot15">
                <p class="text-uppercase mtop5 minheight35 paragrafo">
                    Resposta Clima
                </p>
                <div class="d-flex align-items-center justify-content-center">
                    <p style="font-size:16px; color:#DAA520;">
                        <i class="fa fa-file-alt"></i> <?= $total_resposta_clima ?? 0 ?>
                    </p>
                </div>
            </a>
        </div>
    </div>
</div>