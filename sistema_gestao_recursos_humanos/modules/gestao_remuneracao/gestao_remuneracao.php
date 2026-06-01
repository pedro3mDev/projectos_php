<?php
/*
Module Name: Gestão de Remuneração
Description: Módulo Gestão de Remuneração
Version: 1.0 
Requires at least: 1.0
Author: Team Petabyte
*/

defined('BASEPATH') or exit('No direct script access allowed');
define('GESTAO_REMUNERACAO_MODULE_NAME', 'gestao_remuneracao');
hooks()->add_action('admin_init', 'gestao_remuneracao_module_init_menu_items');
hooks()->add_action('app_search', 'gestao_remuneracao_load_search');
define('VERSION_GESTAO_REMUNERACAO', 1094);
register_activation_hook(GESTAO_REMUNERACAO_MODULE_NAME, 'gestao_remuneracao_module_activation_hook');

function gestao_remuneracao_module_activation_hook()
{
	$CI = &get_instance();
	require_once(__DIR__ . '/install.php');
} 

$CI = & get_instance();
$CI->load->helper(GESTAO_REMUNERACAO_MODULE_NAME . '/gestao_remuneracao');

/**
 * Menús dos Módulos
 */
function gestao_remuneracao_module_init_menu_items() {
    $CI = &get_instance();
    $current_url = $CI->uri->uri_string(); 
    $is_gestao_remuneracao_module = strpos($current_url, 'gestao_remuneracao') !== false;

    if (has_permission('gestao_remuneracao', '', 'view') && $is_gestao_remuneracao_module) {
        // Adicionar o menu principal
        $CI->app_menu->add_sidebar_menu_item('gestao_remuneracao', [
            'name' => _l('Remuneração'),
            'icon' => 'fa fa-line-chart',
            'position' => 2,
        ]);

        // Adicionar os submenus
        $submenus = [
            ['slug' => 'gestao_remuneracao-painel', 'name' => 'Painel', 'icon' => 'fa fa-tachometer', 'href' => 'dashboard', 'position' => 1],
            ['slug' => 'gestao_remuneracao-definicao', 'name' => 'Definição e Atualização', 'icon' => 'fa fa-edit', 'href' => 'definicao', 'position' => 2],
            ['slug' => 'gestao_remuneracao-comparacao', 'name' => 'Comparação', 'icon' => 'fa fa-exchange', 'href' => 'comparacao', 'position' => 3],
            ['slug' => 'gestao_remuneracao-revisao', 'name' => 'Revisão e Ajustes', 'icon' => 'fa fa-wrench', 'href' => 'revisao', 'position' => 4],
            ['slug' => 'gestao_remuneracao-gerenciamento', 'name' => 'Gerenciamento', 'icon' => 'fa fa-cogs', 'href' => 'gerenciamento', 'position' => 5],
            ['slug' => 'gestao_remuneracao-inscricao', 'name' => 'Inscrição e Gestão', 'icon' => 'fa fa-users', 'href' => 'inscricao', 'position' => 6],
            ['slug' => 'gestao_remuneracao-calculo', 'name' => 'Cálculo', 'icon' => 'fa fa-calculator', 'href' => 'calculo', 'position' => 7],
            ['slug' => 'gestao_remuneracao-integracao', 'name' => 'Integração', 'icon' => 'fa fa-link', 'href' => 'integracao', 'position' => 8],
            ['slug' => 'gestao_remuneracao-regulamentacoes', 'name' => 'Regulamentações', 'icon' => 'fa fa-balance-scale', 'href' => 'regulamentacoes', 'position' => 9],
            ['slug' => 'gestao_remuneracao-processamentos', 'name' => 'Processamentos', 'icon' => 'fa fa-cogs', 'href' => 'processamentos', 'position' => 10],
            ['slug' => 'gestao_remuneracao-relatorios', 'name' => 'Relatórios', 'icon' => 'fa fa-file-text', 'href' => 'relatorios', 'position' => 11],
            ['slug' => 'gestao_remuneracao-configuracoes', 'name' => 'Configurações', 'icon' => 'fa fa-cogs', 'href' => 'configuracoes', 'position' => 12],
        ];
 
        foreach ($submenus as $submenu) {
            $CI->app_menu->add_sidebar_children_item('gestao_remuneracao', [
                'slug' => $submenu['slug'],
                'name' => _l($submenu['name']), 
                'icon' => $submenu['icon'],
                'href' => admin_url('gestao_remuneracao/' . $submenu['href']),
                'position' => $submenu['position'],
                'active' => (strpos($current_url, 'gestao_remuneracao/' . $submenu['href']) !== false), // Ativa se a URL contiver o submenu
            ]);
        }
    }
}

