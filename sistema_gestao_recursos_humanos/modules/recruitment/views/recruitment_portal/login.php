<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
</br>
</br>
</br>
</br>
</br>
</br>
</br>
</br>
----
<div class="mtop40">
   </br>
   <div class="col-md-4 col-md-offset-4 text-center">
   </div>
   <div class="card col-md-4 col-md-offset-4 col-sm-8 col-sm-offset-2"  style=" background-color:#fff; border-left:2px solid; #336; border-radius:10px;">
      <div style="text-align: center; font-weight: bold;">
         <h1>Login</h1>
      </div>
      <?php echo form_open(site_url('recruitment/authentication_candidate/login'),array('class'=>'login-form')); ?>
      <?php hooks()->do_action('clients_login_form_start'); ?>
      <div class="panel_s">
         <div class="panel-body">
            <div class="form-group">
               <label for="email"><?php echo _l('clients_login_email'); ?></label>
               <input type="text" autofocus="true" class="form-control" name="email" id="email">
               <?php echo form_error('email'); ?>
            </div>
            <div class="form-group">
               <label for="password"><?php echo _l('clients_login_password'); ?></label>
               <input type="password" class="form-control" name="password" id="password">
               <?php echo form_error('password'); ?>
            </div>
            <?php if(get_option('use_recaptcha_customers_area') == 1
                     && get_option('recaptcha_secret_key') != ''
                     && get_option('recaptcha_site_key') != ''){ ?>
            <div class="g-recaptcha mbot15" data-sitekey="<?php echo get_option('recaptcha_site_key'); ?>"></div>
            <?php echo form_error('g-recaptcha-response'); ?>
            <?php } ?>
  
            <div class="form-group">
               <button type="submit"
                  class="btn btn-info btn-block">
                  <?php echo _l('Fazer Login'); ?>
               </button>
            </div>
           
            <?php echo form_close(); ?>
         </div>
      </div>
   </div>
</div>

<!--div class="form-group">
   <a href="<?php echo site_url('recruitment/authentication_candidate/forgot_password'); ?>"><?php echo _l('admin_auth_login_fp'); ?></a>
</div-->