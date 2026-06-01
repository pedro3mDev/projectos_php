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
                Gestão de Requisições / Aprovações / Minha Requisição
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
            <div class="col-md-12">
            <div class="panel_s">
            <div class="panel-body">
                <h4 class="tw-mt-0 tw-font-semibold tw-text-neutral-700">
                    <span class="tw-text-lg"><strong>#<?php echo $request_data->id; ?></strong>-<?php echo $request_data->request_title; ?></span>
                </h4>
                <hr class="-tw-mx-4"/>
                <h4><?php echo _l('approvify_request_information'); ?></h4>
                <div class="panel-body">

                    <div class="row">
                        <div class="row col-md-12">

                            <div class="col-md-12 panel-padding">
                                <table class="table border table-striped table-margintop">
                                    <tbody>
                                    <tr class="project-overview">
                                        <td class="bold" width="30%"><?php echo _l('approvify_request_title'); ?></td>
                                        <td><?php echo $request_data->request_title; ?></td>
                                    </tr>
                                    <tr class="project-overview">
                                        <td class="bold"><?php echo _l('approvify_request_content'); ?></td>
                                        <td><?php echo $request_data->request_content; ?></td>
                                    </tr>
                                    <tr class="project-overview">
                                        <td class="bold"><?php echo _l('approvify_request_status'); ?></td>
                                        <td><?php echo approvify_return_request_status_html($request_data->status); ?>
                                            &nbsp;
                                        </td>
                                    </tr>
                                    <tr class="project-overview">
                                        <td class="bold"><?php echo _l('approvify_table_created_at'); ?></td>
                                        <td><?php echo $request_data->created_at; ?></td>
                                    </tr>
                                    <tr class="project-overview">
                                        <td class="bold"><?php echo _l('approvify_request_reviewers'); ?></td>
                                        <?php
                                        $approveList = '';
                                        if (!empty($request_data->approve_list)) {
                                            $decodeApproveList = json_decode($request_data->approve_list);

                                            foreach ($decodeApproveList as $staff) {
                                                $approveList .= '<a href="' . admin_url('staff/profile/' . $staff) . '">' . staff_profile_image($staff, [
                                                        'staff-profile-image-small',
                                                    ]) . '</a>';
                                            }
                                        }
                                        ?>
                                        <td><span class="label label-tag tag-id-1"><?php echo $approveList; ?></span>&nbsp;
                                        </td>
                                    </tr>
                                    <?php
                                    $customFields = get_custom_fields('approvify_' . $request_data->category_id);
                                    foreach ($customFields as $field) {
                                        $value = get_custom_field_value($request_data->id, $field['id'], 'approvify_' . $request_data->category_id); ?>

                                        <tr class="project-overview">
                                            <td class="bold"><?php echo $field['name']; ?></td>
                                            <td><?php echo($value != '' ? $value : '-') ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                            <br>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="h4-color"><?php echo _l('approvify_request_attachments'); ?></h4>
                            <hr class="hr-color">
                            <?php

                            if (empty($request_data->attachments)) {
                                echo _l('approvify_empty_request_attachments');
                            }

                            foreach ($request_data->attachments as $image) {
                                $path = FCPATH . 'modules/approvify/uploads/requests/' . $request_data->id . '/' . $image['filename'];
                                $is_image = is_image($path);

                                if ($is_image) {
                                    echo '<div class="preview_image">';
                                } ?>
                                <a href="<?php echo substr(module_dir_url('approvify/uploads/requests/' . $request_data->id . '/' . $image['filename']), 0, -1); ?>"
                                   class="display-block mbot5" <?php if ($is_image) { ?>
                                    data-lightbox="attachment-reply-" <?php } ?>>
                                    <i class=""></i>
                                    <?php echo $image['filename']; ?>
                                    <?php if ($is_image) { ?>
                                        <img class="mtop5"
                                             src="<?php echo site_url('download/preview_image?path=' . protected_file_url_by_path($path) . '&type='); ?>">
                                    <?php } ?>
                                </a>
                                <?php if ($is_image) {
                                    echo '</div>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            </div>


            <div class="col-md-12">
            <div class="panel_s">
            <div class="panel-body">
                <p>
                    <?php
                    if (!empty($is_review)) {
                        ?>

                        <?php
                        echo render_textarea('action_message', 'approvify_action_message');
                        ?>

                        <a onclick="approveRequest(this)" data-requestid="<?php echo $request_data->id; ?>"
                           class="btn btn-success pull-right">
                            <?php echo _l('approvify_btn_approve_status'); ?></a>
                        <a onclick="refuseRequest(this)" data-requestid="<?php echo $request_data->id; ?>"
                           class="btn btn-danger pull-right mright5">
                            <?php echo _l('approvify_btn_refuse_status'); ?></a>
                        <?php
                    }
                    ?>
                    <?php
                    if ($request_data->status === '0') {
                        ?>
                        <a href="<?php echo admin_url('approvify/cancel_request/' . $request_data->id) ?>"
                           class="btn btn-info pull-right mright5"><?php echo _l('approvify_btn_canceled_status'); ?></a>
                        <?php
                    }
                    ?>
                </p>
                <div class="clearfix"></div>
                <p></p>

                <h4><?php echo _l('approvify_request_activity'); ?></h4>
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="activity-feed">
                            <?php
                            if (empty($request_activity_log)) {
                                echo _l('approvify_empty_activity_log');
                            }
                            foreach ($request_activity_log as $activity) {
                                $name = get_staff_full_name($activity['staff_id']);
                                $href = admin_url('profile/' . $activity['staff_id']); ?>
                                <div class="feed-item">
                                    <div class="date"><span class="text-has-action" data-toggle="tooltip"
                                                            data-title="<?php echo _dt($activity['created_at']); ?>">
                            <?php echo time_ago($activity['created_at']); ?>
                        </span>
                                    </div>
                                    <div class="text">
                                        <p class="bold no-mbot">
                                            <a
                                                    href="<?php echo $href; ?>"><?php echo staff_profile_image($activity['staff_id'], ['staff-profile-xs-image', 'pull-left mright10']); ?></a>
                                            <?php if ($href != '') { ?>
                                                <a href="<?php echo $href; ?>"><?php echo $name; ?></a> -
                                            <?php } else {
                                                echo $name;
                                            }; ?>
                                            <?php echo $activity['description']; ?> <br>
                                        <div style="background-color: #efecec"><?php echo $activity['request_message']?? ''; ?></div>
                                        </p>
                                    </div>
                                </div>
                                <?php
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            </div>
        </div>

    </div>
</div>
<?php init_tail(); ?>
<script>
    "use strict";

    function refuseRequest(element) {
        var actionMessage = $('#action_message').val();
        var requestId = $(element).data('requestid');
        var encodedActionMessage = encodeURIComponent(actionMessage);
        var url = "<?php echo admin_url('approvify/refuse_request/'); ?>" + requestId;

        $.get(url, {action_message: encodedActionMessage}, function (data) {
            window.location.reload();
        });
    }

    function approveRequest(element) {
        var actionMessage = $('#action_message').val();
        var requestId = $(element).data('requestid');
        var encodedActionMessage = encodeURIComponent(actionMessage);
        var url = "<?php echo admin_url('approvify/approve_request/'); ?>" + requestId;

        $.get(url, {action_message: encodedActionMessage}, function (data) {
            window.location.reload();
        });
    }
</script>
