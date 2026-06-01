<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Status extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Gv_status_model');
        $this->load->library('form_validation');
    }

    private function http_method ($vfMethod) {
        if ($_SERVER['REQUEST_METHOD'] !== $vfMethod) {
            header("HTTP/1.1 405 Method Not Allowed");
            echo json_encode(['status' => false, 'message' => 'Metodo não permitido']);
            exit;
        }
    }

    public function index()
    {
        $this->http_method('GET');
        echo json_encode([
            'status' => true,
            'dados' => $this->Gv_status_model->get()
        ]);
    }
    public function show($id)
    {
        $this->http_method('GET');
        echo json_encode([
            'status' => true,
            'dados' => $this->Gv_status_model->first($id)
        ]);
    }
    public function create () {
        $this->http_method('POST');
        // $data = json_decode(file_get_contents('php://input'), true);
        $data = [
            'status' => $this->input->post('status') ?? '',
        ];
        if ($data['status'] == '') {
            echo json_encode([
                'status' => false,
                'message' => 'Preencha o campo Status'
            ]);
            return;
        }
        $insert = $this->Gv_status_model->create($data);

        header("HTTP/1.1 201 CREATED");
        echo json_encode([
            'status' => true,
            'message' => 'Status criado com sucesso',
            'dados' => $insert
        ]);
    }
    public function update ($id) {
        $this->http_method('PUT');
        $data = $this->input->input_stream();

        $this->form_validation->set_data($data);
        $this->form_validation->set_rules('status', 'Status', 'required', ['required' => 'Preencha o campo Status']);

        if (!$this->form_validation->run()) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(['status' => false, 'erros' => validation_errors()]);
            exit;
        }
        $data_update = [
            'status' => $data['status'] ?? '',
        ];

        $update = $this->Gv_status_model->update($id, $data);

        echo json_encode([
            'status' => true,
            'message' => 'Status criado com sucesso',
            'dados' => $update,
        ]);
    }

    public function delete ($id) {
        $this->http_method('DELETE');

        $delete = $this->Gv_status_model->delete($id);

        echo json_encode([
            'status' => true,
            'message' => 'Status Eliminado com sucesso',
            'dados' => $delete,
        ]);
    }
}