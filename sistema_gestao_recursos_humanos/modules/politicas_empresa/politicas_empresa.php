<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: Politicas de Empresa
Description: Módulo Politicas de Empresa
Version: 1.1.6
Requires at least: 2.3.*
Author: Petabyte
Author URI: https://codecanyon.net/user/greentech_solutions
*/

define('POLITICAS_EMPRESA_MODULE_NAME', 'politicas_empresa');
hooks()->add_action('admin_init', 'politicas_empresa_module_init_menu_items');
/**
 * Register activation module hook
 */
// register_activation_hook(POLITICAS_EMPRESA_MODULE_NAME, 'politicas_empresa_module_activation_hook');
/**
 * Load the module helper
 */
/**
 * Register language files, must be registered if the module is using languages
 */
register_language_files(POLITICAS_EMPRESA_MODULE_NAME, [POLITICAS_EMPRESA_MODULE_NAME]);

register_activation_hook(POLITICAS_EMPRESA_MODULE_NAME, 'politicas_empresa_module_activation_hook');

function politicas_empresa_module_activation_hook()
{
	$CI = &get_instance();
	require_once(__DIR__ . '/install.php');
}

$CI = & get_instance();
$CI->load->helper(POLITICAS_EMPRESA_MODULE_NAME . '/politicas_empresa');


function politicas_empresa_module_init_menu_items() {
    $CI = &get_instance();
    $current_url = $CI->uri->uri_string(); // Obtém a URL atual
    $is_politicas_empresa_module = strpos($current_url, 'politicas_empresa') !== false; // Verifica se está dentro do módulo

    // Verifica se o usuário tem permissão para visualizar o módulo e está na rota correta
    if (has_permission('politicas_empresa', '', 'view') && $is_politicas_empresa_module) {
        // Adicionar o menu principal
        $CI->app_menu->add_sidebar_menu_item('politicas_empresa', [
            'name' => _l('pe_politica_empresa'),
            'icon' => 'fa fa-cog',
            'position' => 9,
        ]);

        // Definição dos submenus
        $submenus = [
            ['slug' => 'politicas-dashboard', 'name' => 'pe_painel', 'icon' => 'fa fa-dashboard', 'href' => '', 'position' => 1],
            ['slug' => 'politicas-listagem', 'name' => 'Politicas', 'icon' => 'fa fa-gavel', 'href' => 'listagem', 'position' => 2],
            ['slug' => 'politicas-revisao', 'name' => 'Aprovações', 'icon' => 'fa fa-tasks', 'href' => 'revisoes', 'position' => 3],
            ['slug' => 'politicas-conformidades', 'name' => 'pe_conformidades', 'icon' => 'fa fa-balance-scale', 'href' => 'conformidades', 'position' => 4],
            ['slug' => 'politicas-riscos', 'name' => 'pe_riscos', 'icon' => 'fa fa-exclamation-triangle', 'href' => 'riscos', 'position' => 5],
            ['slug' => 'politicas-procedimentos', 'name' => 'pe_procedimentos', 'icon' => 'fa fa-tasks', 'href' => 'procedimentos', 'position' => 6],
            ['slug' => 'politicas-comunicacoes', 'name' => 'pe_comunicacoes', 'icon' => 'fa fa-sms', 'href' => 'comunicacoes', 'position' => 7],
            ['slug' => 'politicas-processos', 'name' => 'pe_processos', 'icon' => 'fa fa-gavel', 'href' => 'processos', 'position' => 8],
            ['slug' => 'politicas-configuracoes', 'name' => 'pe_configuracoes', 'icon' => 'fa fa-cog', 'href' => 'configuracoes', 'position' => 9],
        ];

        // Adicionar os submenus dinamicamente
        foreach ($submenus as $submenu) {
            $CI->app_menu->add_sidebar_children_item('politicas_empresa', [
                'slug' => $submenu['slug'],
                'name' => _l($submenu['name']),
                'icon' => $submenu['icon'],
                'href' => admin_url('politicas_empresa/' . $submenu['href']),
                'position' => $submenu['position'],
                'active' => (strpos($current_url, 'politicas_empresa/' . $submenu['href']) !== false), // Ativa o submenu corretamente
            ]);
        }
    }
}
