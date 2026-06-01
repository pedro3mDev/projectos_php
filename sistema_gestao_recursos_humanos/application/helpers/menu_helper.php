<?php
defined('BASEPATH') or exit('No direct script access allowed');

function app_init_admin_sidebar_menu_items()
{
    $CI = &get_instance();


    // Carregar a biblioteca app_menu, se ainda não estiver carregada
    if (!isset($CI->app_menu)) {
        $CI->load->library('app_menu');
    }

    // Verifique se o app_menu foi carregado corretamente
    if (!isset($CI->app_menu)) {
        log_message('error', 'app_menu não está carregado corretamente');
        return; // Saia da função se o app_menu não estiver disponível
    }
    
    // Verifica a rota atual
    $current_class = $CI->router->fetch_class();
    $current_method = $CI->router->fetch_method();

    // Adiciona o item de menu 'dashboard' para todas as rotas
    $CI->app_menu->add_sidebar_menu_item('dashboard', [
        'name'     => _l('Painel Global'),
        'href'     => admin_url(),
        'position' => 1,
        'icon'     => 'fa-regular fa-object-group',
        'badge'    => [],
    ]);

    /*
    // Verifica se a rota atual é 'projects' ou 'dashboard' (página inicial)
    if ($current_class === 'projects' || $current_class === 'dashboard' || ($current_class === '' && $current_method === 'index')) {
        $CI->app_menu->add_sidebar_menu_item('projects', [
            'name'     => _l('projects'),
            'href'     => admin_url('projects'),
            'icon'     => 'fa-solid fa-chart-gantt',
            'position' => 30,
            'badge'    => [],
        ]);
    }
    */

    /*
    if ($current_class === 'clients' || $current_class === 'dashboard' || ($current_class === '' && $current_method === 'index')) {
        $CI->app_menu->add_sidebar_menu_item('customers', [
            'name'     => _l('Colaborador'),
            'href'     => admin_url('clients'),
            'position' => 2,
            'icon'     => 'fa-regular fa-user',
            'badge'    => [],
        ]);
    }
    
    */

    if ($current_class === 'tasks' || $current_class === 'dashboard' || ($current_class === '' && $current_method === 'index')) {
        $CI->app_menu->add_sidebar_menu_item('tasks', [
            'name'     => _l('als_tasks'),
            'href'     => admin_url('tasks'),
            'icon'     => 'fa-regular fa-circle-check',
            'position' => 35,
            'badge'    => [],
        ]);
    }

    /*/ Adiciona o item de menu para 'settings' (configurações)
    if ($current_class === 'settings') {
        $CI->app_menu->add_sidebar_menu_item('settings', [
            'name'     => _l('settings'),
            'href'     => admin_url('settings'),
            'icon'     => 'fa-solid fa-cogs',
            'position' => 40,
            'badge'    => [],
        ]);
    }*/


    // Adicionando um item de menu para o módulo de 'recruitment' (recrutamento)
    if ($current_class === 'recruitment') {
        $CI->app_menu->add_sidebar_menu_item('recruitment', [
            'name'     => _l('Recruitment'),
            'href'     => admin_url('recruitment'),
            'icon'     => 'fa-solid fa-briefcase',
            'position' => 45,
            'badge'    => [],
        ]);
    }


    // Adicionando um item de menu para 'invoices' (faturas)
    if ($current_class === 'invoices') {
        $CI->app_menu->add_sidebar_menu_item('invoices', [
            'name'     => _l('invoices'),
            'href'     => admin_url('invoices'),
            'icon'     => 'fa-solid fa-file-invoice',
            'position' => 50,
            'badge'    => [],
        ]);
    }

    // Adicionando um item de menu para 'contracts' (contratos)
    if ($current_class === 'contracts') {
        $CI->app_menu->add_sidebar_menu_item('contracts', [
            'name'     => _l('contracts'),
            'href'     => admin_url('contracts'),
            'icon'     => 'fa-solid fa-file-contract',
            'position' => 55,
            'badge'    => [],
        ]);
    }

    /*
    if ($current_class === 'clients' || $current_class === 'dashboard' || ($current_class === '' && $current_method === 'index')) {
        $CI->app_menu->add_sidebar_menu_item('customers', [
            'name'     => _l('als_clients'),
            'href'     => admin_url('clients'),
            'position' => 2,
            'icon'     => 'fa-regular fa-user',
            'badge'    => [],
        ]);
    }
    */

    // Adicionando um item de menu para 'employees' (funcionários)
    if ($current_class === 'employees') {
        $CI->app_menu->add_sidebar_menu_item('employees', [
            'name'     => _l('employees'),
            'href'     => admin_url('employees'),
            'icon'     => 'fa-solid fa-users',
            'position' => 60,
            'badge'    => [],
        ]);
    }


    // Outros itens de menu podem ser adicionados da mesma forma
    // Exemplo: Adicionar módulo de 'attendance' (frequência)
    if ($current_class === 'attendance') {
        $CI->app_menu->add_sidebar_menu_item('attendance', [
            'name'     => _l('attendance'),
            'href'     => admin_url('attendance'),
            'icon'     => 'fa-solid fa-calendar-check',
            'position' => 65,
            'badge'    => [],
        ]);
    }
    
}


/*
defined('BASEPATH') or exit('No direct script access allowed');

function app_init_admin_sidebar_menu_items()
{
    $CI = &get_instance();

    // Verifica a rota atual
    $current_class = $CI->router->fetch_class();
    $current_method = $CI->router->fetch_method();

    // Adiciona o item de menu 'dashboard' para todas as rotas

    $CI->app_menu->add_sidebar_menu_item('dashboard', [
        'name'     => _l('als_dashboard'),
        'href'     => admin_url(),
        'position' => 1,
        'icon'     => 'fa-regular fa-object-group',
        'badge'    => [],
    ]);

    // Verifica se a rota atual é 'projects' ou 'dashboard' (página inicial)
    if ($current_class === 'projects' || $current_class === 'dashboard' || ($current_class === '' && $current_method === 'index')) {
        $CI->app_menu->add_sidebar_menu_item('projects', [
            'name'     => _l('projects'),
            'href'     => admin_url('projects'),
            'icon'     => 'fa-solid fa-chart-gantt',
            'position' => 30,
            'badge'    => [],
        ]);
    }

    if ($current_class === 'clients' || $current_class === 'dashboard' || ($current_class === '' && $current_method === 'index')) {
        $CI->app_menu->add_sidebar_menu_item('customers', [
            'name'     => _l('als_clients'),
            'href'     => admin_url('clients'),
            'position' => 2,
            'icon'     => 'fa-regular fa-user',
            'badge'    => [],
        ]);
    }
    
    if ($current_class === 'tasks' || $current_class === 'dashboard' || ($current_class === '' && $current_method === 'index')) {
        $CI->app_menu->add_sidebar_menu_item('tasks', [
            'name'     => _l('als_tasks'),
            'href'     => admin_url('tasks'),
            'icon'     => 'fa-regular fa-circle-check',
            'position' => 35,
            'badge'    => [],
        ]);
    }

    // Verifica se a rota atual é 'projects', 'dashboard', ou a página inicial ('admin_url()')
    if ($current_class === 'projects' || $current_class === 'dashboard' || ($current_class === '' && $current_method === 'index')) {
        $CI->app_menu->add_sidebar_menu_item('projects', [
            'name'     => _l('projects'),
            'href'     => admin_url('projects'),
            'icon'     => 'fa-solid fa-chart-gantt',
            'position' => 30,
            'badge'    => [],
        ]);
    }

    // Adiciona o item de menu 'staff' para quem tem permissão
    if (staff_can('view', 'staff')) {
        $CI->app_menu->add_setup_menu_item('staff', [
            'name'     => _l('als_staff'),
            'href'     => admin_url('staff'),
            'position' => 5,
            'badge'    => [],
        ]);
    }

    // Verifica se o usuário é admin e adiciona o menu com as opções de clientes e suporte
    if (is_admin()) {
        $CI->app_menu->add_setup_menu_item('customers', [
            'collapse' => true,
            'name'     => _l('clients'),
            'position' => 10,
            'badge'    => [],
        ]);

        $CI->app_menu->add_setup_children_item('customers', [
            'slug'     => 'customer-groups',
            'name'     => _l('customer_groups'),
            'href'     => admin_url('clients/groups'),
            'position' => 5,
            'badge'    => [],
        ]);
        
        // Submenus de suporte
        $CI->app_menu->add_setup_menu_item('support', [
            'collapse' => true,
            'name'     => _l('support'),
            'position' => 15,
            'badge'    => [],
        ]);

        $CI->app_menu->add_setup_children_item('support', [
            'slug'     => 'departments',
            'name'     => _l('acs_departments'),
            'href'     => admin_url('departments'),
            'position' => 5,
            'badge'    => [],
        ]);
        $CI->app_menu->add_setup_children_item('support', [
            'slug'     => 'tickets-predefined-replies',
            'name'     => _l('acs_ticket_predefined_replies_submenu'),
            'href'     => admin_url('tickets/predefined_replies'),
            'position' => 10,
            'badge'    => [],
        ]);
        $CI->app_menu->add_setup_children_item('support', [
            'slug'     => 'tickets-priorities',
            'name'     => _l('acs_ticket_priority_submenu'),
            'href'     => admin_url('tickets/priorities'),
            'position' => 15,
            'badge'    => [],
        ]);
        $CI->app_menu->add_setup_children_item('support', [
            'slug'     => 'tickets-statuses',
            'name'     => _l('acs_ticket_statuses_submenu'),
            'href'     => admin_url('tickets/statuses'),
            'position' => 20,
            'badge'    => [],
        ]);
        $CI->app_menu->add_setup_children_item('support', [
            'slug'     => 'tickets-services',
            'name'     => _l('acs_ticket_services_submenu'),
            'href'     => admin_url('tickets/services'),
            'position' => 25,
            'badge'    => [],
        ]);
        $CI->app_menu->add_setup_children_item('support', [
            'slug'     => 'tickets-spam-filters',
            'name'     => _l('spam_filters'),
            'href'     => admin_url('spam_filters/view/tickets'),
            'position' => 30,
            'badge'    => [],
        ]);

        // Menu de Leads
        $CI->app_menu->add_setup_menu_item('leads', [
            'collapse' => true,
            'name'     => _l('acs_leads'),
            'position' => 20,
            'badge'    => [],
        ]);
        $CI->app_menu->add_setup_children_item('leads', [
            'slug'     => 'leads-sources',
            'name'     => _l('acs_leads_sources_submenu'),
            'href'     => admin_url('leads/sources'),
            'position' => 5,
            'badge'    => [],
        ]);
        $CI->app_menu->add_setup_children_item('leads', [
            'slug'     => 'leads-statuses',
            'name'     => _l('acs_leads_statuses_submenu'),
            'href'     => admin_url('leads/statuses'),
            'position' => 10,
            'badge'    => [],
        ]);
        $CI->app_menu->add_setup_children_item('leads', [
            'slug'     => 'leads-email-integration',
            'name'     => _l('leads_email_integration'),
            'href'     => admin_url('leads/email_integration'),
            'position' => 15,
            'badge'    => [],
        ]);
        $CI->app_menu->add_setup_children_item('leads', [
            'slug'     => 'web-to-lead',
            'name'     => _l('web_to_lead'),
            'href'     => admin_url('leads/forms'),
            'position' => 20,
            'badge'    => [],
        ]);

        // Menu Financeiro
        $CI->app_menu->add_setup_menu_item('finance', [
            'collapse' => true,
            'name'     => _l('acs_finance'),
            'position' => 25,
            'badge'    => [],
        ]);
        $CI->app_menu->add_setup_children_item('finance', [
            'slug'     => 'taxes',
            'name'     => _l('acs_sales_taxes_submenu'),
            'href'     => admin_url('taxes'),
            'position' => 5,
            'badge'    => [],
        ]);
        $CI->app_menu->add_setup_children_item('finance', [
            'slug'     => 'currencies',
            'name'     => _l('acs_sales_currencies_submenu'),
            'href'     => admin_url('currencies'),
            'position' => 10,
            'badge'    => [],
        ]);
        $CI->app_menu->add_setup_children_item('finance', [
            'slug'     => 'payment-modes',
            'name'     => _l('acs_sales_payment_modes_submenu'),
            'href'     => admin_url('paymentmodes'),
            'position' => 15,
            'badge'    => [],
        ]);
        $CI->app_menu->add_setup_children_item('finance', [
            'slug'     => 'expenses-categories',
            'name'     => _l('acs_expense_categories'),
            'href'     => admin_url('expenses/categories'),
            'position' => 20,
            'badge'    => [],
        ]);

        // Menu de Contratos
        $CI->app_menu->add_setup_menu_item('contracts', [
            'collapse' => true,
            'name'     => _l('acs_contracts'),
            'position' => 30,
            'badge'    => [],
        ]);
        $CI->app_menu->add_setup_children_item('contracts', [
            'slug'     => 'contracts-types',
            'name'     => _l('acs_contract_types'),
            'href'     => admin_url('contracts/types'),
            'position' => 5,
            'badge'    => [],
        ]);

        $modulesNeedsUpgrade = $CI->app_modules->number_of_modules_that_require_database_upgrade();

        $CI->app_menu->add_setup_menu_item('modules', [
            'href'     => admin_url('modules'),
            'name'     => _l('modules'),
            'position' => 35,
            'badge'    => [
                'value' => $modulesNeedsUpgrade > 0 ? $modulesNeedsUpgrade : null,
                'type' => 'warning',
            ],
        ]);

        $CI->app_menu->add_setup_menu_item('custom-fields', [
            'href'     => admin_url('custom_fields'),
            'name'     => _l('asc_custom_fields'),
            'position' => 45,
            'badge'    => [],
        ]);

        $CI->app_menu->add_setup_menu_item('gdpr', [
            'href'     => admin_url('gdpr'),
            'name'     => _l('gdpr_short'),
            'position' => 50,
            'badge'    => [],
        ]);

        $CI->app_menu->add_setup_menu_item('roles', [
            'href'     => admin_url('roles'),
            'name'     => _l('acs_roles'),
            'position' => 55,
            'badge'    => [],
        ]);
    }

    // Verifica se o usuário tem permissão para visualizar 'settings' e adiciona o item no menu
    if (staff_can('view', 'settings')) {
        $CI->app_menu->add_setup_menu_item('settings', [
            'href'     => admin_url('settings'),
            'name'     => _l('acs_settings'),
            'position' => 200,
            'badge'    => [],
        ]);
    }

    // Adiciona o item de 'email templates' para quem tem permissão
    if (staff_can('view', 'email_templates')) {
        $CI->app_menu->add_setup_menu_item('email-templates', [
            'href'     => admin_url('emails'),
            'name'     => _l('acs_email_templates'),
            'position' => 40,
            'badge'    => [],
        ]);
    }
}

*/
