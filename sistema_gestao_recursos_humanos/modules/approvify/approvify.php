<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: Requisições
Description: Online Approvals Management for Perfex CRM. Streamline and accelerate your approval processes with ease. Automate workflows, gain real-time insights, and ensure compliance effortlessly. Optimize efficiency, reduce bottlenecks, and improve decision-making. Elevate your CRM experience with seamless approvals.
Version: 1.2.0
Author: Team Petabyte
Author URI: https://codecanyon.net/user/lenzcreativee/portfolio
Requires at least: 1.0.*
*/

define('APPROVIFY_MODULE_NAME', 'approvify');

hooks()->add_action('admin_init', 'approvify_module_init_menu_items');
hooks()->add_action('admin_init', 'approvify_permissions');
//hooks()->add_action('approvify_init', APPROVIFY_MODULE_NAME . '_appint');
//hooks()->add_action('pre_activate_module', APPROVIFY_MODULE_NAME . '_preactivate');
//hooks()->add_action('pre_deactivate_module', APPROVIFY_MODULE_NAME . '_predeactivate');
hooks()->add_action('pre_uninstall_module', APPROVIFY_MODULE_NAME . '_uninstall');


require(__DIR__ . '/services/ApprovifyRequestsKanBan.php');

/**
 * Load the module helper
 */
$CI = &get_instance();
$CI->load->helper(APPROVIFY_MODULE_NAME . '/approvify'); //on module main file

function approvify_permissions()
{
    $capabilities = [];

    $capabilities['capabilities'] = [
        'view' => _l('permission_view'),
        'create' => _l('permission_create'),
        'edit' => _l('permission_edit'),
        'delete' => _l('permission_delete'),
        'create_category' => _l('approvify_create_categories'),
    ];
    register_staff_capabilities('approvify', $capabilities, _l('approvify'));
}

/**
 * Register activation module hook
 */
register_activation_hook(APPROVIFY_MODULE_NAME, 'approvify_module_activation_hook');

function approvify_module_activation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/install.php');
}

/**
 * Register language files, must be registered if the module is using languages
 */
register_language_files(APPROVIFY_MODULE_NAME, [APPROVIFY_MODULE_NAME]);

/**
 * Init module menu items in setup in admin_init hook
 * @return null
 */

 
 function approvify_module_init_menu_items()
 {
     $CI = &get_instance();
 
     // Obtém a classe atual
     $current_class = $CI->router->fetch_class();
 
     // Define as rotas pertencentes ao módulo `approvify`
     $approvify_routes = [
         'approvify',
         'manage_requests',
         'manage_created_requests',
         'manage_review_requests',
         'manage_types',
     ];
 
     // Verifica se a rota atual pertence ao módulo
     if (in_array($current_class, $approvify_routes)) {
         // Adiciona o menu principal apenas para usuários com permissão de visualização
         if (has_permission('approvify', '', 'view')) {
             $CI->app_menu->add_sidebar_menu_item('approvify', [
                 'slug' => 'approvify',
                 'name' => _l('Requisições'),
                 'position' => 6,
                 'icon' => 'fas fa-check' 
             ]);
         }
 
         // Adiciona submenus com base na permissão
         if (has_permission('approvify', '', 'create')) {
             $CI->app_menu->add_sidebar_children_item('approvify', [
                 'slug' => 'approvify-panel',
                 'name' => _l('Painel'),
                 'position' => 1,
                 'icon' => 'fas fa-tachometer-alt',
                 'href' => admin_url('approvify/')
             ]);
 
             $CI->app_menu->add_sidebar_children_item('approvify', [
                 'slug' => 'approvify-create-request',
                 'name' => _l('Novas Requisições'),
                 'position' => 2,
                 'icon' => 'fas fa-plus-circle', 
                 'href' => admin_url('approvify/manage_requests')
             ]);
  
             $CI->app_menu->add_sidebar_children_item('approvify', [
                 'slug' => 'approvify-my-request',
                 'name' => _l('Minhas Requisições'),
                 'position' => 3,
                 'icon' => 'fas fa-tasks',
                 'href' => admin_url('approvify/manage_created_requests')
             ]);
         }
 
         if (has_permission('approvify', '', 'view')) {
             $CI->app_menu->add_sidebar_children_item('approvify', [
                 'slug' => 'approvify-review-request',
                 'name' => _l('Aprovações'),
                 'position' => 4,
                 'icon' => 'fas fa-exchange-alt',
                 'href' => admin_url('approvify/manage_review_requests')
             ]);
         }
 
        //  if (has_permission('approvify', '', 'create_category')) {
        //      $CI->app_menu->add_sidebar_children_item('approvify', [
        //          'slug' => 'approvify-request-categories',
        //          'name' => _l('Categorias'),
        //          'position' => 5,
        //          'icon' => 'fas fa-layer-group',
        //          'href' => admin_url('approvify/manage_types')
        //      ]);
        //  }
         
         if (has_permission('approvify', '', 'create_category')) {
            $CI->app_menu->add_sidebar_children_item('approvify', [
                'slug' => '',
                'name' => _l('Configurações'),
                'position' => 6,
                'icon' => 'fas fa-cog',
                'href' => admin_url('approvify/configuracoes')
            ]);
        }
        
         
     }
 }


hooks()->add_action('after_custom_fields_select_options', 'approvify_new_custom_field_types');
function approvify_new_custom_field_types($custom_field)
{
    require(__DIR__ . '/models/Approvify_model.php');

    $CI = &get_instance();
    $CI->load->model('approvify_model');

    $approvifyCategories = $CI->approvify_model->getTypes();

    if (!empty($approvifyCategories)) {
        foreach ($approvifyCategories as $category) {
            ?>
            <option value="approvify_<?php echo $category['id']; ?>" <?php if (isset($custom_field) && $custom_field->fieldto == 'approvify_' . $category['id']) {
                echo 'selected';
            } ?>>Staff Approvals Category | <?php echo $category['category_name'] ?: ''; ?></option>
            <?php
        }
    }
}

function approvify_appint()
{
    $CI = &get_instance();
    require_once 'libraries/leclib.php';
    $module_api = new ApprovifyLic();
    $module_leclib = $module_api->verify_license(true);
    if (!$module_leclib || ($module_leclib && isset($module_leclib['status']) && !$module_leclib['status'])) {
        $CI->app_modules->deactivate(APPROVIFY_MODULE_NAME);
        set_alert('danger', "One of your modules failed its verification and got deactivated. Please reactivate or contact support.");
        redirect(admin_url('modules'));
    }
}

function approvify_preactivate($module_name)
{
    if ($module_name['system_name'] == APPROVIFY_MODULE_NAME) {
        require_once 'libraries/leclib.php';
        $module_api = new ApprovifyLic();
        $module_leclib = $module_api->verify_license();
        if (!$module_leclib || ($module_leclib && isset($module_leclib['status']) && !$module_leclib['status'])) {
            $CI = &get_instance();
            $data['submit_url'] = $module_name['system_name'] . '/lecverify/activate';
            $data['original_url'] = admin_url('modules/activate/' . APPROVIFY_MODULE_NAME);
            $data['module_name'] = APPROVIFY_MODULE_NAME;
            $data['title'] = "Module License Activation";
            echo $CI->load->view($module_name['system_name'] . '/activate', $data, true);
            exit();
        }
    }
}

function approvify_predeactivate($module_name)
{
    if ($module_name['system_name'] == APPROVIFY_MODULE_NAME) {
        require_once 'libraries/leclib.php';
        $warehouse_api = new ApprovifyLic();
        $warehouse_api->deactivate_license();
    }
}

function approvify_uninstall($module_name)
{
    if ($module_name['system_name'] == APPROVIFY_MODULE_NAME) {
        require_once 'libraries/leclib.php';
        $warehouse_api = new ApprovifyLic();
        $warehouse_api->deactivate_license();
    }
}