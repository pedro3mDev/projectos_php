<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Approvify_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function addRequest($data)
    {

        $data['created_at'] = date('Y-m-d H:i:s');
        $data['requester_id'] = get_staff_user_id();
        $data['request_title'] = trim($data['request_title']);
        $data['request_content'] = nl2br_save_html($data['request_content']);

        $categoryData = $this->getType($data['category_id']);

        if (isset($data['custom_fields'])) {
            $custom_fields = $data['custom_fields'];
            unset($data['custom_fields']);
        }

        $this->db->insert(db_prefix() . 'approvify_requests', $data);
        $requestId = $this->db->insert_id();
        if ($requestId) {
            if ($categoryData->id == 1) {
                $data_pedidos = [
                    'staff_id' => get_staff_user_id(), // ID do Usuario Logado
                    'tipo_viagem_id' => 0,
                    'status_id' => 1,
                    'categoria_id' => 0,
                    'objetivo' => $data['request_title'] ?? '',
                    // 'funcionarios' => $this->input->post('funcionarios[]') ?? '',
                    'aprovadores' => ($categoryData->approve_list) ?? '[]',
                    'destino' => 'Indefinido',
                    'data_inicio' => date('Y-m-d H:i:s'),
                    'data_fim' => date('Y-m-d H:i:s'),
                ];
                $inserir = $this->db->insert('gv_pedido_viagem', $data_pedidos);
            }

            if (isset($custom_fields)) {
                handle_custom_fields_post($requestId, $custom_fields);
            }

            if (!empty($categoryData->approve_list)) {

                $this->load->model('emails_model');
                $decodeApproveList = json_decode($categoryData->approve_list);

                foreach ($decodeApproveList as $staff) {

                    $staffData = get_staff($staff);

                    $notified = add_notification([
                        'description' => 'approvify_new_request_from_staff',
                        'touserid' => $staff,
                        'fromcompany' => 1,
                        'fromuserid' => 0,
                        'link' => 'approvify/view_request/' . $requestId,
                        'additional_data' => serialize([
                            get_staff_full_name($staff),
                            $data['request_title'],
                        ]),
                    ]);

                    if ($notified) {
                        pusher_trigger_notification([$staff]);
                    }

                    $this->emails_model->send_simple_email(
                        $staffData->email,
                        get_option('companyname') . ' - New Staff Request',
                        '
                        Hello,
                        <br>
                        There is a new request from staff with title <strong>' . $data['request_title'] . '</strong> request by <strong>' . get_staff_full_name($data['requester_id']) . '</strong>.
                        <br>
                        <a href="' . admin_url('approvify/view_request/' . $requestId) . '/?review=true">Check Request Here</a>
                        <br>
                        Best regards,<br>
                        ' . get_option('companyname') . '
                        '
                    );
                }
            }

            $attachments = approvify_handle_request_attachments($requestId);
            if ($attachments) {
                $this->insertRequestFilesToDatabase($attachments, $requestId);
            }

            $_attachments = $this->getRequestAttachments($requestId);

            return $requestId;
        }

        return false;
    }

    public function getRequest($requestId)
    {
        $this->db->select(db_prefix() . 'approvify_requests.*, ' . db_prefix() . 'approvify_approval_categories.category_name, ' . db_prefix() . 'approvify_approval_categories.approve_list');
        $this->db->from(db_prefix() . 'approvify_requests');
        $this->db->join(db_prefix() . 'approvify_approval_categories', db_prefix() . 'approvify_approval_categories.id = ' . db_prefix() . 'approvify_requests.category_id', 'left');

        $this->db->where(db_prefix() . 'approvify_requests.id', $requestId);

        $request = $this->db->get()->row();
        if ($request) {
            $request->attachments = $this->getRequestAttachments($request->id);
        }

        return $request;
    }

    public function getRequestAttachments($id)
    {
        $this->db->where('request_id', $id);
        return $this->db->get('approvify_request_files')->result_array();
    }

    public function insertRequestFilesToDatabase($attachments, $requestId)
    {
        foreach ($attachments as $attachment) {
            $attachment['request_id'] = $requestId;
            $attachment['created_at'] = date('Y-m-d H:i:s');
            $attachment['filename'] = $attachment['file_name'];
            unset($attachment['file_name'], $attachment['filetype']);

            $this->db->insert(db_prefix() . 'approvify_request_files', $attachment);
        }
    }

    public function updateRequest($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'approvify_requests', $data);

        return $this->db->affected_rows() > 0;
    }

    public function addActivity($data)
    {
        $this->db->insert(db_prefix() . 'approvify_request_activity', $data);
        $insert_id = $this->db->insert_id();

        if ($insert_id) {
            return $insert_id;
        }

        return false;
    }

    public function getActivities($requestId)
    {
        $this->db->where('request_id', $requestId);
        return $this->db->get(db_prefix() . 'approvify_request_activity')->result_array();
    }

    public function addType($data)
    {
        $this->db->insert(db_prefix() . 'approvify_approval_categories', $data);
        $insert_id = $this->db->insert_id();

        if ($insert_id) {
            return $insert_id;
        }

        return false;
    }

    public function getType($id)
    {
        $this->db->where('id', $id);
        return $this->db->get(db_prefix() . 'approvify_approval_categories')->row();
    }

    public function getTypes()
    {
        $this->db->where('is_active', '1');
        return $this->db->get(db_prefix() . 'approvify_approval_categories')->result_array();
    }

    public function updateType($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'approvify_approval_categories', $data);

        return $this->db->affected_rows() > 0;
    }

    public function deleteType($id)
    {

        if (is_reference_in_table('category_id', db_prefix() . 'approvify_requests', $id)) {
            return [
                'referenced' => true,
            ];
        }

        $this->db->where('id', $id);
        $this->db->delete(db_prefix() . 'approvify_approval_categories');

        if ($this->db->affected_rows() > 0) {
            return true;
        }

        return false;
    }

    public function changeTypeStatus($id, $status)
    {
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'approvify_approval_categories', [
            'is_active' => $status,
        ]);

        if ($this->db->affected_rows() > 0) {
            return true;
        }

        return false;
    }

    public function getTotalCategories()
    {
        // Verifica se a tabela existe antes de executar a consulta
        if ($this->db->table_exists(db_prefix() . 'approvify_approval_categories')) {
            $this->db->from(db_prefix() . 'approvify_approval_categories');
            return $this->db->count_all_results();
        } else {
            return 0; // Retorna 0 se a tabela não existir
        }
    }
    public function getTotalRequests()
    {
        // Verifica se a tabela existe antes de executar a consulta
        if ($this->db->table_exists(db_prefix() . 'approvify_requests')) {
            $this->db->from(db_prefix() . 'approvify_requests');
            return $this->db->count_all_results();
        } else {
            return 0; // Retorna 0 se a tabela não existir
        }
    }
    public function getTotalRequestsByStatus($status = 0)
    {
        // Verifica se a tabela existe antes de executar a consulta
        if ($this->db->table_exists(db_prefix() . 'approvify_requests')) {
            $this->db->from(db_prefix() . 'approvify_requests');
            $this->db->where('status', $status); // Adiciona a condição de status
            return $this->db->count_all_results();
        } else {
            return 0; // Retorna 0 se a tabela não existir
        }
    }
    public function getTopCategoriesByRequests($limit = 5)
    {
        // Verifica se ambas as tabelas existem antes de executar a consulta
        if (
            $this->db->table_exists(db_prefix() . 'approvify_requests') &&
            $this->db->table_exists(db_prefix() . 'approvify_approval_categories')
        ) {
            $this->db->select('categories.category_name, COUNT(requests.id) as total_requests');
            $this->db->from(db_prefix() . 'approvify_requests as requests');
            $this->db->join(db_prefix() . 'approvify_approval_categories as categories', 'requests.category_id = categories.id', 'inner');
            $this->db->group_by('categories.id');
            $this->db->order_by('total_requests', 'DESC');
            $this->db->limit($limit);
            return $this->db->get()->result_array();
        } else {
            return []; // Retorna uma lista vazia se as tabelas não existirem
        }
    }
    public function requisicao_estado($estado = '0', $limit = 10) {
        $this->db->where('status', $estado);
        $this->db->limit($limit);
        return $this->db->get('approvify_requests')->result_array();
    }
}