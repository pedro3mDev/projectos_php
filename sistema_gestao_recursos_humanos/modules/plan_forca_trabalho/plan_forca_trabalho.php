<?php
/*
Module Name: Planeamento de Força de Trabalho
Description: Modulo Planeamento de Força de Trabalho
Version: 1.0 
Requires at least: 1.0
Author: Team Petabyte
*/

defined('BASEPATH') or exit('No direct script access allowed');
define('PLAN_FORCA_TRABALHO_MODULE_NAME', 'plan_forca_trabalho');
hooks()->add_action('admin_init', 'plan_forca_trabalho_module_init_menu_items');
hooks()->add_action('app_search', 'plan_forca_trabalho_load_search');
define('VERSION_PLAN_FORCA_TRABALHO', 1094);
register_activation_hook(PLAN_FORCA_TRABALHO_MODULE_NAME, 'plan_forca_trabalho_module_activation_hook');

function plan_forca_trabalho_module_activation_hook()
{
	$CI = &get_instance(); 
	require_once(__DIR__ . '/install.php');
} 

$CI = & get_instance();
$CI->load->helper(PLAN_FORCA_TRABALHO_MODULE_NAME . '/plan_forca_trabalho');

/**
 * Menús dos Módulos
 */
function plan_forca_trabalho_module_init_menu_items() {
    $CI = &get_instance();
    $current_url = $CI->uri->uri_string(); 
    $is_plan_forca_trabalho_module = strpos($current_url, 'plan_forca_trabalho') !== false;

    if (has_permission('plan_forca_trabalho', '', 'view') && $is_plan_forca_trabalho_module) {
        // Adicionar o menu principal
        $CI->app_menu->add_sidebar_menu_item('plan_forca_trabalho', [
            'name' => _l('Força Trabalho'),
            'icon' => 'fas fa-users',
            'position' => 2, 
        ]);

        // Adicionar os submenus
        $submenus = [ 
            ['slug' => 'plan_forca_trabalho-painel', 'name' => 'Painel', 'icon' => 'fa fa-tachometer', 'href' => 'dashboard', 'position' => 1],
            ['slug' => 'plan_forca_trabalho-analise', 'name' => 'Analise', 'icon' => 'fa fa-edit', 'href' => 'analise', 'position' => 2],
            ['slug' => 'plan_forca_trabalho-planeamento', 'name' => 'Planeamento', 'icon' => 'fa fa-exchange', 'href' => 'planeamento', 'position' => 3],
            ['slug' => 'plan_forca_trabalho-identificacao', 'name' => 'Identificacao', 'icon' => 'fa fa-wrench', 'href' => 'identificacao', 'position' => 4],
            ['slug' => 'plan_forca_trabalho-alocacao', 'name' => 'Alocacao', 'icon' => 'fa fa-cogs', 'href' => 'alocacao', 'position' => 5],
            ['slug' => 'plan_forca_trabalho-simulacao', 'name' => 'Simulacao', 'icon' => 'fa fa-users', 'href' => 'simulacao', 'position' => 6],
            ['slug' => 'plan_forca_trabalho-ajustes', 'name' => 'Ajustes', 'icon' => 'fa fa-calculator', 'href' => 'ajustes', 'position' => 7],
            ['slug' => 'plan_forca_trabalho-monitoramento', 'name' => 'Monitoramento', 'icon' => 'fa fa-link', 'href' => 'monitoramento', 'position' => 8],
            ['slug' => 'plan_forca_trabalho-integracao', 'name' => 'Integracao', 'icon' => 'fa fa-link', 'href' => 'integracao', 'position' => 9],
            ['slug' => 'plan_forca_trabalho-previsao', 'name' => 'Previsao', 'icon' => 'fa fa-link', 'href' => 'previsao', 'position' => 10],
            ['slug' => 'plan_forca_trabalho-projeto', 'name' => 'Projeto', 'icon' => 'fa fa-link', 'href' => 'projeto', 'position' => 11],
            ['slug' => 'plan_forca_trabalho-configuracoes', 'name' => 'Configurações', 'icon' => 'fa fa-cogs', 'href' => 'configuracoes', 'position' => 12],
        ]; 
  
        foreach ($submenus as $submenu) {
            $CI->app_menu->add_sidebar_children_item('plan_forca_trabalho', [
                'slug' => $submenu['slug'],
                'name' => _l($submenu['name']), 
                'icon' => $submenu['icon'],
                'href' => admin_url('plan_forca_trabalho/' . $submenu['href']),
                'position' => $submenu['position'],
                'active' => (strpos($current_url, 'plan_forca_trabalho/' . $submenu['href']) !== false), // Ativa se a URL contiver o submenu
            ]);
        }
    }
}

