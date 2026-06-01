<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $this->load->view('authentication/includes/head.php'); ?>

<body class="login_admin">



<div class="row">

    <div class="col-md-3" style="
        background-color: #FFF;
        min-height: 100vh;
        margin: 0;
        padding: 50px; 
        justify-content: center;
        align-items: center;
        height: 100vh;">

        <!-- Logo da empresa -->
        <div class="company-logo text-center mb-5">
            <?php get_dark_company_logo(); ?>
        </div>

        <!-- Título -->
        <div class="d-flex align-items-center justify-content-center flex-column text-center mb-4">
            <h3 style="font-size: 1.5rem; font-weight: bold;">
                Entre na Plataforma de Capital Humano
            </h3>
        </div>

        <!-- Alertas -->
        <?php $this->load->view('authentication/includes/alerts'); ?>
        <?= form_open($this->uri->uri_string()); ?>
        <?= validation_errors('<div class="alert alert-danger text-center">', '</div>'); ?>
        <?php hooks()->do_action('after_admin_login_form_start'); ?>

        <!-- Campo Email -->
        <div class="form-group mb-4">
            <label for="email" class="control-label" style="font-size: 1.2rem;">
                Endereço de Email
            </label>
            <input type="email" id="email" name="email" placeholder="email@csc.com" 
                class="form-control form-control-lg" 
                style="font-size: 1.1rem; padding: 10px;">
        </div>

        <!-- Campo Senha -->
        <div class="form-group mb-4">
            <span class="d-flex justify-content-between align-items-end mb-2">
                <label for="password" class="control-label" style="font-size: 1.2rem;">
                    Senha
                </label>
                <a href="<?= admin_url('authentication/forgot_password'); ?>" 
                class="text-muted" 
                style="font-size: 0.9rem;">
                    <?= _l('admin_auth_login_fp'); ?>
                </a>
            </span>
            <input type="password" id="password" name="password" placeholder="Senha" 
                class="form-control form-control-lg" 
                style="font-size: 1.1rem; padding: 10px;">
        </div>
        <!-- Campo Ano -->
        <div class="form-group mb-4">
            <label for="ano" class="control-label" style="font-size: 1.2rem;">
                Ano
            </label>
            <select id="ano" name="ano" class="form-control form-control-lg" style="font-size: 1.1rem; padding: 10px;">
                <option value="" disabled selected>2025</option>
                <option value="email1@csc.com">2026</option>
                <!--option value="email2@csc.com">email2@csc.com</option>
                <option value="email3@csc.com">email3@csc.com</option-->
            </select>

        </div>

        <!-- reCAPTCHA -->
        <?php if (show_recaptcha()) { ?>
            <div class="g-recaptcha mb-4"
                data-sitekey="<?= get_option('recaptcha_site_key'); ?>">
            </div>
        <?php } ?>

        <!-- Checkbox Lembrar-me -->
        <div class="form-group mb-4">
            <div class="form-check">
                <input type="checkbox" id="remember" name="remember" class="form-check-input">
                <label for="remember" class="form-check-label" style="font-size: 1rem;">
                    Lembrar-me
                </label>
            </div>
        </div>

        <!-- Botão de Login -->
        <div class="mb-4">
            <button type="submit" 
                    class="btn btn-primary btn-lg btn-block" 
                    style="font-size: 1.2rem; padding: 12px 20px; background-color:#191970; border: 1px solid #999;">
                <?= _l('admin_auth_login_button'); ?>
            </button>
        </div>

        <?php hooks()->do_action('before_admin_login_form_close'); ?>
        <?= form_close(); ?>
        <div class="row">
            <div class="col-md-12 text-center" style="background-color: #800000; padding: 20px; border-radius: 15px;">
                <p style="color: #fff; font-weight: bold;">Quer saber mais sobre nós?</p>
                <a href="https://www.cscangola.ao/" target="_blank" rel="noopener noreferrer" style="color: #fff; text-decoration: underline; font-weight: bold;">
                    Clique Aqui!
                </a>
            </div>
        </div>

    
    </div>


    <div class="col-md-9" style=" 
        background-color: #FFF; 
        background-repeat: no-repeat; 
        background-position: center; 
        min-height: 100vh; 
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center; ">
         
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

        <div id="carouselExample" class="carousel slide w-100 h-100" data-bs-ride="carousel">
            <div class="carousel-inner h-100 rounded-3 shadow-lg" style="border-left: 1px solid #999;">
                
                <!-- Slide 1 -->
                <div class="carousel-item active position-relative">
                    <img src="https://static.wixstatic.com/media/661821_b7f7bb47a62547de8af67308c8322f9a~mv2.jpg/v1/fill/w_1920,h_730,al_c,q_85,usm_0.66_1.00_0.01,enc_avif,quality_auto/661821_b7f7bb47a62547de8af67308c8322f9a~mv2.jpg" 
                        class="d-block w-100" 
                        style="height: 900px; object-fit: cover; border-radius: 10px;" 
                        alt="Slide 1">
                    <div class="position-absolute top-0 w-100 h-100" style="background: rgba(0, 0, 0, 0.4); border-radius: 10px;"></div>
                    <div class="carousel-caption d-flex justify-content-center align-items-center flex-column" style="position: absolute; top: 50%; transform: translateY(-50%);">
                        <h3 class="text-white fw-bold" style="background-color: #800000; padding: 20px; border-radius: 15px;">
                            1. CSC Preparando um futuro cada vez melhor para Angola
                        </h3>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="carousel-item position-relative">
                    <img src="https://www.maestro.ind.br/wp-content/uploads/2019/09/industria135.png" 
                        class="d-block w-100" 
                        style="height: 900px; object-fit: cover; border-radius: 10px;" 
                        alt="Slide 2">
                    <div class="position-absolute top-0 w-100 h-100" style="background: rgba(0, 0, 0, 0.5); border-radius: 10px;"></div>
                    <div class="carousel-caption d-flex justify-content-center align-items-center flex-column" style="position: absolute; top: 50%; transform: translateY(-50%);">
                        <h3 class="text-white fw-bold" style="background-color: #800000; padding: 20px; border-radius: 15px;">
                            2. CSC Preparando um futuro cada vez melhor para Angola
                        </h3>
                    </div>
                </div>

            </div>

            <!-- Botões de Navegação -->
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev" style="width: 5%; opacity: 0.8;">
                <span class="carousel-control-prev-icon bg-dark p-3 rounded-circle" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next" style="width: 5%; opacity: 0.8;">
                <span class="carousel-control-next-icon bg-dark p-3 rounded-circle" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

</div>

</body>

