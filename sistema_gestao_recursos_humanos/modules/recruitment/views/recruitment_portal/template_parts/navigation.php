<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<div class="content" style=" position:fixed; top:0px; left:0; width: 100%; z-index: 1000; padding: 0px;">
    <div id="parte_branca" style=" background: linear-gradient(to right, #fff, #fff); border-radius:0px; height: 80px;">
        <div class="row">
            <div class="col-md-3">
                <?php get_company_logo('','navbar-brand logo'); ?>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-6">
                        <div class="content row"
                            style="position: relative; overflow: hidden; border-radius: 0px; background-color: #fff; padding: 10px; display: flex; justify-content: center;">
                            <ul
                                style="color:#fff; list-style: none; padding: 0; margin: 0; display: flex; gap: 40px; align-items: right; white-space: nowrap; transition: transform 0.5s;">

                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6" style="background-image: url('https://static.wixstatic.com/media/661821_cc5f93b14b0f4ac4a05723fe499319b4~mv2.jpg/v1/fill/w_1920,h_474,al_c,q_85,usm_0.66_1.00_0.01,enc_avif,quality_auto/661821_cc5f93b14b0f4ac4a05723fe499319b4~mv2.jpg'); 
                        background-size: cover; 
                        background-position: center; 
                        height: 80px;
                        opacity: 0.6;">
                    </div> 


                </div>
            </div>
        </div>
    </div>

    <div id="parte_azul" style="background-color:#800000; border-radius:0px; height: 50px; border-top: 2px solid #336;">
        <div class="content row"
            style="position: relative; overflow: hidden; border-radius: 0px; background-color: #336; padding: 10px; display: flex; justify-content: center;">
            <ul
                style="color:#fff; list-style: none; padding: 0; margin: 0; display: flex; gap: 40px; align-items: center; white-space: nowrap; transition: transform 0.5s;">
                <li class="carousel-item">
                    <a href="<?= site_url('recruitment/recruitment_portal'); ?>"
                        style="text-decoration: none; color: inherit; font-weight: bold;">
                        <i class="fas fa-user-tie"></i> Portal de Recrutamento
                    </a>
                </li>
                <?php if (is_candidate_logged_in()) : ?>
                <li class="carousel-item">
                    <a href="<?= site_url('recruitment/recruitment_portal/minhas_candidaturas'); ?>"
                        style=" text-decoration: none; color: inherit; font-weight: bold;">
                        <i class="fas fa-file-alt"></i> Minhas Candidaturas
                    </a>
                </li>
                <li class="carousel-item">
                    <a href="<?= site_url('recruitment/recruitment_portal/perfil'); ?>"
                        style="text-decoration: none; color: inherit; font-weight: bold;">
                        <i class="fas fa-user"></i> Perfil
                    </a>
                </li>
                <li class="carousel-item">
                    <a href=""
                        style="text-decoration: none; color: inherit; font-weight: bold;">
                        <i class="fas fa-info-circle"></i> Sobre
                    </a>
                </li>

                <li class="carousel-item">
                    <a href="<?= site_url('recruitment/authentication_candidate/logout'); ?>"
                        style="text-decoration: none; color: inherit; font-weight: bold;">
                        <i class="fas fa-sign-in-alt"></i> Sair
                    </a>
                </li>
                <?php else : ?>
                <li class="carousel-item">
                    <a href="<?= site_url('recruitment/authentication_candidate/login'); ?>"
                        style="text-decoration: none; color: inherit; font-weight: bold;">
                        <i class="fas fa-sign-in-alt"></i> Entrar
                    </a>
                </li>
                <li class="carousel-item">
                    <a href="<?= site_url('recruitment/authentication_candidate/register'); ?>"
                        style="text-decoration: none; color: inherit; font-weight: bold;">
                        <i class="fas fa-user-plus"></i> Cadastro
                    </a>
                </li>
                <?php endif ?>


            </ul>
        </div>

        <!--div style="display: flex; align-items: center; height: 50px;">
         <ul style="color:#fff; display: flex; gap: 20px; font-weight: bold; font-size: 16px; list-style: none; padding: 0; margin: 0;">
            <li>Portal</li>
            <li>Perfil</li>
         </ul>
      </div-->



        <!--nav class="navbar navbar-default header" >
         <div class="container">
            <div class="navbar-header">
               <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#theme-navbar-collapse" aria-expanded="false">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
               </button>
               <?php get_company_logo('','navbar-brand logo'); ?>
            </div>
            <div class="collapse navbar-collapse" id="theme-navbar-collapse">
               <ul class="nav navbar-nav navbar-right">

                  <li>hiefdb</li>
                  <?php hooks()->do_action('customers_navigation_after_profile'); ?>
               </ul>
            </div>
         </div>
      </nav-->
    </div>

</div>
<style>
.carousel-item {
    color: #fff;
    display: flex;
    align-items: center;
    font-size: 14px;
    font-weight: bold;
    gap: 10px;
    padding: 10px;
    border-radius: 10px;
    transition: background-color 0.3s, color 0.3s, transform 0.3s;
    cursor: pointer;
    white-space: nowrap;
}

.carousel-item i {
    color: #fff;
    margin-right: 10px;
    transition: color 0.3s, transform 0.3s;
}

.carousel-item:hover {
    color: #DAA520;
    transform: scale(1.05);
}

.carousel-item:hover i {
    color: #DAA520;
    transform: scale(1.2);
}

.carousel-item.active {
    background-color: #DAA520;
    color: #fff;
}

.carousel-item.active i {
    color: #fff;
}
</style>