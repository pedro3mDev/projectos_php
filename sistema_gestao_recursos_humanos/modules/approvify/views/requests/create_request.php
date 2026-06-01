<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <?php
            $data_view = [];
            $this->load->view('/admin/menu_modulo/menu', $data_view);
        ?>
        <div class="row">
            <div class="col-md-6">
				<a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
                Requisições / Nova Requisição
				</a>
            </div>
            <div class="col-md-6" style=" display: flex; justify-content: flex-end; align-items: center;">
				<button style="background-color: #336; color:#fff;" class="btn ms-2" onclick="window.history.back()">
					<i class="fas fa-reply"></i> Retroceder
				</button>
            </div>
        </div>

        </br>
        
        <div class="row">
            <div class="panel_s">
                <div class="panel-body">
                    <div id="response"></div>
                    <?php echo form_open(current_full_url(), ['id' => 'requestForm', 'class' => 'disable-on-submit']); ?>
                    <div class="col-md-12">
                        <h4>
                            <?php echo isset($type_data) ? $type_data->category_name : ''; ?>
                        </h4>
                        <p><?php echo isset($type_data) ? $type_data->category_description : ''; ?></p>
                    <hr>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo render_input('request_title', 'approvify_request_title'); ?>
                            </div>
                            <div class="col-md-12">
                                <?php echo render_textarea('request_content', 'approvify_request_content', '', ['rows' => 10], [], '', 'tinymce'); ?>
                            </div>
                            <div class="col-md-12">
                                <?php echo render_custom_fields('approvify_' . (isset($type_data) ? $type_data->id : ''), ''); ?>
                            </div>                     
                            <div class="col-md-12 mbot10">
                                <div class="attachments">
                                    <div class="attachment">
                                        <label for="attachment" class="control-label">
                                            <?php echo _l('ticket_form_attachments'); ?>
                                        </label>
                                        <div class="input-group">
                                            <input type="file"
                                                extension="<?php echo str_replace('.', '', get_option('ticket_attachments_file_extensions')); ?>"
                                                filesize="<?php echo file_upload_max_size(); ?>" class="form-control"
                                                name="attachments[]"
                                                accept="<?php echo get_ticket_form_accepted_mimes(); ?>">
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary add_more_attachments"
                                                        data-max="<?php echo get_option('maximum_allowed_ticket_attachments'); ?>"
                                                        type="button">
                                                        <i class="fa fa-plus"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
 
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success saveDocument pull-right">
                                    <?php echo _l('approvify_create_request'); ?>
                                </button> 
                            </div>
                        </div>
                    </div>
                    <?php
                        echo form_close();
                    ?>    
                </div>
            </div>
        </div>
    </div>  
</div>
<?php init_tail(); ?>
</body>
<script>
    "use strict";

    var form_id = '#requestForm';

    $(function () {

        $(form_id).appFormValidator({

            onSubmit: function (form) {

                $("input[type=file]").each(function () {
                    if ($(this).val() === "") {
                        $(this).prop('disabled', true);
                    }
                });
                $('#form_submit .fa-spin').removeClass('hide');

                var formURL = $(form).attr("action");
                var formData = new FormData($(form)[0]);

                $.ajax({
                    type: $(form).attr('method'),
                    data: formData,
                    mimeType: $(form).attr('enctype'),
                    contentType: false,
                    cache: false,
                    processData: false,
                    url: formURL
                }).always(function () {
                    $('#form_submit').prop('disabled', false);
                    $('#form_submit .fa-spin').addClass('hide');
                }).done(function (response) {

                    response = JSON.parse(response);
                    // In case action hook is used to redirect
                    if (response.redirect_url) {
                        if (window.top) {
                            window.top.location.href = response.redirect_url;
                        } else {
                            window.location.href = response.redirect_url;
                        }
                        return;
                    }
                    if (response.success == false) {
                        $('#recaptcha_response_field').html(response
                            .message); // error message
                    } else if (response.success == true) {
                        $(form_id).remove();
                        $('#response').html(
                            '<div class="alert alert-success" style="margin-bottom:0;">' +
                            response.message + '</div>');
                        $('html,body').animate({
                            scrollTop: $("#online_payment_form").offset().top
                        }, 'slow');
                    } else {
                        $('#response').html('Something went wrong...');
                    }
                    if (typeof (grecaptcha) != 'undefined') {
                        grecaptcha.reset();
                    }
                }).fail(function (data) {

                    if (typeof (grecaptcha) != 'undefined') {
                        grecaptcha.reset();
                    }

                    if (data.status == 422) {
                        $('#response').html(
                            '<div class="alert alert-danger">Some fields that are required are not filled properly.</div>'
                        );
                    } else {
                        $('#response').html(data.responseText);
                    }
                });
                return false;
            }
        });
    });

</script>
</html>
