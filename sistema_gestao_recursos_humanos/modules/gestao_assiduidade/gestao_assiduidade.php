<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: Gestãos de Assiduidades
Description: Módulo Gestãos de Assiduidades
Version: 1.1.6
Requires at least: 2.3.*
Author: Petabyte
Author URI: https://codecanyon.net/user/greentech_solutions
*/

define('GESTAO_ASSIDUIDADE_MODULE_NAME', 'gestao_assiduidade');
hooks()->add_action('admin_init', 'gestao_assiduidade_module_init_menu_items');
hooks()->add_action('app_search', 'gestao_assiduidade_load_search');
/**
 * Register activation module hook
 */
// register_activation_hook(COMPETENCIAS_MODULE_NAME, 'competencias_module_activation_hook');
/**
 * Load the module helper
 */
/**
 * Register language files, must be registered if the module is using languages
 */

 define('VERSION_GESTAO_ASSIDUIDADE', 1094);
register_language_files(GESTAO_ASSIDUIDADE_MODULE_NAME, [GESTAO_ASSIDUIDADE_MODULE_NAME]);

/**
 * Init goals module menu items in setup in admin_init hook
 * @return null
 */
register_activation_hook(GESTAO_ASSIDUIDADE_MODULE_NAME, 'gestao_assiduidade_module_activation_hook');

function gestao_assiduidade_module_activation_hook()
{
	$CI = &get_instance();
	require_once(__DIR__ . '/install.php');
}

$CI = & get_instance();
$CI->load->helper(GESTAO_ASSIDUIDADE_MODULE_NAME . '/gestao_assiduidade');

function gestao_assiduidade_module_init_menu_items() {
    $CI = &get_instance();
    $current_url = $CI->uri->uri_string(); // Obtém a URL atual
    $is_gestao_assiduidade_module = strpos($current_url, 'gestao_assiduidade') !== false; // Verifica se está dentro do módulo

    // Verifica se o usuário tem permissão para visualizar o módulo e está na rota correta
    if (has_permission('gestao_assiduidade', '', 'view') && $is_gestao_assiduidade_module) {
        // Adicionar o menu principal
        $CI->app_menu->add_sidebar_menu_item('gestao_assiduidade', [
            'name' => _l('Assiduidade'),
            'icon' => 'fa fa-calendar',
            'position' => 37,
        ]);

        // Definição dos submenus
        $submenus = [
            ['slug' => 'gestao_assiduidade-dashboard', 'name' => 'Painel', 'icon' => 'fa fa-dashboard', 'href' => 'dashboard', 'position' => 2],
            ['slug' => 'gestao_assiduidade-registo', 'name' => 'Registo', 'icon' => 'fa fa-edit', 'href' => 'index', 'position' => 3],
            ['slug' => 'gestao_assiduidade-ferias', 'name' => 'Férias', 'icon' => 'fa fa-plane', 'href' => 'gestao_de_ferias_geral', 'position' => 4],
            ['slug' => 'gestao_assiduidade-horarios-turnos', 'name' => 'Horários e Turnos', 'icon' => 'fa fa-clock', 'href' => 'horario_turno', 'position' => 5],
            ['slug' => 'gestao_assiduidade-relatorios', 'name' => 'Estatísticas', 'icon' => 'fa fa-chart-bar', 'href' => 'relatorios', 'position' => 6],
            ['slug' => 'gestao_assiduidade-configuracoes', 'name' => 'Configurações', 'icon' => 'fa fa-cogs', 'href' => 'configuracoes?group=periodo_laboral', 'position' => 7],
        ];

        // Adicionar os submenus dinamicamente
        foreach ($submenus as $submenu) {
            $CI->app_menu->add_sidebar_children_item('gestao_assiduidade', [
                'slug' => $submenu['slug'],
                'name' => _l($submenu['name']),
                'icon' => $submenu['icon'],
                'href' => admin_url('gestao_assiduidade/' . $submenu['href']),
                'position' => $submenu['position'],
                'active' => (strpos($current_url, 'gestao_assiduidade/' . $submenu['href']) !== false), // Ativa o submenu se a URL contiver o link correspondente
            ]);
        }
    }
}
