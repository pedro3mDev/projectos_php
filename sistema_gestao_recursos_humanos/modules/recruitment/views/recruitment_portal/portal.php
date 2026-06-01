<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php hooks()->do_action('app_customers_portal_head'); ?>
</br></br></br></br></br></br></br></br>
 
<body class="login_admin">
    <div class="row" style="padding:2px;">
        <div class="container col-md-12" style="border-left:4px solid #b67c18; height:auto; background-color:#f8f2c9; padding:10px">
            <p style="color:#79481a;">
                Para enviar Candidaturas é necessário que estejas Cadastrado!
            </p>
        </div>
    </div>
    <div class="row" style="padding:2px;">
        <div class="container col-md-10" style="height:60px; border-left:4px solid #b67c18; background-color:#f8f2c9; padding:10px">
            <p style="color:#79481a;">
                Ao enviar a Candidatura estás permitindo que os seus dados sejam usados pelos colaboradores da empresa!
            </p>
        </div>
        <div class="container col-md-2" style="height:60px; background-color:#f8f2c9; padding:10px">
            <button 
                style="background-color: #800000; border-bottom: 1px solid #DAA520; font-size: 18px; width: 100%;"
                type="button" 
                class="btn recruitment_showmore show-more-button"
                onclick="">
                <?php echo _l('Politicas') ?>
            </button>    
        </div>
    </div>
    </br>    
    <div class="row" style="border-left:4px solid #336; background-color:#fff;">
        <div class="col-md-10" style="padding: 10px;">
            <div class="text-center">
                <?php echo form_open_multipart(site_url('recruitment/recruitment_portal/search_job'), array('id' => 'search_job')); ?>
                <div class="form-group has-feedback has-feedback-left">
                    <div class="input-group">
                        <input type="search" style="padding:20px;" name="search"
                            placeholder="<?php echo _l('rp_key_search') ?>" class="form-control kb-search-input"
                            value="<?php if(isset($search)){echo html_entity_decode($search) ;}?>">
                        <span class="input-group-btn">
                            <button type="submit" style="padding:10px;" class="btn btn-success kb-search-button"><?php echo _l('Pesquisar') ?></button>
                        </span>
                        <i class="glyphicon glyphicon-search form-control-feedback kb-search-icon"></i>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
        <div class="col-md-2" style="padding: 10px;">
            <?php if(count($rec_campaingn) > 0){ ?>
            <button style="font-size: 18px; width: 100%;"
                class="btn btn-success"
                type="button" class="btn recruitment_showmore show-more-button"
                onclick="show_more_job(this); return false;">
                <?php echo _l('Mostrar Mais') ?>
            </button>
            <?php } ?>
        </div>
    </div>
    <div class="row" style="border-left:4px solid #336; background-color:#fff;">
        <div class="col-md-12" >
            <div class="row" style="padding:10px;">
                <!-- Link para Font Awesome (certifica-te que está no <head> ou antes deste bloco) -->
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

                <div class="container col-md-4" style="display: flex; align-items: center; justify-content: center; border-left:4px solid #3CB371; height:auto; background-color:#d6f5df; padding:10px">
                    <i class="fas fa-folder-open" style="color:#3CB371; font-size: 18px; margin-right: 8px;"></i>
                    <p style="color:#3CB371; font-size: 18px; margin: 0;">
                        Candidaturas Disponíveis
                    </p>
                </div>

                <div class="container col-md-4" style="display: flex; align-items: center; justify-content: center; border-left:4px solid #DAA520; height:auto; background-color:#f8f2c9; padding:10px">
                    <i class="fas fa-paper-plane" style="color:#DAA520; font-size: 18px; margin-right: 8px;"></i>
                    <p style="color:#DAA520; font-size: 18px; margin: 0;">
                        Candidaturas Enviadas
                    </p>
                </div>

                <div class="container col-md-4" style="display: flex; align-items: center; justify-content: center; border-left:4px solid #800000; height:auto; background-color:#ffdada; padding:10px">
                    <i class="fas fa-lock" style="color:#800000; font-size: 18px; margin-right: 8px;"></i>
                    <p style="color:#800000; font-size: 18px; margin: 0;">
                        Candidaturas Fechadas
                    </p>
                </div>

            </div>
        
        <div class="panel_s" style="background-color: rgba(255, 255, 255, 0.8); ; border-radius: 5px;">
            <div class="panel-body">
                <h4 class="no-margin font-bold">
                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                    Vagas
                </h4>
                <hr/>
                <div class="row">
                    <div class="col-md-12" style="padding: 10px;">
                        <?php if(isset($rec_campaingn_total)){ ?>
                        <h2 class="title title-search text-danger">
                            <a class="text-danger" href="">
                                <?php echo html_entity_decode($rec_campaingn_total). ' '.$search ._l('job_for_you')?>
                            </a></h2>
                        <?php } ?>
                    </div>
                    <div class="col-md-12" style="padding: 10px;">
                        <?php if(count($rec_campaingn) > 0){ ?>
                        <div class="panel_s" style="background-color: rgba(255, 255, 255, 0.1);">
                            <div class=" panel-body" id="panel_body_job"
                                style="background-color: rgba(255, 255, 255, 0.8);">
                                <?php foreach ($rec_campaingn as $rec_value) { ?>
                                <div class="job" id="job_68268">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="job_content col-md-12"
                                                    style="border-top: 1px solid #999; border-bottom: 0px;">
                                                    <div class="col-md-2" style="background-image: url('data:image/jpeg;base64,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'); 
                                                        background-size: cover; 
                                                        background-position: center; 
                                                        height: auto;
                                                        opacity: 0.6;">
                                                    </div>
                                                    <div
                                                        class="job__description col-md-10 <?php if(!isset($rec_value['company_id']) || ($rec_value['company_id'] == '0')){ echo 'job__description_margin';} ?>">
                                                        <div class="job__body">
                                                            <div class="details"
                                                                style=" height: 200px; overflow-y: auto;">
                                                                <table class="table table-bordered table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                            <th id="titulo0" class="text-center"
                                                                                colspan="2">
                                                                                <?php echo html_entity_decode($rec_value['campaign_name']) ?>
                                                                            </th>
                                                                        </tr>
                                                                        <tr>
                                                                            <th id="titulo1" class="text-center"
                                                                                colspan="1">Elementos</th>
                                                                            <th class="titulo2" class="text-center"
                                                                                colspan="1">Dados</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="text-center">Cargo</td>
                                                                            <td class="text-center">
                                                                                <?php echo html_entity_decode(_l($rec_value['position_name'])) ?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="text-center">Centro de Custo</td>
                                                                            <td class="text-center">
                                                                                <?php echo html_entity_decode(_l($rec_value['company_name'] ?? '')) ?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="text-center">Modelo</td>
                                                                            <td class="text-center">
                                                                                <?php if(isset($rec_value['cp_form_work'])){ ?>
                                                                                <?php echo _l($rec_value['cp_form_work']) ?>
                                                                                <?php } ?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="text-center">Localização</td>
                                                                            <td class="text-center">
                                                                                <?php echo $rec_value['cp_workplace'] ?>
                                                                            </td>
                                                                        </tr>

                                                                    </tbody>
                                                                </table>
                                                                <style>
                                                                #titulo0 {
                                                                    background-color: #800000;
                                                                    color: #fff;
                                                                    text-align: center;
                                                                    text-transform: uppercase;
                                                                    font-weight: bold;
                                                                }

                                                                #titulo1 {
                                                                    background-color: #999;
                                                                    color: #fff;
                                                                    text-align: center;
                                                                }

                                                                .titulo2 {
                                                                    background-color: #999;
                                                                    color: #fff;
                                                                    text-align: center;
                                                                }
                                                                </style>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="city_and_posted_date col-md-3">
                                                        <div class="feature new text"
                                                            style="background-color:#336; color: #fff; padding:10px; border-radius: 5px;">
                                                            <a class="bold a-color text-uppercase" style="color:#fff;"
                                                                data-controller="utm-tracking"
                                                                href="<?php echo site_url('recruitment/recruitment_portal/job_detail/'.$rec_value['cp_id']) ?>">
                                                                <?php echo _l('view_detail') ?>
                                                            </a>
                                                        </div>
                                                        <?php  if(strtotime(date("Y-m-d")) > strtotime($rec_value['cp_to_date'])){?>
                                                        <div class="feature new text"
                                                            style="padding:10px; border-radius: 5px; border-bottom: 1px solid #336;">
                                                            <?php echo _l('overdue') ?>
                                                        </div>
                                                        <?php }else{ ?>
                                                        <div class=""></div>
                                                        <?php } ?>
                                                        <div class="distance-time-job-posted">
                                                            <span class="distance-time highlight"
                                                                style="padding:10px; border-radius: 5px; background-color:#DAA520; color:#fff; border-bottom: 1px solid #336;">
                                                                <?php echo html_entity_decode($rec_value['cp_from_date'].' - '.$rec_value['cp_to_date']); ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php } ?>

                    </div>
                </div>
            </div>

            <?php if(count($rec_campaingn) == 0){ ?>
            <div class="panel_s">
                <div class="panel-body">
                    <p class="no-margin text-center"><?php echo _l('recruitment_portal_not_found'); ?></p>
                </div>
            </div>
            <?php } ?>



            <div id="additional">
                <input type="hidden" name="current_page"
                    value="<?php if(isset($page)){echo html_entity_decode($page) ;}else{ echo '2' ;} ; ?>">
            </div>

            <?php hooks()->do_action('app_customers_portal_footer'); ?>

</body>
<style>
.show-more-button {
    background-color: #336;
    color: white;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.show-more-button:hover {
    background-color: #800000;
    color: #DAA520;
}
</style>