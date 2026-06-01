<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-md-6">
        <a class="dashboard-link" href="" style="font-size: 16px; color: #333;">
            Permissões
        </a>
    </div>
    <div class="col-md-6" style=" display: flex; justify-content: flex-end; align-items: center;">
        <?php if(has_permission('hrm_setting', '', 'create')){ ?>
        <a href="#" onclick="hr_profile_permissions_update_conf(0,0,' hide'); return false;"
            class="btn btn-primary mbot10"><?php echo _l('hr_hr_add'); ?></a>
        <?php } ?>
    </div>
</div>

</br>

<div class="row">
    <div class="col-12">
        <table class="table table-hr-profile-permission-conf">
            <thead>
                <th><?php echo _l('hr_hr_staff_name'); ?></th>
                <th><?php echo _l('role'); ?></th>
                <th><?php echo _l('staff_dt_email'); ?></th>
                <th><?php echo _l('phone'); ?></th>
                <th><?php echo _l('options'); ?></th>
            </thead>
            <tbody>
            </tbody>
        </table>
        <div id="modal_wrapper"></div>
    </div>
</div>