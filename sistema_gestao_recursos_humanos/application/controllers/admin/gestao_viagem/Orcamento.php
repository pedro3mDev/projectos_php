<?php

use function Clue\StreamFilter\fun;

defined('BASEPATH') or exit('No direct script access allowed');

class Orcamento extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Gv_pedido_model');
        $this->load->model('Gv_orcamento_viagem_model');
        $this->load->library('form_validation');

    }

    private function http_method ($vfMethod) {
        if ($_SERVER['REQUEST_METHOD'] !== $vfMethod) {
            header("HTTP/1.1 405 Method Not Allowed");
            echo json_encode(['status' => false, 'message' => 'Metodo não permitido']);
            exit;
        }
    }

    public function total ($id_pedido) {
        $this->http_method('GET');
        $vfPedido = $this->Gv_pedido_model->first($id_pedido);

        echo json_encode([
            'status' => true,
            'message' => 'sucesso',
            'dados' => $this->Gv_equipa_model->total($vfPedido['id'])
        ]);
    }

    public function index()
    {
        $this->http_method('GET');

        echo json_encode([
            'status' => true,
            'message' => 'sucesso',
            'dados' => $this->Gv_orcamento_viagem_model->get()
        ]);
    }

    public function show($id)
    {
        $this->http_method('GET');

        echo json_encode([
            'status' => true,
            'dados' => $this->Gv_orcamento_viagem_model->first($id)
        ]);
    }

    public function geral ($id) {
        $this->http_method('GET');

        echo json_encode([
            'status' => true,
            'dados' => $this->Gv_orcamento_viagem_model->geral($id)
        ]);
    }

    public function create ($id_pedido) {
        $this->http_method('POST');
        $vfPedido = $this->Gv_pedido_model->first($id_pedido);

        $data = [
            'admin_id' => 1, // ID Admin Logado
            'orcamento_viagem_id' => $vfPedido['id'],
            'orcamento' => $this->input->post('orcamento') ?? '',
        ];
        $this->form_validation->set_rules('orcamento', 'Orçamento', 'required|numeric', ['required' => 'Preencha o campo {field}']);

        if (!$this->form_validation->run()) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(['status' => false, 'erros' => validation_errors()]);
            exit;
        }

        $insert = $this->Gv_orcamento_viagem_model->create($data);

        header("HTTP/1.1 201 CREATED");
        echo json_encode([
            'status' => true,
            'message' => 'Orçamento criado com sucesso',
            'dados' => $insert
        ]);
    }
    public function update ($id) {
        $this->http_method('PUT');
        $vfOracmento = $this->Gv_orcamento_viagem_model->first($id);

        $data_form = $this->input->input_stream();


        $this->form_validation->set_data($data_form);
        $this->form_validation->set_rules('orcamento', 'Orçamento', 'required|numeric', ['required' => 'Preencha o campo {field}']);
        $data['orcamento'] = $data_form['orcamento'];


        if (!$this->form_validation->run()) {
            header("HTTP/1.1 400 BAD REQUEST");
            echo json_encode(['status' => false, 'erros' => validation_errors()]);
            exit;
        }

        $insert = $this->Gv_orcamento_viagem_model->update($data, $vfOracmento['pedido_orcamento_id']);

        header("HTTP/1.1 200 SUCCESS");
        echo json_encode([
            'status' => true,
            'message' => 'Orçamento actualizado com sucesso',
            'dados' => $insert
        ]);
    }

    public function delete ($id) {
        $this->http_method('DELETE');
        $this->Gv_orcamento_viagem_model->first($id);

        echo 11111;
        return;

        $delete = $this->Gv_orcamento_viagem_model->delete($id);
        echo json_encode([
            'status' => true,
            'message' => 'Orçamento Removido com sucesso',
            'dados' => $delete,
        ]);
    }
}