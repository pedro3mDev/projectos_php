<?php
/*
Module Name: Gestão de Engajamento de Talentos
Description: Módulo Gestão de Engajamento de Talentos
Version: 1.0 
Requires at least: 1.0
Author: Team Petabyte
*/

defined('BASEPATH') or exit('No direct script access allowed');
define('GESTAO_ENGAJAMENTO_TALENTOS_MODULE_NAME', 'gestao_engajamento_talentos');
hooks()->add_action('admin_init', 'gestao_engajamento_talentos_module_init_menu_items');
hooks()->add_action('app_search', 'gestao_engajamento_talentos_load_search');
define('VERSION_GESTAO_ENGAJAMENTO_TALENTOS', 1094);
register_activation_hook(GESTAO_ENGAJAMENTO_TALENTOS_MODULE_NAME, 'gestao_engajamento_talentos_module_activation_hook');

function gestao_engajamento_talentos_module_activation_hook()
{
	$CI = &get_instance();
	require_once(__DIR__ . '/install.php');
} 

$CI = & get_instance();
$CI->load->helper(GESTAO_ENGAJAMENTO_TALENTOS_MODULE_NAME . '/gestao_engajamento_talentos');

/**
 * Menús dos Módulos
 */
function gestao_engajamento_talentos_module_init_menu_items() {
    $CI = &get_instance();
    $current_url = $CI->uri->uri_string(); 
    $is_gestao_engajamento_talentos_module = strpos($current_url, 'gestao_engajamento_talentos') !== false;

    if (has_permission('gestao_engajamento_talentos', '', 'view') && $is_gestao_engajamento_talentos_module) {
        // Adicionar o menu principal
        $CI->app_menu->add_sidebar_menu_item('gestao_engajamento_talentos', [
            'name' => _l('Eng. Talentos'),
            'icon' => 'fas fa-users',
            'position' => 2,
        ]);

        // Adicionar os submenus
        $submenus = [
            ['slug' => 'gestao_engajamento_talentos-painel', 'name' => 'Painel', 'icon' => 'fa fa-tachometer', 'href' => 'dashboard', 'position' => 1],
            ['slug' => 'gestao_engajamento_talentos-pesquisas', 'name' => 'Pesquisas de Engajamento', 'icon' => 'fa fa-edit', 'href' => 'pesquisas', 'position' => 2],
            ['slug' => 'gestao_engajamento_talentos-programas', 'name' => 'Programas', 'icon' => 'fa fa-exchange', 'href' => 'programas', 'position' => 3],
            ['slug' => 'gestao_engajamento_talentos-comunicacao', 'name' => 'Comunicação', 'icon' => 'fa fa-wrench', 'href' => 'comunicacao', 'position' => 4],
            ['slug' => 'gestao_engajamento_talentos-feedback', 'name' => 'Feedback', 'icon' => 'fa fa-cogs', 'href' => 'feedback', 'position' => 5],
            ['slug' => 'gestao_engajamento_talentos-comunidade', 'name' => 'Comunidade', 'icon' => 'fa fa-users', 'href' => 'comunidade', 'position' => 6],
            ['slug' => 'gestao_engajamento_talentos-clima', 'name' => 'Clima Organizacional', 'icon' => 'fa fa-calculator', 'href' => 'clima', 'position' => 7],
            ['slug' => 'gestao_engajamento_talentos-conflitos', 'name' => 'Conflitos e Resoluções', 'icon' => 'fa fa-link', 'href' => 'conflitos', 'position' => 8],
        ]; 
  
        foreach ($submenus as $submenu) {
            $CI->app_menu->add_sidebar_children_item('gestao_engajamento_talentos', [
                'slug' => $submenu['slug'],
                'name' => _l($submenu['name']), 
                'icon' => $submenu['icon'],
                'href' => admin_url('gestao_engajamento_talentos/' . $submenu['href']),
                'position' => $submenu['position'],
                'active' => (strpos($current_url, 'gestao_engajamento_talentos/' . $submenu['href']) !== false), // Ativa se a URL contiver o submenu
            ]);
        }
    }
}

