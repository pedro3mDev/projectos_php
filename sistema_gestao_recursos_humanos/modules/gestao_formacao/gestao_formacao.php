<?php
/*
Module Name: Gestão da Formação
Description: Módulo Gestão da Formação
Version: 1.0 
Requires at least: 1.0
Author: Team Petabyte
*/

defined('BASEPATH') or exit('No direct script access allowed');
define('GESTAO_FORMACAO_MODULE_NAME', 'gestao_formacao');
hooks()->add_action('admin_init', 'gestao_formacao_module_init_menu_items');
hooks()->add_action('app_search', 'gestao_formacao_load_search');
register_language_files(GESTAO_FORMACAO_MODULE_NAME, [GESTAO_FORMACAO_MODULE_NAME]);

define('VERSION_GESTAO_FORMACAO', 1094);
register_activation_hook(GESTAO_FORMACAO_MODULE_NAME, 'gestao_formacao_module_activation_hook');

function gestao_formacao_module_activation_hook()
{
	$CI = &get_instance();
	require_once(__DIR__ . '/install.php');
} 

$CI = & get_instance();
$CI->load->helper(GESTAO_FORMACAO_MODULE_NAME . '/gestao_formacao');

/**
 * Menús dos Módulos
 */
function gestao_formacao_module_init_menu_items() {
    $CI = &get_instance();
    $current_url = $CI->uri->uri_string(); 
    $is_gestao_formacao_module = strpos($current_url, 'gestao_formacao') !== false;

    if (has_permission('gestao_formacao', '', 'view') && $is_gestao_formacao_module) {
        // Adicionar o menu principal
        $CI->app_menu->add_sidebar_menu_item('gestao_formacao', [
            'name' => _l('Formação'),
            'icon' => 'fa fa-chalkboard-teacher',
            'position' => 2,
        ]);

        // Adicionar os submenus
        $submenus = [
            ['slug' => 'gestao_formacao-painel', 'name' => 'Painel', 'icon' => 'fa fa-tachometer-alt', 'href' => 'dashboard', 'position' => 1],
            ['slug' => 'gestao_formacao-cursos', 'name' => 'Cursos', 'icon' => 'fa fa-book', 'href' => 'cursos', 'position' => 2],
            ['slug' => 'gestao_formacao-formacao', 'name' => 'Formação', 'icon' => 'fa fa-graduation-cap', 'href' => 'formacao', 'position' => 3],
            ['slug' => 'gestao_formacao-impacto', 'name' => 'Impacto', 'icon' => 'fa fa-chart-line', 'href' => 'impacto', 'position' => 4],
            ['slug' => 'gestao_formacao-orçamento', 'name' => 'Orçamento', 'icon' => 'fa fa-money-bill-wave', 'href' => 'orcamento', 'position' => 5],
            ['slug' => 'gestao_formacao-risco', 'name' => 'Riscos', 'icon' => 'fa fa-exclamation-triangle', 'href' => 'riscos', 'position' => 6],
            ['slug' => 'gestao_formacao-personalizacao', 'name' => 'Personalização', 'icon' => 'fa fa-sliders-h', 'href' => 'personalizacao', 'position' => 7],
            ['slug' => 'gestao_formacao-competencias', 'name' => 'Competências', 'icon' => 'fa fa-lightbulb', 'href' => 'competencias', 'position' => 8],
            ['slug' => 'gestao_formacao-integracao', 'name' => 'Integração', 'icon' => 'fa fa-puzzle-piece', 'href' => 'integracao', 'position' => 9],
            ['slug' => 'gestao_formacao-compliance', 'name' => 'Compliance', 'icon' => 'fa fa-balance-scale', 'href' => 'compliance', 'position' => 10],
            ['slug' => 'gestao_formacao-tec_acesso', 'name' => 'Tec. Acesso', 'icon' => 'fa fa-key', 'href' => 'tec_acesso', 'position' => 11],
            ['slug' => 'gestao_formacao-suporte', 'name' => 'Suporte', 'icon' => 'fa fa-headset', 'href' => 'suporte', 'position' => 12],
            ['slug' => 'gestao_formacao-configuracoes', 'name' => 'configuracoes', 'icon' => 'fa fa-cogs', 'href' => 'configuracoes', 'position' => 13],
        ];
         
        foreach ($submenus as $submenu) {
            $CI->app_menu->add_sidebar_children_item('gestao_formacao', [
                'slug' => $submenu['slug'],
                'name' => _l($submenu['name']), 
                'icon' => $submenu['icon'],
                'href' => admin_url('gestao_formacao/' . $submenu['href']),
                'position' => $submenu['position'],
                'active' => (strpos($current_url, 'gestao_formacao/' . $submenu['href']) !== false), // Ativa se a URL contiver o submenu
            ]);
        }
    }
}