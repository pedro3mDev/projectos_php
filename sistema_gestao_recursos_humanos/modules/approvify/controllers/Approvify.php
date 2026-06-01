<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Approvify extends AdminController
{
    public function __construct()
    {
        parent::__construct();
		$this->load->library(['form_validation', 'upload']);

        $this->load->model('approvify_model');
        hooks()->do_action('approvify_init');
    }

    public function index()
    {
        if (!has_permission('approvify', '', 'view')) {
            access_denied('approvify');
        }

        $data['title'] = 'Requisições - Dashboard';

        $data['totalCategories'] = $this->approvify_model->getTotalCategories();
        $data['totalRequests'] = $this->approvify_model->getTotalRequests();
        $data['totalRequestsByStatusAprovado']  = $this->approvify_model->getTotalRequestsByStatus("1");
        $data['totalRequestsByStatusRecusado']  = $this->approvify_model->getTotalRequestsByStatus("2");
        $data['totalRequestsByStatusCancelado'] = $this->approvify_model->getTotalRequestsByStatus("3");
        $data['totalRequestsByStatusRevisao']   = $this->approvify_model->getTotalRequestsByStatus("0");

        $data['topCategories'] = $this->approvify_model->getTopCategoriesByRequests();
        // echo "<pre>";

        $data['requisicao_pendentes'] = $this->approvify_model->requisicao_estado();

        // var_dump( $data['topCategories'] );die();
        $this->load->view('dashboard', $data);
    }
    public function configuracoes()
    {
        if (!has_permission('approvify', '', 'view')) {
            access_denied('approvify');
        }
        

        // $data['group'] = 'categorias';
        $data['group'] = '';
        if ($data['group'] == '') {
            if (!has_permission('approvify', '', 'create_category')) {
                access_denied('approvify');
            }
			$data['group'] = 'categorias';

            if ($this->input->is_ajax_request()) {
                $this->app->get_table_data(module_views_path('approvify', 'types/type_table'));
            }
		}
        $data['tab'][] = 'categorias';
        $data['tabs']['view'] = 'includes/' . $data['group'];

        $data['title'] = 'Requisições - Configurações';
        $this->load->view('configuracoes', $data);
    }

    public function manage_requests()
    {
        if (!has_permission('approvify', '', 'view')) {
            access_denied('approvify');
        }

        $data['title'] = 'Requisições - Requisições Pendentes';
        $data['type_list'] = $this->approvify_model->getTypes();

        $this->load->view('requests/manage_create_request', $data);
    }

    public function manage_review_requests()
    {
        if (!has_permission('approvify', '', 'view')) {
            access_denied('approvify');
        }

        $this->load->model('staff_model');

        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data(module_views_path('approvify', 'requests/review_requests_table'), ['postData' => $_POST]);
        }

        $data['title'] = 'Requisições - Revisão';
        $data['staff'] = $this->staff_model->get('', ['active' => 1]);

        $this->load->view('requests/manage_review_requests', $data);
    }

    public function create_request()
    {
        if (!has_permission('approvify', '', 'view')) {
            access_denied('approvify');
        }

        if ($this->input->post()) {
            $data            = $this->input->post();
            $data['category_id'] = $_GET['type'];
            $id              = $this->approvify_model->addRequest($data);
            if ($id) {
                set_alert('success', _l('new_ticket_added_successfully', $id));
                echo json_encode([
                    'redirect_url' => admin_url('approvify/manage_created_requests')
                ]);
                die;
            }
        }

        $data = [];

        if (isset($_GET['type'])) {
            $type = $_GET['type'];
            $data['type_data'] = $this->approvify_model->getType($type);
        }

        $data['title'] = 'Requisições - Nova Requisição';
        $data['type_list'] = $this->approvify_model->getTypes();

        $this->load->view('requests/create_request', $data);
    }

    public function view_request($requestId)
    {

        $data = [];

        $isReview = $_GET['review'] ?? '';

        $data['request_data'] = $this->approvify_model->getRequest($requestId);
        $data['request_activity_log'] = $this->approvify_model->getActivities($requestId);
        $data['is_review'] = $isReview;

        if (empty($isReview)) {
            if ($data['request_data']->requester_id !== get_staff_user_id()) {
                redirect(admin_url('approvify/configuracoes'));
            }
        } else {
            $decodeApproveList = json_decode($data['request_data']->approve_list);
            if (!in_array(get_staff_user_id(), $decodeApproveList)) {
                redirect(admin_url('approvify/configuracoes'));
            }
        }

        $data['title'] = 'Requisições - Visualizar Requisições';
        $this->load->view('requests/view_my_request', $data);
    }

    public function refuse_request($requestId)
    {
        $data = [];

        $data['request_data'] = $this->approvify_model->getRequest($requestId);

        $requestMessage = htmlspecialchars($_GET['action_message'], ENT_QUOTES, 'UTF-8') ?: '';
        $requestMessage = urldecode($requestMessage);


        $decodeApproveList = json_decode($data['request_data']->approve_list);
        if (!in_array(get_staff_user_id(), $decodeApproveList)) {
            redirect(admin_url('approvify/view_request/' . $requestId));
        }

        $cancel = $this->approvify_model->updateRequest($requestId, ['status' => '2']);

        if ($cancel) {

            $staffData = get_staff($data['request_data']->requester_id);

            $notified = add_notification([
                'description'     => 'approvify_request_refused',
                'touserid'        => $data['request_data']->requester_id,
                'fromcompany'     => 1,
                'fromuserid'      => 0,
                'link'            => 'approvify/view_request/' . $requestId,
                'additional_data' => serialize([
                    $data['request_data']->request_title,
                    get_staff_full_name(get_staff_user_id())
                ]),
            ]);

            if ($notified) {
                pusher_trigger_notification([$data['request_data']->requester_id]);
            }

            $requestTitle = $data['request_title'] ?? "";

            $this->load->model('emails_model');
            $this->emails_model->send_simple_email(
                $staffData->email,
                'Your Request Has Been Refused -' . get_option('companyname'),
                '
            Hello,
<br>
Your Request with title <strong>' . $requestTitle . '</strong> has been refused by : <strong>' . get_staff_full_name(get_staff_user_id()) . '</strong>
<br>
<a href="' . admin_url('approvify/view_request/' . $requestId) . '">Check Request Here</a>
<br>
Best regards,<br>
' . get_option('companyname') . '
            '
            );

            $this->approvify_model->addActivity([
                'request_id' => $requestId,
                'staff_id' => get_staff_user_id(),
                'description' => 'Has changed request status to Refused',
                'request_message' => $requestMessage,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }

    public function approve_request($requestId)
    {
        $data = [];

        $data['request_data'] = $this->approvify_model->getRequest($requestId);

        $requestMessage = htmlspecialchars($_GET['action_message'], ENT_QUOTES, 'UTF-8') ?: '';
        $requestMessage = urldecode($requestMessage);

        $decodeApproveList = json_decode($data['request_data']->approve_list);
        if (!in_array(get_staff_user_id(), $decodeApproveList)) {
            redirect(admin_url('approvify/view_request/' . $requestId));
        }

        $cancel = $this->approvify_model->updateRequest($requestId, ['status' => '1']);

        if ($cancel) {

            $staffData = get_staff($data['request_data']->requester_id);

            $notified = add_notification([
                'description'     => 'approvify_request_approved',
                'touserid'        => $data['request_data']->requester_id,
                'fromcompany'     => 1,
                'fromuserid'      => 0,
                'link'            => 'approvify/view_request/' . $requestId,
                'additional_data' => serialize([
                    $data['request_data']->request_title,
                    get_staff_full_name(get_staff_user_id())
                ]),
            ]);

            if ($notified) {
                pusher_trigger_notification([$data['request_data']->requester_id]);
            }
            $this->load->model('emails_model');
            $this->emails_model->send_simple_email(
                $staffData->email,
                'Your Request Has Been Approved -' . get_option('companyname'),
                '
            Hello,
<br>
Your Request with title <strong>' . $data['request_title'] . '</strong> has been approved by : <strong>' . get_staff_full_name(get_staff_user_id()) . '</strong>
<br>
<a href="' . admin_url('approvify/view_request/' . $requestId) . '">Check Request Here</a>
<br>
Best regards,<br>
' . get_option('companyname') . '
            '
            );

            $this->approvify_model->addActivity([
                'request_id' => $requestId,
                'staff_id' => get_staff_user_id(),
                'description' => 'Has changed request status to Approved',
                'request_message' => $requestMessage,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }

    public function cancel_request($requestId)
    {

        $data = [];

        $data['request_data'] = $this->approvify_model->getRequest($requestId);

        if ($data['request_data']->requester_id !== get_staff_user_id()) {
            redirect(admin_url('approvify/view_request/' . $requestId));
        }

        if ($data['request_data']->status !== '0') {
            redirect(admin_url('approvify/view_request/' . $requestId));
        }

        $cancel = $this->approvify_model->updateRequest($requestId, ['status' => '3']);

        if ($cancel) {
            $this->approvify_model->addActivity([
                'request_id' => $requestId,
                'staff_id' => get_staff_user_id(),
                'description' => 'Has changed request status to Canceled',
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        redirect(admin_url('approvify/view_request/' . $requestId));
    }

    public function manage_created_requests()
    {
        if (!has_permission('approvify', '', 'view')) {
            access_denied('approvify');
        }

        $data['title'] = 'Requisições - Minhas Requisições';
        $data['isKanBan'] = true;

        $this->load->view('requests/manage_my_requests', $data);
    }

    public function kanban()
    {
        if (!is_staff_member()) {
            ajax_access_denied();
        }
        $data = [];
        echo $this->load->view('requests/manage_my_requests_kanban', $data, true);
    }

    public function my_requests_kanban_load_more()
    {
        if (!is_staff_member()) {
            ajax_access_denied();
        }

        $status = $this->input->get('status');
        $page   = $this->input->get('page');

        $leads = (new ApprovifyRequestsKanBan($status['id']))
            ->search($this->input->get('search'))
            ->sortBy(
                $this->input->get('sort_by'),
                $this->input->get('sort')
            )
            ->page($page)->get();

        foreach ($leads as $lead) {
            $this->load->view('requests/manage_my_requests_kanban_card', [
                'lead'   => $lead,
                'status' => $status,
            ]);
        }
    }

    public function manage_types()
    {
        if (!has_permission('approvify', '', 'create_category')) {
            access_denied('approvify');
        }

        if ($this->input->is_ajax_request()) {
            $this->app->get_table_data(module_views_path('approvify', 'types/type_table'));
        }

        $data['title'] = 'Requisições - Categorias';
        $this->load->view('types/manage_types', $data);
    }

    public function create_type($type_id = '')
    {
        if (!has_permission('approvify', '', 'create_category')) {
            access_denied('approvify');
        }

        $this->load->model('staff_model');

        if ($this->input->post() && $type_id === '') {
            $this->form_validation->set_rules('category_name', _l('approvify_category_name'), 'required', ['required' => 'Preencha o campo {field}']);
            $this->form_validation->set_rules('approve_list[]', _l('approvify_approvers'), 'required', ['required' => 'Preencha o campo {field}']);
            if (!$this->form_validation->run()) {
                set_alert('danger',"Preenchas os campos correctamente");
                return redirect(admin_url('approvify/create_type'));
            }
            $data = $this->input->post();

            $data['created_at'] = date('Y-m-d H:i:s');

            if (isset($data['approve_list'])) {
                $data['approve_list'] = json_encode($data['approve_list']);
            }

            $newTypeId = $this->approvify_model->addType($data);

            if (is_numeric($newTypeId)) {
                set_alert('success', _l('added_successfully', _l('approvify_categories')));
                redirect(admin_url('approvify/create_type/' . $newTypeId));
            } else {
                set_alert('warning', _l('approvify_failed_to_create_type'));
                redirect(admin_url('approvify/create_type'));
            }
        } elseif ($this->input->post() && $type_id !== '') {
            if ($type_id != 1) {
                $this->form_validation->set_rules('category_name', _l('approvify_category_name'), 'required', ['required' => 'Preencha o campo {field}']);
            }
            $this->form_validation->set_rules('approve_list[]', _l('approvify_approvers'), 'required', ['required' => 'Preencha o campo {field}']);
            if (!$this->form_validation->run()) {
                set_alert('danger',"Preenchas os campos correctamente");
                return redirect(admin_url('approvify/create_type/' . $type_id));
            }
            $data = $this->input->post();

            $timestamp = strtotime($data['created_at']);
            $data['created_at'] = date("Y-m-d H:i:s", $timestamp);

            if (isset($data['approve_list'])) {
                $data['approve_list'] = json_encode($data['approve_list']);
            }

            $response = $this->approvify_model->updateType($type_id, $data);

            if ($response) {
                set_alert('success', _l('updated_successfully', _l('approvify_categories')));
                redirect(admin_url('approvify/create_type/' . $type_id));
            } else {
                set_alert('warning', _l('approvify_failed_to_update_type'));
                redirect(admin_url('approvify/create_type/' . $type_id));
            }
        }

        $data['title'] = 'Requisições - Categorias';
        if ($type_id) {
            $data['category_data'] = $this->approvify_model->getType($type_id);
        }
        $data['staff_list'] = $this->staff_model->get('', ['is_not_staff' => 0, 'active' => 1, 'admin' => 1]);

        $this->load->view('types/create_type', $data);
    }

    public function delete_type($id = '')
    {
        if (!has_permission('approvify', '', 'delete')) {
            access_denied('approvify');
        }

        if (!$id) {
            redirect(admin_url('approvify/configuracoes'));
        }

        $response = $this->approvify_model->deleteType($id);

        if (is_array($response) && isset($response['referenced'])) {
            set_alert('warning', _l('is_referenced', _l('approvify_request_category')));
        } elseif ($response == true) {
            set_alert('success', _l('deleted', _l('approvify_request_category')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('approvify_request_category')));
        }

        redirect(admin_url('approvify/configuracoes'));
    }

    public function update_type_status($id, $status)
    {
        if ($this->input->is_ajax_request()) {
            $this->approvify_model->changeTypeStatus($id, $status);
        }
    }
}