<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: Plano de Sucessão e Liderança
Description: Módulo Plano de Sucessão e Liderança
Version: 1.1.6
Requires at least: 2.3.*
Author: Petabyte
Author URI: https://codecanyon.net/user/greentech_solutions
*/

define('PLAN_SUCESS_LIDERENCA_MODULE_NAME', 'plan_sucess_lideranca');
hooks()->add_action('admin_init', 'plan_sucess_lideranca_module_init_menu_items');
/**
 * Register activation module hook
 */
// register_activation_hook(PLAN_SUCESS_LIDERENCA_MODULE_NAME, 'plan_sucess_lideranca_module_activation_hook');
/**
 * Load the module helper
 */
/**
 * Register language files, must be registered if the module is using languages
 */
register_language_files(PLAN_SUCESS_LIDERENCA_MODULE_NAME, [PLAN_SUCESS_LIDERENCA_MODULE_NAME]);

register_activation_hook(PLAN_SUCESS_LIDERENCA_MODULE_NAME, 'plan_sucess_lideranca_module_activation_hook');

function plan_sucess_lideranca_module_activation_hook()
{
	$CI = &get_instance();
	require_once(__DIR__ . '/install.php');
}

$CI = & get_instance();
$CI->load->helper(PLAN_SUCESS_LIDERENCA_MODULE_NAME . '/plan_sucess_lideranca');


/**
 * Init goals module menu items in setup in admin_init hook
 * @return null
 */

 function plan_sucess_lideranca_module_init_menu_items() {
    $CI = &get_instance();
    $current_url = $CI->uri->uri_string(); // Obtém a URL atual
    $is_plan_sucess_lideranca_module = strpos($current_url, 'plan_sucess_lideranca') !== false; // Verifica se está dentro do módulo

    // Verifica se o usuário tem permissão para visualizar o módulo e está na rota correta
    if (has_permission('plan_sucess_lideranca', '', 'view') && $is_plan_sucess_lideranca_module) {
        $CI->app_menu->add_sidebar_menu_item('plan_sucess_lideranca', [
            'name' => _l('Sucess. Liderança'),
            'icon' => 'fa fa-trophy',
            'position' => 2,
        ]);

        // Adicionar os submenus
        $submenus = [ 
            ['slug' => 'plan_sucess_lideranca-painel', 'name' => 'Painel', 'icon' => 'fa fa-tachometer', 'href' => 'dashboard', 'position' => 1], 
            ['slug' => 'plan_sucess_lideranca-identificacao', 'name' => 'Identificação', 'icon' => 'fa fa-id-badge', 'href' => 'identificacao', 'position' => 2], 
            ['slug' => 'plan_sucess_lideranca-planeamento', 'name' => 'Planeamento', 'icon' => 'fa fa-calendar-check', 'href' => 'planeamento', 'position' => 3], 
            ['slug' => 'plan_sucess_lideranca-desenvolvimento', 'name' => 'Desenvolvimento', 'icon' => 'fa fa-chart-line', 'href' => 'desenvolvimento', 'position' => 4], 
            ['slug' => 'plan_sucess_lideranca-competencias', 'name' => 'Competências', 'icon' => 'fa fa-lightbulb', 'href' => 'competencias', 'position' => 5], 
            ['slug' => 'plan_sucess_lideranca-mentoria_coaching', 'name' => 'Mentoria e Coaching', 'icon' => 'fa fa-chalkboard-teacher', 'href' => 'mentoria_coaching', 'position' => 6], 
            ['slug' => 'plan_sucess_lideranca-analise_risco', 'name' => 'Análise de Risco', 'icon' => 'fa fa-exclamation-triangle', 'href' => 'analise_risco', 'position' => 7], 
            ['slug' => 'plan_sucess_lideranca-engajamento', 'name' => 'Engajamento', 'icon' => 'fa fa-users', 'href' => 'engajamento', 'position' => 8], 
            ['slug' => 'plan_sucess_lideranca-configuracoes', 'name' => 'Configurações', 'icon' => 'fa fa-cogs', 'href' => 'configuracoes', 'position' => 9], 
        ];

        foreach ($submenus as $submenu) {
            $CI->app_menu->add_sidebar_children_item('plan_sucess_lideranca', [
                'slug' => $submenu['slug'],
                'name' => _l($submenu['name']), 
                'icon' => $submenu['icon'],
                'href' => admin_url('plan_sucess_lideranca/' . $submenu['href']),
                'position' => $submenu['position'],
                'active' => (strpos($current_url, 'plan_sucess_lideranca/' . $submenu['href']) !== false), // Ativa se a URL contiver o submenu
            ]);
        }
    }
}