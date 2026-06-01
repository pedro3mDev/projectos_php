<script>
$(function() {

    "use strict";
    initDataTable('.table-hr-profile-permission', admin_url + 'hr_profile/hr_profile_permission_table');
    initDataTable('.table-hr-profile-permission-conf', admin_url +
        'hr_profile/hr_profile_permission_table?config=1');
});

function hr_profile_permissions_update(staff_id, role_id, add_new) {
    "use strict";

    $("#modal_wrapper").load("<?php echo admin_url('hr_profile/hr_profile/permission_modal'); ?>", {
        slug: 'update',
        staff_id: staff_id,
        role_id: role_id,
        add_new: add_new
    }, function() {
        if ($('.modal-backdrop.fade').hasClass('in')) {
            $('.modal-backdrop.fade').remove();
        }
        if ($('#appointmentModal').is(':hidden')) {
            $('#appointmentModal').modal({
                show: true
            });
        }
    });

    init_selectpicker();
    $(".selectpicker").selectpicker('refresh');
}

function hr_profile_permissions_update_conf(staff_id, role_id, add_new) {
    "use strict";

    $("#modal_wrapper").load("<?php echo admin_url('hr_profile/hr_profile/permission_modal'); ?>", {
        slug: 'update',
        staff_id: staff_id,
        role_id: role_id,
        add_new: add_new,
        config: 1
    }, function() {
        if ($('.modal-backdrop.fade').hasClass('in')) {
            $('.modal-backdrop.fade').remove();
        }
        if ($('#appointmentModal').is(':hidden')) {
            $('#appointmentModal').modal({
                show: true
            });
        }
    });

    init_selectpicker();
    $(".selectpicker").selectpicker('refresh');
}
</script>