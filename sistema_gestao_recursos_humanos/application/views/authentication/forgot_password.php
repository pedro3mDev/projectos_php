<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $this->load->view('authentication/includes/head.php'); ?>

<body class="login_admin" style="
    background-image: url('https://static.wixstatic.com/media/661821_b7f7bb47a62547de8af67308c8322f9a~mv2.jpg/v1/fill/w_1920,h_730,al_c,q_85,usm_0.66_1.00_0.01,enc_avif,quality_auto/661821_b7f7bb47a62547de8af67308c8322f9a~mv2.jpg'); 
    background-size: cover; 
    background-repeat: no-repeat; 
    background-position: center; 
    min-height: 100vh; 
    margin: 0;
    ">

    <div class="tw-max-w-md tw-mx-auto tw-pt-24 authentication-form-wrappe tw-relative tw-z-20">
        <!--div class="company-logo text-center">
            <?= get_dark_company_logo(); ?>
        </div>

        <h1 class="tw-text-2xl tw-text-neutral-800 text-center tw-font-semibold tw-mb-5">
            <?= _l('admin_auth_forgot_password_heading'); ?>
        </h1-->

        <div
            class="tw-bg-white tw-mx-2 sm:tw-mx-6 tw-py-8 tw-px-6 sm:tw-px-8 tw-shadow-sm tw-rounded-lg tw-border tw-border-solid tw-border-neutral-600/20"
            style="background-color: rgba(255, 255, 255, 0.8);">

            <div class="company-logo text-center">
                <?= get_dark_company_logo(); ?>
            </div>

            <?= form_open($this->uri->uri_string()); ?>

            <?= validation_errors('<div class="alert alert-danger text-center">', '</div>'); ?>

            <?php $this->load->view('authentication/includes/alerts'); ?>

            <?= render_input('email', 'admin_auth_forgot_password_email', set_value('email'), 'email'); ?>

            <button type="submit" class="btn btn-primary btn-block tw-font-semibold tw-py-2">
                <?= _l('admin_auth_forgot_password_button'); ?>
            </button>

            <?= form_close(); ?>
        </div>

    </div>
</body>

</html>