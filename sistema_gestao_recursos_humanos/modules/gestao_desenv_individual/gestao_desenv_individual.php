<?php
/*
Module Name: Gestão de Desenvolvimento Individual
Description: Módulo Gestão de Desenvolvimento Individual
Version: 1.0 
Requires at least: 2.3.*
Author: Team Petabyte
*/

defined('BASEPATH') or exit('No direct script access allowed');
define('GESTAO_DESENV_INDIVIDUAL_MODULE_NAME', 'gestao_desenv_individual');
hooks()->add_action('admin_init', 'gestao_desenv_individual_module_init_menu_items');
hooks()->add_action('app_search', 'gestao_desenv_individual_load_search');
register_language_files(GESTAO_DESENV_INDIVIDUAL_MODULE_NAME, [GESTAO_DESENV_INDIVIDUAL_MODULE_NAME]);
define('VERSION_GESTAO_DESENV_INDIVIDUAL', 1094);
register_activation_hook(GESTAO_DESENV_INDIVIDUAL_MODULE_NAME, 'gestao_desenv_individual_module_activation_hook');

/**
 * Activação
 */
function gestao_desenv_individual_module_activation_hook()
{
	$CI = &get_instance();
	require_once(__DIR__ . '/install.php');
}

$CI = & get_instance();
$CI->load->helper(GESTAO_DESENV_INDIVIDUAL_MODULE_NAME . '/gestao_desenv_individual');

/**
 * Menús dos Módulos
 */
function gestao_desenv_individual_module_init_menu_items() {
    $CI = &get_instance();
    $current_url = $CI->uri->uri_string(); // Obtém a URL atual
    $is_gestao_desenv_module = strpos($current_url, 'gestao_desenv_individual') !== false; // Verifica se está dentro do módulo

    // Verifica se o usuário tem permissão para visualizar o módulo e está na rota correta
    if (has_permission('gestao_desenv_individual', '', 'view') && $is_gestao_desenv_module) {
        // Adicionar o menu principal
        $CI->app_menu->add_sidebar_menu_item('gestao_desenv_individual', [
            'name' => _l('Desenv. Individual'),
            'icon' => 'fa fa-user', 
            'position' => 2,
        ]);

        // Adicionar os submenus
        $submenus = [
            ['slug' => 'gestao_desenv_individual-painel', 'name' => 'Painel', 'icon' => 'fa fa-dashboard', 'href' => 'dashboard', 'position' => 1],
            ['slug' => 'gestao_desenv_individual-planos', 'name' => 'Planos', 'icon' => 'fa fa-tasks', 'href' => 'planos', 'position' => 3],
            ['slug' => 'gestao_desenv_individual-avaliacoes', 'name' => 'Avaliações', 'icon' => 'fa fa-star', 'href' => 'avaliacoes', 'position' => 2],
            ['slug' => 'gestao_desenv_individual-mentoria', 'name' => 'Mentoria', 'icon' => 'fa fa-handshake', 'href' => 'mentoria', 'position' => 4],
            ['slug' => 'gestao_desenv_individual-carreira', 'name' => 'Carreira', 'icon' => 'fa fa-briefcase', 'href' => 'carreira', 'position' => 5],
            ['slug' => 'gestao_desenv_individual-configuracoes', 'name' => 'Configurações', 'icon' => 'fa fa-cogs', 'href' => 'configuracoes', 'position' => 6],
        ];

        foreach ($submenus as $submenu) {
            $CI->app_menu->add_sidebar_children_item('gestao_desenv_individual', [
                'slug' => $submenu['slug'],
                'name' => _l($submenu['name']), 
                'icon' => $submenu['icon'],
                'href' => admin_url('gestao_desenv_individual/' . $submenu['href']),
                'position' => $submenu['position'],
                'active' => (strpos($current_url, 'gestao_desenv_individual/' . $submenu['href']) !== false), // Ativa se a URL contiver o submenu
            ]);
        }
    }
}

