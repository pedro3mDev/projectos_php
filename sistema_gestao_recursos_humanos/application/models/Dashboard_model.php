<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return array
     * Used in home dashboard page
     * Return all upcoming events this week
     */
    public function get_upcoming_events()
    {
        $monday_this_week = date('Y-m-d', strtotime('monday this week'));
        $sunday_this_week = date('Y-m-d', strtotime('sunday this week'));

        $this->db->where("(start BETWEEN '$monday_this_week' and '$sunday_this_week')");
        $this->db->where('(userid = ' . get_staff_user_id() . ' OR public = 1)');
        $this->db->order_by('start', 'desc');
        $this->db->limit(6);

        return $this->db->get(db_prefix() . 'events')->result_array();
    }

    /**
     * @param  integer (optional) Limit upcoming events
     * @return integer
     * Used in home dashboard page
     * Return total upcoming events next week
     */
    public function get_upcoming_events_next_week()
    {
        $monday_this_week = date('Y-m-d', strtotime('monday next week'));
        $sunday_this_week = date('Y-m-d', strtotime('sunday next week'));
        $this->db->where("(start BETWEEN '$monday_this_week' and '$sunday_this_week')");
        $this->db->where('(userid = ' . get_staff_user_id() . ' OR public = 1)');

        return $this->db->count_all_results(db_prefix() . 'events');
    }

    /**
     * @param  mixed
     * @return array
     * Used in home dashboard page, currency passed from javascript (undefined or integer)
     * Displays weekly payment statistics (chart)
     */
    public function get_weekly_payments_statistics($currency)
    {
        $all_payments                 = [];
        $has_permission_payments_view = staff_can('view',  'payments');
        $this->db->select(db_prefix() . 'invoicepaymentrecords.id, amount,' . db_prefix() . 'invoicepaymentrecords.date');
        $this->db->from(db_prefix() . 'invoicepaymentrecords');
        $this->db->join(db_prefix() . 'invoices', '' . db_prefix() . 'invoices.id = ' . db_prefix() . 'invoicepaymentrecords.invoiceid');
        $this->db->where('YEARWEEK(' . db_prefix() . 'invoicepaymentrecords.date) = YEARWEEK(CURRENT_DATE)');
        $this->db->where('' . db_prefix() . 'invoices.status !=', 5);
        if ($currency != 'undefined') {
            $this->db->where('currency', $currency);
        }

        if (!$has_permission_payments_view) {
            $this->db->where('invoiceid IN (SELECT id FROM ' . db_prefix() . 'invoices WHERE addedfrom=' . get_staff_user_id() . ' and addedfrom IN (SELECT staff_id FROM ' . db_prefix() . 'staff_permissions WHERE feature="invoices" AND capability="view_own"))');
        }

        // Current week
        $all_payments[] = $this->db->get()->result_array();
        $this->db->select(db_prefix() . 'invoicepaymentrecords.id, amount,' . db_prefix() . 'invoicepaymentrecords.date');
        $this->db->from(db_prefix() . 'invoicepaymentrecords');
        $this->db->join(db_prefix() . 'invoices', '' . db_prefix() . 'invoices.id = ' . db_prefix() . 'invoicepaymentrecords.invoiceid');
        $this->db->where('YEARWEEK(' . db_prefix() . 'invoicepaymentrecords.date) = YEARWEEK(CURRENT_DATE - INTERVAL 7 DAY) ');

        $this->db->where('' . db_prefix() . 'invoices.status !=', 5);
        if ($currency != 'undefined') {
            $this->db->where('currency', $currency);
        }

        if (!$has_permission_payments_view) {
            $this->db->where('invoiceid IN (SELECT id FROM ' . db_prefix() . 'invoices WHERE addedfrom=' . get_staff_user_id() . ' and addedfrom IN (SELECT staff_id FROM ' . db_prefix() . 'staff_permissions WHERE feature="invoices" AND capability="view_own"))');
        }

        // Last Week
        $all_payments[] = $this->db->get()->result_array();

        $chart = [
            'labels'   => get_weekdays(),
            'datasets' => [
                [
                    'label'           => _l('this_week_payments'),
                    'backgroundColor' => 'rgba(37,155,35,0.2)',
                    'borderColor'     => '#84c529',
                    'borderWidth'     => 1,
                    'tension'         => false,
                    'data'            => [
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                    ],
                ],
                [
                    'label'           => _l('last_week_payments'),
                    'backgroundColor' => 'rgba(197, 61, 169, 0.5)',
                    'borderColor'     => '#c53da9',
                    'borderWidth'     => 1,
                    'tension'         => false,
                    'data'            => [
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                        0,
                    ],
                ],
            ],
        ];


        for ($i = 0; $i < count($all_payments); $i++) {
            foreach ($all_payments[$i] as $payment) {
                $payment_day = date('l', strtotime($payment['date']));
                $x           = 0;
                foreach (get_weekdays_original() as $day) {
                    if ($payment_day == $day) {
                        $chart['datasets'][$i]['data'][$x] += $payment['amount'];
                    }
                    $x++;
                }
            }
        }

        return $chart;
    }


    /**
     * @param  mixed
     * @return array
     * Used in home dashboard page, currency passed from javascript (undefined or integer)
     * Displays monthly payment statistics (chart)
     */
    public function get_monthly_payments_statistics($currency)
    {
        $all_payments                 = [];
        $has_permission_payments_view = staff_can('view',  'payments');
        $this->db->select('SUM(amount) as total, MONTH(' . db_prefix() . 'invoicepaymentrecords.date) as month');
        $this->db->from(db_prefix() . 'invoicepaymentrecords');
        $this->db->join(db_prefix() . 'invoices', '' . db_prefix() . 'invoices.id = ' . db_prefix() . 'invoicepaymentrecords.invoiceid');
        $this->db->where('YEAR(' . db_prefix() . 'invoicepaymentrecords.date) = YEAR(CURRENT_DATE)');
        $this->db->where('' . db_prefix() . 'invoices.status !=', 5);
        $this->db->group_by('month');

        if ($currency != 'undefined') {
            $this->db->where('currency', $currency);
        }

        if (!$has_permission_payments_view) {
            $this->db->where('invoiceid IN (SELECT id FROM ' . db_prefix() . 'invoices WHERE addedfrom=' . get_staff_user_id() . ' and addedfrom IN (SELECT staff_id FROM ' . db_prefix() . 'staff_permissions WHERE feature="invoices" AND capability="view_own"))');
        }

        $all_payments = $this->db->get()->result_array();

        for ($i = 1; $i <= 12; $i++) {
            if (!isset($all_payments[$i])) {
                $all_payments[$i]['total'] = 0;
                $all_payments[$i]['month'] = $i;
            }
            $all_payments[$i]['label'] = _l(date("F", mktime(0, 0, 0, $i, 1)));
        }
        usort($all_payments, function($a, $b) {
            return (int) $a['month'] <=> (int) $b['month'];
        });

        $chart = [
            'labels'   => array_column($all_payments, 'label'),
            'datasets' => [
                [
                    'label'           => _l('report_sales_type_income'),
                    'backgroundColor' => 'rgba(37,155,35,0.2)',
                    'borderColor'     => '#84c529',
                    'borderWidth'     => 1,
                    'tension'         => false,
                    'data'            => array_column($all_payments, 'total'),
                ],
            ],
        ];
        return $chart;
    }

    public function projects_status_stats()
    {
        $this->load->model('projects_model');
        $statuses = $this->projects_model->get_project_statuses();
        $colors   = get_system_favourite_colors();

        $chart = [
            'labels'   => [],
            'datasets' => [],
        ];

        $_data                         = [];
        $_data['data']                 = [];
        $_data['backgroundColor']      = [];
        $_data['hoverBackgroundColor'] = [];
        $_data['statusLink']           = [];


        $has_permission = staff_can('view',  'projects');
        $sql            = '';
        foreach ($statuses as $status) {
            $sql .= ' SELECT COUNT(*) as total';
            $sql .= ' FROM ' . db_prefix() . 'projects';
            $sql .= ' WHERE status=' . $status['id'];
            if (!$has_permission) {
                $sql .= ' AND id IN (SELECT project_id FROM ' . db_prefix() . 'project_members WHERE staff_id=' . get_staff_user_id() . ')';
            }
            $sql .= ' UNION ALL ';
            $sql = trim($sql);
        }

        $result = [];
        if ($sql != '') {
            // Remove the last UNION ALL
            $sql    = substr($sql, 0, -10);
            $result = $this->db->query($sql)->result();
        }

        foreach ($statuses as $key => $status) {
            array_push($_data['statusLink'], admin_url('projects?status=' . $status['id']));
            array_push($chart['labels'], $status['name']);
            array_push($_data['backgroundColor'], $status['color']);
            array_push($_data['hoverBackgroundColor'], adjust_color_brightness($status['color'], -20));
            array_push($_data['data'], $result[$key]->total);
        }

        $chart['datasets'][]           = $_data;
        $chart['datasets'][0]['label'] = _l('home_stats_by_project_status');

        return $chart;
    }

    public function leads_status_stats()
    {
        $chart = [
            'labels'   => [],
            'datasets' => [],
        ];

        $_data                         = [];
        $_data['data']                 = [];
        $_data['backgroundColor']      = [];
        $_data['hoverBackgroundColor'] = [];
        $_data['statusLink']           = [];

        $result = get_leads_summary();

        foreach ($result as $status) {
            if ($status['color'] == '') {
                $status['color'] = '#737373';
            }
            array_push($chart['labels'], $status['name']);
            array_push($_data['backgroundColor'], $status['color']);
            if (!isset($status['junk']) && !isset($status['lost'])) {
                array_push($_data['statusLink'], admin_url('leads?status=' . $status['id']));
            }
            array_push($_data['hoverBackgroundColor'], adjust_color_brightness($status['color'], -20));
            array_push($_data['data'], $status['total']);
        }

        $chart['datasets'][] = $_data;

        return $chart;
    }

    /**
     * Display total tickets awaiting reply by department (chart)
     * @return array
     */
    public function tickets_awaiting_reply_by_department()
    {
        $this->load->model('departments_model');
        $departments = $this->departments_model->get();
        $colors      = get_system_favourite_colors();
        $chart       = [
            'labels'   => [],
            'datasets' => [],
        ];

        $_data                         = [];
        $_data['data']                 = [];
        $_data['backgroundColor']      = [];
        $_data['hoverBackgroundColor'] = [];

        $i = 0;
        foreach ($departments as $department) {
            if (!is_admin()) {
                if (get_option('staff_access_only_assigned_departments') == 1) {
                    $staff_deparments_ids = $this->departments_model->get_staff_departments(get_staff_user_id(), true);
                    $departments_ids      = [];
                    if (count($staff_deparments_ids) == 0) {
                        $departments = $this->departments_model->get();
                        foreach ($departments as $department) {
                            array_push($departments_ids, $department['departmentid']);
                        }
                    } else {
                        $departments_ids = $staff_deparments_ids;
                    }
                    if (count($departments_ids) > 0) {
                        $this->db->where('department IN (SELECT departmentid FROM ' . db_prefix() . 'staff_departments WHERE departmentid IN (' . implode(',', $departments_ids) . ') AND staffid="' . get_staff_user_id() . '")');
                    }
                }
            }
            $this->db->where_in('status', [
                1,
                2,
                4,
            ]);

            $this->db->where('department', $department['departmentid']);
            $this->db->where(db_prefix() . 'tickets.merged_ticket_id IS NULL', null, false);
            $total = $this->db->count_all_results(db_prefix() . 'tickets');

            if ($total > 0) {
                $color = '#333';
                if (isset($colors[$i])) {
                    $color = $colors[$i];
                }
                array_push($chart['labels'], $department['name']);
                array_push($_data['backgroundColor'], $color);
                array_push($_data['hoverBackgroundColor'], adjust_color_brightness($color, -20));
                array_push($_data['data'], $total);
            }
            $i++;
        }

        $chart['datasets'][] = $_data;

        return $chart;
    }

    /**
     * Display total tickets awaiting reply by status (chart)
     * @return array
     */
    public function tickets_awaiting_reply_by_status()
    {
        $this->load->model('tickets_model');
        $statuses             = $this->tickets_model->get_ticket_status();
        $_statuses_with_reply = [
            1,
            2,
            4,
        ];

        $chart = [
            'labels'   => [],
            'datasets' => [],
        ];

        $_data                         = [];
        $_data['data']                 = [];
        $_data['backgroundColor']      = [];
        $_data['hoverBackgroundColor'] = [];
        $_data['statusLink']           = [];

        foreach ($statuses as $status) {
            if (in_array($status['ticketstatusid'], $_statuses_with_reply)) {
                if (!is_admin()) {
                    if (get_option('staff_access_only_assigned_departments') == 1) {
                        $staff_deparments_ids = $this->departments_model->get_staff_departments(get_staff_user_id(), true);
                        $departments_ids      = [];
                        if (count($staff_deparments_ids) == 0) {
                            $departments = $this->departments_model->get();
                            foreach ($departments as $department) {
                                array_push($departments_ids, $department['departmentid']);
                            }
                        } else {
                            $departments_ids = $staff_deparments_ids;
                        }
                        if (count($departments_ids) > 0) {
                            $this->db->where('department IN (SELECT departmentid FROM ' . db_prefix() . 'staff_departments WHERE departmentid IN (' . implode(',', $departments_ids) . ') AND staffid="' . get_staff_user_id() . '")');
                        }
                    }
                }

                $this->db->where('status', $status['ticketstatusid']);
                $this->db->where(db_prefix() . 'tickets.merged_ticket_id IS NULL', null, false);
                $total = $this->db->count_all_results(db_prefix() . 'tickets');
                if ($total > 0) {
                    array_push($chart['labels'], ticket_status_translate($status['ticketstatusid']));
                    array_push($_data['statusLink'], admin_url('tickets/index/' . $status['ticketstatusid']));
                    array_push($_data['backgroundColor'], $status['statuscolor']);
                    array_push($_data['hoverBackgroundColor'], adjust_color_brightness($status['statuscolor'], -20));
                    array_push($_data['data'], $total);
                }
            }
        }

        $chart['datasets'][] = $_data;

        return $chart;
    }

    // Total Funcionarios
    public function total_funcionarios() {
        $query = $this->db->get('staff')->num_rows();
        return $query;
    }
    // Total Funcionarios por departamento
    public function total_funcionarios_departamento($id) {
        $this->db->where('departmentid', $id);
        $query = $this->db->get('staff_departments')->num_rows();
        return $query;
    }
    // Total Funcionarios
    public function total_modulos() {
        $query = $this->db->get('modules')->num_rows();
        return $query;
    }
    // Total Funcionarios
    public function get_modulos() {
        $query = $this->db->get('modules')->result_array();
        return $query;
    }
    public function dashboard_roles()
    {
        $roles = $this->db->get('roles')->result_array();
        $cores = ['#336', '#DAA520', '#8B0000', '#ff0000', '#ffff00', '#00ffff'];
        $cores_hover = ['#36A2EB', '#FFCD56', '#FF6384', '#ff0000', '#ffff00', '#00ffff'];
        $label = '[';
        $background = '[';
        $backgroundhover = '[';
        $data = '[';
        $i = 0;
        foreach ($roles as $role) {
            $countStaff = $this->db->get_where('staff', ['role' => $role['roleid']])->num_rows();
            $label .= "'".$role['name']."',";
            $background .= "'".$cores[$i]."',";
            $backgroundhover .= "'".$cores_hover[$i]."',";
            $data .= "'".$countStaff."',";
            $i++;
            if ($i > 6) { $i = 0; }
        }
        $label .= ']';
        $background .= ']';
        $backgroundhover .= ']';
        $data .= ']';

        $dados = "
        data: {
            labels: $label, // Labels para os dados
            datasets: [{
                label: 'Funcionários por cargos',
                data: $data, // Percentagens dos tipos de contrato
                backgroundColor: $background, // Cores do gráfico
                hoverBackgroundColor: $backgroundhover // Cores de hover
            }]
        }
        ";
        return $dados;
    }
    public function dashboard_departamento () {
        $query = $this->db->get('departments')->result_array();
        $cores = ['#336', '#DAA520', '#8B0000', '#ff0000', '#ffff00', '#00ffff'];
        $cores_hover = ['#36A2EB', '#FFCD56', '#FF6384', '#ff0000', '#ffff00', '#00ffff'];
        $label = '[';
        $background = '[';
        $backgroundhover = '[';
        $data = '[';
        $i = 0;
        foreach ($query as $item) {
            $label .= "'".$item['name']."',";
            $background .= "'".$cores[$i]."',";
            $backgroundhover .= "'".$cores_hover[$i]."',";
            $data .= "'".$this->total_funcionarios_departamento($item['departmentid'])."',";
            $i++;
            if ($i > 5) { $i = 0; }
        }
        $label .= ']';
        $background .= ']';
        $backgroundhover .= ']';
        $data .= ']';

        $dados = "
        data: {
            labels: $label, // Labels para os dados
            datasets: [{
                label: 'Funcionários por Departamentos',
                data: $data, // Percentagens dos tipos de contrato
                backgroundColor: $background, // Cores do gráfico
                hoverBackgroundColor: $backgroundhover // Cores de hover
            }]
        }
        ";
        return $dados;
    }
    public function dasboard_func_cadastro($ano = null) {
        $this->db->select("MONTH(datecreated) as mes, count(staffid ) as total_func");
        if ($ano != null) {
            $this->db->where("YEAR(datecreated)", $ano);
            $this->db->group_by("DATE_FORMAT(datecreated, '%Y-%m')");
        }
        else {
            $this->db->group_by("MONTH(datecreated)");
        }
        $this->db->from('staff');
        $this->db->order_by('mes', 'ASC');
        $query = $this->db->get()->result_array();

        $meses = array_fill(1,12,0);
        $dados = '[';
        foreach ($query as $dado) {
            $meses[$dado['mes']] = $dado['total_func'];
        }
        for ($i=1; $i <= 12; $i++) {
            $dados .= "'". $meses[$i] ."',";
        }
        $dados .=']';
        return $dados;
    }
    public function dashboard_campanha()
	{
		$rs = [];

		$total = $this->db->query('Select * from tblrec_campaign')->result_array();
		$inprogress = $this->db->query('Select * from tblrec_campaign where cp_status = 3')->result_array();
		$planning = $this->db->query('Select * from tblrec_campaign where cp_status = 1')->result_array();
		$finish = $this->db->query('Select * from tblrec_campaign where cp_status = 4')->result_array();
		$candidate_need = $this->db->query('Select amount_recruiment from tblrec_proposal')->result_array();
		$recruited = $this->db->query('Select * from tblrec_candidate where status = 6')->result_array();

		$rs['candidate_need'] = 0;
		foreach ($candidate_need as $cd) {
			$rs['candidate_need'] += $cd['amount_recruiment'];
		}

		$rs['recruiting'] = 0;
		foreach ($inprogress as $cd) {
			$rs['recruiting'] += $cd['cp_amount_recruiment'];
		}

		$rs['recruited'] = count($recruited);
		$rs['total'] = count($total);
		$rs['inprogress'] = count($inprogress);
		$rs['planning'] = count($planning);
		$rs['finish'] = count($finish);

		return $rs;
	}
    public function dashboard_total_candidatos()
	{
        $query = $this->db->get('rec_candidate')->num_rows();
        return $query;
	}
    public function dashboard_candidatos_por_status()
	{
		// Consulta para obter o total de candidatos por status
		$this->db->select('
            rc.status AS status,
            COUNT(rc.id) AS total_candidatos
        ');
		$this->db->from(db_prefix() . 'rec_candidate rc');
		$this->db->group_by('rc.status'); // Agrupa por status
		$this->db->order_by('rc.status', 'ASC'); // Ordena por status em ordem crescente

		// Executa a consulta
		$query = $this->db->get()->result_array();
		$status = array_fill(1,10,0);
		foreach ($query as $dado) {
            $status[$dado['status']] = $dado['total_candidatos'];
        }
		return $status; // Retorna um array com o total de candidatos por status
	}
    public function dashboard_total_onbording() {
        $query = $this->db->get('hr_rec_transfer_records')->num_rows();
        return $query;
    }
    public function dashboard_total_treinamentos() {
        $query = $this->db->get('hr_jp_interview_training')->num_rows();
        return $query;
    }
    public function dashboard_total_contractos() {
        $query = $this->db->get('hr_staff_contract')->num_rows();
        return $query;
    }
    public function dashboard_total_viagens() {
        $query = $this->db->get('gv_pedido_viagem')->num_rows();
        return $query;
    }
    public function dashboard_usuarios_anuais($ano = null) {
		if ($ano == null) {
			$ano = date('Y');
		}
        $this->db->select("MONTH(datecreated) as mes, count(staffid) as total_func", false);
		$this->db->from('staff');
            $this->db->where("YEAR(datecreated)", $ano);
            $this->db->group_by("mes");
            // $this->db->group_by("DATE_FORMAT(datecreated, '%Y-%m')");
        $this->db->order_by('mes', 'ASC');
        $query = $this->db->get()->result_array();

        $meses = array_fill(1,12,0);
        $dados = '[';
        foreach ($query as $dado) {
            $meses[$dado['mes']] = $dado['total_func'];
        }
        for ($i=1; $i <= 12; $i++) {
            $dados .= "'". $meses[$i] ."',";
        }
        $dados .=']';
        return $dados;
    }
    public function dashboard_func_contratados($ano = null) {
        return "[1,2,3,4,5,6,7,8,9,10,11,12]";
    }
    public function dashboard_func_naocontratados($ano = null) {
        return "[1,2,3,4,5,6,7,8,9,10,11,12]";
    }
}