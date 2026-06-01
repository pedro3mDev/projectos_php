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
                        <?= $total_curso ?? 0 ?>
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
                    Pendente
                </p>
                <div class="d-flex align-items-center justify-content-center">
                    <p style="font-size:16px; color:#DAA520;">
                        <i class="fa fa-hourglass-half"></i>
                        <?= $total_curso_p ?? 0 ?>
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
                    Aprovados
                </p>
                <div class="d-flex align-items-center justify-content-center">
                    <p style="font-size:16px; color:#DAA520;">
                        <i class="fa fa-cogs"></i>
                        <?= $total_curso_a ?? 0 ?>
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
                    Rejeitados
                </p>
                <div class="d-flex align-items-center justify-content-center">
                    <p style="font-size:16px; color:#DAA520;">
                        <i class="fa fa-times-circle"></i>
                        <?= $total_curso_r ?? 0 ?>
                    </p>
                </div>
            </a>
        </div>
    </div>
</div>