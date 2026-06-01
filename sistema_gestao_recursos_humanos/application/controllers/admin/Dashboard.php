<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('dashboard_model');
    }

    // This is admin dashboard view
    public function index()
    {
        close_setup_menu();
        $this->load->model('departments_model');
        $this->load->model('todo_model');
        $data['departments'] = $this->departments_model->get();

        $data['todos'] = $this->todo_model->get_todo_items(0);
        // Only show last 5 finished todo items
        $this->todo_model->setTodosLimit(5);
        $data['todos_finished']            = $this->todo_model->get_todo_items(1);
        $data['upcoming_events_next_week'] = $this->dashboard_model->get_upcoming_events_next_week();
        $data['upcoming_events']           = $this->dashboard_model->get_upcoming_events();
        $data['title']                     = _l('dashboard_string');

        $this->load->model('contracts_model');
        $data['expiringContracts'] = $this->contracts_model->get_contracts_about_to_expire(get_staff_user_id());

        $this->load->model('currencies_model');
        $data['currencies']    = $this->currencies_model->get();
        $data['base_currency'] = $this->currencies_model->get_base_currency();
        $data['activity_log']  = $this->misc_model->get_activity_log();
        // Tickets charts
        $tickets_awaiting_reply_by_status     = $this->dashboard_model->tickets_awaiting_reply_by_status();
        $tickets_awaiting_reply_by_department = $this->dashboard_model->tickets_awaiting_reply_by_department();

        $data['tickets_reply_by_status']              = json_encode($tickets_awaiting_reply_by_status);
        $data['tickets_awaiting_reply_by_department'] = json_encode($tickets_awaiting_reply_by_department);

        $data['tickets_reply_by_status_no_json']              = $tickets_awaiting_reply_by_status;
        $data['tickets_awaiting_reply_by_department_no_json'] = $tickets_awaiting_reply_by_department;

        $data['projects_status_stats'] = json_encode($this->dashboard_model->projects_status_stats());
        $data['leads_status_stats']    = json_encode($this->dashboard_model->leads_status_stats());
        $data['google_ids_calendars']  = $this->misc_model->get_google_calendar_ids();
        $data['bodyclass']             = 'dashboard invoices-total-manual';
        $this->load->model('announcements_model');
        $data['staff_announcements']             = $this->announcements_model->get();
        $data['total_undismissed_announcements'] = $this->announcements_model->get_total_undismissed_announcements();

        $this->load->model('projects_model');
        $data['projects_activity'] = $this->projects_model->get_activity('', hooks()->apply_filters('projects_activity_dashboard_limit', 20));
        add_calendar_assets();
        $this->load->model('utilities_model');
        $this->load->model('estimates_model');
        $data['estimate_statuses'] = $this->estimates_model->get_statuses();

        $this->load->model('proposals_model');
        $data['proposal_statuses'] = $this->proposals_model->get_statuses();

        $wps_currency = 'undefined';
        if (is_using_multiple_currencies()) {
            $wps_currency = $data['base_currency']->id;
        }
        $data['weekly_payment_stats'] = json_encode($this->dashboard_model->get_weekly_payments_statistics($wps_currency));

        $data['dashboard'] = true;

        $data['user_dashboard_visibility'] = get_staff_meta(get_staff_user_id(), 'dashboard_widgets_visibility');

        if (! $data['user_dashboard_visibility']) {
            $data['user_dashboard_visibility'] = [];
        } else {
            $data['user_dashboard_visibility'] = unserialize($data['user_dashboard_visibility']);
        }
        $data['user_dashboard_visibility'] = json_encode($data['user_dashboard_visibility']);

        $data['tickets_report'] = [];
        if (is_admin()) {
            $data['tickets_report'] = (new app\services\TicketsReportByStaff())->filterBy('this_month');
        }

        // Total Funcionaros e Modulos
        $data['total_funcionarios'] = $this->dashboard_model->total_funcionarios();
        $data['total_modulos'] = $this->dashboard_model->total_modulos();
        $data['total_modulos'] = $this->dashboard_model->total_modulos();
        $data['dashboard_roles'] = $this->dashboard_model->dashboard_roles();
        $data['dashboard_departamento'] = $this->dashboard_model->dashboard_departamento();
        $data['dashboard_modulos'] = $this->dashboard_model->get_modulos();
        $data['dashboard_func_cadastro'] = $this->dashboard_model->dasboard_func_cadastro();
        // $data['dashboard_func_cadastro'] = $this->dashboard_model->dasboard_func_cadastro(2025);
        $data['dashboard_func_contratados'] = $this->dashboard_model->dashboard_func_contratados();
        $data['dashboard_func_naocontratados'] = $this->dashboard_model->dashboard_func_naocontratados();
        $data['dashboard_campanha'] = $this->dashboard_model->dashboard_campanha();
        $data['dashboard_total_candidatos'] = $this->dashboard_model->dashboard_total_candidatos();
        $data['dashboard_candidatos_por_status'] = $this->dashboard_model->dashboard_candidatos_por_status();
        $data['dashboard_total_onbording'] = $this->dashboard_model->dashboard_total_onbording();
        $data['dashboard_total_treinamentos'] = $this->dashboard_model->dashboard_total_treinamentos();
        $data['dashboard_total_contractos'] = $this->dashboard_model->dashboard_total_contractos();
        $data['dashboard_total_viagens'] = $this->dashboard_model->dashboard_total_viagens();
        // var_dump($data['dashboard_candidatos_por_status'][3]);
        $data['dashboard_total_func_anuais_actual'] = $this->dashboard_model->dashboard_usuarios_anuais();
        $data['dashboard_total_func_anuais_anterior'] = $this->dashboard_model->dashboard_usuarios_anuais((date('Y')-1));
        // return;
        $data['check_status']  =  $this->verifica_marcacoes_in_out_painel();
        $data = hooks()->apply_filters('before_dashboard_render', $data);
        if (is_admin()) {
            $this->load->view('admin/dashboard/dashboard', $data);
        }
        else {
            $this->load->view('admin/dashboard/dashboard_normal', $data);
        }
    }

    // Chart weekly payments statistics on home page / ajax
    public function weekly_payments_statistics($currency)
    {
        if ($this->input->is_ajax_request()) {
            echo json_encode($this->dashboard_model->get_weekly_payments_statistics($currency));

            exit();
        }
    }

    // Chart monthly payments statistics on home page / ajax
    public function monthly_payments_statistics($currency)
    {
        if ($this->input->is_ajax_request()) {
            echo json_encode($this->dashboard_model->get_monthly_payments_statistics($currency));

            exit();
        }
    }

    public function ticket_widget($type)
    {
        $data['tickets_report'] = (new app\services\TicketsReportByStaff())->filterBy($type);
        $this->load->view('admin/dashboard/widgets/tickets_report_table', $data);
    }

    public function verifica_marcacoes_in_out_painel(){
        $id_func = get_staff_user_id();
        $this->db->where('data',date('Y-m-d'));
        $this->db->where('fun_id',$id_func);
        $result =  $this->db->get(db_prefix() . 'as_marcacoes')->row();

        if (!isset($result)) {
            return 0;
        }
         
        $this->db->where('marc_id',$result->id);  
        $this->db->where('marc_out',null);
        $result1 =  $this->db->get(db_prefix() . 'as_marcacoes_in_out')->row();
        if (!isset($result1)) {
            return 1;
        }else {
            return 0;
        }

     }
}