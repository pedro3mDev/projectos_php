<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: Gestão de Viagens
Description: Módulo Gestãos de Viagem
Version: 1.1.6 
Requires at least: 2.3.*
Author: Petabyte
Author URI: https://codecanyon.net/user/greentech_solutions
*/

define('GESTAO_VIAGENS_MODULE_NAME', 'gestao_viagens');
hooks()->add_action('admin_init', 'gestao_viagens_module_init_menu_items');
/**
 * Register activation module hook
 */
// register_activation_hook(GESTAO_VIAGENS_MODULE_NAME, 'gestao_viagens_module_activation_hook');
/**
 * Load the module helper
 */
/**
 * Register language files, must be registered if the module is using languages
 */
register_language_files(GESTAO_VIAGENS_MODULE_NAME, [GESTAO_VIAGENS_MODULE_NAME]);

register_activation_hook(GESTAO_VIAGENS_MODULE_NAME, 'gestao_viagens_module_activation_hook');

function gestao_viagens_module_activation_hook()
{
	$CI = &get_instance();
	require_once(__DIR__ . '/install.php');
}

$CI = & get_instance();
$CI->load->helper(GESTAO_VIAGENS_MODULE_NAME . '/gestao_viagem');


/**
 * Init goals module menu items in setup in admin_init hook
 * @return null
 */

 function gestao_viagens_module_init_menu_items() {
    $CI = &get_instance();
    $current_url = $CI->uri->uri_string(); // Obtém a URL atual
    $is_gestao_viagens_module = strpos($current_url, 'gestao_viagens') !== false; // Verifica se está dentro do módulo

    // Verifica se o usuário tem permissão para visualizar o módulo e está na rota correta
    if (has_permission('gestao_viagens', '', 'view') && $is_gestao_viagens_module) {
        // Adicionar o menu principal
        $CI->app_menu->add_sidebar_menu_item('gestao_viagens', [
            'name' => _l('Gestão de Viagens'),
            'icon' => 'fa fa-plane',
            'position' => 5,
        ]);

        // Definição dos submenus
        $submenus = [
            ['slug' => 'gestao_viagens_painel', 'name' => 'Painel', 'icon' => 'fa fa-tachometer-alt', 'href' => 'index', 'position' => 1],
            ['slug' => 'gestao_viagens_planejamento', 'name' => 'Planejamento', 'icon' => 'fa fa-tasks', 'href' => 'pedidos', 'position' => 2],
            ['slug' => 'gestao_viagens_reservas', 'name' => 'Reservas', 'icon' => 'fa fa-calendar-check', 'href' => 'pedidos/reservas', 'position' => 3],
            ['slug' => 'gestao_viagens_orcamentos', 'name' => 'Orçamentos', 'icon' => 'fa fa-money-bill-wave', 'href' => 'orcamentos', 'position' => 4],
            ['slug' => 'gestao_viagens_despesas', 'name' => 'Despesas', 'icon' => 'fa fa-wallet', 'href' => 'despesas', 'position' => 5],
			['slug' => 'gestao_viagens_comunicacao', 'name' => 'Comunicacao', 'icon' => 'fa fa-paper-plane', 'href' => 'comunicacao', 'position' => 6],
			['slug' => 'gestao_viagens_feedback', 'name' => 'Feedback', 'icon' => 'fa fa-comment-dots', 'href' => 'feedback', 'position' => 8],
            ['slug' => 'gestao_viagens_configuracoes', 'name' => 'Configurações', 'icon' => 'fa fa-cogs', 'href' => 'configuracoes', 'position' => 9],
        ];

        // Adicionar os submenus dinamicamente
        foreach ($submenus as $submenu) {
            $CI->app_menu->add_sidebar_children_item('gestao_viagens', [
                'slug' => $submenu['slug'],
                'name' => _l($submenu['name']),
                'icon' => $submenu['icon'],
                'href' => admin_url('gestao_viagens/' . $submenu['href']),
                'position' => $submenu['position'],
                'active' => (strpos($current_url, 'gestao_viagens/' . $submenu['href']) !== false), // Ativa se a URL contiver o submenu
            ]);
        }
    }
}




			/*

            $CI->app_menu->add_sidebar_children_item('gestao_viagens', [
                'slug' => 'gestao_viagens_pedidos',
                'name' => _l('Pedidos'),
                'icon' => 'fa fa-bar-chart',
                'href' => admin_url('gestao_viagens/pedidos'),
                'position' => 12,
            ]);
			*/


/*
function gestao_viagens_module_init_menu_items()
{

	$CI = &get_instance();
	if (has_permission('gestao_viagens', '', 'view')) {
		$CI->app_menu->add_sidebar_menu_item('gestao_viagens', [
			'name' => _l('gestao_viagens'),
			'icon' => 'fa fa-puzzle-piece',
			'position' => 4,
		]);
		$CI->app_menu->add_sidebar_children_item('gestao_viagens', [
			'slug' => 'panell',
			'name' => _l('panel'),
			'icon' => 'fa fa-street-view',
			'href' => admin_url('gestao_viagens/index'),
			'position' => 1,
		]);
		$CI->app_menu->add_sidebar_children_item('gestao_viagens', [
			'slug' => 'pedidos',
			'name' => _l('Pedidos'),
			'icon' => 'fa fa-bar-chart',
			'href' => admin_url('gestao_viagens/pedidos'),
			'position' => 2,
		]);
		$CI->app_menu->add_sidebar_children_item('gestao_viagens', [
			'slug' => 'orcamentos',
			'name' => _l('orcamentos'),
			'icon' => 'fa fa-bar-chart',
			'href' => admin_url('gestao_viagens/orcamentos'),
			'position' => 2,
		]);
		$CI->app_menu->add_sidebar_children_item('gestao_viagens', [
			'slug' => 'feedback',
			'name' => _l('feedback'),
			'icon' => 'fa fa-bar-chart',
			'href' => admin_url('gestao_viagens/feedback'),
			'position' => 2,
		]);
		$CI->app_menu->add_sidebar_children_item('gestao_viagens', [
			'slug' => 'politica_viagem',
			'name' => _l('politica_viagem'),
			'icon' => 'fa fa-bar-chart',
			'href' => admin_url('gestao_viagens/politica_viagem'),
			'position' => 2,
		]);
		$CI->app_menu->add_sidebar_children_item('gestao_viagens', [
			'slug' => 'Configurações',
			'name' => _l('Configurações'),
			'icon' => 'fa fa-bar-chart',
			'href' => admin_url('gestao_viagens/configurar'),
			'position' => 2,
		]);
	}
	
	


	// function mapeamento_add_head_components()
	// {
	// 	$CI = &get_instance();
	// 	$viewuri = $_SERVER['REQUEST_URI'];

	// 	if (!(strpos($viewuri, 'gestao_viagens/gestao_viagem') === false)) {
	// 		echo '<link href="' . module_dir_url(GESTAO_VIAGENS_MODULE_NAME, 'assets/bootstrap/css/bootstrap.min.css') . '"  rel="stylesheet" type="text/css" />';
	// 	}
	// }
	// function mapeamento_add_footer_components()
	// {
	// 	$CI = &get_instance();
	// 	$viewuri = $_SERVER['REQUEST_URI'];

	// 	if (!(strpos($viewuri, 'gestao_viagens/gestao_viagem') === false)) {
	// 		echo '<script src="' . module_dir_url(GESTAO_VIAGENS_MODULE_NAME, 'assets/bootstrap/js/bootstrap.min.js') . '"></script>';
	// 	}
	// }
}

*/