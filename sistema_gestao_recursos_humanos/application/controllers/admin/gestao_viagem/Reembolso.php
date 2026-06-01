<?php

use function Clue\StreamFilter\fun;

defined('BASEPATH') or exit('No direct script access allowed');

class Reembolso extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Gv_orcamento_viagem_model');
        $this->load->model('Gv_reembolso_model');
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
            'message' => 'sucesso',
            'dados' => $this->Gv_reembolso_model->get()
        ]);
    }

    public function show($id)
    {
        $this->http_method('GET');

        echo json_encode([
            'status' => true,
            'dados' => $this->Gv_reembolso_model->first($id)
        ]);
    }

    public function create ($id) {
        $this->http_method('POST');
        $vfOrcamento = $this->Gv_orcamento_viagem_model->first($id);

        $data = [
            'admin_id' => 1, // ID Admin Logado
            'orcamento_viagem_id' => $vfOrcamento['id'],
            'reembolso' => $this->input->post('reembolso') ?? '',
        ];
        $this->form_validation->set_rules('reembolso', 'Reembolso', 'required|numeric', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(['status' => false, 'erros' => validation_errors()]);
            exit;
        }

        $insert = $this->Gv_reembolso_model->create($data);

        header("HTTP/1.1 201 CREATED");
        echo json_encode([
            'status' => true,
            'message' => 'Reembolso criado com sucesso',
            'dados' => $insert
        ]);
    }

    public function update ($id) {
        $this->http_method('PUT');
        $vfReembolso = $this->Gv_reembolso_model->first($id);

        $data_form = $this->input->input_stream();


        $this->form_validation->set_data($data_form);
        $this->form_validation->set_rules('reembolso', 'Reembolso', 'required|numeric', ['required' => 'Preencha o campo {field}']);
        $data['reembolso'] = $data_form['reembolso'];


        if (!$this->form_validation->run()) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(['status' => false, 'erros' => validation_errors()]);
            exit;
        }

        $insert = $this->Gv_reembolso_model->update($data, $vfReembolso['remmbolso_id']);

        header("HTTP/1.1 200 SUCCESS");
        echo json_encode([
            'status' => true,
            'message' => 'Reembolso actualizado com sucesso',
            'dados' => $insert
        ]);
    }

    public function delete ($id) {

        $this->http_method('DELETE');
        $this->Gv_reembolso_model->first($id);

        $delete = $this->Gv_reembolso_model->delete($id);
        echo json_encode([
            'status' => true,
            'message' => 'Reembolso Removido com sucesso',
            'dados' => $delete,
        ]);
    }
}