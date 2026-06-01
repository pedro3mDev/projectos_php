<div class="row">
    
    <!--1º Card-->
    <div class="col-md-3">
        <div style="height: 20px;">
        </div>
        <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column card">
            <a class="text-warning text-center mbot15">
                <p class="text-uppercase mtop5 minheight35 paragrafo"> 
                    <?php echo _l('total_campaign'); ?>
                </p>
                <div class="d-flex align-items-center justify-content-center">
                    <p class="paragrafo2"> 
                        <i class="fas fa-bullhorn"></i>
                        <?php echo html_entity_decode($cp_count['total']); ?>
                    </p>
                </div>
            </a>
        </div>
    </div>

    <!-- 2º Card-->
    <div class="col-md-3">
        <div style="height: 20px;">
        </div>
        <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column card">
            <a class="text-warning text-center mbot15">
                <p class="text-uppercase mtop5 minheight35 paragrafo">
                    <?php echo _l('campaign_progress'); ?>
                </p>
                <div class="d-flex align-items-center justify-content-center">
                    <p class="paragrafo2"> 
                        <i class="fas fa-tasks"></i>
                        <?php echo html_entity_decode($cp_count['inprogress']) ?>
                    </p>
                </div>
            </a>
        </div>
    </div>

    <!-- 3º Card-->
    <div class="col-md-3">
        <div style="height: 20px;">
        </div>
        <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column card">
            <a class="text-warning text-center mbot15">
                <p class="text-uppercase mtop5 minheight35 paragrafo">
                    <?php echo _l('campaign_planning'); ?>
                </p>
                <div class="d-flex align-items-center justify-content-center">
                    <p class="paragrafo2"> 
                        <i class="fas fa-list-alt"></i>
                        <?php echo html_entity_decode($cp_count['planning']); ?>
                    </p>
                </div>
            </a>
        </div>
    </div>

    <!-- 4º Card-->
    <div class="col-md-3">
        <div style="height: 20px;">
        </div>
        <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column card">
            <a class="text-warning text-center mbot15">
                <p class="text-uppercase mtop5 minheight35 paragrafo">
                    <?php echo _l('campaign_finish'); ?>
                </p>
                <div class="d-flex align-items-center justify-content-center">
                    <p class="paragrafo2"> 
                        <i class="fas fa-check-circle"></i>
                        <?php echo html_entity_decode($cp_count['finish']); ?>
                    </p>
                </div>
            </a>
        </div>
    </div>

    <!-- 5º Card-->
    <div class="col-md-3">
        <div style="height: 20px;">
        </div>
        <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column card">
            <a class="text-warning text-center mbot15">
                <p class="text-uppercase mtop5 minheight35 paragrafo">
                    <?php echo _l('candidates_need_to_recruit'); ?>
                </p>
                <div class="d-flex align-items-center justify-content-center">
                    <p class="paragrafo2"> 
                        <i class="fas fa-users"></i>
                        <?php echo html_entity_decode($cp_count['candidate_need']); ?>
                    </p>
                </div>
            </a>
        </div>
    </div>
    
    <!-- 6º Card-->
    <div class="col-md-3">
        <div style="height: 20px;">
        </div>
        <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column card">
            <a class="text-warning text-center mbot15">
                <p class="text-uppercase mtop5 minheight35 paragrafo">
                    <?php echo _l('recruited_candidate'); ?>
                </p>
                <div class="d-flex align-items-center justify-content-center">
                    <p class="paragrafo2"> 
                        <i class="fas fa-user-tie"></i>
                        <?php echo html_entity_decode($cp_count['recruited']) ?>
                    </p>
                </div>
            </a>
        </div>
    </div>

    <!-- 7º Card-->
    <div class="col-md-3">
        <div style="height: 20px;">
        </div>
        <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column card">
            <a class="text-warning text-center mbot15">
                <p class="text-uppercase mtop5 minheight35 paragrafo">
                    TOTAL DE CANDIDATOS
                </p>
                <div class="d-flex align-items-center justify-content-center">
                    <p class="paragrafo2"> 
                        <i class="fas fa-user-friends"></i>
                        <?php echo html_entity_decode($total_candidatos) ?>
                    </p>
                </div>
            </a>
        </div>
    </div>

    <!-- 8º Card-->
    <div class="col-md-3">
        <div style="height: 20px;">
        </div>
        <div class="top_stats_wrapper minheight85 d-flex align-items-center justify-content-center flex-column" style="border-bottom: 1px solid #336; border-left: 4px solid #8B0000;">
            <a class="text-warning text-center mbot15">
                <p class="text-uppercase mtop5 minheight35 paragrafo">
                    TOTAL DE ENTREVISTAS
                </p>
                <div class="d-flex align-items-center justify-content-center">
                    <p class="paragrafo2"> 
                        <i class="fas fa-handshake"></i>
                        <?php echo html_entity_decode($total_entrevistas) ?>
                    </p>
                </div>
            </a>
        </div>
    </div>

</div>

</br>