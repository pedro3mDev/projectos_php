<div class="row">
    <div class="col-md-3">
        <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column card">
            <a class="text-warning text-center mbot15">
                <p class="text-uppercase mtop5 minheight35 paragrafo">
                    Pesquisa Engajamento
                </p>
                <div class="d-flex align-items-center justify-content-center">
                    <p style="font-size:16px; color:#DAA520;">
                        <i class="fa fa-users"></i> <?= $pesquisa_engajamento_total ?? 0 ?>
                    </p>
                </div>
            </a>
        </div>
    </div>

    <div class="col-md-3">
        <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column card">
            <a class="text-warning text-center mbot15">
                <p class="text-uppercase mtop5 minheight35 paragrafo">
                    Pergunta Engajamento
                </p>
                <div class="d-flex align-items-center justify-content-center">
                    <p style="font-size:16px; color:#DAA520;">
                        <i class="fa fa-bullhorn"></i> <?= $total_pergunta_engajamento ?? 0 ?>
                    </p>
                </div>
            </a>
        </div>
    </div>

    <div class="col-md-3">
        <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column card">
            <a class="text-warning text-center mbot15">
                <p class="text-uppercase mtop5 minheight35 paragrafo">
                    Resposta Engajamento
                </p>
                <div class="d-flex align-items-center justify-content-center">
                    <p style="font-size:16px; color:#DAA520;">
                        <i class="fa fa-file-alt"></i> <?= $total_resposta_engajamento ?? 0 ?>
                    </p>
                </div>
            </a>
        </div>
    </div>

    <div class="col-md-3">
        <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column card">
            <a class="text-warning text-center mbot15">
                <p class="text-uppercase mtop5 minheight35 paragrafo">
                    Pesquisa Pendentes
                </p>
                <div class="d-flex align-items-center justify-content-center">
                    <p style="font-size:16px; color:#DAA520;">
                        <i class="fa fa-comments"></i> <?= $pesquisa_engajamento_total_pendente ?? 0 ?>
                    </p>
                </div>
            </a>
        </div>
    </div>

</div>