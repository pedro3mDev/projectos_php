<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: Configurações
Description: Módulo Configurações
Version: 1.0
Author: Petabyte
*/

define('CONFIGURACAOES_MODULE_NAME', 'configuracoes');
hooks()->add_action('admin_init', 'configuracoes_module_init_menu_items');
register_language_files(CONFIGURACAOES_MODULE_NAME, [CONFIGURACAOES_MODULE_NAME]);
register_activation_hook(CONFIGURACAOES_MODULE_NAME, 'configuracoes_module_activation_hook');

function configuracoes_module_activation_hook()
{
	$CI = &get_instance();
	require_once(__DIR__ . '/install.php');
}

$CI = & get_instance();
$CI->load->helper(CONFIGURACAOES_MODULE_NAME . '/configuracoes');


function configuracoes_module_init_menu_items() {
    $CI = &get_instance();
    $current_url = $CI->uri->uri_string(); // Obtém a URL completa (ex: "admin/configuracoes/sistema")
    $is_configuracoes_module = strpos($current_url, 'configuracoes') !== false; // Verifica se "configuracoes" está na URL

    if (has_permission('configuracoes', '', 'view') && $is_configuracoes_module) {
        // Adiciona o menu principal
        $CI->app_menu->add_sidebar_menu_item('configuracoes', [
            'name' => _l('Configurações'),
            'icon' => 'fa fa-cog',
            'position' => 10,
        ]);
 
        // Definição de submenus do módulo
        $submenus = [
            ['slug' => 'dashboard-configuracoes', 'name' => 'Dashboard', 'icon' => 'fa fa-dashboard', 'href' => 'configuracoes', 'position' => 1],
            ['slug' => 'config-gerais', 'name' => 'Gerais', 'icon' => 'fa fa-sliders', 'href' => 'settings', 'position' => 2],
            ['slug' => 'config-sistema', 'name' => 'Sistema', 'icon' => 'fa fa-cogs', 'href' => 'configuracoes/sistema', 'position' => 3],
            ['slug' => 'config-modulos', 'name' => 'Módulo', 'icon' => 'fa fa-folder', 'href' => 'modules', 'position' => 4],            
        ];

        foreach ($submenus as $submenu) {
            $CI->app_menu->add_sidebar_children_item('configuracoes', [
                'slug' => $submenu['slug'],
                'name' => _l($submenu['name']),
                'icon' => $submenu['icon'],
                'href' => admin_url($submenu['href']),
                'position' => $submenu['position'],
                'active' => (strpos($current_url, $submenu['href']) !== false), // Ativa se a URL contiver o submenu
            ]);
        }
    }
}

