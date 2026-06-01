<div class="row">
    <div class="col-md-3">
        <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column card">
            <a class="text-warning text-center mbot15">
                <p class="text-uppercase mtop5 minheight35 paragrafo">
                    Total de Cursos
                </p>
                <div class="d-flex align-items-center justify-content-center">
                    <p style="font-size:16px; color:#DAA520;">
                        <i class="fa fa-users"></i>
                        <?= $total_curso ?? 0 ?>
                    </p>
                </div>
            </a>
        </div>
    </div>

    <div class="col-md-3">
        <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column card">
            <a class="text-warning text-center mbot15">
                <p class="text-uppercase mtop5 minheight35 paragrafo">
                    Total de Categórias
                </p>
                <div class="d-flex align-items-center justify-content-center">
                    <p style="font-size:16px; color:#DAA520;">
                        <i class="fa fa-bullhorn"></i>
                        <?= $total_categoria ?? 0 ?>
                    </p>
                </div>
            </a>
        </div>
    </div>

    <div class="col-md-3">
        <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column card">
            <a class="text-warning text-center mbot15">
                <p class="text-uppercase mtop5 minheight35 paragrafo">
                    Total de Inscrições
                </p>
                <div class="d-flex align-items-center justify-content-center">
                    <p style="font-size:16px; color:#DAA520;">
                        <i class="fa fa-file-alt"></i>
                        <?= $inscritos_total ?? 0 ?>
                    </p>
                </div>
            </a>
        </div>
    </div>

    <div class="col-md-3">
        <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column card">
            <a class="text-warning text-center mbot15">
                <p class="text-uppercase mtop5 minheight35 paragrafo">
                    Riscos
                </p>
                <div class="d-flex align-items-center justify-content-center">
                    <p style="font-size:16px; color:#DAA520;">
                        <i class="fa fa-comments"></i>
                        <?= $total_risco ?? 0 ?>
                    </p>
                </div>
            </a>
        </div>
    </div>

</div>

</br>